<?php
$mysqli = new mysqli("localhost", "tu_usuario", "tu_contrasena", "tu_base_de_datos", 3306);

// Verificar conexión
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}
?>
