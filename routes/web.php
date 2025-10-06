<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\GuruDashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
});

// Login pages for different roles
Route::get('/login/guru', function () {
    return view('auth.login', ['role' => 'Guru']);
})->name('login.guru');

Route::get('/login/siswa', function () {
    return view('auth.login', ['role' => 'Siswa']);
})->name('login.siswa');

Route::get('/login/admin', function () {
    return view('auth.login', ['role' => 'Admin']);
})->name('login.admin');

// Siswa dashboard
Route::get('/siswa-dashboard', function () {
    return view('siswa.dashboard');
})->name('siswa.dashboard');

// Guru dashboard
Route::get('/guru-dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard');
Route::get('/guru-dashboard/kehadiran', [GuruDashboardController::class, 'kehadiran'])->name('guru.kehadiran');
Route::get('/guru-dashboard/izin_sakit', [GuruDashboardController::class, 'izinSakit'])->name('guru.izin_sakit');

// Admin dashboard
Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin - Manajemen Siswa
Route::get('/admin-dashboard/siswa', function () {
    return view('admin.siswa');
})->name('admin.siswa');

Route::get('/admin-dashboard/guru', function () {
    return view('admin.guru');
})->name('admin.guru');

Route::get('/admin-dashboard/kelas', function () {
    return view('admin.kelas');
})->name('admin.kelas');

// Simple endpoints to accept attendance confirmations (AJAX)
use Illuminate\Http\Request;

Route::post('/absen/masuk', function (Request $request) {
    // In a real app you'd validate, authorize and persist this to DB
    return response()->json([
        'ok' => true,
        'type' => 'masuk',
        'data' => $request->all(),
    ]);
});

Route::post('/absen/pulang', function (Request $request) {
    return response()->json([
        'ok' => true,
        'type' => 'pulang',
        'data' => $request->all(),
    ]);
});

Route::post('/izin/request', function (Request $request) {
    // Placeholder: store request and file
    $data = $request->all();

    return response()->json(['ok' => true, 'data' => $data]);
});
