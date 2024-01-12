<?php

namespace App\Http\Controllers;

use App\Exports\BadanUsahaExport;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

use App\Http\Controllers\HomeController;
use App\Models\perencanaan;
use App\Models\surat;
use Carbon\Carbon;

class BadanUsahaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth'); // Middleware otentikasi
    }
    public function exportToExcel(Request $request)
    {
        try {
            $tanggalPerencanaan = $request->input('start_date'); // Mengambil Tanggal Awal dari permintaan
            $endDate = $request->input('end_date'); // Mengambil Tanggal Akhir dari permintaan

            // Check if perencanaan is approved
            $latestPerencanaan = Perencanaan::where('status', 'approved')->latest()->first();
            $badanUsaha = BadanUsaha::where('perencanaan_id', $latestPerencanaan->id)->first();
            if (!$latestPerencanaan) {
                return redirect()->intended('/')->with('error', 'Perencanaan belum diapprove.');
            }

            $excelFileName = 'Perencanaan Pemeriksaan ' . Carbon::parse($latestPerencanaan->start_date)->isoFormat('D MMMM YYYY') . ' - ' . Carbon::parse($latestPerencanaan->end_date)->isoFormat('D MMMM YYYY') . '.xlsx';
            $existingSurat = Surat::where('nomor_surat', $excelFileName)->first();
            if ($existingSurat) {
                // Directly download the file
                return redirect($existingSurat->file_path)->with('success', 'Perencanaan Pemeriksaan sudah ada, langsung didownload');
            }
            Excel::store(new BadanUsahaExport($tanggalPerencanaan, $endDate, $latestPerencanaan, $badanUsaha), 'public/excel/' . $excelFileName);
            $pdfPath = 'storage/excel/' . $excelFileName;


            $surat = new surat();
            $surat->nomor_surat = $excelFileName;
            $surat->perencanaan_id = $latestPerencanaan->id;
            $surat->badan_usaha_id = $latestPerencanaan->id;
            $surat->jenis_surat = 'Perencanaan';
            $surat->tanggal_surat = $tanggalPerencanaan;
            $surat->file_path = $pdfPath;
            $surat->save();

            return redirect($pdfPath)->with('success', 'Perencanaan exported successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>  'Perencanaan gagal di export !! ']);
        }
    }

    public function create($perencanaan_id)
    {
        $type_menu = 'data-pemeriksaan'; // Atur nilai variabel $type_menu
        $perencanaan = perencanaan::findOrFail($perencanaan_id);

        return view('data-pemeriksaan', compact('perencanaan_id', 'type_menu'));
    }


    public function saveData(Request $request, perencanaan $perencanaanId)
    {
        // Validate the form data
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
            $perencanaanId = $request->input('perencanaan_id'),

        ]);


        // Create a new instance of your model and fill it with form data
        //dd($perencanaanId); // Debugging line
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

        $inputValue = $request->input('jumlah_tunggakan');
        $cleanValue = str_replace(['Rp ', '.'], '', $inputValue);
        $jumlahTunggakan = floatval($cleanValue);
        $bu->jumlah_tunggakan = $jumlahTunggakan;
        // Save the data to the database
        //dd($bu);
        if ($bu->save()) {
            // Data successfully saved
            session()->flash('success', 'Data berhasil ditambahkan.');
            return redirect()->route('data-pemeriksaan.create', ['perencanaan_id' => $perencanaanId])->with('success', 'Data berhasil ditambahkan.');
        } else {
            // Data failed to save
            session()->flash('error', 'Data gagal ditambahkan. Silakan coba lagi.');
            return redirect()->route('data-pemeriksaan.create', ['perencanaan_id' => $perencanaanId])->with('error', 'Data gagal ditambahkan.');
        }
    }
    public function delete($id)
    {
        // Temukan data badan usaha berdasarkan ID
        $badanUsaha = BadanUsaha::find($id);

        // Jika data tidak ditemukan, kembalikan respons atau tindakan yang sesuai, misalnya 404 Not Found.
        if (!$badanUsaha) {
            return abort(404);
        }

        // Hapus data badan usaha
        $badanUsaha->delete();

        // Redirect ke halaman yang sesuai, misalnya halaman data-pemeriksaan
        return redirect('/')->with('success', 'Data berhasil dihapus.');
    }
    public function edit($id)
    {
        // Lakukan query untuk mendapatkan data badan usaha berdasarkan $id
        $data = BadanUsaha::find($id);

        // Jika data tidak ditemukan, tampilkan pesan error atau redirect ke halaman lain
        if (!$data) {
            // Misalnya, redirect ke halaman lain dengan pesan error
            return redirect()->route('data-pemeriksaan')->with('error', 'Data tidak ditemukan.');
        }

        return view('edit-data-pemeriksaan', ['type_menu' => 'dashboard', 'data' => $data]);
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang dikirim melalui form
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
        ]);

        // Proses pembaruan data
        $data = BadanUsaha::find($id);
        $data->nama_badan_usaha = $request->input('nama_badan_usaha');
        $data->kode_badan_usaha = $request->input('kode_badan_usaha');
        $data->alamat = $request->input('alamat');
        $data->kota_kab = $request->input('kota_kab');
        $data->jenis_ketidakpatuhan = $request->input('jenis_ketidakpatuhan');
        $data->tanggal_terakhir_bayar = $request->input('tanggal_terakhir_bayar');
        $data->jumlah_tunggakan = $request->input('jumlah_tunggakan');
        $data->jenis_pemeriksaan = $request->input('jenis_pemeriksaan');
        $data->jadwal_pemeriksaan = $request->input('jadwal_pemeriksaan');


        if ($validate) {
            $data->save();
            return redirect('/')->with('success', 'Data berhasil diperbarui.');
        }
        return redirect()->intended('/edit-data-pemeriksaan')->with('error', 'Data gagal diperbarui.');
    }
}
