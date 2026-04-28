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

            if (scrollActual > ultimoScroll && scrollActual > 50) {
                navbar.classList.add("nav-oculto"); // Esconde el navbar
            } else {
                navbar.classList.remove("nav-oculto"); // Muestra el navbar
            }
            
            ultimoScroll = scrollActual;
        });
    </script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Usamos delegación de eventos o verificamos que los botones existan 
    // para que este script no tire error en páginas que no son de detalle
    const btnLike = document.getElementById('btn-like');
    const btnDislike = document.getElementById('btn-dislike');

    if (btnLike && btnDislike) {
        const botones = [btnLike, btnDislike];

        botones.forEach(boton => {
            boton.addEventListener('click', function() {
                const idReceta = this.getAttribute('data-id');
                const tipoVoto = this.getAttribute('data-voto');
                const formData = new FormData();
                formData.append('id_receta', idReceta);
                formData.append('tipo_voto', tipoVoto);

                fetch('<?= base_url('valorar-receta') ?>', {
                    method: 'POST',
                    body: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' }
                })
                .then(res => {
                    // Si el controlador mandó un 401, la interfaz decide qué mostrar
                    if (res.status === 401) {
                        alert('Debes iniciar sesión para valorar la receta.');
                        return;
                    }
                    if (!res.ok) throw new Error('Error en el servidor');
                    return res.json();
                })
                .then(data => {
                    if (data) {
                        // Actualizamos contadores (Muestra nuevo total de votos)
                        document.getElementById('count-likes').innerText = data.likes;
                        document.getElementById('count-dislikes').innerText = data.dislikes;
                    }
                })
                .catch(err => console.error('Error:', err));
            });
        });
    }
});
</script>
</body>
</html>