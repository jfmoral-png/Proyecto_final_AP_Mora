<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conductores extends Model
{
    protected $table = 'conductores';
    protected $fillable = [
        'nombre',
        'apellido',
        'documento',
        'telefono',
        'correo',
        'numero_licencia',
        'categoria_licencia',
        'fecha_vencimiento_licencia',
        'estado',
        'created_at',
        'updated_at',
    ];
}