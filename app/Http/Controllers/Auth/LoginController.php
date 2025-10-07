<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    // Show the role-specific login page
    public function show(Request $request, string $role)
    {
        $roleLower = strtolower($role);
        if ($roleLower === 'admin') {
            return view('auth.login-admin');
        }
        $roleFormatted = ucfirst($roleLower);

        return view('auth.login', ['role' => $roleFormatted]);
    }

    // Handle GET /login: redirect to a role-specific login page
    public function redirect(Request $request)
    {
        $intended = session('url.intended', '/');
        if (str_contains($intended, 'siswa')) {
            return redirect('/login/siswa');
        } elseif (str_contains($intended, 'guru')) {
            return redirect('/login/guru');
        } else {
            return redirect('/login/admin');
        }
    }

    // Handle POST /login/{role}: authenticate user with database
    public function login(Request $request, string $role)
    {
        $credentials = $request->only('email', 'password');
        $roleLower = strtolower($role);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            if ($user->role === $roleLower) {
                return redirect('/'.$roleLower.'-dashboard');
            } else {
                Auth::logout();

                return back()->withErrors(['Role mismatch']);
            }
        }

        return back()->withErrors(['Invalid credentials']);
    }

    // Logout handler that redirects users to their role-specific login
    public function logout(Request $request)
    {
        $user = Auth::user();
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // If we can identify the user's role, redirect to matching login
        if ($user) {
            return redirect('/login/'.$user->role);
        }

        return redirect('/');
    }
}
