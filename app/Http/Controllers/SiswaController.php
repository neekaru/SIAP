<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSiswaRequest;
use App\Models\DataAbsensi;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

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
            'siswa_id' => $dataSiswa->id,
            'kelas' => $kelas,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreSiswaRequest $request, DataSiswa $dataSiswa)
    {
        // Only update user data if values have changed
        $userData = [];
        if ($request->user_name !== $dataSiswa->user->name) {
            $userData['name'] = $request->user_name;
        }
        if ($request->email !== $dataSiswa->user->email) {
            $userData['email'] = $request->email;
        }
        if ($request->username !== $dataSiswa->user->username) {
            $userData['username'] = $request->username;
        }

        // Update user only if there are changes
        if (! empty($userData)) {
            $dataSiswa->user->update($userData);
        }

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

    public function MasukAbsen(Request $request)
    {
        // handle data Masuk
        $id_siswa = $request->input('id_siswa');
        $tanggal = $request->input('jam_masuk');
        $jenis = strtolower($request->input('status'));
        $lokasi = $request->input('location');

        $siswa = DataSiswa::where('user_id', $id_siswa)->first();
        if (! $siswa) {
            return null;
        }

        // Extract the absensi
        $existingAbsen = DataAbsensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now()->toDateString())
            ->where('jenis', 'masuk')
            ->first();

        if ($existingAbsen) {
            return $existingAbsen;
        }

        $absensi = DataAbsensi::create([
            'siswa_id' => $siswa->id,
            'tanggal' => $tanggal,
            'jenis' => $jenis,
            'lokasi_gps' => json_encode($lokasi),
            'created_at' => now(),
        ]);

        if (! $absensi) {
            Log::info('Absensi gagal disimpan untuk siswa dengan ID: '.($siswa ? $siswa->id : 'tidak ditemukan').'. Data request: ', [
                'id_siswa' => $id_siswa,
                'tanggal' => $tanggal,
                'jenis' => $jenis,
                'lokasi' => $lokasi,
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Siswa Tidak di temukan',
            ], 404);
        }

        return response()->json([
            'ok' => 'true',
            'type' => 'masuk',
            'message' => 'Absensi Masuk Berhasil di catat',
        ]);
    }

    public function PulangAbsen(Request $request)
    {
        // handle data Pulang
        $id_siswa = $request->input('id_siswa');
        $tanggal = $request->input('jam_masuk');
        $jenis = strtolower($request->input('status'));
        $lokasi = $request->input('location');

        $siswa = DataSiswa::where('user_id', $id_siswa)->first();
        if (! $siswa) {
            return null;
        }

        // Extract the absensi
        $existingAbsen = DataAbsensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now()->toDateString())
            ->where('jenis', 'pulang')
            ->first();

        if ($existingAbsen) {
            return $existingAbsen;
        }

        // Find the "masuk" absensi for today
        $absenMasuk = DataAbsensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now()->toDateString())
            ->where('jenis', 'masuk')
            ->first();

        if (! $absenMasuk) {
            Log::info('Absensi pulang gagal: absensi masuk tidak ditemukan untuk siswa dengan ID: '.($siswa ? $siswa->id : 'tidak ditemukan').'. Data request: ', [
                'id_siswa' => $id_siswa,
                'tanggal' => $tanggal,
                'jenis' => $jenis,
                'lokasi' => $lokasi,
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Absensi masuk belum dicatat, tidak bisa absen pulang',
            ], 404);
        }

        // Update the "masuk" absensi to "pulang"
        $absenMasuk->update([
            'lokasi_gps' => json_encode($lokasi),
            'jenis' => 'pulang',
            'updated_at' => now(),
        ]);

        if (! $absenMasuk) {
            Log::info('Absensi gagal disimpan untuk siswa dengan ID: '.($siswa ? $siswa->id : 'tidak ditemukan').'. Data request: ', [
                'id_siswa' => $id_siswa,
                'tanggal' => $tanggal,
                'jenis' => $jenis,
                'lokasi' => $lokasi,
                'request_data' => $request->all(),
            ]);

            return response()->json([
                'ok' => false,
                'message' => 'Siswa Tidak di temukan',
            ], 404);
        }

        return response()->json([
            'ok' => 'true',
            'type' => 'masuk',
            'message' => 'Absensi Pulang Berhasil di catat',
        ]);
    }

    public function StatusAbsensi(Request $request, int $idSiswa)
    {
        $siswa = DataSiswa::where('user_id', $idSiswa)->first();
        if (! $siswa) {
            return null;
        }

        // Find Absen masuk and Absen Pulang
        $status = DataAbsensi::where('siswa_id', $siswa->id)->get('jenis')->first();
        $statusValue = $status ? $status->jenis : 'Belum Absensi';

        // Handle Absensi
        // check status absensi nya
        // Cari absensi masuk dan pulang untuk hari ini
        $absenMasuk = DataAbsensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now()->toDateString())
            ->where('jenis', 'masuk')
            ->first();

        $absenPulang = DataAbsensi::where('siswa_id', $siswa->id)
            ->whereDate('tanggal', now()->toDateString())
            ->where('jenis', 'pulang')
            ->first();

        if ($absenMasuk) {
            $statusValue = 'Sudah Absen Masuk';
        } elseif ($absenPulang) {
            $statusValue = 'Sudah Absen Pulang';
        } else {
            $statusValue = 'Belum Absensi';
        }

        return response()->json([
            'id_siswa' => $siswa->id,
            'status' => $statusValue,
        ]);
    }
}
