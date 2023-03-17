
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
             <img class="profile-user-img img-responsive img-circle" src="<?=base_url()?>assets/img/fotografias/<?=$cuenta_cliente['fotografia']?>" alt="User profile picture">

             <h3 class="profile-username text-center"><?php

             $nombres=$cuenta_cliente['nombres'];
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

             <p class="text-muted text-center"><?=$cuenta_cliente['oficio']?></p>
           </div>
           <div class="col-sm-3">
             <ul class="list-group list-group-unbordered">
               <li class="list-group-item">
                 <b>Monto Pendiente</b> <a class="pull-right"><?=$monto_pendiente?></a>
               </li>
               <li class="list-group-item">
                 <b>Items</b> <a class="pull-right">0</a>
               </li>
               <li class="list-group-item">
                 <b>Estado</b> <a class="pull-right">A</a>
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
               <label class="col-sm-4">Telefono:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" disabled value="<?=$cuenta_cliente['telefono'];?>"/>
                </div>
                <label class="col-sm-4">Email:</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" disabled value="<?=$cuenta_cliente['email'];?>"/>
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
                   <th style="min-width: 150px">Producto</th>
                   <th style="width:50px">Cant.</th>
                   <th>Fecha</th>
                   <th>Plazo</th>
                   <th>Monto</th>
                   <th style="width:20px;">Vendidos</th>
                   <th>Total</th>
                   <th>Entregado</th>
                   <?php
                   $arr_estilo=array('bg-red','bg-yellow','bg-green','bg-aqua','bg-orange','bg-blue','bg-navy','bg-teal','bg-black');
                   $i=0;
                   ?>
                 </tr>
                 </thead>
                 <?php
                 $i=0;
                 $indice=0;
                 $id_color='';
                 $arr_color=array('bg-red','bg-yellow','bg-blue','bg-navy','bg-teal','bg-olive','bg-lime','bg-orange','bg-fuchsia','bg-purple','bg-maroon',
                 'bg-black','bg-red-active','bg-yellow-active','bg-aqua-active','bg-blue-active','bg-light-blue-active',
                 'bg-green-active','bg-navy-active','bg-teal-active');
     $cantidad_pedidos=count($arr_pedidos);
     foreach ($arr_pedidos as $pedido) {
       if($i==0){
           $id_color=$pedido['id'];
       }
       if($id_color!=$pedido['id']){
         //---cambio de color
         $indice++;
         $id_color=$pedido['id'];
       }
       if($indice>18)
       $indice=0;

       $precio=($pedido['total']/$pedido['cantidad']);
       ?>
       <tr>
     <td class="<?=$arr_color[$indice]?>"><input type="hidden" id="lb_id_<?=$i?>" value="<?=$pedido['id']?>"
       /><input type="hidden" id="lb_orden_<?=$i?>" value="<?=$pedido['orden']?>"/><input type="hidden" id="precio_<?=$i?>" value="<?=$precio?>"
       /><input type="hidden" id="lb_fecha_inicio_<?=$i?>" value="<?=$pedido['fecha_inicio']?>"/><input  type="hidden" id="nota_<?=$i?>" value="<?=$pedido['anotacion']?>"
       /><input type="hidden" value="<?=$pedido['orden']?>"/>
     </td>
         <td><img  align="left" class="img-responsive" width="50px" src="<?php echo base_url()?>assets/img/catalogo/thumbs/<?=$pedido['img_producto']?>">
           <span class="text-light-blue"><?=$pedido['codigo']?> </span>&nbsp;&nbsp;<?=$pedido['nombre_producto']?>
         </td>
          <td><?php
            echo '<label id="lb_cant_max_'.$i.'">'.$pedido['cantidad'].'</label>';
            ?>
          </td>
         <td><?=$pedido['fecha_inicio']?></td>
         <td>
           <?php
           echo '<span class="text-green">+5</span>';
           ?>
         </td>
         <td><?=$pedido['total']?></td>
         <td ><?php
          //  echo '<label class="text-teal" id="lb_cant_'.$i.'"></label>';
          echo '<input style="width:65px" hidden type="number" id="lb_cant_'.$i.'" min="1" max="'.$pedido['cantidad'].'" onchange="actualizar_total('.$i.')"/>';
         ?></td>

         <td><?php
         echo '<label class="btn-block text-right" id="lb_total_'.$i.'"></label>';
         ?>
       </td>
         <td>
           <button type="button" disabled id="btn_<?=$i?>" data-toggle="modal" onclick="editarConsignacion(<?=$i?>)" data-target="#myModalEdit" class="btn btn-primary btn-xs"> <span class="btn-xs glyphicon glyphicon-edit"></span>
           </button>
           <input type="checkbox"  class="btn btn-danger" id="check_<?=$i?>" onchange="entregarProducto(<?=$i?>)"></input>'
         </td>
       </tr>
       <?php
       $i++;
     }
                 ?>
               <tr>
                 <td></td>
                 <td style="min-width: 150px"></td>
                 <td style="width:50px"></td>
                 <td></td>
                 <td></td>
                 <td></td>
                 <td style="width:20px;"><div id="lb_total_cant"></div></td>
                 <td><label id="lb_total_ventas" class="btn-block text-right"></label></td>
                 <td></td>
                 <td></td>
               </tr>
                 <tbody>

               </table>
             </div></div>
             </div>
             </div>
             <!-- /.box-body -->
           </div>
           <!-- /.box -->
         </div>
         <!-- /.col -->
         <div class=" text-center">
             <button class="btn btn-success" type="button" onclick="validacion_formvc()" >Guardar Consignacion de productos</button>
             <a href="<?php echo base_url()."cobranzas/consignacion";?>" class="btn btn-default" role="button">Cancelar</a>
         </div>
       </div>
       <form method="post" id="consignacion_formvc" action="<?=base_url()?>cobranzas/consignacion_cobranzas">
         <input type="hidden" name="arr_id" id="arr_id" value=""/>
         <input type="hidden" name="arr_orden" id="arr_orden" value=""/>
         <input type="hidden" name="arr_fecha_inicio" id="arr_fecha_inicio" value=""/>
         <input type="hidden" name="arr_vendidos" id="arr_vendidos" value=""/>
         <input type="hidden" name="arr_anotacion" id="arr_anotacion" value=""/>
         <input type="hidden" name="arr_montos" id="arr_montos" value=""/>
         <input type="hidden" name="butt_consignacion_procesar" value="ok"/>
         <input type="hidden" name="id_cliente" value="<?=$cuenta_cliente['id']?>"/>
      </form>
       <!-- /.row -->

 </section>
 <!--Mostrando Modal Productos Edit-->
 <!-- Modal -->
 <div id="myModalEdit" class="modal fade" role="dialog">
   <div class="modal-dialog">
     <input type="hidden" id="id_edit" value=""/>
     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">Cuadrar consignacion</h4>
       </div>
       <div class="modal-body">
         <div class="row form-group">
           <div class="col-sm-4">
           <b>Anotacion:</b><br><cite>Estado del producto</cite></div>
           <div class="col-sm-8"><textarea rows="4" id="edit_notas" class="form-control" value=""></textarea>
           </div>
         </div>

       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cambiarDatosTabla()">Guardar</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
     </div>

   </div>
 </div>
 <script>
 var cantidad_pedidos=<?=$cantidad_pedidos?>;
 function entregarProducto(id){
   if(document.getElementById('check_'+id).checked){
        document.getElementById('btn_'+id).disabled=false;
        $('#lb_cant_'+id).val($('#lb_cant_max_'+id).html());
        //$('#lb_cant_'+id).attr("max",$('#lb_cant_max_'+id).html()); // set a new value;
        $('#lb_cant_'+id).show();
   }else{
        document.getElementById('btn_'+id).disabled=true;
        $('#lb_cant_'+id).hide();
        $('#lb_cant_'+id).val('');
        $('#lb_total_'+id).html('');
   }
   actualizar_total(id);
 }
 function actualizar_total(id){
   var a=$('#precio_'+id).val();
   var b=$('#lb_cant_'+id).val();
   a= parseFloat(a);
   $('#lb_total_'+id).html(Math.ceil(a*b));
   //---sumado el cant_vendidos y total---
   cant_vendidos=0;
   total_suma=0;
   for (var i = 0; i <cantidad_pedidos; i++) {
      if(document.getElementById('check_'+i).checked){
       var b=$('#lb_cant_'+i).val();
       var c=$('#lb_total_'+i).html();
       cant_vendidos=cant_vendidos+parseInt(b);
       total_suma=total_suma+parseInt(c);
     }
   }
   $('#lb_total_cant').html('Total('+cant_vendidos+')=');
   $('#lb_total_ventas').html(total_suma);

 }
 function editarConsignacion(id){
   anotacion=$('#nota_'+id).val();
   $('#edit_notas').val(anotacion);
   $('#id_edit').val(id);
 }
 function cambiarDatosTabla(){
   id= $('#id_edit').val();
   anotacion= $('#edit_notas').val();
   $('#nota_'+id).val(anotacion);

 }
 function validacion_formvc(){


    var concat='';
    var conteo=0;
    for(var q=0;q<cantidad_pedidos;++q)
    {
      if(document.getElementById('check_'+q).checked){
        conteo++;
        id            =$('#lb_id_'+q).val();
        orden         =$('#lb_orden_'+q).val();
        fecha_inicio  =$('#lb_fecha_inicio_'+q).val();
        cant_vendidos =$('#lb_cant_'+q).val();
        anotacion     =$('#nota_'+q).val();
        anotacion=(anotacion.split(",")).join(".");
        monto         =$('#lb_total_'+q).html();

        document.getElementById('arr_id').value=
        document.getElementById('arr_id').value+concat+id;
        document.getElementById('arr_orden').value=
        document.getElementById('arr_orden').value+concat+orden;
        document.getElementById('arr_montos').value=
        document.getElementById('arr_montos').value+concat+monto;
        document.getElementById('arr_fecha_inicio').value=
        document.getElementById('arr_fecha_inicio').value+concat+fecha_inicio;
        document.getElementById('arr_vendidos').value=
        document.getElementById('arr_vendidos').value+concat+cant_vendidos;
        document.getElementById('arr_anotacion').value=
        document.getElementById('arr_anotacion').value+concat+anotacion;
        concat=',';
     }



    }
  if(conteo>0){
   $('#consignacion_formvc').submit();
 }else {
   alert('Seleccione un producto para finalizar consignacion');
 }

}

 </script>
