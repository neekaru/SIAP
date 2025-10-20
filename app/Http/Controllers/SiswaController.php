<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\User;

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
        $users = User::where('role', 'siswa')->get();
        $kelas = DataKelas::all();

        return view('admin.form-siswa', [
            'users' => $users,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreSiswaRequest $request)
    {
        DataSiswa::create($request->validated());

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
        $users = User::where('role', 'siswa')->get();
        $kelas = DataKelas::all();

        return view('admin.form-siswa', [
            'siswa' => $dataSiswa,
            'users' => $users,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSiswaRequest $request, DataSiswa $dataSiswa)
    {
        $dataSiswa->update($request->validated());

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
