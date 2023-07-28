<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicles extends Model
{
    use HasFactory;

    protected $fillable = [
        'placa',
        'numero_bastidor',
        'fotografia_vehiculo',
        'companies_id',
    ];


}
