<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiswaRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $nisUnique = 'unique:data_siswa,nis';
        $siswa = $this->route('data_siswa');
        if ($siswa && is_object($siswa)) {
            $nisUnique .= ','.$siswa->id;
        }

        $emailUnique = 'unique:users,email';
        $usernameUnique = 'unique:users,username';

        if ($siswa && is_object($siswa)) {
            $emailUnique .= ','.$siswa->user_id;
            $usernameUnique .= ','.$siswa->user_id;
        }

        return [
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', $emailUnique],
            'username' => ['required', 'string', 'max:255', $usernameUnique],
            'password' => $this->isMethod('post') ? ['required', 'string', 'min:8'] : ['nullable'],
            'nama' => ['required', 'string', 'max:255'],
            'nis' => ['required', 'string', 'max:255', $nisUnique],
            'kelas_id' => ['nullable', 'integer', 'exists:data_kelas,id'],
            'no_hp_ortu' => ['nullable', 'string', 'max:20'],
        ];
    }

    public function messages(): array
    {
        return [
            'user_name.required' => 'Nama pengguna wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Email harus format yang valid',
            'email.unique' => 'Email sudah terdaftar',
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah terdaftar',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'nama.required' => 'Nama siswa wajib diisi',
            'nis.required' => 'NIS wajib diisi',
            'nis.unique' => 'NIS sudah terdaftar',
            'kelas_id.exists' => 'Kelas tidak ditemukan',
            'no_hp_ortu.max' => 'Nomor HP maksimal 20 karakter',
        ];
    }
}
