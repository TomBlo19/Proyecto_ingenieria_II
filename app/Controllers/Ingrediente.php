<?php

namespace App\Controllers;

use App\Models\IngredienteModel;

class Ingrediente extends BaseController
{


public  function obtenerIngrediente($nombre)
{
    $model = new IngredienteModel();

    $ingrediente = $model
        ->where('nombre_ingrediente', $nombre)
        ->first();

    if ($ingrediente) {

        return $ingrediente['id_ingrediente'];
    }

    return $this->registrarIngrediente($nombre);
}



public  function registrarIngrediente($nombre)
{
    $model = new IngredienteModel();

    $model->insert([
        'nombre_ingrediente' => $nombre
    ]);

    return $model->getInsertID();
}



public function obtenerIngredientesReceta($idReceta)
{
    $model = new IngredienteModel();

    return $model->obtenerIngredientesReceta(
        $idReceta
    );
}

}