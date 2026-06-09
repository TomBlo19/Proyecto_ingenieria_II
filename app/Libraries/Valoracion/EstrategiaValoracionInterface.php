<?php
namespace App\Libraries\Valoracion;

interface EstrategiaValoracionInterface {
    public function buscarVoto($idUsuario, $idPublicacion);
    public function guardarVoto($idUsuario, $idPublicacion, $tipoVoto, $votoExistente);
    public function actualizarContadorVotos($idPublicacion);
}

