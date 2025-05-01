<?php
class conexionBD {
    private $pdo;

    public function conexionPDO() {
        $host = "82.197.82.53";
        $usuario = "u486624649_jersson2025";
        $contrasena = "Miranda1407.";
        $bdName = "u486624649_INCOCAT2025";

        try {
            // Asignar la conexión a la propiedad de clase $this->pdo
            $this->pdo = new PDO("mysql:host=$host;dbname=$bdName", $usuario, $contrasena);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->exec("set names utf8");
            return $this->pdo;
        } catch (PDOException $e) {
            echo 'Falló la conexión: ' . $e->getMessage();
            return null; // Retorna null en caso de error
        }
    }

    public function cerrar_conexion() {
        $this->pdo = null; // Cerrar la conexión establecida
    }
}
?>
