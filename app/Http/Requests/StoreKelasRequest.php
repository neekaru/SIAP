<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKelasRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $kodeUnique = 'unique:data_kelas,kode';
        $kelas = $this->route('kelas');
        if ($kelas && is_object($kelas)) {
            $kodeUnique .= ','.$kelas->id;
        }

        return [
            'kode' => ['required', 'string', 'max:10', $kodeUnique],
            'nama' => ['required', 'string', 'max:255'],
            'walikelas_id' => ['required', 'integer', 'exists:data_guru,id'],
        ];
    }

    public function messages(): array
    {
        return [
            'kode.required' => 'Kode kelas wajib diisi',
            'kode.unique' => 'Kode kelas sudah terdaftar',
            'kode.max' => 'Kode kelas maksimal 10 karakter',
            'nama.required' => 'Nama kelas wajib diisi',
            'nama.max' => 'Nama kelas maksimal 255 karakter',
            'walikelas_id.required' => 'Wali kelas wajib dipilih',
            'walikelas_id.exists' => 'Wali kelas tidak ditemukan',
        ];
    }
}
