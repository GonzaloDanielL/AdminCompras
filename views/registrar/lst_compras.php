<?php 
$sentencia = $conexion->prepare("SELECT * FROM compras INNER JOIN proveedor on compras.id_proveedor = proveedor.id order by compras.fecha desc");
$sentencia->execute();
$lstcompras = $sentencia->fetchAll(PDO::FETCH_ASSOC);

?>

<table class="table table-hover table-bordered">
    <thead>
        <tr class="table-primary">
            <th>Empresa</th>
            <th>Monto</th>
            <th>Fecha</th>
            <th>IMG</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($lstcompras as $compras){?>
        <tr class="table-info">
            <td><?php echo $compras["nombre"];?></td>
            <td><?php echo $compras["monto"];?></td>
            <td><?php echo $compras["fecha"];?></td>
            <td>
                <img src="../../facturas/<?php echo $compras["img"];?>" class="img-thumbnail" onclick="mostrar_imagen('<?php echo $compras['img'];?>')" width="50" alt="<?php echo $compras["img"];?>">
            </td>
            <td class="align-middle">
                <form method="post">
                    <input type="hidden" name="txtid" value="<?php echo $compras["id_compra"];?>">
                    <button class="boton-tabla-seleccionar bg-success" type="submit" name="accion" value="seleccionCompra">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-hand-index-thumb-fill" viewBox="0 0 16 16">
                        <path d="M8.5 1.75v2.716l.047-.002c.312-.012.742-.016 1.051.046.28.056.543.18.738.288.273.152.456.385.56.642l.132-.012c.312-.024.794-.038 1.158.108.37.148.689.487.88.716.075.09.141.175.195.248h.582a2 2 0 0 1 1.99 2.199l-.272 2.715a3.5 3.5 0 0 1-.444 1.389l-1.395 2.441A1.5 1.5 0 0 1 12.42 16H6.118a1.5 1.5 0 0 1-1.342-.83l-1.215-2.43L1.07 8.589a1.517 1.517 0 0 1 2.373-1.852L5 8.293V1.75a1.75 1.75 0 0 1 3.5 0z"/>
                        </svg>
                    </button>
                </form>
                <button type="button" class="boton-tabla-borrar bg-danger" onclick="borrar_compra(<?php echo $compras['id_compra'];?>)">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                    <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                    </svg>
                </button>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>