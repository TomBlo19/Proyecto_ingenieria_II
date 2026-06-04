<?php

namespace App\Models;

use CodeIgniter\Model;

class IngredienteModel extends Model
{
    protected $table = 'ingrediente';
    protected $primaryKey = 'id_ingrediente';

    protected $allowedFields = [
        'nombre_ingrediente'
    ];

    public function obtenerIngredientesReceta($idReceta)
    {
        return $this->db
            ->table('receta_ingrediente ri')
            ->select('i.nombre_ingrediente')
            ->join(
                'ingrediente i',
                'i.id_ingrediente = ri.id_ingrediente'
            )
            ->where('ri.id_receta', $idReceta)
            ->get()
            ->getResultArray();
    }
}
    