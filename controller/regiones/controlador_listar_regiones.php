<?php
    require '../../model/model_regiones.php';
    $MRE = new Modelo_Regiones();//Instaciamos
    $consulta = $MRE->Listar_Regiones();
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
