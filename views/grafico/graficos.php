<?php include("../cabecera.php");
$sentencia = $conexion->prepare("SELECT * FROM compras INNER JOIN proveedor on compras.id_proveedor = proveedor.id order by compras.fecha desc");
$sentencia->execute();
$lstcompras = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$sentencia = $conexion->prepare("SELECT * FROM proveedor");
$sentencia->execute();
$lstempresa = $sentencia->fetchAll(PDO::FETCH_ASSOC);

$montos = [];
$contador = "0";
$dinero = 0;

$suma1 = 0;
$suma2 = 0;

$suma3 = 0;


$fechareferencia = date('Y-m-d');
$fechareferencia1 = substr($fechareferencia,0,4);
$fechareferenciames = substr($fechareferencia,0,7);

for($i = 1; $i < 13; $i++){
    $union = (string)$i;
    $contador = $contador.$union;

    foreach($lstcompras as $compras){
        $fechacap = $compras["fecha"];
        $fechacapmes = substr($fechacap,5,2);
        $fechacapyear = substr($fechacap,0,4);
        $fechacapmes = (string)$fechacapmes;
    
        if ($fechacapmes == $contador && $fechacapyear == $fechareferencia1){
            $dinero += $compras["monto"];
            $suma1 += $compras["monto"];
        }
    }

    if ($contador == "09" || $contador == "10" || $contador == "11" || $contador == "12"){
        $contador = "";

    }else{
        $contador = "0";
    }

    $dinero = round($dinero, 1);

    $montos[] = $dinero;
    $dinero = 0;

}
?>
<div class="graficos-contenedor" id="contenedor-grafico-principal">
    <div class="graficos-subcontenedor bg-light">
        <h4 class="text-primary titulo-contenedor">Gráfico <?php echo $fechareferencia1;?> acumulativo por mes</h4>
        <?php 
        for($i = 0; $i < count($montos); $i++){
        ?>
            <input type="hidden" class="monto" value="<?php echo json_encode($montos[$i]);?>">
        <?php
        }
        ?>
        <input type="hidden" class="fechaactual" value="<?php echo $fechareferencia1;?>">
        <br>
        <div id="grafico-acumulativo-mes"></div>
        <h4 class="text-white fw-bold">Total -> <?php echo round($suma1,2); ?></h4>
    </div>
    <div class="graficos-subcontenedor bg-light">
        <h4 class="text-primary titulo-contenedor">Gráfico <?php echo $fechareferencia1;?> acumulativo por empresa</h4>
        <?php
        $monto = 0;
        foreach($lstempresa as $empresa){
            foreach($lstcompras as $compras){
                $fechacap = $compras["fecha"];
                $fechacapyear = substr($fechacap,0,4);

                if($empresa["id"] == $compras["id_proveedor"] && $fechacapyear == $fechareferencia1){
                    $monto += $compras["monto"];
                }
            }
            
            if($monto > 0){
                ?> 
                <input type="hidden" class="parametro1" value="<?php echo $empresa["nombre"]?>">
                <input type="hidden" class="valor1" value="<?php echo $monto?>">
                <?php
            }
            $monto = 0;
        }
        ?>
        <br>
        <div id="grafico-acumulativo-empresa"></div>
        <h4 class="text-white fw-bold">Total -> <?php echo round($suma1,2); ?></h4>
    </div>


    <div class="graficos-subcontenedor bg-light">
        <h4 class="text-primary titulo-contenedor">Gráficos</h4>
        <br>
        <?php
        $monto = 0;
        foreach($lstempresa as $empresa){
            foreach($lstcompras as $compras){
                $fechacap = $compras["fecha"];
                $fechacapyear = substr($fechacap,0,7);

                if($empresa["id"] == $compras["id_proveedor"] && $fechacapyear == $fechareferenciames){
                    $monto += $compras["monto"];
                    $suma2 += $compras["monto"];
                }
            }
            
            if($monto > 0){
                ?> 
                <input type="hidden" class="parametro2" value="<?php echo $empresa["nombre"]?>">
                <input type="hidden" class="valor2" value="<?php echo $monto?>">
                <?php
            }
            $monto = 0;
        }

        $monto2 = 0;
        foreach($lstempresa as $empresa){
            foreach($lstcompras as $compras){
                $fechacap = $compras["fecha"];
                $fechacapyear = substr($fechacap,0,4);

                if($empresa["id"] == $compras["id_proveedor"] && $fechacapyear == $fechareferencia1){
                    $monto2 += $compras["monto"];
                    $suma3 += $compras["monto"];
                }
            }
            
            if($monto2 > 0){
                ?> 
                <input type="hidden" class="parametro3" value="<?php echo $empresa["nombre"]?>">
                <input type="hidden" class="valor3" value="<?php echo $monto2?>">
                <?php
            }
            $monto2 = 0;
        }
        

        for($i = 0; $i < count($montos); $i++){
        ?>
            <input type="hidden" class="monto2" value="<?php echo json_encode($montos[$i]);?>">
        <?php
        }
        ?>

        <div class="grafico-pie">
            <div class="item-grid-pie" id="grafico-acumulativo-empresa-mes">
                <h4 class="text-white fw-bold">Total -> <?php echo round($suma2,2);?></h4>
            </div>
            <div class="item-grid-pie" id="grafico-acumulativo-empresa-año">
                <h4 class="text-white fw-bold">Total -> <?php echo round($suma3,2);?></h4>
            </div>
            <div class="item-grid-pie" id="grafico-acumulativo-gastos-año">
                <h4 class="text-white fw-bold">Total -> <?php echo round($suma1,2);?></h4>
            </div>
        </div>
    </div>
</div>
<br><br>

<?php 
include("../pie.php");
?>