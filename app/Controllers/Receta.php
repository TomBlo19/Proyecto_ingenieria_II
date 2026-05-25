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
    /////receta detalle
 public function detalle($id)
{
    $model = new RecetaModel();

    $data['receta'] = $model->find($id);

    $data['ingredientes'] = $this->obtenerIngredientes($id);

    $data['resenas'] = $this->obtenerResenas($id);

    $data['ya_comento'] = $this->usuarioYaComento($id);

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

private function obtenerResenas($idReceta)
{
    $db = \Config\Database::connect();

    return $db->table('resena r')
        ->select('r.*, u.nombre_usuario')
        ->join('usuario u', 'u.id_usuario = r.id_usuario')
        ->where('r.id_receta', $idReceta)
        ->orderBy('r.fecha_resena', 'DESC')
        ->get()
        ->getResultArray();
}
private function usuarioYaComento($idReceta) {
     if (!session()->get('isLoggedIn')) { return false; } $resenaModel = new ResenaModel(); 
     return $resenaModel 
     ->where([ 'id_usuario' => session()
     ->get('id_usuario'), 'id_receta' => $idReceta ]) 
     ->first(); }
/////
public function mostrarFormularioReceta()
{
    return view('contenido/crear_receta');
}

//////////////////////// REGISTRAR RECETA 

public function obtenerCategorias()
{
    $model = new CategoriaModel();
    return $this->response->setJSON($model->findAll());
}


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


////////////////////////////////////////////
    public function index()
{
    $model = new RecetaModel();

    $data['recetas'] = $model->findAll();

    return view('contenido/recetas', $data);
}

   public function categorias()
{
    $model = new CategoriaModel();
    
    $data['categorias'] = $model->findAll(); 

    return view('contenido/categorias', $data);
}
/////buscar por categoria


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

    public function guardados()
    {
        return view('contenido/guardados');
    }

/////////// VALORAR RECETA

public function valorarReceta()
{
    $idReceta = $this->request->getPost('id_receta');

    $usuarioValido = $this->verificarUsuario($idReceta);

    if ($usuarioValido !== true) {
        return $usuarioValido;
    }

    $idUsuario = session()->get('id_usuario');
    $tipoVoto  = $this->request->getPost('tipo_voto');

    $this->verificarVotoUsuario(
        $idUsuario,
        $idReceta,
        $tipoVoto
    );

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'success_voto',
            'Voto registrado correctamente'
        );
}



private function verificarUsuario($idReceta)
{
    if (!session()->get('isLoggedIn')) {

        return redirect()
            ->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Debes iniciar sesión para votar esta receta'
            );
    }

    return true;
}



private function verificarVotoUsuario(
    $idUsuario,
    $idReceta,
    $tipoVoto
)
{
    $votoModel = new VotoRecetaModel();

    $votoExistente = $votoModel
        ->where([
            'id_usuario' => $idUsuario,
            'id_receta'  => $idReceta
        ])
        ->first();

    return $this->guardarVoto(
        $idUsuario,
        $idReceta,
        $tipoVoto,
        $votoExistente
    );
}



private function guardarVoto(
    $idUsuario,
    $idReceta,
    $tipoVoto,
    $votoExistente
)
{
    $votoModel = new VotoRecetaModel();

    if ($votoExistente) {

        $votoModel
            ->where('id_usuario', $idUsuario)
            ->where('id_receta', $idReceta)
            ->set([
                'tipo_voto' => $tipoVoto
            ])
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
    $votoModel   = new VotoRecetaModel();
    $recetaModel = new RecetaModel();

    $likes    = $votoModel->contarVotos($idReceta, 1);
    $dislikes = $votoModel->contarVotos($idReceta, 0);

    $recetaModel->update($idReceta, [
        'cant_likes'    => $likes,
        'cant_dislikes' => $dislikes
    ]);
}
    // RESEÑAS


   public function guardarResena()
{
    $idReceta = $this->request->getPost('id_receta');

    $idUsuario = session()->get('id_usuario');

    $textoResena = $this->request->getPost('texto_resena');

    if ($this->usuarioYaComento($idReceta)) {

        return redirect()->to('/receta/' . $idReceta)
            ->with(
                'error_voto',
                'Solo puedes dejar una reseña por receta.'
            );
    }
    $this->registrarResena(
        $idUsuario,
        $idReceta,
        $textoResena
    );

    return redirect()->to('/receta/' . $idReceta)
        ->with(
            'success_voto',
            '¡Tu reseña fue publicada con éxito!'
        );
}

private function registrarResena(
    $idUsuario,
    $idReceta,
    $textoResena
)
{
    $resenaModel = new ResenaModel();

    $resenaModel->insert([
        'id_receta'         => $idReceta,
        'id_usuario'        => $idUsuario,
        'titulo_resena'     => 'Opinión',
        'comentario_resena' => $textoResena,
        'cant_likes'        => 0,
        'cant_dislikes'     => 0
    ]);
}

   

    //// VOTAR RESEÑA

public function votarResena()
{
    $idReceta = $this->request->getPost('id_receta');

    $usuarioValido = $this->verificarUsuario($idReceta);

    if ($usuarioValido !== true) {
        return $usuarioValido;
    }

    $idResena = $this->request->getPost('id_resena');

    $idUsuario = session()->get('id_usuario');

    $tipoVoto = $this->request->getPost('tipo_voto');


    $this->verificarVotoResena(
        $idUsuario,
        $idResena,
        $tipoVoto
    );

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'success_voto',
            'Voto registrado correctamente'
        );
}



private function verificarVotoResena(
    $idUsuario,
    $idResena,
    $tipoVoto
)
{
    $votoResenaModel = new VotoResenaModel();

    $votoExistente = $votoResenaModel
        ->where([
            'id_usuario' => $idUsuario,
            'id_resena'  => $idResena
        ])
        ->first();

    return $this->guardarVotoResena(
        $idUsuario,
        $idResena,
        $tipoVoto,
        $votoExistente
    );
}



private function guardarVotoResena(
    $idUsuario,
    $idResena,
    $tipoVoto,
    $votoExistente
)
{
    $votoResenaModel = new VotoResenaModel();

    if ($votoExistente) {

        $votoResenaModel
            ->where('id_usuario', $idUsuario)
            ->where('id_resena', $idResena)
            ->set([
                'tipo_voto' => $tipoVoto
            ])
            ->update();

    } else {

        $votoResenaModel->insert([
            'id_usuario' => $idUsuario,
            'id_resena'  => $idResena,
            'tipo_voto'  => $tipoVoto
        ]);
    }

    return $this->actualizarContadorVotosResena($idResena);
}



private function actualizarContadorVotosResena($idResena)
{
    $db = \Config\Database::connect();

    $likes = $db->table('voto_resena')
        ->where([
            'id_resena' => $idResena,
            'tipo_voto' => 1
        ])
        ->countAllResults();

    $dislikes = $db->table('voto_resena')
        ->where([
            'id_resena' => $idResena,
            'tipo_voto' => 0
        ])
        ->countAllResults();

    $resenaModel = new ResenaModel();

    $resenaModel->update($idResena, [
        'cant_likes'    => $likes,
        'cant_dislikes' => $dislikes
    ]);
}


}