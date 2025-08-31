<?php 
ob_start();
include("header.php");

$fecha = date("Y-m-d");
$rut = $_SESSION['Rut'];

if($_GET['IDtp']){ //paquete
    $ID = $_GET['IDtp'];
    $Calidad = (int )$_REQUEST["Calidad"];
    $Transporte = (int )$_REQUEST["Transporte"];
    $Servicio = (int )$_REQUEST["Servicio"];
    $RPC = (int )$_REQUEST["RPC"];
    $Text = $_REQUEST["Text"];

    $sentencia = $conexion->prepare("INSERT INTO `comentario`(`Id_comentario`,`Id_usuario`,`Id_compra`,`Cal1`,`Cal2`,`Cal3`,`Cal4`,`Fecha_reseña`,`Comentario`) VALUES (NULL,'$rut','$ID','$Calidad','$Transporte','$Servicio','$RPC','$fecha','$Text');");
    if($sentencia->execute() === true){
        header("Location: Mis_compras.php");
    }
}

else if($_GET['IDth']){ //hotel
    $ID  = $_GET['IDth'];
    $Limpieza = (int )$_REQUEST["Limpieza"];
    $Servicio_ = (int )$_REQUEST["Servicio_"];
    $Decoracion = (int )$_REQUEST["Decoracion"];
    $Camas = (int )$_REQUEST["Camas"];
    $Text = $_REQUEST["Text"];
    
    $sentencia = $conexion->prepare("INSERT INTO `comentario`(`Id_comentario`,`Id_usuario`,`Id_compra`,`Cal1`,`Cal2`,`Cal3`,`Cal4`,`Fecha_reseña`,`Comentario`) VALUES (NULL,'$rut','$ID','$Limpieza','$Servicio_','$Decoracion','$Camas','$fecha','$Text');");
    if($sentencia->execute() === true){
        header("Location: Mis_compras.php");
    }
}
?>