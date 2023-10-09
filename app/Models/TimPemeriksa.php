<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimPemeriksa extends Model
{
    protected $table = 'tim_pemeriksa'; // Nama tabel sesuai kebutuhan

    protected $fillable = [
        'nama',
        'npp',
        // Atribut lainnya
    ];

    public function spt()
    {
        return $this->hasMany(SuratPerintahTugas::class);
    }


    use HasFactory;
}
