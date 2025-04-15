<?php
    require '../../model/model_distritos.php';
    $MDIS = new Modelo_Distritos();
    $id_provincia = htmlspecialchars($_POST['id_provincia'],ENT_QUOTES,'UTF-8');
    $consulta = $MDIS->Cargar_distritos($id_provincia);
    echo json_encode($consulta);
 
?>
