<?php

namespace App\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Usuario_controller
{
    public function get_users()
    {
        return User::orderBy('id')->get();
    }

    public function get_user($id)
    {
        return User::findOrFail($id);
    }

    public function login($username, $password)
    {
        $user = User::where('usuario', $username)
            ->orWhere('correo', $username)
            ->first();

        if (!$user) {
            throw new ModelNotFoundException('Usuario no encontrado');
        }

        if (!password_verify($password, $user->contrasena) &&
            !hash_equals($user->contrasena, $password)) {
            return null;
        }

        $user->sesion_activa = true;
        $user->save();

        return $user;
    }

    public function register($nombre, $correo, $usuario = null, $contrasena = null, $rol = 'operador')
    {
        // Compatibilidad con llamadas antiguas: register(nombre, correo, password)
        if ($contrasena === null) {
            $contrasena = $usuario;
            $usuario = strstr($correo, '@', true) ?: $correo;
        }

        if ($usuario === null || $usuario === '' || $contrasena === null || $contrasena === '') {
            return null;
        }

        if (User::where('correo', $correo)->orWhere('usuario', $usuario)->exists()) {
            return null;
        }

        return User::create([
            'nombre' => $nombre,
            'correo' => $correo,
            'usuario' => $usuario,
            'contrasena' => password_hash($contrasena, PASSWORD_DEFAULT),
            'rol' => $rol,
            'sesion_activa' => false,
            'estado' => 'activo',
        ]);
    }

    public function create(array $data)
    {
        return $this->register(
            $data['nombre'] ?? '',
            $data['correo'] ?? '',
            $data['usuario'] ?? '',
            $data['contrasena'] ?? $data['password'] ?? '',
            $data['rol'] ?? 'operador'
        );
    }

    public function update($id, array $data)
    {
        $user = $this->get_user($id);

        $fillable = ['nombre', 'correo', 'usuario', 'rol', 'estado'];
        foreach ($fillable as $field) {
            if (array_key_exists($field, $data)) {
                $user->{$field} = $data[$field];
            }
        }

        if (!empty($data['contrasena']) || !empty($data['password'])) {
            $password = $data['contrasena'] ?? $data['password'];
            $user->contrasena = password_hash($password, PASSWORD_DEFAULT);
        }

        $user->save();

        return $user;
    }

    public function delete($id)
    {
        $user = $this->get_user($id);

        return $user->delete();
    }
}