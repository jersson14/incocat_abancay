<?php
    require '../../model/model_provincias.php';
    $MPR = new Modelo_Provincias();//Instaciamos
    $region = htmlspecialchars($_POST['region'],ENT_QUOTES,'UTF-8');

    $consulta = $MPR->Listar_provincias_filtro($region);
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
