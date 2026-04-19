<?php

namespace App\Controllers;
use App\Models\UsuarioModel; // ¡No te olvides de esta línea! Es la que llama a tu base de datos.

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

    public function guardados()
    {
        return view('contenido/guardados');
    }


    public function guardar()
    {
        // Dejamos de "simular" y conectamos tu modelo
        $model = new UsuarioModel();

        // Atrapamos lo que el usuario escribió en el HTML de tu compañero
        $datos = [
            'nombre_usuario'   => $this->request->getPost('nombre'),
            'correo_usuario'   => $this->request->getPost('correo'),
            'password_usuario' => password_hash($this->request->getPost('password'), PASSWORD_DEFAULT),
            'rol_usuario'      => 2
        ];

        // Guardamos de verdad en MySQL
        $model->insert($datos);

        // Usamos el mismo mensaje de éxito que inventó tu compañero
        session()->setFlashdata('mensaje', 'Usuario creado correctamente 🎉');

        return redirect()->to('/login');
    }


    public function procesarLogin()
    {
        $session = session();
        $model = new UsuarioModel();

        $correo = $this->request->getPost('correo');
        $password = $this->request->getPost('password');

        // Buscamos el correo en tu tabla
        $usuario = $model->where('correo_usuario', $correo)->first();

        // Verificamos la contraseña encriptada
        if ($usuario && password_verify($password, $usuario->password_usuario)) {
            
            // Si entra acá, los datos están bien. ¡Iniciamos sesión!
            $datosSesion = [
                'id_usuario' => $usuario->id_usuario,
                'nombre'     => $usuario->nombre_usuario,
                'rol'        => $usuario->rol_usuario,
                'isLoggedIn' => TRUE
            ];
            $session->set($datosSesion);
            
            // Lo mandamos al inicio (acá poné la ruta de tu página principal)
            return redirect()->to('/'); 

        } else {
            // Si le pifió a la clave, reusamos el sistema de mensajes de tu compañero
            $session->setFlashdata('mensaje', 'Correo o contraseña incorrectos ❌');
            return redirect()->to('/login');
        }
    }

    public function salir()
    {
        session()->destroy();
        return redirect()->to('/login');
    }
}