<?php

namespace App\Presentation\Repositories;

use Illuminate\Database\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Conductores_Repositori
{
    function all(Request $request, Response $response, $args): Response
    {
        $controller = new Conductores_Controller();
        $rows = $controller->get_conductores();
        $response->getBody()->write($rows->toJson());
        return $response->withHeader("Content-Type", "application/json");
    }

    function create(Request $request, Response $response, $args): Response
    {
        $controller = new Conductores_Controller();
        $data = json_decode($request->getBody(), true);
        $nombre = $data['nombre'] ?? '';
        $apellido = $data['apellido'] ?? '';
        $documento = $data['documento'] ?? '';
        $telefono = $data['telefono'] ?? '';
        $correo = $data['correo'] ?? '';
        $numero_licencia = $data['numero_licencia'] ?? '';
        $categoria_licencia = $data['categoria_licencia'] ?? '';
        $fecha_vencimiento_licencia = $data['fecha_vencimiento_licencia'] ?? '';

        try {
            $conductor = $controller->create_conductor(
                $nombre,
                $apellido,
                $documento,
                $telefono,
                $correo,
                $numero_licencia,
                $categoria_licencia,
                $fecha_vencimiento_licencia
            );
            if ($conductor) {
                $response->getBody()->write(json_encode(['message' => 'Conductor creado exitosamente', 'conductor' => $conductor]));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(['message' => 'Error al crear el conductor']));
                return $response->withStatus(400)->withHeader("Content-Type", "application/json");
            }
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['message' => 'Error: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader("Content-Type", "application/json");
        }
    }

    function getById(Request $request, Response $response, $args): Response
    {
        $controller = new Conductores_Controller();
        $id = $args['id'] ?? null;

        if ($id === null) {
            $response->getBody()->write(json_encode(['message' => 'ID del conductor no proporcionado']));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        try {
            $conductor = $controller->get_conductor_by_id($id);
            if ($conductor) {
                $response->getBody()->write(json_encode(['conductor' => $conductor]));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(['message' => 'Conductor no encontrado']));
                return $response->withStatus(404)->withHeader("Content-Type", "application/json");
            }
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['message' => 'Error: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader("Content-Type", "application/json");
        }
    }
    
    function update(Request $request, Response $response, $args): Response
    {
        $controller = new Conductores_Controller();
        $id = $args['id'] ?? null;
        $data = json_decode($request->getBody(), true);

        if ($id === null) {
            $response->getBody()->write(json_encode(['message' => 'ID del conductor no proporcionado']));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        try {
            $conductor = $controller->update_conductor($id, $data);
            if ($conductor) {
                $response->getBody()->write(json_encode(['message' => 'Conductor actualizado exitosamente', 'conductor' => $conductor]));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(['message' => 'Conductor no encontrado']));
                return $response->withStatus(404)->withHeader("Content-Type", "application/json");
            }
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['message' => 'Error: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader("Content-Type", "application/json");
        }
    }

    function delete(Request $request, Response $response, $args): Response
    {
        $controller = new Conductores_Controller();
        $id = $args['id'] ?? null;

        if ($id === null) {
            $response->getBody()->write(json_encode(['message' => 'ID del conductor no proporcionado']));
            return $response->withStatus(400)->withHeader("Content-Type", "application/json");
        }

        try {
            $deleted = $controller->delete_conductor($id);
            if ($deleted) {
                $response->getBody()->write(json_encode(['message' => 'Conductor eliminado exitosamente']));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(['message' => 'Conductor no encontrado']));
                return $response->withStatus(404)->withHeader("Content-Type", "application/json");
            }
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['message' => 'Error: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader("Content-Type", "application/json");
        }
    }
}