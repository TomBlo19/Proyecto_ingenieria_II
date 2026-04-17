<?= view('plantilla/header', ['titulo' => 'Detalle']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5">

    <div class="row">

        <!-- Imagen -->
        <div class="col-md-6">
            <img src="https://via.placeholder.com/500" class="img-fluid rounded shadow">
        </div>

        <!-- Info -->
        <div class="col-md-6">

            <h2>Pizza</h2>

            <p class="text-warning">⭐⭐⭐⭐☆</p>

            <p>
                Esta es una receta de ejemplo. Acá va la descripción completa
                de cómo preparar la receta.
            </p>

            <h5>Ingredientes:</h5>
            <ul>
                <li>Harina</li>
                <li>Queso</li>
                <li>Salsa</li>
            </ul>

        </div>

    </div>

    <!-- Reseñas -->
    <div class="mt-5">

        <h4>Reseñas</h4>

        <div class="card mb-3">
            <div class="card-body">
                <strong>Usuario1</strong>
                <p>Muy buena receta!</p>
            </div>
        </div>

        <div class="card mb-3">
            <div class="card-body">
                <strong>Usuario2</strong>
                <p>Me encantó 🔥</p>
            </div>
        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>