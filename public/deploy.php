<?php

/**
 * Deployment endpoint for the cPanel host, which has no SSH access for CI.
 *
 * GitHub Actions authenticates with a bearer token (DEPLOY_TOKEN in the server
 * .env), uploads the commit SHA it built plus zips of public/build and vendor/,
 * and this script moves the checkout to that commit and runs the Artisan steps.
 * Every step reports an exit code so the workflow can pass/fail accurately.
 *
 * The server has no composer, so vendor/ is shipped from the runner too. Both
 * archives arrive as chunks (action=chunk) sized to the host's upload limit, and
 * are reassembled and checksummed before the deployment itself starts.
 */

declare(strict_types=1);

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Foundation\Application;

const DEPLOY_MIN_TOKEN_LENGTH = 32;
const DEPLOY_MAX_OUTPUT = 8000;
const DEPLOY_MAX_CHUNKS = 200;
const DEPLOY_UPLOAD_TTL = 7200;

$root = dirname(__DIR__);
$steps = [];
$warnings = [];

header('Content-Type: application/json');
header('Cache-Control: no-store');

function deploy_respond(int $status, array $payload): never
{
    global $steps, $warnings;

    http_response_code($status);
    echo json_encode($payload + ['steps' => $steps, 'warnings' => $warnings], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
    exit;
}

function deploy_fail(int $status, string $message): never
{
    deploy_respond($status, ['ok' => false, 'error' => $message]);
}

function deploy_log(string $message): void
{
    global $root;

    $line = sprintf(
        "[%s] %s %s\n",
        gmdate('Y-m-d H:i:s'),
        $_SERVER['REMOTE_ADDR'] ?? '-',
        $message
    );

    @file_put_contents($root.'/storage/logs/deploy.log', $line, FILE_APPEND | LOCK_EX);
}

function deploy_env(string $file, string $key): ?string
{
    if (! is_readable($file)) {
        return null;
    }

    foreach (file($file, FILE_IGNORE_NEW_LINES) ?: [] as $line) {
        $line = trim($line);

        if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
            continue;
        }

        [$name, $value] = explode('=', $line, 2);

        if (trim($name) !== $key) {
            continue;
        }

        $value = trim($value);

        if (strlen($value) > 1 && ($value[0] === '"' || $value[0] === "'") && $value[-1] === $value[0]) {
            $value = substr($value, 1, -1);
        }

        return $value;
    }

    return null;
}

function deploy_bearer_token(): ?string
{
    $header = $_SERVER['HTTP_AUTHORIZATION'] ?? $_SERVER['REDIRECT_HTTP_AUTHORIZATION'] ?? null;

    if ($header === null && function_exists('getallheaders')) {
        foreach (getallheaders() as $name => $value) {
            if (strcasecmp($name, 'Authorization') === 0) {
                $header = $value;
                break;
            }
        }
    }

    if (! is_string($header) || ! preg_match('/^Bearer\s+(\S+)$/i', $header, $matches)) {
        return null;
    }

    return $matches[1];
}

function deploy_function_available(string $name): bool
{
    if (! function_exists($name)) {
        return false;
    }

    $disabled = array_map('trim', explode(',', (string) ini_get('disable_functions')));

    return ! in_array($name, $disabled, true);
}

function deploy_run(array $command, string $cwd): array
{
    $descriptors = [1 => ['pipe', 'w'], 2 => ['pipe', 'w']];
    $env = [
        'PATH' => getenv('PATH') ?: '/usr/local/bin:/usr/bin:/bin',
        'HOME' => getenv('HOME') ?: dirname($cwd),
        'GIT_TERMINAL_PROMPT' => '0',
        'LANG' => 'C',
    ];

    $process = proc_open($command, $descriptors, $pipes, $cwd, $env);

    if (! is_resource($process)) {
        return ['exit_code' => -1, 'output' => 'Failed to start: '.implode(' ', $command)];
    }

    $stdout = stream_get_contents($pipes[1]);
    $stderr = stream_get_contents($pipes[2]);
    fclose($pipes[1]);
    fclose($pipes[2]);

    return [
        'exit_code' => proc_close($process),
        'output' => trim($stdout."\n".$stderr),
    ];
}

