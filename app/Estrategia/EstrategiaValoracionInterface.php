<?php

namespace App\Estrategia;

interface EstrategiaValoracionInterface
{
    public function buscarVoto(
        $idUsuario,
        $idPublicacion
    );

    public function guardarVoto(
        $idUsuario,
        $idPublicacion,
        $tipoVoto,
        $votoExistente
    );
}