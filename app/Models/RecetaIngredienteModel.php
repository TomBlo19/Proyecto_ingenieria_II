<?php

namespace App\Models;

use CodeIgniter\Model;

class RecetaIngredienteModel extends Model
{
    protected $table = 'receta_ingrediente';
    protected $primaryKey = 'id_receta_ingrediente';

    protected $allowedFields = [
        'id_receta',
        'id_ingrediente'
    ];
}