function deploy_step(string $name, int $exitCode, string $output, float $startedAt): bool
{
    global $steps;

    $steps[] = [
        'name' => $name,
        'ok' => $exitCode === 0,
        'exit_code' => $exitCode,
        'output' => substr(trim($output), 0, DEPLOY_MAX_OUTPUT),
        'ms' => (int) round((microtime(true) - $startedAt) * 1000),
    ];

    return $exitCode === 0;
}

function deploy_rmdir(string $path): void
{
    if (! is_dir($path)) {
        return;
    }

    $items = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($path, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::CHILD_FIRST
    );

    foreach ($items as $item) {
        $item->isDir() && ! $item->isLink() ? rmdir($item->getPathname()) : unlink($item->getPathname());
    }

    rmdir($path);
}

function deploy_describe(string $path): string
{
    return round(filesize($path) / 1048576, 1).' MB verified';
}

function deploy_upload_dir(string $root, string $id): string
{
    return $root.'/storage/framework/deploy-uploads/'.$id;
}

function deploy_prune_uploads(string $root): void
{
    $base = $root.'/storage/framework/deploy-uploads';

    foreach (glob($base.'/*') ?: [] as $dir) {
        if (is_dir($dir) && filemtime($dir) < time() - DEPLOY_UPLOAD_TTL) {
            deploy_rmdir($dir);
        }
    }
}

/**
 * Concatenate the uploaded chunks back into a single zip and verify its checksum.
 */
function deploy_assemble(string $dir, int $parts, string $sha256): array
{
    if (! is_dir($dir)) {
        return [null, 'No chunks were received for this upload id.'];
    }

    $target = $dir.'/upload.zip';
    $out = fopen($target, 'wb');

    if ($out === false) {
        return [null, 'Could not open '.$target.' for writing.'];
    }

    for ($i = 0; $i < $parts; $i++) {
        $part = sprintf('%s/%03d.part', $dir, $i);

        if (! is_file($part)) {
            fclose($out);

            return [null, 'Chunk '.$i.' of '.$parts.' was never received.'];
        }

        $in = fopen($part, 'rb');
        stream_copy_to_stream($in, $out);
        fclose($in);
    }

    fclose($out);

    $actual = hash_file('sha256', $target);

    if (! hash_equals($sha256, $actual)) {
        return [null, 'Checksum mismatch: expected '.$sha256.', assembled '.$actual.'.'];
    }

    return [$target, null];
}

/**
 * Validate and reassemble a chunked upload described by <prefix>_id/_parts/_sha256.
 *
 * Returns [path, id, error]; a missing id yields [null, null, null] so optional
 * uploads can be told apart from broken ones.
 */
function deploy_take_upload(string $root, string $prefix): array
{
    $id = (string) ($_POST[$prefix.'_id'] ?? '');

    if ($id === '') {
        return [null, null, null];
    }

    $parts = filter_var($_POST[$prefix.'_parts'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 1, 'max_range' => DEPLOY_MAX_CHUNKS]]);
    $sha256 = (string) ($_POST[$prefix.'_sha256'] ?? '');

    if (! preg_match('/^[0-9a-f]{16,64}$/', $id) || ! preg_match('/^[0-9a-f]{64}$/', $sha256) || ! $parts) {
        return [null, $id, $prefix.'_id, '.$prefix.'_parts and '.$prefix.'_sha256 must all be valid.'];
    }

    [$path, $error] = deploy_assemble(deploy_upload_dir($root, $id), $parts, $sha256);

    return [$path, $id, $error];
}

/**
 * Extract a zip into a staging directory, rejecting anything that escapes it.
 */
