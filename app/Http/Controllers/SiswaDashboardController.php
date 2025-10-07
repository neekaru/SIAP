<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;

class SiswaDashboardController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'siswa',
        ];
    }

    /**
     * Show the siswa dashboard.
     */
    public function index(Request $request): \Illuminate\Http\Response
    {
        return response()->view('siswa.dashboard');
    }
}
