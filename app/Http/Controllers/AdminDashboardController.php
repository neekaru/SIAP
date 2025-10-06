<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard with mock stats.
     */
    public function index(Request $request): \Illuminate\Http\Response
    {
        $data = [
            'total_siswa' => 32,
            'total_guru' => 6,
            'total_kelas' => 12,
        ];

        return response()->view('admin.dashboard', $data);
    }
}
