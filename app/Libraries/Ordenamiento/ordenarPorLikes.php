<?php
namespace App\Libraries\Ordenamiento;

class OrdenarPorLikes implements estrategiaOrdenamiento {
    public function ordenar($queryBuilder) {
        // Ordena de mayor a menor según los likes
        return $queryBuilder->orderBy('cant_likes', 'DESC');
    }
}