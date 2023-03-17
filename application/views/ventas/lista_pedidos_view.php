
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
            	if (isset($title_crud))
            	echo " ".$title_crud;

            ?>
            <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?></small>
          </h2>
        </div>
        <!-- /.col -->
      </div>
      <!-- info row -->
      <form class="form-horizontal"  id="ventas_formpedidos" method="post" action="<?=base_url()?>ventas/pedidos_cliente">
             <div class="row">
               <div class="col-sm-2">
               </div>
               <div class="col-sm-5">
               <div class="form-group">
                 <div class="input-group">
                   <div class="input-group-addon">
                     <span class="glyphicon glyphicon-user">Cliente</span>
                   </div>
                    <select id="clientename"  name="clientename"  class="clientename form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">

                   </select>
                 </div>
               </div>
               </div>
               <div class="col-sm-2">
                 <button type="submit" name="butt_pedidos" value="ok"class="btn  btn-primary ">Gestionar Pedidos</button>
               </div>
               <div class="col-sm-2">
                 <a class="btn btn-app" data-toggle="modal"  data-target="#modalcliente">
                <i class="fa fa-user-plus"></i> Cliente
              </a>
               </div>
             </div>
             <!-- /.box-footer -->
           </form>
           <form id="ventas_formgestionpedidos" method="post" action="<?=base_url()?>ventas/pedidos_cliente">
             <input type="hidden" name="id_cliente" id="id_cliente" value="0"/>
             <input type="hidden" name="butt_gestionar" value="ok"/>

           </form>

      <div class="row invoice-info">
        <?php
        if(count($arr_pedidos)>0){
        ?>
       <div class="col-sm-12 invoice-col">
         <div class="box-body table-responsive ">
              <table class="table table-hover">
                <tbody><tr>
                  <th>ID</th>
                  <th>Inicio</th>
                  <th>Restantes</th>
                  <th>Status</th>
                  <th>Cliente</th>
                  <th>Items</th>
                  <th>Total</th>
                  <th>Accion</th>
                </tr>
                <?php
                foreach ($arr_pedidos as $value) {
                   $dStart = new DateTime($value['fecha_inicio']);
                   $dEnd  = new DateTime($value['fecha_entrega']);
                   $dDiff = $dStart->diff($dEnd);

                  echo'<tr>';
                    echo'<td>'.$value['id'].'</td>';
                    echo'<td>'.$value['fecha_inicio'].'</td>';
                    echo'<td>'. $dDiff->days.' dias</td>';
                    if($dDiff->days>15)
                    echo'<td><span class="btn-block badge label-success">Aprobado</span></td>';
                    else if($dDiff->days>7)
                    echo'<td><span class="btn-block badge label-primary">Pendiente</span></td>';
                    else if($dDiff->days>3)
                    echo'<td><span class="btn-block badge label-warning">Riesgo</span></td>';
                    else
                    echo'<td><span class="btn-block badge bg-red">Mora</span></td>';

                    echo'<td>'.$value['nombre_cliente'].'</td>';
                    echo'<td>'.$value['cantidad'].'</td>';
                    echo'<td>'.$value['total'].'</td>';
                    echo'<td><button type="button" onclick="gestionar_pedido('.$value['id_cliente'].')" class="btn btn-block btn-info btn-sm">Gestionar</button></td>';
                  echo'</tr>';
                }


                 ?>
              </tbody></table>
            </div>

       </div>
       <?php
     }else{
       ?>
       <div class="error-content text-center">
          <h4><i class="fa fa-warning text-yellow"></i> Oops! No existe pedidos pendientes.</h4>



        </div>

       <?php

     }
       ?>

    </div>

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>


    <!--Mostrando Modal CLientes Nuevos Edit-->
    <!-- Modal -->
    <div id="modalcliente" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Gestionar Cliente</h4>
          </div>

          <div class="modal-body">
            <p>Ingrese los datos del nuevo cliente, <span class="text-red">(*)</span> campos obligatorios</p>
              <div class="row">
              <div class="col-sm-7 form-group">
                <label  class=""> Nombre <span class="text-red">(*)</span></label>
                <input type="text" class="form-control" id="edit_nombre" placeholder="Ingrese nombre del cliente"/>
              </div>
              <div class="col-sm-5 form-group">
                <label  class="">Sexo <span class="text-red">(*)</span></label>
                <div class="input-group radio-inline">
    <label class="radio-inline"><input type="radio"  value="H" name="editsexocliente"><span class="fa fa-male"> </label>
    <label class="radio-inline"><input type="radio" checked  value="M" id="editsexocliente" name="editsexocliente"><span class="fa fa-female"> </label>
                </div>
              </div>
              <div class="col-sm-7 form-group">
                <label  class="">Direccion</label>
                <input type="text" class="form-control" id="edit_direccion" placeholder="direccion del cliente" value=""/>
              </div>
              <div class="col-sm-5 form-group">
                <label  class="">Ci</label>
                <input type="text" class="form-control" id="edit_ci" placeholder="Cedula Identidad" value=""/>
              </div>
              <div class="col-sm-7 form-group">
                <label  class="">Facebook</label>
                <input type="text" class="form-control" id="edit_facebook" placeholder="Facebook" value=""/>
              </div>
              <div class="col-sm-5 form-group">
                <label  class="">Telefono</label>
                <input type="text" class="form-control" id="edit_telefono" placeholder="ingrese telefono" value=""/>
              </div>
              <div class="col-sm-7 form-group">
                <label  class="">Email</label>
                <input type="text" class="form-control" id="edit_email" placeholder="Email"/>
              </div>
              <div class="col-sm-5 form-group">
                <label  class="">Referencia</label>
                <input type="text" class="form-control" id="edit_referencia" placeholder="referencias" value=""/>
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal" onclick="editar_cliente_gestionado_modal()">Guardar</button>
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>

      </div>
    </div>
