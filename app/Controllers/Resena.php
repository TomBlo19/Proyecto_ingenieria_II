<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\ResenaModel;
use App\Models\VotoResenaModel;

class Resena extends BaseController
{
   
// RESEÑAS

////// registar reseña
public function guardarResena(
    $idUsuario,
    $idReceta,
    $textoResena
)
{
    return $this->registrarResena(
        $idUsuario,
        $idReceta,
        $textoResena
    );
}



private function registrarResena(
    $idUsuario,
    $idReceta,
    $textoResena
)
{
    $resenaModel = new ResenaModel();

    $resenaModel->insert([
        'id_receta'         => $idReceta,
        'id_usuario'        => $idUsuario,
        'titulo_resena'     => 'Opinión',
        'comentario_resena' => $textoResena,
        'cant_likes'        => 0,
        'cant_dislikes'     => 0
    ]);

    return true;
}

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
       public function obtenerRankingResenas($limite )
    {
        $resenaModel = new ResenaModel();

        return $resenaModel
            ->obtenerRankingResenasSP($limite);
    }


public function actualizarContadorVotosResena($idResena)
{
    $resenaModel = new ResenaModel();

    $resenaModel->actualizarContadorVotosSP(
        $idResena
    );
}



}