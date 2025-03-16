<?php
    require '../../model/model_reuniones.php';
    $MREU = new Modelo_Reuniones();//Instaciamos
    $id = strtoupper(htmlspecialchars($_POST['id'],ENT_QUOTES,'UTF-8'));

    $consulta = $MREU->Eliminar_Reuniones($id);
    echo $consulta;



?>