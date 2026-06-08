<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;

class Categoria extends BaseController
{

  
/////////buscar por categoria
public function validarCategoria($idCategoria)
{
    return $this->buscarCategoria(
        $idCategoria
    ) !== null;
}

private function buscarCategoria($idCategoria)
{
    $model = new CategoriaModel();

    return $model->find($idCategoria);
}

 
public function obtenerRankingPorCategoria($limitePorCategoria)
{
    $categoriaModel =new CategoriaModel();

    $categorias =$categoriaModel->findAll();

    $recetaModel =new RecetaModel();

    $ranking = [];

    foreach ($categorias as $categoria) {

        $topRecetas =
            $recetaModel
                ->where(
                    'id_categoria',
                    $categoria['id_categoria']
                )
                ->orderBy(
                    'cant_likes',
                    'DESC'
                )
                ->findAll(
                    $limitePorCategoria
                );

        if (!empty($topRecetas)) {

            $ranking[
                $categoria['nombre_categoria']
            ] = $topRecetas;
        }
    }

    return $ranking;



}

 
}