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
use App\Controllers\Buscador;
class RecetaApi extends BaseController
{
  public function inicio()
{
    $buscadorController =
    new \App\Controllers\Buscador();

  $data['ranking_recetas'] =
    $buscadorController ->obtenerRankingRecetas(6);

  $data['ranking_resenas'] =
    $buscadorController ->obtenerRankingResenas(3);

  $data['recetas_recientes'] =
    $buscadorController ->obtenerRecetasRecientes(6);

    return view(
        'contenido/home', $data
    );
}

    public function detalle($id)
    {
        $model = new RecetaModel();

        $data['receta'] = $model->find($id);

        $ingredienteController = new Ingrediente();
         $publicacionController = new \App\Controllers\Publicacion();
        $buscadorController =new \App\Controllers\Buscador();

        $data['ingredientes'] =
         $buscadorController ->obtenerIngredientesReceta($id);

        $data['resenas'] =
          $buscadorController->obtenerResenas($id);
        
          $resenaController = new Resena();

       $data['ya_comento'] =
    session()->get('isLoggedIn')
        ? $publicacionController->VerificarComentarioUsuario(
            session()->get('id_usuario'),
            $id
        )
        : false;

        return view('contenido/receta_detalle', $data);
    }
  
public function guardarReceta()
{
    $publicacionController =
        new \App\Controllers\Publicacion();

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
        $publicacionController->guardarReceta(
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

        $publicacionController
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

$ValoracionController =
    new \App\Controllers\Valoracion();

$ValoracionController->valorarPublicacion(
    'receta',
    $idUsuario,
    $idReceta,
    $tipoVoto
);

$recetaController =
    new \App\Controllers\Receta();

$recetaController
    ->actualizarContadorVotosReceta(
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

    $buscadorController =
        new \App\Controllers\Buscador();

    $data['recetas'] =
        $buscadorController
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

public function verRecetasCategoria(
    $idCategoria
)
{
    $categoriaController =
        new \App\Controllers\Categoria();

    if (
        !$categoriaController
            ->validarCategoria(
                $idCategoria
            )
    ) {
        return redirect()
            ->to('/categorias');
    }

    $buscadorController =
        new \App\Controllers\Buscador();

    $data['recetas'] =
        $buscadorController
            ->obtenerRecetasPorCategoria(
                $idCategoria
            );

    $data['orden_actual'] =
        'fecha';

    return view(
        'contenido/recetas',
        $data
    );
}

}
