<?= view('plantilla/header', ['titulo' => 'Crear Receta']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5">

    <div class="row justify-content-center">

        <div class="col-md-6">

            <div class="card shadow-lg p-4">

                <h2 class="text-center mb-4">🍔 Crear Receta</h2>

                <form method="post" action="<?= base_url('guardar-receta') ?>">

                    <!-- Título -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Título</label>
                        <input type="text" name="titulo" class="form-control" placeholder="Ej: Pizza casera">
                    </div>

                    <!-- Descripción -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Descripción</label>
                        <textarea name="descripcion" class="form-control" rows="3"></textarea>
                    </div>

                    <!-- Ingredientes -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Ingredientes</label>      
                         <textarea name="ingredientes" class="form-control" rows="3"></textarea>                                 
              </div>

                    <!-- Imagen -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Imagen (URL)</label>
                          <input type="text" name="imagen" class="form-control">
                    </div>

                    <!-- Botón -->
                    <div class="d-grid">
                        <button type="submit" class="btn btn-warning fw-bold">
                            Guardar receta 🚀
                        </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>