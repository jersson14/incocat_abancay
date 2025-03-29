<?php
    require '../../model/model_servicios.php';

    $MS = new Modelo_Servicios(); // Instanciamos

    // Recibir y limpiar los datos
    $id = isset($_POST['id']) ? trim($_POST['id']) : '';
    $requisito = isset($_POST['requisito']) ? trim($_POST['requisito']) : '';

    // Validar que los datos no estén vacíos
    if (empty($id) || empty($requisito)) {
        echo "Error: Datos inválidos.";
        exit;
    }

    // Convertimos los datos en un array
    $array_requisito = explode(",", $requisito);

    // Validar que hay requisitos en el array
    if (count($array_requisito) === 0) {
        echo "Error: No se recibieron requisitos.";
        exit;
    }

    // Insertar cada requisito
    foreach ($array_requisito as $req) {
        $req = trim($req); // Eliminar espacios extra

        // Validar que el requisito no esté vacío
        if (empty($req)) {
            continue;
        }

        $consulta = $MS->Modificar_detalle_practicas($id, $req);
        if (!$consulta) {
            echo "Error al registrar el requisito: " . $req;
            exit;
        }
    }

    echo 1; // Confirmación de éxito
?>
