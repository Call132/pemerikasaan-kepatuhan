<?php

namespace App\Http\Controllers\Auth;

use App\Models\UserRole;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthRegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::login;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // Atur peran pengguna, misalnya 'user entry'
        $user->assignRole('user');

        // Anda juga dapat menambahkan izin jika diperlukan
        // $user->givePermissionTo('permission_name');

        // Redirect ke halaman login dengan pesan sukses
        return redirect()->route('user.login')->with('success', 'Registration successful. Please login.');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'phone' => ['required', 'string', 'max:20', 'unique:users'],
        ], [
            'email.unique' => 'The email address has already been taken.',
            'phone.unique' => 'The phone number has already been taken.',
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone']

        ]);

        return redirect()->route('/login')->with('succes', 'registrasi berhasil silahkan login');
    }
}
