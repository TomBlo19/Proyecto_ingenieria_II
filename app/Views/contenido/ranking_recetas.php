<?= view('plantilla/header', ['titulo' => 'Detalle']) ?>
<?= view('plantilla/navbar') ?>

<div class="container py-5 mt-5">
    <div class="text-center mb-5" data-aos="fade-down">
        <h1 class="fw-bold display-4">
            <i class="bi bi-trophy-fill text-warning"></i> Hall de la Fama
        </h1>
        <p class="text-muted fs-5">El Top 10 de las recetas más amadas por la comunidad, separadas por categoría.</p>
    </div>

    <!-- Recorremos el arreglo que armamos en el controlador -->
    <?php foreach ($ranking_por_categoria as $nombre_categoria => $recetas): ?>
        
        <div class="mb-5" data-aos="fade-up">
            <h2 class="fw-bold border-bottom pb-2 mb-4 text-primary">
                <?= esc($nombre_categoria) ?>
            </h2>

            <div class="row g-4">
                <!-- Usamos $posicion para mostrar si está 1ro, 2do, etc. -->
                <?php $posicion = 1; foreach ($recetas as $receta): ?>
                    
                    <div class="col-md-6 col-lg-4">
                        <a href="<?= base_url('receta/' . $receta['id_receta']) ?>" style="text-decoration:none;color:inherit;">
                            <div class="card border-0 shadow-sm rounded-4 overflow-hidden h-100 position-relative">
                                
                                <!-- Medalla de posición -->
                                <div class="position-absolute top-0 start-0 m-3 z-3">
                                    <span class="badge rounded-circle bg-warning text-dark d-flex align-items-center justify-content-center shadow" style="width: 40px; height: 40px; font-size: 1.2rem; border: 2px solid white;">
                                        #<?= $posicion ?>
                                    </span>
                                </div>

                                <img src="<?= base_url('assets/uploads/' . $receta['imagen_receta']) ?>" class="w-100" style="height:200px; object-fit:cover;">
                                
                                <div class="card-body p-3">
                                    <h5 class="fw-bold text-truncate mb-2">
                                        <?= esc($receta['titulo_receta']) ?>
                                    </h5>
                                    <span class="badge bg-success">
                                        <i class="bi bi-heart-fill"></i> <?= $receta['cant_likes'] ?> Likes
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>

                <?php $posicion++; endforeach; ?>
            </div>
        </div>

    <?php endforeach; ?>
</div>

<?= view('plantilla/footer') ?>