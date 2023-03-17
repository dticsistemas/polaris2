
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
<?php
$cuenta=$cuenta_cliente['cuenta_cliente'];
?>
             <p class="text-muted text-center"><?=$cuenta_cliente['oficio']?></p>
           </div>
           <div class="col-sm-4">
             <ul class="list-group list-group-unbordered">
               <li class="list-group-item">
                 <b>Nombre</b> <a class="pull-right"><?=$nombres?></a>
               </li>
               <li class="list-group-item">
                 <b>Dirección</b> <a class="pull-right"><?=$cuenta_cliente['direccion'];?></a>
               </li>
               <li class="list-group-item">
                 <b>Telefono</b> <a class="pull-right"><?=$cuenta_cliente['telefono'];?></a>
               </li>
               <li class="list-group-item">
                 <b>Email</b> <a class="pull-right"><?=$cuenta_cliente['email'];?></a>
               </li>
               <li class="list-group-item">
                 <b>Creación Cuenta</b> <a class="pull-right"><?=$cuenta['fecha_creacion']?></a>
               </li>
             </ul>
           </div>
           <form method="post" action="<?=base_url()?>administracion/admin_cuenta_plan_pagos">
             <input type="hidden" name="id_cliente" value="<?=$cuenta_cliente['id']?>"/>
             <input type="hidden" name="success" value="ok">
           <div class="col-sm-5">
             <label class="col-sm-4">Deuda:</label>
              <div class="col-sm-8">
                <input type="text" class="form-control" disabled value="<?=$cuenta['deuda']?>"/>
              </div>
              <label class="col-sm-4">Saldo:</label>
               <div class="col-sm-8">
                 <input type="text" class="form-control" disabled value="<?=$cuenta['saldo']?>"/>
               </div>
               <label class="col-sm-4">Estado:</label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" disabled value="<?=$cuenta['estado']?>"/>
                </div>
                <label class="col-sm-4">Tipo:</label>
                 <div class="col-sm-8">
                   <input type="text" class="form-control" disabled value="<?=$cuenta['tipo']?>"/>
                 </div>
                 <label class="col-sm-4">Credito Maximo:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" name="monto_credito_maximo" value="<?=$cuenta['monto_credito_maximo'];?>"/>
                  </div>
                  <label class="col-sm-4">Cobrador_Asignado:</label>
                   <div class="col-sm-12">
                     <?php
                    // $combox_sucursales=array('0'=>'juan perez perez','1'=>'klon admin');
                       echo form_dropdown('id_cobrador', $select_cobrador,$cuenta['id_cobrador'],'class="form-control" name="id_cobrador" id="id_cobrador"' );
                      ?>

                   </div>
                  <div class="col-sm-12">
                  <button type="submit" name="butt_actualizar_cc" value="ok" class="btn btn-block btn-primary">Actualizar Cuenta Cliente</button>
                  </div>

           </div>
         </form>
         </div>
         <div class="box-body box-profile">
      </div>

       </div>

