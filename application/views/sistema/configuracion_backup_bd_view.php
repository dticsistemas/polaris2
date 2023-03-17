
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

<div class="box-body">
    <h4 style="background-color:#f7f7f7; font-size: 18px; text-align: center; padding: 7px 10px; margin-top: 0;">
        GESTIONAR BACKUP DE BASE DE DATOS
    </h4>
    <form action="<?=base_url()?>seguridad/admin_basedatos" method="post">
    <div class="media">
        <div class="media-left">
            <a href="" class="ad-click-event">
                <img src="<?=base_url()?>assets/img/consolidacion-de-base-de-datos.png" alt="Webadmin" class="media-object" style="width: 200px;height: auto;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);">
            </a>
        </div>
        <div class="media-body">
            <div class="clearfix">
                <p class="pull-right ">
                    <button type="submit" class="btn btn-lg btn-success btn-block" id="butt_backup_full" name="butt_backup_full" value="ok">
                          <i class="fa fa-download"></i> DESCARGAR
                    </button>
                </p>

                <h4 style="margin-top: 0">Base Datos Completa</h4>

                <p>Realizando Backup de la Base de Datos, todas las tablas y datos en formato plano scipt "file.txt"</p>
                <p style="margin-bottom: 0">
                    <i class="fa fa-database margin-r5"></i> download full base de datos
                </p>
            </div>
        </div>
    </div>
    <div class="media">
        <div class="media-left">
            <a href="" class="ad-click-event">
                <img src="<?=base_url()?>assets/img/configuracionbd.jpg" alt="Webadmin" class="media-object" style="width: 200px;height:auto ;border-radius: 4px;box-shadow: 0 1px 3px rgba(0,0,0,.15);">
            </a>
        </div>
        <div class="media-body">
            <div class="clearfix">
                <p class="pull-right ">
                    <button type="submit" class="btn btn-lg btn-success btn-warning" id="butt_backup_full" name="butt_backup_truncate" value="ok">
                          <i class="fa fa-download"></i> LIMPIAR BD
                    </button>
                </p>

                <h4 style="margin-top: 0">Truncar Base de Datos</h4>

                <p>Realizando truncado de tablas de la Base de Datos<br>
                  Algunos registros de tablas sera eliminados de la base de datos para liberar espacio,
                  asegurese de realizar y guardar copias de la base de datos
                   antes de realizar esta acción.<br>Los registros
                a eliminar son los especificados en la configuracion del sistema  </p>

            </div>
        </div>
    </div>
  </form>
</div>
