<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class CreateAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:create {email} {name} {password}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin account from the given email, name, and password. Provide the email, name, and password as arguments (in that order).';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        User::create([
            'email' => $this->argument('email'),
            'name' => $this->argument('name'),
            'password' => Hash::make($this->argument('password')),
            'role' => 'admin',
        ]);
        
        $this->info('Admin user created successfully!');
    }
}
