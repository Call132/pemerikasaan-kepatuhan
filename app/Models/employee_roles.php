<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class employee_roles extends Model
{
    protected $table = 'employee_roles'; // Nama tabel sesuai kebutuhan

    protected $fillable = [
        'nama',
        'posisi',
        // Atribut l
    ];

    use HasFactory;
}
