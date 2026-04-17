<?php

namespace App\Controllers;

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
    // simulamos guardar usuario

    session()->setFlashdata('mensaje', 'Usuario creado correctamente 🎉');

    return redirect()->to('/login');
}
public function guardados()
{
    return view('contenido/guardados');
}

    }