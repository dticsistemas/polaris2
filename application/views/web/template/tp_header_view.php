<!DOCTYPE html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="kitsoft">
    <link rel="icon" href="<?php echo base_url();?>assets/img/favicon.ico">
    <title>Polaris, Venta de Productos</title>
    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url();?>assets/bootstrap-4.3.1-dist/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

    <link href="<?php echo base_url();?>assets/css/myestilo.css" rel="stylesheet">  
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js" defer></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.1.0/css/flag-icon.min.css" rel="stylesheet">
        
    <!--<script src="<?php echo base_url();?>assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js" defer></script>-->

  <link rel="stylesheet" href="<?=base_url()?>assets/assets/css/styles.css">
  <link rel="stylesheet" href="<?=base_url()?>assets/assets/css/css.css" media="all">

</head>
<body>
  <nav class="navbar navbar-expand-md navbar-dark bg-header ">
  <a class="navbar-brand" href="<?=base_url()?>">
    <img   class="starter-logo img-responsive" src="<?php echo base_url();?>assets/img/logo_empresa_img.png" alt="logo empresa">
  </a>
  <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="navbar-collapse collapse" id="navbarCollapse" style="">
    <ul class="navbar-nav ml-auto"> 
    <?php 
        if(isset($inicio))
        if ($inicio==false){
      ?>       
      <li class="nav-item">
        <a class="nav-link" href="<?=base_url()?>">Inicio </a></li>
      <?php  } ?>  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown">Empresa</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?=base_url()?>#about">Quienes Somos</a>
          <a class="dropdown-item" href="<?=base_url()?>empresa">Nuestra Empresa</a>
          <a class="dropdown-item" href="<?=base_url()?>empresa#partners">Nuestros socios</a>
          <a class="dropdown-item" href="<?=base_url()?>#banners">Unete</a>
        </div>
      </li>     
     <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown">Productos</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">          
          <a class="dropdown-item" href="<?=base_url()?>#work">Nuestro Productos</a>
          <a class="dropdown-item" href="<?=base_url()?>productos">Trabajos/Galeria</a>
          <a class="dropdown-item" href="<?=base_url()?>productos/listar">Catalogo Productos</a>
        </div>
      </li> 
       <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown">Contacto</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?=base_url()?>#contact">Contacta con nosotros</a>
          <a class="dropdown-item" href="<?=base_url()?>contacto">Nuestra Ubicacion</a>
        </div>
      </li>  
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown">Novedades</a>
        <div class="dropdown-menu" aria-labelledby="dropdown01">
          <a class="dropdown-item" href="<?=base_url()?>novedades">Noticias</a>
          <a class="dropdown-item" href="<?=base_url()?>novedades#logros">Logros</a>
        </div>
      </li>              
     

       <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle"  id="dropdown09" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
               <?php if($this->session->userdata('site_lang') == 'english')
                      echo '<span class="flag-icon flag-icon-us"> </span> English</a>';
                      else
                      echo '<span class="flag-icon flag-icon-bo"> </span> Español</a>';
               ?>

            <div class="dropdown-menu" aria-labelledby="dropdown09">

                <a class="dropdown-item" href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/spanish'><span class="flag-icon flag-icon-bo"> </span>  Español</a>
                <a class="dropdown-item" href='<?php echo base_url(); ?>LanguageSwitcher/switchLang/english'><span class="flag-icon flag-icon-us"> </span>  English</a>               
            </div>
        </li>   
         <li class="nav-item">  
        <a class="btn btn-outline-info" href="<?=base_url()?>login"><i class="fas fa-user"></i></a></li>            
    </ul>
   
  </div>
</nav>




          <!--
          <form method="post" action="<?php echo base_url();?>productos/listar" class="navbar-form navbar-right">
            <div class="input-group">
              <input type="text" class="form-control text-search" name="search_string_inicio" placeholder="¿Qué estás buscando?">
              <div class="input-group-btn">
                <button class="btn btn-default" type="submit" name="butt_buscar_inicio" value="ok" >
                  <i class="glyphicon glyphicon-search"></i>
                </button>
              </div>
              <div class="input-group-btn">
                <?php
                if(CARRITO){
                    if($carrito>0 ){
                      echo '<a class="btn btn-primary" href="'.base_url().'cotizacion">';
                      echo '<i class="glyphicon glyphicon-shopping-cart"></i>';
                      echo '<span id="lb_cotizacion">';
                      echo " ".$carrito." Cotizar";
                      echo '</span>';
                      echo '</a>';

                  }else{
                    ?>
                    <a class="btn btn-default" href="<?php echo base_url();?>cotizacion">
                      <i class="glyphicon glyphicon-shopping-cart"></i>
                      <span id="lb_cotizacion">Cotizacion</span>
                      </a>

                    <?php
                  }
                }
                  ?>

              </div>
            </div>
          </form>
          -->
         <!--
     <li class="dropdown">
    <a  class="dropdown-toggle" tabindex="0"  data-toggle="dropdown" data-submenu="">PRODUCTOS
    <span class="caret"></span></a>
    <ul class="dropdown-menu">
      <?php

    function subcategorias($categoria,$nivel){
      $subcategorias=$categoria['sub_categorias'];
       if($subcategorias==null) {
        echo '<li>';
        echo '<a tabindex="0"  href="'.base_url().'productos/categoria/'.$categoria["id"].'">'.$categoria["nombre"].'</a>';
        echo '</li>';
       }
       else{
        echo '<li class="dropdown-submenu">';
        echo '<a tabindex="0" href="#">'.$categoria["nombre"] .'</a>';
        echo '<ul class="dropdown-menu">';
        echo '<li>';
        echo '<a tabindex="0"  href="'.base_url().'productos/categoria/'.$categoria["id"].'">[Todos]</a>';
        echo '</li>';
          foreach ($subcategorias as $categorias_aux) {
            subcategorias($categorias_aux,1);
            //echo '<li><a href="#">3rd level dropdown</a></li>';
          }
        echo '</ul>';
        echo '</li>';
        }
     }
     //-----------------------
    if(count($categorias)>0)
    foreach ($categorias as $categoria) {
       $subcategorias=$categoria['id_parent'];
       if($subcategorias==null) {
        echo '<li>';
        echo '<a tabindex="0"  href="'.base_url().'productos/categoria/'.$categoria["id"].'">'.$categoria["nombre"].'</a>';
        echo '</li>';
       }
       else{
        echo '<li class="dropdown-submenu">';
        echo '<a tabindex="0" href="#">'.$categoria["nombre"] .'</a>';
        echo '<ul class="dropdown-menu">';
        echo '<li>';
        echo '<a tabindex="0"  href="'.base_url().'productos/categoria/'.$categoria["id"].'">[Todos]</a>';
        echo '</li>';
          foreach ($subcategorias as $categorias_aux) {
          //  subcategorias($categorias_aux,1);
            //echo '<li><a href="#">3rd level dropdown</a></li>';
          }
        echo '</ul>';
        echo '</li>';
        }

       }


      ?>



    </ul>
  </li>
-->

           
