<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\RecetaIngredienteModel;
use App\Models\VotoRecetaModel;
use App\Models\CategoriaModel;
use App\Models\ResenaModel;
use App\Models\VotoResenaModel;

class Buscador  extends BaseController
{
    ////inicio recetas

     
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


     public function obtenerRecetasOrdenadas(
    $tipoOrden
)
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
//buscar receta por categoria
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


    // raking de reseña

    public function obtenerRankingResenas($limite )
    {
        $resenaModel = new ResenaModel();

        return $resenaModel
            ->obtenerRankingResenasSP($limite);
    }
    //incrediente
    public function obtenerIngredientesReceta($idReceta)
{
    $model = new IngredienteModel();

    return $model->obtenerIngredientesReceta(
        $idReceta
    );
}

//reseña 
   public function obtenerResenas($idReceta)
{
    $resenaModel = new ResenaModel();

    return $resenaModel
        ->obtenerResenas($idReceta);
}

    } 