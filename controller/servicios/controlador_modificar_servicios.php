<?php
    require '../../model/model_servicios.php';
    $MS = new Modelo_Servicios();
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));
    $serv = strtoupper(htmlspecialchars($_POST['serv'],ENT_QUOTES,'UTF-8'));
    $costo = strtoupper(htmlspecialchars($_POST['costo'],ENT_QUOTES,'UTF-8'));
    $descripcion = strtoupper(htmlspecialchars($_POST['descripcion'],ENT_QUOTES,'UTF-8'));
    $esta = strtoupper(htmlspecialchars($_POST['esta'],ENT_QUOTES,'UTF-8'));
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));

    $consulta = $MS->Modificar_Servicios($id,$serv,$costo,$descripcion,$esta,$idusu);
    echo $consulta;



?>