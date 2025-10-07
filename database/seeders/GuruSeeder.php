<?php

namespace Database\Seeders;

use App\Models\DataGuru;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class GuruSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $gurus = [
            [
                'name' => 'Guru Matematika',
                'email' => 'guru1@example.com',
                'username' => 'guru1',
                'nip' => '1234567890',
                'nama' => 'Ahmad Santoso',
                'no_hp' => '081234567890',
                'is_wali' => true,
            ],
            [
                'name' => 'Guru Bahasa Indonesia',
                'email' => 'guru2@example.com',
                'username' => 'guru2',
                'nip' => '1234567891',
                'nama' => 'Siti Nurhaliza',
                'no_hp' => '081234567891',
                'is_wali' => false,
            ],
        ];

        foreach ($gurus as $guruData) {
            $user = User::updateOrCreate([
                'email' => $guruData['email'],
            ], [
                'name' => $guruData['name'],
                'password' => Hash::make('password'),
                'username' => $guruData['username'],
                'role' => 'guru',
            ]);

            DataGuru::updateOrCreate([
                'user_id' => $user->id,
            ], [
                'nip' => $guruData['nip'],
                'nama' => $guruData['nama'],
                'no_hp' => $guruData['no_hp'],
                'is_wali' => $guruData['is_wali'],
            ]);
        }
    }
}
