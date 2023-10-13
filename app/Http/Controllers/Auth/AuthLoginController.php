<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthLoginController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            // Cek apakah pengguna adalah admin
            if (Auth::user()->hasRole('admin')) {
                return redirect('/dashboard-admin');
            } else {
                // Jika bukan admin, arahkan ke dashboard biasa
                return redirect('/');
            }
        }


        // Otentikasi gagal, tampilkan pesan kesalahan atau alihkan ke halaman masuk dengan pesan.
        return redirect('login')->with('error', 'Email atau kata sandi salah.');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('login');
    }
}
