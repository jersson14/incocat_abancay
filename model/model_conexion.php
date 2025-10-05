<?php
class conexionBD {
    private $pdo;

    public function conexionPDO() {
        $host = "localhost";
        $port = "3307";
        $usuario = "root";
        $contrasena = "";
        $bdName = "incocat2";

        try {
            // Asignar la conexión a la propiedad de clase $this->pdo
            $this->pdo = new PDO("mysql:host=$host;port=$port;dbname=$bdName;charset=utf8", $usuario, $contrasena);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
