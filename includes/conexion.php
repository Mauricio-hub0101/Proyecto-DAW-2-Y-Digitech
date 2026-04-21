<?php
$host = "127.0.0.1"; // Usar la IP evita confusiones con localhost
$user = "user_digitech";
$pass = "PROYDIGI";
$db = "digitech_db";
$port = 3307; // El nuevo puerto que configuramos

$conexion = mysqli_connect($host, $user, $pass, $db, $port);

/*if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
} else {
    echo "¡Conexión exitosa a DigiTech en el puerto 3307!";
}
*/
// Configuramos el conjunto de caracteres a UTF-8 para que se vean las tildes y la Ñ
mysqli_set_charset($conexion, "utf8");

// echo "Conexión exitosa a DigiTech. El motor de la base de datos está listo.";
?>