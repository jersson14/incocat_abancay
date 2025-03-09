<?php
    require '../../model/model_regiones.php';
    $MRE = new Modelo_Regiones();
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));
    $region = strtoupper(htmlspecialchars($_POST['region'],ENT_QUOTES,'UTF-8'));
    $esta = strtoupper(htmlspecialchars($_POST['esta'],ENT_QUOTES,'UTF-8'));
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));

    $consulta = $MRE->Modificar_Región($id,$region,$esta,$idusu);
    echo $consulta;



?>