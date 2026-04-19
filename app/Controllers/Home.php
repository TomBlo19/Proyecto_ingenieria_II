<?php

namespace App\Controllers;

use App\Models\RecetaModel;

class Home extends BaseController
{
    public function index()
    {
        $model = new RecetaModel();

        $data['recetas'] = $model->findAll();

        return view('contenido/home', $data);
    }
}