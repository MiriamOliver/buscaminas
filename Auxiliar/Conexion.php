<?php
    require_once 'Parametros.php';
    require_once 'Modelo/Jugador.php';
    require_once 'Modelo/Tablero.php';

    class Conexion{
        public static $conexion;

        static function abrirConexion(){
            self::$conexion = new mysqli(Parametros::$host, Parametros::$usuario, Parametros::$passwd, Parametros::$bbdd);   
            if (mysqli_connect_errno(self::$conexion)) {
                die();
            }
        }

        static function getJugador($id, $nombre, $passwd){
            $p = false;
            $consulta = "SELECT * FROM " .Parametros::$TablaJugador. " WHERE ID like ? and nombre like ? and passw like ?";
            self::abrirConexion();
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("sss", $id, $nombre, $passwd);
            try{ 
                $stmt->execute();
                $resultado = $stmt->get_result();
                while($fila = $resultado->fetch_array()){
                    $p = new Jugador($fila["ID"] , $fila["nombre"], $fila["passw"], $fila["correo"], $fila["realizadas"], $fila["ganadas"], $fila["perdidas"], $fila["verificado"]);
                }
            }catch (Exception $e) { 
            }finally {
                $resultado->free_result();
                self::cerrarConexion();
            }
            return $p;
        }

        static function updateJugador($id, $nombre, $passwd){
            $conseguido = false;
            self::abrirConexion();
            $consulta = "UPDATE " .Parametros::$TablaJugador. " SET nombre = ?, passw = ? WHERE ID = ?"; 
            $stmt = self::$conexion->prepare($consulta);
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

        static function insertJugador($id, $nombre, $passwd, $correo){
            $conseguido = false;
            self::abrirConexion();
            $consulta = "INSERT INTO " .Parametros::$TablaJugador. " VALUES (?,?,?,?,0,0,0,0)"; 
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("ssss", $id, $nombre, $passwd, $correo); 
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

        static function insertTablero($id, $tablero, $tableroJugador, $mina){
            $conseguido = false;
            self::abrirConexion();
            $consulta = "INSERT INTO " .Parametros::$TablaTablero. " VALUES (?, ?, ?, ?, 0)"; 
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("sssi", $id, $tablero, $tableroJugador, $mina); 
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

        static function getTableroActivo($id){
            $tablero = [];
            $consulta = "SELECT " .Parametros::$TablaTablero.".ID, " .Parametros::$TablaTablero.".tablero, " .Parametros::$TablaTablero.".tableroHumano, " .Parametros::$TablaTablero.".mina FROM "
            .Parametros::$TablaTablero. " join " .Parametros::$TablaPartida. " on " 
            .Parametros::$TablaTablero.".ID = ".Parametros::$TablaPartida.".IDtablero join " .Parametros::$TablaJugador.
            " on ".Parametros::$TablaJugador.".ID = ".Parametros::$TablaPartida.".IDjugador WHERE " .Parametros::$TablaJugador."
            .ID like ? and " .Parametros::$TablaTablero.".completado = 0";
            self::abrirConexion();
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("s", $id); 
            try{
                $stmt->execute();
                $resultado = $stmt->get_result();
                if($fila = $resultado->fetch_array()){
                    array_push($tablero, new Tablero($fila["ID"], explode("#", $fila["tablero"]), count(explode("#", $fila["tablero"])), $fila["mina"])); 
                    array_push($tablero, new Tablero($fila["ID"], explode("#", $fila["tableroHumano"]), count(explode("#", $fila["tableroHumano"])), $fila["mina"]));
                }
            }catch (Execution $e){
            }finally{
                $resultado->free_result();
                self::cerrarConexion();
            }
            return $tablero;     
        }

        static function getTableros($id){
            $consulta = "SELECT * FROM " .Parametros::$TablaTablero. " WHERE IDJugador like ? and completado = 1";
            self::abrirConexion();
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("si", $id, $completado); 
            try{
                $stmt->execute();
                $resultado = $stmt->get_result();
                while($fila = $resultado->fetch_array()){
                    $partida[] = [
                        'id' => $fila["ID"],
                        'tablero' => $fila["tableroHumano"]
                    ];
                }   
            }catch (Execution $e){
            }finally{
                $resultado->free_result();
                self::cerrarConexion();
            }
            return $partida;     
        }


        static function updateTablero($id, $tJugador, $completado){
            $conseguido = false;
            self::abrirConexion();
            $consulta = "UPDATE " .Parametros::$TablaTablero. " SET tableroHumano = ? , completado = ? WHERE ID = ?"; 
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("sis", $tJugador, $completado, $id); 
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
/*
        static function rendirse($id){
            self::abrirConexion();
            self::$consulta = "DELETE FROM " .Parametros::$TablaTablero. " WHERE IDJugador like ? and completado = 0";
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("s", $id);
            try{ 
            $stmt->execute();
            }catch (Exception $e){
            }finally{ 
                self::cerrarConexion();
            }
        }
*/
        static function deleteTableros($id){
            $conseguido = false;
            self::abrirConexion();
            $consulta = "DELETE FROM " .Parametros::$TablaTablero. " WHERE ID IN (SELECT " .Parametros::$TablaPartida.".IDtablero 
            FROM " .Parametros::$TablaPartida. " WHERE IDjugador = ?)";
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("s", $id);
            try{ 
                $stmt->execute();
                $conseguido = true;
            }catch (Exception $e){
            }finally{ 
                self::cerrarConexion();
            }
            return $conseguido;
        }

        static function updatePartidasJugador($id, $puntuacion){
            self::abrirConexion();
            if($puntuacion == true){
                $consulta = "UPDATE " .Parametros::$TablaJugador. " SET realizadas = realizadas + 1, ganadas = ganadas + 1  WHERE ID = ?"; 
            }else{
                $consulta = "UPDATE " .Parametros::$TablaJugador. " SET realizadas = realizadas + 1, perdidas = perdidas + 1  WHERE ID = ?";
            }
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("s", $id);
            try{ 
                $stmt->execute();  
            }catch (Exception $e){
            }finally{   
                self::cerrarConexion();
            } 
        }

        
        static function insertPartida($idJugador, $idTablero){
            $conseguido = false;
            self::abrirConexion();
            $consulta = "INSERT INTO " .Parametros::$TablaPartida. " VALUES (?, ?)"; 
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("ss", $idJugador, $idTablero); 
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


        static function deleteJugador($id, $nombre, $passwd){ 
            $conseguido = false;
            self::abrirConexion();
            $consulta = "DELETE FROM " .Parametros::$TablaJugador. " WHERE ID like ? AND nombre = ? AND passw = ?";
            $stmt = self::$conexion->prepare($consulta);
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

        static function verificarJugador($id){
            $conseguido = false;
            self::abrirConexion();
            $consulta = "UPDATE " .Parametros::$TablaJugador. " SET verificado = '1' WHERE ID = ?"; 
            $stmt = self::$conexion->prepare($consulta);
            $stmt->bind_param("s", $id); 
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
    }
?>