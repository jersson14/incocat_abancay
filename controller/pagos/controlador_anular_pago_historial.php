<?php
    require '../../model/model_pagos.php';
    $MPA = new Modelo_Pagos();//Instaciamos
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));
    $motivo_anulacion = strtoupper(htmlspecialchars($_POST['motivo_anulacion'],ENT_QUOTES,'UTF-8'));
    $monto_anulado = strtoupper(htmlspecialchars($_POST['monto_anulado'],ENT_QUOTES,'UTF-8'));


    $consulta = $MPA->Anular_pago_historial($id,$idusu,$motivo_anulacion,$monto_anulado);
    echo $consulta;



?>