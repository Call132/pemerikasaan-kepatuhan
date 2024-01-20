<?php

namespace App\Http\Controllers;

use App\Jobs\SendApprovalNotification;
use App\Models\BadanUsaha;
use App\Models\perencanaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user()->role;

        if ($user == 'User Entry') {
            $perencanaan = perencanaan::whereIn('status', ['Diajukan', 'approved'])->latest()->first();

            if ($perencanaan) {
                $badanUsaha = $perencanaan->badanUsaha;
                $badanUsaha->transform(function ($item) {
                    $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
                    return $item;
                });
            } else {
                $badanUsaha = collect();
            }
            return view('pages.dashboard.index', compact('perencanaan', 'badanUsaha'));
        } else {
            $perencanaan = Perencanaan::where('status', 'Diajukan')->latest()->first();
            if ($perencanaan !== null) {
                $perencanaan = Perencanaan::latest()->first();
                $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaan->id)->get();
                return view('pages.dashboard.index', compact('perencanaan', 'badanUsaha'));
            }
            $badanUsaha = [];
            return view('pages.dashboard.index', compact('perencanaan', 'badanUsaha'))->with('error', 'Tidak ada perencanaan yang diajukan.');
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

            $data->status = 'approved';
            $data->save();
            $users = User::where('role', 'User Entry')->get();

            dispatch(new SendApprovalNotification($users, $note))->onConnection('sync');;

            return redirect()->back()->with('success', 'Perencanaan berhasil disetujui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function reject($id)
    {
        $data = perencanaan::findOrFail($id);
        $data->status = 'selesai';
        $data->save();

        return redirect()->back()->with('error', 'Perencanaan ditolak.');
    }
}
