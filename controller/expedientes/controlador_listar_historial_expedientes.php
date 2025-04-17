<?php
require '../../model/model_expedientes.php';
$ME = new Modelo_Espedientes();
$id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');

$consulta = $ME->Listar_Historial_Espedientes($id);

if ($consulta && isset($consulta['data'])) {
    echo json_encode($consulta); // ✅ Devuelve "data" correctamente
} else {
    echo json_encode([
        "sEcho" => 1,
        "iTotalRecords" => 0,
        "iTotalDisplayRecords" => 0,
        "data" => [] // 🔴 Corrige "aaData" por "data"
    ]);
}
