<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Obra extends Model
{
    use HasFactory;
    protected $table = 'obra';
    protected $primaryKey = 'codigo_obra';
    public $timestamps = false;

    protected $fillable = [
        'codigo_obra',
        'nombre_obra',
        'direccion',
        'ubicacion',
    ];
}
