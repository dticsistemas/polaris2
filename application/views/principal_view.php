<div class="banner-wrap">
  <div class="banner">
    <div class="banner-inner">
      <div class="container">
        <div class="banner-content">
          <h1 class="banner-heading enfasis">
            <span class="banner-heading-1">Creatividad</span>
            <span class="banner-heading-2">&amp;</span>
            <span class="banner-heading-3">Diseño</span>
          </h1>
          <div class="banner-content-inner">
            <p>
              <?php echo $this->lang->line('welcome_message'); ?>
            </p>
          </div>
          <a class="button button-primary banner-button" href="#about">Descubre mas</a>
          <a class="button button-secondary banner-button" href="#work">Ver trabajos</a>
        </div>
      </div>
    </div>
  </div>
</div>  <!--End banner-wrap-->

<div id="about" class="about"> 
  <h1 class="text-center">Quienes somos</h1>
  <div class="row"> 
    <div class="col-sm-2"></div>
  <div class="col-sm-8" >
  <h5 class="text-center">
    <p>
       
     Somos un grupo de personas apasionadas por el arte de la confección de muebles y todo lo relacionado al arte, heredamos el oficio de generaciones pasadas y nos enfocamos en mantener vivas las tradiciones.</p>
  </h5>
  </div>
  <div class="col-sm-2"></div>
  </div>
  <div class="row">
    <div class="col-sm-6">   
      <div class="jumbotron caja-banners">  
        <p class="lead ">"POLARIS" , somos una empresa dedicada a la fabricación y comercialización
          de productos para el hogar, industria y la oficina
          .</p>

        <p class="lead ">Formamos parte de una red colaborativa de empresas fabricantes productores, que nos permite ofrecer una amplia gama de
        soluciones para sus necesidades, sean productos o servicios </p>
        <p class="lead ">Implementamos soluciones tecnológicas adaptadas a las necesidades del
          cliente para cada uno de los colaboradores de nuestra red</p>
          <p class="lead ">
          Nuestra larga experiencia y aprendizaje en el proceso desde que el cuero es curtido hasta darle su nueva forma nos permiten seleccionar los mejores materiales y crear estructuras hechas por manos expertas, artesanos que dedican su vida a crear piezas únicas mezclando lo moderno con lo clásico.</p>
        </div>
    </div>
    <div class="col-sm-6">
       <img src="<?=base_url()?>assets/img/empresa_colaboracion.jpg" class="img-fluid">
     </div>
   </div>
 
   <div class="text-center">
     <a class="button button-third" href="<?=base_url()?>empresa"><span class="none inline-tablet"></span>Conoce nuestra historia</a>
   </div>
       
</div><!--/End panel Abouts-->  




