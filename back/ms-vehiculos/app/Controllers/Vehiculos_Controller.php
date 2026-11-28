<?php

namespace App\Controllers;

use App\Models\User;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class Vehiculos_Controller
{
    public function getAllVehiculos()
    {
        $vehiculos = Vehiculos::all();
        return $vehiculos;
    }

    public function getVehiculoById($id)
    {
        $vehiculo = Vehiculos::find($id);
        return $vehiculo;
    }

    public function createVehiculo($data)
    {
        $vehiculo = Vehiculos::create($data);
        return $vehiculo;
    }

    public function updateVehiculo($id, $data)
    {
        $vehiculo = Vehiculos::find($id);
        if ($vehiculo) {
            $vehiculo->update($data);
            return $vehiculo;
        }
        return null;
    }

    public function estado_vehiculo($id)
    {
        $vehiculo = Vehiculos::find($id);
        if ($vehiculo) {
            return $vehiculo->estado;
        }
        return null;
    }

    public function deleteVehiculo($id)
    {
        $vehiculo = Vehiculos::find($id);
        if ($vehiculo) {
            $vehiculo->delete();
            return true;
        }
        return false;
    }
}