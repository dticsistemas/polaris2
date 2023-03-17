<?php
  if(isset($success)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-success alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Info!</h4>
                <?=$success?>
              </div>
    </div>
  <?php
 }
 if(isset($error)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-danger alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning "></i> Advertencia!</h4>
                <?=$error?>
              </div>
    </div>
  <?php
 }
  if(isset($warning)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-warning alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning "></i> Advertencia!</h4>
                <?=$warning?>
              </div>
    </div>
  <?php
 }
  if(isset($info)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-info alert-dismissible" style="margin-bottom: 0!important;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <h4><i class="icon fa fa-info"></i> Info!</h4>
  <?=$info?>
</div>
</div>
  <?php
 }
 ?>

 <!-- Main content -->
     <section class="invoice">
       <!-- title row -->
       <div class="row">
         <div class="col-xs-12">
           <h2 class="page-header">
            CATALOGO <?=EMPRESA?>

             <?php
             	if (isset($title))
             	echo " ".$title;

             ?>
             <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?></small>
           </h2>
         </div>
         <!-- /.col -->
       </div>
         <!-- /.row -->
         <form method="post" action="<?=base_url()?>inventario/catalogo">

        <div class="row">
          <p class="text-muted well well-sm no-shadow" style="margin-top: 10px;">
            Para la descarga del catalogo seleccione los campos deseados para ser visualizados,
            luego seleccione el formato a descargar.
          </p>
          <div class="row">
            <div class="col-sm-4">
              <div class="form-group">
                <div class="checkbox">
                  <label>
                    <input name="id_producto" value="ok" type="checkbox" checked>
                    ID Producto
                  </label>
                </div>
                <div class="checkbox" checked>
                  <label>
                    <input name="codigo" value="ok" type="checkbox" checked>
                    Codigo del Producto
                  </label>
                </div>
                  <div class="checkbox">
                    <label>
                      <input name="nombre" value="ok" type="checkbox" checked>
                      Nombre del Producto
                    </label>
                  </div>


                  <div class="checkbox">
                    <label>
                      <input name="titulo" value="ok" type="checkbox">
                      Titulo del Producto
                    </label>
                  </div>

                  <div class="checkbox">
                    <label>
                      <input name="descripcion" value="ok" type="checkbox">
                      Descripcion
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input name="tipo" value="ok" type="checkbox">
                      Tipo de Producto
                    </label>
                  </div>
                </div>
                <div class="row">
                  <div class='col-sm-4'>
                         <label for="password">Categoria:</label>
                  </div>
                  <div class='col-sm-8'>
                            <?php
                              echo form_dropdown('categoria', $combox_categorias,'0','class="form-control"' );
                             ?>
                  </div>
                </div>
            </div><!--End col sm 4 .1-->
            <div class="col-sm-4">
              <div class="form-group">
                  <div class="checkbox">
                    <label>
                      <input name="imagen" value="ok" type="checkbox" checked>
                      Imagen Referencia
                    </label>
                  </div>



                  <div class="checkbox">
                    <label>
                      <input name="precio" value="ok" type="checkbox" checked>
                      Precio Base
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input name="medida" value="ok" type="checkbox">
                      Unidad de Medida
                    </label>
                  </div>

                  <div class="checkbox">
                    <label>
                      <input name="cabecera" value="ok" type="checkbox" checked>
                      Incluir Cabecera
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input name="pie_pagina" value="ok" type="checkbox" checked>
                      Incluir Pie de Pagina
                    </label>
                  </div>
                  <div class="checkbox">
                    <label>
                      <input name="bordes" value="ok" type="checkbox" checked>
                      Incluir Bordes
                    </label>
                  </div>
                </div>


            </div><!--End col sm 4-->
            <div class="col-sm-4">
            <div class="box box-widget widget-user">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username"><?=EMPRESA?></h3>
              <h5 class="widget-user-desc"><?=TITLE?></h5>
            </div>
            <div class="widget-user-image">
              <img class="img-circle" src="<?=base_url()?>assets/img/logo.png" alt="User Avatar">
            </div>
            <div class="box-footer">
              <div class="row">
                <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-header"><?=$cant_productos?></h5>
                    <span class="description-text">PRODUCTOS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <div class="col-sm-6">
                  <div class="description-block">
                    <h5 class="description-header"><?=$cant_items?></h5>
                    <span class="description-text">ITEMS</span>
                  </div>
                  <!-- /.description-block -->
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
          </div>

            </div>


          </div>

         <div class="col-xs-12">
          <button type="button" disabled class="btn btn-default"><i class="fa fa-print"></i> Print</button>
          <button type="submit" disabled name="butt_catalogo_xls" value="ok"  class="btn btn-success pull-right"><i class="fa fa-download"></i> Generate xls
          </button>
          <button type="submit" name="butt_catalogo_pdf" value="ok" class="btn btn-primary pull-right" style="margin-right: 5px;">
            <i class="fa fa-download"></i> Generate PDF
          </button>
        </div>
        </div>
      </form>

   </section>
