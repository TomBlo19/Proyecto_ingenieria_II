<?php
namespace App\Libraries\Ordenamiento;

class ordenarAlfabeticamente implements EstrategiaOrdenamiento {
    public function ordenar($queryBuilder) {
        
        return $queryBuilder->orderBy('titulo_receta', 'ASC');
    }
}