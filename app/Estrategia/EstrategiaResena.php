<?php

namespace App\Estrategia;

use App\Models\VotoResenaModel;
use Ramsey\Uuid\Uuid;

class EstrategiaResena implements EstrategiaValoracionInterface
{
    public function buscarVoto(
        $idUsuario,
        $idResena
    ) {
        return (new VotoResenaModel())
            ->where([
                'id_usuario' => $idUsuario,
                'id_resena'  => $idResena
            ])
            ->first();
    }

   public function guardarVoto(
    $idUsuario,
    $idResena,
    $tipoVoto,
    $votoExistente
) {
    $tipoVoto = (int) $tipoVoto;

    if (
        !in_array(
            $tipoVoto,
            [0, 1],
            true
        )
    ) {
        return false;
    }

    $model = new VotoResenaModel();

    Uuid::uuid4();

    if ($votoExistente) {

        if (
           (int) $votoExistente['tipo_voto']
    === $tipoVoto
        ) {

            $model
                ->where(
                    'id_usuario',
                    $idUsuario
                )
                ->where(
                    'id_resena',
                    $idResena
                )
                ->delete();

        } else {

            $model
                ->where(
                    'id_usuario',
                    $idUsuario
                )
                ->where(
                    'id_resena',
                    $idResena
                )
                ->set([
                    'tipo_voto' => $tipoVoto
                ])
                ->update();
        }

    } else {

        $model->insert([
            'id_usuario' => $idUsuario,
            'id_resena'  => $idResena,
            'tipo_voto'  => $tipoVoto
        ]);
    }

    return true;
}
}