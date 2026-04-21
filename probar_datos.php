<?php
include 'includes/conexion.php';

$sql = "SELECT nombre, precio FROM Productos";
$resultado = mysqli_query($conexion, $sql);

echo "<h1>Catálogo de DigiTech</h1>";
while ($fila = mysqli_fetch_assoc($resultado)) {
    echo "Producto: " . $fila['nombre'] . " - Precio: " . $fila['precio'] . "€<br>";
}
?>