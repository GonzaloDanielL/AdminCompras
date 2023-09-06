<?php 
ob_start();

include('../conexion.php'); 
session_start();
date_default_timezone_set('America/Lima');
$fechano = $_SESSION["anual"];
$fechames = $_SESSION["mes"];

$sentencia = $conexion->prepare("SELECT * FROM compras INNER JOIN proveedor on compras.id_proveedor = proveedor.id where YEAR(compras.fecha) = :fecha and MONTH(compras.fecha) = :fecha2 order by compras.fecha desc");
$sentencia->bindParam(':fecha',$fechano);
$sentencia->bindParam(':fecha2',$fechames);
$sentencia->execute();
$lstcompras = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$total = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="http://localhost/SISTEMALUNA/css/estilo.css">
    <link rel="stylesheet" href="http://localhost/SISTEMALUNA/css/bootstrap3.css">
    <link rel="stylesheet" href="http://localhost/SISTEMALUNA/css/bootstrap.min3.css">
    <title>pdf</title>
</head>
<body>
    <div class="col-md-7">
        <table class="table table-bordered">
            <thead>
                <tr class="table-primary">
                    <th class="tabla-rojo">Empresa</th>
                    <th class="tabla-rojo">Fecha</th>
                    <th class="tabla-rojo">Monto</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($lstcompras as $compra){
                    $total += $compra["monto"]; ?>
                <tr class="table-info">
                    <td><?php echo $compra["nombre"];?></td>
                    <td><?php echo $compra["fecha"];?></td>
                    <td>S/<?php echo $compra["monto"];?></td>
                </tr>
                <?php } ?>
                <tr>
                    <th></th>
                    <th class="tabla-rojo">Total</th>
                    <th>S/<?php echo round($total,1)?></th>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>

<?php 
$html = ob_get_clean();


require_once '../dompdf/autoload.inc.php';
use Dompdf\Dompdf;
$dompdf = new Dompdf();

$options = $dompdf->getOptions();
$options->set(array('isRemoteEnabled' => true));
$dompdf->setOptions($options);

$dompdf->loadHtml($html);

// (Optional) Setup the paper size and orientation
$dompdf->setPaper('letter');

// Render the HTML as PDF
$dompdf->render();

// Output the generated PDF to Browser
$dompdf->stream("REPORTE-MES-".$fechano."-".$fechames.".pdf", array("Attachment" => true));

?>