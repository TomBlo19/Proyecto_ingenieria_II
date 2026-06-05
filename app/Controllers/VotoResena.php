<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\VotoResenaModel;
use App\Models\VotoRecetaModel;
use App\Models\ResenaModel;
use App\Models\UsuarioModel; 
class VotoResena extends BaseController
{

public function votarResena(
    $idUsuario,
    $idResena,
    $tipoVoto
)
{
    return $this->verificarVotoResena(
        $idUsuario,
        $idResena,
        $tipoVoto
    );
}



private function verificarVotoResena(
    $idUsuario,
    $idResena,
    $tipoVoto
)
{
    $votoResenaModel = new VotoResenaModel();

    $votoExistente = $votoResenaModel
        ->where([
            'id_usuario' => $idUsuario,
            'id_resena'  => $idResena
        ])
        ->first();

    return $this->guardarVotoResena(
        $idUsuario,
        $idResena,
        $tipoVoto,
        $votoExistente
    );
}



private function guardarVotoResena(
    $idUsuario,
    $idResena,
    $tipoVoto,
    $votoExistente
)
{
    $votoResenaModel =
        new VotoResenaModel();

    if ($votoExistente) {

        $votoResenaModel
            ->where(
                'id_usuario',
                $idUsuario
            )
            ->where(
                'id_resena',
                $idResena
            )
            ->set([
                'tipo_voto' => $tipoVoto
            ])
            ->update();

    } else {

        $votoResenaModel->insert([
            'id_usuario' => $idUsuario,
            'id_resena' => $idResena,
            'tipo_voto' => $tipoVoto
        ]);
    }

    return true;
}


}