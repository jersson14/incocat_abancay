<?php
require '../../model/model_expedientes.php';
$ME = new Modelo_Espedientes();

$numero_documento = strtoupper(htmlspecialchars($_POST['numero_documento'], ENT_QUOTES, 'UTF-8'));

$consulta = $ME->Buscar_persona_por_documento($numero_documento);

// Validar si hay resultados y formatear correctamente
if (isset($consulta["data"]) && count($consulta["data"]) > 0) {
    echo json_encode([
        "data" => $consulta["data"]
    ]);
} else {
    echo json_encode([
        "data" => []
    ]);
}



?>