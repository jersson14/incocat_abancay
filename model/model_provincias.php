<?php
    require_once 'model_conexion.php';

    class Modelo_Provincias extends conexionBD{
        

        public function listar_provincias_todo(){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_PROVINCIA()";
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
        public function Listar_provincias_filtro($region){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_LISTAR_REGION_FILTRO(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query->bindParam(1,$region);

            $query->execute();
            $resultado = $query->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultado as $resp){
                $arreglo["data"][]=$resp;
            }
            return $arreglo;
            conexionBD::cerrar_conexion();
        }
         public function Registrar_Provincia($region,$provincia,$esta,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_REGISTRAR_PROVINCIA(?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$region);
            $query ->bindParam(2,$provincia);
            $query ->bindParam(3,$esta);
            $query ->bindParam(4,$idusu);

            $query->execute();
            if($row = $query->fetchColumn()){
                return $row;
            }
            conexionBD::cerrar_conexion();
        }
        public function Modificar_Provincia($id,$region,$provincia,$esta,$idusu){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_MODIFICAR_PROVINCIA(?,?,?,?,?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id);
            $query ->bindParam(2,$region);
            $query ->bindParam(3,$provincia);
            $query ->bindParam(4,$esta);
            $query ->bindParam(5,$idusu);

            $query->execute();
            if($row = $query->fetchColumn()){
                return $row;
            }
            conexionBD::cerrar_conexion();
        }
        public function Eliminar_Provincia($id){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_ELIMINAR_PROVINCIA(?)";
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
        public function Listar_distritos_provincia($id){
            $c = conexionBD::conexionPDO();
            $arreglo = array();
            $sql = "CALL SP_LISTA_DISTRITOS_PROVINCIA(?)";
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
        public function Cargar_Provincias($id_region){
            $c = conexionBD::conexionPDO();
            $sql = "CALL SP_CARGAR_PROVINCIAS_POR_REGION(?)";
            $arreglo = array();
            $query  = $c->prepare($sql);
            $query ->bindParam(1,$id_region);
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