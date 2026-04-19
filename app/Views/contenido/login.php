<?= view('plantilla/header', ['titulo' => 'Login']) ?>
<?= view('plantilla/navbar') ?>

<?php 
$mensaje = session()->getFlashdata('mensaje');
?>

<?php if($mensaje): ?>
    <div class="container mt-5 pt-5">
        <div class="alert alert-success text-center">
            <?= $mensaje ?>
        </div>
    </div>
<?php endif; ?>

<div class="container mt-5 pt-5">

    <div class="row justify-content-center">

        <div class="col-md-5">

            <div class="card shadow p-4">

                <h3 class="text-center mb-4">🔐 Iniciar sesión</h3>

                    <form action="<?= base_url('/procesar-login') ?>" method="POST">

                        <div class="mb-3">
                            <label>Email</label>
                            <input type="email" name="correo" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label>Contraseña</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Ingresar</button>
                        </div>

                    </form>

                <p class="text-center mt-3">
                    ¿No tenés cuenta? 
                    <a href="<?= base_url('registro') ?>">Registrate</a>
                </p>

            </div>

        </div>

    </div>

</div>

<?= view('plantilla/footer') ?>