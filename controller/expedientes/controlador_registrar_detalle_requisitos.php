<?php
require '../../model/model_expedientes.php';

// Guardar datos de depuración


$ME = new Modelo_Espedientes();

// Obtener los datos del POST
$idexpediente = $_POST['idexpediente'];
$dni = $_POST['dni'];
$idusu = $_POST['idusu'];
$requisitos = $_POST['requisitos'];
$fechas = $_POST['fechas'];
$estados = $_POST['estados']; // ← Nuevo arreglo de estados ("SI"/"NO")
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
    $fecha_original = $fechas[$i] ?? '';
    $estado = $estados[$i] ?? 'NO'; // ← Valor por defecto "NO"

    // Convertir fecha
    if (empty($fecha_original)) {
        $fecha_convertida = '0000-00-00 00:00:00';
    } else {
        $fecha_convertida_dt = DateTime::createFromFormat('Y-m-d H:i:s', $fecha_original) ?: 
                               DateTime::createFromFormat('Y-m-d', $fecha_original);

        $fecha_convertida = $fecha_convertida_dt ? 
                            $fecha_convertida_dt->format('Y-m-d H:i:s') : 
                            '0000-00-00 00:00:00';
    }

    // Archivo
    $archivo_nombre = $archivos['name'][$i] ?? '';
    $archivo_tmp = $archivos['tmp_name'][$i] ?? '';

    if (!isset($archivo_tmp) || empty($archivo_tmp)) {
        $ruta_final = '';
    } else {
        $ruta_final = $ruta_base . basename($archivo_nombre);
        if (!move_uploaded_file($archivo_tmp, $ruta_final)) {
            echo json_encode(['success' => false, 'message' => "Error al mover archivo en índice $i"]);
            exit;
        }
    }

    // Registrar en BD con estado incluido
    $consulta = $ME->Registrar_Detalle_Requisito($idexpediente, $id_requisito, $ruta_final, $fecha_convertida, $idusu, $estado);
    if (!$consulta) {
        echo json_encode(['success' => false, 'message' => "Error al registrar en BD en índice $i"]);
        exit;
    }
}

echo json_encode(['success' => true, 'message' => "Todo registrado correctamente"]);
?>
