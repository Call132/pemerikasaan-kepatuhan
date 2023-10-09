<?php

namespace App\Http\Controllers;

use App\Models\employee_roles;
use App\Models\perencanaan;
use Illuminate\Http\Request;

class perencanaanController extends Controller
{

    public function index()
    {
        // Logika untuk menampilkan daftar badan usaha
    }

    // Menampilkan formulir pembuatan badan usaha
    public function create()
    {
        return view('data-pemeriksaan');
    }

    // Menyimpan badan usaha baru ke dalam database
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'nama_tim_pemeriksa' => 'required|string',
            'nama_kepala_bagian' => 'required|string',
            'nama_kepala_cabang' => 'required|string',
        ]);

        $perencanaan = new Perencanaan();
        $perencanaan->status = 'diajukan';
        $perencanaan->start_date = $request->input('start_date');
        $perencanaan->end_date = $request->input('end_date');
        // Simpan data perencanaan ke dalam tabel 'perencanaan'
        $perencanaan->save();

        // Update tiga nama dalam tabel 'employee_roles' jika sudah ada

        employee_roles::where('posisi', 'Tim Pemeriksa')->update(['nama' => $request->input('nama_tim_pemeriksa')]);
        employee_roles::where('posisi', 'Kepala Bagian')->update(['nama' => $request->input('nama_kepala_bagian')]);
        employee_roles::where('posisi', 'Kepala Cabang')->update(['nama' => $request->input('nama_kepala_cabang')]);

        return redirect()->route('data-pemeriksaan.create', ['perencanaan_id' => $perencanaan->id]);



        //return redirect()->route('data-pemeriksaan', ['perencanaan_id' => $perencanaan->id]);
    }

    // Menampilkan detail badan usaha
    public function show($id)
    {
        // Logika untuk menampilkan detail badan usaha
    }

    // Menampilkan formulir pengeditan badan usaha
    public function edit($id)
    {
        // Logika untuk menampilkan formulir pengeditan badan usaha
    }

    // Memperbarui badan usaha dalam database
    public function update(Request $request, $id)
    {
        // Validasi input
        // Perbarui badan usaha dalam database
        // Redirect atau berikan respons sesuai kebutuhan
    }

    // Menghapus badan usaha
    public function destroy($id)
    {
        // Logika untuk menghapus badan usaha
    }
}
