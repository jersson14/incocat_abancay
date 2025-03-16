<?php
    require '../../model/model_reuniones.php';
    $MREU = new Modelo_Reuniones();//Instaciamos
    $consulta = $MREU->Listar_Reuniones();
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
