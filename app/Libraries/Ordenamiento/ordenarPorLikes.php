<?php
namespace App\Libraries\Ordenamiento;

class OrdenarPorLikes implements estrategiaOrdenamiento {
    public function ordenar($queryBuilder) {
       
        return $queryBuilder->orderBy('cant_likes', 'DESC');
    }
}