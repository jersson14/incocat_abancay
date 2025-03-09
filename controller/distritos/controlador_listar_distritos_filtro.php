<?php
    require '../../model/model_distritos.php';
    $MDI = new Modelo_Distritos();//Instaciamos
    $region = htmlspecialchars($_POST['region'],ENT_QUOTES,'UTF-8');
    $provincia = htmlspecialchars($_POST['provincia'],ENT_QUOTES,'UTF-8');

    $consulta = $MDI->Listar_distritos_filtro($region, $provincia);
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
