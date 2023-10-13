<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\perencanaan;
use Illuminate\Support\Facades\DB;
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

        //$latestPerencanaan = Perencanaan::where('status', 'diajukan')->get();

        $badanUsahaDiajukan = DB::table('perencanaan')
            ->join('badan_usaha', 'perencanaan.id', '=', 'badan_usaha.perencanaan_id')
            ->where('perencanaan.status', 'diajukan')
            ->select('badan_usaha.*', 'perencanaan.start_date')
            ->get();

        // Transform the data as needed
        $badanUsahaDiajukan->transform(function ($item) {
            $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
            return $item;
        });


        return view('admin.dashboard-admin', [
            'type_menu' => 'dashboard',
            'badanUsahaDiajukan' => $badanUsahaDiajukan,


        ]);
    }
    public function approve($id)
    {
        $data = perencanaan::findOrFail($id);
        // Lakukan tindakan persetujuan di sini
        $data->status = 'approved';
        $data->save();

        return redirect()->route('admin.dashboard')->with('success', 'Perencanaan berhasil approved.');
    }
    public function reject($id)
    {
        $data = perencanaan::findOrFail($id);
        // Lakukan tindakan penolakan di sini
        $data->status = 'selesai';
        $data->save();

        return redirect()->route('admin.dashboard')->with('error', 'Perencanaan ditolak.');
    }
}
