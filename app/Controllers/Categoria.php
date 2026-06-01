<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;

class Categoria extends BaseController
{

  public function categorias()
{
    $model = new CategoriaModel();
    
    $data['categorias'] = $model->findAll(); 

    return view('contenido/categorias', $data);
}

/////////buscar por categoria


public function verRecetas($id){
    
    $categoria = $this->validarCategoria($id);

    $model = new RecetaModel();

    $recetas = $model
        ->where('id_categoria', $id)
        ->findAll();

    return view('contenido/recetas', [
        'categoria' => $categoria,
        'recetas' => $recetas
    ]);
}

private function validarCategoria($id)
{
    $categoria = $this->buscarCategoria($id);

    if (!$categoria) {
        return redirect()->to('/categorias')
            ->with('error', 'La categoría seleccionada no existe.');
    }

    return $categoria;
}

private function buscarCategoria($id)
{
   $model = new CategoriaModel();
    
    return $model->find($id);
}

/////////////////////////// REGISTRAR RECETA 

public function obtenerCategorias()
{
    $model = new CategoriaModel();
    return $this->response->setJSON($model->findAll());
}

//racking
public function obtenerRankingPorCategoria($limitePorCategoria = 10)
{
    $categorias = $this->obtenerTodasLasCategorias();
    $ranking = [];

    $recetaController = new Receta();

    foreach ($categorias as $categoria) {

        $topRecetas = $recetaController
            ->obtenerTopRecetasDeCategoria(
                $categoria['id_categoria'],
                $limitePorCategoria
            );

        if (!empty($topRecetas)) {
            $ranking[$categoria['nombre_categoria']] = $topRecetas;
        }
    }

    return $ranking;
}

    private function obtenerTodasLasCategorias()
    {
        $categoriaModel = new CategoriaModel();
        
        return $categoriaModel->findAll();
    }
}