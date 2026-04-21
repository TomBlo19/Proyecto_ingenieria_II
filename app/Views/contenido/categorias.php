<?= view('plantilla/header', ['titulo' => 'Categorías']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5 pb-5">

    <div class="text-center mb-5" data-aos="fade-down">
        <h1 class="fw-bold"> <i class="bi bi-archive"></i> Categorías</h1>
        <p class="text-muted">Explorá recetas por tipo de comida</p>
    </div>

    <div class="row g-4">

        <?php foreach($categorias as $categoria): ?>

        <div class="col-md-6 col-lg-4" data-aos="zoom-in">

            <a href="<?= base_url('categoria/' . $categoria['id_categoria']) ?>"
               style="text-decoration:none;color:inherit;">

                <div class="card border-0 shadow-lg rounded-4 p-4 text-center h-100">

                    <h4 class="fw-bold mb-2">
                        <?= esc($categoria['nombre_categoria']) ?>
                    </h4>

                    <p class="text-muted mb-0">
                        Ver recetas <i class="bi bi-fork-knife"></i>
                    </p>

                </div>

            </a>

        </div>

        <?php endforeach; ?>

    </div>

</div>

<?= view('plantilla/footer') ?>