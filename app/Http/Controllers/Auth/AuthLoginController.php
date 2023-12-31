<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthLoginController extends Controller
{
    public function login(Request $request)
    {
        try {
            $credentials = $request->validate([
                'name' => ['required'],
                'password' => ['required'],
            ]);

            // Check if the username and password are valid without attempting login
            $isValidCredentials = Auth::validate($credentials);

            if (!$isValidCredentials) {
                return redirect('/login')->with('error', 'Nama atau kata sandi salah.');
            }

            $request->session()->regenerate();

            Auth::attempt($credentials);

            if (Auth::user()->hasAnyRole('admin', 'user approval')) {
                return redirect()->route('admin.dashboard')->with('success', 'Selamat datang ' . Auth::user()->name);
            } elseif (Auth::user()->hasAnyRole('user entry', 'Kepala Cabang')) {
                return redirect()->route('home')->with('success', 'Selamat datang ' . Auth::user()->name);
            }

            return redirect('/login')->with('error', 'Akun tidak memiliki peran yang valid.');
        } catch (\Exception $e) {
            return redirect('/login')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function logout(Request $request)
    {

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Session::flush();
        Auth::logout();

        return redirect('/login');
    }
}
