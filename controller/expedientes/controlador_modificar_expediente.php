<?php
require '../../model/model_expedientes.php';
$ME = new Modelo_Espedientes();

$id = htmlspecialchars($_POST['id'], ENT_QUOTES, 'UTF-8');
$idexpe = htmlspecialchars($_POST['idexpe'], ENT_QUOTES, 'UTF-8');
$nombre = strtoupper(htmlspecialchars($_POST['nombre'], ENT_QUOTES, 'UTF-8'));
$apellido = strtoupper(htmlspecialchars($_POST['apellido'], ENT_QUOTES, 'UTF-8'));
$celular = htmlspecialchars($_POST['celular'], ENT_QUOTES, 'UTF-8');
$telefono = htmlspecialchars($_POST['telefono'], ENT_QUOTES, 'UTF-8');
$email = htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');
$direc = strtoupper(htmlspecialchars($_POST['direc'], ENT_QUOTES, 'UTF-8'));
$descrip = strtoupper(htmlspecialchars($_POST['descrip'], ENT_QUOTES, 'UTF-8'));
$vpresentacion = strtoupper(htmlspecialchars($_POST['vpresentacion'], ENT_QUOTES, 'UTF-8'));
$ruc = strtoupper(htmlspecialchars($_POST['ruc'], ENT_QUOTES, 'UTF-8'));
$raz = strtoupper(htmlspecialchars($_POST['raz'], ENT_QUOTES, 'UTF-8'));
$servi = strtoupper(htmlspecialchars($_POST['servi'], ENT_QUOTES, 'UTF-8'));
$nroexpe = strtoupper(htmlspecialchars($_POST['nroexpe'], ENT_QUOTES, 'UTF-8'));
$folio = strtoupper(htmlspecialchars($_POST['folio'], ENT_QUOTES, 'UTF-8'));
$total = htmlspecialchars($_POST['total'], ENT_QUOTES, 'UTF-8');
$distri = htmlspecialchars($_POST['distri'], ENT_QUOTES, 'UTF-8');
$idusu = htmlspecialchars($_POST['idusu'], ENT_QUOTES, 'UTF-8');

$resultado = $ME->Modificar_Expediente(
    $id,$idexpe, $nombre, $apellido, $celular, $telefono, $email, $direc, $descrip,
    $vpresentacion, $ruc, $raz, $servi, $nroexpe, $folio, $total, $distri, $idusu
);

echo $resultado;
