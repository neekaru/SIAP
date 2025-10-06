<?php

use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\GuruDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Route::post('/login/{role}', function (Request $request, $role) {
    $email = $request->email;
    $password = $request->password;
    $valid = false;
    $roleLower = strtolower($role);

    if ($roleLower == 'admin' && $email == 'admin@example.com' && $password == 'password') {
        $valid = true;
    } elseif ($roleLower == 'guru' && $email == 'guru@example.com' && $password == 'password') {
        $valid = true;
    } elseif ($roleLower == 'siswa' && $email == 'siswa@example.com' && $password == 'password') {
        $valid = true;
    }

    if ($valid) {
        $id = $roleLower == 'admin' ? 1 : ($roleLower == 'guru' ? 2 : 3);
        $user = \App\Models\User::find($id);
        if ($user) {
            Auth::login($user);
        } else {
            $user = new \App\Models\User();
            $user->id = $id;
            $user->email = $email;
            $user->name = ucfirst($roleLower);
            $user->password = bcrypt('password');
            $user->save();
            Auth::login($user);
        }
        return redirect('/' . $roleLower . '-dashboard');
    } else {
        return back()->withErrors(['Invalid credentials']);
    }
})->name('login.post');

Route::get('/login', function () {
    $intended = session('url.intended', '/');
    if (str_contains($intended, 'siswa')) {
        return redirect('/login/siswa');
    } elseif (str_contains($intended, 'guru')) {
        return redirect('/login/guru');
    } else {
        return redirect('/login/admin');
    }
})->name('login');

Route::get('/logout', function () {
    Auth::logout();
    return redirect('/');
})->name('logout');


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
})->name('siswa.dashboard')->middleware('auth');

// Guru dashboard
Route::get('/guru-dashboard', [GuruDashboardController::class, 'index'])->name('guru.dashboard')->middleware('auth');
Route::get('/guru-dashboard/kehadiran', [GuruDashboardController::class, 'kehadiran'])->name('guru.kehadiran')->middleware('auth');
Route::get('/guru-dashboard/izin_sakit', [GuruDashboardController::class, 'izinSakit'])->name('guru.izin_sakit')->middleware('auth');

// Admin dashboard
Route::get('/admin-dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard')->middleware('auth');

// Admin - Manajemen Siswa
Route::get('/admin-dashboard/siswa', function () {
    return view('admin.siswa');
})->name('admin.siswa')->middleware('auth');

Route::get('/admin-dashboard/guru', function () {
    return view('admin.guru');
})->name('admin.guru')->middleware('auth');

Route::get('/admin-dashboard/kelas', function () {
    return view('admin.kelas');
})->name('admin.kelas')->middleware('auth');

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
