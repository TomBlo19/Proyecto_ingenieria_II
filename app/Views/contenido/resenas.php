<?= view('plantilla/header', ['titulo' => 'Reseñas']) ?>
<?= view('plantilla/navbar') ?>

<style>
.resena-card{
    transition: all .25s ease;
    border: none;
    border-radius: 18px;
    overflow: hidden;
}

.resena-card:hover{
    transform: translateY(-6px);
    box-shadow: 0 12px 30px rgba(0,0,0,.15) !important;
}

.resena-link{
    text-decoration:none;
}

.resena-texto{
    color:#555;
    line-height:1.6;
}

.stats-badge{
    background:#f8f9fa;
    border-radius:20px;
    padding:6px 12px;
    font-size:.9rem;
}

.hero-resenas{
    background: linear-gradient(135deg,#ff9f43,#ff6b6b);
    border-radius:20px;
    color:white;
    padding:30px;
    margin-bottom:30px;
}

.ver-receta{
    opacity:.8;
    transition:.2s;
}

.resena-card:hover .ver-receta{
    opacity:1;
    transform:translateX(5px);
}
</style>

<div class="container mt-5 pt-5">

    <div class="hero-resenas shadow">

        <h1 class="fw-bold mb-2">
            <i class="bi bi-chat-heart-fill"></i>
            Reseñas de la comunidad
        </h1>

        <p class="mb-0">
            Descubre opiniones, recomendaciones y experiencias compartidas por los cocineritos.
        </p>

    </div>

    <?php if(empty($resenas)): ?>

        <div class="alert alert-info text-center">
            <i class="bi bi-chat-square-text"></i>
            No hay reseñas disponibles.
        </div>

    <?php else: ?>

        <div class="row">

            <?php foreach($resenas as $resena): ?>

                <div class="col-lg-6 mb-4">

                    <a href="<?= base_url('resena/' . $resena['id_resena']) ?>"
                       class="resena-link">

                        <div class="card shadow-sm resena-card h-100">

                            <div class="card-body">

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <h5 class="fw-bold mb-0 text-dark">
                                        <i class="bi bi-chat-left-quote-fill text-warning"></i>
                                        <?= esc($resena['titulo_resena']) ?>
                                    </h5>

                                    <span class="badge bg-warning text-dark">
                                        Opinión
                                    </span>

                                </div>

                                <p class="resena-texto">
                                    <?= esc($resena['comentario_resena']) ?>
                                </p>

                                <hr>

                                <div class="d-flex justify-content-between align-items-center">

                                    <div>

                                        <span class="stats-badge me-2">
                                            👍 <?= $resena['cant_likes'] ?>
                                        </span>

                                        <span class="stats-badge">
                                            👎 <?= $resena['cant_dislikes'] ?>
                                        </span>

                                    </div>

                                    <span class="text-primary fw-semibold ver-receta">
                                        Ver receta
                                        <i class="bi bi-arrow-right"></i>
                                    </span>

                                </div>

                            </div>

                        </div>

                    </a>

                </div>

            <?php endforeach; ?>

        </div>

    <?php endif; ?>

</div>

<?= view('plantilla/footer') ?>