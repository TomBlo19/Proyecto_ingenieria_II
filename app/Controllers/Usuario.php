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
        
        $model = new UsuarioModel();

        
        $datos = [
            'nombre_usuario'   => $this->request->getPost('nombre'),
            'correo_usuario'   => $this->request->getPost('correo'),
            'password_usuario' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol_usuario'      => 2
        ];

        
        $model->insert($datos);

  
        session()->setFlashdata('mensaje', 'Usuario creado correctamente 🎉');

        return redirect()->to('/login');
    }

        
    public function procesarLogin()
    {
        $session = session();
        $model = new UsuarioModel();

        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('password');

       
        $usuario = $model->where('correo_usuario', $correo)->first();

        if ($usuario && password_verify($password, $usuario->password_usuario)) {
            
           
            $datosSesion = [
                'id_usuario' => $usuario->id_usuario,
                'nombre'     => $usuario->nombre_usuario,
                'rol'        => $usuario->rol_usuario,
                'isLoggedIn' => TRUE
            ];
            $session->set($datosSesion);
            
           
            return redirect()->to('/'); 

        } else {
            
            $session->setFlashdata('mensaje', 'Correo o contraseña incorrectos ❌');
            return redirect()->to('/login');
        }
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