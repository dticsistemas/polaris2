<?php
if (!isset($title))
 $title='no existe title';

if (!isset($titulo))
 $titulo='no existe ';

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


<!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> ZKCaterin Inc.
              <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?> </small>
          </h2>


      </div>

<div class="box">
<div class="box-header">
</div>
<!-- /.box-header -->
<div class="box-body">
<div class="row">
<form action="<?=base_url()?>reportes/ventas_global" method="post">
  <div class="col-sm-2"><?=$title?></div>
  <div class="col-sm-4">
    <!-- Date and time range -->
    <div class="form-group">
       <label for="password">Rango de fechas</label>
     <div class="input-group">
        <div class="input-group-addon">
          <i class="fa fa-calendar"></i>
        </div>
        <input type="text" class="form-control pull-right" name="reservation"  value="<?=$fecha_inicio?> - <?=$fecha_fin?>" id="reservation">
      </div>
    </div>


      <!-- /.form group -->

  </div>
  <div class='col-sm-3'>
      <div class="form-group">
         <label for="password">Sucursal</label>
         <div class='input-group date' >
            <?php
           // $combox_sucursales=array('0'=>'juan perez perez','1'=>'klon admin');
              echo form_dropdown('select_sucursal', $combox_sucursales,'0','class="form-control" id="select_sucursal"  onchange="cargar_productos()" ' );
             ?>
          </div>
      </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group">
       <label><span class="fa  fa-list"></span></label>
        <div class='input-group date' >
    <button type="submitt" class="btn btn-primary" name="btn_fecha_ranged" value="ok">
      Ver Reportes
    </div>
    </button>
    </div>
  </div>
</form>
</div>
<?php
if(isset($ventas_global)){
?>
 <table class="table table-bordered table-striped table-hover table-responsive" role="grid" >
  <thead>
  <tr role="row">
    <th>ID</th>
    <th>FECHA</th>
    <th>ACTORES</th>
    <th>INFO</th>
    <th style="min-width:350px">PRODUCTOS</th>
    <th>DATA</th>
  </tr>
  </thead>
  <tbody>
    <?php
    $sw=false;
    foreach ($ventas_global as $venta) {
    ?>
          <tr <?php
          $sw=!$sw;
          if($sw)
          echo 'class="info" ';

           ?>>
              <td><?=$venta['id']?></td>
              <td><?=$venta['fecha']?></td>
              <td>
                Cliente: <?=$venta['cliente']?><br>
                Vendedor:<?=$venta['vendedor']?><br>
                Usuario:<?=$venta['usuario']?>
              </td>
              <td>
              Sucursal:<?=$venta['sucursal']?><br>
              Tipo:<?=$venta['tipo']?><br>
              Nota:<?=$venta['nota']?>
              </td>


              <td>
                <?php
                $arr_detalle_venta=$venta['detalle_venta'];
                echo '<table class="table ">';
                //print_r($arr_detalle_venta[0]);
                foreach ($arr_detalle_venta as $detalle) {
                  echo '<tr>';
                  echo '<td>'.$detalle['cantidad'].'</td>';
                  echo '<td>'.$detalle['producto'].'</td>';
                  echo '<td>'.$detalle['precio'].'</td>';
                  echo '</tr>';
                }
                echo '</table>';
                ?>
              </td>
              <td>
                Estado: <?=$venta['estado']?><br>
                Transferida:<?=$venta['transferida']?><br>
                Monto: <?=$venta['total']?>
              </td>
          </tr>
    <?php
     }
    ?>
    </tbody>
    <tr role="row">
      <th></th>
      <th></th>
      <th></th>
      <th></th>
      <th>MONTO TOTAL</th>
      <th><?=$costo_total?></th>
    </tr>
    </table>

      <?php
      }
     ?>
</div>
</div>   <!-- Box-->

    <div>
    </section>
