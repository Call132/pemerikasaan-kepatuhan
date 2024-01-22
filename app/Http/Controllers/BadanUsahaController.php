<?php

namespace App\Http\Controllers;

use App\Exports\BadanUsahaExport;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Models\perencanaan;
use App\Models\surat;
use Carbon\Carbon;

class BadanUsahaController extends Controller
{

    public function create($id)
    {
        $perencanaan = perencanaan::findOrFail($id);
        return view('pages.badanUsaha.create', compact('perencanaan'));
    }

    public function export()
    {
        try {

            $perencanaan = Perencanaan::where('status', 'approved')->latest()->first();
            if (!$perencanaan) {
                return redirect()->intended('/')->with('error', 'Perencanaan belum diapprove.');
            }
            $badanUsaha = BadanUsaha::where('perencanaan_id', $perencanaan->id)->first();

            $startDate = $perencanaan->tanggal_awal;
            $endDate = $perencanaan->tanggal_akhir;

            $excelFileName = 'Perencanaan Pemeriksaan ' . Carbon::parse($perencanaan->start_date)->isoFormat('D MMMM YYYY') . ' - ' . Carbon::parse($perencanaan->end_date)->isoFormat('D MMMM YYYY') . '.xlsx';
            $existingSurat = Surat::where('nomor_surat', $excelFileName)->first();
            if ($existingSurat) {

                return redirect($existingSurat->file_path)->with('success', 'Perencanaan Pemeriksaan sudah ada, langsung didownload');
            }
            Excel::store(new BadanUsahaExport($startDate, $endDate, $perencanaan, $badanUsaha), 'public/excel/' . $excelFileName);
            $pdfPath = 'storage/excel/' . $excelFileName;


            $surat = new surat();
            $surat->nomor_surat = $excelFileName;
            $surat->perencanaan_id = $perencanaan->id;
            $surat->badan_usaha_id = 1;
            $surat->jenis_surat = 'Perencanaan';
            $surat->tanggal_surat = $perencanaan->created_at->toDateString();
            $surat->file_path = $pdfPath;
            $surat->save();

            return redirect($pdfPath)->with('success', 'Perencanaan Pemeriksaan Berhasilal di export !!');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>  'Perencanaan gagal di export !! : ' . $e->getMessage()]);
        }
    }




    public function store(Request $request, perencanaan $perencanaanId)
    {
        try {
            $request->validate([
                'nama_badan_usaha' => 'required|string|max:255',
                'kode_badan_usaha' => 'required|string|max:255',
                'alamat' => 'required|string',
                'kota_kab' => 'required|string|max:255',
                'jenis_ketidakpatuhan' => 'required|string|max:255',
                'tanggal_terakhir_bayar' => 'required|date',
                'jumlah_tunggakan' => 'required|numeric',
                'jenis_pemeriksaan' => 'required|string|max:255',
                'jadwal_pemeriksaan' => 'required|date',
                'penerbitan_lhpa' => 'required|date',
                $perencanaanId = $request->input('perencanaan_id'),

            ]);

            $inputValue = $request->input('jumlah_tunggakan');
            $cleanValue = str_replace(['Rp ', '.'], '', $inputValue);
            $jumlahTunggakan = floatval($cleanValue);

            $bu = new BadanUsaha();
            $bu->perencanaan_id = $perencanaanId;
            $bu->nama_badan_usaha = $request->input('nama_badan_usaha');
            $bu->kode_badan_usaha = $request->input('kode_badan_usaha');
            $bu->alamat = $request->input('alamat');
            $bu->kota_kab = $request->input('kota_kab');
            $bu->jenis_ketidakpatuhan = $request->input('jenis_ketidakpatuhan');
            $bu->tanggal_terakhir_bayar = $request->input('tanggal_terakhir_bayar');
            $bu->jumlah_tunggakan = $request->input('jumlah_tunggakan');
            $bu->jenis_pemeriksaan = $request->input('jenis_pemeriksaan');
            $bu->jadwal_pemeriksaan = $request->input('jadwal_pemeriksaan');
            $bu->penerbitan_lhpa = $request->input('penerbitan_lhpa');


            $bu->jumlah_tunggakan = $jumlahTunggakan;
            if ($bu->save()) {
                session()->flash('success', 'Data berhasil ditambahkan.');
                return redirect()->route('badanusaha.create', $perencanaanId)->with('success', 'Data berhasil ditambahkan.');
            } else {
                session()->flash('error', 'Data gagal ditambahkan. Silakan coba lagi.');
                return redirect()->route('badanusaha.create', $perencanaanId)->with('error', 'Data gagal ditambahkan.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => $e->getMessage()]);
        }
    }
    public function delete($id)
    {
        $badanUsaha = BadanUsaha::find($id);

        if (!$badanUsaha) {
            return abort(404);
        }

        $badanUsaha->delete();
        return redirect('/')->with('success', 'Data berhasil dihapus.');
    }
    public function edit($id)
    {
        $badanUsaha = BadanUsaha::find($id);
        return view('pages.badanusaha.edit', compact('badanUsaha'));
    }

    public function update(Request $request, $id)
    {
        $validate = $request->validate([
            'nama_badan_usaha' => 'required',
            'kode_badan_usaha' => 'required',
            'alamat' => 'required',
            'kota_kab' => 'required',
            'jenis_ketidakpatuhan' => 'required',
            'tanggal_terakhir_bayar' => 'required',
            'jumlah_tunggakan' => 'required',
            'jenis_pemeriksaan' => 'required',
            'jadwal_pemeriksaan' => 'required',
            'penerbitan_lhpa' => 'required',
        ]);

        $bu = BadanUsaha::find($id);
        $bu->nama_badan_usaha = $request->input('nama_badan_usaha');
        $bu->kode_badan_usaha = $request->input('kode_badan_usaha');
        $bu->alamat = $request->input('alamat');
        $bu->kota_kab = $request->input('kota_kab');
        $bu->jenis_ketidakpatuhan = $request->input('jenis_ketidakpatuhan');
        $bu->tanggal_terakhir_bayar = $request->input('tanggal_terakhir_bayar');
        $bu->jumlah_tunggakan = $request->input('jumlah_tunggakan');
        $bu->jenis_pemeriksaan = $request->input('jenis_pemeriksaan');
        $bu->jadwal_pemeriksaan = $request->input('jadwal_pemeriksaan');
        $bu->penerbitan_lhpa = $request->input('penerbitan_lhpa');


        if ($validate) {
            $bu->save();
            return redirect('/')->with('success', 'Data berhasil diperbarui.');
        }
        return redirect()->intended('/edit-data-pemeriksaan')->with('error', 'Data gagal diperbarui.');
    }
}
