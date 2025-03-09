<?php
    require '../../model/model_distritos.php';
    $MDI = new Modelo_Distritos();
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));

    $consulta = $MDI->Eliminar_Distrito($id);
    echo $consulta;



?>