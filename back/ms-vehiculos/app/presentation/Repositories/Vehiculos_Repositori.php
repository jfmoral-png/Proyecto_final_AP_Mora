<?php

namespace App\Presentation\Repositories;

use App\Controllers\UsersController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Vehiculos_Repositori
{
    public function create_vehiculo(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $usersController = new UsersController();
        $vehiculo = $usersController->createVehiculo($data);

        if ($vehiculo) {
            return $response->withJson($vehiculo, 201);
        } else {
            return $response->withJson(['error' => 'No se pudo crear el vehículo'], 400);
        }
    }

    public function get_vehiculos(Request $request, Response $response, array $args): Response
    {
        $usersController = new UsersController();
        $vehiculos = $usersController->getAllVehiculos();

        return $response->withJson($vehiculos);
    }

    public function update_vehiculo(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $usersController = new UsersController();
        $vehiculo = $usersController->updateVehiculo($id, $data);

        if ($vehiculo) {
            return $response->withJson($vehiculo);
        } else {
            return $response->withJson(['error' => 'Vehículo no encontrado'], 404);
        }
    }

    public function esrado_vehiculo(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $usersController = new UsersController();
        $vehiculo = $usersController->getVehiculoById($id);

        if ($vehiculo) {
            return $response->withJson(['estado' => $vehiculo->estado]);
        } else {
            return $response->withJson(['error' => 'Vehículo no encontrado'], 404);
        }
    }

}
