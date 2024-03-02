<?php

$accion = $_POST['accion'];
$valor = $_POST['valor'];

// Conexión a la base de datos
$conexion = new mysqli("localhost", "usuario", "contraseña", "basededatos");

// Verificar conexión
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

// Realizar la acción según lo solicitado
switch ($accion) {
    case 'pagar':
        // Código para borrar el saldo de la base de datos
        $consulta = "UPDATE tabla SET saldo = 0 ";
        $conexion->query($consulta);
        break;
    
    case 'abonar':
        // Código para restar el valor ingresado a la base de datos
        $consulta = "UPDATE tabla SET saldo = saldo - $valor";
        $conexion->query($consulta);
        break;

    case 'anotar':
        // Código para sumar el valor a la base de datos
        $consulta = "UPDATE tabla SET saldo = saldo + $valor";
        $conexion->query($consulta);
        break;
}

// Cerrar conexión
$conexion->close();

// Redireccionar al archivo principal
header("Location: index.html");

?>