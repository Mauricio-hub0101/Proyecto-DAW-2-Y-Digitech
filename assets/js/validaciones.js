document.getElementById('formContacto').addEventListener('submit', function(event) {
    let esValido = true;
    const nombre = document.getElementById('nombre');
    const email = document.getElementById('email');
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    // Validación de Nombre
    if (nombre.value.trim() === "") {
        nombre.classList.add('is-invalid');
        esValido = false;
    } else {
        nombre.classList.remove('is-invalid');
        nombre.classList.add('is-valid');
    }

    // Validación de Email
    if (!emailRegex.test(email.value)) {
        email.classList.add('is-invalid');
        esValido = false;
    } else {
        email.classList.remove('is-invalid');
        email.classList.add('is-valid');
    }

    // Si no es válido, evitamos que el formulario se envíe a PHP
    if (!esValido) {
        event.preventDefault();
        alert("Por favor, revisa los campos marcados en rojo.");
    }
});