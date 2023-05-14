<?php 

    $servidor = "192.168.1.71";
    $baseDeDatos = "appempleados";
    $usuario = "samsung";
    $contrasenia = "";

    try {
        $conexion = new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
    } catch(Exception $ex) {
        echo $ex->getMessage();
    }

?>