<?php
    require '../../model/model_reuniones.php';
    $MREU = new Modelo_Reuniones();//Instaciamos
    $consulta = $MREU->Cargar_Select_Clientes();
    echo json_encode($consulta);
 
?>
