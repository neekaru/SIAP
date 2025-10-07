<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuruDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::post('/login/{role}', [LoginController::class, 'login'])->name('login.post');

Route::get('/login', [LoginController::class, 'redirect'])->name('login');

Route::get('/logout', function () {
    Auth::logout();

    return redirect('/');
})->name('logout');

Route::get('/login/{role}', [LoginController::class, 'show'])->whereIn('role', ['guru', 'siswa', 'admin']);

Route::get('/', function () {
    return view('home');
});

// Login pages for different roles
Route::get('/login/guru', [LoginController::class, 'show'])->name('login.guru')->defaults('role', 'Guru');

Route::get('/login/siswa', [LoginController::class, 'show'])->name('login.siswa')->defaults('role', 'Siswa');

Route::get('/login/admin', [LoginController::class, 'show'])->name('login.admin')->defaults('role', 'Admin');

// Siswa dashboard
Route::get('/siswa-dashboard', function () {
    return view('siswa.dashboard');
})->name('siswa.dashboard')->middleware('auth');

// Guru dashboard
Route::get('/guru-dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard')->middleware('auth');
Route::get('/guru-dashboard/kehadiran', [GuruDashboardController::class, 'kehadiran'])->name('guru.kehadiran')->middleware('auth');
Route::get('/guru-dashboard/izin_sakit', [GuruDashboardController::class, 'izinSakit'])->name('guru.izin_sakit')->middleware('auth');

// Admin dashboard
Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

// Admin - Manajemen Siswa
Route::get('/admin-dashboard/siswa', [AdminDashboardController::class, 'siswa'])->name('admin.siswa');

// Admin - Manajemen Guru
Route::get('/admin-dashboard/guru', [AdminDashboardController::class, 'guru'])->name('admin.guru');

// Admin - Manajemen Kelas
Route::get('/admin-dashboard/kelas', [AdminDashboardController::class, 'kelas'])->name('admin.kelas');

// Simple endpoints to accept attendance confirmations (AJAX)
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
