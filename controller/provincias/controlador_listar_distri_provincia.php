<?php
    require '../../model/model_provincias.php';
    $MPRO = new Modelo_Provincias();
$id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');

$consulta = $MPRO->Listar_distritos_provincia($id);

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
