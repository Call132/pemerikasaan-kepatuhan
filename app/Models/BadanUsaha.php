<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BadanUsaha extends Model
{
    
    protected $table = 'badan_usaha'; // Nama tabel di database

    protected $fillable = [
        'perencanaan_id',
        'npwp',
        'nama_badan_usaha',
        'kode_badan_usaha',
        'alamat',
        'kota_kab',
        'jenis_ketidakpatuhan',
        'tanggal_terakhir_bayar',
        'jumlah_tunggakan',
        'jenis_pemeriksaan',
        'jadwal_pemeriksaan',
        'jumlah_bulan_menunggak',
        'tanggal_bayar',
        'jumlah_bayar',
        'penerbitan_lhpa',
        'hasil_pemeriksaan',
        
    ];
    public function perencanaan()
    {
        return $this->belongsTo(Perencanaan::class);
    }
    use HasFactory;
}
