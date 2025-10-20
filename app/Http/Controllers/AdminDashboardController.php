<?php

namespace App\Http\Controllers;

use App\Models\DataGuru;
use App\Models\DataKelas;
use App\Models\DataSiswa;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class AdminDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'admin',
        ];
    }

    /**
     * Show the admin dashboard with mock stats.
     */
    public function index(Request $request): \Illuminate\Http\Response
    {
        return response()->view('admin.dashboard');
    }

    /**
     * Show the admin siswa page.
     */
    public function siswa(Request $request): \Illuminate\Http\Response
    {
        $siswa = DataSiswa::with('user', 'kelas')->get();

        return response()->view('admin.siswa', ['siswa' => $siswa]);
    }

    /**
     * Show the admin guru page.
     */
    public function guru(Request $request): \Illuminate\Http\Response
    {
        $guru = DataGuru::with('user')->get();

        return response()->view('admin.guru', ['guru' => $guru]);
    }

    /**
     * Show the form to create a new guru.
     */
    public function createGuru(Request $request): \Illuminate\Http\Response
    {
        return response()->view('admin.guru-create');
    }

    /**
     * Show the form to edit an existing guru.
     */
    public function editGuru(Request $request, $id): \Illuminate\Http\Response
    {
        $guru = DataGuru::findOrFail($id);

        return response()->view('admin.guru-edit', ['guru' => $guru]);
    }

    /**
     * Show the admin kelas page.
     */
    public function kelas(Request $request): \Illuminate\Http\Response
    {
        $kelas = DataKelas::with('walikelas')->get();

        return response()->view('admin.kelas', ['kelas' => $kelas]);
    }

    public function DataTotal(Request $request): \Illuminate\Http\JsonResponse
    {
        // Grab data Siswa
        $siswa = DataSiswa::all()->count();
        $guru = DataGuru::all()->count();
        $kelas = DataKelas::all()->count();

        $data = [
            'total_siswa' => $siswa,
            'total_guru' => $guru,
            'total_kelas' => $kelas,
        ];

        return response()->json($data);
    }
}
