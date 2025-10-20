<?php

namespace Tests\Feature;

use App\Models\DataGuru;
use App\Models\DataKelas;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class KelasControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_all_kelas(): void
    {
        DataKelas::factory()->count(3)->create();

        $response = $this->get(route('kelas.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.kelas');
        $response->assertViewHas('kelas');
    }

    public function test_create_shows_form(): void
    {
        $response = $this->get(route('kelas.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.form-kelas');
        $response->assertViewHas('guru');
    }

    public function test_store_creates_new_kelas(): void
    {
        $guru = DataGuru::factory()->create(['is_wali' => true]);

        $data = [
            'kode' => 'X-A',
            'nama' => 'Kelas X-A',
            'walikelas_id' => $guru->id,
        ];

        $response = $this->post(route('kelas.store'), $data);

        $response->assertRedirect(route('kelas.index'));
        $this->assertDatabaseHas('data_kelas', $data);
    }

    public function test_store_fails_with_duplicate_kode(): void
    {
        $guru = DataGuru::factory()->create(['is_wali' => true]);
        DataKelas::factory()->create(['kode' => 'X-A']);

        $data = [
            'kode' => 'X-A',
            'nama' => 'Kelas X-A Duplicate',
            'walikelas_id' => $guru->id,
        ];

        $response = $this->post(route('kelas.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseMissing('data_kelas', ['nama' => 'Kelas X-A Duplicate']);
    }

    public function test_edit_shows_form(): void
    {
        $kelas = DataKelas::factory()->create();

        $response = $this->get(route('kelas.edit', $kelas->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.form-kelas');
        $response->assertViewHas('kelas', $kelas);
        $response->assertViewHas('guru');
    }

    public function test_update_modifies_kelas(): void
    {
        $kelas = DataKelas::factory()->create([
            'nama' => 'Kelas XI-A',
        ]);
        $guru = DataGuru::factory()->create(['is_wali' => true]);

        $data = [
            'kode' => 'XI-B',
            'nama' => 'Kelas XI-B Updated',
            'walikelas_id' => $guru->id,
        ];

        $response = $this->put(route('kelas.update', $kelas->id), $data);

        $response->assertRedirect(route('kelas.index'));
        $this->assertDatabaseHas('data_kelas', [
            'id' => $kelas->id,
            'nama' => 'Kelas XI-B Updated',
        ]);
    }

    public function test_destroy_deletes_kelas(): void
    {
        $kelas = DataKelas::factory()->create([
            'nama' => 'Kelas XII-A',
        ]);
        $kelasId = $kelas->id;

        $response = $this->delete(route('kelas.destroy', $kelasId));

        $response->assertRedirect(route('kelas.index'));
        $this->assertDatabaseMissing('data_kelas', ['id' => $kelasId]);
    }
}
