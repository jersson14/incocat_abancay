<?php
    require '../../model/model_servicios.php';
    $MS = new Modelo_Servicios(); // Instanciamos
    $consulta = $MS->Cargar_Select_Servicios();
    echo json_encode($consulta);
 
?>
