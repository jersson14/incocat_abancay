<?php
require '../../vendor/autoload.php';
require '../../model/model_conexion.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conexion = new conexionBD();
$pdo = $conexion->conexionPDO();

if (!$pdo) {
    die("Error: No se pudo establecer la conexión con la base de datos.");
}

$query = "
SELECT
    expediente.id_expediente,
    expediente.nro_expediente,
    expediente.representación,
    expediente.tiempo_transcurrido,
    expediente.created_at,
    DATE_FORMAT(expediente.created_at, '%d-%m-%Y %H:%i') AS fecha_inicio,
    clientes.email,
    CONCAT(clientes.nombres, ' ', clientes.apellidos) AS cliente_nombre,
    servicios.nombre AS nombre_servicio
FROM expediente 
INNER JOIN clientes ON expediente.id_cliente = clientes.id_cliente 
INNER JOIN servicios ON expediente.id_servicio = servicios.id_servicios 
WHERE expediente.estado != 'ELIMINADO'
AND expediente.tiempo_transcurrido >= 30
";

$stmt = $pdo->prepare($query);
$stmt->execute();
$expedientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
file_put_contents(__DIR__ . '/log_cron.txt', "🕒 Ejecutado: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

if ($expedientes) {
    foreach ($expedientes as $expediente) {
        $mail = new PHPMailer(true);
        $cliente = htmlspecialchars($expediente['cliente_nombre'], ENT_QUOTES, 'UTF-8');
        $correo = $expediente['email'];
        $fecha_inicio = $expediente['fecha_inicio'];
        $dias = $expediente['tiempo_transcurrido'];
        $nro_expediente = $expediente['nro_expediente'];
        $servicio = htmlspecialchars($expediente['nombre_servicio'], ENT_QUOTES, 'UTF-8');

        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.hostinger.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'norificaciones@incocat.shop';
            $mail->Password = 'Miranda1407.';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->CharSet = 'UTF-8';
            $mail->setFrom('norificaciones@incocat.shop', 'INCOCAT S.R.L.');
            $mail->addAddress($correo, $cliente);
            $mail->addCC('jersson14071996@gmail.com');

            $mail->isHTML(true);
            $mail->Subject = "⏰ Alerta: Expediente con $dias días de atraso";
            $mail->AddEmbeddedImage('../../img/incocat.png', 'logo_incocat');

            $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background: #f4f6f9; border-radius: 10px;'>
                    <div style='text-align: center;'>
                        <img src='cid:logo_incocat' alt='Logo INCOCAT' style='width: 200px; margin-bottom: 20px;'>
                    </div>
                    <div style='background: white; padding: 25px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);'>
                        <h2 style='color: #c0392b; text-align: center;'>📢 Expediente Atrasado</h2>
                        <p style='font-size: 16px; color: #333;'>El expediente de <strong>$cliente</strong> ha superado los <strong>$dias días</strong> desde su registro el <strong>$fecha_inicio</strong>.</p>
                        <p style='font-size: 15px; color: #555;'>El expediente número <strong>$nro_expediente</strong> correspondiente al servicio <strong>$servicio</strong> ha superado los <strong>$dias días</strong> desde su registro el <strong>$fecha_inicio</strong>.</p>
                        <p style='font-size: 15px; color: #555;'>Por favor, toma las acciones necesarias para regularizar su estado.</p>
                      
                    </div>
                    <p style='text-align: center; color: #999; font-size: 13px; margin-top: 30px;'>INCOCAT S.R.L. | Todos los derechos reservados.</p>
                </div>
            ";

            $mail->send();
            echo "✅ Notificación enviada a $correo por expediente $nro_expediente<br>";
            file_put_contents(__DIR__ . '/log_cron.txt', "🕒 Ejecutado: " . date('Y-m-d H:i:s') . "\n", FILE_APPEND);

        } catch (Exception $e) {
            echo "❌ Error al enviar a $correo: {$mail->ErrorInfo}<br>";
        }
    }
} else {
    echo "No hay expedientes con más de 30 días de atraso.";
}
?>
