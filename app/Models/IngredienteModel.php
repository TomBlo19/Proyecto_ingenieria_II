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
}