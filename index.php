<?php

    require_once 'Auxiliar/Conexion.php';
    require_once 'Modelo/Persona.php';
    header("Content-Type:application/json");

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $paths = $_SERVER['REQUEST_URI'];

    $param = explode("/",$paths);   
    unset($param[0]);
    if($requestMethod != "GET" || $requestMethod != "POST" || $requestMethod != "PUT" || $requestMethod != "DELETE"){
        $cod = 405;
        $desc = 'Verbo no admitido';
    }else{
        $param = explode("/",$paths);   
        unset($param[0]);
        if($requestMethod == "GET"){
            $datosRecibidos = file_get_contents("php://input");
            $datos = json_decode($datosRecibidos, true);
            if(empty($param[1])){
                $cod = 400;
                $desc = 'Faltan parámetros';
            }else{
                if($param[1] == 'Cliente3'){
                    $datosRecibidos = file_get_contents("php://input");
                    $datos = json_decode($datosRecibidos, true);
                    if (Conexion::getJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                        $cod = 200;
                        $desc = 'Ok. Información de las partidas';
                    }
                }else if($param[1] == 'Juego1'){
                    if(empty($param[2]) && empty($param[3])){
                        $datosRecibidos = file_get_contents("php://input");
                        $datos = json_decode($datosRecibidos, true);
                        if(Conexion::getJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                            $t = new Tablero(10, 3);
                            $tJugador = new Tablero(10, 3);
                            $t->generarTablero();
                            $t->addMinas();
                            $tJugador->generarTablero();
                            if (Conexion::insertTablero($Tablero::getId(), $tJugador, $t, $datos['id'])){
                                $cod = 200;
                                $desc = 'Ok. Información guardada';
                            }
                        }
                    }else if(!is_numeric($param[2]) || !is_numeric($param[3])){
                        $cod = 400;
                        $desc = 'Solo caractéres numéricos';
                    }else if(empty($param[3])){
                        $cod = 400;
                        $desc = 'Falta un parámetro';
                    }else if(Sparam[2] < $param[3]){
                        $cod = 400;
                        $desc = 'El primer número debe ser mayor';
                    }else{
                        $datosRecibidos = file_get_contents("php://input");
                        $datos = json_decode($datosRecibidos, true);
                        if(Conexion::getJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                            $t = new Tablero($param[2], $param[3]);
                            $tJugador = new Tablero($param[2], $param[3]);
                            $t->generarTablero();
                            $t->addMinas();
                            $tJugador->generarTablero();
                            if (Conexion::insertTablero($Tablero::getId(), $tJugador, $t, $datos['id'])){
                                $cod = 200;
                                $desc = 'Ok. Información guardada';
                            }
                        }
                    }
                }else if($param[1] == 'Juego2'){
                    if(!is_numeric($param[2])){
                        $cod = 400;
                        $desc = 'Solo caractéres numéricos';
                    }else if(empty($param[2])){
                        $cod = 400;
                        $desc = 'Faltan parámetros';
                    }else{
                        $datosRecibidos = file_get_contents("php://input");
                        $datos = json_decode($datosRecibidos, true);
                        if(Conexion::getJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                            $tablero = Conexion::getTablero($datos['id']);
                            if($tablero != false){
                                $t = str_split($tablero[0]);
                                $tHumano = str_split($tablero[1]);
                                $result = $t->Tablero::comprobarTablero($param[2]);
                                if(!result){
                                    $tHumano->Tablero::guardarResultado($t->Tablero::getResultado());
                                    if(Conexion::updateTablero($datos['id'], $t, $tHumano)){
                                        $cod = 202;
                                        $desc = 'Tablero actualizado';
                                    }
                                }else{
                                    Conexion::deleteTablero($datos['id']);
                                    if(Conexion::insertPartidas($datos['id'], $tHumano, $idTablero)){
                                        $cod = 202;
                                        $desc = 'Perdistes';
                                    }
                                }    
                            }
                        }else{
                            $cod = 400;
                            $desc = 'Tablero no encontrado';
                        }
                    }
                }else{
                    $cod = 400;
                    $desc = 'Datos incorrectos';
                }
            }     
        }else if($requestMethod == "POST"){
            if(empty($param[1])){
                $cod = 400;
                $desc = 'Faltan parámetros';
            }else if(count($param) > 1){
                $cod = 400;
                $desc = 'Demasiados parámetros';
            }else{
                if($param[1] == 'Cliente1'){
                    $datosRecibidos = file_get_contents("php://input");
                    $datos = json_decode($datosRecibidos, true);
                    if (Conexion::insertJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                        $cod = 201;
                        $desc = 'Anadido con éxito';
                    }
                }else{
                    $cod = 400;
                    $desc = 'Petición incorrecta';
                }
            }
        }else if($requestMethod == "PUT"){
            if(empty($param[1])){
                $cod = 400;
                $desc = 'Faltan parámetros';
            }else if(count($param) > 1){
                $cod = 400;
                $desc = 'Demasiados parámetros';
            }else{
                if($param[1] == 'Cliente2'){
                    $datosRecibidos = file_get_contents("php://input");
                    $datos = json_decode($datosRecibidos, true);
                    if (Conexion::updateJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                        $cod = 202;
                        $desc = 'Cliente modificado con éxito';
                    }else{
                        $cod = 400;
                        $desc = 'Datos incorrectos';
                    }
                }else{
                    $cod = 400;
                    $desc = 'Petición incorrecta';
                }
            }           
        }else if($requestMethod == "DELETE"){
            if(empty($param[1])){
                $cod = 400;
                $desc = 'Faltan parámetros';
            }else if(count($param) > 1){
                $cod = 400;
                $desc = 'Demasiados parámetros';
            }else{
                if($param[1] == 'Cliente4'){
                    $datosRecibidos = file_get_contents("php://input");
                    $datos = json_decode($datosRecibidos, true);
                    if (Conexion::deleteJugador($datos['id'], $datos['nombre'], $datos['passw'])){
                        $cod = 202;
                        $desc = 'Cliente borrado con éxito';
                    }else{
                        $cod = 400;
                        $desc = 'Datos incorrectos';
                    }
                }else{
                    $cod = 400;
                    $desc = 'Petición incorrecta';
                }
            }
        }
    }   
    echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
?>