<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surat extends Model
{
    use HasFactory;
    protected $table = 'surat'; // Nama tabel di database
    protected $fillable = [
        'nomor_surat',
        'jenis_surat',
        'perencanaan_id',
        'badan_usaha_id',
        'tanggal_surat',
        'file_path',
    ];

    public function badanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }

    public function perencanaan()
    {
        return $this->belongsTo(perencanaan::class, 'perencanaan_id');
    }
}
