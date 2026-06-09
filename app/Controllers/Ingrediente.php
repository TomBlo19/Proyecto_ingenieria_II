<?php

namespace App\Controllers;

use App\Models\IngredienteModel;
use App\Models\RecetaIngredienteModel;

class Ingrediente extends BaseController
{


public function obtenerIngrediente(
    $nombre,
    $idReceta
)
{
    $model = new IngredienteModel();

    $ingrediente = $model
        ->where(
            'nombre_ingrediente',
            $nombre
        )
        ->first();

    if ($ingrediente) {

        $idIngrediente =
            $ingrediente[
                'id_ingrediente'
            ];

    } else {

        $idIngrediente =
            $this->registrarIngrediente(
                $nombre
            );
    }

    $this->registrarIngredienteReceta(
        $idReceta,
        $idIngrediente
    );

    return $idIngrediente;
}



private  function registrarIngrediente($nombre)
{
    $model = new IngredienteModel();

    $model->insert([
        'nombre_ingrediente' => $nombre
    ]);

    return $model->getInsertID();
}


private function registrarIngredienteReceta(
    $idReceta,
    $idIngrediente
)
{
    $relacionModel = new RecetaIngredienteModel();

    $relacionModel->insert([
        'id_receta'      => $idReceta,
        'id_ingrediente' => $idIngrediente
    ]);
}


   //incrediente
    public function obtenerIngredientesReceta($idReceta)
{
    $model = new IngredienteModel();

    return $model->obtenerIngredientesReceta(
        $idReceta
    );
}


}