<?php

namespace App\Models;

use CodeIgniter\Model;

class VotoRecetaModel extends Model
{
    protected $table      = 'voto_receta';
    // Como en tu DER es una tabla de relación, usamos id_voto si tenés PK 
    // o simplemente omitimos si manejas solo los IDs.
    protected $primaryKey = 'id_usuario'; 

    protected $allowedFields = [
        'id_usuario',
        'id_receta',
        'tipo_voto'
    ];
}