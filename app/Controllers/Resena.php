<?php

namespace App\Controllers;

use App\Models\CategoriaModel;
use App\Models\RecetaModel;
use App\Models\ResenaModel;

class Resena extends BaseController
{


    /////receta detalle  
    public  function obtenerResenas($idReceta)
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

public  function usuarioYaComento($idReceta) {
     if (!session()->get('isLoggedIn')) { return false; } $resenaModel = new ResenaModel(); 
     return $resenaModel 
     ->where([ 'id_usuario' => session()
     ->get('id_usuario'), 'id_receta' => $idReceta ]) 
     ->first(); }

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

}