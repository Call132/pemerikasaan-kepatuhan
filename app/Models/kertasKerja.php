<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class kertasKerja extends Model
{
    protected $table = 'kertas_kerja';
    protected $fillable = [
        'badan_usaha_id',
        'npwp',
        'uraian',
        'tanggapan_bu',
        'ref_pekerja',
        'koreksi',
        'ref_iuran',
        'total_pekerja',
        'jumlah_bulan_menunggak',
    ];
    use HasFactory;
    public function badanUsaha(){
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }
}
