<?= view('plantilla/header', ['titulo' => 'Detalle']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5 pb-5">

    <!-- MENSAJES -->
   <?php if(session()->getFlashdata('error_voto')): ?>
    <div class="alert alert-danger text-center">
        <?= session()->getFlashdata('error_voto') ?>
    </div>
<?php endif; ?>

<?php if(session()->getFlashdata('success_voto')): ?>
    <div class="alert alert-success text-center">
        <?= session()->getFlashdata('success_voto') ?>
    </div>
<?php endif; ?>

    <div class="row g-5 align-items-start">

        <!-- IMAGEN -->
        <div class="col-lg-6" data-aos="fade-right">
            <div class="card border-0 shadow-lg rounded-4 overflow-hidden">
                <img src="<?= base_url('assets/uploads/' . $receta['imagen_receta']) ?>"
                     class="w-100"
                     style="height:500px; object-fit:cover;">
            </div>
        </div>

        <!-- DETALLE -->
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

                <h4 class="fw-bold mb-3">
                    <i class="bi bi-egg-fried"></i> Ingredientes
                </h4>

                <div class="row g-2 mb-4">
                    <?php foreach($ingredientes as $item): ?>
                        <div class="col-md-6">
                            <div class="bg-light border rounded-4 px-3 py-2 shadow-sm">
                                <?= esc($item['nombre_ingrediente']) ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="d-flex gap-3 flex-wrap">

    <!-- LIKE -->
    <form method="POST" action="<?= base_url('valorar-receta-manual') ?>">
        <input type="hidden" name="id_receta" value="<?= $receta['id_receta'] ?>">
        <input type="hidden" name="tipo_voto" value="1">

        <button class="btn btn-success px-4 py-2 rounded-pill shadow">
            <i class="bi bi-heart"></i>
            Me gusta (<?= $receta['cant_likes'] ?>)
        </button>
    </form>

    <!-- DISLIKE -->
    <form method="POST" action="<?= base_url('valorar-receta-manual') ?>">
        <input type="hidden" name="id_receta" value="<?= $receta['id_receta'] ?>">
        <input type="hidden" name="tipo_voto" value="0">

        <button class="btn btn-danger px-4 py-2 rounded-pill shadow">
            <i class="bi bi-heartbreak"></i>
            No me gusta (<?= $receta['cant_dislikes'] ?>)
        </button>
    </form>

</div>

            </div>
        </div>
    </div>

    <!-- RESEÑAS -->
    <div class="mt-5" data-aos="fade-up">
        <h4 class="fw-bold mb-4 border-bottom pb-2">
            <i class="bi bi-chat-dots"></i> Reseñas de la comunidad
        </h4>

        <?php if (session()->get('isLoggedIn')): ?>
            
            <?php if (isset($ya_comento) && $ya_comento): ?>
                <div class="alert alert-info text-center rounded-4 shadow-sm mb-5">
                    <i class="bi bi-info-circle"></i> Ya dejaste tu reseña en esta receta. ¡Gracias por participar!
                </div>
            <?php else: ?>
                <div class="bg-white shadow rounded-4 p-4 mb-5 border-top border-4 border-warning">
                    <form action="<?= base_url('guardar-resena') ?>" method="POST">
                        <input type="hidden" name="id_receta" value="<?= $receta['id_receta'] ?>">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Dejá tu opinión</label>
                            <textarea class="form-control bg-light rounded-3" name="texto_resena" rows="3" placeholder="¿Qué te pareció esta receta? Compartí tu experiencia..." required></textarea>
                        </div>
                        <div class="text-end">
                            <button type="submit" class="btn btn-warning fw-bold rounded-pill px-4 shadow-sm">
                                Publicar reseña <i class="bi bi-send ms-1"></i>
                            </button>
                        </div>
                    </form>
                </div>
            <?php endif; ?>

        <?php else: ?>
            <div class="alert alert-secondary text-center rounded-4 mb-5 shadow-sm">
                <i class="bi bi-lock"></i> Tenés que <a href="<?= base_url('login') ?>" class="alert-link">iniciar sesión</a> para poder escribir una reseña.
            </div>
        <?php endif; ?>


        <div class="d-flex flex-column gap-3">
            
            <?php if (!empty($resenas)): ?>
                <?php foreach ($resenas as $resena): ?>
                    <div class="bg-white shadow-sm rounded-4 p-4 border">
                        
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <span class="fw-bold text-dark">
                                    <i class="bi bi-person-circle text-secondary me-1"></i> 
                                    <?= esc($resena['nombre_usuario']) ?>
                                </span>
                                <small class="text-muted ms-2">
                                    <?= date('d/m/Y', strtotime($resena['fecha_resena'])) ?>
                                </small>
                            </div>
                        </div>
                        
                        <p class="mb-3 text-dark">
                            <?= esc($resena['comentario_resena']) ?>
                        </p>

                        <div class="d-flex gap-2 mt-2">
                            
                            <form action="<?= base_url('votar-resena') ?>" method="POST" class="m-0">
                                <input type="hidden" name="id_receta" value="<?= $receta['id_receta'] ?>">
                                <input type="hidden" name="id_resena" value="<?= $resena['id_resena'] ?>">
                                <input type="hidden" name="tipo_voto" value="1">
                                <button type="submit" class="btn btn-sm btn-outline-success rounded-pill px-3">
                                    <i class="bi bi-heart"></i> <?= $resena['cant_likes'] ?>
                                </button>
                            </form>

                            <form action="<?= base_url('votar-resena') ?>" method="POST" class="m-0">
                                <input type="hidden" name="id_receta" value="<?= $receta['id_receta'] ?>">
                                <input type="hidden" name="id_resena" value="<?= $resena['id_resena'] ?>">
                                <input type="hidden" name="tipo_voto" value="0">
                                <button type="submit" class="btn btn-sm btn-outline-danger rounded-pill px-3">
                                    <i class="bi bi-heartbreak"></i> <?= $resena['cant_dislikes'] ?>
                                </button>
                            </form>

                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="text-center text-muted p-5 bg-white rounded-4 shadow-sm border">
                    <i class="bi bi-chat-square-text display-4 d-block mb-3 text-light"></i>
                    Todavía no hay reseñas. ¡Sé el primero en opinar!
                </div>
            <?php endif; ?>

        </div>
    </div>
    </div>

</div>

<?= view('plantilla/footer') ?>