<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pendamping extends Model
{
    public function timPemeriksa()
{
    return $this->belongsTo(TimPemeriksa::class, 'tim_pemeriksa_id');
}
    use HasFactory;
}
