<?php

namespace App\Controllers;

use Illuminate\Database\Eloquent\Model;

class Viajes extends Model 
{
    protected $table = 'viajes';
    protected $fillable = [
        'programacion_viaje_id',
        'fecha',
        'hora',
        'estado',
        'novedad',
        'created_at',
        'updated_at',
    ];
}