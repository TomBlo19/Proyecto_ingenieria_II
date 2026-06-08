<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;

class Buscador extends BaseController
{

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

    public function buscarRecetasPorCategoria(
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

public function buscarRecetasPorIngrediente(
    $ingrediente
)
{
    return [];
}
    }
