<?php

namespace App\Http\Controllers;

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
        $data = [
            'total_siswa' => 32,
            'total_guru' => 6,
            'total_kelas' => 12,
        ];

        return response()->view('admin.dashboard', $data);
    }

    /**
     * Show the admin siswa page.
     */
    public function siswa(Request $request): \Illuminate\Http\Response
    {
        return response()->view('admin.siswa');
    }

    /**
     * Show the admin guru page.
     */
    public function guru(Request $request): \Illuminate\Http\Response
    {
        return response()->view('admin.guru');
    }

    /**
     * Show the admin kelas page.
     */
    public function kelas(Request $request): \Illuminate\Http\Response
    {
        return response()->view('admin.kelas');
    }
}
