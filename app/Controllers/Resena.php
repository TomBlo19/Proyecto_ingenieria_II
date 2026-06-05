<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\ResenaModel;

class Resena extends BaseController
{
    /////receta detalle  
   public function obtenerResenas($idReceta)
{
    $resenaModel = new ResenaModel();

    return $resenaModel
        ->obtenerResenas($idReceta);
}
// RESEÑAS
public function guardarResena(
    $idUsuario,
    $idReceta,
    $textoResena
)
{
    if (
        $this->usuarioYaComento(
            $idUsuario,
            $idReceta
        )
    ) {
        return false;
    }

    return $this->registrarResena(
        $idUsuario,
        $idReceta,
        $textoResena
    );
}
public function usuarioYaComento(
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
///votos reseña
public function actualizarContadorVotosResena($idResena)
{
    $resenaModel = new ResenaModel();

    $resenaModel->actualizarContadorVotosSP(
        $idResena
    );
}

// raking de reseña

    public function obtenerRankingResenas($limite )
    {
        $resenaModel = new ResenaModel();

        return $resenaModel
            ->select('resena.*, receta.titulo_receta, receta.id_receta')
            ->join('receta', 'receta.id_receta = resena.id_receta')
            ->orderBy('cant_likes', 'DESC')
            ->findAll($limite);
    }

}