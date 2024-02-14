<?php

// Verificar si se ha enviado el formulario
session_start();

if (!empty($_POST["enviar"])) {
    if (!empty($_POST["usuario"]) and !empty($_POST["password"])) {
        $usuario=$_POST["usuario"];
        $password=$_POST["password"];
        $sql=$conexion->query(" select * from usuarios where usuario='$usuario' and password='$password'");
        if ($datos=$sql->fetch_object()) {
            $_SESSION["id"]=$datos->id;
            $_SESSION["nombre"]=$datos->nombres;
            $_SESSION["apellido"]=$datos->apellidos;
            header("location:leer.php");    
        } else {
            echo"<div class='alert alert-danger'>Usuario no registrado</div>" ;
        }
        

    } else{
        echo"<div class='alert alert-danger'>Campos vacios</div>";
    }
    
    

}

?>