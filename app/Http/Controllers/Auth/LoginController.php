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
        $roleFormatted = ucfirst(strtolower($role));
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

    // Handle POST /login/{role}: simple hardcoded auth logic as before
    public function login(Request $request, string $role)
    {
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
            $user = User::find($id);
            if ($user) {
                Auth::login($user);
            } else {
                $user = new User();
                $user->id = $id;
                $user->email = $email;
                $user->name = ucfirst($roleLower);
                $user->password = bcrypt('password');
                $user->save();
                Auth::login($user);
            }
            return redirect('/' . $roleLower . '-dashboard');
        }

        return back()->withErrors(['Invalid credentials']);
    }
}
