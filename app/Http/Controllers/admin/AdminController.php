<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\perencanaan;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function __construct()
{
    $this->middleware(['auth', 'role:admin']); // Pastikan pengguna adalah admin
    $this->middleware('can:approve post')->only('approve'); // Hanya pengguna dengan izin approve post yang dapat mengakses metode 'approve'
}
    public function index()
{
    // Logika untuk mengambil data perencanaan yang perlu disetujui
    $perencanaan = perencanaan::where('status', 'diajukan')->get();

    return view('admin.dashboard', ['perencanaan' => $perencanaan]);
}
}
