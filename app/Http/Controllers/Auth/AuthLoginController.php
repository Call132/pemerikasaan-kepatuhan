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
                'email' => ['required', 'email'],
                'password' => ['required'],
            ]);
            $request->session()->regenerate();

            Auth::attempt($credentials);
           
            if (Auth::user()->hasRole('admin')) {

                return redirect()->route('admin.dashboard');
            }
            if (Auth::user()->hasRole('user')) {
                return redirect()->route('home');
            }
            return redirect('/login')->with('error', 'Email atau kata sandi salah.');
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
