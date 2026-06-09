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

     
   public function obtenerRankingRecetas($limiteReceta)
{
    $recetaModel = new RecetaModel();

    return $recetaModel
        ->obtenerRankingRecetasSP(
            $limiteReceta
        );
}

    public  function obtenerRecetasRecientes($limiteReceta )
    {
        $recetaModel = new RecetaModel();

        return $recetaModel
            ->orderBy('id_receta', 'DESC')
            ->findAll($limiteReceta);
    }
    public function buscarReceta($idReceta)
{
    $recetaModel =
        new RecetaModel();

    return $recetaModel
        ->find($idReceta);
}

     public function buscarRecetasPorNombre(
        $nombre
    )
    {
        $recetaModel =
            new RecetaModel();

        return $recetaModel
            ->like(
                'titulo_receta',
                $nombre
            )
            ->findAll();
    }


}