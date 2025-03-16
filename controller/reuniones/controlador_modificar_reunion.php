<?php
    require '../../model/model_reuniones.php';
    $MREU = new Modelo_Reuniones();//Instaciamos
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));
    $cliente = strtoupper(htmlspecialchars($_POST['cliente'],ENT_QUOTES,'UTF-8'));
    $descrip = strtoupper(htmlspecialchars($_POST['descrip'],ENT_QUOTES,'UTF-8'));
    $fechahora = strtoupper(htmlspecialchars($_POST['fechahora'],ENT_QUOTES,'UTF-8'));
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));

    $consulta = $MREU->Modificar_Reuniones($id,$cliente,$descrip,$fechahora,$idusu);
    echo $consulta;



?>