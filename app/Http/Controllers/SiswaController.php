<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $siswa = DataSiswa::with('user', 'kelas')->get();

        return view('admin.siswa', ['siswa' => $siswa]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kelas = DataKelas::all();

        return view('admin.form-siswa', [
            'kelas' => $kelas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaRequest $request)
    {
        // Create user
        $user = User::create([
            'name' => $request->user_name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Create siswa
        DataSiswa::create([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'user_id' => $user->id,
            'kelas_id' => $request->kelas_id,
            'no_hp_ortu' => $request->no_hp_ortu,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataSiswa $dataSiswa)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataSiswa $dataSiswa)
    {
        $kelas = DataKelas::all();

        return view('admin.form-siswa', [
            'siswa' => $dataSiswa,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSiswaRequest $request, DataSiswa $dataSiswa)
    {
        // Update user
        $dataSiswa->user->update([
            'name' => $request->user_name,
            'email' => $request->email,
            'username' => $request->username,
        ]);

        // Update siswa
        $dataSiswa->update([
            'nama' => $request->nama,
            'nis' => $request->nis,
            'kelas_id' => $request->kelas_id,
            'no_hp_ortu' => $request->no_hp_ortu,
        ]);

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataSiswa $dataSiswa)
    {
        $dataSiswa->delete();

        return redirect()->route('siswa.index')->with('success', 'Siswa berhasil dihapus');
    }
}
