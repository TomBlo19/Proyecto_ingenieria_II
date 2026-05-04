<?php

namespace App\Models;

use CodeIgniter\Model;

class VotoResenaModel extends Model
{
    protected $table            = 'voto_resena';
    
    // Acá no definimos un primaryKey único porque, como bien armaste 
    // en tu base de datos, usamos una clave primaria compuesta.
    
    protected $allowedFields    = [
        'id_usuario', 
        'id_resena', 
        'tipo_voto'
    ];
}