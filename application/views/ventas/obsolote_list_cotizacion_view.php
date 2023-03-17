
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
           <?=EMPRESA?>
            <?php
            	if (isset($title_crud))
            	echo " ".$title_crud;

            ?>
            <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <?php echo form_open('inventario/cotizaciones','id="form_cotizaciones"');?>
        <input type="hidden" name="id_cotizacion" id="id_cotizacion" value="0"/>
        <input type="hidden" name="butt_gestionar" value="ok"/>

      <?=form_close();?>
      <div class="row invoice-info">
        <?php
        if(count($arr_cotizaciones)>0){
        ?>
       <div class="col-sm-12 invoice-col">
         <div class="box-body table-responsive ">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Cliente</th>
                  <th>Empresa</th>
                  <th>Fecha</th>
                  <th>Items</th>
                  <th>Mensaje</th>
                  <th>Accion</th>
                </tr>
                <?php
                foreach ($arr_cotizaciones as $value) {
                   echo'<td>CTZ-'.$value['id'].'</td>';
                    echo'<td>'.$value['nombre'].'</td>';
                     echo'<td>'.$value['empresa'].'</td>';
                    echo'<td>'.$value['fecha'].'</td>';
                    echo'<td>'.$value['cantidad'].'</td>';
                    echo'<td>'.$value['mensaje'].'</td>';
                    echo'<td><button type="button" onclick="gestionar_cotizacion('.$value['id'].')" class="btn btn-block btn-info btn-sm">Gestionar</button></td>';
                  echo'</tr>';
                }


                 ?>
              </tbody></table>
            </div>

       </div>
       <?php
     }else{
       ?>
       <div class="error-content text-center">
          <h4><i class="fa fa-warning text-yellow"></i> Oops! No existe consignaciones vigentes.</h4>



        </div>

       <?php

     }
       ?>

    </div>

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>

<script>



///////////////////////////////////////////////////////////
//--------------------------------------------------------
//--------------FORM--------------------------------------

function gestionar_cotizacion(id_cotizacion){

      document.getElementById('id_cotizacion').value=id_cotizacion;
      //document.getElementById('array_notas').value+concat+notas;
      //document.getElementById('array_fechas').value=
      //document.getElementById('array_fechas').value+concat+fechas;
      //document.getElementById('array_grupos').value=
      //document.getElementById('array_grupos').value+concat+grupo;
      $('#form_cotizaciones').submit();

   }
</script>
