<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class sphp extends Model
{
    protected $table = 'sphp';
    protected $fillable = [
        'badan_usaha_id',
        'no_sphp',
        'tgl_sphp',
        'p-a',
        'p-b',
        'p-c',
    ];
    use HasFactory;

    public function badanUsaha(){
        return $this->belongsTo(BadanUsaha::class, 'badan_usaha_id');
    }
}
