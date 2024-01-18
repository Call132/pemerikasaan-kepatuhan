<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perencanaan extends Model
{
    protected $table = 'perencanaan';
    protected $fillable = [
        'tanggal_awal',
        'tanggal_akhir',
        'status',
    ];

    protected $attributes = [
        'status' => 'diajukan',
    ];

    public function spt()
    {
        return $this->hasMany(SuratPerintahTugas::class);
    }
    public function badanUsaha()
    {
        return $this->hasMany(BadanUsaha::class);
    }

    use HasFactory;
}
