<?php 
include("../cabecera.php");
session_start();

$accion = (isset($_POST["accion"]))?$_POST["accion"]:"";
$txtfecha = (isset($_POST["fecha"]))?$_POST["fecha"]:"";

$total = 0;
$pdf = "";


if(isset($txtfecha)){
    $txtfecha2 = date("Y-m-d");
    $fechano = substr($txtfecha2,0,4);
    $fechames = substr($txtfecha2,5,2);
    $_SESSION["mes"] = $fechames;
    $_SESSION["anual"] = $fechano;

    $pdf = "pdfmes.php";
    $sentencia = $conexion->prepare("SELECT * FROM compras INNER JOIN proveedor on compras.id_proveedor = proveedor.id where YEAR(compras.fecha) = :fecha and MONTH(compras.fecha) = :fecha2 order by compras.fecha desc");
    $sentencia->bindParam(':fecha',$fechano);
    $sentencia->bindParam(':fecha2',$fechames);
    $sentencia->execute();
    $lstcompras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
}

switch($accion){
    case "dia":
        $sentencia = $conexion->prepare("SELECT * FROM compras INNER JOIN proveedor on compras.id_proveedor = proveedor.id where  DATE(compras.fecha) = DATE(:fecha) order by compras.fecha desc");
        $sentencia->bindParam(':fecha',$txtfecha);
        $sentencia->execute();
        $lstcompras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["dia"] = $txtfecha;
        $pdf = "pdfdia.php";
        break;

    case "mes";
        $fechano = substr($txtfecha,0,4);
        $fechames = substr($txtfecha,5,2);

        $sentencia = $conexion->prepare("SELECT * FROM compras INNER JOIN proveedor on compras.id_proveedor = proveedor.id where YEAR(compras.fecha) = :fecha and MONTH(compras.fecha) = :fecha2 order by compras.fecha desc");
        $sentencia->bindParam(':fecha',$fechano);
        $sentencia->bindParam(':fecha2',$fechames);
        $sentencia->execute();
        $lstcompras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["mes"] = $fechames;
        $_SESSION["anual"] = $fechano;
        $pdf = "pdfmes.php";
        break;

    case "anual":
        $fechano = substr($txtfecha,0,4);
        $sentencia = $conexion->prepare("SELECT * FROM compras INNER JOIN proveedor on compras.id_proveedor = proveedor.id where YEAR(compras.fecha) = :fecha order by compras.fecha desc");
        $sentencia->bindParam(':fecha',$fechano);
        $sentencia->execute();
        $lstcompras = $sentencia->fetchAll(PDO::FETCH_ASSOC);
        $_SESSION["anual"] = $fechano;
        $pdf = "pdfanual.php";
        break;
}   

?>
<div class="reporte-contendor" id="contenedor-reporte-principal">
    <div class="reporte-contenedor-1 bg-light">
        <form method="post">
        <h4 class="text-primary titulo-contenedor">Fecha</h4>
            <br>
            <input type="date" class="form-control" id="fecha" name="fecha" value="<?php echo $txtfecha;?>" required>
            <label class="col-form-label mt-4 subtitulo" for="inputDefault">Imprimir</label>
            <div>
                <button type="submit" class="btn btn-success" name="accion" value="dia">Dia</button>
                <button type="submit" class="btn btn-warning" name="accion" value="mes">Mes</button>
                <button type="submit" class="btn btn-info" name="accion" value="anual">Año</button>
            </div>
        </form>
    </div>

    <div class="reporte-contenedor-2 bg-light">
        <div class="reporte-contendor-titulo">
            <div class="reporteflex1">
                <h4 class="text-primary titulo-contenedor">Lista</h4>
            </div>
            <div class="reporteflex2">
                <button type="button" class="btn-pdf" onclick="printDiv('listar-tabla-fecha')" value="imprimir div">
                    <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-filetype-pdf" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M14 4.5V14a2 2 0 0 1-2 2h-1v-1h1a1 1 0 0 0 1-1V4.5h-2A1.5 1.5 0 0 1 9.5 3V1H4a1 1 0 0 0-1 1v9H2V2a2 2 0 0 1 2-2h5.5L14 4.5ZM1.6 11.85H0v3.999h.791v-1.342h.803c.287 0 .531-.057.732-.173.203-.117.358-.275.463-.474a1.42 1.42 0 0 0 .161-.677c0-.25-.053-.476-.158-.677a1.176 1.176 0 0 0-.46-.477c-.2-.12-.443-.179-.732-.179Zm.545 1.333a.795.795 0 0 1-.085.38.574.574 0 0 1-.238.241.794.794 0 0 1-.375.082H.788V12.48h.66c.218 0 .389.06.512.181.123.122.185.296.185.522Zm1.217-1.333v3.999h1.46c.401 0 .734-.08.998-.237a1.45 1.45 0 0 0 .595-.689c.13-.3.196-.662.196-1.084 0-.42-.065-.778-.196-1.075a1.426 1.426 0 0 0-.589-.68c-.264-.156-.599-.234-1.005-.234H3.362Zm.791.645h.563c.248 0 .45.05.609.152a.89.89 0 0 1 .354.454c.079.201.118.452.118.753a2.3 2.3 0 0 1-.068.592 1.14 1.14 0 0 1-.196.422.8.8 0 0 1-.334.252 1.298 1.298 0 0 1-.483.082h-.563v-2.707Zm3.743 1.763v1.591h-.79V11.85h2.548v.653H7.896v1.117h1.606v.638H7.896Z"/>
                    </svg>
                </button>
            </div>
        </div>
        <br>
        <div class="table-responsive tabla-ajuste" id="listar-tabla-fecha">
            <table class="table table-hover table-bordered">
                <thead>
                    <tr class="table-primary">
                        <th>Empresa</th>
                        <th>Fecha</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($lstcompras as $compra){
                        $total += $compra["monto"]; ?>
                    <tr class="table-info">
                        <td><?php echo $compra["nombre"];?></td>
                        <td><?php echo $compra["fecha"];?></td>
                        <td><?php echo $compra["monto"];?></td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div> 
        <br>
        <h4 class="text-white fw-bold">Total -> <?php echo round($total,1);?></h4>
    </div>
</div>

<?php 
include("../pie.php");
?>