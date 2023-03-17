<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?=EMPRESA?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">


  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
<!--               Personalizados  componenetes                -->
<?php
if(isset($daterangepicker))
echo '<link rel="stylesheet" href="'.base_url().'assets/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">';
if(isset($datepicker))
echo '<link rel="stylesheet" href="'.base_url().'assets/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">'."\n";
if(isset($timepicker))
echo '<link rel="stylesheet" href="'.base_url().'assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">'."\n";
if(isset($charts))
echo '<link rel="stylesheet" href="'.base_url().'assets/adminlte/bower_components/morris.js/morris.css">'."\n";
if(isset($datetimepicker))
echo '<link href="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/build/css/bootstrap-datetimepicker.css">'."\n";
if(isset($select2))
echo '<link rel="stylesheet" href="'.base_url().'assets/adminlte/bower_components/select2/dist/css/select2.min.css">'."\n";
if(isset($datatable))
echo' <link rel="stylesheet" href="'.base_url().'assets/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">'."\n";
if(isset($msdropdown))
echo' <link rel="stylesheet" href="'.base_url().'assets/msdropdown/css/msdropdown/dd.css" />';

if(isset($css_files))
foreach($css_files as $file): ?>
  <link type="text/css" rel="stylesheet" href="<?php echo $file; ?>" />
<?php endforeach; ?>
<link rel="stylesheet" type="text/css" href="<?=base_url()?>assets/css/mi_adminlte.css" />



<!-- Bootstrap 3.3.7 -->
<link rel="stylesheet" href="<?=base_url()?>assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.css">
<!-- Font Awesome -->
<link rel="stylesheet" href="<?=base_url()?>assets/adminlte/bower_components/font-awesome/css/font-awesome.css">
<!-- Ionicons -->
<!--<link rel="stylesheet" href="<?=base_url()?>assets/adminlte/bower_components/Ionicons/css/ionicons.min.css">-->
<!-- Theme style -->
<link rel="stylesheet" href="<?=base_url()?>assets/adminlte/dist/css/AdminLTE.css">
<!-- AdminLTE Skins. Choose a skin from the css/skins
     folder instead of downloading all of them to reduce the load. -->
