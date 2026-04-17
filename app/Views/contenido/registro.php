<?= view('plantilla/header', ['titulo' => 'Registro']) ?>
<?= view('plantilla/navbar') ?>

<div class="container mt-5 pt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow p-4">

                <h3 class="text-center mb-4">📝 Crear cuenta</h3>

                <form method="post" action="<?= base_url('guardar-usuario') ?>">

                    <div class="mb-3">
                        <label>Nombre</label>
                        <input type="text" name="nombre" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control">
                    </div>

                    <div class="mb-3">
                        <label>Contraseña</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="mb-3">
                            <label>Repetir contraseña</label>
                            <input type="password" name="password2" class="form-control">
                            </div>

                    <div class="d-grid">
                        <button class="btn btn-success">Registrarse 🚀</button>
                    </div>

                </form>

            </div>

        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>