<?php

namespace App\Models;

use CodeIgniter\Model;

class RecetaModel extends Model
{
    protected $table = 'receta';
    protected $primaryKey = 'id_receta';

    protected $allowedFields = [
        'titulo_receta',
        'descripcion_receta',
        'imagen_receta',
        'id_usuario',
        'id_categoria',
        'cant_likes',    
        'cant_dislikes'
    ];
public function actualizarContadorVotosSP($idReceta)
{
    $this->db->query(
        "CALL sp_actualizar_contador_votos_receta(?)",
        [$idReceta]
    );
}

public function obtenerRankingRecetasSP($limite)
{
    return $this->db
        ->query(
            "CALL sp_obtener_ranking_recetas(?)",
            [$limite]
        )
        ->getResultArray();
}
   
}