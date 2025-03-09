<?php
    require '../../model/model_regiones.php';
    $MRE = new Modelo_Regiones();//Instaciamos
    $consulta = $MRE->Cargar_Select_Regiones();
    echo json_encode($consulta);
 
?>
