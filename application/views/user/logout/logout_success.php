<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!-- Automatic element centering -->
<div class="lockscreen-wrapper">
  <div class="lockscreen-logo">
    <a href=""><b><?=EMPRESA?></b></a>
  </div>
  <!-- User name -->
  <div class="lockscreen-name"><?=$username?></div>

  <!-- START LOCK SCREEN ITEM -->
  <div class="lockscreen-item">
    <!-- lockscreen image -->
    <div class="lockscreen-image">
      <img src="<?= base_url('assets/img/user1_200x200.png')?>" alt="User Image">
    </div>
    <!-- /.lockscreen-image -->

    <!-- lockscreen credentials (contains the form) -->
    <form method="post" action="<?=base_url()?>login" class="lockscreen-credentials">
      <div class="input-group">
        <input type="password" name="password" class="form-control" placeholder="password">
        <input type="hidden" name="username" value="<?=$username?>">
        <div class="input-group-btn">
          <button type="submitt" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
        </div>
      </div>
    </form>
    <!-- /.lockscreen credentials -->

  </div>
  <!-- /.lockscreen-item -->
  <div class="help-block text-center">
    Ingresa tu password para volver al sistema
  </div>
  <div class="text-center">
    <a href="<?=base_url()?>login"> O Ingresa a otro usuario </a>
  </div>
  <div class="lockscreen-footer text-center">
    Copyright &copy; 2014<b><a href="https://adminlte.io" class="text-black"> KitSoft Studio</a></b><br>
    All rights reserved
  </div>
</div>
<!-- /.center -->
