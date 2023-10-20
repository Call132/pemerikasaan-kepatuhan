<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sppl extends Model
{
    protected $table = 'sppl'; // Nama tabel di database

    protected $fillable = [
        'nomor_sppl',
        'nama',
        'noHp',
    ];

    public function spt()
    {
        return $this->belongsTo(Spt::class);
    }
    public function badanUsaha()
    {
        return $this->belongsTo(BadanUsaha::class);
    }
    use HasFactory;
}
