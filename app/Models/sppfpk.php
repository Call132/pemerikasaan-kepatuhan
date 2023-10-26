<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sppfpk extends Model
{
    protected $table = 'sppfpk';

    protected $fillable = [
        'nomor_sppfpk',
        'tanggal_surat',
        'waktu',
    ];

    // Definisikan relasi ke Badan Usaha jika diperlukan
    public function badanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class);
    }
    public function sppk()
    {
        return $this->belongsTo(Sppk::class, 'sppk_id');
    }
    use HasFactory;
}
