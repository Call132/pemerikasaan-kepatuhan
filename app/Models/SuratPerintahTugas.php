<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SuratPerintahTugas extends Model
{

    protected $table = 'surat_perintah_tugas'; // Nama tabel di database

    protected $fillable = [
        'nomor_spt',
        'tanggal_spt',
        


    ];
    public function perencanaan(){
        return $this->belongsTo(perencanaan::class);
    }
    public function timPemeriksa()
    {
        return $this->hasOne(TimPemeriksa::class, 'spt_id');
    }
    public function pendamping()
    {
        return $this->hasMany(Pendamping::class, 'surat_perintah_tugas_id');
    }
    public function extPendamping()
    {
        return $this->hasMany(extPendamping::class, 'surat_perintah_tugas_id');
    }
    public function bapket(){
        return $this->hasMany(bapket::class, 'spt_id');
    }

    use HasFactory;
}
