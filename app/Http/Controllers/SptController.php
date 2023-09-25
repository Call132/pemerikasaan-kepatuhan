<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\SuratPerintahTugas;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;

class SptController extends Controller
{
    public function create()
{
    return view('spt-preview');
}


/*public function exportPdf(Request $request)
    {
        // Ambil data dari formulir
        $nomorSpt = $request->input('nomor_spt');
        $tanggalSurat = $request->input('tanggal_surat');
        $petugasPemeriksa = $request->input('petugas_pemeriksa');
        $nppPetugas = $request->input('npp_petugas');
        $tanggalPemeriksaan = $request->input('tanggal_pemeriksaan');

        
        // Generate PDF menggunakan template
        $pdf = FacadePdf::loadView('spt-preview', [
            'nomorSpt' => $nomorSpt,
            'tanggalSurat' => $tanggalSurat,
            'petugasPemeriksa' => $petugasPemeriksa,
            'nppPetugas' => $nppPetugas,
            'tanggalPemeriksaan' => $tanggalPemeriksaan,
        ]);
        return view('spt-preview', [
            'nomorSpt' => $nomorSpt,
            'tanggalSurat' => $tanggalSurat,
            'petugasPemeriksa' => $petugasPemeriksa,
            'nppPetugas' => $nppPetugas,
            'tanggalPemeriksaan' => $tanggalPemeriksaan,
            ]);

        // Simpan atau unduh PDF
        return $pdf->download('Surat Perintah Tugas.pdf'); // Mengunduh file PDF
    }
*/
    // Menyimpan SPT yang baru dibuat
public function store(Request $request)

{
    // Validasi input dari form
    $validatedData = $request->validate([
    'nomor_spt' => 'required',
    'tanggal_spt' => 'required|date',
    'petugas_pemeriksa_nama' => 'nullable', // Sesuaikan dengan kebutuhan Anda
    'petugas_pemeriksa_npp' => 'nullable',
    'pendamping_nama' => 'array',
    'pendamping_npp' => 'array',
]);
if (!$request->has('tanggal_spt')) {
    $validatedData['tanggal_spt'] = now(); // Atur tanggal default jika tidak ada input 'tanggal_spt'
}

    // Simpan data SPT ke dalam database
    $spt = new SuratPerintahTugas($validatedData);
    //dd($spt);
    
    

    // Simpan data petugas pemeriksa dan pendamping
    $spt->petugasPemeriksa()->create([
        'nama' => $request->input('petugas_pemeriksa_nama'),
        'npp' => $request->input('petugas_pemeriksa_npp'),
    ]);

   // Simpan data pendamping
   $spt->pendamping()->create([
    'nama' => $request->input('pendamping_nama[]'),
    'npp' => $request->input('pendamping_npp[]'),
]);
    $spt->save();

    return redirect()->route('/spt-preview')->with('success', 'SPT berhasil disimpan.');
}

// Menampilkan daftar BU
public function index()
{
    $badanUsahaDiajukan = BadanUsaha::where('status', 'Diajukan')->get();
    
       
       $badanUsahaDiajukan->transform(function ($item) {
           $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
           return $item;
       });
       
   
       $sptList = SuratPerintahTugas::all();
       //dd($badanUsahaDiajukan);
       return view('spt-preview', compact('badanUsahaDiajukan'));

}

}
