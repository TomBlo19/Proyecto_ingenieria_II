<?php
namespace App\Libraries\Ordenamiento;

class OrdenarPorFecha implements estrategiaOrdenamiento {
    public function ordenar($queryBuilder) {
        // Ordena de mayor a menor según el ID (las últimas creadas)
        return $queryBuilder->orderBy('id_receta', 'DESC');
    }
}