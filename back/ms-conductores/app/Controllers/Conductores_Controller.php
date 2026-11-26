<?php

namespace App\Controllers;

use App\Models\Conductores;
use Illuminate\Database\Eloquent\Collection;

class Conductores_Controller
{
    public function getAllConductores()
    {
        $conductores = Conductores::all();
        return $conductores;
    }

    public function getConductorById($id)
    {
        $conductor = Conductores::find($id);
        return $conductor;
    }

    public function createConductor($data)
    {
        $conductor = Conductores::create($data);
        return $conductor;
    }

    public function updateConductor($id, $data)
    {
        $conductor = Conductores::find($id);
        if ($conductor) {
            $conductor->update($data);
            return $conductor;
        }
        return null;
    }

    public function deleteConductor($id)
    {
        $conductor = Conductores::find($id);
        if ($conductor) {
            $conductor->delete();
            return true;
        }
        return false;
    }
}