<div class="row invoice-info">
  <?php
  if($plan_pago!=null){
  ?>
       <div class="col-md-12">
          <!-- Horizontal Form -->
          <div class="box box-info">
            <div class="box-header with-border">
              <h3 class="box-title">Plan Pago(vigente)</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->

              <div class="row">
                <div class="col-sm-6">
                  <div class="row">
                  <label for="inputEmail3" class="col-sm-4 control-label">Id</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="id_plan" value="<?=$plan_pago['id']?>">
                  </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Monto Total</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['monto_total']?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Deuda anterior</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['deuda_anterior']?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Plan anterior</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['id_plan_anterior']?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Fecha Inicio</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['fecha_inicio']?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Fecha Creacion</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['fecha_creacion']?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Estado</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['estado']?>">
                    </div>
                  </div>
                </div>


                <div class="col-sm-6">
                  <div class="row">
                  <label for="inputEmail3" class="col-sm-4 control-label">Monto inicial</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="inputEmail3" value="<?=$plan_pago['monto_inicial']?>">
                  </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Nro Cuotas</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['nro_cuotas']?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Tipo Periodico</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['tipo_periodico']?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Monto Cuota</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['monto_cuotas']?>">
                    </div>
                  </div>
                  <div class="row">
                    <label for="inputPassword3" class="col-sm-4 control-label">Nota</label>

                    <div class="col-sm-8">
                      <input type="text" class="form-control" value="<?=$plan_pago['nota']?>">
                    </div>
                  </div>
                  <div class="row">
                    <input type="checkbox"  class="btn btn-danger" id="check_plan" onchange="habilitarreprogramacion()"></input>'
                    <button type="button" disabled id="btn_reprogramar" data-toggle="modal"
                     onclick="calcularxnumero()"  data-target="#myModalEdit2"
                      class="btn btn-primary btn-xs">
                      <span class="btn-xs glyphicon glyphicon-edit"> Reprogramar Plan</span>
                    </button>

                  </div>

                </div>


              </div>
              <!-- /.box-body -->
<div class="row" id="fichas_plan_pago">
  <?php
    foreach ($cuotas as $cuota) {
    echo '<div class="col-sm-3" id="ficha_'.$cuota['numero'].'">';
    if($cuota['estado']=='A')//pendiente
    echo '<div class="info-box bg-aqua">';
    else if($cuota['estado']=='P')//pagado
    echo '<div class="info-box bg-green">';
    else if($cuota['estado']=='M')//mora
    echo '<div class="info-box bg-red">';
    else if($cuota['estado']=='B')//a medias
    echo '<div class="info-box bg-yellow">';
    if($cuota['estado']=='X')//cancelado
    echo '<div class="info-box bg-black">';

    echo 'Nro:'.$cuota['numero'].'<br>';
    echo 'Monto:'.$cuota['monto_cuota'].'<br>';
    echo 'Pagado:'.$cuota['monto_pagado'].'<br>';
    echo 'Estado:'.$cuota['estado'].'<br>';
    echo 'Fecha a cobrar:'.$cuota['fecha_pago'].'<br>';
    echo 'Fecha pagada:'.$cuota['fecha_pagada'].'<br>';
    echo 'Cobrador:'.$cuota['id_cobrador'].'<br>';
    echo '</div>';
    //echo '<input type="checkbox"  class="btn btn-danger" id="check_<?=>';
    echo '<button type="button" id="btn_<?=$i?>" data-toggle="modal"';
    echo '  onclick="editarCuota('.$cuota['numero'].','.$cuota['id_plan_pago'].')" data-target="#myModalEdit"';
    echo '  class="btn btn-primary btn-xs">';
    echo '  <span class="btn-xs glyphicon glyphicon-edit"> Edit</span>';
    echo '</button>';
    echo '</div>';
    }

  ?>
</div>

          </div>
          <!-- /.box -->

          <!-- /.box -->
        </div>
        <?php
}else{

  echo "No existe Plan de pago vigente...";
}
        ?>
       </div>
       <!-- info row -->
       <div class="row invoice-info">

         <div class="col-xs-12">

           <div class="box">
             <div class="box-header with-border">
               <h3 class="box-title">Historial de pagos</h3>
             </div>
             <!-- /.box-header -->

             <div class="box-body">
               <div id="example1_wrapper" class="dataTables_wrapper form-inline dt-bootstrap">
                 <div class="row">
                 <div class="col-sm-12">

                 <table id="data_table" class="table table-bordered table-striped dataTable" role="grid" aria-describedby="example1_info">
                 <thead>
                 <tr role="row">
                   <th><span class="glyphicon glyphicon-th-list"></span></th>
                   <th style="min-width: 50px">ID</th>
                   <th style="width:200px">Fecha Programada</th>
                   <th style="width:120px">Monto</th>
                   <th style="width:200px">ID Cobrador</th>
                   <th style="width:120px">Plan Pago</th>
                   <th style="width:350px">Cuota Pagadas</th>

                   <?php
                   $arr_estilo=array('bg-red','bg-yellow','bg-green','bg-aqua','bg-orange','bg-blue','bg-navy','bg-teal','bg-black');
                   $i=0;
                   ?>
                 </tr>
                 </thead>

                 <?php

                 foreach ($historico_pagos as $pago) {
                  // print_r($pago);
                   echo "<tr>";
                   echo "<td>";
                   echo "</td>";
                   echo "<td>";
                   echo $pago['id'];
                   echo "</td>";
                   echo "<td>";
                   echo $pago['fecha'];
                   echo "</td>";
                   echo "<td>";
                   echo '<span class="text-green">'.$pago['monto'].'</span>';
                   echo "</td>";
                   echo "<td>";
                   echo $pago['id_cobrador'];
                   echo "</td>";
                   echo "<td>";
                   echo '<span class="text-light-blue">'."ID PLAN:".$pago['id_plan_pago']."</span>";
                   echo "</td>";
                   echo "<td>";
                   foreach ($pago['cuotas'] as $tmp) {

                     echo "Nro Cuota:".$tmp['numero']."<br>";
                     echo "Monto Cuota:".$tmp['monto_cuota']."<br>";
                     echo "Monto Pagado:".$tmp['monto_pagado']."<br>";
                     echo "Estado:".$tmp['estado']."<br>";
                   }
                   echo "</td>";
                   echo "</tr>";
                 }

                 ?>

                 <?php
                 $i=0;
                 $indice=0;
                 $id_color='';
                 $arr_color=array('bg-red','bg-yellow','bg-blue','bg-navy','bg-teal','bg-olive','bg-lime','bg-orange','bg-fuchsia','bg-purple','bg-maroon',
                 'bg-black','bg-red-active','bg-yellow-active','bg-aqua-active','bg-blue-active','bg-light-blue-active',
                 'bg-green-active','bg-navy-active','bg-teal-active');
     $cantidad_pedidos=count($cuotas);
     foreach ($cuotas as $cuota) {
      /* if($i==0){
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
       */
       ?>

       <?php
       $i++;

     }

                 ?>

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
 <!--Mostrando Modal CuotasEdit-->
 <!-- Modal -->
 <div id="myModalEdit" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">
             <input type="hidden" name="id_plan_pago" id="id_plan_pago" value=""/>
             MODIFICAR PLAN PAGO [<span id="txt_plan_pago"> 0</span>]

         </h4>
       </div>
       <div class="modal-body">
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Numero Cuota:</b>
          </div>
          <div class="col-sm-8">
            <input type="text" disabled name="id_numero" id="id_numero" value=""/>
          </div>
        </div>
        <div class="row form-group">
         <div class="col-sm-4">
         <b>Monto Cuota:</b>
         </div>
         <div class="col-sm-8">
           <input type="text" name="edit_monto_cuota" id="edit_monto_cuota" value=""/>
         </div>
       </div>
       <div class="row form-group">
        <div class="col-sm-4">
        <b>Monto Pagado:</b>
        </div>
        <div class="col-sm-8">
          <input type="text" name="edit_monto_pagado" id="edit_monto_pagado" value=""/>
        </div>
      </div>
      <div class="row form-group">
       <div class="col-sm-4">
       <b>Estado Cuota:</b>
       </div>
       <div class="col-sm-8">
         <input type="text" name="edit_estado" id="edit_estado" value=""/>
       </div>
     </div>
     <div class="row form-group">
      <div class="col-sm-4">
      <b>Fecha a Cobrar:</b>
      </div>
      <div class="col-sm-8">
        <input type="text" name="edit_fecha_cobrar" id="edit_fecha_cobrar" value=""/>
      </div>
    </div>
      <div class="row form-group">
       <div class="col-sm-4">
       <b>Fecha Pagada:</b>
       </div>
       <div class="col-sm-8">
         <input type="text" name="edit_fecha_pagada" id="edit_fecha_pagada" value=""/>
       </div>
     </div>
     <div class="row form-group">
      <div class="col-sm-4">
      <b>Cobrador:</b>
      </div>
      <div class="col-sm-8">
        <input type="text" name="edit_cobrador" id="edit_cobrador" value=""/>
      </div>
    </div>
    <div class="row form-group">
     <div class="col-sm-4">
     <b>Motivo:</b>
     </div>
     <div class="col-sm-8">
       <input type="text" name="edit_motivo" id="edit_motivo" value=""/>
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

 <!--Mostrando Modal REPORGRMACION PLAN PAGOS Edit-->
 <!-- Modal -->
 <div id="myModalEdit2" class="modal fade" role="dialog">
   <div class="modal-dialog">

     <!-- Modal content-->
     <div class="modal-content">
       <div class="modal-header">
         <button type="button" class="close" data-dismiss="modal">&times;</button>
         <h4 class="modal-title">
             <input type="hidden" name="id_plan_pago" id="id_plan_pago" value=""/>
             MODIFICAR PLAN PAGO [<span id="txt_plan_pago"> 0</span>]

         </h4>
       </div>
       <div class="modal-body">
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Monto Total:</b>
          </div>
          <div class="col-sm-8">
            <input type="text"  id="rep_monto_total" value="<?=$cuenta['deuda']-$cuenta['saldo']?>"/>
          </div>
         </div>
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Multa aplicada:</b>
          </div>
          <div class="col-sm-8">
            <input type="text"  id="rep_multa" value="0"/>
          </div>
         </div>
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Monto Inicial:</b>
          </div>
          <div class="col-sm-8">
            <input type="text"  id="rep_monto_inicial" value="0"/>
          </div>
         </div>
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Numero Cuotas:</b>
          </div>
          <div class="col-sm-8">
            <input type="number"  id="rep_nro_cuotas" onchange="calcularxnumero()" value="3"/>
          </div>
         </div>
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Tipo periodicidad:</b>
          </div>
          <div class="col-sm-8">
            <select class="form-control" id="rep_tipo_periodico" name="rep_tipo_periodico">
              <option value="1">Mensual</option>
              <option value="2">Semanal</option>
              <option value="3">Quincenal</option>
            </select>
          </div>
         </div>
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Monto Cuota:</b>
          </div>
          <div class="col-sm-8">
            <input type="text"  id="rep_monto_cuota" value="0"/>
          </div>
         </div>
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Fecha Inicio:</b>
          </div>
          <div class="col-sm-8">
            <input type="text"  id="rep_fecha_inicio" value="<?=date('Y-m-d')?>"/>
          </div>
         </div>
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Nota:</b>
          </div>
          <div class="col-sm-8">
            <input type="text"  id="rep_nota" value="Reprogramando"/>
          </div>
         </div>
         <div class="row form-group">
          <div class="col-sm-4">
          <b>Plan anterior:</b>
          </div>
          <div class="col-sm-8">
            <input type="text"  id="rep_plan_anterior" value="<?=$plan_pago['id']?>"/>
          </div>
         </div>


       </div>
       <div class="modal-footer">
         <button type="button" class="btn btn-default" data-dismiss="modal"
         onclick="reprogramarPlanPago(<?=$plan_pago['id']?>)">Guardar</button>
         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
       </div>
     </div>

   </div>
 </div>

