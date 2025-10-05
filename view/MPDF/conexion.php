<?php
$mysqli = new mysqli("localhost", "root", "", "incocat2", 3307);

// Verificar conexión
if ($mysqli->connect_errno) {
    echo "Falló la conexión a MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
    exit();
}
?>
