<?php

namespace App\Controllers;

use App\Libraries\Valoracion\EstrategiaValoracionInterface;

class Valoracion extends BaseController
{
   
    public function valorarPublicacion($tipoPublicacion, $idUsuario, $idPublicacion, $tipoVoto)
    {
        
        $estrategia = $this->obtenerEstrategia($tipoPublicacion);

        
        $votoExistente = $this->verificarVotoPublicacion($estrategia, $idUsuario, $idPublicacion);

        return $this->guardarVotoPublicacion($estrategia, $idUsuario, $idPublicacion, $tipoVoto, $votoExistente);
    }

    
    private function verificarVotoPublicacion($estrategia, $idUsuario, $idPublicacion)
    {
        
        return $estrategia->buscarVoto($idUsuario, $idPublicacion);
    }

   
    private function guardarVotoPublicacion($estrategia, $idUsuario, $idPublicacion, $tipoVoto, $votoExistente)
    {
        
        return $estrategia->guardarVoto($idUsuario, $idPublicacion, $tipoVoto, $votoExistente);
    }

    
    private function obtenerEstrategia($tipoPublicacion) {
        if ($tipoPublicacion === 'receta') {
            return new \App\Libraries\Valoracion\EstrategiaReceta();
        }
        return new \App\Libraries\Valoracion\EstrategiaResena();
    }
}