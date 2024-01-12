<?php

namespace App\Http\Controllers;

use App\Jobs\SendNotificationJob;
use App\Models\employee_roles;
use App\Models\perencanaan;
use App\Models\User;
use App\Notifications\perencanaanNotify;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Queue;
use Spatie\Permission\Models\Role;

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
        try {
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

            $admin = User::whereHas('roles', function ($query) {
                $query->where('name', 'user approval');
            })->get();


            // Mengirim notifikasi kepada admin
            dispatch(new SendNotificationJob($admin, new perencanaanNotify()))->onConnection('database');




            // Update atau buat data 'Tim Pemeriksa' jika belum ada
            employee_roles::updateOrCreate(['posisi' => 'Tim Pemeriksa'], ['nama' => $request->input('nama_tim_pemeriksa', 'Default Tim Pemeriksa')]);

            // Update atau buat data 'Kepala Bagian' jika belum ada
            employee_roles::updateOrCreate(['posisi' => 'Kepala Bagian'], ['nama' => $request->input('nama_kepala_bagian', 'Default Kepala Bagian')]);

            // Update atau buat data 'Kepala Cabang' jika belum ada
            employee_roles::updateOrCreate(['posisi' => 'Kepala Cabang'], ['nama' => $request->input('nama_kepala_cabang', 'Default Kepala Cabang')]);

            return redirect()->route('data-pemeriksaan.create', ['perencanaan_id' => $perencanaan->id])->with('succes', 'Perencanaan berhasil dibuat! Silahkan menambahkan data badan usaha.');
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' =>  'perencanaan gagal dibuat']);
        }
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