<div id="work" class=" caja-banners">
  <h2>Catalogo</h2>
    
  <div class="clear row">
     <div class="col-sm-3"><img src="<?=base_url()?>assets/img/web/categorias/logca2t.jpg" class="img-fluid"></div>
    <div class="col-sm-3"><img src="<?=base_url()?>assets/img/web/categorias/ceramica.jpg" class="img-fluid"></div>
     <div class="col-sm-3"><img src="<?=base_url()?>assets/img/web/categorias/fibranatural.jpg" class="img-fluid"></div>
      <div class="col-sm-3"><img src="<?=base_url()?>assets/img/web/categorias/stone.jpg" class="img-fluid"></div>
       <div class="col-sm-3"><img src="<?=base_url()?>assets/img/web/categorias/corporativos.jpg" class="img-fluid"></div>
        <div class="col-sm-3"><img src="<?=base_url()?>assets/img/web/categorias/gourmet.jpg" class="img-fluid"></div>
         <div class="col-sm-3"><img src="<?=base_url()?>assets/img/web/categorias/new-apaz-textile-slider-31.jpg" class="img-fluid"></div>
          <div class="col-sm-3 caja-banners">
            <div class="caja-banner"><a class="button button-primary banner-button" href="<?=base_url()?>productos">
            Ver Galeria / Trabajos
            </a></div>
            <div class="caja-banner"><a class="button button-primary banner-button" href="<?=base_url()?>productos/listar">
            Ver Catalogo Productos
            </a></div>
             
          </div>
  
  </div>
  
  <div class="caja-banners">
  <h2>Productos Destacados</h2>
 <div class="row">
    <?php
    $max=4;
  if(count($productos_destacados)>0){
  foreach ($productos_destacados as $producto_destacado) {
    $max--;
    if($max<0) break;
        ?>
<div class="col-md-3">
          <div class="card mb-4 shadow-sm">
            <svg class="bd-placeholder-img card-img-top" width="100%" height="35" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: Thumbnail">
              <title>Placeholder</title><rect width="100%" height="100%" fill="#55595c"></rect>

              <text x="36%" y="50%" fill="#eceeef" dy=".3em">Producto</text>
            </svg>
            <img src="<?php echo base_url();?>assets/img/catalogo/small/<?php echo $producto_destacado['imagen']; ?>" alt="..." 
      style="height:105px ;width:100%" class="img-fluid">
            <div class="card-body">
              <h4><?php echo substr($producto_destacado['nombre'],0,125);?></h4>
              <p class="card-text"><?php
        if($producto_destacado['nota']!=''){
          echo $producto_destacado['nota'];
        }else
           echo substr(strip_tags($producto_destacado['descripcion']),0,125)."...";
        ?>.</p>
              <div class="d-flex justify-content-between align-items-center">
                <div class="btn-group">
                   <a href="<?php echo base_url()."productos/detalle/".$producto_destacado['id_producto'];?>" class="btn btn-sm btn-outline-secondary" role="button">Ver Producto &raquo;</a>
                 
                   <?php if(CARRITO){?>
                  <button onclick="agregarCarrito(<?=$producto_destacado['id_producto']?>)" class="btn btn-default" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> +</button>
                <?php }?>

                </div>
                <small> 15Bs</small>
              </div>
            </div>
          </div>
        </div>         


  <?php

  }
  }

  ?>

</div>
</div><!-- /.destacados -->

</div> <!--End Works-->



<div id="banners" class="caja-banners">
<div class="row">  
<?php
  if (isset($banners))
    foreach ($banners as $banner) {
      $titulo=$banner['titulo'];
      $subtitulo=$banner['subtitulo'];
      $imagen=$banner['imagen'];
      $descripcion=$banner['descripcion'];


  ?>
  <div class="col-md-6">
      <div class="row no-gutters border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col-sm-8 p-4 d-flex flex-column position-static">
          <strong class="d-inline-block mb-2 text-primary"><?=$subtitulo?></strong>
          <h3 class="mb-0"><?=$titulo?></h3>
          <div class="mb-1 text-muted">Nov 12</div>
          <p class="card-text mb-auto"><?=$descripcion?>.</p>
          <a href="#" class="stretched-link">Continuar leyendo</a>
        </div>
        <div class="col-sm-4  banner-block">          
        <img src="<?=base_url()?>assets/img/web/banners/<?=$imagen?>"">
        </div>
      </div>
    </div>


<?php
}
?>
</div>
</div><!--End novedades-->
        
