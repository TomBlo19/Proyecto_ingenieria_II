<?= view('plantilla/header', ['titulo' => 'Crear Receta']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5">

    <div class="row justify-content-center">

        <div class="col-md-7">

            <div class="card shadow-lg border-0 rounded-4 p-4">

                <h2 class="text-center mb-4">🍔 Crear Receta</h2>

                <?php if(session()->getFlashdata('mensaje')): ?>
                    <div class="alert alert-success text-center">
                        <?= session()->getFlashdata('mensaje') ?>
                    </div>
                <?php endif; ?>

                <form method="post"
                      action="<?= base_url('guardar-receta') ?>"
                      enctype="multipart/form-data">

                    <!-- TÍTULO -->
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

                    <!-- DESCRIPCIÓN -->
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

                    <!-- INGREDIENTES -->
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

                    <!-- CATEGORÍA -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Categoría</label>

                        <select name="categoria" class="form-select">
                            <option value="">Seleccionar categoría</option>
                            <option value="1" <?= old('categoria') == '1' ? 'selected' : '' ?>>Rápidas</option>
                            <option value="2" <?= old('categoria') == '2' ? 'selected' : '' ?>>Saludables</option>
                            <option value="3" <?= old('categoria') == '3' ? 'selected' : '' ?>>Postres</option>
                            <option value="4" <?= old('categoria') == '4' ? 'selected' : '' ?>>Pastas</option>
                            <option value="5" <?= old('categoria') == '5' ? 'selected' : '' ?>>Carnes</option>
                            <option value="6" <?= old('categoria') == '6' ? 'selected' : '' ?>>Bebidas</option>
                            <option value="7" <?= old('categoria') == '7' ? 'selected' : '' ?>>Vegetarianas</option>
                            <option value="8" <?= old('categoria') == '8' ? 'selected' : '' ?>>Desayunos</option>
                        </select>

                        <?php if(isset($validation) && $validation->hasError('categoria')): ?>
                            <small class="text-danger">
                                <?= $validation->getError('categoria') ?>
                            </small>
                        <?php endif; ?>
                    </div>

                    <!-- IMAGEN -->
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

                    <!-- BOTÓN -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning fw-bold py-2">
                            Guardar receta 🚀
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>