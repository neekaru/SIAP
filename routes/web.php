<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\GuruController;
use App\Http\Controllers\GuruDashboardController;
use App\Http\Controllers\KelasController;
use App\Http\Controllers\SiswaController;
use App\Http\Controllers\SiswaDashboardController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;

Route::post('/login/{role}', [LoginController::class, 'login'])->name('login.post');

Route::get('/login', [LoginController::class, 'redirect'])->name('login');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout.post');

Route::get('/login/{role}', [LoginController::class, 'show'])->whereIn('role', ['guru', 'siswa', 'admin']);

Route::get('/', function () {
    return view('home');
});

// Login pages for different roles
Route::get('/login/guru', [LoginController::class, 'show'])->name('login.guru')->defaults('role', 'Guru');

Route::get('/login/siswa', [LoginController::class, 'show'])->name('login.siswa')->defaults('role', 'Siswa');

Route::get('/login/admin', [LoginController::class, 'show'])->name('login.admin')->defaults('role', 'Admin');

// Siswa dashboard
Route::get('/siswa-dashboard', [SiswaDashboardController::class, 'index'])->name('siswa.dashboard');

// Guru dashboard
Route::prefix('guru-dashboard')->middleware('guru')->group(function () {
    Route::get('/', [GuruDashboardController::class, 'index'])->name('guru.dashboard');
    Route::get('/kehadiran', [GuruDashboardController::class, 'kehadiran'])->name('guru.kehadiran');
    Route::get('/izin_sakit', [GuruDashboardController::class, 'izinSakit'])->name('guru.izin_sakit');
    Route::get('/stats', [GuruDashboardController::class, 'StatsGuruDashboard'])->name('guru.stats');
    // This for handle Data Kehadiran handling
    Route::post('/validasi_kehadiran', [\App\Http\Controllers\GuruAdditionalController::class, 'ValidasiKehadiran'])->name('guru.validasi_kehadiran');
});

// Admin dashboard
Route::prefix('admin-dashboard')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // Admin - Manajemen Siswa
    Route::get('/siswa', [AdminDashboardController::class, 'siswa'])->name('admin.siswa');

    // Admin - Manajemen Guru
    Route::get('/guru', [AdminDashboardController::class, 'guru'])->name('admin.guru');

    // Admin - Manajemen Kelas
    Route::get('/kelas', [AdminDashboardController::class, 'kelas'])->name('admin.kelas');

    Route::get('/stats', [AdminDashboardController::class, 'DataTotal'])->name('admin.stats');
});

// Admin - Manajemen Siswa (CRUD)
Route::resource('siswa', SiswaController::class)->parameters([
    'siswa' => 'data_siswa',
]);

// Admin - Manajemen Guru (CRUD)
Route::resource('guru', GuruController::class);

// Admin - Manajemen Kelas (CRUD)
Route::resource('kelas', KelasController::class)->parameters([
    'kelas' => 'kelas',
]);

// Simple endpoints to accept attendance confirmations (AJAX)
Route::prefix('absen')->group(function () {
    Route::post('/masuk', [SiswaController::class, 'MasukAbsen'])->name('absen.masuk');
    Route::post('/pulang', [SiswaController::class, 'PulangAbsen'])->name('absen.pulang');
    Route::get('/status/{id}', [SiswaController::class, 'StatusAbsensi'])->name('absen.status');
});
// This for izin and Sakit
Route::post('/izin/request', [SiswaController::class, 'IzinSakit'])->name('absen.izin');

// Proxy endpoint to avoid CORS and rate-limit issues when calling ipapi.co from browser
Route::get('/ip-location', function (Request $request) {
    // Determine client IP (respect X-Forwarded-For if present)
    $forwarded = $request->header('X-Forwarded-For');
    $ip = $forwarded ? trim(explode(',', $forwarded)[0]) : $request->ip();
    if ($ip === '::1') {
        $ip = '127.0.0.1';
    }

    $cacheKey = 'ipapi_location_'.str_replace([':', '.'], '_', $ip);
    $cached = cache()->get($cacheKey);
    if ($cached) {
        return response()->json(array_merge($cached, ['cached' => true, 'fetched_for_ip' => $ip]));
    }

    try {
        // If IP looks like a private/local address, fall back to server-based lookup
        $useClientIp = false;
        if (filter_var($ip, FILTER_VALIDATE_IP)) {
            // Detect common private ranges
            if (! preg_match('/^(10\.|172\.(1[6-9]|2[0-9]|3[0-1])\.|192\.168\.|127\.)/', $ip)) {
                $useClientIp = true;
            }
        }

        $url = $useClientIp ? "https://ipapi.co/{$ip}/json/" : 'https://ipapi.co/json/';
        $res = Http::timeout(5)->get($url);
        $status = $res->status();
        $body = $res->body();

        // If upstream tells us rate-limited, forward 429 and don't cache
        if ($status === 429 || stripos($body, 'Too Many') !== false || stripos($body, 'too many') !== false) {
            return response()->json(['error' => 'Upstream rate limited', 'detail' => $body], 429);
        }

        if ($res->ok()) {
            $data = $res->json();
            // Cache only when we have coordinates (avoid caching error pages)
            if (! empty($data['latitude']) && ! empty($data['longitude'])) {
                cache()->put($cacheKey, $data, now()->addMinutes(5));
            }

            return response()->json(array_merge($data, ['fetched_for_ip' => $ip]));
        }
    } catch (\Exception $e) {
        return response()->json(['error' => 'Proxy error', 'detail' => $e->getMessage()], 502);
    }

    return response()->json(['error' => 'Upstream error'], 502);
});
