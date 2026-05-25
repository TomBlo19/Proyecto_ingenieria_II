<?= view('plantilla/header', ['titulo' => 'Inicio']) ?>
<?= view('plantilla/navbar') ?>

<?php $mensaje = session()->getFlashdata('mensaje'); ?>

<?php if($mensaje): ?>

<div class="container mt-5 pt-5">

    <div id="alerta"
         class="alert alert-success text-center shadow rounded-4"
         data-aos="fade-down">

        <?= $mensaje ?>

    </div>

</div>

<?php endif; ?>



<div class="container mt-5 pt-5 pb-5">

    <!-- HERO -->
    <div class="bg-dark text-white rounded-4 p-5 shadow-lg mb-5"
         data-aos="fade-up">

        <div class="text-center mb-5">

            <img src="<?= base_url('assets/img/logo_cocineritos.png') ?>"
                 alt="Logo Cocineritos"
                 height="250"
                 class="mb-3 d-block mx-auto">

            <h1 class="fw-bold display-5">
                Bienvenido a Cocineritos
            </h1>

            <p class="fs-5 text-light mb-4">
                Descubrí recetas increíbles creadas por la comunidad.
            </p>

        </div>


        <form action="<?= base_url('recetas') ?>">

            <div class="input-group input-group-lg">

                <input type="text"
                       class="form-control"
                       placeholder="Buscar recetas...">

                <button class="btn btn-warning fw-bold">

                    Buscar
                    <i class="bi bi-search-heart"></i>

                </button>

            </div>

        </form>

    </div>



    <!-- MÁS GUSTADAS -->
    <div class="mb-5">

        <div class="d-flex justify-content-between align-items-center mb-4">

            <h2 class="fw-bold">

                <i class="bi bi-fire text-danger"></i>
                Recetas más gustadas

            </h2>

        </div>


        <div class="row g-4">

            <?php foreach($ranking_recetas as $receta): ?>

            <div class="col-md-6 col-lg-4"
                 data-aos="zoom-in">

                <a href="<?= base_url('receta/' . $receta['id_receta']) ?>"
                   style="text-decoration:none;color:inherit;">

                    <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100">

                        <img src="<?= base_url('assets/uploads/' . $receta['imagen_receta']) ?>"
                             class="w-100"
                             style="height:250px; object-fit:cover;">

                        <div class="card-body p-4">

                            <h4 class="fw-bold mb-2">

                                <?= esc($receta['titulo_receta']) ?>

                            </h4>

                            <p class="text-muted mb-2">

                                <?= character_limiter($receta['descripcion_receta'], 70) ?>

                            </p>

                            <span class="badge bg-success">

                                <i class="bi bi-hand-thumbs-up-fill"></i>
                                <?= $receta['cant_likes'] ?>

                            </span>

                        </div>

                    </div>

                </a>

            </div>

            <?php endforeach; ?>

        </div>

    </div>



    <!-- RESEÑAS DESTACADAS -->
    <div class="mb-5">

        <h2 class="fw-bold mb-4">

            <i class="bi bi-chat-left-heart text-primary"></i>
            Comentarios destacados

        </h2>


        <div class="row g-4">

            <?php foreach($ranking_resenas as $resena): ?>

            <div class="col-md-4"
                 data-aos="fade-up">

                <a href="<?= base_url('receta/' . $resena['id_receta']) ?>"
                   class="text-decoration-none text-dark">

                    <div class="bg-white shadow rounded-4 p-4 h-100">

                        <div class="mb-3 text-muted small">

                            <i class="bi bi-book"></i>
                            <?= esc($resena['titulo_receta']) ?>

                        </div>

                        <p class="fw-semibold">

                            "<?= esc($resena['comentario_resena']) ?>"

                        </p>

                        <span class="badge bg-success">

                            <i class="bi bi-hand-thumbs-up-fill"></i>
                            <?= $resena['cant_likes'] ?>

                        </span>

                    </div>

                </a>

            </div>

            <?php endforeach; ?>

        </div>

    </div>



    <!-- RECIÉN SUBIDAS -->
    <div class="mb-5">

        <h2 class="fw-bold mb-4">

            <i class="bi bi-clock-history text-dark"></i>
            Recién subidas

        </h2>


        <div class="row g-4">

            <?php foreach($recetas_recientes as $receta): ?>

            <div class="col-md-6 col-lg-4"
                 data-aos="zoom-in">

                <a href="<?= base_url('receta/' . $receta['id_receta']) ?>"
                   style="text-decoration:none;color:inherit;">

                    <div class="card border-0 shadow rounded-4 overflow-hidden h-100">

                        <img src="<?= base_url('assets/uploads/' . $receta['imagen_receta']) ?>"
                             class="w-100"
                             style="height:220px; object-fit:cover;">

                        <div class="card-body p-4">

                            <h5 class="fw-bold">

                                <?= esc($receta['titulo_receta']) ?>

                            </h5>

                            <p class="text-muted">

                                <?= character_limiter($receta['descripcion_receta'], 60) ?>

                            </p>

                        </div>

                    </div>

                </a>

            </div>

            <?php endforeach; ?>

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