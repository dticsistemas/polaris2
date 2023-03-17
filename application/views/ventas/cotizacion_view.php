
<?php
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
         <div class="col-xs-12">
           <h2 class="page-header">
            <?=EMPRESA?>

             <?php
             	if (isset($title))
             	echo " ".$title;

             ?>
             <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?></small>
           </h2>
         </div>
         <!-- /.col -->
         <div class="row">
           <div class="col-sm-3">
             <img class="profile-user-img img-responsive img-circle" src="<?=base_url()?>assets/img/fotografias/no_image.png" alt="User profile picture">

             <h3 class="profile-username text-center"><?php

             $nombres=$cotizacion['nombre'];
             if(strlen($nombres)<15){
               echo $nombres;
             }else{
               $nombre='';
               $j=0;
               for($i=0;$i<strlen($nombres);$i++){
                    $a=$nombres[$i];
                    if($a==' '){
                    $j++;
                    }
                    if($j>1){
                    break;
                    }
                    $nombre=$nombre.$a;
               }
               echo $nombre;
             }


             ?></h3>

             <p class="text-muted text-center"></p>
           </div>
           <div class="col-sm-3">
             <ul class="list-group list-group-unbordered">
               <li class="list-group-item">
                 <b>EMPRESA</b> <a class="pull-right"><?=$cuenta_cliente['empresa']?></a>
               </li>
               <li class="list-group-item">
                 <b>Telefono</b> <a class="pull-right"><?=$cuenta_cliente['telefono']?></a>
               </li>
               <li class="list-group-item">
                 <b>Fecha</b> <a class="pull-right"><?=$cuenta_cliente['fecha']?></a>
               </li>
               <li class="list-group-item">
                 <b>Items</b> <a class="pull-right"><?=$cotizacion['items']?></a>
               </li>
               <li class="list-group-item">
                 <b>Estado</b> <?php
                 if($cuenta_cliente['estado']==0)
                  echo '<a class="pull-right text-red">PENDIENTE</a>';
                 else
                  echo '<a class="pull-right text-green">PROCESADO</a>';
                 ?>
               </li>


             </ul>
           </div>
           <div class="col-sm-6">
             <label class="col-sm-4">Nombre:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" disabled value="<?=$nombres?>"/>
              </div>

              <label class="col-sm-4">Direccion:</label>
               <div class="col-sm-8">
                 <input type="text" class="form-control" disabled value="<?=$cuenta_cliente['direccion'];?>"/>
               </div>
                <label class="col-sm-4">Email:</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" disabled value="<?=$cuenta_cliente['email'];?>"/>
                 </div>
                 <label class="col-sm-4">Mensaje:</label>
                  <div class="col-sm-8">
                    <textarea class="form-control" rows="4">
                    <?php

                        echo $cuenta_cliente['mensaje'];
                    ?></textarea>
                  </div>
           </div>
         </div>
         <div class="box-body box-profile">
      </div>

       </div>
       <!-- info row -->
       <div class="row invoice-info">

         <div class="col-xs-12">

           <div class="box">
             <!-- /.box-header -->
             <div class="box-body">
               <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                 <div class="row">
                 <div class="col-sm-12">
                 <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                 <thead>
                 <tr role="row">
                   <th><span class="glyphicon glyphicon-th-list"></span></th>
                   <th>Codigo</th>
                   <th style="min-width: 150px">Producto</th>
                   <th >Nombre</th>
                   <th style="width:50px">Cant.</th>
                   <th>Precio</th>
                   <th>Total</th>
                   <?php
                   $arr_estilo=array('bg-red','bg-yellow','bg-green','bg-aqua','bg-orange','bg-blue','bg-navy','bg-teal','bg-black');
                   $i=0;
                   ?>
                 </tr>
                 </thead>
                 <?php
                 $i=0;
                 $indice=-1;
                 $id_color='';
                 $arr_color=array('bg-red','bg-yellow','bg-blue','bg-navy','bg-teal','bg-olive','bg-lime','bg-orange','bg-fuchsia','bg-purple','bg-maroon',
                 'bg-black','bg-red-active','bg-yellow-active','bg-aqua-active','bg-blue-active','bg-light-blue-active',
                 'bg-green-active','bg-navy-active','bg-teal-active');
     $cantidad_pedidos=count($arr_pedidos);
     foreach ($arr_pedidos as $pedido) {
       if($indice>19)
       $indice=0;
       $indice++;



       $precio=0;
       ?>
       <tr>
     <td class="<?=$arr_color[$indice]?>"><input type="hidden" id="lb_id_<?=$i?>" value="<?=$pedido['id_producto']?>"
       />
     </td>
      <td><span class="text-light-blue"><?=$pedido['codigo']?> </span></td>
         <td><img  align="left" class="img-responsive" width="50px" src="<?php echo base_url()?>assets/img/catalogo/thumbs/<?=$pedido['img_producto']?>">
         </td>
         <td>
            <?=$pedido['nombre_producto']?>
         </td>
           <td><?=$pedido['cantidad']?></td>
          <td><?php
            echo '<label id="lb_'.$i.'">'.$pedido['precio_base'].'</label>';
            ?>
          </td>

         <td>
           <?php
           if($pedido['precio']!=0)
           echo '<input type="text" disabled id="lb_total_'.$i.'" value="'.($pedido['precio_base']*$pedido['cantidad']).'" class="form-control">';
         else
           echo '<input type="text" id="lb_total_'.$i.'" value="'.($pedido['precio_base']*$pedido['cantidad']).'" class="form-control">';
           ?>
         </td>



       </tr>
       <?php
       $i++;
     }
                 ?>
                 <tbody>

               </table>

             </div>
             <div class="row">
               <div class="col-sm-2">
                 <div class="checkbox">
                      <label>
                        <input id="check_email" type="checkbox"
                        <?php
                        if($cuenta_cliente['estado']==0)
                        echo 'checked';

                         ?>> <b> Responder con email</b>
                      </label>
                    </div>
               </div>
               <div class="col-sm-10">
