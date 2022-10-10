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

        static function getClienteTablero($id){
            self::$consulta = "SELECT * FROM " .Parametros::$TablaJugador. " WHERE DNI like ?";
            
        }
    }
?>