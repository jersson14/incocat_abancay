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
        public function Registrar_Servicio($serv,$costo,$descripcion,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_SERVICIO(?,?,?,?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$serv);
            $query ->bindParam(2,$costo);
            $query ->bindParam(3,$descripcion);
            $query ->bindParam(4,$idusu);

            $resultado = $query->execute();
            if($row = $query->fetchColumn()){
                return $row;
            }
            conexionBD::cerrar_conexion();
        }
        public function Modificar_Servicios($id,$serv,$costo,$descripcion,$esta,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_SERVICIO(?,?,?,?,?,?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
            $query ->bindParam(2,$serv);
            $query ->bindParam(3,$costo);
            $query ->bindParam(4,$descripcion);
            $query ->bindParam(5,$esta);
            $query ->bindParam(6,$idusu);

            $resultado = $query->execute();
            if($row = $query->fetchColumn()){
                return $row;
            }
            conexionBD::cerrar_conexion();
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
    }




?>