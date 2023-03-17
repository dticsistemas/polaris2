
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

  <button type="button" class="close" data-dismiss="alert"
  aria-hidden="true"></button>
  <h4><i class="icon fa fa-info"></i> Info!</h4>
  <?=$info?>
</div>
</div>
  <?php
 }
 ?>


 <div class="box">

            <div class="box-header ui-sortable-handle" style="cursor: move;">
              <i class="fa fa-bell-o"></i>
              <h3 class="box-title">Notificaciones Activas</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body row">


                <?php

                $col='col-sm-4';
                if(count($notificaciones)<=2)
                $col='col-sm-8 col-sm-offset-2';
                else if(count($notificaciones)<5)
                $col='col-sm-6';
                foreach ($notificaciones as $notificacion){
                  $tipo   =$notificacion['tipo'];
                  $id     =$notificacion['id'];
                  $estado    =$notificacion['estado'];
                  $title  =$notificacion['title'];
                  $fecha  =$notificacion['fecha'];
                  $fecha = date('Y-M-d',strtotime($fecha));
                  $estilo='fa fa-users text-aqua';
                  $callout='';
                  switch ($tipo) {
                    case 'Informativo':
                        $estilo='fa fa-info-circle ';
                        $callout='info';
                      break;
                    case 'Advertencia':
                        $estilo='fa fa-exclamation-circle ';
                        $callout='warning';
                      break;
                    case 'Mensaje':
                        $estilo='fa fa-info-circle';
                        $callout='success';
                      break;
                    case 'Critico':
                        $estilo='fa fa-exclamation-triangle';
                        $callout='danger';
                      break;
                  }
                  ?>
                  <div class="<?=$col?>">
                  <div class="box box-<?=$callout?> box-sombreado box-solid">
                    <div class="box-header">
                      <h3 class="box-title"><i class="<?=$estilo?>"></i> <?=$title?></h3>

                      <div class="box-tools pull-right">
                        <button type="button" onclick="quitarNotificacion(<?=$id?>)" class="btn btn-box-tool"  data-widget="remove">
                          <i class="fa  fa-bell-slash" ></i>
                        </button>
                      </div>
                      <!-- /.box-tools -->
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                      <?=$notificacion['mensaje']?>
                    </div>
                    <!-- /.box-body -->
                  </div>
                  </div>


                <?php } ?>
            </div>
            <!-- /.box-body -->


          </div>
<script>
function quitarNotificacion(id){

  $.ajax({
    url: '<?=base_url()?>administracion/notificaciones',
    type: 'post',
    data: {'id':id,'butt_notificacion':'ok'}

  });

}
</script>
