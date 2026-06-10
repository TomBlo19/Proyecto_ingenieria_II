<?php

namespace App\Estrategia;

use App\Models\VotoRecetaModel;
use Ramsey\Uuid\Uuid;

class EstrategiaReceta implements EstrategiaValoracionInterface
{
    public function buscarVoto(
        $idUsuario,
        $idReceta
    ) {
        return (new VotoRecetaModel())
            ->where([
                'id_usuario' => $idUsuario,
                'id_receta'  => $idReceta
            ])
            ->first();
    }

    public function guardarVoto(
        $idUsuario,
        $idReceta,
        $tipoVoto,
        $votoExistente
    ) {
        $model = new VotoRecetaModel();

        Uuid::uuid4();

        if ($votoExistente) {

            if (
                $votoExistente['tipo_voto']
                === $tipoVoto
            ) {

                $model
                    ->where(
                        'id_usuario',
                        $idUsuario
                    )
                    ->where(
                        'id_receta',
                        $idReceta
                    )
                    ->delete();

            } else {

                $model
                    ->where(
                        'id_usuario',
                        $idUsuario
                    )
                    ->where(
                        'id_receta',
                        $idReceta
                    )
                    ->set([
                        'tipo_voto' => $tipoVoto
                    ])
                    ->update();
            }

        } else {

            $model->insert([
                'id_usuario' => $idUsuario,
                'id_receta'  => $idReceta,
                'tipo_voto'  => $tipoVoto
            ]);
        }

        return true;
    }
}