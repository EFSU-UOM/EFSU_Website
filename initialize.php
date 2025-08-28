<?php
if (false) {
    die('Access denied. Add ?force=1 to bypass IP check.');
}

function runCommand($command, $description) {
    echo "<div class='command-block'>";
    echo "<h3>$description</h3>";
    echo "<pre class='command'>$ $command</pre>";
    echo "<div class='output'>";
    
    ob_start();
    $output = [];
    $return_var = 0;
    
    exec($command . ' 2>&1', $output, $return_var);
    
    $result = implode("\n", $output);
    ob_end_clean();
    
    if ($return_var === 0) {
        echo "<span class='success'>✅ SUCCESS</span>\n";
    } else {
        echo "<span class='error'>❌ ERROR (Exit code: $return_var)</span>\n";
    }
    
    echo htmlspecialchars($result);
    echo "</div></div>";
    
    return $return_var === 0;
}

?>
<!DOCTYPE html>
<html>
<head>
    <title>Laravel Initialization</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; background: #f5f5f5; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 20px; border-radius: 8px; }
        .command-block { margin: 20px 0; padding: 15px; border: 1px solid #ddd; border-radius: 5px; background: #fafafa; }
        .command { background: #333; color: #fff; padding: 10px; border-radius: 3px; margin: 10px 0; }
        .output { background: #f8f8f8; padding: 10px; border-left: 4px solid #ccc; white-space: pre-wrap; font-family: monospace; }
        .success { color: green; font-weight: bold; }
        .error { color: red; font-weight: bold; }
        .btn { padding: 10px 20px; margin: 10px 5px; background: #007cba; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .btn:hover { background: #005a8b; }
        .danger { background: #dc3545; }
        .danger:hover { background: #c82333; }
        .warning { background: #ffc107; color: #000; }
        .info { background: #17a2b8; }
        h1 { color: #333; border-bottom: 2px solid #007cba; padding-bottom: 10px; }
        h2 { color: #555; margin-top: 30px; }
        .status { padding: 10px; margin: 10px 0; border-radius: 5px; }
        .status.success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .status.error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    </style>
</head>
<body>
    <div class="container">
        <h1>🚀 Laravel Application Initialization</h1>
        <p>Use these commands to initialize your Laravel application after deployment.</p>
        
        <?php if (isset($_POST['action'])): ?>
            <div class="status <?php echo (strpos($_POST['action'], 'error') === false) ? 'success' : 'error'; ?>">
                <strong>Executing: <?php echo htmlspecialchars($_POST['action']); ?></strong>
            </div>
            
            <?php
            switch ($_POST['action']) {
                case 'migrate':
                    runCommand('php artisan migrate --force', 'Run Database Migrations');
                    break;
                    
                case 'migrate_fresh':
                    runCommand('php artisan migrate:fresh --force', 'Fresh Migration (⚠️ Drops all tables)');
                    break;
                    
                case 'seed':
                    runCommand('php artisan db:seed --force', 'Run Database Seeders');
                    break;
                    
                case 'storage_link':
                    runCommand('php artisan storage:link', 'Create Storage Symbolic Link');
                    break;
                    
                case 'clear_cache':
                    $success = true;
                    $success &= runCommand('php artisan config:clear', 'Clear Config Cache');
                    $success &= runCommand('php artisan route:clear', 'Clear Route Cache');
                    $success &= runCommand('php artisan view:clear', 'Clear View Cache');
                    $success &= runCommand('php artisan cache:clear', 'Clear Application Cache');
                    break;
                    
                case 'optimize':
                    $success = true;
                    $success &= runCommand('php artisan config:cache', 'Cache Configuration');
                    $success &= runCommand('php artisan route:cache', 'Cache Routes');
                    $success &= runCommand('php artisan view:cache', 'Cache Views');
                    $success &= runCommand('php artisan optimize', 'Optimize Application');
                    break;
                    
                case 'permissions':
                    $success = true;
                    $success &= runCommand('chmod -R 755 storage', 'Set Storage Permissions');
                    $success &= runCommand('chmod -R 755 bootstrap/cache', 'Set Bootstrap Cache Permissions');
                    $success &= runCommand('chmod -R 755 public', 'Set Public Directory Permissions');
                    break;
                    
                case 'key_generate':
                    runCommand('php artisan key:generate --force', 'Generate Application Key');
                    break;
                    
                case 'queue_work':
                    runCommand('php artisan queue:work --daemon --timeout=60', 'Start Queue Worker (Background)');
                    break;
                    
                case 'check_status':
                    $success = true;
                    $success &= runCommand('php artisan --version', 'Laravel Version');
                    $success &= runCommand('php --version', 'PHP Version');
                    $success &= runCommand('ls -la', 'Directory Contents');
                    $success &= runCommand('php artisan config:show app.env', 'Current Environment');
                    break;
            }
            ?>
            
        <?php else: ?>
            
        <h2>🔧 Essential Setup Commands</h2>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="key_generate">
            <button type="submit" class="btn">Generate App Key</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="storage_link">
            <button type="submit" class="btn">Create Storage Link</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="permissions">
            <button type="submit" class="btn">Fix Permissions</button>
        </form>
        
        <h2>🗄️ Database Commands</h2>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="migrate">
            <button type="submit" class="btn">Run Migrations</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="seed">
            <button type="submit" class="btn">Run Seeders</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="migrate_fresh">
            <button type="submit" class="btn danger" onclick="return confirm('This will drop all tables! Are you sure?')">Fresh Migration</button>
        </form>
        
        <h2>⚡ Performance & Cache</h2>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="clear_cache">
            <button type="submit" class="btn warning">Clear All Cache</button>
        </form>
        name: Deploy Laravel to cPanel

on:
  push:
    branches: [ main, production ]
  workflow_dispatch: # Allows manual triggering

jobs:
  deploy:
    runs-on: ubuntu-latest
    
    steps:
    - name: Checkout code
      uses: actions/checkout@v4
      
    - name: Setup PHP
      uses: shivammathur/setup-php@v2
      with:
        php-version: '8.2'
        extensions: mbstring, xml, ctype, iconv, intl, pdo_pgsql, dom, filter, gd, iconv, json, mbstring, pdo
        
    - name: Setup Node.js
      uses: actions/setup-node@v4
      with:
        node-version: '20'
        cache: 'npm'
        
    - name: Cache Composer packages
      uses: actions/cache@v3
      with:
        path: vendor
        key: ${{ runner.os }}-php-${{ hashFiles('**/composer.lock') }}
        restore-keys: |
          ${{ runner.os }}-php-
          
    - name: Install Composer dependencies
      run: composer install --optimize-autoloader --no-dev --no-interaction
      
    - name: Install npm dependencies
      run: npm ci
      
    - name: Build frontend assets
      run: npm run build
      
    - name: Create production .env file
      run: |
        # Create production .env file
        cat > .env << EOF
        APP_NAME="Engineering Faculty Students' Union - University of Moratuwa"
        APP_ENV=production
        APP_KEY=${{ secrets.APP_KEY }}
        APP_DEBUG=false
        APP_URL=${{ secrets.APP_URL }}
        
        APP_LOCALE=en
        APP_FALLBACK_LOCALE=en
        APP_FAKER_LOCALE=en_US
        
        APP_MAINTENANCE_DRIVER=file
        
        PHP_CLI_SERVER_WORKERS=4
        
        BCRYPT_ROUNDS=12
        
        LOG_CHANNEL=stack
        LOG_STACK=single
        LOG_DEPRECATIONS_CHANNEL=null
        LOG_LEVEL=debug
        
        DB_CONNECTION=mysql
        DB_HOST=${{ secrets.DB_HOST }}
        DB_PORT=${{ secrets.DB_PORT }}
        DB_DATABASE=${{ secrets.DB_DB }}
        DB_USERNAME=${{ secrets.DB_USER }}
        DB_PASSWORD=${{ secrets.DB_PASSWORD }}
        
        SESSION_DRIVER=database
        SESSION_LIFETIME=120
        SESSION_ENCRYPT=false
        SESSION_PATH=/
        SESSION_DOMAIN=null
        
        BROADCAST_CONNECTION=log
        FILESYSTEM_DISK=local
        QUEUE_CONNECTION=database
        
        CACHE_STORE=database
        
        MEMCACHED_HOST=127.0.0.1
        
        REDIS_CLIENT=phpredis
        REDIS_HOST=127.0.0.1
        REDIS_PASSWORD=null
        REDIS_PORT=6379
        
        MAIL_MAILER=${{ secrets.MAIL_MAILER || 'log' }}
        MAIL_SCHEME=null
        MAIL_HOST=${{ secrets.MAIL_HOST || '127.0.0.1' }}
        MAIL_PORT=${{ secrets.MAIL_PORT || '2525' }}
        MAIL_USERNAME=${{ secrets.MAIL_USERNAME || 'null' }}
        MAIL_PASSWORD=${{ secrets.MAIL_PASSWORD || 'null' }}
        MAIL_FROM_ADDRESS="${{ secrets.MAIL_FROM_ADDRESS || 'hello@example.com' }}"
        MAIL_FROM_NAME="Laravel"
        
        AWS_ACCESS_KEY_ID=
        AWS_SECRET_ACCESS_KEY=
        AWS_DEFAULT_REGION=us-east-1
        AWS_BUCKET=
        AWS_USE_PATH_STYLE_ENDPOINT=false

        VITE_APP_NAME="Engineering Faculty Students' Union - University of Moratuwa"
        EOF
      
    - name: Run Laravel optimization commands
      run: |
        # Generate application key if not set
        php artisan key:generate --force
        
        # Clear any existing cached files
        php artisan config:clear
        php artisan route:clear
        php artisan view:clear
        php artisan cache:clear
        
        # Run Laravel optimization commands for production
        php artisan config:cache
        php artisan route:cache
        php artisan view:cache
        php artisan optimize
        
        # Set proper file permissions for deployment
        find . -type f -exec chmod 644 {} \; 2>/dev/null || true
        find . -type d -exec chmod 755 {} \; 2>/dev/null || true
        chmod -R 755 storage
        chmod -R 755 bootstrap/cache
        chmod -R 755 public
      
    - name: Deploy entire Laravel app to FTP root
      uses: SamKirkland/FTP-Deploy-Action@v4.3.4
      with:
        server: ${{ secrets.FTP_SERVER }}
        username: ${{ secrets.FTP_USERNAME }}
        password: ${{ secrets.FTP_PASSWORD }}
        local-dir: ./
        server-dir: /
        exclude: |
          **/.git*
          **/.git*/**
          **/node_modules/**
          **/tests/**
          **/.github/**
          **/.env.example
          **/README.md
          
    - name: Notify deployment status
      if: always()
      run: |
        if [ ${{ job.status }} == 'success' ]; then
          echo "✅ Deployment successful!"
          echo "Laravel app deployed to FTP root with public directory as web root"
        else
          echo "❌ Deployment failed!"
        fi

        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="optimize">
            <button type="submit" class="btn">Optimize App</button>
        </form>
        
        <h2>📊 System Status</h2>
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="check_status">
            <button type="submit" class="btn info">Check Status</button>
        </form>
        
        <form method="POST" style="display: inline;">
            <input type="hidden" name="action" value="queue_work">
            <button type="submit" class="btn">Start Queue Worker</button>
        </form>
        
        <h2>⚠️ Important Notes</h2>
        <ul>
            <li>Run "Generate App Key" first if .env doesn't have APP_KEY set</li>
            <li>Run "Fix Permissions" if you get file permission errors</li>
            <li>Run "Create Storage Link" to enable file uploads</li>
            <li>Use "Fresh Migration" only on first setup or when you want to reset data</li>
            <li>Run "Optimize App" after any configuration changes</li>
            <li><strong>Delete this file after initialization for security!</strong></li>
        </ul>
        
        <?php endif; ?>
        
        <hr style="margin: 30px 0;">
        <p style="color: #666; font-size: 0.9em;">
            📁 Current directory: <?php echo htmlspecialchars(getcwd()); ?><br>
            🌍 Server: <?php echo htmlspecialchars($_SERVER['HTTP_HOST']); ?><br>
            ⏰ Time: <?php echo date('Y-m-d H:i:s'); ?>
        </p>
    </div>
</body>
</html>