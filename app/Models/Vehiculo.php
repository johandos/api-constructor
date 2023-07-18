<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    use HasFactory;

    protected $primaryKey = 'numero_poliza';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'placa',
        'numero_bastidor',
        'fotografia_vehiculo',
        'ruc_empresa',
    ];


}
