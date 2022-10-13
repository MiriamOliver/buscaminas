<?php
    require_once 'Parametros.php';
    require_once 'Modelo/Jugador.php';
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

        static function mostrarJugador($id, $nombre, $passwd){
            self::$consulta = "SELECT * FROM " .Parametros::$TablaJugador. " WHERE ID like ? and nombre like ? and passw like ?";
            self::abrirConexion();
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $id, $nombre, $passwd); 
            $stmt->execute();
            self::$resultado = $stmt->get_result();
            while($fila = self::$resultado->fetch_array()){
                $p = new Persona($fila["ID"] , $fila["nombre"], $fila["passw"], $fila["realizadas"], $fila["ganadas"], $fila["perdidas"]);

            }
            self::$resultado->free_result();
            self::cerrarConexion();
            return $p;
        }

        static function getJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::$consulta = "SELECT * FROM " .Parametros::$TablaJugador. " WHERE ID like ? and nombre like ? and passw like ?";
            self::abrirConexion();
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $id, $nombre, $passwd); 
            try{
                if($stmt->execute()){
                    $conseguido = true;
                }
            }catch (Exception $e) { 
            }finally {
                self::cerrarConexion();
            }
            return $conseguido;
        }

        static function updateJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "UPDATE " .Parametros::$TablaJugador. " SET nombre = ?, passw = ? WHERE ID = ?"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $nombre, $passwd, $id); 
            if($stmt->execute()){
                $conseguido = true;
            }             
            self::cerrarConexion(); 
            return $conseguido;
        }

        static function insertJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "INSERT INTO " .Parametros::$TablaJugador. " VALUES (?,?,?,0,0,0)"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $id, $nombre, $passwd); 
            try{
                if($stmt->execute()){
                    $conseguido = true;   
                }
            }catch (Exception $e){
            }finally {
                self::cerrarConexion();
            } 
            return $conseguido;
        }

        static function insertTablero($id, $tablero, $tableroJugador, $idJugador){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "INSERT INTO " .Parametros::$TablaTablero. " VALUES (?, ?, ?, ?)"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("ssss", $id, $tablero, $tableroJugador, $idJugador); 
            try{
                if($stmt->execute()){
                    $conseguido = true;   
                }
            }catch (Exception $e){
            }finally{   
            self::cerrarConexion(); 
            }
            return $conseguido;
        }

        static function getTablero($id){
            $tablero = null;
            self::$consulta = "SELECT * FROM " .Parametros::$TablaTablero. " WHERE IDJugador like ?";
            self::abrirConexion();
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("s", $id); 
            try{
                $stmt->execute();
                self::$resultado = $stmt->get_result();
                while($fila = self::$resultado->fetch_array()){
                    $tablero[0] = $fila["tablero"];
                    $tablero[1] = $fila["tableroHumano"];
                }
            }catch (Execution $e){
            }finally{
                self::$resultado->free_result();
                self::cerrarConexion();
            }
            return $tablero;     
        }


        static function updateTablero($id, $tJugador){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "UPDATE " .Parametros::$TablaTablero. " SET tableroHumano = ? WHERE IDJugador = ?"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("ss", $tJugador, $id); 
            try{
                if($stmt->execute()){
                    $conseguido = true;
                }  
            }catch (Exception $e){
            }finally{           
                self::cerrarConexion();
            } 
            return $conseguido;
        }

        static function deleteTablero($id){
            self::abrirConexion();
            self::$consulta = "DELETE FROM " .Parametros::$TablaTablero. " WHERE ID like ?";
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("s", $id); 
            $stmt->execute(); 
            self::cerrarConexion();
        }

        static function updatePartidasJugador($id, $puntuacion){
            self::abrirConexion();
            if($puntuacion == true){
                self::$consulta = "UPDATE " .Parametros::$TablaJugador. " SET realizadas = realizadas + 1, ganadas = ganadas + 1  WHERE ID = ?"; 
            }else{
                self::$consulta = "UPDATE " .Parametros::$TablaJugador. " SET realizadas = realizadas + 1, perdidas = perdidas + 1  WHERE ID = ?";
            }
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("s", $id); 
            $stmt->execute();     
            self::cerrarConexion(); 
        }

        static function insertPartida($idJugador, $tJugador){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "INSERT INTO " .Parametros::$TablaPartida. " VALUES (?,?)"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("ss", $idJugador, $tJugador); 
            try{
                if($stmt->execute()){
                    $conseguido = true;   
                }
            }catch (Execution $e){
            }finally{
                self::cerrarConexion(); 
            }   
            return $conseguido;
        }

        static function getPartida($id){
            self::abrirConexion();
            $partidas = null;
            self::$consulta = "SELECT * FROM " .Parametros::TablaPartida. " WHERE ID_jugador like ?";
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("s", $id); 
            $stmt->execute();
            self::$resultado = $stmt->get_result();
            while($fila = self::$resultado->fetch_array()){
                $partida[0] = $fila["ID_tablero"];
                $partida[1] = $fila["tablero"];
                $partidas[] = $partida;
            }
            self::$resultado->free_result();
            self::cerrarConexion();
            return $partidas;
        }

        static function deleteJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "DELETE FROM " .Parametros::$TablaJugador."join " .Parametros::$TablaTablero. "on " 
            .Parametros::TablaJugador.".ID = ".Parametros::$TablaTablero.".IDJugador join " .Parametros::$TablaPartida. "on "
            .Parametros::TablaJugador.".ID = ".Parametros::$TablaPartida.".ID_jugador WHERE ".Parametros::$TablaJugador.".ID like ? 
            AND ".Parametros::$TablaJugador.".nombre like ? AND ".Parametros::$TablaJugador.".passw like ?";
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $id, $nombre, $passwd); 
            if($stmt->execute()){
                $conseguido = true;
            }                 
            self::cerrarConexion(); 
            return $conseguido;    
        }

        static function cerrarConexion(){
            mysqli_close(self::$conexion);
        }
    }
?>