<?php
include("../conexion.php");

$accion = $_POST["accion"];


if($accion == "registrar"){
    $txtnombre = $_POST["nombre"]; 
    $txtruc = $_POST["ruc"]; 
    
    $sentencia = $conexion->prepare("INSERT INTO proveedor(nombre,ruc)values(:nombre, :ruc)");
    $sentencia->bindParam(":nombre",$txtnombre);
    $sentencia->bindParam(":ruc",$txtruc);
    $sentencia->execute();

}elseif ($accion == "modificar"){
    $txtID = $_POST["idreferenciaprovee"];
    $txtnombre = $_POST["nombre"]; 
    $txtruc = $_POST["ruc"]; 
    
    $sentencia = $conexion->prepare("UPDATE proveedor set nombre = :nombre, ruc = :ruc where id = :id");
    $sentencia->bindParam(":nombre",$txtnombre);
    $sentencia->bindParam(":ruc",$txtruc);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

}elseif ($accion == "borrar"){

    try {
        $txtID = $_POST["idreferenciaprovee"];

        $sentencia = $conexion->prepare("DELETE FROM proveedor WHERE id = :id");
        $sentencia->bindParam(":id", $txtID);
        $sentencia->execute();
    }catch(Exception $e){
        echo "la empresa que se quiere borrar tiene registros de compra, borre o cambie el proveedor en los registros de compra";
    }
}

include("../views/registrar/lst_empresa.php");

?>