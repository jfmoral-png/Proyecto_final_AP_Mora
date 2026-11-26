<?php

namespace App\Controllers;

use Illuminate\Database\Eloquent\Collection;

class Rutas extends Model
{
    protected $table = 'rutas';
    protected $fillable = [
        'conductor_id',
        'vehiculo_id',
        'ruta_id',
        'fecha_salida',
        'hora_salida',
        'fecha_estimada_llegada',
        'observaciones',
        'estado',
        'created_at',
        'updated_at',
    ];
}
