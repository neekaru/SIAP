<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $nisUnique = 'unique:data_siswa,nis';
        $siswa = $this->route('siswa');
        if ($siswa && is_object($siswa)) {
            $nisUnique .= ','.$siswa->id;
        }

        return [
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:255', $nisUnique],
            'user_id' => ['required', 'integer', 'exists:users,id'],
            'kelas_id' => ['nullable', 'integer', 'exists:data_kelas,id'],
            'no_hp_ortu' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'nama.required' => 'Nama siswa wajib diisi',
            'nama.string' => 'Nama siswa harus berupa teks',
            'nama.max' => 'Nama siswa maksimal 255 karakter',
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'user_id.required' => 'Akun pengguna wajib dipilih',
            'user_id.exists' => 'Akun pengguna tidak ditemukan',
            'kelas_id.exists' => 'Kelas tidak ditemukan',
            'no_hp_ortu.max' => 'Nomor HP maksimal 20 karakter',
        ];
    }
}
