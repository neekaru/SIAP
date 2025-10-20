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
        $response->assertViewHas('users');
        $response->assertViewHas('kelas');
    }

    public function test_store_creates_new_siswa(): void
    {
        $user = User::factory()->create();
        $kelas = DataKelas::factory()->create();

        $data = [
            'nama' => 'John Doe',
            'nis' => '12345678',
            'user_id' => $user->id,
            'kelas_id' => $kelas->id,
            'no_hp_ortu' => '081234567890',
        ];

        $response = $this->post(route('siswa.store'), $data);

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('data_siswa', [
            'nama' => 'John Doe',
            'nis' => '12345678',
        ]);
    }

    public function test_store_fails_with_duplicate_nis(): void
    {
        $siswa = DataSiswa::factory()->create();
        $user = User::factory()->create();

        $data = [
            'nama' => 'Jane Doe',
            'nis' => $siswa->nis,
            'user_id' => $user->id,
        ];

        $response = $this->post(route('siswa.store'), $data);

        $response->assertSessionHasErrors('nis');
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
            'nama' => 'Updated Name',
            'nis' => $siswa->nis,
            'user_id' => $siswa->user_id,
            'kelas_id' => $siswa->kelas_id,
            'no_hp_ortu' => '089876543210',
        ];

        $response = $this->put(route('siswa.update', $siswa->id), $data);

        $response->assertRedirect(route('siswa.index'));
        $this->assertDatabaseHas('data_siswa', [
            'id' => $siswa->id,
            'nama' => 'Updated Name',
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
