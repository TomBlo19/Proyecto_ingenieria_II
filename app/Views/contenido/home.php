<?= view('plantilla/header', ['titulo' => 'Inicio']) ?>
<?= view('plantilla/navbar') ?>

<?php 
$mensaje = session()->getFlashdata('mensaje');
if($mensaje):
?>
<div class="container mt-5 pt-5">
    <div id="alerta" class="alert alert-success text-center shadow">
        <?= $mensaje ?>
    </div>
</div>
<?php endif; ?>

<div class="container mt-5 pt-5">

    <input type="text" class="form-control mb-4" placeholder="Buscar receta...">

    <h3>Recetas destacadas</h3>

    <div class="row">

        <!-- CARD 1 -->
        <div class="col-md-4">
            <a href="<?= base_url('receta') ?>" style="text-decoration:none; color:inherit; display:block;">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top">
                    <div class="card-body">
                        <h5>Pizza</h5>
                        ⭐⭐⭐⭐☆
                    </div>
                </div>
            </a>
        </div>

        <!-- CARD 2 -->
        <div class="col-md-4">
            <a href="<?= base_url('receta') ?>" style="text-decoration:none; color:inherit; display:block;">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top">
                    <div class="card-body">
                        <h5>Pizza</h5>
                        ⭐⭐⭐⭐☆
                    </div>
                </div>
            </a>
        </div>

        <!-- CARD 3 -->
        <div class="col-md-4">
            <a href="<?= base_url('receta') ?>" style="text-decoration:none; color:inherit; display:block;">
                <div class="card shadow-sm">
                    <img src="https://via.placeholder.com/300" class="card-img-top">
                    <div class="card-body">
                        <h5>Torta</h5>
                        ⭐⭐⭐⭐⭐
                    </div>
                </div>
            </a>
        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>

<script>
document.addEventListener("DOMContentLoaded", function(){

    let alerta = document.getElementById('alerta');

    if(alerta){
        setTimeout(() => {
            alerta.style.transition = "0.5s";
            alerta.style.opacity = "0";

            setTimeout(() => alerta.remove(), 500);
        }, 3000);
    }

});
</script>