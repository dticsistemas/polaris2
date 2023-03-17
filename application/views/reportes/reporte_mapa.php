 <?php 
if (!isset($title))
  $title='no existe title';

if (!isset($titulo))
  $titulo='no existe ';

 if(isset($success)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-success alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-check"></i> Info!</h4>
                <?=$success?>
              </div>
    </div>
  <?php
 }
 if(isset($error)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-danger alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning "></i> Advertencia!</h4>
                <?=$error?>
              </div>
    </div>
  <?php
 }
  if(isset($warning)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-warning alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-warning "></i> Advertencia!</h4>
                <?=$warning?>
              </div>
    </div>
  <?php
 }
  if(isset($info)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-info alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h4><i class="icon fa fa-info"></i> Info!</h4>
                <?=$info?>
              </div>
    </div>
  <?php
 }
 ?>

 

<!-- Main content -->
    <section class="invoice">
      <!-- title row -->
      <div class="row">
          <h2 class="page-header">
            <i class="fa fa-globe"></i> SISFRUT Inc.  
              <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?> </small>          
          </h2>
     
        
      </div>

<div class="box">
<div class="box-header">
</div>
<!-- /.box-header -->
<div class="box-body">
<br>
<div class="row">




</div>
</div>   <!-- Box--> 




<canvas id="polygons" width="900" height="900">
        <p>Su navegador no soporta HTML5</p>
        </canvas>

 
    </section>
    <!-- /.content -->
    <div class="clearfix"></div>

 <script type="application/x-javascript">
        function simpleCanvas() {           
            /* Recuperamos el canvas */
          var canvas = document.getElementById("polygons");   
                if (canvas.getContext) {
                /* Obtenemos el contexto plano (2d) */
                var ctx = canvas.getContext("2d"); 
                /* Establecemos el valor RGB del primer polígono */
                ctx.fillStyle = "#c3c3a2";     
                    // Comenzamos un trazo
                    ctx.beginPath();   
                    // Desplazamos el punto a la posición 10,10
                   <?php
                    if(isset($terreno)){
                      $coordenadas=$terreno['coordenadas'];
                      if($coordenadas!=''){
                        $coordenadas=str_replace('(','',$coordenadas);
                        $coordenadas=str_replace(')','',$coordenadas);
                        $puntos=explode('-',$coordenadas);
                        $i=0;
                        foreach ($puntos as $point) {

                          $xy=explode(',',$point);
                           if($i==0)
                             echo "ctx.moveTo(".$xy[0].",".$xy[1]." );"; 
                           else
                             echo "ctx.lineTo(".$xy[0].",".$xy[1]." );";
                          $i++;
                        }
                      }
                    }

                  ?>

                  ctx.fillStyle = "#ddff99";
                  ctx.stroke(); 
                    // Por último pintamos el resultado 
                    ctx.fill();

                 


           <?php
 /////////////////////////////////////////////////////////////////
//------------------------   GRAFICANDO ZONAS
////////////////////////////////////////////////////////////////   
            if(isset($zonas)){
              foreach ($zonas as $zona) {                            
              $coordenadas=$zona['coordenadas'];
              $color=$zona['color'];
              $nombre=$zona['nombre'];
              if($coordenadas!=''){
                $coordenadas=str_replace('(','',$coordenadas);
                $coordenadas=str_replace(')','',$coordenadas);
                $puntos=explode('-',$coordenadas);
                $i=0;  $dxy='';              
                echo 'ctx.beginPath(); ';
                foreach ($puntos as $point) {

                  $xy=explode(',',$point);
                   if($i==0){
                     echo "ctx.moveTo(".$xy[0].",".$xy[1]." );"; 
                     $dxy[0]=$xy[0];
                     $dxy[1]=$xy[1];
                   }
                   else
                     echo "ctx.lineTo(".$xy[0].",".$xy[1]." );";
                  $i++;
                }
                echo 'ctx.fillStyle = "'.$color.'";  ';
                echo 'ctx.fill();';
                echo 'ctx.fillStyle = "black";  ';
                echo 'ctx.font = "10px Arial";';
                echo 'ctx.fillText("'.$nombre.'",'.$dxy[0].','.$dxy[1].'+15); ';
              }
            }//---End foreach
          }

          ?>



///////////////////////////
 
                }
 
            

        }
        simpleCanvas();
    </script>