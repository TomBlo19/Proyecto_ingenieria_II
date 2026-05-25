<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\ResenaModel;

class Home extends BaseController
{
    public function inicio()
    {
        $data['ranking_recetas'] = $this->obtenerRankingRecetas();

        $data['ranking_resenas'] = $this->obtenerRankingResenas();

        $data['recetas_recientes'] = $this->obtenerRecetasRecientes();

        return view('contenido/home', $data);
    }



    private function obtenerRankingRecetas($limite = 6)
    {
        $recetaModel = new RecetaModel();

        return $recetaModel
            ->orderBy('cant_likes', 'DESC')
            ->findAll($limite);
    }



    private function obtenerRankingResenas($limite = 3)
    {
        $resenaModel = new ResenaModel();

        return $resenaModel
            ->select('resena.*, receta.titulo_receta, receta.id_receta')
            ->join('receta', 'receta.id_receta = resena.id_receta')
            ->orderBy('cant_likes', 'DESC')
            ->findAll($limite);
    }



    private function obtenerRecetasRecientes($limite = 6)
    {
        $recetaModel = new RecetaModel();

        return $recetaModel
            ->orderBy('id_receta', 'DESC')
            ->findAll($limite);
    }
}