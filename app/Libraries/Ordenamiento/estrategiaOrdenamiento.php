<?php
namespace App\Libraries\Ordenamiento;

interface estrategiaOrdenamiento {
    public function ordenar($queryBuilder);
}