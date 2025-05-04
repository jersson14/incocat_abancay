<?php
    require '../../model/model_expedientes.php';
    $ME = new Modelo_Espedientes();//Instaciamos
    $id_expediente = strtoupper(htmlspecialchars($_POST['id_expediente'],ENT_QUOTES,'UTF-8'));


    $consulta = $ME->Listar_historial_expediente($id_expediente);
    echo json_encode($consulta);



?>