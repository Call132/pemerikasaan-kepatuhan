<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lhps extends Model
{
    protected $table = 'lhps';
    protected $fillable = [
        'badan_usaha_id',
        'tgl_lhps',
        'jumlah_bulan_menunggak',
        'jumlah_pekerja',
        'tanggapan_bu',
        'rekomendasi_pemeriksa',
        'last_year_bulan',
        'last_year_nominal',
        'this_year_bulan',
        'this_year_nominal',

    ];
    use HasFactory;
    public function badanUsaha(){
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }
}
