<?php
    require '../../model/model_provincias.php';
    $MPR = new Modelo_Provincias();//Instaciamos
    $consulta = $MPR->listar_provincias_todo();
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
