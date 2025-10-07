<?php

namespace Database\Seeders;

use App\Models\DataAdmin;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::firstOrCreate([
            'email' => 'admin@example.com',
        ], [
            'name' => 'Admin',
            'password' => Hash::make('password'),
            'username' => 'admin',
            'role' => 'admin',
        ]);

        DataAdmin::firstOrCreate([
            'user_id' => $user->id,
        ], [
            'nama' => 'Administrator',
        ]);
    }
}
