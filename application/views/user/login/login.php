<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

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

<div class="login-box">

<div class="box box-widget widget-user-2">
            <!-- Add the bg color to the header using any of the bg-* classes -->
            <div class="widget-user-header bg-blue ">
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
    <p class="login-box-msg">Ingrese datos para Iniciar Session</p>

    <?= form_open() ?>
      <div class="form-group has-feedback">
        <input type="text" class="form-control" id="username" name="username" placeholder="Usuario">
        <span class="glyphicon glyphicon-user form-control-feedback"></span>
      </div>
      <div class="form-group has-feedback">
        <input type="password" class="form-control" placeholder="Password" id="password" name="password">
        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
      </div>
      <div class="row">
      <div class="col-xs-1">

        </div>

        <div class="col-xs-6">
          <div class="checkbox icheck">
            <label>
              <input type="checkbox"> Recordarme
            </label>
          </div>
        </div>
        <!-- /.col -->
        <div class="col-xs-4">
          <button type="submit" class="btn btn-primary btn-block btn-flat">Ingresar</button>
        </div>
        <!-- /.col -->
      </div><!--/row-->

    <!-- /.social-auth-links -->

   </form>

  </div>
  <!-- /.login-box-body -->
           </div><!--box-footer-->
</div>





<!-- /.login-box -->
<style type="text/css">
	body {
		background: #d2d6de;
	}

</style>
