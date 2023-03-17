<!-- Content Header (Page header) -->
 <?php


  if (!isset($cant_productos)){
    	$cant_productos=0;
    }
	if (!isset($cant_ventas)){
		$cant_ventas=0;
	}
	if (!isset($cant_stock)){
		$cant_stock=0;
	}
	if (!isset($cant_pedidos)){
		$cant_pedidos=0;
	}
 ?>
     <!-- Main content -->
     <?php
     if (isset($welcome)){
      echo '<h4>'.$welcome.'</h4>';
    }
      ?>
    <div class="" style="min-height:450px; width: auto !important;   height: auto !important;   max-width: 100%;
    background-image: url('<?=base_url()?>assets/img/resources/background3.jpg');
     background-repeat: no-repeat;background-size: cover;">


      <!-- Info boxes -->

      <div class="row">
              <div class="col-sm-3 col-xs-6">
                <!-- small box -->
                <div class="card card-stats">
                <div class="small-box bg-aqua fix-margin-bottom">
                  <div class="inner">
                    <h3><?=$cant_ventas?></h3>

                    <p>Ventas</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-shopping-cart"></i>
                  </div>
                  <a href="<?=base_url()?>ventas/ventas_contado" class="small-box-footer  ">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              </div>
              <!-- ./col -->
              <div class="col-sm-3 col-xs-6">
                <!-- small box -->
                    <div class="card card-stats">
                <div class="small-box bg-green fix-margin-bottom">
                  <div class="inner">
                    <h3><?=$cant_pedidos?></h3>

                    <p>Pedidos</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-edit"></i>
                  </div>
                  <a href="<?=base_url()?>ventas/pedidos" class="small-box-footer ">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              </div>
              <!-- ./col -->
              <div class="col-sm-3 col-xs-6">
                <!-- small box -->
                <div class="card card-stats">
                <div class="small-box bg-yellow fix-margin-bottom">
                  <div class="inner">
                    <h3><?=$cant_productos?></h3>

                    <p>Productos</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-cube"></i>
                  </div>
                  <a href="<?=base_url()?>inventario/productos"  class="small-box-footer ">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              </div>
              <!-- ./col -->
              <div class="col-sm-3 col-xs-6">
                <!-- small box -->
                <div class="card card-stats">
                <div class="small-box bg-red fix-margin-bottom">
                  <div class="inner">
                    <h3><?=$cant_stock?></h3>

                    <p>Stock</p>
                  </div>
                  <div class="icon">
                    <i class="fa fa-cubes"></i>
                  </div>
                  <a href="<?=base_url()?>inventario/inventario_productos" class="small-box-footer ">Mas info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
              </div>
              </div>
              <!-- ./col -->
            </div> <!-- /.row -->

<?php
if($_SESSION['id_grupo']==ADMINISTRADOR){
    $setting=$_SESSION['settings_user'];
?>
    <div class="row panel_doble">

    <div class="col-sm-8 ">
          <!-- LINE CHART -->
        <?php  if($setting['ventas_statistics']==1){ ?>
          <div class="box box-primary">
            <div class="box-header with-border panel_doble_header">
              <h3 class="box-title"><i class="fa fa-bar-chart-o"></i> Estadisticas Ventas Global</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <div class="box-body">
              <div class="chart">
                <canvas id="lineChart" style="height: 350px; width:100%;"></canvas>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
            <?php
          }
            if($setting['usuarios_statistics']==1){ ?>
          <!-- /.box -->
      <div class="box box-primary">
            <div class="row">
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-flag-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Mensajes</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-yellow"><i class="fa fa-bell-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Notificacion</span>
              <span class="info-box-number"></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-4 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa  fa-cart-arrow-down"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Anuladas</span>
              <span class="info-box-number">0</span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
        <!-- /.col -->
      </div>
          </div>
          <?php
        }
          ?>

        </div>
        <div class="col-sm-4">
            <?php  if($setting['pedidos_vigentes']==1){ ?>
          <div class="box box-primary">
                <div class="box-header with-border panel_doble_header">
                  <h3 class="box-title"><i class="fa fa-edit"></i> Pedidos Vigentes</h3>

                  <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                  </div>
                </div>
                <!-- /.box-header -->

                <div class="box-body">
                  <div class="">
                    <?php
                    if(count($arr_pedidos)>0){
                    foreach ($arr_pedidos as $value) {
                       $dStart = new DateTime($value['fecha_inicio']);
                       $dEnd  = new DateTime($value['fecha_entrega']);
                       $dDiff = $dStart->diff($dEnd);
                       $fecha_actual=date('Y-m-d');
                       $eDiff = (new DateTime($fecha_actual))->diff($dEnd);;
                       echo'<div class="progress-group">';
                       echo'<span class="progress-text">['.$value['id'].'] '.$value['nombre_cliente'].'</span>';
                       $fecha_actual = strtotime($fecha_actual);
                       $fecha_entrada = strtotime($value['fecha_entrega']);
                       $resta=$dDiff->days;
                       if($fecha_actual < $fecha_entrada)
                       echo'<span class="progress-number"><b>'.$eDiff->days.'</b>/'.$dDiff->days.'</span>';
                       else if($fecha_actual == $fecha_entrada)
                       echo'<span class="progress-number"><b>Hoy</b></span>';
                       else{
                         $resta=0;
                         echo'<span class="progress-number"><b>'.$eDiff->days.' mora</span>';
                       }
                       echo'<div class="progress sm">';
                       if($resta>30)
                       echo'<div class="progress-bar progress-bar-green" style="width: 20%"></div>';
                       else if($resta>20)
                       echo'<div class="progress-bar progress-bar-blue" style="width: 40%"></div>';
                       else if($resta>15)
                       echo'<div class="progress-bar progress-bar-aqua" style="width: 60%"></div>';
                       else if($resta>7)
                       echo'<div class="progress-bar progress-bar-yellow" style="width: 75%"></div>';
                       else if($resta>3)
                       echo'<div class="progress-bar progress-bar-orange" style="width: 90%"></div>';
                       else
                       echo'<div class="progress-bar progress-bar-red" style="width: 100%"></div>';

                       echo'</div>';
                       echo'</div>';
                    }
                }else{

                  echo'<p class="text-center">No existen pedidos</p>';
                }
                  ?>
                </div>
                <!-- /.box-body -->
                <div class="box-footer clearfix">
                  <a href="<?=base_url()?>ventas/pedidos" class="btn btn-sm btn-default btn-flat pull-right">Ver Todos</a>
                </div>
                <!-- /.box-footer -->
              </div>


        </div>
      <?php
    }
       if($setting['productos_top']==1){ ?>
        <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Top Productos vendidos</h3>

              <div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                </button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
              </div>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <ul class="products-list product-list-in-box">
                <?php foreach ($top_productos as $productos): ?>
                  <li class="item">
                    <div class="product-img">
                      <img src="<?=base_url()."assets/img/catalogo/thumbs/".$productos['imagen']?>" alt="Product Image">
                    </div>
                    <div class="product-info">
                      <a href="javascript:void(0)" class="product-title"><?=$productos['codigo']?>
                        <span class="label label-warning pull-right"><?=$productos['cantidad']?></span></a>
                      <span class="product-description">
                            <?=$productos['nombre']?>.
                          </span>
                    </div>
                  </li>
                <?php endforeach; ?>
                <!-- /.item -->
              </ul>
            </div>
            <!-- /.box-body -->
          </div>
        <?php } ?>
    </div>
      </div>
    <?php
  }

    ?>
</div>
