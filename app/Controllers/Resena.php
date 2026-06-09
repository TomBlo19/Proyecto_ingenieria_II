<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\ResenaModel;
use App\Models\VotoResenaModel;

class Resena extends BaseController
{
   


public function VerificarComentarioUsuario(
    $idUsuario,
    $idReceta
)
{
    $resenaModel =
        new ResenaModel();

    return $resenaModel
        ->where([
            'id_usuario' => $idUsuario,
            'id_receta' => $idReceta
        ])
        ->first();
}

public function obtenerResenas(
        $idReceta
    )
    {
        $resenaModel =
            new ResenaModel();

        return $resenaModel
            ->obtenerResenas(
                $idReceta
            );
    }

    public function buscarResena(
        $idResena
    )
    {
        $resenaModel =
            new ResenaModel();

        return $resenaModel
            ->find(
                $idResena
            );
    }

    ///renking de reseñas
       public function obtenerRankingResenas($limiteResena )
    {
        $resenaModel = new ResenaModel();

        return $resenaModel
            ->obtenerRankingResenasSP($limiteResena);
    }




}