<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Controllers\Receta;
use App\Controllers\Categoria;
use App\Controllers\Ingrediente;
use App\Controllers\Resena;
use App\Models\RecetaModel;
use App\Models\UsuarioModel; 
use App\Models\VotoResenaModel;
use App\Models\CategoriaModel;
class ResenaApi extends BaseController
{

public function guardarResena()
{
    $idUsuario =
        session()->get(
            'id_usuario'
        );

    $idReceta =
        $this->request->getPost(
            'id_receta'
        );

    $textoResena =
        $this->request->getPost(
            'texto_resena'
        );

    if (!session()->get('isLoggedIn')) {

        return redirect()
            ->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Debes iniciar sesión para comentar'
            );
    }

    $usuarioController =
        new \App\Controllers\Usuario();

    $usuarioValido =
        $usuarioController
            ->verificarUsuario(
                $idUsuario
            );

    if (!$usuarioValido) {

        return redirect()
            ->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Usuario inválido.'
            );
    }

    $resenaController =
        new \App\Controllers\Resena();

    $resultado =
        $resenaController
            ->guardarResena(
                $idUsuario,
                $idReceta,
                $textoResena
            );

    if (!$resultado) {

        return redirect()
            ->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Solo puedes dejar una reseña por receta.'
            );
    }

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'success_voto',
            '¡Tu reseña fue publicada con éxito!'
        );
}
public function votarResena()
{
    $idResena =
        $this->request->getPost(
            'id_resena'
        );

    $idReceta =
        $this->request->getPost(
            'id_receta'
        );

    $tipoVoto =
        $this->request->getPost(
            'tipo_voto'
        );

    $idUsuario =
        session()->get(
            'id_usuario'
        );

    if (!session()->get('isLoggedIn')) {

        return redirect()
            ->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Debes iniciar sesión'
            );
    }

    $usuarioController =
        new \App\Controllers\Usuario();

    $usuarioValido =
        $usuarioController
            ->verificarUsuario(
                $idUsuario
            );

    if (!$usuarioValido) {

        return redirect()
            ->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Usuario inválido.'
            );
    }

    $votoController =
        new \App\Controllers\VotoResena();

    $votoController->votarResena(
        $idUsuario,
        $idResena,
        $tipoVoto
    );

    $resenaController =
        new \App\Controllers\Resena();

    $resenaController
        ->actualizarContadorVotosResena(
            $idResena
        );

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'success_voto',
            'Voto registrado correctamente'
        );
}


}