<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadanUsaha extends Model
{
    
    protected $table = 'badan_usaha'; // Nama tabel di database

    protected $fillable = [
        'nama_badan_usaha',
        'kode_badan_usaha',
        'alamat',
        'kota_kab',
        'jenis_ketidakpatuhan',
        'tanggal_terakhir_bayar',
        'jumlah_tunggakan',
        'jenis_pemeriksaan',
        'jadwal_pemeriksaan',
    ];
    protected $attributes = [
        'status' => 'Diajukan', // Nilai default untuk kolom status
    ];
    use HasFactory;
}
