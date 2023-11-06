<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class programPemeriksaan extends Model
{
    protected $table = 'program_pemeriksaan';
    protected $fillable = [
        'badan_usaha_id',
        'npwp',
        'aspek_tenaga_kerja',
        'aspek_iuran',
        'peraturan',
        'daftar_pekerja',
        'struktur_organisasi',
        'daftar_slip_gaji',
        'slip_gaji',
        'absensi',

    ];
    use HasFactory;

    public function badanUsaha(){
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }
}
