<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimPemeriksa extends Model
{
    protected $table = 'tim_pemeriksa'; // Nama tabel sesuai kebutuhan

    protected $fillable = [
        'petugas_pemeriksa_nama',
        'petugas_pemeriksa_npp',
        // Atribut lainnya
    ];

    public function pendamping()
{
    return $this->hasMany(Pendamping::class, 'tim_pemeriksa_id');
}


    use HasFactory;
}
