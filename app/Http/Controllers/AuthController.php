<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        return view('pages.auth.login');
    }
    public function auth_login(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'password' => 'required',
            ]);

            if (Auth::attempt($request->only('name', 'password'))) {
                return redirect()->route('dashboard.index');
            }
            return redirect()->back()->withErrors(['message' => 'Ups! Username atau password salah']);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(['message' => $e->getMessage()]);
        }
    }


    public function logout()
    {

        Session::flush();
        Auth::logout();

        return redirect()->route('login');
    }
}
