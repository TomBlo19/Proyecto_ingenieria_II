<?php

namespace App\Controllers;
use App\Models\UsuarioModel; 

class Usuario extends BaseController
{

private function registrarUsuario(
    $nombre,
    $correo,
    $password
)
{
    $model = new UsuarioModel();

    $datos = [
        'nombre_usuario'   => $nombre,
        'correo_usuario'   => $correo,
        'password_usuario' => password_hash($password, PASSWORD_DEFAULT),
        'rol_usuario'      => 2
    ];

    $model->insert($datos);
}



public function obtenerUsuario(
    $correo
)
{
    $model = new UsuarioModel();

    return $model
        ->where(
            'correo_usuario',
            $correo
        )
        ->first();
}

public function validarCredenciales(
    $datosUsuario,
    $password
)
{
    return $datosUsuario &&
           password_verify(
               $password,
               $datosUsuario->password_usuario
           );
}

    
 

public function verificarUsuario(
    $idUsuario
)
{
    $usuarioModel = new UsuarioModel();

    return $usuarioModel
        ->where(
            'id_usuario',
            $idUsuario
        )
        ->first() !== null;
}
}