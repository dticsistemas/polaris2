<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Main content -->
    <section class="invoice">

	<!-- title row -->
      <div class="row">
        <div class="col-xs-12">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> <?=EMPRESA?>c.
            <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
	<div class="row">
		<div class="col-md-12">
			<div class="page-header">
				<h3>Gracias por registrarse, ha creado una nueva cuenta!</h3>
			</div>
			<p>Se ha completado el registro. Ahora puedes acceder al sistema con la cuenta de usuario creada</p>
      <p>
        Tarea finalizada <a href="<?=base_url?>seguridad/admin_usuarios">regresar</a>  al listado de usuarios.
      </p>
    </div>

	</div><!-- .row -->
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
