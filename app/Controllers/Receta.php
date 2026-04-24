<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\RecetaIngredienteModel;

class Receta extends BaseController
{
 public function detalle($id)
{
    $model = new RecetaModel();

    $db = \Config\Database::connect();

    $ingredientes = $db->table('receta_ingrediente ri')
        ->select('i.nombre_ingrediente')
        ->join('ingrediente i', 'i.id_ingrediente = ri.id_ingrediente')
        ->where('ri.id_receta', $id)
        ->get()
        ->getResultArray();

    $data['receta'] = $model->find($id);
    $data['ingredientes'] = $ingredientes;

    return view('contenido/receta_detalle', $data);
}

  public function crear()
{
    $db = \Config\Database::connect();

    $data['categorias'] = $db->table('categoria')->get()->getResultArray();

    return view('contenido/crear_receta', $data);

}


public function guardarReceta()
{
    if ($respuesta = $this->validarReceta()) {
        return $respuesta;
    }

    $categoria = $this->obtenerCategoriaReceta();

    $idReceta = $this->registrarReceta($categoria);

    $this->registrarIngredientesReceta($idReceta);

    session()->setFlashdata('mensaje', 'Receta creada correctamente');

    return redirect()->to('/crear-receta');
}

private function validarReceta()
{
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

        $db = \Config\Database::connect();

        $data['categorias'] = $db->table('categoria')->get()->getResultArray();
        $data['validation'] = $this->validator;

        return view('contenido/crear_receta', $data);
    }

    return false;
}


private function registrarReceta($categoria)
{
    $model = new RecetaModel();

    $archivo = $this->request->getFile('imagen');
    $nombreImagen = $archivo->getRandomName();
    $archivo->move('assets/uploads/', $nombreImagen);

    $model->insert([
        'titulo_receta' => $this->request->getPost('titulo'),
        'descripcion_receta' => $this->request->getPost('descripcion'),
        'imagen_receta' => $nombreImagen,
        'id_usuario' => session()->get('id_usuario'),
        'id_categoria' => $categoria
    ]);

    return $model->getInsertID();
}

private function obtenerCategoriaReceta()
{
    return $this->request->getPost('categoria');
}

private function registrarIngredientesReceta($idReceta)
{
    $ingredienteModel = new IngredienteModel();
    $relacionModel = new RecetaIngredienteModel();

    $ingredientes = explode(',', $this->request->getPost('ingredientes'));

    foreach ($ingredientes as $item) {
        $nombre = trim($item);

        if ($nombre == '') continue;

        $ingrediente = $ingredienteModel
            ->where('nombre_ingrediente', $nombre)
            ->first();

        if (!$ingrediente) {
            $ingredienteModel->insert([
                'nombre_ingrediente' => $nombre
            ]);

            $idIngrediente = $ingredienteModel->getInsertID();
        } else {
            $idIngrediente = $ingrediente['id_ingrediente'];
        }

        $relacionModel->insert([
            'id_receta' => $idReceta,
            'id_ingrediente' => $idIngrediente
        ]);
    }
}


    public function index()
{
    $model = new RecetaModel();

    $data['recetas'] = $model->findAll();

    return view('contenido/recetas', $data);
}

   public function categorias()
{
    $db = \Config\Database::connect();

    $data['categorias'] = $db->table('categoria')->get()->getResultArray();

    return view('contenido/categorias', $data);
}

public function verCategoria($id)
{
    $model = new RecetaModel();

    $data['recetas'] = $model
        ->where('id_categoria', $id)
        ->findAll();

    return view('contenido/recetas', $data);
}

    public function guardados()
    {
        return view('contenido/guardados');
    }
}