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
    ////inicio recetas

     public function inicio()
    {
        $data['ranking_recetas'] = $this->obtenerRankingRecetas();

       
    $resenaController = new Resena();

    $data['ranking_resenas'] =
        $resenaController->obtenerRankingResenas();

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

    private function obtenerRecetasRecientes($limite = 6)
    {
        $recetaModel = new RecetaModel();

        return $recetaModel
            ->orderBy('id_receta', 'DESC')
            ->findAll($limite);
    }
    /////receta detalle
 public function detalle($id)
{
    $model = new RecetaModel();

    $data['receta'] = $model->find($id);

$ingredienteController = new Ingrediente();

$data['ingredientes'] =
    $ingredienteController
        ->obtenerIngredientesReceta($id);

    $resenaController = new Resena();

$data['resenas'] = $resenaController->obtenerResenas($id);

$data['ya_comento'] = $resenaController->usuarioYaComento($id);

    return view('contenido/receta_detalle', $data);
}





/////
public function mostrarFormularioReceta()
{
    return view('contenido/crear_receta');
}

//////////////////////// REGISTRAR RECETA 


public function guardarReceta()
{
    $datos = $this->validarReceta();

    if ($datos === false) {

        return view('contenido/crear_receta', [
            'validation' => $this->validator
        ]);
    }

    return $this->registrarReceta(
        $datos['titulo'],
        $datos['descripcion'],
        $datos['ingredientes'],
        $datos['categoria'],
        $datos['imagen']
    );
}


private function validarReceta()
{
    $titulo = $this->request->getPost('titulo');
    $descripcion = $this->request->getPost('descripcion');
    $ingredientes = $this->request->getPost('ingredientes');
    $idCategoria = $this->request->getPost('categoria');
    $imagen = $this->request->getFile('imagen');

    if (!$this->validate([

        'titulo' => [
            'rules' => 'required|min_length[3]',
            'errors' => [
                'required'   => 'El título es obligatorio.',
                'min_length' => 'El título debe tener al menos 3 caracteres.'
            ]
        ],

        'descripcion' => [
            'rules' => 'required|min_length[10]',
            'errors' => [
                'required'   => 'La descripción es obligatoria.',
                'min_length' => 'La descripción debe tener al menos 10 caracteres.'
            ]
        ],

        'ingredientes' => [
            'rules' => 'required|min_length[5]',
            'errors' => [
                'required'   => 'Los ingredientes son obligatorios.',
                'min_length' => 'Ingresá ingredientes más detallados.'
            ]
        ],

        'categoria' => [
            'rules' => 'required',
            'errors' => [
                'required' => 'Debes seleccionar una categoría.'
            ]
        ],

        'imagen' => [
            'rules' => 'uploaded[imagen]|is_image[imagen]',
            'errors' => [
                'uploaded' => 'Debes seleccionar una imagen.',
                'is_image' => 'El archivo debe ser una imagen válida.'
            ]
        ]

    ])) {

        return false;
    }

    return [
        'titulo' => $titulo,
        'descripcion' => $descripcion,
        'ingredientes' => $ingredientes,
        'categoria' => $idCategoria,
        'imagen' => $imagen
    ];
}



private function registrarReceta($titulo, $descripcion, $ingredientes, $idCategoria, $imagen)
{
    $model = new RecetaModel();

    $nombreImagen = $imagen->getRandomName();
    $imagen->move('assets/uploads/', $nombreImagen);

    $model->insert([
        'titulo_receta' => $titulo,
        'descripcion_receta' => $descripcion,
        'imagen_receta' => $nombreImagen,
        'id_usuario' => session()->get('id_usuario'),
        'id_categoria' => $idCategoria
    ]);

    $idReceta = $model->getInsertID();

    $listaIngredientes = explode(',', $ingredientes);

    $this->registrarIngredientesReceta( $idReceta, $listaIngredientes);

    session()->setFlashdata('mensaje', 'Receta creada correctamente');

    return redirect()->to('/crear-receta');
}



private function registrarIngredientesReceta(  $idReceta,array $listaIngredientes)
{
    $relacionModel = new RecetaIngredienteModel();

    foreach ($listaIngredientes as $nombre) {

        $nombre = trim($nombre);

        if ($nombre == '') {
            continue;
        }

        $ingredienteController = new Ingrediente();

        $idIngrediente =
            $ingredienteController
                ->obtenerIngrediente($nombre);

        $relacionModel->insert([
            'id_receta' => $idReceta,
            'id_ingrediente' => $idIngrediente
        ]);
    }
}





    // MÉTODOS DEL RANKING DE RECETAS
    
   public function ranking()
{
    $categoriaController = new Categoria();

    $data['ranking_por_categoria'] =
        $categoriaController->obtenerRankingPorCategoria();

    return view('contenido/ranking_recetas', $data);
}
   

   public function obtenerTopRecetasDeCategoria($idCategoria, $limite)
{
    $recetaModel = new RecetaModel();

    return $recetaModel
        ->where('id_categoria', $idCategoria)
        ->orderBy('cant_likes', 'DESC')
        ->findAll($limite);
}


////////////////////////////////////////////
    public function index()
{
    $model = new RecetaModel();

    $data['recetas'] = $model->findAll();

    return view('contenido/recetas', $data);
}

 


    public function guardados()
    {
        return view('contenido/guardados');
    }

///contador de votos

public function actualizarContadorVotos($idReceta)
{
$votoModel = new VotoRecetaModel();


$likes = $votoModel->contarVotos($idReceta, 1);
$dislikes = $votoModel->contarVotos($idReceta, 0);

$recetaModel = new RecetaModel();

$recetaModel->update($idReceta, [
    'cant_likes' => $likes,
    'cant_dislikes' => $dislikes
]);

}

}