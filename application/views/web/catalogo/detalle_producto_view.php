 <!-- The Modal -->
<div id="myModal" class="modal">
  <span class="close">×</span>
  <img class="modal-content" id="img01">
  <div id="caption"></div>
</div>

<div class="container">
<div class="panel panel-primary detalle_title">
  <div class="panel-heading text-center">

        <h3><strong><?php echo strtoupper($producto["nombre"]);?> </strong></h3>

  </div>
 </div>
 <div>
 	<div class="col-sm-6">
 		<div class="imagenes_miniatura">
            <?php
              $img_default="no_image.png";
              $img_descripcion="no imagen del producto";
              if (count($imagenes)>0){
                 	$imgaux=$imagenes[0];
                 	$img_default=$imgaux["imagen"];
                  $img_descripcion=$imgaux["descripcion"];
              foreach ($imagenes as $imagen):
              ?>
           <div class="imgmini">
				   <img class="img-responsive thumbnail" src="<?php echo base_url();?>assets/img/catalogo/thumbs/<?php echo $imagen["imagen"];?>"
                 alt="<?php echo $imagen['descripcion'];?>" onClick="visualizarProducto(this)"/>
			     </div>
              <?php
              endforeach;
              }
              ?>
    </div>
    <div class="marco_detalle_producto">
    <img id="img_detalle_producto" class="img_detalle_producto img-responsive" src="<?php echo base_url();?>assets/img/catalogo/medium/<?php echo $img_default;?>"
     alt="<?php echo $img_descripcion;?>"/>

      <button type="button" class="btn btn-primary btn-lg ampliar" onClick="ampliarProducto()">
        <span class="glyphicon glyphicon-fullscreen"></span>
      </button>

   </div>


 	</div>
 	<div class="col-sm-6">
    <h2>
      <strong>CODIGO: <?php echo strtoupper($producto["codigo"]);?> </strong>
      <div class="pull-right">
          <?php if(CARRITO){?>
      <button onclick="agregarCarrito(<?=$producto['id']?>)" class="btn btn-default" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> Adicionar</button>
    <?php }?>
    </div>
    </h2>

 		<h3>Especificaciones:</h3>
       <div class="alert alert-info" role="alert">
        <?php echo $producto["titulo"];?>
       </div>
				<?php echo $producto["especificaciones"];?>
 	</div>

 </div>



	<?php
	if(isset($producto["descripcion"])){
	echo "<h3>Descripción:</h3>";
	echo $producto["descripcion"];
    }
	if(isset($producto["servicios"])){
	echo "<h3>Servicios:</h3>";
	echo $producto["servicios"];
	}
	?>




<div class="row">
<?php

	$nombre="";
	if (count($similares)>0){
		echo "<h3> Productos Similares</h3>";
		foreach ($similares as $value):
	 	  $nombre = $value['nombre'];
	        $id = $value['id'];
      $codigo = $value['codigo'];
      $imagen = $value['imagen'];
	?>
  <div class="col-md-3">
    <div class="thumbnail">
      <a href="<?php echo base_url()."productos/detalle/".$id;?>">
        <img src="<?php echo base_url();?>assets/img/catalogo/small/<?php echo $imagen;?>"  alt="Lights" class="img-responsive"  style=" height:120px;">
        <div class="caption">
          <h4><?php echo $nombre;?></h4>
        </div>
      </a>
    </div>
  </div>
  <?php
    endforeach;
   }
  ?>
</div>

</div>



<script type="text/javascript">
var path_imagen_producto='<?php echo $img_default;?>';

 function visualizarProducto(imagen){

  var path=imagen.src.toString();
  var aux=path.lastIndexOf('/');
  path_imagen_producto=path.substring(aux+1);
  document.getElementById('img_detalle_producto').src='<?php echo base_url();?>assets/img/catalogo/medium/'+path_imagen_producto;
  document.getElementById('img_detalle_producto').alt=imagen.alt.toString();

};


// Get the modal
var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
//var img_action = document.getElementById('img_ampliar_img_detalle');
var img=document.getElementById('img_detalle_producto');
var modalImg = document.getElementById("img01");
var captionText = document.getElementById("caption");
/*img_action.onclick = function(){

    modal.style.display = "block";
    modalImg.src = img.src;
    captionText.innerHTML = img.alt;
}
*/
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
    modal.style.display = "none";
}





function ampliarProducto(){
    modal.style.display = "block";
    modalImg.src = '<?php echo base_url();?>assets/img/catalogo/'+path_imagen_producto;
    captionText.innerHTML = img.alt;
}

</script>