function deploy_extract(string $zipPath, string $staging, string $requiredEntry): ?string
{
    deploy_rmdir($staging);

    $zip = new ZipArchive;

    if ($zip->open($zipPath) !== true) {
        return 'The archive could not be opened.';
    }

    $found = false;

    for ($i = 0; $i < $zip->numFiles; $i++) {
        $entry = (string) $zip->getNameIndex($i);
        $normalized = str_replace('\\', '/', $entry);

        if (str_starts_with($normalized, './')) {
            $normalized = substr($normalized, 2);
        }

        if (str_starts_with($normalized, '/') || in_array('..', explode('/', $normalized), true)) {
            $zip->close();

            return 'Rejected archive entry: '.$entry;
        }

        if ($normalized === $requiredEntry) {
            $found = true;
        }
    }

    if (! $found) {
        $zip->close();

        return 'The archive does not contain '.$requiredEntry.'.';
    }

    if (! $zip->extractTo($staging)) {
        $zip->close();
        deploy_rmdir($staging);

        return 'Extraction into '.basename($staging).' failed.';
    }

    $zip->close();

    return null;
}

/**
 * Move $staging into place as $live, keeping the replaced directory at $previous.
 */
function deploy_swap(string $live, string $staging, string $previous): ?string
{
    deploy_rmdir($previous);

    if (is_dir($live) && ! rename($live, $previous)) {
        deploy_rmdir($staging);

        return 'Could not move the existing '.basename($live).' aside.';
    }

    if (! rename($staging, $live)) {
        is_dir($previous) && rename($previous, $live);

        return 'Could not move the new '.basename($live).' into place.';
    }

    return null;
}

/*
|--------------------------------------------------------------------------
| Authentication
|--------------------------------------------------------------------------
*/

$expectedToken = deploy_env($root.'/.env', 'DEPLOY_TOKEN');

if ($expectedToken === null || strlen($expectedToken) < DEPLOY_MIN_TOKEN_LENGTH) {
    deploy_fail(500, 'DEPLOY_TOKEN is missing from the server .env or is shorter than '.DEPLOY_MIN_TOKEN_LENGTH.' characters.');
}

$providedToken = deploy_bearer_token();

if ($providedToken === null || ! hash_equals($expectedToken, $providedToken)) {
    deploy_log('unauthorized');
    usleep(500000);
    deploy_fail(401, 'Unauthorized.');
}

/*
|--------------------------------------------------------------------------
| Diagnostics
|--------------------------------------------------------------------------
*/

$method = $_SERVER['REQUEST_METHOD'] ?? 'GET';
$vendorMarker = $root.'/storage/framework/deployed-vendor.sha256';

if ($method === 'GET' && isset($_GET['status'])) {
    $git = deploy_function_available('proc_open')
        ? deploy_run(['git', 'rev-parse', 'HEAD'], $root)
        : ['exit_code' => -1, 'output' => 'proc_open unavailable'];

    deploy_respond(200, [
        'ok' => true,
        'head' => $git['exit_code'] === 0 ? $git['output'] : null,
        'git' => $git,
        'php_version' => PHP_VERSION,
        'proc_open' => deploy_function_available('proc_open'),
        'zip_archive' => class_exists('ZipArchive'),
        'composer_lock_sha256' => is_readable($root.'/composer.lock') ? hash_file('sha256', $root.'/composer.lock') : null,
        'vendor_lock_sha256' => is_readable($vendorMarker) ? trim((string) file_get_contents($vendorMarker)) : null,
        'upload_max_filesize' => ini_get('upload_max_filesize'),
        'post_max_size' => ini_get('post_max_size'),
        'bootstrap_cache_writable' => is_writable($root.'/bootstrap/cache'),
        'storage_writable' => is_writable($root.'/storage'),
    ]);
}

if ($method !== 'POST') {
    deploy_fail(405, 'Use POST to deploy, or GET ?status=1 for diagnostics.');
}

/*
|--------------------------------------------------------------------------
| Preconditions
|--------------------------------------------------------------------------
*/

@set_time_limit(0);
ignore_user_abort(true);

if (! deploy_function_available('proc_open')) {
    deploy_fail(500, 'proc_open() is disabled on this host, so git cannot be run.');
}

if (! class_exists('ZipArchive')) {
    deploy_fail(500, 'The zip extension is not available, so uploaded archives cannot be extracted.');
}

if (! is_dir($root.'/.git')) {
    deploy_fail(500, 'No .git directory at '.$root.'.');
}

deploy_prune_uploads($root);

/*
|--------------------------------------------------------------------------
| Chunked uploads
|--------------------------------------------------------------------------
*/

