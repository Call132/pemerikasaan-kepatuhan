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
    public function perencanaan()
    {
        return $this->belongsTo(perencanaan::class);
    }
    public function timPemeriksa()
    {
        return $this->hasOne(TimPemeriksa::class);
    }
    public function pendamping()
    {
        return $this->hasMany(Pendamping::class);
    }
    public function extPendamping()
    {
        return $this->hasOne(extPendamping::class);
    }
    public function sppk()
    {
        return $this->hasMany(sppk::class);
    }
    public function sppl()
    {
        return $this->hasMany(sppl::class);
    }
    public function bapket()
    {
        return $this->hasMany(bapket::class);
    }

    use HasFactory;
}
