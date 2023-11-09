<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendamping extends Model
{

    protected $table = 'pendamping'; // Nama tabel sesuai kebutuhan

    protected $fillable = [
        'nama',
        'npp',
        // Atribut l
    ];

    public function timPemeriksa()
    {
        return $this->belongsTo(TimPemeriksa::class, 'tim_pemeriksa_id');
    }
    public function spt()
    {
        return $this->belongsTo(SuratPerintahTugas::class, 'spt_id');
    }
    use HasFactory;
}
