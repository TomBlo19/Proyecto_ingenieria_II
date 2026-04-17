<?= view('plantilla/header', ['titulo' => 'Categorías']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5">

    <h2 class="mb-4">🗂 Categorías</h2>

    <div class="list-group">
        <a class="list-group-item list-group-item-action">🍕 Comida rápida</a>
        <a class="list-group-item list-group-item-action">🍰 Postres</a>
        <a class="list-group-item list-group-item-action">🥗 Saludable</a>
    </div>

</div>

<?= view('plantilla/footer') ?>