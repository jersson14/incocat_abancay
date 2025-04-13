<?php
require '../../model/model_expedientes.php';

// Guardar datos de depuración
file_put_contents("log_debug.txt", print_r([
    'POST' => $_POST,
    'FILES' => $_FILES,
    'DNI' => $_POST['dni'] ?? 'No DNI',
    'FECHAS' => $_POST['fechas'] ?? 'No fechas',
    'REQUISITOS' => $_POST['requisitos'] ?? 'No requisitos'
], true));

$ME = new Modelo_Espedientes();

// Obtener los datos del POST
$idexpediente = $_POST['idexpediente'];
$dni = $_POST['dni'];
$idusu = $_POST['idusu'];
$requisitos = $_POST['requisitos'];
$fechas = $_POST['fechas'];
$archivos = $_FILES['archivos'];

// Ruta para guardar los archivos
$ruta_base = "../../archivos_expedientes/$dni/";
if (!file_exists($ruta_base)) {
    mkdir($ruta_base, 0777, true); // Crear carpeta si no existe
}

$todo_ok = true; // Bandera para verificar el proceso

// Procesar cada requisito
for ($i = 0; $i < count($requisitos); $i++) {
    $id_requisito = $requisitos[$i];
    $fecha_original = $fechas[$i] ?? null;

    if (!$fecha_original) {
        echo json_encode(['success' => false, 'message' => "Fecha no recibida en el índice $i"]);
        exit;
    }

    // Verificar si la fecha está en el formato correcto
    $fecha_convertida = DateTime::createFromFormat('Y-m-d H:i:s', $fecha_original);
    if (!$fecha_convertida) {
        echo json_encode(['success' => false, 'message' => "Fecha inválida recibida: $fecha_original"]);
        exit;
    }
    $fecha_convertida = $fecha_convertida->format('Y-m-d H:i:s');

    // Obtener la información del archivo
    $archivo_nombre = $archivos['name'][$i] ?? '';
    $archivo_tmp = $archivos['tmp_name'][$i] ?? '';

    // Verificar si el archivo ha sido enviado
    if (!isset($archivo_tmp) || empty($archivo_tmp)) {
        echo json_encode(['success' => false, 'message' => "Archivo vacío o no enviado en el índice $i"]);
        exit;
    }

    // Definir la ruta completa para guardar el archivo
    $ruta_final = $ruta_base . basename($archivo_nombre);

    // Mover el archivo al servidor
    if (move_uploaded_file($archivo_tmp, $ruta_final)) {
        // Llamar al método para registrar el detalle del requisito
        $consulta = $ME->Registrar_Detalle_Requisito($idexpediente, $id_requisito, $ruta_final, $fecha_convertida, $idusu);
        if (!$consulta) {
            echo json_encode(['success' => false, 'message' => "Error al registrar en BD en índice $i"]);
            exit;
        }
    } else {
        echo json_encode(['success' => false, 'message' => "Error al mover archivo en índice $i"]);
        exit;
    }
}

echo json_encode(['success' => true, 'message' => "Todo registrado correctamente"]);
?>
