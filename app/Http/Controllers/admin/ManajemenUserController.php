<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ManajemenUserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->get();
    return view('/admin/manajemen-user', compact('users'));
    }

    public function edit($id)
{
    $user = User::findOrFail($id);
    return view('/admin/edit-user', compact('user'));
}

public function update(Request $request, $id)
{
    // Validasi input jika diperlukan
    $request->validate([
        'name' => 'required',
        'email' => 'required|email',
        'phone' => 'nullable',
        'role' => 'required|in:admin,user',
    ]);

    // Update data pengguna
    $user = User::findOrFail($id);
    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
    ]);

    // Update role pengguna menggunakan spatie/permission
    $user->syncRoles([$request->role]);

    // Redirect atau response sesuai kebutuhan
    return redirect()->route('manajemen-user')->with('success', 'Data pengguna berhasil diperbarui.');
}
public function destroy($id)
{
    $user = User::findOrFail($id);
    $user->delete();

    return redirect()->route('manajemen-user')->with('success', 'Pengguna berhasil dihapus.');
}
}
