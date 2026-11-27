<?php

namespace App\Controllers;

use App\Models\Rutas;
use Illuminate\Database\Eloquent\Collection;

class Rutas_Controller
{
    public function getAllRutas()
    {
        $rutas = Rutas::all();
        return $rutas;
    }

    public function getRutaById($id)
    {
        $ruta = Rutas::find($id);
        return $ruta;
    }

    public function createRuta($data)
    {
        $ruta = Rutas::create($data);
        return $ruta;
    }

    public function updateRuta($id, $data)
    {
        $ruta = Rutas::find($id);
        if ($ruta) {
            $ruta->update($data);
            return $ruta;
        }
        return null;
    }

    public function deleteRuta($id)
    {
        $ruta = Rutas::find($id);
        if ($ruta) {
            $ruta->delete();
            return true;
        }
        return false;
    }
}