<form method="post" id="reprogramacion_form" action="<?=base_url()?>administracion/admin_cuenta_plan_pagos">
  <input type="hidden" name="id_cliente" value="<?=$cuenta_cliente['id']?>"/>
  <input type="hidden" name="info" value="ok"/>
</form>
 <script>
 function generar_fichas_cuotas(){

   id_plan_pago=$('#id_plan').val();
   $.ajax({
     url: '<?=base_url()?>administracion/generar_fichas_cuota',
     dataType: 'text',
     type: 'post',
     //contentType: 'application/json',
     data: {'id_plan_pago': id_plan_pago},
     //processData: false,
     success: function( data ){
         //$('#response pre').html( JSON.stringify( data ) );
        //alert(data);
        $('#fichas_plan_pago').html(data);

     },
     error: function( jqXhr, textStatus, errorThrown ){
         //console.log( errorThrown );
         alert("falla");
     }
   });
 }
 function calcularxnumero(){
   nro_cuotas=parseInt($('#rep_nro_cuotas').val());
   monto_total=parseInt($('#rep_monto_total').val())+parseInt($('#rep_multa').val());
   $('#rep_monto_cuota').val((monto_total/nro_cuotas)>>0);



 }
 function editarCuota(numero,id_plan_pago){
   //anotacion=$('#nota_'+id).val();
   $('#txt_plan_pago').text(id_plan_pago);
   $('#txt_numero').text(numero);
   $('#id_numero').val(numero);
   $('#id_plan_pago').val(id_plan_pago);
   //---obteniendo datos de la cuota
   $.ajax({
     url: '<?=base_url()?>administracion/obtener_cuota',
     dataType: 'json',
     type: 'post',
     //contentType: 'application/json',
     data: {'numero':numero, 'id_plan_pago': id_plan_pago},
     //processData: false,
     success: function( data, textStatus, jQxhr ){
         //$('#response pre').html( JSON.stringify( data ) );
         if(data.result==false){
         alert("No se encontro la cuota  numero "+numero+"del plan"+id_plan_pago);
       }else{
         //---actualizando los datos
         $('#edit_monto_cuota').val(data['monto_cuota']);
         $('#edit_monto_pagado').val(data['monto_pagado']);
         $('#edit_estado').val(data['estado']);
         $('#edit_fecha_cobrar').val(data['fecha_pago']);
         $('#edit_fecha_pagada').val(data['fecha_pagada']);
         $('#edit_cobrador').val(data['id_cobrador']);
       }
     },
     error: function( jqXhr, textStatus, errorThrown ){
         //console.log( errorThrown );
         alert("falla");
     }
   });
    //---End

 }
 function cambiarDatosTabla(){
   //---actualizando datos de la cuota plan pago
   numero = $('#id_numero').val();
   id_plan_pago=$('#id_plan_pago').val();

   $.ajax({
     url: '<?=base_url()?>administracion/modificar_cuota',
     dataType: 'json',
     type: 'post',
     //contentType: 'application/json',
     data: {'numero':numero, 'id_plan_pago': id_plan_pago, 'monto_cuota':$('#edit_monto_cuota').val(),
   'monto_pagado':$('#edit_monto_pagado').val(),'estado':$('#edit_estado').val(),'fecha_pago':$('#edit_fecha_cobrar').val(),
   'fecha_pagada':$('#edit_fecha_pagada').val(),'id_cobrador':$('#edit_cobrador').val(),
   'motivo':$('#edit_motivo').val()},
     //processData: false,
     success: function( data, textStatus, jQxhr ){
         //$('#response pre').html( JSON.stringify( data ) );
         if(data.result==false){
         alert("No se encontro la cuota  numero "+numero+"del plan"+id_plan_pago);
       }else{
         //---actualizando los datos
        // alert(data['resultado']);
         /*
        v(data['monto_cuota']);
         $('#edit_monto_pagado').val(data['monto_pagado']);
         $('#edit_estado').val(data['estado']);
         $('#edit_edit_fecha_cobrar').val(data['fecha_pago']);
         $('#edit_fecha_pagada').val(data['fecha_pagada']);
         $('#edit_cobrador').val(data['id_cobrador']);*/
        // $('#ficha_'+numero).text(JSON.stringify( data ) );
        generar_fichas_cuotas();
       }
     },
     error: function( jqXhr, textStatus, errorThrown ){
         //console.log( errorThrown );
         alert("falla");
     }
   });
    //---End


 }
