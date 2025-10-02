<?php

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