<script>


/////////////////MODAL CLIENTE///////////////
function editar_cliente_gestionado_modal(){
  var edit_nombre =$("#edit_nombre").val();
  var edit_sexo ="Hombre";
  if(document.getElementById("editsexocliente").checked)
  edit_sexo="Mujer";

  var edit_direccion =$("#edit_direccion").val();
  var edit_ci =$("#edit_ci").val();
  var edit_facebook =$("#edit_facebook").val();
  var edit_telefono =$("#edit_telefono").val();
  var edit_email =$("#edit_email").val();
  var edit_referencia =$("#edit_referencia").val();

    $.ajax({
      url: '<?=base_url()?>clientes/gestionar_cliente',
      dataType: 'json',
      type: 'post',
      //contentType: 'application/json',
      data: {'nombre':edit_nombre, 'sexo': edit_sexo,'direccion':edit_direccion,'ci':edit_ci,
           'facebook':edit_facebook,'email':edit_email,'referencia':edit_referencia},
      //processData: false,
      success: function( data, textStatus, jQxhr ){
          //$('#response pre').html( JSON.stringify( data ) );

          if(data.result==false){
          alert("El ci cliente ya fue registrado anteriormente");
        }
          var newOption = new Option(data.nombres,data.id_cliente, false, false);
          $('#clientename').append(newOption).trigger('change');
      },
      error: function( jqXhr, textStatus, errorThrown ){
          //console.log( errorThrown );
          alert("falla");
      }
  });

}
///////////////////////////////////////////////////////////
//--------------------------------------------------------
//--------------FORM--------------------------------------

function gestionar_pedido(id_cliente){

      document.getElementById('id_cliente').value=id_cliente;
      //document.getElementById('array_notas').value+concat+notas;
      //document.getElementById('array_fechas').value=
      //document.getElementById('array_fechas').value+concat+fechas;
      //document.getElementById('array_grupos').value=
      //document.getElementById('array_grupos').value+concat+grupo;
      $('#ventas_formgestionpedidos').submit();

   }
</script>
