<?php

namespace Database\Seeders;

use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SiswaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $siswas = [
            [
                'name' => 'Siswa 1',
                'email' => 'siswa1@example.com',
                'username' => 'siswa1',
                'nis' => '001',
                'nama' => 'Ahmad Santoso',
                'no_hp_ortu' => '081234567890',
                'kelas_id' => null, // Belum ada kelas
            ],
            [
                'name' => 'Siswa 2',
                'email' => 'siswa2@example.com',
                'username' => 'siswa2',
                'nis' => '002',
                'nama' => 'Siti Nurhaliza',
                'no_hp_ortu' => '081234567891',
                'kelas_id' => null,
            ],
            [
                'name' => 'Siswa 3',
                'email' => 'siswa3@example.com',
                'username' => 'siswa3',
                'nis' => '003',
                'nama' => 'Budi Santoso',
                'no_hp_ortu' => '081234567892',
                'kelas_id' => null,
            ],
        ];

        foreach ($siswas as $siswaData) {
            $user = User::firstOrCreate([
                'email' => $siswaData['email'],
            ], [
                'name' => $siswaData['name'],
                'password' => Hash::make('password'),
                'username' => $siswaData['username'],
                'role' => 'siswa',
            ]);

            DataSiswa::firstOrCreate([
                'user_id' => $user->id,
            ], [
                'nama' => $siswaData['nama'],
                'nis' => $siswaData['nis'],
                'no_hp_ortu' => $siswaData['no_hp_ortu'],
                'kelas_id' => $siswaData['kelas_id'],
            ]);
        }
    }
}
