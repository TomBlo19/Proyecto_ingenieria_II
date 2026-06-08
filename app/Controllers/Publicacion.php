<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\ResenaModel;

class Publicacion extends BaseController
{
    public function obtenerDetallePublicacion(
        $idReceta
    )
    {
        $recetaModel =new RecetaModel();

        $ingredienteModel =new IngredienteModel();

        $resenaModel =new ResenaModel();

        $receta =$recetaModel->find($idReceta);

        $ingredientes =
            $ingredienteModel
                ->obtenerIngredientesReceta( $idReceta);

        $resenas =
            $resenaModel
                ->obtenerResenas($idReceta);
        $yaComento = false;

        if (session()->get('isLoggedIn')) {
            $yaComento =
                $resenaModel
                    ->where([
                        'id_usuario' => session()->get('id_usuario'),
                        'id_receta' => $idReceta])
                    ->first();
        }

        return [
            'receta'       => $receta,
            'ingredientes' => $ingredientes,
            'resenas'      => $resenas,
            'ya_comento'   => $yaComento
        ];
    }

public function obtenerPublicacionDesdeResena(
    $idReceta,
    $idResena
)
{
    $recetaModel =
        new RecetaModel();

    $resenaModel =
        new ResenaModel();

    $receta =
        $recetaModel->find(
            $idReceta
        );

    $resena =
        $resenaModel->find(
            $idResena
        );

    return [
        'receta' => $receta,
        'resena' => $resena
    ];
}

    }
 


