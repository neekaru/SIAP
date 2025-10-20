<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreGuruRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $nipUnique = 'unique:data_guru,nip';
        $guru = $this->route('guru');
        if ($guru && is_object($guru)) {
            $nipUnique .= ','.$guru->id;
        }

        $emailUnique = 'unique:users,email';
        $usernameUnique = 'unique:users,username';

        if ($guru && is_object($guru)) {
            $emailUnique .= ','.$guru->user_id;
            $usernameUnique .= ','.$guru->user_id;
        }

        return [
            'user_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', $emailUnique],
            'username' => ['required', 'string', 'max:255', $usernameUnique],
            'password' => $this->isMethod('post') ? ['required', 'string', 'min:8'] : ['nullable'],
            'nip' => ['required', 'string', 'max:20', $nipUnique],
            'nama' => ['required', 'string', 'max:255'],
            'no_hp' => ['nullable', 'string', 'max:20'],
            'is_wali' => ['boolean'],
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
            'nip.required' => 'NIP wajib diisi',
            'nip.unique' => 'NIP sudah terdaftar',
            'nip.max' => 'NIP maksimal 20 karakter',
            'nama.required' => 'Nama guru wajib diisi',
            'nama.max' => 'Nama guru maksimal 255 karakter',
            'no_hp.max' => 'Nomor HP maksimal 20 karakter',
            'is_wali.boolean' => 'Status wali kelas harus benar atau salah',
        ];
    }
}
