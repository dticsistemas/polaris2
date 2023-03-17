
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
      <!-- info row -->
           <form id="ventas_formgestionpedidos" method="post" action="<?=base_url()?>cobranzas/consignacion_cobranzas">
             <input type="hidden" name="id_cliente" id="id_cliente" value="0"/>
             <input type="hidden" name="butt_gestionar" value="ok"/>

           </form>

      <div class="row invoice-info">
        <?php
        if(count($arr_consignaciones)>0){
        ?>
       <div class="col-sm-12 invoice-col">
         <div class="box-body table-responsive ">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Inicio</th>
                  <th>Restantes</th>
                  <th>Status</th>
                  <th>Cliente</th>
                  <th>Items</th>
                  <th>Total</th>
                  <th>Accion</th>
                </tr>
                <?php
                foreach ($arr_consignaciones as $value) {
                   $dStart = new DateTime($value['fecha_inicio']);
                   $dEnd  = new DateTime($value['fecha_entrega']);
                   $dDiff = $dStart->diff($dEnd);

                  echo'<tr>';
                    echo'<td>'.$value['id'].'</td>';
                    echo'<td>'.$value['fecha_inicio'].'</td>';
                    echo'<td>'. $dDiff->days.' dias</td>';
                    if($dDiff->days>15)
                    echo'<td><span class="btn-block badge label-success">Aprobado</span></td>';
                    else if($dDiff->days>7)
                    echo'<td><span class="btn-block badge label-primary">Pendiente</span></td>';
                    else if($dDiff->days>3)
                    echo'<td><span class="btn-block badge label-warning">Riesgo</span></td>';
                    else
                    echo'<td><span class="btn-block badge bg-red">Mora</span></td>';

                    echo'<td>'.$value['nombre_cliente'].'</td>';
                    echo'<td>'.$value['cantidad'].'</td>';
                    echo'<td>'.$value['total'].'</td>';
                    echo'<td><button type="button" onclick="gestionar_pedido('.$value['id_cliente'].')" class="btn btn-block btn-info btn-sm">Gestionar</button></td>';
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

function gestionar_pedido(id_cliente){

      document.getElementById('id_cliente').value=id_cliente;
      //document.getElementById('array_notas').value+concat+notas;
      //document.getElementById('array_fechas').value=
      //document.getElementById('array_fechas').value+concat+fechas;
      //document.getElementById('array_grupos').value=
      //document.getElementById('array_grupos').value+concat+grupo;
      $('#ventas_formgestionpedidos').submit();

   }
</script>
