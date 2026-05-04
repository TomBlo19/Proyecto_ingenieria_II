<?= view('plantilla/header', ['titulo' => 'Crear Receta']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-lg border-0 rounded-4 p-4">

                <h2 class="text-center mb-4"> <i class="bi bi-fork-knife"></i> Crear Receta</h2>

                <?php if(session()->getFlashdata('mensaje')): ?>
                    <div class="alert alert-success text-center">
                        <?= session()->getFlashdata('mensaje') ?>
                    </div>
                <?php endif; ?>

                <form method="post"
                      action="<?= base_url('guardar-receta') ?>"
                      enctype="multipart/form-data">

                    <!-- agrega titulo -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título</label>

                        <input type="text"
                               name="titulo"
                               class="form-control"
                               value="<?= old('titulo') ?>"
                               placeholder="Ej: Pizza casera">

                        <?php if(isset($validation) && $validation->hasError('titulo')): ?>
                            <small class="text-danger">
                                <?= $validation->getError('titulo') ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- agregar descripción -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>

                        <textarea name="descripcion"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Contanos sobre tu receta"><?= old('descripcion') ?></textarea>

                        <?php if(isset($validation) && $validation->hasError('descripcion')): ?>
                            <small class="text-danger">
                                <?= $validation->getError('descripcion') ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- ingredientes -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ingredientes</label>

                        <textarea name="ingredientes"
                                  class="form-control"
                                  rows="4"
                                  placeholder="Ej: Harina, queso, tomate"><?= old('ingredientes') ?></textarea>

                        <?php if(isset($validation) && $validation->hasError('ingredientes')): ?>
                            <small class="text-danger">
                                <?= $validation->getError('ingredientes') ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- sleccionar categoria -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoría</label>

                       <select name="categoria" id="select-categoria" class="form-select">
                             <option value="">Seleccionar categoría</option>
                        </select>

                        <?php if(isset($validation) && $validation->hasError('categoria')): ?>
                            <small class="text-danger">
                                <?= $validation->getError('categoria') ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- guardamos la imagen -->
                    <div class="mb-4">
                        <label class="form-label fw-bold">Imagen</label>

                        <input type="file"
                               name="imagen"
                               class="form-control">

                        <?php if(isset($validation) && $validation->hasError('imagen')): ?>
                            <small class="text-danger">
                                <?= $validation->getError('imagen') ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning fw-bold py-2">
                            Guardar receta <i class="bi bi-rocket-takeoff"></i>
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<script>
document.addEventListener('DOMContentLoaded', function () {

    const select = document.getElementById('select-categoria');

    // Cuando el usuario hace foco (simula "solicita categorias")
    select.addEventListener('focus', function () {

        // Evita recargar si ya tiene opciones
        if (select.options.length > 1) return;

        fetch('<?= base_url('obtener-categorias') ?>')
            .then(res => res.json())
            .then(data => {

                data.forEach(cat => {
                    const option = document.createElement('option');
                    option.value = cat.id_categoria;
                    option.textContent = cat.nombre_categoria;
                    select.appendChild(option);
                });

            })
            .catch(err => console.error('Error:', err));
    });

});
</script>

<?= view('plantilla/footer') ?>