<?php

namespace App\Models;
use CodeIgniter\Model;

class UsuarioModel extends Model
{
    // Le indicamos que tiene que guardar los datos en tu tabla "usuario"
    protected $table      = 'usuario';
    
    // Le decimos cuál es el ID (tu Clave Primaria)
    protected $primaryKey = 'id_usuario';

    // ¡Súper importante! Le damos permiso para escribir en estas 4 columnas
    protected $allowedFields = [
        'nombre_usuario', 
        'correo_usuario', 
        'password_usuario', 
        'rol_usuario'
    ];

    // Para que sea más fácil trabajar con los datos después
    protected $returnType = 'object';
}