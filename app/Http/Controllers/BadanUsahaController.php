<?php

namespace App\Http\Controllers;

use App\Exports\BadanUsahaExport;
use App\Models\BadanUsaha;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\HomeController;

class BadanUsahaController extends Controller
{
    public function exportToExcel(Request $request)
{
    $startDate = $request->input('start_date'); // Mengambil Tanggal Awal dari permintaan
    $endDate = $request->input('end_date');     // Mengambil Tanggal Akhir dari permintaan

    // Sekarang Anda memiliki tanggal awal dan tanggal akhir yang dapat digunakan untuk menghasilkan laporan Excel.
    // Anda juga dapat menyimpan nilai-nilai ini dalam variabel tersembunyi jika perlu digunakan di dalam view Excel.

    return Excel::download(new BadanUsahaExport($startDate, $endDate), 'PERENCANAAN_PEMERIKSAAN.xlsx');
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
    return redirect('/')->with('succes', 'Form successfully ditambah');;
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
public function index()
{
    // ...

    return view('home')->with('type_menu', 'dashboard');

    // ...
}
public function update(Request $request, $id)
{
    // Validasi input data
    $this->validate($request, [
        'nama_badan_usaha' => 'required',
        'kode_badan_usaha' => 'required',
        'alamat' => 'required',
        'kota_kab' => 'required',
        'jenis_ketidakpatuhan' => 'required',
        'tanggal_terakhir_bayar' => 'required|date',
        'jumlah_tunggakan' => 'required|numeric',
        'jenis_pemeriksaan' => 'required',
        'jadwal_pemeriksaan' => 'required|date',
        // tambahkan validasi lainnya sesuai kebutuhan
    ]);

    // Temukan data badan usaha berdasarkan ID
    $badanUsaha = BadanUsaha::find($id);

    // Periksa apakah data badan usaha ditemukan
    if (!$badanUsaha) {
        return redirect()->route('halaman_lain')->with('error', 'Data tidak ditemukan');
    }

    // Update data badan usaha dengan data yang dikirimkan dari form
    $badanUsaha->update($request->all());

    // Setelah berhasil mengupdate data, alihkan pengguna ke halaman "home.blade.php"
    return redirect('/')->with('success', 'Data berhasil diperbarui');
}


}