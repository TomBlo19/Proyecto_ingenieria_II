<?php

namespace App\Models;

use CodeIgniter\Model;

class VotoResenaModel extends Model
{
    protected $table            = 'voto_resena';
    
   
    protected $allowedFields    = [
        'id_usuario', 
        'id_resena', 
        'tipo_voto'
    ];
}