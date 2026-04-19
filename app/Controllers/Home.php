<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        // Cambiamos el welcome_message por tu pantalla de inicio
        return view('contenido/home');
    }
}