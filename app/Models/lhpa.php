<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class lhpa extends Model
{
    protected $table = 'lhpa';
    protected $fillable = [
        'badan_usaha_id',
        'tgl_lhpa',
        'jumlah_bulan_menunggak',
        'jumlah_pekerja',
        'last_year_bulan',
        'last_year_pembayaran',
        'last_year_nominal',
        'this_year_bulan',
        'this_year_nominal',
        'this_year_pembayaran',
    ];
    use HasFactory;

    public function badanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }
}