<textarea style="width:100%" rows="5" name="respuesta" id="respuesta"><?php
if($cuenta_cliente['estado']!=0){
  echo '[Procesado el '.$cotizacion['fecha_respuesta']."]\n";
}
echo $cotizacion['respuesta'];
?></textarea>
              </div>
           </div>
           </div>
             </div>
             </div>
             <!-- /.box-body -->
           </div>
           <!-- /.box -->
         </div>
         <!-- /.col -->
         <div class=" text-center">
             <button class="btn btn-success" type="button" onclick="validacion_formvc()" >Procesar Solicitud  Cotizacion de productos</button>
             <a href="<?php echo base_url()."inventario/cotizaciones";?>" class="btn btn-default" role="button">Volver al Listado</a>
         </div>
       </div>
       <form method="post" id="cotizacion_formvc" action="<?=base_url()?>inventario/gestionarcotizaciones">
         <input type="hidden" name="arr_id" id="arr_id" value=""/>
         <input type="hidden" name="arr_montos" id="arr_montos" value=""/>
         <input type="hidden" name="butt_consignacion_procesar" value="ok"/>
         <input type="hidden" name="id_cotizacion" value="<?=$cuenta_cliente['id']?>"/>
         <input type="hidden" id="mensaje" name="respuesta" value="<?=$cuenta_cliente['id']?>"/>
         <input type="hidden" id="email_to" name="email_to" value="<?=$cuenta_cliente['email'];?>"/>
         <input type="hidden" id="enviar_email" name="enviar_email" value="ok"/>


      </form>
       <!-- /.row -->

 </section>

 <script>
var cantidad_pedidos=<?=count($arr_pedidos)?>;
 function validacion_formvc(){

    var concat='';
    var conteo=0;
    for(var q=0;q<cantidad_pedidos;++q)
    {
        conteo++;
        id            =$('#lb_id_'+q).val();
        monto         =$('#lb_total_'+q).val();

        document.getElementById('arr_id').value=
        document.getElementById('arr_id').value+concat+id;
        document.getElementById('arr_montos').value=
        document.getElementById('arr_montos').value+concat+monto;
      //  document.getElementById('arr_anotacion').value=
      //  document.getElementById('arr_anotacion').value+concat+anotacion;
        concat=',';



    }
  if(conteo>0){
   $('#mensaje').val($('#respuesta').val());
   if(document.getElementById('check_email').checked)
   $('#enviar_email').val('ok');
   $('#cotizacion_formvc').submit();
 }else {
   alert('Seleccione un producto para finalizar cotizacion');
 }

}

 </script>
