<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuratPerintahTugas extends Model
{
    
    protected $table = 'surat_perintah_tugas'; // Nama tabel di database

    protected $fillable = [
        'nomor_spt',
        'tanggal_spt',
        'lampiran_badan_usaha',
        'kota_kab',
        'petugas_pemeriksa_nama',
        'petugas_pemeriksa_npp',
        'pendamping_nama',
        'pendamping_npp',
        
    ];
    public function timPemeriksa()
{
    return $this->hasOne(TimPemeriksa::class);
}
public function pendamping()
{
    return $this->hasMany(Pendamping::class);
}
    use HasFactory;
}
