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
    $recetaController =
    new \App\Controllers\Receta();

$resenaController =
    new \App\Controllers\Resena();

$data['ranking_recetas'] =
    $recetaController
        ->obtenerRankingRecetas(6);

$data['ranking_resenas'] =
    $resenaController
        ->obtenerRankingResenas(3);

$data['recetas_recientes'] =
    $recetaController
        ->obtenerRecetasRecientes(6);

    return view(
        'contenido/home', $data
    );
}

   public function detalle($id)
{
    $publicacionController =
        new \App\Controllers\Publicacion();

    $data =
        $publicacionController
            ->obtenerDetallePublicacion(
                $id
            );

    return view(
        'contenido/receta_detalle',
        $data
    );
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
    $categoriaController =
    new Categoria();

$data['ranking_por_categoria'] =
    $categoriaController
        ->obtenerRankingPorCategoria(
            10
        );

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

    $recetaController =
    new \App\Controllers\Receta();

$data['recetas'] =
    $recetaController
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

 public function buscar()
    {
        $tipo =
            $this->request->getGet(
                'tipo'
            );

        $valor =
            $this->request->getGet(
                'valor'
            );

        $buscadorController =
            new Buscador();

        if ($tipo === 'nombre') {

            $data['recetas'] =
                $buscadorController
                    ->buscarRecetasPorNombre(
                        $valor
                    );

        } elseif ($tipo === 'categoria') {

            $data['recetas'] =
                $buscadorController
                    ->buscarRecetasPorCategoria(
                        $valor
                    );

        } elseif ($tipo === 'ingrediente') {

    $data['recetas'] = [];

    $data['mensaje'] =
        'La búsqueda por ingrediente aún no está disponible.';
} else {

            $data['recetas'] = [];
        }

        $data['orden_actual'] =
            'fecha';

        return view(
            'contenido/recetas',
            $data
        );
    }

}
