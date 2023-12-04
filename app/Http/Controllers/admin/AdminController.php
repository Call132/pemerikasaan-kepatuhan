<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use App\Models\User;

use App\Notifications\perencanaanApproved;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class AdminController extends Controller
{

    public function index()
    {

        try {

            $latestPerencanaan = Perencanaan::where('status', 'diajukan')->latest()->first();
            if ($latestPerencanaan !== null) {
                $latestPerencanaan = Perencanaan::latest()->first();
                $badanUsaha = BadanUsaha::where('perencanaan_id', $latestPerencanaan->id)->get();
                return view('admin.dashboard-admin', compact('latestPerencanaan', 'badanUsaha'));
            }
            $badanUsaha = [];
            return view('admin.dashboard-admin', compact('latestPerencanaan', 'badanUsaha'))->with('error', 'Tidak ada perencanaan yang diajukan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function approve(Request $request, $id)
    {
        try {
            $data = perencanaan::findOrFail($id);
            $request->validate([
                'catatan' => 'nullable',
            ]);
            $note = $request->input('catatan');


            // Lakukan tindakan persetujuan di sini
            $data->status = 'approved';
            $data->save();

            // Mengecek apakah ada catatan
            $notification = new perencanaanApproved($note); // Notifikasi dengan atau tanpa catatan

            // Mendapatkan semua pengguna
            $users = User::whereHas('roles', function ($query) {
                $query->where('name', 'user entry');
            })->get();

            // Mengirim notifikasi persetujuan kepada semua pengguna
            Notification::send($users, $notification);

            // Redirect ke halaman admin.dashboard dengan pesan sukses
            return redirect()->route('admin.dashboard')->with('success', 'Perencanaan berhasil disetujui.');
        } catch (\Exception $e) {
            return dd($e);
        }
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
