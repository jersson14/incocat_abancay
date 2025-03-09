<?php
    require '../../model/model_regiones.php';
    $MRE = new Modelo_Regiones();//Instaciamos
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));

    $consulta = $MRE->Eliminar_Region($id);
    echo $consulta;



?>