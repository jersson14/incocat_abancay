<?php
// Capturar todos los errores y warnings
error_reporting(E_ALL);
ini_set('display_errors', 0); // No mostrar errores en pantalla
ini_set('log_errors', 1);

// Iniciar buffer de salida para capturar cualquier output no deseado
ob_start();

require '../../model/model_expedientes.php';

header('Content-Type: application/json');
date_default_timezone_set('America/Lima');

try {
    $ME = new Modelo_Espedientes();
    
    // Debug: verificar datos recibidos
    error_log("POST: " . print_r($_POST, true));
    error_log("FILES: " . print_r($_FILES, true));
    
    // Recibir datos POST
    $idexpediente = $_POST['idexpediente'] ?? null;
    $dni = $_POST['dni'] ?? null;
    $idusu = $_POST['idusu'] ?? null;
    $requisitos = $_POST['requisitos'] ?? [];
    $seleccionados = $_POST['seleccionados'] ?? [];
    
    if (!$idexpediente || !$dni || !$idusu) {
        throw new Exception("Faltan datos necesarios: idexpediente, dni o idusu");
    }
    
    if (empty($requisitos)) {
        throw new Exception("No se recibieron requisitos para modificar");
    }
    
    // Definir ruta relativa y ruta base absoluta para guardar archivos
    $ruta_relativa = "../../archivos_expedientes/$dni/";
    $ruta_base = $ruta_relativa;
    
    if (!file_exists($ruta_base)) {
        if (!mkdir($ruta_base, 0755, true)) {
            throw new Exception("No se pudo crear el directorio: $ruta_base");
        }
    }
    
    $resultados = [];
    
    // Procesar cada requisito
    foreach ($requisitos as $index => $id_requisito_expe) {
        $esta_seleccionado = isset($seleccionados[$index]) && $seleccionados[$index] == 1;
        $estado = $esta_seleccionado ? 'SI' : 'NO';
        $fecha_actual = $esta_seleccionado ? date('Y-m-d H:i:s') : null;

        $archivo_nombre = null;
        if (isset($_FILES['archivos']['name'][$index]) && 
            $_FILES['archivos']['error'][$index] === UPLOAD_ERR_OK &&
            !empty($_FILES['archivos']['name'][$index])) {

            $archivo_tmp = $_FILES['archivos']['tmp_name'][$index];
            $nombre_original = basename($_FILES['archivos']['name'][$index]);
            $extension = pathinfo($nombre_original, PATHINFO_EXTENSION);

            $extensiones_permitidas = ['pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'txt'];
            if (!in_array(strtolower($extension), $extensiones_permitidas)) {
                throw new Exception("Extensión no permitida: $nombre_original");
            }

            $nuevo_nombre = "req_{$idexpediente}_{$id_requisito_expe}_" . time() . "_" . rand(1000, 9999) . "." . $extension;
            $ruta_final = $ruta_base . $nuevo_nombre;

            if (!move_uploaded_file($archivo_tmp, $ruta_final)) {
                throw new Exception("Error al mover archivo de $id_requisito_expe");
            }

            // Guardar ruta relativa + nombre de archivo para la base de datos
            $archivo_nombre = $ruta_relativa . $nuevo_nombre;
        }

        $modificado = $ME->Modificar_Detalle_Requisito(
            $id_requisito_expe,
            $archivo_nombre,
            $fecha_actual,
            $idusu,
            $estado
        );

        $resultados[] = [
            'id_requisito_expe' => $id_requisito_expe,
            'estado' => $estado,
            'archivo' => $archivo_nombre,
            'fecha' => $fecha_actual,
            'modificado' => $modificado
        ];
    }

    // Limpiar buffer y enviar respuesta JSON
    ob_clean();
    echo json_encode([
        'success' => true,
        'message' => 'Proceso finalizado. Algunos requisitos pudieron no requerir modificación.',
        'data' => $resultados
    ]);
    
} catch (Exception $e) {
    // Limpiar buffer en caso de error
    ob_clean();
    error_log("Error en controlador: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => $e->getMessage()
    ]);
} catch (Error $e) {
    // Capturar errores fatales
    ob_clean();
    error_log("Error fatal en controlador: " . $e->getMessage());
    echo json_encode([
        'success' => false, 
        'message' => "Error interno del servidor"
    ]);
}
