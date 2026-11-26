<?php

namespace App\Presentation\Repositori;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class Usuarios_Repositori
{
    public function all(Request $request, Response $response, $args): Response
    {
        $controller = new Usuarios_Controller();
        $rows = $controller->get_users();
        $response->getBody()->write($rows->toJson());
        return $response->withHeader("Content-Type", "application/json");
    }

    public function login(Request $request, Response $response, $args): Response
    {
        $controller = new Usuarios_Controller();
        $data = json_decode($request->getBody(), true);
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        try {
            $user = $controller->login($email, $password);
            if ($user) {
                $response->getBody()->write(json_encode(['message' => 'Login successful', 'user' => $user]));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(['message' => 'Invalid credentials']));
                return $response->withStatus(401)->withHeader("Content-Type", "application/json");
            }
        } catch (ModelNotFoundException $e) {
            $response->getBody()->write(json_encode(['message' => 'User not found']));
            return $response->withStatus(404)->withHeader("Content-Type", "application/json");
        }
    }

    public function register(Request $request, Response $response, $args): Response
    {
        $controller = new Usuarios_Controller();
        $data = json_decode($request->getBody(), true);
        $nombre = $data['nombre'] ?? '';
        $email = $data['email'] ?? '';
        $password = $data['password'] ?? '';

        try {
            $user = $controller->register($nombre, $email, $password);
            if ($user) {
                $response->getBody()->write(json_encode(['message' => 'User registered successfully', 'user' => $user]));
                return $response->withHeader("Content-Type", "application/json");
            } else {
                $response->getBody()->write(json_encode(['message' => 'Registration failed']));
                return $response->withStatus(400)->withHeader("Content-Type", "application/json");
            }
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['message' => 'Error: ' . $e->getMessage()]));
            return $response->withStatus(500)->withHeader("Content-Type", "application/json");
        }
    }
}