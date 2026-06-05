<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\VotoResenaModel;
use App\Models\VotoRecetaModel;
use App\Models\ResenaModel;
use App\Models\UsuarioModel; 
class VotoReceta extends BaseController
{

/////////// VALORAR RECETA
public function valorarReceta(
    $idUsuario,
    $idReceta,
    $tipoVoto
)
{
    return $this->verificarVotoUsuario(
        $idUsuario,
        $idReceta,
        $tipoVoto
    );
}

private function verificarVotoUsuario(
    $idUsuario,
    $idReceta,
    $tipoVoto
)
{
    $votoModel =
        new VotoRecetaModel();

    $votoExistente =
        $votoModel
            ->where([
                'id_usuario' => $idUsuario,
                'id_receta' => $idReceta
            ])
            ->first();

    return $this->guardarVoto(
        $idUsuario,
        $idReceta,
        $tipoVoto,
        $votoExistente
    );
}
private function guardarVoto(
    $idUsuario,
    $idReceta,
    $tipoVoto,
    $votoExistente
)
{
    $votoModel =
        new VotoRecetaModel();

    if ($votoExistente) {

        $votoModel
            ->where(
                'id_usuario',
                $idUsuario
            )
            ->where(
                'id_receta',
                $idReceta
            )
            ->set([
                'tipo_voto' => $tipoVoto
            ])
            ->update();

    } else {

        $votoModel->insert([
            'id_usuario' => $idUsuario,
            'id_receta' => $idReceta,
            'tipo_voto' => $tipoVoto
        ]);
    }

    return true;
}

}