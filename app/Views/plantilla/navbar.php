<nav class="navbar fixed-top navbar-dark bg-dark">
  <div class="container-fluid">

    <!-- Botón menú -->
    <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#menuLateral">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- MENÚ LATERAL -->
    <div class="offcanvas offcanvas-start bg-dark text-white" tabindex="-1" id="menuLateral">
      <div class="offcanvas-header">
        <h5 class="fw-bold">Menú</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"></button>
      </div>

      <div class="offcanvas-body">
        <ul class="navbar-nav">

          <li class="nav-item">
            <a class="nav-link text-white" href="<?= base_url() ?>">Inicio</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="<?= base_url('recetas') ?>">Recetas</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="<?= base_url('categorias') ?>">Categorías</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-white" href="<?= base_url('guardados') ?>">Guardados</a>
          </li>

          <?php if(session()->get('isLoggedIn')): ?>
          <li class="nav-item">
            <a class="nav-link text-white" href="<?= base_url('crear-receta') ?>">Nueva receta</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-danger" href="<?= base_url('logout') ?>">Cerrar sesión</a>
          </li>
          <?php endif; ?>

        </ul>
      </div>
    </div>

    <!-- LOGO -->
    <a class="navbar-brand fw-bold" href="<?= base_url() ?>">
      🍔 Cocineritos
    </a>

    <!-- DERECHA -->
    <div class="d-flex align-items-center">

      <!-- Buscar -->
      <a href="#" class="btn btn-link text-white">
        <i class="bi bi-search"></i>
      </a>

      <?php if(session()->get('isLoggedIn')): ?>

        <span class="text-white me-2">
          Hola <?= session()->get('nombre') ?>
        </span>

        <a href="<?= base_url('logout') ?>" class="btn btn-outline-light btn-sm">
          Salir
        </a>

      <?php else: ?>

        <a href="<?= base_url('login') ?>" class="btn btn-link text-white">
          <i class="bi bi-person"></i>
        </a>

      <?php endif; ?>

    </div>

  </div>
</nav>