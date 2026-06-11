<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Controllers\Receta;
use App\Controllers\Categoria;
use App\Controllers\Ingrediente;
use App\Controllers\Resena;
use App\Models\RecetaModel;
use App\Models\UsuarioModel; 
use App\Models\VotoResenaModel;
use App\Models\CategoriaModel;
class NavegacionApi extends BaseController
{


////////////// categorias 
public function categorias()
{
    $model = new CategoriaModel();
    
    $data['categorias'] = $model->findAll(); 

    return view('contenido/categorias', $data);
}


public function obtenerCategorias()
{
    $model = new CategoriaModel();
    return $this->response->setJSON($model->findAll());
}

///usuario
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
    $usuarioController =
        new \App\Controllers\Usuario();

    $usuarioController->registrarUsuario(
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

public function procesarLogin()
{
    $correo =
        $this->request->getPost(
            'correo'
        );

    $password =
        $this->request->getPost(
            'password'
        );

    $usuarioController =
        new \App\Controllers\Usuario();

    $datosUsuario =
        $usuarioController
            ->obtenerUsuario(
                $correo
            );

    if (
        $usuarioController
            ->validarCredenciales(
                $datosUsuario,
                $password
            )
    ) {

        session()->set([
            'id_usuario' => $datosUsuario->id_usuario,
            'nombre'     => $datosUsuario->nombre_usuario,
            'rol'        => $datosUsuario->rol_usuario,
            'isLoggedIn' => true
        ]);

        return redirect()->to('/');

    }

    session()->setFlashdata(
        'mensaje',
        'Correo o contraseña incorrectos ❌'
    );

    return redirect()->to('/login');
}

   public function salir()
    {
        session()->destroy();
        return redirect()->to('/login');
    }

 ///rutas 
  public function guardados()
    {
        return view('contenido/guardados');
    }   
}