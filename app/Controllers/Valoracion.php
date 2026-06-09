<?php

namespace App\Controllers;

class Valoracion extends BaseController
{
    public function valorarPublicacion($tipoPublicacion, $idUsuario, $idPublicacion, $tipoVoto)
{
    $votoExistente = $this->verificarVotoPublicacion(
        $tipoPublicacion,
        $idUsuario,
        $idPublicacion
    );

    $resultado = $this->guardarVotoPublicacion(
        $tipoPublicacion,
        $idUsuario,
        $idPublicacion,
        $tipoVoto,
        $votoExistente
    );

    $this->actualizarContadorPublicacion(
        $tipoPublicacion,
        $idPublicacion
    );

    return $resultado;
}

    private function verificarVotoPublicacion($tipoPublicacion, $idUsuario, $idPublicacion)
    {
        $estrategia = $this->obtenerEstrategia($tipoPublicacion);

        return $estrategia->buscarVoto($idUsuario, $idPublicacion);
    }

    private function guardarVotoPublicacion($tipoPublicacion, $idUsuario, $idPublicacion, $tipoVoto, $votoExistente)
    {
        $estrategia = $this->obtenerEstrategia($tipoPublicacion);

        return $estrategia->guardarVoto(
            $idUsuario,
            $idPublicacion,
            $tipoVoto,
            $votoExistente
        );
    }

    private function actualizarContadorPublicacion($tipoPublicacion, $idPublicacion)
    {
        $estrategia = $this->obtenerEstrategia($tipoPublicacion);

        return $estrategia->actualizarContadorVotos($idPublicacion);
    }

    private function obtenerEstrategia($tipoPublicacion)
    {
        if ($tipoPublicacion === 'receta') {
            return new \App\Libraries\Valoracion\EstrategiaReceta();
        }

        return new \App\Libraries\Valoracion\EstrategiaResena();
    }
}