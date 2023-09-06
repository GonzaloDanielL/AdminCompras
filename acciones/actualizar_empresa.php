<?php 
include("../conexion.php");

$txtdato = $_POST["dato"];

$sentencia = $conexion->prepare("SELECT * FROM proveedor");
$sentencia->execute();
$lstproveedor = $sentencia->fetchAll();

include("../views/registrar/select_empresa.php");

?>