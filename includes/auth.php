<?php
// Aseguramos que la sesión esté iniciada para poder comprobarla
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Si la variable 'user_id' no existe en la sesión, el usuario no ha pasado por el login
if (!isset($_SESSION['user_id'])) {
    // Lo expulsamos a la página de login
    header("Location: login.php");
    exit(); // Detenemos la ejecución del resto de la página
}
?>