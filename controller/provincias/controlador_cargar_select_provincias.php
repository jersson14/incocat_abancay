<?php
    require '../../model/model_provincias.php';
    $MPRO = new Modelo_Provincias();
    $id_region = htmlspecialchars($_POST['id_region'],ENT_QUOTES,'UTF-8');
    $consulta = $MPRO->Cargar_Provincias($id_region);
    echo json_encode($consulta);
 
?>
