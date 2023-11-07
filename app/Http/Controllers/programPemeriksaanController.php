<?php

namespace App\Http\Controllers;

use App\Exports\ProgramPemeriksaan;
use App\Models\BadanUsaha;
use App\Models\employee_roles;
use App\Models\perencanaan;
use App\Models\programPemeriksaan as ModelsProgramPemeriksaan;
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

            $programPemeriksaan = new ModelsProgramPemeriksaan();
            $id = $request->input('bu_id');
            $badanUsaha = BadanUsaha::findOrFail($id);
            $programPemeriksaan->badan_usaha_id = $request->input('bu_id');
            $programPemeriksaan->npwp = $request->input('npwp');
            $programPemeriksaan->aspek_tenaga_kerja = $request->input('aspek_tenaga_kerja');
            $programPemeriksaan->aspek_iuran = $request->input('aspek_iuran');
            $programPemeriksaan->peraturan = $request->input('peraturan_perusahaan');
            $programPemeriksaan->daftar_pekerja = $request->input('daftar_pekerja');
            $programPemeriksaan->struktur_organisasi = $request->input('struktur_organisasi');
            $programPemeriksaan->daftar_slip_gaji = $request->input('daftar_slip_gaji');
            $programPemeriksaan->slip_gaji = $request->input('slip_gaji');
            $programPemeriksaan->absensi = $request->input('absensi');

            $programPemeriksaan->save();





            return Excel::download(new ProgramPemeriksaan($badanUsaha, $programPemeriksaan), 'Program Realisasi Pemeriksaan '. $badanUsaha->nama_badan_usaha  . '.xlsx');
        

       
    }


    public function form($id)
    {
        $badanUsaha = BadanUsaha::findOrFail($id);
        $jadwal_pemeriksaan = Carbon::parse($badanUsaha->jadwal_pemeriksaan)->isoFormat('MMMM', 'ID');

        return view('form-program-pemeriksaan', compact('badanUsaha', 'jadwal_pemeriksaan'));
    }
}