if (($_POST['action'] ?? '') === 'chunk') {
    $id = (string) ($_POST['id'] ?? '');
    $index = filter_var($_POST['index'] ?? null, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0, 'max_range' => DEPLOY_MAX_CHUNKS - 1]]);
    $chunk = $_FILES['chunk'] ?? null;

    if (! preg_match('/^[0-9a-f]{16,64}$/', $id)) {
        deploy_fail(422, 'A hexadecimal upload id is required.');
    }

    if ($index === false || $index === null) {
        deploy_fail(422, 'A chunk index between 0 and '.(DEPLOY_MAX_CHUNKS - 1).' is required.');
    }

    if (! is_array($chunk) || ($chunk['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK || ! is_uploaded_file($chunk['tmp_name'])) {
        deploy_fail(422, 'A "chunk" file upload is required; this host accepts at most '.ini_get('upload_max_filesize').' per chunk.');
    }

    $dir = deploy_upload_dir($root, $id);

    if (! is_dir($dir) && ! mkdir($dir, 0775, true)) {
        deploy_fail(500, 'Could not create the upload directory.');
    }

    $path = sprintf('%s/%03d.part', $dir, $index);

    if (! move_uploaded_file($chunk['tmp_name'], $path)) {
        deploy_fail(500, 'Could not store chunk '.$index.'.');
    }

    deploy_respond(200, ['ok' => true, 'id' => $id, 'index' => $index, 'bytes' => filesize($path)]);
}

/*
|--------------------------------------------------------------------------
| Deployment input
|--------------------------------------------------------------------------
*/

$lock = fopen($root.'/storage/framework/deploy.lock', 'c');

if ($lock === false || ! flock($lock, LOCK_EX | LOCK_NB)) {
    deploy_fail(409, 'Another deployment is already running.');
}

$commit = (string) ($_POST['commit'] ?? '');

if (! preg_match('/^[0-9a-f]{40}$/', $commit)) {
    deploy_fail(422, 'A 40-character commit SHA is required.');
}

$branch = deploy_env($root.'/.env', 'DEPLOY_BRANCH') ?: 'main';

$startedAt = microtime(true);
[$buildZip, $buildId, $error] = deploy_take_upload($root, 'build');

if ($buildZip === null && $error === null) {
    deploy_fail(422, 'A chunked build upload is required (build_id, build_parts, build_sha256).');
}

if (! deploy_step('assemble build upload', $error === null ? 0 : 1, $error ?? deploy_describe($buildZip), $startedAt)) {
    deploy_fail(500, 'The uploaded build archive is incomplete or corrupt.');
}

$startedAt = microtime(true);
[$vendorZip, $vendorId, $error] = deploy_take_upload($root, 'vendor');

if ($vendorId !== null && ! deploy_step('assemble vendor upload', $error === null ? 0 : 1, $error ?? deploy_describe($vendorZip), $startedAt)) {
    deploy_fail(500, 'The uploaded vendor archive is incomplete or corrupt.');
}

/*
|--------------------------------------------------------------------------
| Update the checkout
|--------------------------------------------------------------------------
*/

$lockHashBefore = is_readable($root.'/composer.lock') ? hash_file('sha256', $root.'/composer.lock') : null;

$startedAt = microtime(true);
$result = deploy_run(['git', 'fetch', '--prune', 'origin', $branch], $root);

if (! deploy_step('git fetch', $result['exit_code'], $result['output'], $startedAt)) {
    deploy_fail(500, 'git fetch failed.');
}

$startedAt = microtime(true);
$result = deploy_run(['git', 'reset', '--hard', $commit], $root);

if (! deploy_step('git reset --hard '.substr($commit, 0, 7), $result['exit_code'], $result['output'], $startedAt)) {
    deploy_fail(500, 'git reset failed. The commit may not exist on origin/'.$branch.'.');
}

$startedAt = microtime(true);
$result = deploy_run(['git', 'rev-parse', 'HEAD'], $root);
$head = $result['output'];

if (! deploy_step('verify HEAD', $head === $commit ? 0 : 1, 'HEAD is '.$head, $startedAt)) {
    deploy_fail(500, 'HEAD is '.$head.' but '.$commit.' was expected.');
}

$lockHashAfter = is_readable($root.'/composer.lock') ? hash_file('sha256', $root.'/composer.lock') : null;

if ($vendorZip === null && $lockHashBefore !== $lockHashAfter) {
    $warnings[] = 'composer.lock changed but no vendor archive was uploaded, so PHP dependencies were NOT updated.';
}

/*
|--------------------------------------------------------------------------
| Swap in vendor/ and the built assets
|--------------------------------------------------------------------------
*/

$vendorPrevious = $root.'/vendor.old';

if ($vendorZip !== null) {
    $startedAt = microtime(true);
    $error = deploy_extract($vendorZip, $root.'/vendor.new', 'autoload.php')
        ?? deploy_swap($root.'/vendor', $root.'/vendor.new', $vendorPrevious);

    deploy_rmdir(deploy_upload_dir($root, $vendorId));

    if (! deploy_step('install vendor', $error === null ? 0 : 1, $error ?? 'vendor/ replaced.', $startedAt)) {
        deploy_fail(500, 'Failed to install the uploaded vendor directory.');
    }
}

$startedAt = microtime(true);
$error = deploy_extract($buildZip, $root.'/public/build.new', 'manifest.json')
    ?? deploy_swap($root.'/public/build', $root.'/public/build.new', $root.'/public/build.old');

deploy_rmdir($root.'/public/build.old');
deploy_rmdir(deploy_upload_dir($root, $buildId));

if (! deploy_step('install build', $error === null ? 0 : 1, $error ?? 'public/build replaced.', $startedAt)) {
    deploy_fail(500, 'Failed to install the uploaded build artifact.');
}

if (function_exists('opcache_reset')) {
    opcache_reset();
}

/*
|--------------------------------------------------------------------------
| Artisan
|--------------------------------------------------------------------------
*/

$startedAt = microtime(true);

try {
    require $root.'/vendor/autoload.php';

    /** @var Application $app */
    $app = require $root.'/bootstrap/app.php';
    $kernel = $app->make(Kernel::class);
    $kernel->bootstrap();
} catch (Throwable $e) {
    // A bad vendor/ upload would otherwise leave the site unable to boot at all.
    if ($vendorZip !== null && is_dir($vendorPrevious)) {
        deploy_rmdir($root.'/vendor');
        rename($vendorPrevious, $root.'/vendor');
        $warnings[] = 'The previous vendor/ was restored.';
    }

    deploy_step('bootstrap laravel', 1, get_class($e).': '.$e->getMessage(), $startedAt);
    deploy_fail(500, 'Could not boot the application after updating the code.');
}

deploy_step('bootstrap laravel', 0, 'Booted.', $startedAt);
deploy_rmdir($vendorPrevious);

$commands = [
    ['config:clear', []],
    ['migrate', ['--force' => true]],
    ['config:cache', []],
    ['route:cache', []],
    ['view:cache', []],
    ['event:cache', []],
];

if (! file_exists($root.'/public/storage')) {
    array_splice($commands, 2, 0, [['storage:link', []]]);
}

foreach ($commands as [$name, $parameters]) {
    $startedAt = microtime(true);

    try {
        $exitCode = $kernel->call($name, $parameters);
        $output = $kernel->output();
    } catch (Throwable $e) {
        $exitCode = 1;
        $output = get_class($e).': '.$e->getMessage();
    }

    if (! deploy_step('artisan '.$name, $exitCode, $output, $startedAt)) {
        deploy_log('failed at artisan '.$name.' ('.substr($commit, 0, 7).')');
        deploy_fail(500, 'artisan '.$name.' failed.');
    }
}

if ($vendorZip !== null && $lockHashAfter !== null) {
    file_put_contents($vendorMarker, $lockHashAfter);
}

deploy_log('deployed '.substr($commit, 0, 7).($vendorZip === null ? '' : ' with vendor').($warnings === [] ? '' : ' with warnings'));

deploy_respond(200, ['ok' => true, 'commit' => $commit, 'vendor_installed' => $vendorZip !== null]);
