<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\VotoResenaModel;
use App\Models\VotoRecetaModel;
use App\Models\ResenaModel;

class VotoResena extends BaseController
{


    //// VOTAR RESEÑA

public function votarResena()
{
    $idReceta = $this->request->getPost('id_receta');

    $usuarioController = new Usuario();

   $usuarioValido = $usuarioController->verificarUsuario();

    if ($usuarioValido !== true) {
        return $usuarioValido;
    }

    $idResena = $this->request->getPost('id_resena');

    $idUsuario = session()->get('id_usuario');

    $tipoVoto = $this->request->getPost('tipo_voto');


    $this->verificarVotoResena(
        $idUsuario,
        $idResena,
        $tipoVoto
    );

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'success_voto',
            'Voto registrado correctamente'
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
    $votoResenaModel = new VotoResenaModel();

    if ($votoExistente) {

        $votoResenaModel
            ->where('id_usuario', $idUsuario)
            ->where('id_resena', $idResena)
            ->set([
                'tipo_voto' => $tipoVoto
            ])
            ->update();

    } else {

        $votoResenaModel->insert([
            'id_usuario' => $idUsuario,
            'id_resena'  => $idResena,
            'tipo_voto'  => $tipoVoto
        ]);
    }

   $resenaController = new Resena();

return $resenaController
    ->actualizarContadorVotosResena($idResena);
}


}