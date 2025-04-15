<?php
    require '../../model/model_expedientes.php';
    $ME = new Modelo_Espedientes(); // Instanciamos

    // Recibimos los datos enviados desde console_expediente.js
    $tipo_doc = strtoupper(htmlspecialchars($_POST['tipo_doc'], ENT_QUOTES, 'UTF-8'));
    $documentoFinal = strtoupper(htmlspecialchars($_POST['documentoFinal'], ENT_QUOTES, 'UTF-8'));
    $nombre = strtoupper(htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8'));
    $apellido = strtoupper(htmlspecialchars($_POST['apellido'], ENT_QUOTES, 'UTF-8'));
    $celular = strtoupper(htmlspecialchars($_POST['celular'], ENT_QUOTES, 'UTF-8'));
    $telefono = strtoupper(htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8'));
    $email = strtoupper(htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8'));

    $direc = strtoupper(htmlspecialchars($_POST['direc'], ENT_QUOTES, 'UTF-8'));
    $descrip = strtoupper(htmlspecialchars($_POST['descrip'], ENT_QUOTES, 'UTF-8'));
    $vpresentacion = strtoupper(htmlspecialchars($_POST['vpresentacion'], ENT_QUOTES, 'UTF-8'));
    $ruc = strtoupper(htmlspecialchars($_POST['ruc'], ENT_QUOTES, 'UTF-8'));
    $raz = strtoupper(htmlspecialchars($_POST['raz'], ENT_QUOTES, 'UTF-8')); // Ejemplo de nuevo dato
    $servi = strtoupper(htmlspecialchars($_POST['servi'], ENT_QUOTES, 'UTF-8')); // Ejemplo de nuevo dato
    $nroexpe = strtoupper(htmlspecialchars($_POST['nroexpe'], ENT_QUOTES, 'UTF-8')); // Ejemplo de nuevo dato
    $folio = strtoupper(htmlspecialchars($_POST['folio'], ENT_QUOTES, 'UTF-8')); // Ejemplo de nuevo dato
    $idusu = strtoupper(htmlspecialchars($_POST['idusu'], ENT_QUOTES, 'UTF-8')); // Ejemplo de nuevo dato
    $total = strtoupper(htmlspecialchars($_POST['total'], ENT_QUOTES, 'UTF-8')); // Ejemplo de nuevo dato
    $distri = strtoupper(htmlspecialchars($_POST['distri'], ENT_QUOTES, 'UTF-8')); // Ejemplo de nuevo dato

    // Llamamos al método del modelo con todos los datos
    $consulta = $ME->Registrar_Expediente($tipo_doc,$documentoFinal, $nombre, $apellido, $celular, $telefono, $email, $direc, $descrip, $vpresentacion, $ruc, $raz, $servi, $nroexpe, $folio, $idusu, $total,$distri);
    echo $consulta;
?>