<?php

namespace Tests\Feature;

use App\Models\DataGuru;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GuruControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_index_shows_all_guru(): void
    {
        DataGuru::factory()->count(3)->create();

        $response = $this->get(route('guru.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.guru');
        $response->assertViewHas('guru');
    }

    public function test_create_shows_form(): void
    {
        $response = $this->get(route('guru.create'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.form-guru');
    }

    public function test_store_creates_new_guru(): void
    {
        $userData = [
            'user_name' => 'Ahmad Hidayat',
            'email' => 'ahmad.hidayat@guru.sch.id',
            'username' => 'ahmad.hidayat',
            'password' => 'password123',
        ];

        $guruData = [
            'nip' => '12345678',
            'nama' => 'Ahmad Hidayat',
            'no_hp' => '081234567890',
            'is_wali' => true,
        ];

        $data = array_merge($userData, $guruData);

        $response = $this->post(route('guru.store'), $data);

        $response->assertRedirect(route('guru.index'));
        $this->assertDatabaseHas('users', [
            'name' => 'Ahmad Hidayat',
            'email' => 'ahmad.hidayat@guru.sch.id',
            'username' => 'ahmad.hidayat',
        ]);
        $this->assertDatabaseHas('data_guru', [
            'nip' => '12345678',
            'nama' => 'Ahmad Hidayat',
            'is_wali' => true,
        ]);
    }

    public function test_store_fails_with_duplicate_nip(): void
    {
        DataGuru::factory()->create(['nip' => '12345678']);

        $data = [
            'user_name' => 'Budi Santoso',
            'email' => 'budi.santoso@guru.sch.id',
            'username' => 'budi.santoso',
            'password' => 'password123',
            'nip' => '12345678',
            'nama' => 'Budi Santoso',
            'no_hp' => '081234567891',
            'is_wali' => false,
        ];

        $response = $this->post(route('guru.store'), $data);

        $response->assertRedirect();
        $this->assertDatabaseMissing('data_guru', ['nama' => 'Budi Santoso']);
    }

    public function test_edit_shows_form(): void
    {
        $guru = DataGuru::factory()->create();

        $response = $this->get(route('guru.edit', $guru->id));

        $response->assertStatus(200);
        $response->assertViewIs('admin.form-guru');
        $response->assertViewHas('guru', $guru);
    }

    public function test_update_modifies_guru(): void
    {
        $guru = DataGuru::factory()->create([
            'nama' => 'Ahmad Hidayat',
        ]);

        $data = [
            'user_name' => 'Ahmad Hidayat Updated',
            'email' => 'ahmad.updated@guru.sch.id',
            'username' => 'ahmad.updated',
            'nip' => '87654321',
            'nama' => 'Ahmad Hidayat Updated',
            'no_hp' => '081234567891',
            'is_wali' => false,
        ];

        $response = $this->put(route('guru.update', $guru->id), $data);

        $response->assertRedirect(route('guru.index'));
        $this->assertDatabaseHas('data_guru', [
            'id' => $guru->id,
            'nama' => 'Ahmad Hidayat Updated',
            'nip' => '87654321',
            'is_wali' => false,
        ]);
    }

    public function test_destroy_deletes_guru(): void
    {
        $guru = DataGuru::factory()->create([
            'nama' => 'Guru Test',
        ]);
        $guruId = $guru->id;

        $response = $this->delete(route('guru.destroy', $guruId));

        $response->assertRedirect(route('guru.index'));
        $this->assertDatabaseMissing('data_guru', ['id' => $guruId]);
    }
}
