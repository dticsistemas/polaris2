
<div class="footer">
  <strong class="logo">
    <span class="sr"> 
    </span>	       
  </strong>
  <img src="<?php echo base_url();?>assets/img/logo_small.png" class="img-fluid logo-footer ">
  <p>
    Copyright 2020. All Rights Reserved.

  </p>


</div>
  </body>

  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

  <script src="assets/js/webfontloader.js"></script>
<script src="assets/js/default.js"></script>

<script>



		function agregarCarrito(id_producto){
			var r = confirm("agregar producto a cotizacion??");
			if (r == true) {
				$.ajax({
			     type:"POST", // la variable type guarda el tipo de la peticion GET,POST,..
			     url:"<?=base_url('cotizacion/agregar')?>", //url guarda la ruta hacia donde se hace la peticion
			     data:{'id_producto':id_producto}, // data recive un objeto con la informacion que se enviara al servidor
			     success:function(datos){ //success es una funcion que se utiliza si el servidor retorna informacion
			          $('#lb_cotizacion').html(datos);
			      }//,
			     //dataType: dataType // El tipo de datos esperados del servidor. Valor predeterminado: Intelligent Guess (xml, json, script, text, html).
			  });
			}

		}
	</script>
</html>
