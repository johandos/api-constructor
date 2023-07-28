<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Polices extends Model
{
    use HasFactory;

    protected $fillable = [
        'numero_poliza',
        'fecha_inicio',
        'fecha_fin',
        'aseguradora',
        'telefono_aseguradora',
        'telefono_broker',
        'cronograma_pago',
        'poliza_adjunta',
        'tipo_poliza',
        'estado_poliza',
    ];
}
