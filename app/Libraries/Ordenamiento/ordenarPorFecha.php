<?php
namespace App\Libraries\Ordenamiento;

class OrdenarPorFecha implements estrategiaOrdenamiento {
    public function ordenar($queryBuilder) {
        
        return $queryBuilder->orderBy('id_receta', 'DESC');
    }
}