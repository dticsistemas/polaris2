<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Main content -->
<?php if (validation_errors()) : ?>
  <div class="col-md-12">
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
      <?= validation_errors() ?>
    </div>
  </div>
<?php endif; ?>
<?php if (isset($error)) : ?>
  <div class="col-md-12">
    <div class="alert alert-danger alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

      <?= $error ?>
    </div>
  </div>
<?php endif; ?>
<?php if (isset($info)) : ?>
  <div class="col-md-12">
    <div class="alert alert-info alert-dismissible" role="alert">
      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>

      <?= $info ?>
    </div>
  </div>
<?php endif; ?>

<?= form_open() ?>
      <div class="col-sm-12">
      <div class="col-sm-8">
      <div class="row ">

<div class="box box-primary ">
<input type="hidden" name="username" value="<?=$_SESSION['username']?>"/>
            <div class="box-body box-profile">
                  <h4 class="title">Perfil de usuario</h4>

                  <div class="row">
                  <div class="col-md-8">
                  <div class="form-group">
                    <label class="control-label">Personal</label>
                    <input type="text" disabled="" class="form-control" value="<?=$_SESSION['name'] ?>">
                  </div>
                  </div>
                  <div class="col-md-4">
                  <div class="form-group">
                    <label class="control-label">Usuario</label>
                        <input type="text"  disabled placeholder="Username" class="form-control" value="<?=$_SESSION['username']  ?>">

                   </div>
                 </div>
                
                  </div>
                  <div class="row"><div class="col-md-6"><div class="form-group">
                    <label class="control-label">Email</label>
                    <input type="text" name="email"  placeholder="Email" class="form-control" value="<=$persona['email']?>"></div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group"><label class="control-label">Facebook</label>
                      <input type="text" name="facebook"  placeholder="Facebook" class="form-control" value="<=$persona['facebook']?>">
                    </div></div>
                  </div>
                  <div class="row">
                    <div class="col-md-6"><div class="form-group">
                    <label class="control-label">Direccion</label>
                    <input type="text" name="direccion"  placeholder="First name" class="form-control" value="<=$persona['direccion']?>"></div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Telefono</label>
                      <input type="text" name="telefono"   placeholder="Telefono" class="form-control" value="<=$persona['telefono']?>">
                    </div></div>
                  </div>
                  <div class="row">
                    <div class="col-md-6"><div class="form-group">
                      <label class="control-label">Password</label>
                      <input type="password" class="form-control" id="password" name="password" placeholder="Ingrese su password">
                      <p class="help-block">Al menos 6 caracteres</p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label class="control-label">Confirmar password</label>
                        <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Confirme su password">
                        <p class="help-block">Las contraseñas deben coincidir</p>
                    </div></div>
                  </div>





  <div class="login-box-body ">
   <!-- /.box-body -->
               <div class="row">
               <div class="col-sm-6 col-md-offset-3">
               <input type="submit" class="btn btn-primary btn-block" value="Modificar Perfil Usuario">

              </div>
              </div>


  </div>
  <!-- /.login-box-body -->
           </div><!--box-footer-->




</div>




	</div><!-- .row -->
</div><!-- .col-sm-8 -->
<div class="col-sm-4">

  <div class="box invoice-info">
    <div class="image">
  <img height="110" width="100%"src="<?=base_url()?>assets/img/resources/background_medium.jpg" alt="...">
</div>
<div class="content perfil ">
  <div class="author">
    <a href="#">
    <img class="avatar border-gray" src="<?=base_url()?>assets/img/fotografias/<?=$persona['fotografia']?>" alt="...">
    <h4 class="card_title"><?=$_SESSION['nombre_persona']?><br><small><?=$_SESSION['username']?></small>
    </h4></a>
  </div>
  <p class="description text-center">
    <span><?=$persona['ocupacion']?></span>
  </p>
  <p class="description text-center">
    <h5 class="text-center">Actualmente en:</h5></span>
  </p>
  <div class="form-group">
     <div class='input-group' >
        <?php
          echo form_dropdown('id_sucursal', $sucursales,$_SESSION['id_sucursal'],'class="form-control" id="id_sucursal" ' );
         ?>
      </div>
  </div>
</div>

  <hr>
  <a target="_blank" href="http://<?=$persona['facebook']?>" class="btn-simple btn btn-default">
      <i class="fa fa-facebook-square"></i>
  </a>
  <button type="button" class="btn-simple btn btn-default">
        <i class="fa fa-home">
  </i></button>
  <a href="http://<?=$persona['email']?>" target="_blank" type="button" class="btn-simple btn btn-default">
   <i class="fa fa-google-plus-square"></i>
 </a>
</hr>
</div></div>
 </div>
</div><!-- .col-sm-4 -->
</div><!-- .row -->
</form>

    <!-- /.content -->
    <div class="clearfix"></div>
