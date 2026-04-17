<?php

namespace App\Controllers;

class Receta extends BaseController
{
    public function detalle()
    {
        return view('contenido/receta_detalle');
    }

    public function crear()
{
    return view('contenido/crear_receta');
}

public function guardar()
{
    // guardamos mensaje en sesión
    session()->setFlashdata('mensaje', 'Receta creada correctamente 🔥');

    // redirigimos
    return redirect()->to('/');
}

public function index()
{
    return view('contenido/recetas');
}
public function categorias()
{
    return view('contenido/categorias');
}

public function guardados()
{
    return view('contenido/guardados');
}
}

