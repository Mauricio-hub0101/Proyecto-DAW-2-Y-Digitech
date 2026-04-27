document.addEventListener('DOMContentLoaded', function() {
    // Buscamos todos los botones de "Añadir al carrito"
    const botonesAñadir = document.querySelectorAll('.btn-add-cart');

    botonesAñadir.forEach(boton => {
        boton.addEventListener('click', function(e) {
            e.preventDefault(); // Evitamos que la página salte o se recargue
            
            const idProducto = this.getAttribute('data-id');
            const botonOriginal = this.innerHTML; // Guardamos el texto original

            // Cambiamos el botón temporalmente para que el usuario sepa que está cargando
            this.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Añadiendo...';
            this.disabled = true;

            // Hacemos la petición AJAX usando Fetch
            fetch('agregar_carrito_con_ajax.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id_producto: idProducto })
            })
            .then(response => response.json())
            .then(data => {
                if(data.success) {
                    // 1. Actualizamos el número del carrito en la barra de navegación superior
                    const badge = document.querySelector('.badge-notify'); // O el ID que le hayas puesto
                    if(badge) {
                        badge.textContent = data.total_items;
                    }

                    // 2. Efecto visual: El botón se pone verde y dice "¡Añadido!"
                    this.classList.remove('btn-primary');
                    this.classList.add('btn-success');
                    this.innerHTML = '<i class="bi bi-check2"></i> ¡Añadido!';

                    // 3. Después de 2 segundos, lo devolvemos a la normalidad
                    setTimeout(() => {
                        this.innerHTML = botonOriginal;
                        this.classList.remove('btn-success');
                        this.classList.add('btn-primary');
                        this.disabled = false;
                    }, 2000);
                } else {
                    alert("Hubo un error: " + data.mensaje);
                    this.disabled = false;
                    this.innerHTML = botonOriginal;
                }
            })
            .catch(error => {
                console.error('Error en AJAX:', error);
                this.disabled = false;
                this.innerHTML = botonOriginal;
            });
        });
    });
});