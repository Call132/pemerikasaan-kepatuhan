<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class extPendamping extends Model
{
    protected $table = 'extPendamping'; // Nama tabel sesuai kebutuhan

    protected $fillable = [
        'nama',
        'jabatan',
        // Atribut l
    ];

    public function timPemeriksa()
    {
        return $this->belongsTo(TimPemeriksa::class, 'tim_pemeriksa_id');
    }
    public function spt(){
        return $this->belongsTo(SuratPerintahTugas::class, 'spt_id');
    }
    use HasFactory;
}
