<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class perencanaan extends Model
{
    protected $table = 'perencanaan';
    protected $fillable = [
        'start_date',
        'end_date',
        'status', // Tambahkan kolom status
    ];

    protected $attributes = [
        'status' => 'diajukan', // Nilai default untuk kolom status
    ];

    public function spt(){
        return $this->hasMany(SuratPerintahTugas::class);
    }
    public function badanUsaha()
    {
        return $this->hasMany(BadanUsaha::class);
    }

    use HasFactory;
}
