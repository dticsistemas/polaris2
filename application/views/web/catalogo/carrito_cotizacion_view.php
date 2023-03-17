<div class="container">

<div class="panel panel-primary">
  <div class="panel-heading text-center">
    <h2>
        Cotización - Listado de Productos
    </h2>
  </div>
  <div class="panel-body">
            <!--contenedor de los artículos-->
            <ul class="grid_7" id="subcontenedor">
                <?php
                //mostramos el mensaje de las sesiones flashdata dependiendo
                //de lo que hayamos hecho.
                $agregado = $this->session->flashdata('agregado');
                $destruido = $this->session->flashdata('destruido');
                $productoEliminado = $this->session->flashdata('productoEliminado');
                if ($agregado) {
                    ?>
                    <li class="grid_6" id="productoAgregado"><?= $agregado ?></li>
                    <?php
                }elseif($destruido)
                {
                    ?>
                    <li class="grid_6" id="productoAgregado"><?= $destruido ?></li>
                    <?php
                }elseif($productoEliminado)
                {
                    ?>
                    <li class="grid_6" id="productoAgregado"><?= $productoEliminado ?></li>
                    <?php
                }
                ?>

            </ul>

            <!--fin del contenedor de los articulos-->

            <!--mostramos el contenido de nuestro carrito-->
            <?php
            //si el carrito contiene productos los mostramos
            if (count($productos)>0) {
                ?>
                <div class="table_productos_listar">

                <table  class="table table-condensed table-hover table-striped table-bordered">
                        <tr>

                            <th>Codigo</th>
                            <th>Imagen</th>
                            <th>Nombre</th>
                            <th>Cantidad</th>
                            <th>Accion</th>
                        </tr>
                    <?php
                    foreach ($productos as $producto) {
                        ?>
                        <tr>

                          <td><?=$producto['codigo']?></td>
                          <td><img src="<?=base_url()."assets/img/catalogo/thumbs/".$producto['imagen']?>"></td>
                          <td><?=$producto['name']?></td>
                          <td><?=$producto['qty']?></td>

                            <td id="eliminar"><?= anchor('carrito/eliminarProducto/' . $producto['rowid'], '<i class="glyphicon glyphicon-shopping-cart"></i> Eliminar', 'class="btn btn-danger"') ?></td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tr id="total">
                        <td colspan="3" style="text-align:right"><strong>Total:</strong></td>
                        <!--mostramos el total del carrito
                        con $this->cart->total()-->
                        <td> <?= $this->cart->total() ?> euros.</td>
                        <!--creamos un enlace para eliminar el carrito-->
                        <td id="eliminarCarrito"><?= anchor('carrito/eliminarCarrito', 'Vaciar carrito',' class="btn btn-danger"')?></td>
                    </tr>
                </table>
                </div>
            <?php
            }
            else{
              ?>
<h3> NO EXISTEN PRODUCTOS AGREGADOS</h3>
              <?php
            }
            ?>
        </div>

        <div class="row jumbotron">
            <div class="col-sm-12">
              <p class="comentario">Para comunicarse con nosotros solo complete el siguiente formulario con sus datos
              personales y nuestros ejecutivos se contactarán con usted a la brevedad.</p>

            </div>
            <?php
             echo validation_errors();
             echo $resultado;
        ?>
              <?php
                  $atributos = array('class' => 'form-horizontal', 'id' => 'formulario_contacto');
                  echo form_open('cotizacion',$atributos);
              ?>
            <div class="col-sm-6">
              <div class="panel-body">


                  <div class="form-group">
                    <label for="nombre">Nombre y Apellido(*):</label>
                    <input class="form-control" name="nombre" id="nombre" type="text" value="">
                  </div>

                  <div class="form-group">
                    <label for="empresa">Telefono(*):</label>
                    <input class="form-control" name="telefono" id="telefono" type="text">
                  </div>

                  <div class="form-group">
                    <label>Dirección:</label>
                    <input class="form-control" name="direccion" id="direccion" type="direccion">
                  </div>

                  <div class="form-group">
                  <label><span >(*)</span> Ingrese el Codigo de verificacion: </label>
                          <?php
                          echo $captcha['image'];
                           echo "<p> ".$captcha['word']."</p>";
                          ?>

                          <input class="form-control" type="text" name="captcha" value="" />
                  </div>
                          <input  class="form-control" name="button2" id="button2" class="btn btn-secondary" value="Enviar Consulta" type="submit">



              </div><!-- Fin contacto-izq -->
            </div>
            <div class="col-sm-6">
              <div class="panel-body">
              <div class="form-group">
                <label for="empresa">Empresa o razón social:</label>
                <input class="form-control" name="empresa" id="empresa" type="text">
              </div>
              <div class="form-group">
                <label for="email">Email(*):</label>
                <input class="form-control" name="email" id="email" type="email">
              </div>
              <div class="form-group">
                <label for="mensaje">Mensaje(*):</label>
                <textarea  class="form-control" name="mensaje" id="mensaje"></textarea>
              </div>

            </div>
            </div>
              </form>

        </div>

        <!--fin del contenedor principal-->
