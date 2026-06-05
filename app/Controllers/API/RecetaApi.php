<?php

namespace App\Controllers\API;

use App\Controllers\BaseController;
use App\Controllers\Receta;
use App\Controllers\Categoria;
use App\Controllers\Ingrediente;
use App\Controllers\Resena;
use App\Models\RecetaModel;
use App\Models\UsuarioModel; 
use App\Models\CategoriaModel;
class RecetaApi extends BaseController
{
  public function inicio()
{
    $recetaController = new Receta();

    $data['ranking_recetas'] =
        $recetaController
            ->obtenerRankingRecetas(6);

    $resenaController = new Resena();

    $data['ranking_resenas'] =
        $resenaController
            ->obtenerRankingResenas(3);

    $data['recetas_recientes'] =
        $recetaController
            ->obtenerRecetasRecientes(6);

    return view(
        'contenido/home',
        $data
    );
}

    public function detalle($id)
    {
        $model = new RecetaModel();

        $data['receta'] = $model->find($id);

        $ingredienteController = new Ingrediente();

        $data['ingredientes'] =
            $ingredienteController
                ->obtenerIngredientesReceta($id);

        $resenaController = new Resena();

        $data['resenas'] =
            $resenaController->obtenerResenas($id);

       $data['ya_comento'] =
    session()->get('isLoggedIn')
        ? $resenaController->usuarioYaComento(
            session()->get('id_usuario'),
            $id
        )
        : false;

        return view('contenido/receta_detalle', $data);
    }
  
public function guardarReceta()
{
    $recetaController =
        new \App\Controllers\Receta();

    $ingredienteController =
        new \App\Controllers\Ingrediente();

    $titulo =
        $this->request->getPost('titulo');

    $descripcion =
        $this->request->getPost('descripcion');

    $ingredientes =
        $this->request->getPost('ingredientes');

    $categoria =
        $this->request->getPost('categoria');

    $imagen =
        $this->request->getFile('imagen');

    $resultado =
        $recetaController->guardarReceta(
            $titulo,
            $descripcion,
            $ingredientes,
            $categoria,
            $imagen
        );

    if (!is_numeric($resultado)) {
        return $resultado;
    }

    $idReceta = $resultado;

    $listaIngredientes =
        explode(',', $ingredientes);

    foreach ($listaIngredientes as $nombre) {

        $nombre = trim($nombre);

        if ($nombre == '') {
            continue;
        }

        $idIngrediente =
            $ingredienteController
                ->obtenerIngrediente($nombre);

        $recetaController
            ->registrarIngredienteReceta(
                $idReceta,
                $idIngrediente
            );
    }

    session()->setFlashdata(
        'mensaje',
        'Receta creada correctamente'
    );

    return redirect()->to('/crear-receta');
}
    public function mostrarFormularioReceta()
    {
        return view('contenido/crear_receta');
    }

    public function ranking()
    {
        $categoriaController = new Categoria();

        $data['ranking_por_categoria'] =
            $categoriaController
                ->obtenerRankingPorCategoria();

        return view(
            'contenido/ranking_recetas',
            $data
        );
    }


   public function valorarReceta()
{
$idReceta =
$this->request->getPost(
'id_receta'
);


$tipoVoto =
    $this->request->getPost(
        'tipo_voto'
    );

$idUsuario =
    session()->get(
        'id_usuario'
    );

if (!session()->get('isLoggedIn')) {

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'error_voto',
            'Debes iniciar sesión'
        );
}

$usuarioController =
    new \App\Controllers\Usuario();

if (
    !$usuarioController->verificarUsuario(
        $idUsuario
    )
) {

    return redirect()
        ->to('/receta/' . $idReceta)
        ->with(
            'error_voto',
            'Usuario inválido.'
        );
}

$votoController =
    new \App\Controllers\VotoReceta();

$votoController->valorarReceta(
    $idUsuario,
    $idReceta,
    $tipoVoto
);

$recetaController =
    new \App\Controllers\Receta();

$recetaController
    ->actualizarContadorVotos(
        $idReceta
    );

return redirect()
    ->to('/receta/' . $idReceta)
    ->with(
        'success_voto',
        'Voto registrado correctamente'
    );


}

public function listarRecetas()
{
    $tipoOrden =
        $this->request->getGet('orden')
        ?? 'fecha';

    $recetaController =
        new \App\Controllers\Receta();

    $data['recetas'] =
        $recetaController
            ->obtenerRecetasOrdenadas(
                $tipoOrden
            );

    $data['orden_actual'] =
        $tipoOrden;

    return view(
        'contenido/recetas',
        $data
    );
}



}
