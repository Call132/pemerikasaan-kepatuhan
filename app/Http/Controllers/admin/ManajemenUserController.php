<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManajemenUserController extends Controller
{
    public function create()
    {

        return view('/admin/create-user');
    }
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'nullable',
                'password' => 'required|min:8',
                'role' => 'required|in:admin,user entry, user approval',
            ]);
            if (User::where('email', $request->email)->exists()) {
                return redirect()->back()->with('error', 'Email sudah terdaftar!');
            }
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole($request->role);
            return redirect()->route('manajemen-user')->with('success', 'User berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    public function index()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->get();
        return view('/admin/manajemen-user', compact('users'));
    }

    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('/admin/edit-user', compact('user'));
    }

    public function update(Request $request, $id)
    {
        try {
            // Validasi input jika diperlukan
            $request->validate([
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'nullable',
                'role' => 'required',
            ]);

            // Update data pengguna
            $user = User::findOrFail($id);
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'role' => $request->role,
            ]);

            // Update role pengguna menggunakan spatie/permission
            $user->syncRoles([$request->role]);

            // Redirect atau response sesuai kebutuhan
            return redirect()->route('manajemen-user')->with('success', 'Data pengguna berhasil diperbarui.');
        } catch (\Exception $e) {
            return dd($e);
        }
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Pengguna berhasil dihapus.');
    }
}
