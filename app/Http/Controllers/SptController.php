<?php

namespace App\Http\Controllers;

use App\Models\BadanUsaha;
use App\Models\Pendamping;
use App\Models\SuratPerintahTugas;
use Illuminate\Http\Request;

use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Barryvdh\DomPDF\PDF as DomPDFPDF;


class SptController extends Controller
{
    public function create()
    {
        $badanUsahaDiajukan = BadanUsaha::where('status', 'draft')->get();

        $badanUsahaDiajukan->transform(function ($item) {
            $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
            return $item;
        });

        return view('spt-preview', compact('badanUsahaDiajukan'));
    }




    // Menyimpan SPT yang baru dibuat
    public function store(Request $request)

    {


        // Validasi input dari form
        $validatedData = $request->validate([
            'nomor_spt' => 'required',
            'tanggal_spt' => 'required|date',
            'petugas_pemeriksa_nama' => 'nullable',
            'petugas_pemeriksa_npp' => 'nullable',
            'pendamping_nama.*' => 'nullable',
            'pendamping_npp.*' => 'nullable',
            'jabatan' => 'nullable',
        ]);
        if (!$request->has('tanggal_spt')) {
            $validatedData['tanggal_spt'] = now(); // Atur tanggal default jika tidak ada input 'tanggal_spt'
        }

        // Simpan data SPT ke dalam database
        $spt = new SuratPerintahTugas($validatedData);
        $spt->save();
        //dd($spt);



        // Simpan data petugas pemeriksa dan pendamping
        $spt->timPemeriksa()->create([
            'nama' => $request->input('petugas_pemeriksa_nama'),
            'npp' => $request->input('petugas_pemeriksa_npp'),
        ]);

        $pendampingNama = $request->input('pendamping_nama');
        $pendampingNPP = $request->input('pendamping_npp');

        foreach ($pendampingNama as $key => $nama) {
            if (!empty($nama)) {
                $pendamping = new Pendamping([
                    'nama' => $nama,
                    'npp' => $pendampingNPP[$key],
                ]);
                $spt->pendamping()->save($pendamping);
            }
        }

        $badanUsahaDiajukan = BadanUsaha::where('status', 'draft')->get();

        $badanUsahaDiajukan->transform(function ($item) {
            $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
            return $item;
        });

        //return view('spt-preview', compact('badanUsahaDiajukan'))->with('success', 'SPT berhasil disimpan.');
        // Generate the PDF
        $pdf = FacadePdf::loadView('spt-preview', compact('spt', 'badanUsahaDiajukan'));

        // Generate a unique filename for the PDF (you can customize this)
        $pdfFileName = 'SPT_' . $spt->nomor_spt . '.pdf';

        // Optionally, you can save the PDF to a directory on your server
        $pdfFilePath = storage_path('/public/docs' . $pdfFileName);

        // Download the PDF
        return $pdf->download($pdfFileName);

        // Pass the $spt variable to the view
        return view('spt-preview', compact('spt', 'badanUsahaDiajukan'))->with('success', 'SPT berhasil disimpan.');

        //return redirect()->route('spt.preview', ['spt' => $spt])->with('success', 'SPT berhasil disimpan.');
    }

    // Menampilkan daftar BU
    public function index()
    {
        $badanUsahaDiajukan = BadanUsaha::where('status', 'draft')->get();


        $badanUsahaDiajukan->transform(function ($item) {
            $item->jumlah_tunggakan = 'Rp ' . number_format(floatval($item->jumlah_tunggakan), 2, ',', '.');
            return $item;
        });


        $sptList = SuratPerintahTugas::all();
        //dd($badanUsahaDiajukan);
        return view('spt-preview', compact('badanUsahaDiajukan'));
    }
}
