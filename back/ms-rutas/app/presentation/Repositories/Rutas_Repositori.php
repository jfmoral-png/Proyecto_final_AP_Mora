<?php

namespace App\presentation\Repositories;

use App\Controllers\Rutas_Controller;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Rutas_Repositori
{
    function create_ruta(Request $request, Response $response, array $args): Response
    {
        $data = $request->getParsedBody();
        $rutasController = new Rutas_Controller();
        $ruta = $rutasController->createRuta($data);

        if ($ruta) {
            return $response->withJson($ruta, 201);
        } else {
            return $response->withJson(['error' => 'No se pudo crear la ruta'], 400);
        }
    }

    function get_rutas(Request $request, Response $response, array $args): Response
    {
        $rutasController = new Rutas_Controller();
        $rutas = $rutasController->getAllRutas();

        return $response->withJson($rutas);
    }

    function update_ruta(Request $request, Response $response, array $args): Response
    {
        $id = $args['id'];
        $data = $request->getParsedBody();
        $rutasController = new Rutas_Controller();
        $ruta = $rutasController->updateRuta($id, $data);

        if ($ruta) {
            return $response->withJson($ruta);
        } else {
            return $response->withJson(['error' => 'Ruta no encontrada'], 404);
        }
    }

    
}