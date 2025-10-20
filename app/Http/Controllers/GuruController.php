<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGuruRequest;
use App\Models\DataGuru;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuruController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $guru = DataGuru::with('user')->get();

        return view('admin.guru', ['guru' => $guru]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.form-guru');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreGuruRequest $request)
    {
        // Create user
        $user = User::create([
            'name' => $request->user_name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'guru',
        ]);

        // Create guru
        DataGuru::create([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'user_id' => $user->id,
            'is_wali' => $request->boolean('is_wali', false),
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(DataGuru $guru)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(DataGuru $guru)
    {
        return view('admin.form-guru', [
            'guru' => $guru,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreGuruRequest $request, DataGuru $guru)
    {
        // Only update user data if values have changed
        $userData = [];
        if ($request->user_name !== $guru->user->name) {
            $userData['name'] = $request->user_name;
        }
        if ($request->email !== $guru->user->email) {
            $userData['email'] = $request->email;
        }
        if ($request->username !== $guru->user->username) {
            $userData['username'] = $request->username;
        }

        // Update user only if there are changes
        if (! empty($userData)) {
            $guru->user->update($userData);
        }

        // Update guru
        $guru->update([
            'nip' => $request->nip,
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'is_wali' => $request->boolean('is_wali', false),
        ]);

        return redirect()->route('guru.index')->with('success', 'Guru berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(DataGuru $guru)
    {
        $guru->delete();

        return redirect()->route('guru.index')->with('success', 'Guru berhasil dihapus');
    }
}
