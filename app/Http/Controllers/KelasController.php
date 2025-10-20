<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreKelasRequest;
use App\Models\DataGuru;
use App\Models\DataKelas;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kelas = DataKelas::with('walikelas')->get();

        return view('admin.kelas', ['kelas' => $kelas]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $guru = DataGuru::where('is_wali', true)->get();

        return view('admin.form-kelas', [
            'guru' => $guru,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreKelasRequest $request)
    {
        DataKelas::create($request->validated());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataKelas $kelas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataKelas $kelas)
    {
        $guru = DataGuru::where('is_wali', true)->get();

        return view('admin.form-kelas', [
            'kelas' => $kelas,
            'guru' => $guru,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreKelasRequest $request, DataKelas $kelas)
    {
        $kelas->update($request->validated());

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataKelas $kelas)
    {
        $kelas->delete();

        return redirect()->route('kelas.index')->with('success', 'Kelas berhasil dihapus');
    }
}
