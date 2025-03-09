<?php
    require '../../model/model_provincias.php';
    $MPRO = new Modelo_Provincias();
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));

    $consulta = $MPRO->Eliminar_Provincia($id);
    echo $consulta;



?>