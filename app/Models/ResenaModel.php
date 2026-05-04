<?php

namespace App\Models;

use CodeIgniter\Model;

class ResenaModel extends Model
{
    protected $table            = 'resena';
    protected $primaryKey       = 'id_resena';
    
    // Le decimos a CodeIgniter qué columnas le dejamos modificar
    protected $allowedFields    = [
        'id_receta', 
        'id_usuario', 
        'titulo_resena', 
        'comentario_resena', 
        'cant_likes', 
        'cant_dislikes'
    ];
    
    // (No hace falta poner fecha_resena acá porque la base de datos 
    // le pone el CURRENT_TIMESTAMP solita cuando se inserta)
}