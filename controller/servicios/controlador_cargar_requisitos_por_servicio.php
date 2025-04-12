<?php
    require '../../model/model_servicios.php';
    $MS = new Modelo_Servicios(); // Instanciamos
    $id_servicio = htmlspecialchars($_POST['id_servicio'], ENT_QUOTES, 'UTF-8');

    $consulta = $MS->Listar_requisito_por_servicio($id_servicio);
    
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
