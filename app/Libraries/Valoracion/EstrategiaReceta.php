<?php
namespace App\Libraries\Valoracion;
use App\Models\VotoRecetaModel;
use App\Models\ResenaModel;
use App\Models\RecetaModel;

class EstrategiaReceta implements EstrategiaValoracionInterface {
    public function buscarVoto($idUsuario, $idPublicacion) {
        return (new VotoRecetaModel())->where(['id_usuario' => $idUsuario, 'id_receta' => $idPublicacion])->first();
    }

    public function guardarVoto($idUsuario, $idPublicacion, $tipoVoto, $votoExistente) {
        $model = new VotoRecetaModel();
        if ($votoExistente) {
            $model->where('id_usuario', $idUsuario)->where('id_receta', $idPublicacion)->set(['tipo_voto' => $tipoVoto])->update();
        } else {
            $model->insert(['id_usuario' => $idUsuario, 'id_receta' => $idPublicacion, 'tipo_voto' => $tipoVoto]);
        }
        return true;
    }

     public function actualizarContadorVotos(
        $idPublicacion
    ) {
        $recetaModel = new RecetaModel();

        $recetaModel->actualizarContadorVotosSP(
            $idPublicacion
        );
    }
}