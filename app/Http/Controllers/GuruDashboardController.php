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

    /**
     * Show the kehadiran (attendance) page for guru.
     */
    public function kehadiran(Request $request): \Illuminate\Http\Response
    {
        // Dummy attendance data (no database). Each row includes nama, nis, waktu, status
        $kehadiran = [
            ['nama' => 'Ahmad Santoso', 'nis' => '001', 'waktu' => '07:05', 'status' => 'Hadir'],
            ['nama' => 'Siti Nurhaliza', 'nis' => '002', 'waktu' => '07:12', 'status' => 'Hadir'],
            ['nama' => 'Budi Santoso', 'nis' => '003', 'waktu' => '-', 'status' => 'Izin'],
            ['nama' => 'Rina Wijaya', 'nis' => '004', 'waktu' => '-', 'status' => 'Alpa'],
            ['nama' => 'Dedi Kurnia', 'nis' => '005', 'waktu' => '07:20', 'status' => 'Hadir'],
        ];

        return response()->view('guru.kehadiran', ['kehadiran' => $kehadiran]);
    }
}
