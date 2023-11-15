<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class ProfileController extends Controller
{
    public function index()
    {
        return view('profile'); // Sesuaikan dengan struktur folder dan nama view Anda
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
    
            $user = auth::User();
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->phone = $request->input('phone');
            try{
                $user->save();
            }catch(\Exception $e){return dd($e->getMessage());}
    
            return redirect()->back()->with('success', 'Profil berhasil diperbarui.');
        } catch(\Exception $e){return dd($e->getMessage());}
    }
}
