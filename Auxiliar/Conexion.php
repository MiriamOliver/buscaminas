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
            $p = null;
            self::$consulta = "SELECT * FROM " .Parametros::$TablaJugador. " WHERE ID like ? and nombre like ? and passw like ?";
            self::abrirConexion();
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $id, $nombre, $passwd);
            try{ 
                $stmt->execute();
                self::$resultado = $stmt->get_result();
                while($fila = self::$resultado->fetch_array()){
                    $p = new Jugador($fila["ID"] , $fila["nombre"], $fila["passw"], $fila["realizadas"], $fila["ganadas"], $fila["perdidas"]);
                }
            }catch (Exception $e) { 
            }finally {
                self::$resultado->free_result();
                self::cerrarConexion();
            }
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
            try{
                if($stmt->execute()){
                    if ($stmt->affected_rows > 0) {
                        $conseguido = true;
                    }
                }   
            }catch (Exception $e) { 
            }finally {          
                self::cerrarConexion(); 
            }
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

        static function insertTablero($id, $tablero, $tableroJugador, $idJugador, $mina){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "INSERT INTO " .Parametros::$TablaTablero. " VALUES (?, ?, ?, ?, ?)"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("ssssi", $id, $tablero, $tableroJugador, $idJugador, $mina); 
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
            $tablero = [];
            self::$consulta = "SELECT * FROM " .Parametros::$TablaTablero. " WHERE IDJugador like ?";
            self::abrirConexion();
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("s", $id); 
            try{
                $stmt->execute();
                self::$resultado = $stmt->get_result();
                if($fila = self::$resultado->fetch_array()){
                    array_push($tablero, new Tablero($fila["ID"], explode("#", $fila["tablero"]), count(explode("#", $fila["tablero"])), $fila["mina"])); 
                    array_push($tablero, new Tablero($fila["ID"], explode("#", $fila["tableroHumano"]), count(explode("#", $fila["tableroHumano"])), $fila["mina"]));
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
                    if ($stmt->affected_rows > 0) {
                        $conseguido = true;
                    }
                }  
            }catch (Exception $e){
            }finally{           
                self::cerrarConexion();
            } 
            return $conseguido;
        }

        static function deleteTablero($id){
            self::abrirConexion();
            self::$consulta = "DELETE FROM " .Parametros::$TablaTablero. " WHERE IDJugador like ?";
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("s", $id);
            try{ 
            $stmt->execute();
            }catch (Exception $e){
            }finally{ 
                self::cerrarConexion();
            }
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
            try{ 
                $stmt->execute();  
            }catch (Exception $e){
            }finally{   
                self::cerrarConexion();
            } 
        }

        static function insertPartida($idJugador, $tJugador, $idTablero){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "INSERT INTO " .Parametros::$TablaPartida. " VALUES (?,?,?)"; 
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $idJugador, $idTablero, $tJugador); 
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
            $partida = null;
            self::$consulta = "SELECT * FROM " .Parametros::$TablaPartida. " WHERE IDjugador like ?";
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("s", $id); 
            try{
                $stmt->execute();
                self::$resultado = $stmt->get_result();
                while($fila = self::$resultado->fetch_array()){
                    $partida[] = [
                        'id' => $fila["IDtablero"],
                        'tablero' => $fila["tablero"]
                    ];
                }   
            }catch (Exception $e){
            }finally{
                self::$resultado->free_result();
                self::cerrarConexion();
            }
            return $partida;
        }

        static function deleteJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::abrirConexion();
            self::$consulta = "DELETE FROM " .Parametros::$TablaJugador. " WHERE ID like ? AND nombre = ? AND passw = ?";
            $stmt = self::$conexion->prepare(self::$consulta);
            $stmt->bind_param("sss", $id, $nombre, $passwd); 
            try{
                if($stmt->execute()){
                    if ($stmt->affected_rows > 0) {
                        $conseguido = true;
                    }
                } 
            }catch (Exception $e){
            }finally{                
                self::cerrarConexion();
            } 
            return $conseguido;    
        }

        static function cerrarConexion(){
            mysqli_close(self::$conexion);
        }
    }
?>