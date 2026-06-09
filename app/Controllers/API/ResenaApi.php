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
        session()->get('id_usuario');

    $idReceta =
        $this->request->getPost('id_receta');

    $textoResena =
        $this->request->getPost('texto_resena');

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

    if (
        !$usuarioController
            ->verificarUsuario(
                $idUsuario
            )
    ) {

        return redirect()
            ->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Usuario inválido.'
            );
    }

   $resenaController =
    new \App\Controllers\Resena();

if (
    $resenaController
        ->verificarComentarioUsuario(
            $idUsuario,
            $idReceta
        )
)
    {

        return redirect()
            ->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Solo puedes dejar una reseña por receta.'
            );
    }

    
    $publicacionController =
    new \App\Controllers\Publicacion();

$publicacionController
    ->publicarResena(
        $idUsuario,
        $idReceta,
        $textoResena
    );

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

   $valoracionController =
    new \App\Controllers\Valoracion();

$valoracionController->valorarPublicacion(
    'resena',
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

public function listarResenas()
{
    $resenaModel =
        new \App\Models\ResenaModel();

    $data['resenas'] =
        $resenaModel
            ->orderBy(
                'id_resena',
                'DESC'
            )
            ->findAll();

    return view(
        'contenido/resenas',
        $data
    );
}

public function verResena(
    $idResena
)
{
    $resenaController =
        new \App\Controllers\Resena();

    $resena =
        $resenaController
            ->buscarResena(
                $idResena
            );

   return redirect()->to(
    '/receta/' .
    $resena['id_receta'] .
    '?resena=' .
    $idResena
);

}

}