<?php
require '../../model/model_regiones.php';
$MRE = new Modelo_Regiones();//Instaciamos
$id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');

$consulta = $MRE->Listar_provincias($id);

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
