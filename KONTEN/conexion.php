<?php

//conexión
$conexion = new mysqli("konten.localhost", "root", "", "konten");
$conexion->set_charset("utf8");
// Verificar la conexión
if ($conexion->connect_error) {
    die("Error de conexión a la base de datos: " . $conexion->connect_error);
}


?>