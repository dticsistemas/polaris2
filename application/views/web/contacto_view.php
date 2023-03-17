<div class="content-section-a caja" id="contact">

		<div class="container ">

				<div class="row">
						<div class="col-sm-4">
							<div class="jumbotron">

								<p class="comentario">Para comunicarse con nosotros solo complete el siguiente formulario con sus datos
								personales y nuestros ejecutivos se contactarán con usted a la brevedad.</p>
								<?php
										 echo validation_errors();
										 echo $resultado;
								?>
											<?php
													$atributos = array('class' => 'form-horizontal', 'id' => 'formulario_contacto');
													echo form_open('contacto',$atributos);
											?>
									<div class="form-group">
								    <label for="nombre">Nombre y Apellido(*):</label>
								    <input class="form-control" name="nombre" id="nombre" type="text">
								  </div>
									<div class="form-group">
								    <label for="empresa">Empresa:</label>
								    <input class="form-control" name="empresa" id="empresa" type="text">
								  </div>
									<div class="form-group">
								    <label for="email">Email(*):</label>
								    <input class="form-control" name="email" id="email" type="email">
								  </div>
									<div class="form-group">
								    <label for="empresa">Telefono(*):</label>
								    <input class="form-control" name="telefono" id="telefono" type="text">
								  </div>
									<div class="form-group">
								    <label for="motivo">Motivo:</label>
										<select class="form-control" name="motivo" id="motivo">
															<option class="form-control" selected="selected" value="Consulta o Sugerencia">Consulta o Sugerencia</option>
															<option class="form-control" value="Estado del pedido">Estado del pedido</option>
											<option value="Presupuesto">Presupuesto</option>

										</select>
								  </div>
									<div class="form-group">
								    <label for="mensaje">Mensaje(*):</label>
								    <textarea  class="form-control" name="mensaje" id="mensaje"></textarea>
								  </div>
									<div class="form-group">
									<label><span >(*)</span> Ingrese el Codigo de verificacion: </label>
													<?php echo $captcha['image'];
													 // echo "<p> ".$captcha['word']."</p>";
													?>

													<input class="form-control" type="text" name="captcha" value="" />
									</div>
													<input  class="form-control" name="button2" id="button2" class="btn btn-secondary" value="Enviar Consulta" type="submit">

								</form>

							</div><!-- Fin contacto-izq -->
						</div>
						<div class="col-sm-8">
							 <div class="clearfix">
								<h2 class="section-heading">Nuestra Ubicacion</h2>
								<p class="comentario">Estamos ubicados en: </p>
								<div class="row starter-container banners">

									 <?php

									 foreach ($sucursales as $sucursal) {
										 echo '<div class="col-sm-6"><li><b>'.$sucursal['nombre'].'</b> ';
										 if($sucursal['telefono']!='')echo " &nbsp&nbsp Telf.: ".$sucursal['telefono']."<br> ";
										 if($sucursal['email']!='')echo "Email.: ".$sucursal['email']."<br> ";
										 echo $sucursal['direccion']."</li></div>";
									 }

									 ?>

							 </div>
						 </div>
						 <div>
							 <iframe src="https://www.google.com/maps/embed?pb=!1m10!1m8!1m3!1d1899.5849866189646!2d-63.18282596523741!3d-17.783707027454284!3m2!1i1024!2i768!4f13.1!5e0!3m2!1ses!2sbo!4v1535042585631" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
						 </div>


						</div>
				</div>

		</div>
		<!-- /.container -->

</div>

<div class="container starter-container">


		<div class="contacto-der">
			<!--<h2>Contacto directo</h2>-->
			<h2>Contacto directo</h2>


				<span>Teléfono: +591 (3) 3903196</span>

				<img style="margin-top:10px;"
				src="<?php echo base_url();?>assets/img/contactenos.jpg" height="auto" width="100%">

		</div><!-- Fin contacto-der -->

	</div><!-- Fin box -->
