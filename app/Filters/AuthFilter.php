<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // Si la sesión no tiene 'isLoggedIn', lo mandamos al login
        if (!session()->get('isLoggedIn')) {
            return redirect()->to('/login')->with('mensaje', 'Debés iniciar sesión para entrar ahí ⛔');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // no necesitamos hacer nada despues de la peticion
    }
}