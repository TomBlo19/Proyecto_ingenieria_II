<?php
namespace App\Libraries\Ordenamiento;

class ordenarAlfabeticamente implements EstrategiaOrdenamiento {
    public function ordenar($queryBuilder) {
        // Ordena de la A a la Z según el título
        return $queryBuilder->orderBy('titulo_receta', 'ASC');
    }
}