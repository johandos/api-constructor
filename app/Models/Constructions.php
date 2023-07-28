<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Constructions extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo_obra',
        'nombre_obra',
        'direccion',
        'ubicacion',
    ];
}
