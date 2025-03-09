<?php
    require '../../model/model_distritos.php';
    $MDI = new Modelo_Distritos();//Instaciamos
    $consulta = $MDI->listar_distritos_todo();
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
