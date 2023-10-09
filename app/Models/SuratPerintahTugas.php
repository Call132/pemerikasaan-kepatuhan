<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class SuratPerintahTugas extends Model
{

    protected $table = 'surat_perintah_tugas'; // Nama tabel di database

    protected $fillable = [
        'nomor_spt',
        'tanggal_spt',
        'jabatan',


    ];
    public function timPemeriksa()
    {
        return $this->hasOne(TimPemeriksa::class, 'spt_id');
    }
    public function pendamping()
    {
        return $this->hasMany(Pendamping::class, 'surat_perintah_tugas_id');
    }
    use HasFactory;
}
