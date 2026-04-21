<footer class="py-5 bg-dark text-white mt-5">
  <div class="d-flex justify-content-center align-items-center">
            
            <img src="<?= base_url('assets/img/logo_cocineritos.png') ?>" 
                 alt="Logo" 
                 height="50" 
                 class="me-2">
            
                Cocineritos - Todos los derechos reservados &copy; <?= date('Y') ?>
 
            
        </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script>
AOS.init({
  duration: 900,
  once: true
});
</script>

<script>
        let ultimoScroll = 0;
        const navbar = document.getElementById("navbarCocineritos");

        window.addEventListener("scroll", () => {
            let scrollActual = window.scrollY;

            // Si bajamos y pasamos los 50px de margen superior
            if (scrollActual > ultimoScroll && scrollActual > 50) {
                navbar.classList.add("nav-oculto"); // Esconde el navbar
            } else {
                navbar.classList.remove("nav-oculto"); // Muestra el navbar
            }
            
            ultimoScroll = scrollActual;
        });
    </script>
</body>
</html>