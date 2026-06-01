<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\VotoResenaModel;
use App\Models\VotoRecetaModel;
use App\Models\ResenaModel;

class VotoReceta extends BaseController
{


/////////// VALORAR RECETA

public function valorarReceta()
{
    $idReceta = $this->request->getPost('id_receta');

 $usuarioController = new Usuario();

$usuarioValido = $usuarioController->verificarUsuario();

if (!$usuarioValido) {

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'error_voto',
            'Debes iniciar sesión para votar esta receta'
        );
}

    $idUsuario = session()->get('id_usuario');
    $tipoVoto  = $this->request->getPost('tipo_voto');

    $this->verificarVotoUsuario(
        $idUsuario,
        $idReceta,
        $tipoVoto
    );

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'success_voto',
            'Voto registrado correctamente'
        );
}
private function verificarVotoUsuario(
    $idUsuario,
    $idReceta,
    $tipoVoto
)
{
    $votoModel = new VotoRecetaModel();

    $votoExistente = $votoModel
        ->where([
            'id_usuario' => $idUsuario,
            'id_receta'  => $idReceta
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
    $votoModel = new VotoRecetaModel();

    if ($votoExistente) {

        $votoModel
            ->where('id_usuario', $idUsuario)
            ->where('id_receta', $idReceta)
            ->set([
                'tipo_voto' => $tipoVoto
            ])
            ->update();

    } else {

        $votoModel->insert([
            'id_usuario' => $idUsuario,
            'id_receta'  => $idReceta,
            'tipo_voto'  => $tipoVoto
        ]);
    }

  $recetaController = new Receta();

return $recetaController
->actualizarContadorVotos($idReceta);

}





}