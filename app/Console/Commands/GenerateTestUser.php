<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GenerateTestUser extends Command
{
    protected $signature = 'app:generate-test-user';

    protected $description = 'Generate a test user';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Select user role:');
        $this->info('1. User');
        $this->info('2. Admin');
        $role = $this->choice('Role', ['user', 'admin'], 0);

        $name = $this->ask('Enter name');
        $email = $this->ask('Enter email');
        $password = $this->secret('Enter password');

        $user = User::create([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
            'role' => $role,
        ]);

        $token = $user->createToken('TestToken')->plainTextToken;

        $this->info("User created successfully. Token: {$token}");
    }
}
