<?php
    require_once 'model_conexion.php';

    class Modelo_Indicadores extends conexionBD{
        

        public function Listar_Indicadores(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_INDICADORES()";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
         public function Registrar_Indicadores($tipo,$indi,$descrip,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_INDICADOR(?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$tipo);
            $query ->bindParam(2,$indi);
            $query ->bindParam(3,$descrip);
            $query ->bindParam(4,$idusu);
            $query->execute();
            if($row = $query->fetchColumn()){
                return $row;
            }
            conexionBD::cerrar_conexion();
        }
        public function Modificar_Indicadores($id,$tipo,$indi,$descrip,$esta,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_INDICADOR(?,?,?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
            $query ->bindParam(2,$tipo);
            $query ->bindParam(3,$indi);
            $query ->bindParam(4,$descrip);
            $query ->bindParam(5,$esta);
            $query ->bindParam(6,$idusu);

            $query->execute();
            if($row = $query->fetchColumn()){
                return $row;
            }
            conexionBD::cerrar_conexion();
        }
        public function Eliminar_Indicador($id){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_ELIMINAR_INDICADOR(?)";
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
        public function Cargar_Select_Indicadores(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_INDICADORES()";
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
    }




?>