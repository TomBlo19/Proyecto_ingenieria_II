<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\RecetaIngredienteModel;
use App\Models\VotoRecetaModel;
use App\Models\CategoriaModel;
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
//////////////////////// REGISTRAR RECETA 

public function registrarReceta()
{
    $validacion = $this->validarReceta();

    if ($validacion !== true) {
        return $validacion;
    }

    $model = new RecetaModel();

    $archivo = $this->request->getFile('imagen');
    $nombreImagen = $archivo->getRandomName();
    $archivo->move('assets/uploads/', $nombreImagen);

    $model->insert([
        'titulo_receta' => $this->request->getPost('titulo'),
        'descripcion_receta' => $this->request->getPost('descripcion'),
        'imagen_receta' => $nombreImagen,
        'id_usuario' => session()->get('id_usuario'),
        'id_categoria' => $this->request->getPost('categoria')
    ]);

    $idReceta = $model->getInsertID();

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

        return view('contenido/crear_receta', [
            'categorias' => $db->table('categoria')->get()->getResultArray(),
            'validation' => $this->validator
        ]);
    }

   
    $idCategoria = $this->request->getPost('categoria');

    $categoria = $this->obtenerCategoria($idCategoria);

    if (!$categoria) {
        return redirect()->back()->with('error', 'La categoría seleccionada no es válida.');
    }

    return true;
}

private function obtenerCategoria($id)
{
    $db = \Config\Database::connect();

    return $db->table('categoria')
              ->where('id_categoria', $id)
              ->get()
              ->getRowArray();
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
////////////////////////////////////////////
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
/////buscar por categoria 
public function verCategoria($id)
{
    $categoria = $this->buscarCategoria($id);

    $model = new RecetaModel();

    $data['categoria'] = $categoria;
    $data['recetas'] = $model
        ->where('id_categoria', $id)
        ->findAll();

    return view('contenido/recetas', $data);
}

private function buscarCategoria($id)
{
    $db = \Config\Database::connect();

    return $db->table('categoria')
        ->where('id_categoria', $id)
        ->get()
        ->getRowArray();
}

    public function guardados()
    {
        return view('contenido/guardados');
    }


///////////valorar receta 

public function verificarUsuario()
{
    $idReceta = $this->request->getPost('id_receta');

    if (!session()->get('isLoggedIn')) {
        return redirect()
            ->to('/receta/' . $idReceta)
            ->with('error_voto', 'Debes iniciar sesión para votar esta receta');
    }

    $idUsuario = session()->get('id_usuario');
    $tipoVoto = $this->request->getPost('tipo_voto');

    // 🔥 NO hace todo, delega
    return $this->verificarVotoUsuario($idUsuario, $idReceta, $tipoVoto);
}

private function verificarVotoUsuario($idUsuario, $idReceta, $tipoVoto)
{
    $votoModel = new VotoRecetaModel();

    $votoExistente = $votoModel
        ->where(['id_usuario' => $idUsuario, 'id_receta' => $idReceta])
        ->first();

    return $this->guardarOActualizarVoto($idUsuario, $idReceta, $tipoVoto, $votoExistente);
}

private function guardarOActualizarVoto($idUsuario, $idReceta, $tipoVoto, $votoExistente)
{
    $votoModel = new VotoRecetaModel();

    if ($votoExistente) {
        $votoModel->where('id_usuario', $idUsuario)
                  ->where('id_receta', $idReceta)
                  ->set(['tipo_voto' => $tipoVoto])
                  ->update();
    } else {
        $votoModel->insert([
            'id_usuario' => $idUsuario,
            'id_receta'  => $idReceta,
            'tipo_voto'  => $tipoVoto
        ]);
    }

    return $this->actualizarContadorVotos($idReceta);
}

private function actualizarContadorVotos($idReceta)
{
    $db = \Config\Database::connect();

    $likes = $db->table('voto_receta')
        ->where(['id_receta' => $idReceta, 'tipo_voto' => 1])
        ->countAllResults();

    $dislikes = $db->table('voto_receta')
        ->where(['id_receta' => $idReceta, 'tipo_voto' => 0])
        ->countAllResults();

    $recetaModel = new RecetaModel();
    $recetaModel->update($idReceta, [
        'cant_likes' => $likes,
        'cant_dislikes' => $dislikes
    ]);

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with('success_voto', 'Voto registrado correctamente');
}

}