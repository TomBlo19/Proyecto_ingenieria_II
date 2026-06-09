<?php

namespace App\Models;

use CodeIgniter\Model;

class ResenaModel extends Model
{
    protected $table            = 'resena';
    protected $primaryKey       = 'id_resena';
    
    
    protected $allowedFields    = [
        'id_receta', 
        'id_usuario', 
        'titulo_resena', 
        'comentario_resena', 
        'cant_likes', 
        'cant_dislikes'
    ];
public function obtenerResenas($idReceta)
{
    return $this->db->table('resena r')
        ->select('r.*, u.nombre_usuario')
        ->join('usuario u', 'u.id_usuario = r.id_usuario')
        ->where('r.id_receta', $idReceta)
        ->orderBy('r.fecha_resena', 'DESC')
        ->get()
        ->getResultArray();
}
    public function contarLikes($idResena)
{
    return $this->db->table('voto_resena')
        ->where([
            'id_resena' => $idResena,
            'tipo_voto' => 1
        ])
        ->countAllResults();
}

public function contarDislikes($idResena)
{
    return $this->db->table('voto_resena')
        ->where([
            'id_resena' => $idResena,
            'tipo_voto' => 0
        ])
        ->countAllResults();
}
    
    public function actualizarContadorVotosSP($idResena)
{
    $this->db->query(
        "CALL sp_actualizar_contador_votos_resena(?)",
        [$idResena]
    );
}

public function obtenerRankingResenasSP($limite)
{
    return $this->db
        ->query(
            "CALL sp_obtener_ranking_resenas(?)",
            [$limite]  
        )
        ->getResultArray();
}
    
}