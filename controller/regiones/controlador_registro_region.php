<?php
    require '../../model/model_regiones.php';
    $MRE = new Modelo_Regiones();
    $region = strtoupper(htmlspecialchars($_POST['region'],ENT_QUOTES,'UTF-8'));
    $esta = strtoupper(htmlspecialchars($_POST['esta'],ENT_QUOTES,'UTF-8'));
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));

    $consulta = $MRE->Registrar_Region($region,$esta,$idusu);
    echo $consulta;



?>