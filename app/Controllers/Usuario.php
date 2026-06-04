<?php

namespace App\Controllers;
use App\Models\UsuarioModel; 

class Usuario extends BaseController
{

    public function login()
    {
        return view('contenido/login');
    }

    public function registro()
    {
        return view('contenido/registro');
    }



   public function guardar()
{
    $this->registrarUsuario(
        $this->request->getPost('nombre'),
        $this->request->getPost('correo'),
        $this->request->getPost('password')
    );

    session()->setFlashdata(
        'mensaje',
        'Usuario creado correctamente 🎉'
    );

    return redirect()->to('/login');
}

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

public function procesarLogin()
{
    $session = session();

    $correo = $this->request->getPost('correo');
    $password = $this->request->getPost('password');

    $datosUsuario = $this->obtenerUsuario($correo);

    if (
        $this->validarCredenciales(
            $datosUsuario,
            $password
        )
    ) {

        $datosSesion = [
            'id_usuario' => $datosUsuario->id_usuario,
            'nombre'     => $datosUsuario->nombre_usuario,
            'rol'        => $datosUsuario->rol_usuario,
            'isLoggedIn' => TRUE
        ];

        $session->set($datosSesion);

        return redirect()->to('/');

    } else {

        $session->setFlashdata(
            'mensaje',
            'Correo o contraseña incorrectos ❌'
        );

        return redirect()->to('/login');
    }
}


private function obtenerUsuario(
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

private function validarCredenciales(
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

    
    public function salir()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

public function verificarUsuario()
{
    return session()->get('isLoggedIn');
}

}