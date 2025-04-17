<?php
    require '../../model/model_expedientes.php';
    $ME = new Modelo_Espedientes();//Instaciamos
    $consulta = $ME->Listar_Expedientes_archivados();
    if($consulta){
        echo json_encode($consulta);
    }else{
        echo '{
            "sEcho": 1,
            "iTotalRecords": "0",
            "iTotalDisplayRecords": "0",
            "aaData": []
        }';
    }
?>
