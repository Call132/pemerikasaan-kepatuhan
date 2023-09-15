<?php

namespace App\Http\Controllers;

use App\Exports\BadanUsahaExport;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class BadanUsahaController extends Controller
{
    public function exportToExcel()
    {
    return Excel::download(new BadanUsahaExport, 'PERENCANAAN_PEMERIKSAAN.xlsx');

    }
    public function saveData(Request $request)
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
    ]);
    

    // Create a new instance of your model and fill it with form data
    $bu = new BadanUsaha();
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
    $cleanValue = str_replace(['Rp ', '.', ','], '', $inputValue);
    $bu->jumlah_tunggakan = $cleanValue;
    // Save the data to the database
    //dd($bu->jumlah_tunggakan);

    $bu->save();
    // Redirect the user or perform any other actions you need
    session()->flash('success', 'Data berhasil ditambahkan.');
    return redirect('/data-pemeriksaan')->with('succes', 'Form successfully ditambah');;
}
}