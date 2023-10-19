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
        'waktu',
        'tempat',
    ];

    public function spt()
    {
        return $this->belongsTo(Spt::class);
    }
    public function badanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class);
    }
}
