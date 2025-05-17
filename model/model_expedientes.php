<?php
    require_once 'model_conexion.php';

    class Modelo_Espedientes extends conexionBD{
        

        public function Listar_Expedientes(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_EXPEDIENTES()";
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Listar_expedientes_filtro($fechaini,$fechafin,$servicio){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_EXPEDIENTES_FILTRO(?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->bindParam(1,$fechaini);
            $query->bindParam(2,$fechafin);
            $query->bindParam(3,$servicio);

            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Registrar_Expediente($tipo_doc,$documentoFinal, $nombre, $apellido, $celular, $telefono, $email, $direc, $descrip, $vpresentacion, $ruc, $raz, $servi, $nroexpe, $folio, $idusu, $total,$distri){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_EXPEDIENTE(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$tipo_doc);
            $query ->bindParam(2,$documentoFinal);
            $query ->bindParam(3,$nombre);
            $query ->bindParam(4,$apellido);
            $query ->bindParam(5,$celular);
            $query ->bindParam(6,$telefono);
            $query ->bindParam(7,$email);
            $query ->bindParam(8,$direc);
            $query ->bindParam(9,$descrip);
            $query ->bindParam(10,$vpresentacion);
            $query ->bindParam(11,$ruc);
            $query ->bindParam(12,$raz);
            $query ->bindParam(13,$servi);
            $query ->bindParam(14,$nroexpe);
            $query ->bindParam(15,$folio);
            $query ->bindParam(16,$idusu);
            $query ->bindParam(17,$total);
            $query ->bindParam(18,$distri);
            $resultado = $query->execute();
            if($row = $query->fetchColumn()){
                return $row;
            }
            conexionBD::cerrar_conexion();
        }
        public function Registrar_Detalle_Requisito($idexpediente, $id_requisito, $ruta_final, $fecha_convertida, $idusu, $estado) {
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_DETALLE_REQUISITO(?,?,?,?,?,?)";
            $query = $c->prepare($sql);
            $query->bindParam(1, $idexpediente);
            $query->bindParam(2, $id_requisito);
        
            // Detectar si es cadena vacía y reemplazar por NULL
            if ($ruta_final === "") {
                $query->bindValue(3, null, PDO::PARAM_NULL);
            } else {
                $query->bindValue(3, $ruta_final, PDO::PARAM_STR);
            }
        
            $query->bindParam(4, $fecha_convertida);
            $query->bindParam(5, $idusu);
            $query->bindParam(6, $estado);

            $resultado = $query->execute();
            conexionBD::cerrar_conexion();
            return $resultado;
        }
        
        
        public function Eliminar_Servicio($id){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_ELIMINAR_SERVICIO(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
    
            $resul = $query->execute();
            if($resul){
                return 1;
            }else{
                return 0;
            }
            conexionBD::cerrar_conexion();
        }
        public function Cargar_Select_Area(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_SELECT_AREA()";
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                $arreglo[]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        function Registrar_detalle_practicas($id, $array_requisito){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_REQUISITOS(?, ?)"; 
            $query = $c->prepare($sql);
            $query->bindParam(1, $id, PDO::PARAM_INT);
            $query->bindParam(2, $array_requisito, PDO::PARAM_STR); // Debe ser STRING
            $resul = $query->execute();
            conexionBD::cerrar_conexion();
            return $resul ? 1 : 0;
        }

        function Modificar_detalle_practicas($id, $array_requisito){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_REQUISITOS(?, ?)"; 
            $query = $c->prepare($sql);
            $query->bindParam(1, $id, PDO::PARAM_INT);
            $query->bindParam(2, $array_requisito, PDO::PARAM_STR); // Debe ser STRING
            $resul = $query->execute();
            conexionBD::cerrar_conexion();
            return $resul ? 1 : 0;
        }
        public function Listar_detalle_requisitos($id){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_VER_DETALLE_REQUISITOS(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->bindParam(1,$id);

            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Eliminar_Detalle_requisito($id){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_ELIMINAR_DETALLE_REQUISITOS(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
    
            $resul = $query->execute();
            if($resul){
                return 1;
            }else{
                return 0;
            }
            conexionBD::cerrar_conexion();
        }
        public function Cargar_Select_Servicios(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_SERVICIOS()";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll();
            foreach($resultado as $resp){
                $arreglo[]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Listar_requisito_por_servicio($id_servicio){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_VER_DETALLE_REQUISITOS(?)";
            $arreglo = array();
            $query = $c->prepare($sql);
            $query->bindParam(1, $id_servicio); // Aquí estabas usando $id en lugar de $id_obra
        
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            
            // No necesitas el formato "data" para el uso que le estás dando
            // Simplemente devuelve el array de resultados
            return $resultado;
            
            // Esta línea nunca se ejecuta porque está después del return
            // conexionBD::cerrar_conexion();
        }
        public function Eliminar_expediente($id){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_ELIMINAR_EXPEDIENTE(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
    
            $resul = $query->execute();
            if($resul){
                return 1;
            }else{
                return 0;
            }
            conexionBD::cerrar_conexion();
        }
        public function Listar_Expedientes_archivados(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_EXPEDIENTES_ARCHIVADOS()";
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }

        public function Listar_expedientes_filtro_archivados($fechaini,$fechafin,$servicio){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_EXPEDIENTES_FILTRO_ARCHIVADOS(?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->bindParam(1,$fechaini);
            $query->bindParam(2,$fechafin);
            $query->bindParam(3,$servicio);

            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Modificar_Estado($id,$esta,$motivo,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_ESTADO(?,?,?,?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
            $query ->bindParam(2,$esta);
            $query ->bindParam(3,$motivo);
            $query ->bindParam(4,$idusu);

            $resul = $query->execute();
            if($resul){
                return 1;
            }else{
                return 0;
            }
            conexionBD::cerrar_conexion();
        }
        public function Listar_Historial_Espedientes($id){
            $c = conexionBD::conexionPDO();
            $arreglo = array();
            $sql = "CALL SP_LISTA_HISTORIAL_EXPEDIENTES(?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        
        }
        public function Listar_Requisitos_Espedientes($id){
            $c = conexionBD::conexionPDO();
            $arreglo = array();
            $sql = "CALL SP_LISTA_REQUISITOS_EXPEDIENTES(?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        
        }
        //REPORTERIA DE EXPEDIENTES POR FECHA Y PROVINCIA
        public function Listar_expedientes_filtro_fechas_provincia($fechaini,$fechafin,$provincia){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_EXPEDIENTES_FILTRO_FECHA_PROVINCIA(?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->bindParam(1,$fechaini);
            $query->bindParam(2,$fechafin);
            $query->bindParam(3,$provincia);

            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Listar_expedientes_filtro_fechas_estado($fechaini,$fechafin,$estado){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_EXPEDIENTES_FILTRO_FECHA_ESTADO(?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->bindParam(1,$fechaini);
            $query->bindParam(2,$fechafin);
            $query->bindParam(3,$estado);

            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Listar_expedientes_filtro_fechas_distrito($fechaini,$fechafin,$distrito){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_EXPEDIENTES_FILTRO_FECHA_DISTRITO(?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->bindParam(1,$fechaini);
            $query->bindParam(2,$fechafin);
            $query->bindParam(3,$distrito);

            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Buscar_Expediente($tipo_documento, $numero_documento, $numero_expediente){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_BUSCAR_EXPEDIENTE(?,?,?)";
            $arreglo = array();
            $query = $c->prepare($sql);
            $query->bindParam(1, $tipo_documento);
            $query->bindParam(2, $numero_documento);
            $query->bindParam(3, $numero_expediente);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            conexionBD::cerrar_conexion();
            return $resultado;
        }
        
        public function Listar_historial_expediente($id_expediente) {
            $c = conexionBD::conexionPDO();
            $arreglo = ["data" => []]; // ✅ Asegura que la clave "data" siempre existe
            $sql = "CALL SP_LISTA_HISTORIAL_EXPEDIENTE(?)";
            $query = $c->prepare($sql);
            $query->bindParam(1, $id_expediente);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        
            if (!empty($resultado)) { // ✅ Solo llena "data" si hay resultados
                $arreglo["data"] = $resultado;
            }
        
            conexionBD::cerrar_conexion();
            return $arreglo;
        }
         public function Listar_Historial_Espedientes_Cliente($id){
            $c = conexionBD::conexionPDO();
            $arreglo = array();
            $sql = "CALL SP_LISTA_HISTORIAL_EXPEDIENTES_CLIENTE(?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        
        }
      public function Buscar_persona_por_documento($numero_documento) {
    $c = conexionBD::conexionPDO();
    $sql = "CALL SP_BUSCAR_PERSONA_POR_DOCUMENTO(?)";
    $arreglo = array();

    try {
        $query  = $c->prepare($sql);
        $query->bindParam(1, $numero_documento);
        $query->execute();

        $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
        foreach ($resultado as $resp) {
            $arreglo["data"][] = $resp;
        }

        return $arreglo;
    } catch (Exception $e) {
        return ["error" => true, "message" => $e->getMessage()];
    } finally {
        // Esto garantiza que la conexión se cierre correctamente
        $c = null;
    }
}

    }




?>