function habilitarreprogramacion(){
 //$('#btn_reprogramar').removeAttr('disabled');
 document.getElementById('btn_reprogramar').disabled = false;
}
function reprogramarPlanPago(id_plan_pago){
  $.ajax({
    url: '<?=base_url()?>administracion/reprogramar_plan_pago',
    dataType: 'json',
    type: 'post',
    //contentType: 'application/json',
    data: {'id_plan_pago': id_plan_pago,'id_cliente':<?=$cuenta_cliente['id']?>,'monto_total':$('#rep_monto_total').val(),
    'monto_inicial':$('#rep_monto_inicial').val(),'nro_cuotas':$('#rep_nro_cuotas').val(),'tipo_periodico':$('#rep_tipo_periodico').val(),
    'multa':$('#rep_multa').val(),'monto_cuotas':$('#rep_monto_cuota').val(),
    'fecha_inicio':$('#rep_fecha_inicio').val(),'nota':$('#rep_nota').val()},
    //processData: false,
    success: function( data, textStatus, jQxhr ){
        //$('#response pre').html( JSON.stringify( data ) );
        if(data.result==false){
        alert("No se pudo realizar la reprogramacion");
      }else{
        //alert(data);
        //---actualizando los datos
          if(data['resultado']==true){
           $('#reprogramacion_form').submit();
        //   alert(data['data']);
         }
          else {
            alert("No se pudo reprogramar");
          }

      }
    },
    error: function( jqXhr, textStatus, errorThrown ){
        //console.log( errorThrown );
        alert("falla"+ jqXhr+textStatus+errorThrown );
    }
  });
   //---End
}


 </script>
