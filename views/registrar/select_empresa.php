<?php 

if(!isset($txtproveedor)){
    $txtproveedor = "";
}

?>

<label class="col-form-label mt-4 subtitulo" for="inputDefault">Empresa:</label>
<select class="form-select" id="idproveedor">
    <?php foreach($lstproveedor as $provee){?>
    <option value="<?php echo $provee["id"];?>" <?php echo ($txtproveedor == $provee["id"])?"selected":"" ?>><?php echo $provee["nombre"];?></option>
    <?php  } ?>
</select>