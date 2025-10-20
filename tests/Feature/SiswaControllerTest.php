<?php

namespace Tests\Feature;

use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SiswaControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_all_siswa(): void
    {
        $siswa = DataSiswa::factory()->count(3)->create();

        $response = $this->get(route('siswa.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.siswa');
        $response->assertViewHas('siswa');
    }

    public function test_create_shows_form(): void
    {
        $response = $this->get(route('siswa.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.form-siswa');
        $response->assertViewHas('kelas');
    }

    public function test_store_creates_new_siswa(): void
    {
        $kelas = DataKelas::factory()->create();

        $data = [
            'user_name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'username' => 'johndoe',
            'password' => 'password123',
            'nama' => 'John Doe',
            'nis' => '12345678',
            'kelas_id' => $kelas->id,
            'no_hp_ortu' => '081234567890',
        ];

        $response = $this->post(route('siswa.store'), $data);

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'John Doe',
            'email' => 'john.doe@example.com',
            'username' => 'johndoe',
        ]);
        $this->assertDatabaseHas('data_siswa', [
            'nama' => 'John Doe',
            'nis' => '12345678',
        ]);
    }

    public function test_store_fails_with_duplicate_nis(): void
    {
        $siswa = DataSiswa::factory()->create();

        $data = [
            'user_name' => 'Jane Doe',
            'email' => 'jane.doe@example.com',
            'username' => 'janedoe',
            'password' => 'password123',
            'nama' => 'Jane Doe',
            'nis' => $siswa->nis,
            'kelas_id' => $siswa->kelas_id,
            'no_hp_ortu' => '081234567891',
        ];

        $response = $this->post(route('siswa.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseMissing('data_siswa', ['nama' => 'Jane Doe']);
    }

    public function test_edit_shows_form(): void
    {
        $siswa = DataSiswa::factory()->create();

        $response = $this->get(route('siswa.edit', $siswa->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.form-siswa');
        $response->assertViewHas('siswa', $siswa);
    }

    public function test_update_modifies_siswa(): void
    {
        $siswa = DataSiswa::factory()->create();

        $data = [
            'user_name' => 'Updated Name',
            'email' => 'updated@example.com',
            'username' => 'updateduser',
            'nama' => 'Updated Name',
            'nis' => $siswa->nis,
            'kelas_id' => $siswa->kelas_id,
            'no_hp_ortu' => '089876543210',
        ];

        $response = $this->put(route('siswa.update', $siswa->id), $data);

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('data_siswa', [
            'id' => $siswa->id,
            'nama' => 'Updated Name',
        ]);
        $this->assertDatabaseHas('users', [
            'id' => $siswa->user_id,
            'name' => 'Updated Name',
            'email' => 'updated@example.com',
            'username' => 'updateduser',
        ]);
    }

    public function test_update_does_not_modify_user_data_when_values_unchanged(): void
    {
        $user = User::factory()->create([
            'username' => 'testsiswa',
            'name' => 'Test Siswa',
            'email' => 'test@siswa.sch.id',
        ]);

        $siswa = DataSiswa::factory()->create([
            'nama' => 'Test Siswa',
            'user_id' => $user->id,
        ]);

        $originalUserData = $user->toArray();

        $data = [
            'user_name' => $user->name, // Same value
            'email' => $user->email, // Same value
            'username' => $user->username, // Same value
            'nama' => 'Test Siswa Updated', // Changed
            'nis' => $siswa->nis, // Same
            'kelas_id' => $siswa->kelas_id, // Same
            'no_hp_ortu' => '081234567891', // Changed
        ];

        $response = $this->put(route('siswa.update', $siswa->id), $data);

        $response->assertRedirect(route('siswa.index'));

        // Siswa data should be updated
        $this->assertDatabaseHas('data_siswa', [
            'id' => $siswa->id,
            'nama' => 'Test Siswa Updated',
            'no_hp_ortu' => '081234567891',
        ]);

        // User data should remain unchanged
        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'name' => $originalUserData['name'],
            'email' => $originalUserData['email'],
            'username' => $originalUserData['username'],
        ]);
    }

    public function test_destroy_deletes_siswa(): void
    {
        $siswa = DataSiswa::factory()->create();
        $siswaId = $siswa->id;

        $response = $this->delete(route('siswa.destroy', $siswaId));

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseMissing('data_siswa', ['id' => $siswaId]);
    }
}
