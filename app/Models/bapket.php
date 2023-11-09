<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class bapket extends Model
{

    protected $table = 'bapket';
    protected $fillable = [
        'badan_usaha_id',
        'spt_id',
        'no_bapket',
        'tgl_bapket',
        'nama_pemberi_kerja',
        'jabatan',
        'sebab_menunggak',
    ];
    use HasFactory;

    public function badanUsaha(){
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }
    public function spt(){
        return $this->belongsTo(SuratPerintahTugas::class);
    }
}
