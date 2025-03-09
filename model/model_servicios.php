<?php
    require_once 'model_conexion.php';

    class Modelo_Servicios extends conexionBD{
        

        public function Listar_Servicios(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_SERVICIOS()";
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
        public function Registrar_Servicio($serv,$costo,$requisito,$descripcion,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_SERVICIO(?,?,?,?,?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$serv);
            $query ->bindParam(2,$costo);
            $query ->bindParam(3,$requisito);
            $query ->bindParam(4,$descripcion);
            $query ->bindParam(5,$idusu);

            $resultado = $query->execute();
            if($row = $query->fetchColumn()){
                return $row;
            }
            conexionBD::cerrar_conexion();
        }
        public function Modificar_Servicios($id,$serv,$costo,$requisito,$descripcion,$esta,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_SERVICIO(?,?,?,?,?,?,?)";
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
            $query ->bindParam(2,$serv);
            $query ->bindParam(3,$costo);
            $query ->bindParam(4,$requisito);
            $query ->bindParam(5,$descripcion);
            $query ->bindParam(6,$esta);
            $query ->bindParam(7,$idusu);

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
    }




?>