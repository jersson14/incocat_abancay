<?php
    require '../../model/model_servicios.php';
    $MS = new Modelo_Servicios();//Instaciamos
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));

    $consulta = $MS->Eliminar_Servicio($id);
    echo $consulta;



?>