<?php

namespace App\Http\Controllers;

use App\Exports\ProgramPemeriksaan;
use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\perencanaan;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class programPemeriksaanController extends Controller
{
    public function create()
    {
        $perencanaan = perencanaan::all();
        foreach ($perencanaan as $p) {
            $p->id;
        }

        $badanUsaha = BadanUsaha::where('perencanaan_id', $p->id)->get();

        return view('program-pemeriksaan', compact('badanUsaha'));
    }

    public function store(Request $request)
    {
        $validator = $request->validate([
            'bu_id' => 'required',
            'npwp' => 'required',
            'aspek_tenaga_kerja' => 'required',
            'aspek_iuran' => 'required',
            'peraturan_perusahaan' => 'required',
            'daftar_pekerja' => 'required',
            'struktur_organisasi' => 'required',
            'daftar_slip_gaji' => 'required',
            'slip_gaji' => 'required',
            'absensi' => 'required'
        ]);

        if ($validator) {
            $id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($id);
            $npwp = $request->input('npwp');
            $tenagaKerja = $request->input('aspek_tenaga_kerja');
            $iuran = $request->input('aspek_iuran');
            $peraturan = $request->input('peraturan_perusahaan');
            $pekerja = $request->input('daftar_pekerja');
            $struktur = $request->input('struktur_organisasi');
            $slipGajiList = $request->input('daftar_slip_gaji');
            $slipGaji = $request->input('slip_gaji');
            $absen = $request->input('absensi');



            return Excel::download(new ProgramPemeriksaan($badanUsaha, $npwp, $tenagaKerja, $iuran, $peraturan, $pekerja, $struktur, $slipGajiList, $slipGaji, $absen), 'Program Realisasi Pemeriksaan.xlsx');
        }

        return redirect()->back()->with('error', 'Program Realisasi Pemeriksaan Gagal Dibuat');
    }


    public function form($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $jadwal_pemeriksaan = Carbon::parse($badanUsaha->jadwal_pemeriksaan)->isoFormat('MMMM', 'ID');

        return view('form-program-pemeriksaan', compact('badanUsaha', 'jadwal_pemeriksaan'));
    }
}
