<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileadminController extends Controller
{
    public function index()
    {
        return view('admin.profile-admin'); // Sesuaikan dengan struktur folder dan nama view Anda
    }

    public function update(Request $request)
    {
        try{
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'nullable|string|max:20',
            ]);
    
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }
    
            $user = auth::User()->hasRole('admin');
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            
                $user->save();
            
    
            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } catch(\Exception $e){
            return redirect()->back()->with('error', 'gagal memperbarui profil');}
    }
}
