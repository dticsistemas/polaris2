<?php
/*
if(!isset($fecha))
$fecha=date("Y-m-d H:i:s");
if(!isset($time_evento))
$time_evento=10;
if(!isset($time_programacion))
$time_programacion=240;
if(!isset($time_tolerancia))
$time_tolerancia=5;
*/

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
 if(isset($erro2)){
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
 ?>

<?php echo validation_errors ( '<div class="pad margin no-print"><div class="alert alert-danger alert-dismissible" style="margin-bottom: 0!important;"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>' , '</div></div>' );?>

<div class="row">
<div class="col-sm-8 col-md-offset-2">
<div class="login-box">
<form action="<?=base_url()?>seguridad/admin_configuracion" method="post">


<div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-primary ">
              <div class="widget-user-image">
                 <img class="img" src="<?=base_url()?>assets/img/logo.png" alt="Logo <?=EMPRESA?>" ><!-- /.direct-chat-img -->
              </div>
              <!-- /.widget-user-image -->
              <h2 class="widget-user-username"><b><?=EMPRESA?></b></h2>
              <h5 class="widget-user-desc"><?=TITLE?></h5>
            </div>
            <div class="box-footer no-padding">
              <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Ingrese la configuracion del sistema</p>


      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre" value="<?=$nombre?>">
        <span class="fa fa-globe form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
         <textarea class="form-control" rows="3" class="form-control" placeholder="Reseña" id="resenia" name="resenia" ><?=$resenia?></textarea>
        <span class="fa  fa-commenting form-control-feedback"></span>
      </div>
       <div class="form-group has-feedback">
        <input type="text" class="form-control" placeholder="Lema" id="lema" name="lema" value="<?=$lema?>">
        <span class="fa fa-flag-o form-control-feedback"></span>
      </div>

   <!-- /.box-body -->
            <div class="box box-footer">
               <div class="row">
               <div class="col-sm-8 col-md-offset-2">
              <button type="Submit" name="butt_save_config" value="ok" class="btn btn-block btn-primary">Guardar Nueva Configuracion</button>
              </div>
              </div>

            </div>
  </div>
  <!-- /.login-box-body -->
           </div><!--box-footer-->


    </form>
</div><!---Fin de div login-box-->


</div>
</div>
