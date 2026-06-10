<?php

namespace App\Controllers;

use App\Models\RecetaModel;
use App\Models\IngredienteModel;
use App\Models\RecetaIngredienteModel;
use App\Models\VotoRecetaModel;
use App\Models\CategoriaModel;
use App\Models\ResenaModel;
use App\Models\VotoResenaModel;
use DI\ContainerBuilder;
use App\Estrategia\EstrategiaReceta;
use App\Estrategia\EstrategiaResena;

class Receta extends BaseController
{
  
public function publicarReceta(
    $titulo,
    $descripcion,
    $ingredientes,
    $idCategoria,
    $imagen
)
{
    $datos = $this->validarPublicacionReceta(
        $titulo,
        $descripcion,
        $ingredientes,
        $idCategoria,
        $imagen
    );

    if ($datos !== true) {

        return view(
            'contenido/crear_receta',
            ['errores' => $datos]
        );
    }

    return $this->registrarPublicacionReceta(
        $titulo,
        $descripcion,
        $idCategoria,
        $imagen
    );
}
private function validarPublicacionReceta(
    $titulo,
    $descripcion,
    $ingredientes,
    $idCategoria,
    $imagen
)
{
    $errores = [];

  
    if (empty(trim($titulo))) {

        $errores['titulo'] =
            'El título es obligatorio.';

    } elseif (strlen(trim($titulo)) < 3) {

        $errores['titulo'] =
            'El título debe tener al menos 3 caracteres.';
    }

   
    if (empty(trim($descripcion))) {

        $errores['descripcion'] =
            'La descripción es obligatoria.';

    } elseif (strlen(trim($descripcion)) < 10) {

        $errores['descripcion'] =
            'La descripción debe tener al menos 10 caracteres.';
    }

  
    if (empty(trim($ingredientes))) {

        $errores['ingredientes'] =
            'Los ingredientes son obligatorios.';

    } elseif (strlen(trim($ingredientes)) < 5) {

        $errores['ingredientes'] =
            'Ingresá ingredientes más detallados.';
    }

  
    if (empty($idCategoria)) {

        $errores['categoria'] =
            'Debes seleccionar una categoría.';
    }

    if (!$imagen || !$imagen->isValid()) {

        $errores['imagen'] =
            'Debes seleccionar una imagen válida.';
    }

    return empty($errores)
        ? true
        : $errores;
}
private function registrarPublicacionReceta(
    $titulo,
    $descripcion,
    $idCategoria,
    $imagen
)
{
    $model = new RecetaModel();

    $nombreImagen = $imagen->getRandomName();

    $imagen->move(
        'assets/uploads/',
        $nombreImagen
    );

    $model->insert([
        'titulo_receta'      => $titulo,
        'descripcion_receta' => $descripcion,
        'imagen_receta'      => $nombreImagen,
        'id_usuario'         => session()->get('id_usuario'),
        'id_categoria'       => $idCategoria
    ]);

    return $model->getInsertID();
}



// RESEÑAS

////// registar reseña
public function publicarResena(
    $idUsuario,
    $idReceta,
    $textoResena
)
{
    if (empty(trim($textoResena))) {
        return false;
    }

    return $this->registrarPublicacioResena(
        $idUsuario,
        $idReceta,
        $textoResena
    );
}



private function  registrarPublicacioResena(
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

    return true;
}
///obtener receta 

     public function obtenerRecetasOrdenadas( $tipoOrden )
{
    $model = new RecetaModel();

    $builder =
        $model->builder();

    if ($tipoOrden === 'likes') {

        $estrategia =
            new \App\Libraries\Ordenamiento\OrdenarPorLikes();

    } elseif (
        $tipoOrden === 'alfabetico'
    ) {

        $estrategia =
            new \App\Libraries\Ordenamiento\OrdenarAlfabeticamente();

    } else {

        $estrategia =
            new \App\Libraries\Ordenamiento\OrdenarPorFecha();
    }

    $builder =
        $estrategia->ordenar(
            $builder
        );

    return $builder
        ->get()
        ->getResultArray();
}

public function obtenerRecetasPorCategoria(
    $idCategoria
)
{
    $recetaModel =
        new RecetaModel();

    return $recetaModel
        ->where(
            'id_categoria',
            $idCategoria
        )
        ->findAll();
}

//kanging

     
   public function obtenerRankingRecetas($limiteReceta)
{
    $recetaModel = new RecetaModel();

    return $recetaModel
        ->obtenerRankingRecetasSP(
            $limiteReceta
        );
}

    public  function obtenerRecetasRecientes($limiteReceta )
    {
        $recetaModel = new RecetaModel();

        return $recetaModel
            ->orderBy('id_receta', 'DESC')
            ->findAll($limiteReceta);
    }
    public function buscarReceta($idReceta)
{
    $recetaModel =
        new RecetaModel();

    return $recetaModel
        ->find($idReceta);
}

     public function buscarRecetasPorNombre(
        $nombre
    )
    {
        $recetaModel =
            new RecetaModel();

        return $recetaModel
            ->like(
                'titulo_receta',
                $nombre
            )
            ->findAll();
    }
/// obtener reseña y verificar 

public function VerificarComentarioUsuario(
    $idUsuario,
    $idReceta
)
{
    $resenaModel =
        new ResenaModel();

    return $resenaModel
        ->where([
            'id_usuario' => $idUsuario,
            'id_receta' => $idReceta
        ])
        ->first();
}

public function obtenerResenas(
        $idReceta
    )
    {
        $resenaModel =
            new ResenaModel();

        return $resenaModel
            ->obtenerResenas(
                $idReceta
            );
    }

    public function buscarResena(
        $idResena
    )
    {
        $resenaModel =
            new ResenaModel();

        return $resenaModel
            ->find(
                $idResena
            );
    }

    ///renking de reseñas
       public function obtenerRankingResenas($limiteResena )
    {
        $resenaModel = new ResenaModel();

        return $resenaModel
            ->obtenerRankingResenasSP($limiteResena);
    }

    ///valorar 
    
    ///// valorar publicaion 
public function valorarPublicacion(
    $tipoPublicacion,
    $idUsuario,
    $identificador,
    $tipoVoto
)
{
    $builder = new ContainerBuilder();

    $builder->addDefinitions([
        'estrategia.receta' =>
            \DI\autowire(
                EstrategiaReceta::class
            ),

        'estrategia.resena' =>
            \DI\autowire(
                EstrategiaResena::class
            )
    ]);

    $container = $builder->build();

    $estrategia =
        $container->get(
            'estrategia.' .
            $tipoPublicacion
        );

    $votoExistente =
        $estrategia->buscarVoto(
            $idUsuario,
            $identificador
        );

    return $estrategia->guardarVoto(
        $idUsuario,
        $identificador,
        $tipoVoto,
        $votoExistente
    );
}


 
public function actualizarContadorReceta(
    $idReceta
)
{
    $recetaModel =
        new RecetaModel();

    return $recetaModel
        ->actualizarContadorVotosSP(
            $idReceta
        );
}

public function actualizarContadorResena(
    $idResena
)
{
    $resenaModel =
        new ResenaModel();

    return $resenaModel
        ->actualizarContadorVotosSP(
            $idResena
        );
}

   

}