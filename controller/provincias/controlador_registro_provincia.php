<?php
    require '../../model/model_provincias.php';
    $MPRO = new Modelo_Provincias();
    $region = strtoupper(htmlspecialchars($_POST['region'],ENT_QUOTES,'UTF-8'));
    $provincia = strtoupper(htmlspecialchars($_POST['provincia'],ENT_QUOTES,'UTF-8'));
    $esta = strtoupper(htmlspecialchars($_POST['esta'],ENT_QUOTES,'UTF-8'));
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));

    $consulta = $MPRO->Registrar_Provincia($region,$provincia,$esta,$idusu);
    echo $consulta;



?>