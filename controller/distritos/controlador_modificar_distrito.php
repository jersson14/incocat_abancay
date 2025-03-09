<?php
    require '../../model/model_distritos.php';
    $MDI = new Modelo_Distritos();
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));
    $provincia = strtoupper(htmlspecialchars($_POST['provincia'],ENT_QUOTES,'UTF-8'));
    $distrito = strtoupper(htmlspecialchars($_POST['distrito'],ENT_QUOTES,'UTF-8'));
    $esta = strtoupper(htmlspecialchars($_POST['esta'],ENT_QUOTES,'UTF-8'));
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'],ENT_QUOTES,'UTF-8'));

    $consulta = $MDI->Modificar_Distrito($id,$provincia,$distrito,$esta,$idusu);
    echo $consulta;



?>