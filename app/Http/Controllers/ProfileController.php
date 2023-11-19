<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile'); // Sesuaikan dengan struktur folder dan nama view Anda
    }

    public function update(Request $request)
    {
        try {
            $user = Auth::user();
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'nullable|string|max:20',
                'password_old' => 'nullable|string|min:8',
                'password' => 'nullable|string|min:8|confirmed',
            ]);

            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);

            // Update kata sandi jika ada
            if ($request->filled('password_old') && Hash::check($request->password_old, $user->password)) {
                $user->update([
                    'password' => Hash::make($request->password),
                ]);
                return redirect()->route('admin.dashboard')->with('success', 'Profil dan password berhasil diperbarui.');
            } elseif ($request->filled('password_old')) {
                return redirect()->back()->with('error', 'Password lama tidak sesuai.');
            }
           
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
