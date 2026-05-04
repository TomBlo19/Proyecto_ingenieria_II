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
public function mostrarFormularioReceta()
{
    return view('contenido/crear_receta');
}

public function obtenerCategorias()
{
   $model = new CategoriaModel();
        return $this->response->setJSON($model->findAll());
}
//////////////////////// REGISTRAR RECETA 

public function validarReceta()
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

    ])) 
    
    return view('contenido/crear_receta', [
    'validation' => $this->validator
]);

      
        return $this->registrarReceta(
            $titulo,
            $descripcion,
            $ingredientes,
            $idCategoria,
            $imagen
        );
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
    $ingredienteModel = new IngredienteModel();
    $relacionModel = new RecetaIngredienteModel();

    $listaIngredientes = explode(',', $ingredientes);

    foreach ($listaIngredientes as $item) {
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
    $model = new CategoriaModel();
    
    $data['categorias'] = $model->findAll(); 

    return view('contenido/categorias', $data);
}
/////buscar por categoria 
public function verCategoria($id)
{
    
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
    $votoModel = new VotoRecetaModel();
    $recetaModel = new RecetaModel();

    
    $likes    = $votoModel->contarVotos($idReceta, 1);
    $dislikes = $votoModel->contarVotos($idReceta, 0);

    $recetaModel->update($idReceta, [
        'cant_likes'    => $likes,
        'cant_dislikes' => $dislikes
    ]);

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with('success_voto', 'Voto registrado correctamente');
}


    // RESEÑAS


    public function guardarResena()
    {
        $idReceta = $this->request->getPost('id_receta');
        $idUsuario = session()->get('id_usuario');
        $textoResena = $this->request->getPost('texto_resena');
        
        return $this->procesarNuevaResena($idUsuario, $idReceta, $textoResena);
    }

    private function procesarNuevaResena($idUsuario, $idReceta, $textoResena)
    {
        $resenaModel = new ResenaModel();

        // Verificamos si ya comentó
        $yaComento = $resenaModel->where(['id_usuario' => $idUsuario, 'id_receta' => $idReceta])->first();

        if ($yaComento) {
            return redirect()->to('/receta/' . $idReceta)
                             ->with('error_voto', 'Solo puedes dejar una reseña por receta.');
        }

        // Insertamos la reseña
        $resenaModel->insert([
            'id_receta'         => $idReceta,
            'id_usuario'        => $idUsuario,
            'titulo_resena'     => 'Opinión',
            'comentario_resena' => $textoResena,
            'cant_likes'        => 0,
            'cant_dislikes'     => 0
        ]);

        return redirect()->to('/receta/' . $idReceta)
                         ->with('success_voto', '¡Tu reseña fue publicada con éxito!');
    }

    // VOTAR RESEÑAS

    public function votarResena()
    {
        $idReceta = $this->request->getPost('id_receta'); 
        $idResena = $this->request->getPost('id_resena');
        $idUsuario = session()->get('id_usuario');
        $tipoVoto = $this->request->getPost('tipo_voto'); // 1 para Like, 0 para Dislike

        return $this->guardarOActualizarVotoResena($idUsuario, $idResena, $idReceta, $tipoVoto);
    }

    private function guardarOActualizarVotoResena($idUsuario, $idResena, $idReceta, $tipoVoto)
    {
        $votoResenaModel = new VotoResenaModel();

        $votoExistente = $votoResenaModel
            ->where(['id_usuario' => $idUsuario, 'id_resena' => $idResena])
            ->first();

        if ($votoExistente) {
            $votoResenaModel->where('id_usuario', $idUsuario)
                            ->where('id_resena', $idResena)
                            ->set(['tipo_voto' => $tipoVoto])
                            ->update();
        } else {
            $votoResenaModel->insert([
                'id_usuario' => $idUsuario,
                'id_resena'  => $idResena,
                'tipo_voto'  => $tipoVoto
            ]);
        }

        return $this->actualizarContadorVotosResena($idResena, $idReceta);
    }

    private function actualizarContadorVotosResena($idResena, $idReceta)
    {
        $db = \Config\Database::connect();

        $likes = $db->table('voto_resena')
                    ->where(['id_resena' => $idResena, 'tipo_voto' => 1])
                    ->countAllResults();

        $dislikes = $db->table('voto_resena')
                        ->where(['id_resena' => $idResena, 'tipo_voto' => 0])
                        ->countAllResults();

        $resenaModel = new ResenaModel();
        $resenaModel->update($idResena, [
            'cant_likes'    => $likes,
            'cant_dislikes' => $dislikes
        ]);

        return redirect()->to('/receta/' . $idReceta);
    }


}