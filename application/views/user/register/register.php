<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Main content -->
    <section class="invoice">

	<!-- title row -->
      <div class="row">
        <div class="col-md-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <?=EMPRESA?> Inc.   -
          <b> Registro de Usuarios</b>
            <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <div class="row invoice-info">
		<?php if (validation_errors()) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= validation_errors() ?>
				</div>
			</div>
		<?php endif; ?>
		<?php if (isset($error)) : ?>
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
					<?= $error ?>
				</div>
			</div>
		<?php endif; ?>
<?= form_open() ?>
<div class="col-md-8 col-md-offset-2">
<div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-primary ">
              <div class="widget-user-image">
                 <img class="img" src="<?=base_url()?>assets/img/logo.png" alt="Logo"><!-- /.direct-chat-img -->
              </div>
              <!-- /.widget-user-image -->
              <h2 class="widget-user-username"><b><?=EMPRESA?></b></h2>
              <h5 class="widget-user-desc"><?=TITLE?></h5>
            </div>
            <div class="box-footer no-padding">
              <!-- /.login-logo -->
  <div class="login-box-body">
    <p class="login-box-msg">Ingrese los datos del nuevo usuario del sistema</p>

	<div class="form-group">
					<label for="username">Nombre usuario</label>
					<input type="text" class="form-control" id="username" name="username" placeholder="Enter a username">
					<p class="help-block">Al menos 4 caracteres, letras o numeros</p>
				</div>
				<!--<div class="form-group">
					<label for="name">Nombre Completo</label>
					<input type="name" class="form-control" id="name" name="name" placeholder="Nombre y Apellidos">
				</div>-->
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" class="form-control" id="password" name="password" placeholder="Enter a password">
					<p class="help-block">Al menos 6 caracteres</p>
				</div>
				<div class="form-group">
					<label for="password_confirm">Confirmar password</label>
					<input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirm your password">
					<p class="help-block">Las contraseñas deben coincidir</p>
				</div>

          <?php
          if(isset($list_grupos)){
?>
        <div class="form-group">
                <label>Grupo Usuario</label>
                <select class="form-control select2 select2-hidden-accessible" name="grupo" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <?php
                  foreach ($list_grupos as $value) {

                    echo '<option value="'.$value['id'].'">'.$value['nombre'].'</option>';
                  }
                  //<option selected="selected">Alabama</option>

                  ?>
                </select>
              </div>
<?php

          }

          if(isset($list_personal)){
?>
        <div class="form-group">
                <label>Personal asignado al Usuario </label>
                <select class="form-control select2 select2-hidden-accessible" name="persona" style="width: 100%;" tabindex="-1" aria-hidden="true">
                  <?php
                  foreach ($list_personal as $value) {

                    echo '<option value="'.$value['id'].'">'.$value['nombre'].' '.$value['apellidos'].'</option>';
                  }
                  //<option selected="selected">Alabama</option>

                  ?>
                </select>
              </div>
<?php

          }

          ?>
          <div class="form-group">
            <div class="row">
              <div class="col-sm-4">
          <label>Avatar de usuario </label>
        </div>
        <div class="col-sm-7">
          <select name="tech" id="tech">
             <option value="0" data-image="<?=base_url()?>assets/img/avatar/0.png">Usuario</option>
             <option value="1" data-image="<?=base_url()?>assets/img/avatar/1.png">Default</option>
             <option value="2" data-image="<?=base_url()?>assets/img/avatar/2.png">Firefox</option>
             <option value="3" data-image="<?=base_url()?>assets/img/avatar/3.png">User</option>
             <option value="4" data-image="<?=base_url()?>assets/img/avatar/4.png">Personal</option>
             <option value="5" data-image="<?=base_url()?>assets/img/avatar/5.png">Admin</option>
             <option value="6" data-image="<?=base_url()?>assets/img/avatar/6.png">DrpBox</option>

           </select>
         </div>
         </div>
            </div>

          </div>





   <!-- /.box-body -->

               <div class="row">
               <div class="col-sm-8 col-md-offset-2">
               <input type="submit" class="btn btn-primary btn-block" value="Registrar Usuario">

              </div>
              </div>


  </div>
  <!-- /.login-box-body -->
           </div><!--box-footer-->



</div><!---Fin de div login-box-->
</form>

</div>




	</div><!-- .row -->

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
