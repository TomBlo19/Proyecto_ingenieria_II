<?php

namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
   
    protected $table      = 'usuario';
    
    
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = [
        'nombre_usuario', 
        'correo_usuario', 
        'password_usuario', 
        'rol_usuario'
    ];

    protected $returnType = 'object';
}