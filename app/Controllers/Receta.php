<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\RecetaIngredienteModel;
use App\Models\VotoRecetaModel;
use App\Models\CategoriaModel;
use App\Models\ResenaModel;
use App\Models\VotoResenaModel;

class Receta extends BaseController
{
  

   
//////////////////////// REGISTRAR RECETA 

public function guardarReceta(
    $titulo,
    $descripcion,
    $ingredientes,
    $idCategoria,
    $imagen
)
{
    $datos = $this->validarReceta(
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

    return $this->registrarReceta(
        $titulo,
        $descripcion,
        $idCategoria,
        $imagen
    );
}
private function validarReceta(
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
private function registrarReceta(
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


public function registrarIngredienteReceta(
    $idReceta,
    $idIngrediente
)
{
    $relacionModel = new RecetaIngredienteModel();

    $relacionModel->insert([
        'id_receta'      => $idReceta,
        'id_ingrediente' => $idIngrediente
    ]);
}

///obtener receta 

     public function obtenerRecetasOrdenadas( $tipoOrden )
{
    $model = new RecetaModel();

    $builder =
        $model->builder();

    if ($tipoOrden === 'likes') {

        $estrategia =
            new \App\Libraries\Ordenamiento\OrdenarPorLikes();

    } elseif (
        $tipoOrden === 'alfabetico'
    ) {

        $estrategia =
            new \App\Libraries\Ordenamiento\OrdenarAlfabeticamente();

    } else {

        $estrategia =
            new \App\Libraries\Ordenamiento\OrdenarPorFecha();
    }

    $builder =
        $estrategia->ordenar(
            $builder
        );

    return $builder
        ->get()
        ->getResultArray();
}

public function obtenerRecetasPorCategoria(
    $idCategoria
)
{
    $recetaModel =
        new RecetaModel();

    return $recetaModel
        ->where(
            'id_categoria',
            $idCategoria
        )
        ->findAll();
}

//kanging

     
   public function obtenerRankingRecetas($limite)
{
    $recetaModel = new RecetaModel();

    return $recetaModel
        ->obtenerRankingRecetasSP(
            $limite
        );
}

    public  function obtenerRecetasRecientes($limite )
    {
        $recetaModel = new RecetaModel();

        return $recetaModel
            ->orderBy('id_receta', 'DESC')
            ->findAll($limite);
    }

///contador de votos

public function actualizarContadorVotosReceta($idReceta)
{
    $recetaModel = new RecetaModel();

    $recetaModel
        ->actualizarContadorVotosSP(
            $idReceta
        );
}

}