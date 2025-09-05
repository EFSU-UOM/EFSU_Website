<?php

namespace App\Console\Commands;

use App\Enums\AccessLevel;
use App\Models\User;
use Illuminate\Console\Command;

class ChangeUserAccessLevel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:access {email} {level : Access level (0=Super Admin, 1=Admin, 10=Moderator, 100=User)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Change the access level of an existing user by email';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $accessLevel = (int) $this->argument('level');

        $validLevels = [0, 1, 10, 100];
        if (!in_array($accessLevel, $validLevels)) {
            $this->error('Invalid access level. Valid levels: 0 (Super Admin), 1 (Admin), 10 (Moderator), 100 (User)');
            return 1;
        }

        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email '{$email}' not found.");
            return 1;
        }

        $oldLevel = $user->access_level;
        $user->access_level = $accessLevel;
        $user->save();

        $newAccessLevelEnum = AccessLevel::from($accessLevel);
        $oldAccessLevelEnum = $oldLevel;
        
        $this->info("User '{$email}' access level changed from {$oldAccessLevelEnum->label()} to {$newAccessLevelEnum->label()}");
        
        return 0;
    }
}
