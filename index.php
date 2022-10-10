<?php

    require_once 'Auxiliar/Conexion.php';
    require_once 'Modelo/Persona.php';
    header("Content-Type:application/json");

    $requestMethod = $_SERVER["REQUEST_METHOD"];
    $paths = $_SERVER['REQUEST_URI'];

    $param = explode("/",$paths);   
    unset($param[0]);
    if($requestMethod == "GET"){
        $datosRecibidos = file_get_contents("php://input");
        $datos = json_decode($datosRecibidos, true);
        
    }else if($requestMethod == "POST"){
        $datosRecibidos = file_get_contents("php://input");
        $datos = json_decode($datosRecibidos, true);
        
    }else if($requestMethod == "PUT"){
        $datosRecibidos = file_get_contents("php://input");
        $datos = json_decode($datosRecibidos, true);
        
    }else if($requestMethod == "DELETE"){
        
    }
    echo json_encode($mensaje, JSON_UNESCAPED_UNICODE);
?>