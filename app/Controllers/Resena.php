<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\ResenaModel;
use App\Models\VotoResenaModel;

class Resena extends BaseController
{
   
// RESEÑAS



public function actualizarContadorVotosResena($idResena)
{
    $resenaModel = new ResenaModel();

    $resenaModel->actualizarContadorVotosSP(
        $idResena
    );
}



}