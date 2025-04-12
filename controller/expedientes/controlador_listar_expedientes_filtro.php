<?php
    require '../../model/model_expedientes.php';
    $ME = new Modelo_Espedientes();//Instaciamos
    $fechaini = htmlspecialchars($_POST['fechaini'],ENT_QUOTES,'UTF-8');
    $fechafin = htmlspecialchars($_POST['fechafin'],ENT_QUOTES,'UTF-8');
    $servicio = htmlspecialchars($_POST['servicio'],ENT_QUOTES,'UTF-8');

    $consulta = $ME->Listar_expedientes_filtro($fechaini,$fechafin,$servicio);
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
