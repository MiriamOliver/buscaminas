<?php
    require_once 'Parametros.php';
    require_once 'Modelo/Persona.php';
    require_once 'Modelo/Tablero.php';

    class Conexion{
        public static $conexion;
        public static $resultado;
        public static $consulta;

        static function abrirConexion(){
            self::$conexion = new mysqli(Parametros::$host, Parametros::$usuario, Parametros::$passwd, Parametros::$bbdd);   
            if (mysqli_connect_errno(self::$conexion)) {
                die();
            }
        }

        static function getJugador($id){
            self::$consulta = "SELECT * FROM " .Parametros::$TablaJugador. " WHERE DNI like ?";
            
        }

        static function updateJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "UPDATE " .Parametros::$TablaPersonas. " SET nombre = ?, passw = ? WHERE ID = ?"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("ssss", $nombre, $passwd, $id); 
            if($stmt->execute()){
                $conseguido = true;
            }             
            self::cerrarConexion(); 
            return $conseguido;
        }

        static function insertJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "INSERT INTO " .Parametros::$TablaJugador. " VALUES (?,?,?,?,?,?)"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sssiii", $id, $nombre, $passwd, 0, 0, 0); 
            if($stmt->execute()){
                $conseguido = true;   
            }   
            self::cerrarConexion(); 
            return $conseguido;
        }

        static function deleteJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "DELETE FROM " .Parametros::$TablaJugador. " WHERE ID like ? AND nombre like ? AND passw like ?";
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $id, $nombre, $passwd); 
            if($stmt->execute()){
                $conseguido = true;
            }                 
            self::cerrarConexion(); 
            return $conseguido;    
        }

        static function insertTablero($id, $tablero, $tableroJugador, $idJugador){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "INSERT INTO " .Parametros::$TablaTablero. " VALUES (?,?,?,?)"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("ssss", $id, $tablero, $tableroJugador, $idJugador); 
            if($stmt->execute()){
                $conseguido = true;   
            }   
            self::cerrarConexion(); 
            return $conseguido;
        }

        static function getTablero($id){

        }

        static function updateTablero($id, $tJugador){
            
        }

        static function insertPartida($idJugador, $tJugador, $idTablero){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "INSERT INTO " .Parametros::$TablaPartida. " VALUES (?,?,?)"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $idJugador, $idTablero, $tJugador); 
            if($stmt->execute()){
                $conseguido = true;   
            }   
            self::cerrarConexion(); 
            return $conseguido;
        }
    }
?>