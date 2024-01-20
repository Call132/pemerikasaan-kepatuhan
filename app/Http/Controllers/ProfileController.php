<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        return view('pages.profile.index');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'password_old' => 'required|string|min:6',
            'password' => 'nullable|string|min:6|confirmed',
        ]);

        if (!Hash::check($request->input('password_old'), $user->password)) {
            return redirect()->route('profile.index')->withErrors(['password_old' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => $request->input('password') ? bcrypt($request->input('password')) : $user->password,
        ]);

        return redirect()->route('profile.index')->with('success', 'Profil pengguna berhasil diperbarui.');
    }
}
