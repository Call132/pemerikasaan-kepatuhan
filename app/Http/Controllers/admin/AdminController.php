<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use App\Models\User;
use App\Models\BadanUsaha;
use App\Notifications\perencanaanApproved;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']); // Pastikan pengguna adalah admin
        $this->middleware('can:approve post')->only('approve'); // Hanya pengguna dengan izin approve post yang dapat mengakses metode 'approve'
    }
    public function index()
{

        try {
            $latestPerencanaan = Perencanaan::where('status', 'diajukan')->latest()->first();

            
            $badanUsaha = BadanUsaha::where( 'perencanaan_id' , $latestPerencanaan->id)->get();

            return view('admin.dashboard-admin', compact('latestPerencanaan', 'badanUsaha'));
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan');
        }
    }
   
    public function approve($id)
    {
        $data = perencanaan::findOrFail($id);
        $note = request()->input('note');

        // Lakukan tindakan persetujuan di sini
        $data->status = 'approved';
        $data->save();

        // Mengecek apakah ada catatan
        $notification = new perencanaanApproved($note); // Notifikasi dengan atau tanpa catatan

        // Mendapatkan semua pengguna
        $users = User::whereHas('roles', function ($query) {
            $query->where('name', 'user');
        })->get();

        // Mengirim notifikasi persetujuan kepada semua pengguna
        Notification::send($users, $notification);

        // Redirect ke halaman admin.dashboard dengan pesan sukses
        return redirect()->route('admin.dashboard')->with('success', 'Perencanaan berhasil disetujui.');
    }


    public function reject($id)
    {
        $data = perencanaan::findOrFail($id);
        // Lakukan tindakan penolakan di sini
        $data->status = 'selesai';
        $data->save();

        return redirect()->route('admin.dashboard')->with('error', 'Perencanaan ditolak.');
    }
    public function getDetilBadanUsaha($perencanaanId)
{
    $badanUsahaDiajukan = BadanUsaha::where('perencanaan_id', $perencanaanId)->get();

    // Transform the data as needed
    $badanUsahaDiajukan->transform(function ($item) {
        $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
        return $item;
    });

    return view('admin.dashboard-admin', ['badanUsahaDiajukan' => $badanUsahaDiajukan]);
}

}
