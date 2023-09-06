<?php 
include("../cabecera.php");
$accion = (isset($_POST["accion"]))?$_POST["accion"]:"";
$txtid = (isset($_POST["txtid"]))?$_POST["txtid"]:0;
$txtidproveedor = (isset($_POST["txtidprovee"]))?$_POST["txtidprovee"]:0;

$txtproveedor = "";
$txtmonto = "";
$txtfecha = "";
$txtimg = "";

$txtnombre = "";
$txtruc = "";



$sentencia = $conexion->prepare("SELECT * FROM proveedor");
$sentencia->execute();
$lstproveedor = $sentencia->fetchAll();

switch($accion){
    case "seleccionCompra":
        $sentencia = $conexion->prepare("SELECT * FROM compras where id_compra = :id");
        $sentencia->bindParam(':id',$txtid);
        $sentencia->execute();
        $compraselecion = $sentencia->fetch();

        $txtproveedor = $compraselecion["id_proveedor"];
        $txtmonto = $compraselecion["monto"];
        $txtfecha = $compraselecion["fecha"];
        $txtimg = $compraselecion["img"];
        $txtid = $compraselecion["id_compra"];
        break;

    case "SeleccionEmpresa":
        $sentencia = $conexion->prepare("SELECT * FROM proveedor where id= :id");
        $sentencia->bindParam(':id',$txtidproveedor);
        $sentencia->execute();
        $empresaselecion = $sentencia->fetch();

        $txtidproveedor = $empresaselecion["id"];
        $txtnombre = $empresaselecion["nombre"];
        $txtruc = $empresaselecion["ruc"];
        break;
}

?>
<!-- modal para mostrar imagen ampliada -->
<div class="modal fade modal-lg" id="modalimg" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-compra-titulo-img"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-compra-contenido-img">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- modal -->
<div class="modal fade" id="modalregistrar" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="modal-registro-titulo"></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body" id="modal-registro-descripcion">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- registrar compra -->
<div id="contenedor-registro-principal">
    <h3 class="titulos text-primary">Registrar Compra</h3>
    <hr class="linea">
    <div class="registrar-container-compra">
        <div class="registrar-container-compra-form bg-light">
            <h4 class="text-primary titulo-contenedor">Registrar</h4>
            <form method="post" enctype="multipart/form-data" id="registro-formulario">
                <div class="registrar-compra-form-datos">
                    <input type="hidden" id="txtidreferencia" value="<?php echo $txtid;?>">
                    <div id="listar_empresas">
                        <?php include("select_empresa.php"); ?>
                    </div>
                    <div>
                        <label class="col-form-label mt-4 subtitulo" for="inputDefault">Monto:</label>
                        <input type="number" class="form-control" step="0.1" placeholder="$00.00" id="monto" value="<?php if($txtmonto!=""){echo $txtmonto;}?>">
                    </div>
                    <div>
                        <label class="col-form-label mt-4 subtitulo" for="inputDefault">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" value="<?php if($txtfecha==""){echo $fecha = date('Y-m-d');}else{echo $txtfecha;}?>">
                    </div>
                    <div>
                        <label class="col-form-label mt-4 subtitulo" for="inputDefault">Imagen:</label>
                        <input type="file" class="form-control" id="img" value="<?php if($txtimg!=""){echo $txtimg;}?>">
                    </div>
                        
                    <?php if($txtimg!=""){ ?>
                    <div id="contenedor-imagen-muestra">
                        <label class="col-form-label mt-4 subtitulo" for="inputDefault">Imagen seleccionada:</label>
                        <img class="img-thumbnail rounded" src="../../facturas/<?php echo $txtimg;?>" onclick="mostrar_imagen('<?php echo $txtimg;?>')" width="60" alt="no hay ninguna imagen registrada" srcset="">               
                    </div>
                    <?php } ?>

                </div>
            </form>
            <div>
                <button type="button" class="btn btn-success" id="registrar-compra">Registrar</button>
                <button type="button" class="btn btn-warning" id="modificar-compra">Modificar</button>
                <button type="button" class="btn btn-info" id="cancelar-compra">Cancelar</button>
            </div>
        </div>

        <div class="registrar-container-compra-tabla bg-light">
            <h4 class="text-primary titulo-contenedor">Compras</h4>
            <br>
            <div class="table-responsive tabla-ajuste" id="lst-compras">
                <?php include("lst_compras.php");?>
            </div> 
        </div>
    </div>
    <br>
    <br>

    <!-- registrar empresa -->
    <h3 class="titulos text-primary">Registrar Empresa</h3>
    <hr class="linea">
    <div class="registrar-container-proveedor">
        <div class="registrar-container-compra-form bg-light">
            <h4 class="text-primary titulo-contenedor">Registrar</h4>

            <form method="post">
                <div class="registrar-compra-form-datos">
                    <div>
                        <input type="hidden" id="idreferenciaprovee" value="<?php echo $txtidproveedor;?>">
                        <label class="col-form-label mt-4 subtitulo" for="inputDefault">Nombre:</label>
                        <input type="text" class="form-control" placeholder="nombre" id="nombre" value="<?php if($txtnombre!=""){echo $txtnombre;}?>" autocomplete="off">
                    </div>
                    <div>
                        <label class="col-form-label mt-4 subtitulo" for="inputDefault">RUC:</label>
                        <input type="text" class="form-control" placeholder="000000000" id="ruc" value="<?php if($txtruc!=""){echo $txtruc;}?>" autocomplete="off">
                    </div>
                </div>
            </form>
            <div>
                <button type="button" class="btn btn-success" id="registrar-empresa">Registrar</button>
                <button type="button" class="btn btn-warning" id="modificar-empresa">Modificar</button>
                <button type="button" class="btn btn-info" id="cancelar-empresa">Cancelar</button>
            </div>
        </div>

        <div class="registrar-container-compra-tabla bg-light">
            <h4 class="text-primary titulo-contenedor">Lista de Empresas</h4>
            <br>
            <div class="table-responsive tabla-ajuste" id="lst-empresa">
                <?php include("lst_empresa.php"); ?>
            </div> 
        </div>
    </div>
</div>

<br><br>

<?php 
include("../pie.php");
?>