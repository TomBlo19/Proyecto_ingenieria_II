<?= view('plantilla/header', ['titulo' => 'Inicio']) ?>
<?= view('plantilla/navbar') ?>

<?php $mensaje = session()->getFlashdata('mensaje'); ?>

<?php if($mensaje): ?>
<div class="container mt-5 pt-5">
    <div id="alerta" class="alert alert-success text-center shadow rounded-4" data-aos="fade-down">
        <?= $mensaje ?>
    </div>
</div>
<?php endif; ?>

<div class="container mt-5 pt-5 pb-5">

    <!-- HERO -->
    <div class="bg-dark text-white rounded-4 p-5 shadow-lg mb-5" data-aos="fade-up">

        <h1 class="fw-bold display-5 mb-3">
            🍔 Bienvenido a Cocineritos
        </h1>

        <p class="fs-5 text-light mb-4">
            Descubrí recetas increíbles creadas por la comunidad.
        </p>

        <form action="<?= base_url('recetas') ?>">
            <div class="input-group input-group-lg">
                <input type="text"
                       class="form-control"
                       placeholder="Buscar recetas...">
                <button class="btn btn-warning fw-bold">
                    Buscar 🔎
                </button>
            </div>
        </form>

    </div>

    <!-- DESTACADAS -->
    <div class="mb-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2 class="fw-bold">🔥 Recetas destacadas</h2>
            <a href="<?= base_url('recetas') ?>" class="btn btn-outline-dark rounded-pill">
                Ver todas
            </a>
        </div>

        <div class="row g-4">

            <?php foreach($recetas as $receta): ?>

            <div class="col-md-6 col-lg-4" data-aos="zoom-in">

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
                                👍 <?= $receta['cant_likes'] ?>
                            </span>

                        </div>

                    </div>

                </a>

            </div>

            <?php endforeach; ?>

        </div>

    </div>

    <!-- RANKINGS -->
    <div class="row g-4">

        <div class="col-md-4" data-aos="fade-up">
            <div class="bg-white shadow rounded-4 p-4 h-100">
                <h4 class="fw-bold mb-3">🏆 Más gustadas</h4>
                <p class="text-muted mb-0">
                    Próximamente ranking automático por likes.
                </p>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up">
            <div class="bg-white shadow rounded-4 p-4 h-100">
                <h4 class="fw-bold mb-3">🆕 Recién subidas</h4>
                <p class="text-muted mb-0">
                    Mostraremos las últimas recetas creadas.
                </p>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up">
            <div class="bg-white shadow rounded-4 p-4 h-100">
                <h4 class="fw-bold mb-3">⭐ Mejor valoradas</h4>
                <p class="text-muted mb-0">
                    Próximamente ranking con reseñas reales.
                </p>
            </div>
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