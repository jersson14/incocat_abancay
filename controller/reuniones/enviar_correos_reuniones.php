    <?php
require '../../vendor/autoload.php';
require '../../model/model_conexion.php'; // Incluir el archivo de conexión

$conexion = new conexionBD();
$pdo = $conexion->conexionPDO();

if (!$pdo) {
    die("Error: No se pudo establecer la conexión con la base de datos.");
}

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$stmt = $pdo->prepare("SELECT r.fecha_reunion, c.nombres, c.apellidos, c.email 
                       FROM reuniones r
                       JOIN clientes c ON r.id_cliente = c.id_cliente
                       WHERE DATE(r.fecha_reunion) = DATE_ADD(CURDATE(), INTERVAL 1 DAY)");
$stmt->execute();
$reuniones = $stmt->fetchAll(PDO::FETCH_ASSOC);

if ($reuniones) {
    foreach ($reuniones as $reunion) {
        $nombre = htmlspecialchars($reunion['nombres'], ENT_QUOTES, 'UTF-8');
        $apellido = htmlspecialchars($reunion['apellidos'], ENT_QUOTES, 'UTF-8');
        $correo = $reunion['email'];
        $fecha = date("d-m-Y H:i", strtotime($reunion['fecha_reunion'])); // Formato más amigable

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'norificaciones@incocat.shop';
            $mail->Password = 'Miranda1407.';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8'; // Configurar codificación correcta
            $mail->setFrom('norificaciones@incocat.shop', 'INCOCAT S.R.L.');
            $mail->addAddress($correo, "$nombre $apellido");

            $mail->addCC('jersson14071996@gmail.com'); 

            $mail->isHTML(true);
            $mail->Subject = '📅 Recordatorio de reunión para mañana';
            $mail->AddEmbeddedImage('../../img/incocat.png', 'logo_incocat');

            // ---------------------- PLANTILLA HTML ----------------------
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; border-radius: 10px; background: #f9f9f9;'>
                    <div style='text-align: center; padding-bottom: 20px;'>
            <img src='cid:logo_incocat' alt='INCOCAT S.R.L.' style='width: 250px;'>
                    </div>
                    <div style='background: white; padding: 20px; border-radius: 8px; box-shadow: 0px 4px 8px rgba(0,0,0,0.1);'>
                        <h2 style='color: #333; text-align: center;'>🔔 Recordatorio de Reunión</h2>
                        <p style='color: #555; text-align: center; font-size: 16px;'>Hola, <strong>$nombre $apellido</strong>,</p>
                        <p style='color: #555; font-size: 16px; text-align: center;'>Tienes una reunión programada para el:</p>
                        <p style='text-align: center; font-size: 18px; font-weight: bold; color: #2c3e50;'>📅 $fecha</p>
                        <p style='text-align: center; font-size: 16px; color: #555;'>Por favor, asegúrate de asistir a tiempo.</p>

                    </div>
                    <p style='text-align: center; font-size: 14px; color: #999; margin-top: 20px;'>INCOCAT S.R.L. | Todos los derechos reservados.</p>
                </div>";

            $mail->send();
            echo "Correo enviado a $correo <br>";
            file_put_contents(__DIR__ . '/log_cron.txt', "✅ Correo enviado a $correo para la reunión del $fecha\n", FILE_APPEND);
        } catch (Exception $e) {
            echo "Error al enviar correo a $correo: {$mail->ErrorInfo} <br>";
        }
    }
} else {
    echo "No hay reuniones programadas para mañana.";
}

    ?>
