<?= view('plantilla/header', ['titulo' => 'Recetas']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5 pb-5">

    <div class="text-center mb-4" data-aos="fade-down">
        <h1 class="fw-bold"> <i class="bi bi-card-list"></i> Todas las recetas</h1>
        <p class="text-muted fs-5">Descubrí recetas creadas por la comunidad</p>
    </div>

    <div class="text-center mb-5" data-aos="fade-up">
        <strong class="me-2 fs-5">Ordenar por: </strong>
        
        <a href="<?= base_url('recetas?orden=fecha') ?>" 
           class="btn <?= ($orden_actual == 'fecha') ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill px-4 me-2 shadow-sm">
            <i class="bi bi-clock-history"></i> Más Recientes
        </a>
        
        <a href="<?= base_url('recetas?orden=likes') ?>" 
           class="btn <?= ($orden_actual == 'likes') ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill px-4 me-2 shadow-sm">
            <i class="bi bi-fire"></i> Más Gustadas
        </a>

        <a href="<?= base_url('recetas?orden=alfabetico') ?>" 
           class="btn <?= ($orden_actual == 'alfabetico') ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill px-4 shadow-sm">
            <i class="bi bi-sort-alpha-down"></i> A - Z
        </a>
    </div>
    
    <div class="row g-4">

        <?php foreach($recetas as $receta): ?>

        <div class="col-md-6 col-lg-4" data-aos="zoom-in">

            <a href="<?= base_url('receta/' . $receta['id_receta']) ?>"
               style="text-decoration:none;color:inherit;">

                <div class="card border-0 shadow-lg rounded-4 overflow-hidden h-100 receta-card">

                    <img src="<?= base_url('assets/uploads/' . $receta['imagen_receta']) ?>"
                         class="w-100"
                         style="height:260px; object-fit:cover;">

                    <div class="card-body p-4">

                        <h4 class="fw-bold mb-2">
                            <?= esc($receta['titulo_receta']) ?>
                        </h4>

                        <p class="text-muted mb-0">
                            Ver receta completa 
                        </p>

                    </div>

                </div>

            </a>

        </div>

        <?php endforeach; ?>

    </div>

</div>

<?= view('plantilla/footer') ?>