<link rel="stylesheet" href="<?=base_url()?>assets/adminlte/dist/css/skins/_all-skins.min.css">


  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <!-- Logo -->
    <a href="<?=base_url()?>home" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>APK</b></span>
      <!-- logo for regular state and mobile devices -->

      <span class="logo-lg " style="text-align: left;">

              <img class="img" width="40px" height="40px"  src="<?=base_url()?>assets/img/logo.png" alt="Logo <?=EMPRESA?>" ><!-- /.direct-chat-img -->
              <b><?=EMPRESA?></b></span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="<?=base_url()?>" class="sidebar-toggle" data-toggle="push-menu" role="button">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </a>



            <div class="navbar-custom-menu">
              <ul class="nav navbar-nav">
                <!-- Messages: style can be found in dropdown.less-->
                <li class="dropdown messages-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-envelope-o"></i>
                      <?php if(count($mensajes)>0){?>
                        <span class="label label-success"><?=count($mensajes)?></span>
                      <?php } ?>
                  </a>
                  <?php if(count($mensajes)>0){?>
                  <ul class="dropdown-menu">
                    <li class="header">
                      <?php
                        if(count($mensajes)>0)
                          echo 'Tu tienes '.count($mensajes).' mensajes';
                      ?>
                    </li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <ul class="menu">
                        <?php

                             foreach ($mensajes as $nota) {
                               $mensaje=$nota['mensaje'];
                               $fotografia=$nota['fotografia'];
                               $user_mensaje=$nota['usuario'];
                               $id_remitente=$nota['id_remitente'];
                               ?>
                         <!--<li>
                           <a href="#">
                             <span class="tex-red">
                               <?=substr($mensaje,0,25)?>...
                               <small class="fa  fa-envelope pull-right"></small>
                             </span>
                           </a>
                         </li>-->
                         <li>
                           <a href="#">
                             <div class="pull-left">
                               <img src="<?=base_url()?>assets/img/fotografias/<?=$fotografia?>" class="img-circle" alt="User Image">
                             </div>
                             <h4>
                             <?=$user_mensaje?>
                               <small><i class="fa fa-clock-o"></i> 5 mins</small>
                             </h4>
                             <p><?=substr($mensaje,0,25)?></p>
                           </a>
                         </li>
                          <?php
                             }

                           ?>

                      </ul>
                    </li>
                  <li class="footer"><a href="<?=base_url()?>administracion/mensajes">Ver Todos los Mensajes</a></li>
                  </ul>
                <?php } ?>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <i class="fa fa-bell-o"></i>
                    <?php
                      if(count($notificaciones)>0){
                        $aux=$notificaciones[0];
                        switch ($aux['tipo']) {
                          case 'Informativo':
                              echo '<span class="label label-info">'.count($notificaciones).'</span>';
                            break;
                          case 'Advertencia':
                              echo '<span class="label label-warning">'.count($notificaciones).'</span>';
                            break;
                          case 'Mensaje':
                              echo '<span class="label label-success">'.count($notificaciones).'</span>';
                            break;
                          case 'Critico':
                              echo '<span class="label label-danger">'.count($notificaciones).'</span>';
                            break;
                        }

                      }
                    ?>
                  </a>
                  <?php if(count($notificaciones)>0){?>
                  <ul class="dropdown-menu">
                    <li class="header">Tu tienes <?=count($notificaciones)?> notificaciones:</li>
                    <li>
                      <!-- inner menu: contains the actual data -->
                      <ul class="menu">
                       <?php

                            foreach ($notificaciones as $nota) {

                              $mensaje=$nota['mensaje'];
                              $tipo   =$nota['tipo'];
                              $id     =$nota['id'];
                              $id     =$nota['estado'];
                              $title  =$nota['title'];
                              $estilo='fa fa-users text-aqua';
                              switch ($tipo) {
                                case 'Informativo':
                                    $estilo='fa fa-info-circle text-aqua';
                                  break;
                                case 'Advertencia':
                                    $estilo='fa fa-exclamation-circle  text-yellow';
                                  break;
                                case 'Mensaje':
                                    $estilo='fa fa-info-circle text-green';
                                  break;
                                case 'Critico':
                                    $estilo='fa fa-exclamation-triangle  text-red';
                                  break;
                              }
                              ?>
                              <li><!-- start message -->
                          <a href="#">
                            <div class="pull-left">
                              <span style="font-size:35px;" class="icon_imagen <?=$estilo?>" ></span>
                            </div>
                            <div class="icon_title text-left">
                              <?=$title?>
                            </div>
                            <p  class="icon_desc"><?=substr($mensaje,0,50)?>....</p>
                          </a>
                        </li>
                              <?php

                            }
                          ?>


                        <!-- end task item -->
                      </ul>
                    </li>
                    <li class="footer"><a href="<?=base_url()?>administracion/notificaciones">Ver Todas las Notificaciones</a></li>

                  </ul>
                  <?php
                    }
                  ?>
                </li>
                <!-- Tasks: style can be found in dropdown.less -->
                <li class="dropdown tasks-menu">
                    <a href="javascript:void(0);" onclick="fullScreen();"><i class="glyphicon glyphicon-fullscreen"></i></a>
                </li>
                <!-- User Account: style can be found in dropdown.less -->
                <li class="dropdown user user-menu">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                    <img src="<?=base_url()?>assets/img/fotografias/<?=$_SESSION['fotografia']?>" class="user-image" alt="User Image">
                    <span class="hidden-xs"><?=$_SESSION['nombre_persona']?></span>
                  </a>
                  <ul class="dropdown-menu">
                    <!-- User image -->
                    <li class="user-header">
                      <img src="<?=base_url()?>assets/img/fotografias/<?=$_SESSION['fotografia']?>" class="img-circle" alt="User Image">

                      <p>
                        <?=$_SESSION['username']?> - <?php echo $_SESSION['grupo'] ;?>
                        <small><?php setlocale(LC_TIME, 'spanish'); echo strftime('%d de %B del %Y',strtotime($_SESSION['create_user']));?></small>
                      </p>
                    </li>
                    <!-- Menu Body -->
                    <li class="user-body">
                      <div class="row text-center">
                        <?=$_SESSION['name']?><br>
                        <?=$_SESSION['ocupacion']?>
                      </div>
                      <!-- /.row -->
                    </li>
                    <!-- Menu Footer-->
                    <li class="user-footer">
                      <div class="pull-left">
                        <a href="<?=base_url()?>perfil" class="btn btn-default btn-flat">Perfil</a>
                      </div>
                      <div class="pull-right">
                        <a href="<?=base_url()?>logout" class="btn btn-default btn-flat">Cerrar sesión</a>
                      </div>
                    </li>
                  </ul>
                </li>
                <!-- Control Sidebar Toggle Button -->
                <li>
                  <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                </li>
              </ul>

      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
            <img src="<?=base_url()?>assets/img/fotografias/<?=$_SESSION['fotografia']?>" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?=$_SESSION['username']?></p>
          <a href="<?=base_url()?>perfil"><i class="fa fa-circle text-success"></i><?php echo $_SESSION['grupo'] ;?></a>
        </div>
      </div>
      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu" data-widget="tree">
        <li class="header">MENU NAVEGACION</li>
        <li <?php
        if(isset($link_active)){
           if($link_active=='home')
           echo' class="active" ';
          }
          ?>>
          <a href="<?=base_url()?>home" >
            <i class="fa fa-home"></i> <span>INICIO</span>
            <span class="pull-right-container">
            </span>
          </a>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-shopping-cart"></i>
            <span>VENTAS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <!--<li><a href="<?=base_url()?>ventas/ventas_contado"><i class="fa  fa-shopping-cart text-green"></i> Ventas al Contado </a></li>
              <li><a href="<?=base_url()?>ventas/ventas_credito"><i class="fa  fa-shopping-cart text-yellow"></i> Ventas al Credito </a></li>
             -->
             <li><a href="<?=base_url()?>ventas/pedidos"><i class="fa fa-shopping-cart text-yellow"></i>  Ventas Pedidos</a></li>
             
             <li><a href="<?=base_url()?>ventas/ventas_suspendidas"><i class="fa  fa-shopping-cart text-blue"></i> Ventas Suspendidas </a></li>
             <li><a href="<?=base_url()?>ventas/consignacion"><i class="fa  fa-shopping-cart text-green"></i> Consignacion </a></li>
             
             <li><a href="<?=base_url()?>inventario/cotizaciones"><i class="fa  fa-cube text-blue"></i>Cotizaciones Solicitadas</a></li>
             <li><a href="<?=base_url()?>ventas/anular"><i class=" fa fa-shopping-cart text-red"></i> ANULAR VENTAS</a></li>

          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-opencart"></i>
            <span>COMPRAS/GASTOS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li><a href="<?=base_url()?>compras/compras"><i class="fa  fa-opencart text-green"></i> Registrar Compras</a></li>
             <li><a href="<?=base_url()?>compras/gastos"><i class="fa fa-dollar"></i> Registrar Gastos</a></li>
             <li><a href="<?=base_url()?>compras/proveedores"><i class="fa  fa-group text-blue"></i> Gestionar Proveedores</a></li>
             <li><a href="<?=base_url()?>inventario/insumos"><i class="fa  fa-ticket "></i> Insumo/Items/Materiales</a></li>
             <li><a href="<?=base_url()?>inventario/inventario_insumos"><i class="fa  fa-ticket "></i> Inventario Insumos</a></li>



          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-money"></i>
            <span>COBROS</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url()?>cobranzas/consignaciones"><i class="fa  fa-list-alt text-light-blue"></i> Cuadrar Consignaciones </a></li>
            <li><a href="<?=base_url()?>administracion/admin_cuentaclientes"><i class="fa fa-user-plus"></i> Gestionar Cuenta Clientes</a></li>
            <li><a href="<?=base_url()?>404_override"><i class="fa  fa-list-alt text-light-blue"></i> Listar Cobranzas Clientes </a></lis>
            <li><a href="<?=base_url()?>404_override"><i class="fa  fa-check-square-o"></i> Cuadrar Cobranzas </a></li>
            <li><a href="<?=base_url()?>404_override"><i class="fa  fa-list-alt text-light-blue"></i> Ver Mis Cobranzas </a></li>
            <li><a href="<?=base_url()?>404_override"><i class="fa  fa-list-alt text-light-blue"></i> Gestionar Cobranzas </a></li>
          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-industry"></i>
            <span>PRODUCCION</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url()?>cobranzas/consignaciones"><i class="fa  fa-list-alt text-light-blue"></i> Pedidos Pendiente</a></li>
            <li><a href="<?=base_url()?>administracion/admin_cuentaclientes"><i class="fa fa-user-plus"></i> Pedidos a Despachar</a></li>

          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-book"></i>
            <span>CATALOGO</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
             <li><a href="<?=base_url()?>inventario/productos"><i class="fa  fa-cube text-blue"></i> Gestionar Productos </a></li>
             <li><a href="<?=base_url()?>inventario/categorias"><i class="fa  fa-cubes text-green"></i> Categoria Producto </a></li>
             <li><a href="<?=base_url()?>inventario/inventario_productos"><i class="fa  fa-edit text-yellow"></i> Inventario Productos</a></li>
              <li class="bg-info"><a href="<?=base_url()?>inventario/catalogo" target="_blank" style="background-color: rgb(0, 166, 90);"><i class="fa  fa-arrow-circle-down" style="color: rgb(255, 255, 255);"></i><span style="color: rgb(255, 255, 255);">Descargar Catalogo</span></a></li>
               </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa fa-bar-chart"></i> <span>REPORTES</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li> <a href="<?=base_url()?>reportes/inventario_global"><i class="fa  fa-list-alt text-light-blue"></i>  Inventario Global</a></li>
            <li><a href="<?=base_url()?>reportes/ventas"><i class="fa  fa-list-alt text-light-blue"></i> Reporte Ventas </a></li>
            <li><a href="<?=base_url()?>reportes/ventas_global"><i class="fa  fa-list-alt text-light-blue"></i> Reporte Ventas Global</a></li>
            <li><a href="<?=base_url()?>reportes/pedidos_global"><i class="fa  fa-list-alt text-light-blue"></i> Reporte Pedidos</a></li>

          </ul>
        </li>
        <li <?php
        if(isset($link_active)){
           if($link_active=='mensajes')
           echo' class="active" ';
          }
          ?>>
          <a href="<?=base_url()?>administracion/mensajes" >
            <i class="fa fa-envelope-o text-aqua"></i> <span>Mensajes</span>
            <?php if(count($mensajes)>0){?>
              <span class="pull-right label label-success"><?=count($mensajes)?></span>
            <?php } ?>
            <span class="pull-right-container">
            </span>
          </a>
        </li>

        <li class="header">CONFIGURACION</li>


         <li class="treeview">
          <a href="#">
            <i class="fa fa-edit"></i> <span>ADMINISTRACION</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url()?>administracion/admin_personas"><i class="fa fa-user"></i>Gestionar Personal</a> </li>
            <li><a href="<?=base_url()?>administracion/admin_sucursales"><i class="fa fa-building"></i> Gestionar Sucursales</a></li>
            <li><a href="<?=base_url()?>administracion/admin_zonas"><i class="fa fa-map-o"></i> Gestionar Zonas</a></li>
            <li><a href="<?=base_url()?>administracion/admin_clientes"><i class="fa  fa-users"></i> Gestionar Clientes</a></li>
            <li><a href="<?=base_url()?>administracion/admin_dispositivos"><i class="fa fa-android"></i> Gestionar Dispositivos</a></li>

          </ul>
        </li>
        <li class="treeview">
          <a href="#">
            <i class="fa  fa-dashboard "></i>
            <span>PORTAL WEB</span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url()?>portal/admin_diapositivas"><i class="fa fa-image"></i> Diapositivas</a></li>
            <li><a href="<?=base_url()?>portal/admin_productos_destacados"><i class="fa fa-tags"></i> Destacados</a></li>
            <li><a href="<?=base_url()?>portal/admin_banners"><i class="fa fa-object-ungroup"></i> Banners</a></li>
          </ul>
        </li>

        <li class="treeview">
          <a href="#">
            <i class="fa  fa-expeditedssl"></i>
            <span>SISTEMA </span>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="<?=base_url()?>seguridad/admin_configuracion"><i class="fa  fa-gears"></i> Configuracion <?=EMPRESA?></a></li>
            <li><a href="<?=base_url()?>seguridad/admin_basedatos"><i class="fa  fa-database"></i> Base de Datos</a></li>
            <li><a href="<?=base_url()?>seguridad/admin_bitacora"><i class="fa fa-book"></i> Bitacora</a></li>
            <li><a href="<?=base_url()?>seguridad/admin_usuarios"><i class="fa fa-users"></i> Usuarios</a></li>
            <li><a href="<?=base_url()?>seguridad/admin_notificaciones"><i class="fa fa-bell"></i> Notificaciones</a></li>
          </ul>
        </li>


      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

    <!-- Main content -->
    <section class="content">
