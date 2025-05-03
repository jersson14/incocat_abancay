<?php
require '../../model/model_expedientes.php';

$ME = new Modelo_Espedientes();

$tipo_documento = htmlspecialchars($_POST['tipo_documento'], ENT_QUOTES, 'UTF-8');
$numero_documento = htmlspecialchars($_POST['numero_documento'], ENT_QUOTES, 'UTF-8');
$numero_expediente = htmlspecialchars($_POST['numero_expediente'], ENT_QUOTES, 'UTF-8');

$datos = $ME->Buscar_Expediente($tipo_documento, $numero_documento, $numero_expediente);

if ($datos && count($datos) > 0) {
    echo json_encode([
        'status' => 'ok',
        'data' => $datos[0]  // Retornamos solo el primer resultado
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Expediente no encontrado'
    ]);
}
?>