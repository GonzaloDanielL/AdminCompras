<?php
include("../conexion.php");

$accion = $_POST["accion"];
$fecha = new DateTime();


if($accion == "registrar"){
    $txtprovedor = $_POST["idprovee"]; 
    $txtmonto = $_POST["monto"]; 
    $txtfecha = $_POST["fecha"]; 
    $txtimg  = (isset($_FILES['img']['name']))?$_FILES['img']['name']:"";

    if(empty($_FILES["img"])){
        $nombreimg = "imagen.jpg";
    }else{
        $nombreimg = $fecha->getTimestamp()."-".$_FILES["img"]["name"];
        move_uploaded_file($_FILES['img']['tmp_name'],'../facturas/'.$nombreimg);
    }
    
    $sentencia = $conexion->prepare("INSERT INTO compras(monto, fecha, img, id_proveedor)values(:monto, :fecha, :img, :id_proveedor)");
    $sentencia->bindParam(":monto",$txtmonto);
    $sentencia->bindParam(":fecha",$txtfecha);
    $sentencia->bindParam(":img",$nombreimg);
    $sentencia->bindParam(":id_proveedor",$txtprovedor);
    $sentencia->execute();

}elseif ($accion == "modificar"){
    $txtprovedor = $_POST["idprovee"]; 
    $txtmonto = $_POST["monto"]; 
    $txtfecha = $_POST["fecha"]; 
    $txtimg  = (isset($_FILES['img']['name']))?$_FILES['img']['name']:"";
    $txtID = $_POST["idreferencia"];

    if($txtimg!=""){
        $nombreimg = $fecha->getTimestamp()."-".$_FILES["img"]["name"];
        move_uploaded_file($_FILES['img']['tmp_name'],'../facturas/'.$nombreimg);

        $sentencia = $conexion->prepare("SELECT img FROM compras where id_compra = :id");
        $sentencia->bindParam(':id',$txtID);
        $sentencia->execute();
        $lista=$sentencia->fetch(PDO::FETCH_LAZY);
    
        if(isset($lista["img"]) &&($lista["img"]!="imagen.jpg") ){
    
            if(file_exists('../facturas/'.$lista["img"])){
    
                unlink('../facturas/'.$lista["img"]);
           }
    
        }

        $sentencia = $conexion->prepare("UPDATE compras set img = :img where id_compra = :id");
        $sentencia->bindParam(":img",$nombreimg);
        $sentencia->bindParam(":id",$txtID);
        $sentencia->execute();
    }
    
    $sentencia = $conexion->prepare("UPDATE compras set monto = :monto, fecha = :fecha, id_proveedor = :id_proveedor where id_compra = :id");
    $sentencia->bindParam(":monto",$txtmonto);
    $sentencia->bindParam(":fecha",$txtfecha);
    $sentencia->bindParam(":id_proveedor",$txtprovedor);
    $sentencia->bindParam(":id",$txtID);
    $sentencia->execute();

}elseif ($accion == "borrar"){
    $txtID = $_POST["idreferencia"];

    $sentencia = $conexion->prepare("SELECT img FROM compras WHERE id_compra = :id");
    $sentencia->bindParam(':id',$txtID);
    $sentencia->execute();
    $lista = $sentencia->fetch(PDO::FETCH_LAZY);
    
    if(isset($lista["img"]) && ($lista["img"]!="imagen.jpg") ){
    
        if(file_exists("../facturas/".$lista["img"])){
    
            unlink("../facturas/".$lista["img"]);
        }
    
    }

    $sentencia = $conexion->prepare("DELETE FROM compras WHERE id_compra = :id");
    $sentencia->bindParam(":id", $txtID);
    $sentencia->execute();
}

include("../views/registrar/lst_compras.php");

?>