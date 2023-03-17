<div class="container starter-container">
       	    
	<h1>NUESTROS PRODUCTOS</h1>
	<h4> Nuestra  amplia variedad de productos que le ofrecemos</h4>
	<?php 
	    foreach ($categorias as $value): 
        $nombre=$value["nombre"];
        $id=$value["id"];            
        $descripcion=$value["descripcion"];  

	?>
	<div class="col-md-3">
    <div class="thumbnail">
    <a href="<?php echo base_url();?>productos/categoria/<?php echo $id;?>">         
      
      <h4 class="text-primary"><?php echo substr($nombre,0,125);?></h4> 	
        <img src="<?php echo base_url();?>assets/img/categorias.png" class="img-rounded img-responsive" height="323" width="567">			
	    <div class="caption">       
        <p><?php echo str_pad(substr(strip_tags($descripcion),0,125),128,'. ');?></p>
        
      </div>
      </a> 
    </div>    
    </div>

	
	 									
	<?php endforeach ?> 																	

</div><!-- End container --> 
		