<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GuruDashboardController extends Controller
{
    /**
     * Show the guru dashboard.
     */
    public function index(Request $request): \Illuminate\Http\Response
    {
        // In a real app you'd compute these using models/queries. We'll provide
        // mock numbers that match the design: total siswa, hadir, izin, belum absen.
        $data = [
            'total_siswa' => 32,
            'hadir' => 6,
            'izin_sakit' => 12,
            'belum_absen' => 24,
        ];

        return response()->view('guru.dashboard', $data);
    }
}
