<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sppk extends Model
{
    use HasFactory;
    protected $table = 'sppk'; // Nama tabel di database

    protected $fillable = [
        'nomor_sppk',
        'tanggal_surat',
        'waktu',
        'surat_perintah_tugas_id',
        'badan_usaha_id',   
    ];

    public function spt()
    {
        return $this->belongsTo(SuratPerintahTugas::class);
    }
    public function badanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class);
    }
    public function sppfpk()
    {
        return $this->belongsTo(sppfpk::class, 'sppfpk_id');
    }
}
