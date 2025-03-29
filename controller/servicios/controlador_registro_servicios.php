<?php
    require '../../model/model_servicios.php';
    $MS = new Modelo_Servicios();
    $serv = strtoupper(htmlspecialchars($_POST['serv'],ENT_QUOTES,'UTF-8'));
    $costo = strtoupper(htmlspecialchars($_POST['costo'],ENT_QUOTES,'UTF-8'));
    $descripcion = strtoupper(htmlspecialchars($_POST['descripcion'],ENT_QUOTES,'UTF-8'));
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));

    $consulta = $MS->Registrar_Servicio($serv,$costo,$descripcion,$idusu);
    echo $consulta;



?>