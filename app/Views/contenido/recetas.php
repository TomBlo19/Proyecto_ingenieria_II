<?= view('plantilla/header', ['titulo' => 'Recetas']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5">

    <h2 class="mb-4">📚 Todas las recetas</h2>

    <div class="row">

        <div class="col-md-4" data-aos="fade-up">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/300" class="card-img-top">
                <div class="card-body">
                    <h5>Pizza</h5>
                </div>
            </div>
        </div>

        <div class="col-md-4" data-aos="fade-up">
            <div class="card shadow-sm">
                <img src="https://via.placeholder.com/300" class="card-img-top">
                <div class="card-body">
                    <h5>Torta</h5>
                </div>
            </div>
        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>