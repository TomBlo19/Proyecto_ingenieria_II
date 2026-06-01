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
    /////receta detalle
 public function detalle($id)
{
    $model = new RecetaModel();

    $data['receta'] = $model->find($id);

    $data['ingredientes'] = $this->obtenerIngredientes($id);

    $resenaController = new Resena();

$data['resenas'] = $resenaController->obtenerResenas($id);

$data['ya_comento'] = $resenaController->usuarioYaComento($id);

    return view('contenido/receta_detalle', $data);
}

private function obtenerIngredientes($idReceta)
{
    $db = \Config\Database::connect();

    return $db->table('receta_ingrediente ri')
        ->select('i.nombre_ingrediente')
        ->join('ingrediente i', 'i.id_ingrediente = ri.id_ingrediente')
        ->where('ri.id_receta', $idReceta)
        ->get()
        ->getResultArray();
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

    $this->registrarIngredientesReceta($idReceta, $ingredientes);

    session()->setFlashdata('mensaje', 'Receta creada correctamente');

    return redirect()->to('/crear-receta');
}



private function registrarIngredientesReceta($idReceta, $ingredientes)
{
    $relacionModel = new RecetaIngredienteModel();

    $listaIngredientes = explode(',', $ingredientes);

    foreach ($listaIngredientes as $item) {

        $nombre = trim($item);

        if ($nombre == '') continue;

        $idIngrediente = $this->obtenerIngrediente($nombre);

        $relacionModel->insert([
            'id_receta' => $idReceta,
            'id_ingrediente' => $idIngrediente
        ]);
    }
}



private function obtenerIngrediente($nombre)
{
    $model = new IngredienteModel();

    $ingrediente = $model
        ->where('nombre_ingrediente', $nombre)
        ->first();

    if ($ingrediente) {

        return $ingrediente['id_ingrediente'];
    }

    return $this->registrarIngrediente($nombre);
}



private function registrarIngrediente($nombre)
{
    $model = new IngredienteModel();

    $model->insert([
        'nombre_ingrediente' => $nombre
    ]);

    return $model->getInsertID();
}


    // MÉTODOS DEL RANKING DE RECETAS
    
    public function ranking()
    {
        $data['ranking_por_categoria'] = $this->obtenerRankingPorCategoria();

        return view('contenido/ranking_recetas', $data);
    }

    private function obtenerRankingPorCategoria($limitePorCategoria = 10)
    {
        $categorias = $this->obtenerTodasLasCategorias();
        $ranking = [];

        foreach ($categorias as $categoria) {
            $topRecetas = $this->obtenerTopRecetasDeCategoria($categoria['id_categoria'], $limitePorCategoria);

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

    private function obtenerTopRecetasDeCategoria($idCategoria, $limite)
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



}