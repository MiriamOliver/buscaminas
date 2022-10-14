<?php

    require_once 'Auxiliar/Conexion.php';
    require_once 'Modelo/Jugador.php';
    require_once 'Modelo/Tablero.php';
    header("Content-Type:application/json");

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $paths = $_SERVER['REQUEST_URI'];

    if($requestMethod != "GET" && $requestMethod != "POST" && $requestMethod != "PUT" && $requestMethod != "DELETE"){
        $cod = 405;
        $desc = 'Verbo no admitido';
        $resultado = $desc;
    }else{
        $param = explode("/",$paths);   
        unset($param[0]);
        if($requestMethod == "GET"){
            $datosRecibidos = file_get_contents("php://input");
            $datos = json_decode($datosRecibidos, true);
            if(empty($param[1])){
                $cod = 400;
                $desc = 'Faltan parámetros';
                $resultado = 'Faltan parámetros';
            }else{
                if($param[1] == 'Cliente3' && count($param) == 1){
                    $datosRecibidos = file_get_contents("php://input");
                    $datos = json_decode($datosRecibidos, true);
                    $p = Conexion::mostrarJugador($datos['id'], $datos['nombre'], $datos['passw']);
                    if ($p != null){
                        $resultado = [
                            'Jugador' => $p,
                            'Partidas' => $partida = Conexion::getPartida($datos['id'])
                        ];
                            $cod = 200;
                            $desc = 'Ok. Información de las partidas';
                    }else{
                        $cod = 400;
                        $desc = 'Ok. No se encuentra';
                        $resultado = $desc;
                    }
                }else if($param[1] == 'Juego1' && count($param) == 1 || count($param) == 3){
                    if(empty($param[2]) && empty($param[3])){
                        $datosRecibidos = file_get_contents("php://input");
                        $datos = json_decode($datosRecibidos, true);
                        if(Conexion::getJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                            $id = rand(0, 99999);
                            $t = new Tablero($id, 10, 3);
                            $tJugador = new Tablero($id, 10, 3);
                            $t->generarTablero();
                            $t->addMinas();
                            $t->construirPistas();
                            $tJugador->generarTablero();
                            if (Conexion::insertTablero($id, implode("#",$t->getTab()), implode("#", $tJugador->getTab()), $datos['id'], 3)){
                                $cod = 200;
                                $desc = 'Ok. Información guardada';
                                $resultado = $tJugador->getTab();
                            }
                        }
                    }else if(!is_numeric($param[2]) || !is_numeric($param[3])){
                        $cod = 400;
                        $desc = 'error';
                        $resultado = 'Solo caractéres numéricos';
                    }else if(empty($param[3])){
                        $cod = 400;
                        $desc = 'error';
                        $resultado = 'Falta un parámetro';
                    }else if($param[2] < $param[3]){
                        $cod = 400;
                        $desc = 'error';
                        $resultado = 'El primer número debe ser mayor';
                    }else{
                        $datosRecibidos = file_get_contents("php://input");
                        $datos = json_decode($datosRecibidos, true);
                        if(Conexion::getJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                            $id = rand(0, 99999);
                            $t = new Tablero($id, $param[2], $param[3]);
                            $tJugador = new Tablero($id, $param[2], $param[3]);
                            $t->generarTablero();
                            $t->addMinas();
                            $t->construirPistas();
                            $tJugador->generarTablero();
                            if (Conexion::insertTablero($id, implode("#",$t->getTab()), implode("#", $tJugador->getTab()), $datos['id'], $param[3])){
                                $cod = 200;
                                $desc = 'Ok. Información guardada';
                                $resultado = $tJugador->getTab();
                            }
                        }
                    }
                }else if($param[1] == 'Juego2' && count($param) == 2){
                    if(!is_numeric($param[2])){
                        $cod = 400;
                        $desc = 'error';
                        $resultado = 'Solo caractéres numéricos';
                    }else if(empty($param[2]) && $param[2] != 0){
                        $cod = 400;
                        $desc = 'error';
                        $resultado = 'Faltan parámetros';
                    }else{
                        $datosRecibidos = file_get_contents("php://input");
                        $datos = json_decode($datosRecibidos, true);
                        if(Conexion::getJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                            $tablero = Conexion::getTablero($datos['id']);
                            if($tablero != null){
                                $t = $tablero[0];
                                $tHumano = $tablero[1];
                                $result = $t->comprobarTablero($param[2]);
                                if(!$result){
                                    $tHumano->guardarResultado($param[2], $t->getResultado($param[2]));
                                    if($t->getMina() == $tHumano->cantCasillas()){
                                        Conexion::deleteTablero($datos['id']);
                                        Conexion::updatePartidasJugador($datos['id'], true);
                                        if(Conexion::insertPartida($datos['id'], implode("#", $tHumano->getTab()), $tHumano->getId())){
                                            $cod = 202;
                                            $desc = 'OK';
                                            $resultado = [
                                                'resultado' => 'GANASTES',
                                                'tablero' => $tHumano->getTab()
                                            ];
                                        }
                                    }else if(Conexion::updateTablero($datos['id'], implode("#", $tHumano->getTab()))){
                                        $cod = 202;
                                        $desc = 'Tablero actualizado';
                                        $resultado = $tHumano->getTab();
                                    }
                                }else if($result){
                                    $tHumano->guardarResultado($param[2], $t->getResultado($param[2]));
                                    Conexion::deleteTablero($datos['id']);
                                    Conexion::updatePartidasJugador($datos['id'], false);
                                    if(Conexion::insertPartida($datos['id'], implode("#", $tHumano->getTab()), $tHumano->getId())){
                                        $cod = 202;
                                        $desc = 'OK';
                                        $resultado = [
                                            'resultado' => 'PERDISTES',
                                            'tablero' => $tHumano->getTab()
                                        ];
                                    }
                                }    
                            }
                        }else{
                            $cod = 400;
                            $desc = 'error';
                            $resultado = 'Tablero no encontrado';
                        }
                    }
                }else{
                    $cod = 400;
                    $desc = 'error';
                    $resultado = 'Datos incorrectos';
                }
            }     
        }else if($requestMethod == "POST"){
            if(empty($param[1])){
                $cod = 400;
                $desc = 'error';
                $resultado = 'Faltan parámetros';
            }else if(count($param) > 1){
                $cod = 400;
                $desc = 'error';
                $resultado = 'Demasiados parámetros';
            }else{
                if($param[1] == 'Cliente1'){
                    $datosRecibidos = file_get_contents("php://input");
                    $datos = json_decode($datosRecibidos, true);
                    if (Conexion::insertJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                        $cod = 201;
                        $desc = 'Anadido con éxito';
                        $resultado = 'Jugador registrado';
                    }else{
                        $cod = 400;
                        $desc = 'ERROR';
                        $resultado = 'Usuario ya registrado';
                    }
                }else{
                    $cod = 400;
                    $desc = 'Petición incorrecta';
                    $resultado = 'El jugador no se pudo registrar';
                }
            }
        }else if($requestMethod == "PUT"){
            if(empty($param[1])){
                $cod = 400;
                $desc = 'error';
                $resultado = 'Faltan parámetros';
            }else if(count($param) > 1){
                $cod = 400;
                $desc = 'error';
                $resultado = 'Demasiados parámetros';
            }else{
                if($param[1] == 'Cliente2'){
                    $datosRecibidos = file_get_contents("php://input");
                    $datos = json_decode($datosRecibidos, true);
                    if (Conexion::updateJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                        $cod = 202;
                        $desc = 'OK';
                        $resultado = 'Cliente modificado con éxito';
                    }else{
                        $cod = 400;
                        $desc = 'Datos incorrectos';
                        $resultado = 'El cliente no se pudo modificar';
                    }
                }else{
                    $cod = 400;
                    $desc = 'error';
                    $resultado = 'Petición incorrecta';
                }
            }           
        }else if($requestMethod == "DELETE"){
            if(empty($param[1])){
                $cod = 400;
                $desc = 'error';
                $resultado = 'Faltan parámetros';
            }else if(count($param) > 1){
                $cod = 400;
                $desc = 'error';
                $resultado = 'Demasiados parámetros';
            }else{
                if($param[1] == 'Cliente4'){
                    $datosRecibidos = file_get_contents("php://input");
                    $datos = json_decode($datosRecibidos, true);
                    if (Conexion::deleteJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                        $cod = 202;
                        $desc = 'OK';
                        $resultado = 'Cliente borrado con éxito';
                    }else{
                        $cod = 400;
                        $desc = 'error';
                        $resultado = 'Datos incorrectos';
                    }
                }else{
                    $cod = 400;
                    $desc = 'error';
                    $resultado = 'Petición incorrecta';
                }
            }
        }
    }   
    echo json_encode($resultado, JSON_UNESCAPED_UNICODE);
    header("HTTP/1.1 " .$cod. " " .$desc);
?>