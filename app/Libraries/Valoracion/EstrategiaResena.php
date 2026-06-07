<?php
namespace App\Libraries\Valoracion;

use App\Models\VotoResenaModel;

class EstrategiaResena implements EstrategiaValoracionInterface 
{
    public function buscarVoto($idUsuario, $idPublicacion) 
    {
        $model = new VotoResenaModel();

        return $model
            ->where([
                'id_usuario' => $idUsuario,
                'id_resena'  => $idPublicacion
            ])
            ->first();
    }

    public function guardarVoto($idUsuario, $idPublicacion, $tipoVoto, $votoExistente) 
    {
        $model = new VotoResenaModel();

        if ($votoExistente) {

            $model
                ->where('id_usuario', $idUsuario)
                ->where('id_resena', $idPublicacion)
                ->set([
                    'tipo_voto' => $tipoVoto
                ])
                ->update();

        } else {

            $model->insert([
                'id_usuario' => $idUsuario,
                'id_resena'  => $idPublicacion,
                'tipo_voto'  => $tipoVoto
            ]);
        }

        return true;
    }
}