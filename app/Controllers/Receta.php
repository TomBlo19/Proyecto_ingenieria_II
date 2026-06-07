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
  
////////////////////////////////////////////
   


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