<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\ResenaModel;

class Publicacion extends BaseController
{
   
public function publicarReceta(
    $titulo,
    $descripcion,
    $ingredientes,
    $idCategoria,
    $imagen
)
{
    $datos = $this->validarPublicacionReceta(
        $titulo,
        $descripcion,
        $ingredientes,
        $idCategoria,
        $imagen
    );

    if ($datos !== true) {

        return view(
            'contenido/crear_receta',
            ['errores' => $datos]
        );
    }

    return $this->registrarPublicacionReceta(
        $titulo,
        $descripcion,
        $idCategoria,
        $imagen
    );
}
private function validarPublicacionReceta(
    $titulo,
    $descripcion,
    $ingredientes,
    $idCategoria,
    $imagen
)
{
    $errores = [];

  
    if (empty(trim($titulo))) {

        $errores['titulo'] =
            'El título es obligatorio.';

    } elseif (strlen(trim($titulo)) < 3) {

        $errores['titulo'] =
            'El título debe tener al menos 3 caracteres.';
    }

   
    if (empty(trim($descripcion))) {

        $errores['descripcion'] =
            'La descripción es obligatoria.';

    } elseif (strlen(trim($descripcion)) < 10) {

        $errores['descripcion'] =
            'La descripción debe tener al menos 10 caracteres.';
    }

  
    if (empty(trim($ingredientes))) {

        $errores['ingredientes'] =
            'Los ingredientes son obligatorios.';

    } elseif (strlen(trim($ingredientes)) < 5) {

        $errores['ingredientes'] =
            'Ingresá ingredientes más detallados.';
    }

  
    if (empty($idCategoria)) {

        $errores['categoria'] =
            'Debes seleccionar una categoría.';
    }

    if (!$imagen || !$imagen->isValid()) {

        $errores['imagen'] =
            'Debes seleccionar una imagen válida.';
    }

    return empty($errores)
        ? true
        : $errores;
}
private function registrarPublicacionReceta(
    $titulo,
    $descripcion,
    $idCategoria,
    $imagen
)
{
    $model = new RecetaModel();

    $nombreImagen = $imagen->getRandomName();

    $imagen->move(
        'assets/uploads/',
        $nombreImagen
    );

    $model->insert([
        'titulo_receta'      => $titulo,
        'descripcion_receta' => $descripcion,
        'imagen_receta'      => $nombreImagen,
        'id_usuario'         => session()->get('id_usuario'),
        'id_categoria'       => $idCategoria
    ]);

    return $model->getInsertID();
}



// RESEÑAS

////// registar reseña
public function publicarResena(
    $idUsuario,
    $idReceta,
    $textoResena
)
{
    return $this-> registrarPublicacioResena(
        $idUsuario,
        $idReceta,
        $textoResena
    );
}



private function  registrarPublicacioResena(
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
    }
 


