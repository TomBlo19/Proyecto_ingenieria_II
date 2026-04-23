<?= view('plantilla/header', ['titulo' => 'Registro']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow p-4">

            <!-- ingresamos los datos y los guardamos en la base -->

                <h3 class="text-center mb-4"><i class="bi bi-envelope-at"></i> Crear cuenta</h3>

                <form action="<?= base_url('/guardar-usuario') ?>" method="POST">

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="correo" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Repetir contraseña</label>
                        <input type="password" name="password2" class="form-control" required>
                    </div>

                    <div class="d-grid">
                        <button type="submit" class="btn btn-success">Registrarse </button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>