<?php
    require '../../src/PHPMailer.php';
require '../../src/SMTP.php';
require '../../src/Exception.php';

require '../../vendor/autoload.php'; // Ajusta la ruta si es necesario
require '../../model/conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Obtener reuniones programadas para MAÑANA (sin importar la hora)
$stmt = $pdo->prepare("SELECT r.fecha_reunion, c.nombres, c.email 
                       FROM reuniones r
                       JOIN clientes c ON r.id_cliente = c.id_cliente
                       WHERE DATE(r.fecha_reunion) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)");
$stmt->execute();
$reuniones = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($reuniones) {
    foreach ($reuniones as $reunion) {
        $nombre = $reunion['nombres'];
        $correo = $reunion['email'];
        $fecha = $reunion['fecha_reunion'];

        // Configurar PHPMailer
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com'; // Servidor SMTP
            $mail->SMTPAuth = true;
            $mail->Username = 'norificaciones@incocat.shop '; 
            $mail->Password = 'Miranda1407.'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 465;

            // Remitente y destinatario
            $mail->setFrom('norificaciones@incocat.shop ', 'INCOCAT S.R.L.');
            $mail->addAddress($correo, $nombre);

            // Contenido del correo
            $mail->isHTML(true);
            $mail->Subject = 'Recordatorio de reunión para mañana';
            $mail->Body = "<h3>Hola, $nombre $apellido</h3>
                           <p>Te recordamos que tienes una reunión programada para <strong>mañana ($fecha)</strong>.</p>
                           <p>Saludos,<br>INCOCAT S.R.L.</p>";

            // Enviar correo
            $mail->send();
            echo "Correo enviado a $correo <br>";
        } catch (Exception $e) {
            echo "Error al enviar correo a $correo: {$mail->ErrorInfo} <br>";
        }
    }
} else {
    echo "No hay reuniones programadas para mañana.";
}
?>