<div id="contact" class="contact-background ">
<div class="feature-box">
  <h1 class="text-center">Contactenos</h1>  
  <h5 class="text-center">
    <p>
       Listos para atender tus solicitudes.</p>
  </h5>
  <div class="contact-block-inner container ">
  <div class="row">
  <div class="col-sm-6 contact-form">
    
   <div class="jumbotron caja-banners">
      <p class="comentario">Para comunicarse con nosotros solo complete el siguiente formulario con sus datos
      personales y nuestros ejecutivos se contactarán con usted a la brevedad.</p>
      <?php
                     echo validation_errors();
                     if(isset($resultado))
                     echo $resultado;
                ?>
                      <?php
                          $atributos = array('class' => 'form-horizontal', 'id' => 'formulario_contacto');
                          echo form_open('contacto',$atributos);
                      ?>
      <form action="<?=base_url()?>/contacto" class="form-horizontal" id="formulario_contacto" method="post" accept-charset="utf-8">
         <form>

        <div class="input-group mb-2">  
        <div class="input-group-prepend">
          <span class="input-group-text"><i class="fa fa-user"></i></span>
        </div>       
          <input class="form-control" placeholder="Nombre" name="nombre" id="nombre" type="text">
        </div>       
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-at"></i></span>
          </div>
          <input class="form-control" placeholder="Email" name="email" id="email" type="email">
        </div>
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-phone"></i></span>
          </div>
          <input class="form-control" placeholder="Telefono"  name="telefono" id="telefono" type="text">
        </div>        
        <div class="input-group mb-2">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="fa fa-envelope"></i></span>
          </div>
          <textarea class="form-control" name="mensaje"  placeHolder ="Consulta o sugerencia"  id="mensaje"></textarea>
        </div>
        <div class="input-group mb-2">
        <label><span>(*)</span> Ingrese el Codigo de verificacion: </label>
                <?php echo $captcha['image'];
                           // echo "<p> ".$captcha['word']."</p>";
                          ?>
                <input class="form-control" type="text" name="captcha" value="">
        </div>                
        <div class="form-group caja-banners">          
                <button type="button" class="btn btn-info float-right" id="btn_contacto">Enviar Consulta</button>
        </div>        

      </form>

    </div><!-- Fin contacto-izq -->
  </div>   
  <div class="col-sm-6">
     <div class="contact-block-content">
      <h2 class="fs-2 ">Polaris APK</h2>
      <p>Gracias por su interés en Polaris APK. Por favor contáctenos usando la información a continuación. Para localizar contactos en la oficinas de APK Polaris cercana a usted, visite los sitios web de nuestra oficina. Para obtener las últimas actualizaciones de APK Polaris, suscríbase a un boletín o conéctese con nosotros en las redes sociales..</p>
      <ul class="contact-list">
        <li><span class="icon contact-icon contact-icon-location">B/ Roca y Coronado calle 1º Mayo Central Nº25, Santa Cuz - Bolivia</span></li>
        <li><span class="icon contact-icon contact-icon-phone">+591</span></li>
        <li><span class="icon contact-icon contact-icon-phone">+591</span></li>
        <li><span class="icon contact-icon contact-icon-email"><a href="mailto:hello@skokovcompany.com?subject=General%20Enquiry&amp;anp;body=">contacto@apkpolaris.com</a></span></li>
      </ul>
      <div class="text-center">
     <a class="button button-third" href="<?=base_url()?>contacto"><span class="none inline-tablet"></span>Ver Nuestras sucursales</a>
   </div>
  </div> 

  </div>
  </div><!--End row-->
  </div>
</div><!--End Features-->
</div><!--End contacto-->



  <!-- Carousel
    ==================================================
  <div id="myCarousel" class="carousel slide carousel-back" data-ride="carousel">
 
  <ol class="carousel-indicators">
    <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
    <?php
      $cont_slide=1;

       while ( $cont_slide< count($slideshow)) {
         echo '<li data-target="#myCarousel" data-slide-to="'.$cont_slide.'"></li>';
         $cont_slide++;
       }
    ?>
  </ol>
  <div class="carousel-inner" style="display: flex; justify-content: center;" role="listbox">
    <?php
        $cont_slide=0;
       while ( $cont_slide<count($slideshow)) {
         $slide_aux=$slideshow[$cont_slide];


    ?>
    <div class="item <?php if ($cont_slide==0) echo " active";?>">
      <img src="<?php echo base_url();?>assets/img/web/slideshow/<?php echo $slide_aux['url'];?>" alt="Chania">
      <div class="carousel-caption">
         <p><?php echo $slide_aux['title'];?></p>
      </div>
    </div>
    <?php
        $cont_slide++;
        }
    ?>

  </div>
  

 
  <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
</div>
 End Carousel-->

