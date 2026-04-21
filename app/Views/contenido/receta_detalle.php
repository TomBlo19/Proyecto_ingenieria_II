<?= view('plantilla/header', ['titulo' => 'Detalle']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5 pb-5">

    <div class="row g-5 align-items-start">

        <!-- IMAGEN -->
        <div class="col-lg-6" data-aos="fade-right">

            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">

                <img src="<?= base_url('assets/uploads/' . $receta['imagen_receta']) ?>"
                     class="w-100"
                     style="height:500px; object-fit:cover;">

            </div>

        </div>

        <!-- INFO -->
        <div class="col-lg-6" data-aos="fade-left">

            <div class="bg-white shadow-lg rounded-4 p-4">

                <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">
                     Receta destacada
                </span>

                <h1 class="fw-bold mb-3">
                    <?= esc($receta['titulo_receta']) ?>
                </h1>

                <p class="text-muted fs-5 mb-4">
                    <?= esc($receta['descripcion_receta']) ?>
                </p>

                <!-- INGREDIENTES -->
                <h4 class="fw-bold mb-3"> <i class="bi bi-egg-fried"></i> Ingredientes</h4>

                <div class="row g-2 mb-4">

                    <?php foreach($ingredientes as $item): ?>
                        <div class="col-md-6">
                            <div class="bg-light border rounded-4 px-3 py-2 shadow-sm">
                                <?= esc($item['nombre_ingrediente']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>

                </div>

                <!-- BOTONES -->
                <div class="d-flex gap-3 flex-wrap">

                    <button class="btn btn-success px-4 py-2 rounded-pill shadow">
                        <i class="bi bi-heart"></i> Me gusta (<?= $receta['cant_likes'] ?>)
                    </button>

                    <button class="btn btn-danger px-4 py-2 rounded-pill shadow">
                        <i class="bi bi-heartbreak"></i> No me gusta (<?= $receta['cant_dislikes'] ?>)
                    </button>

                </div>

            </div>

        </div>

    </div>

    <!-- RESEÑAS -->
    <div class="mt-5" data-aos="fade-up">

        <div class="bg-white shadow rounded-4 p-4 text-center">

            <h4 class="fw-bold mb-3"> <i class="bi bi-chat-dots"></i> Reseñas</h4>

            <p class="text-muted mb-0">
                Próximamente podrás comentar y puntuar recetas.
            </p>

        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>