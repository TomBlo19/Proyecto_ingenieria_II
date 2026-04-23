<?php

namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    // guarda los datos en la tabla usuario
    protected $table      = 'usuario';
    
    // Le decimos cuál es el id
    protected $primaryKey = 'id_usuario';

    protected $allowedFields = [
        'nombre_usuario', 
        'correo_usuario', 
        'password_usuario', 
        'rol_usuario'
    ];

    protected $returnType = 'object';
}