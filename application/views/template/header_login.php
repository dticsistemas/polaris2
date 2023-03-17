<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title><?=EMPRESA?> - <?=TITLE?></title>
	<meta name="description" content="sistema <?=EMPRESA?>"
	<meta name="keywords" content="">
	<meta name="author" content="leonmc">

	 <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css')?>">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/bower_components/font-awesome/css/font-awesome.min.css')?>">
    <!-- Ionicons -->
    <link rel="stylesheet" href="<?= base_url('assets/adminlte/bower_components/Ionicons/css/ionicons.min.css')?>">
    <!-- Theme style -->
	<link href="<?= base_url('assets/adminlte/dist/css/AdminLTE.min.css') ?>" rel="stylesheet">
	<link href="<?= base_url('assets/adminlte/dist/css/skins/_all-skins.min.css') ?>" rel="stylesheet">

	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
</head>
<body>

	<header id="site-header">
		<nav class="navbar-inverse navbar-default" role="navigation">
			<div class="container-fluid">
				<div class="navbar-header">
					<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
						<span class="sr-only">Toggle navigation</span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="navbar-brand" href="<?= base_url() ?>">Inicio</a>
				</div>
				<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
					<ul class="nav navbar-nav navbar-right">
						<?php if (isset($_SESSION['username']) && $_SESSION['logged_in'] === true) : ?>
							<li><a href="<?= base_url('logout') ?>">Logout</a></li>
						<?php else : ?>
							<li><a href="<?= base_url('login') ?>">iniciar sesión</a></li>
						<?php endif; ?>
					</ul>
				</div><!-- .navbar-collapse -->
			</div><!-- .container-fluid -->
		</nav><!-- .navbar -->
	</header><!-- #site-header -->
