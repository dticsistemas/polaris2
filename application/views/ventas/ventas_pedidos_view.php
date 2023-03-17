


<?php
    $attributtes=' id="ventas_formvc" ';
    echo form_open('ventas/ventas_credito',$attributtes);
?>


<input type="hidden" name="id_cliente" id="id_cliente" value="<?=$cuenta_cliente['id']?>"/>
<input type="hidden" name="array_id_productos" id="array_id_productos" />
<input type="hidden" name="array_precio_productos" id="array_precio_productos" />
<input type="hidden" name="total_actual" id="total_actual" />
<input type="hidden" name="deuda_cliente" value="<?=$cuenta_cliente['cuenta_cliente']['deuda']?>" />
<input type="hidden" name="saldo_cliente" value="<?=$cuenta_cliente['cuenta_cliente']['saldo']?>" />
<input type="hidden" name="array_cantidad_productos" id="array_cantidad_productos" />
<input type="hidden" name="id_venta_anterior" id="id_venta_anterior" value="<?=$id_venta_anterior?>" />
<!--<input type="hidden" name="array_id_clientes" id="array_id_clientes"/>-->
<input type="hidden" name="array_vendedores" id="array_vendedores"/>
<input type="hidden" name="array_sucursales" id="array_sucursales"/>
<input type="hidden" name="array_notas" id="array_notas"/>
<input type="hidden" name="array_fechas" id="array_fechas"/>
<input type="hidden" name="array_fechas_entregas" id="array_fechas_entregas"/>
<input type="hidden" name="array_descontar_stock" id="array_descontar_stock"/>
<input type="hidden" name="array_grupos" id="array_grupos"/>
<input type="hidden" name="array_estados" id="array_estados"/>
<input type="hidden" name="fecha_venta" id="fecha_venta"/>
<input type="hidden" name="id_sucursal" id="id_sucursal"/>
<input type="hidden" name="id_vendedor" id="id_vendedor"/>
<input type="hidden" name="tipo_pago" id="tipo_pago" value="1"/>
<input type="hidden" name="db_monto_restante" id="db_monto_restante" value="0"/>
<input type="hidden" name="db_monto_inicial" id="db_monto_inicial" value="1"/>
<input type="hidden" name="db_nro_cuotas" id="db_nro_cuotas" value="1"/>
<input type="hidden" name="db_tipo_periodico" id="db_tipo_periodico" value="1"/>
<input type="hidden" name="db_monto_cuotas" id="db_monto_cuotas" value="1"/>
<input type="hidden" name="db_fecha_inicio" id="db_fecha_inicio" value="1"/>
<input type="hidden" name="array_fechas_entregados" id="array_fechas_entregados"/>
<input type="hidden" id="butt_vc_procesar"  name="butt_ventas_procesar"  value="ok" />

<?php echo form_close(); ?>
<div class="panel panel-primary">
<div class="panel-heading">
    <h2 class="panel-title text-center">REGISTRANDO VENTA/PEDIDO DE PRODUCTOS</h2>
</div>
<div class="panel-body">
<div>
    <p>Introduzca y verifique los datos antes de guardarlos</p>


    <?php
  if(isset($success)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-success alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-check"></i> <?=$success?>
                
              </div>
    </div>
  <?php
 }
 if(isset($error)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-danger alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-warning "></i><?=$error?>
              </div>
    </div>
  <?php
 }
  if(isset($warning)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-warning alert-dismissible" style="margin-bottom: 0!important;">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <i class="icon fa fa-warning "></i><?=$warning?>
              </div>
    </div>
  <?php
 }
  if(isset($info)){
  ?>

<div class="pad margin no-print">
<div class="alert alert-info alert-dismissible" style="margin-bottom: 0!important;">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <i class="icon fa fa-info"></i><?=$info?>
</div>
</div>
  <?php
 }
 ?>




</div>
<div class="row">
<div class="col-sm-10">

  <div class="row">
    <div class='col-sm-1'>
      <label>Cliente:</label>
    </div>
  <div class='col-sm-4'>
      <div class="input-group">
        <div class="input-group-addon">
          <i class="fa fa-user"></i>
        </div>
        <input type="text" class="form-control pull-right" disabled value="<?=$cuenta_cliente['nombres']?>">
        <div class="input-group-btn">
          <button onclick="datosCliente()" class="btn btn-info" type="button" id="butt_datos_cliente" >
              <span class="fa fa-info"></button>
        </div>
      </div>
    </div>
   <div class="col-sm-1 form-group">
       <label >Deuda:</label>
  </div>
  <div class="col-sm-2 form-group">
       <input class="form-control" disabled type="text" id="deuda_anterior" name="deuda_anterior" value="<?=$cuenta_cliente['cuenta_cliente']['deuda']?>" >
   </div>
   <div class="col-sm-1 form-group">
     <label for="select_producto">Saldo:</label>
  </div>
  <div class="col-sm-1 form-group">
     <input class="form-control" type="text" id="saldo" disabled name="saldo" value="<?=$cuenta_cliente['cuenta_cliente']['saldo']?>" >
   </div>
   <div class="col-sm-1 form-group">
     <label >Estado:</label>
  </div>
  <div class="col-sm-1 form-group">
    <input class="form-control"  id="estado" disabled name="estado" value="<?=$cuenta_cliente['cuenta_cliente']['estado']?>" >
   </div>

  </div> <!--End subrow-->

<div class="row">
  <div class="col-sm-3">
      <div class="form-group">
                <label>Fecha de Venta:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
      </div>
  </div>
  <div class="col-sm-3">
      <div class="form-group">
                <label>Fecha de Entrega:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker2">
                </div>
                <!-- /.input group -->
      </div>
  </div>
  <div class='col-sm-3'>
      <div class="form-group">
         <label for="password">Vendedor</label>
         <div class='input-group date' >
            <?php
              echo form_dropdown('select_vendedor', $combox_vendedores,$id_persona,'id="select_vendedor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" ' );
             ?>
          </div>
      </div>
  </div>
  <div class='col-sm-3'>
      <div class="form-group">
         <label for="password">Sucursal</label>
         <div class='input-group date' >
            <?php
              echo form_dropdown('select_sucursal', $combox_sucursales,'0','class="form-control select2" id="select_sucursal" ' );
             ?>
          </div>
      </div>
  </div>

</div>

<div class="row">
 <div class="col-sm-2 form-group">
     <label >Cantidad:</label>
     <input class="form-control" type="number" id="cantidad" name="cantidad" value="1" min="1" max="99" required="required" maxlength="5" onchange="calculo_monto_cantidad(this.value)" >

 </div>
 <div class="col-sm-3 form-group">
   <label for="select_producto">Producto:</label>
        <?php
   echo form_dropdown('select_producto', $combox_productos,'0','class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="select_producto" onchange="obtenerInfoProducto(this.value)" ');
        ?>
 </div>
 <div class="col-sm-2 form-group">
   <label id="precio_label">Precio</label>
   <input type="hidden" id="precio" value="0" name="precio"></label>
  <input class="form-control"  id="precio_convenido" name="precio_convenido" required="required" maxlength="15">

 </div>

  <div class="col-sm-4 form-group">
    <label >Nota</label>
   <input class="form-control"  id="nota" name="nota" required="required" maxlength="45">

  </div>
  <div class="col-sm-1 form-group">
    <label id="label_grupo" class="btn bg-aqua-active" data-toggle= "tooltip" data-placement= "top" title= "Entregado" ><span class="fa  fa-object-group"></label>
    <input type="checkbox"  checked id="grupo">

  </div>


</div> <!--End subrow-->

</div>
<div class="col-sm-2 form-group">
  <div class="row">
    <img name="img-prod-thumb" id="img-prod-thumb" class="img-responsive thumbnail" src="<?php echo base_url();?>/assets/img/catalogo/thumbs/no_image.png"/>
    <div id="info_producto"></div>
  </div>
  <div class="row">
  <div class=" form-group">
      <label></label>
      <button class="btn btn-primary" type="button" id="butt_agregar" onclick="agregarproducto()">Agregar Producto</button>

    </div>
  </div>
</div>
</div> <!---End row-->

    <!-----------Tabla de Productos---------------------->


          <div class="box">
          <div class="box-header">
              <h3 class="box-title">Productos a llevar</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <div class="row table-responsive">
          <table id="tabla" class="table table-hover">
          <thead>
            <tr>
              <th><span class="glyphicon glyphicon-th-list"></span></th>
              <th style="width:50px">Cant.</th>
              <th style="min-width: 250px">Producto</th>
              <th>Fecha</th>
              <th>Entregar</th>
              <th>Entregado</th>
              <th>Estado</th>
              <th>Monto</th>
              <th>Notas</th>
              <th>Accion</th>
            </tr>
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
  ?>
  <tr>
<td class="<?=$arr_color[$indice]?>"><input type="hidden" value="<?=$pedido['id_producto']?>"
  /><input type="hidden" value="<?=$i+1?>"/><input type="hidden" value="vendedor"
  /><input type="hidden" value="sucursal"/><input type="hidden" value="cliente"
  /><input type="hidden" value="<?=$pedido['orden']?>"
  /><input type="hidden" value="<?=$pedido['id']?>"/><input type="hidden" value="<?=$pedido['descontar_stock']?>"/><?=$pedido['id']?>
</td>
    <td><?=$pedido['cantidad']?></td>
    <td><img  align="left" class="img-responsive" width="50px" src="<?php echo base_url()?>assets/img/catalogo/thumbs/<?=$pedido['img_producto']?>">
      <span class="text-light-blue"><?=$pedido['codigo']?> </span>&nbsp;&nbsp;<?=$pedido['nombre_producto']?>
    </td>
    <td><?=$pedido['fecha_inicio']?></td>
    <td><?=$pedido['fecha_entrega']?></td>
    <td><?php
    if($pedido['fecha_entregado']=='0000-00-00')
    echo "";
    else
    echo $pedido['fecha_entregado'];

    ?></td>
    <td><?=$pedido['estado']?></td>
    <td><?=$pedido['total']?></td>
    <td><?=$pedido['anotacion']?></td>
    <td>
      <button type="button" disabled data-toggle="modal" onclick="editarProducto(<?=$i+1?>)" data-target="#myModalEdit" class="btn btn-primary btn-xs"> <span class="btn-xs glyphicon glyphicon-edit"></span>
      </button>
      <button type="button" disabled class="btn btn-google btn-xs"> <span class="btn-xs glyphicon glyphicon-ban-circle"></span>
      </button>'
    </td>
  </tr>
  <?php
  $i++;
}
            ?>
          </thead>
          <tbody>
          </tbody>
          </table>
          </div>
                 <div class="form-group row">
                      <label for="monto_ventas" class="col-sm-8 control-label text-right">Total Actual</label>
                      <div class="col-sm-4">
                            <input type="text" class="form-control" readonly="" id="monto_ventas" name="monto_ventas" value="0"/>
                      </div>
                  </div>

                    <!-- /.montos globales de la venta-->
            </div><!-- /.box-body -->
      </div><!-- /.box -->
<!-----------------End Tabla Productos-------------------->


<div class="row">
  <div class="col-sm-4">
  <h3>Forma de Pago</h3>
</div>
  <div class="col-sm-4">
    <div class="form-group">
      <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionscontado" checked value="option1" onclick="forma_pago(1)">
            Al Contado
          </label>
        </div>
        <div class="radio">
            <label>
              <input type="radio" name="optionsRadios" id="optionscreditoalterno"  value="option3" onclick="forma_pago(3)">
              A Credito Nuevo Plan Pago
            </label>
          </div>

      </div>
  </div>
  <div class="col-sm-4">
    <div class="form-group">
        <?php
            if($cuenta_cliente['cuenta_cliente']['deuda']>0){
         ?>
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionscredito" value="option2" onclick="forma_pago(2)">
            Al Credito Fusionar Deudas
          </label>
        </div>
        <?php
            }

         ?>
        <div class="radio">
          <label>
            <input type="radio" name="optionsRadios" id="optionsalfinalizar" value="option4" onclick="forma_pago(4)">
            Al Finalizar Entrega
          </label>
        </div>
      </div>
  </div>
</div>
<div class="panel panel-primary" id="panel_pago_finalizar" style="display:none">
  <div class="box">
  <div class="box-header with-border">
    <h4 class="box-title">
      <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
        Al finalizar y entregar los produtos del pedido
      </a>
    </h4>
  </div>
  </div>
  <div class="row">
        <div class="row">
          <div class="col-sm-2">
          </div>
          <div class="form-group col-sm-8">
            <label for="edit_fecha_inicio" class="col-sm-4 control-label">Monto Adelanto</label>
            <div class="col-sm-8">
              <input type="number" class="form-control" id="edit_monto_adelanto" value="0">
            </div>
          </div>
        </div>
  </div>
</div>
<div class="panel panel-primary" id="panel_pago" style="display:none">
<!------------------------------------------------------------------------->


<div class="box">
<div class="box-header with-border">
  <h4 class="box-title">
    <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree">
      Plan de Pago
    </a>
  </h4>
</div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="deuda_anterior">Deudas</label>
            <div class="input-group">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <input class="form-control" id="deuda_anterior_plan" readonly type="text" placeholder="deuda_anterior" name="deuda_anterior" value="<?=$cuenta_cliente['cuenta_cliente']['deuda']?>">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
             <label for="saldo">Saldo:</label>
             <div class="input-group">
               <div class="input-group-addon">
                 <span class="glyphicon glyphicon-user"></span>
               </div>
               <input class="form-control" disabled id="saldo" type="text" placeholder="Saldo a favor" name="saldo" value="<?=$cuenta_cliente['cuenta_cliente']['saldo']?>">
             </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
             <label for="ventas">Total Ventas:</label>
             <div class="input-group">
               <div id="div_total"></div>
             </div>
        </div>
    </div>

</div> <!---End row-->
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="monto_inicial">Cuota Inicial:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <input class="form-control" type="number" id="monto_inicial" type="text" placeholder="Monto Inicial" name="monto_inicial" value="0" onchange="calcular_restante()">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
             <label for="cuota_restante">Total Restante:</label>
             <div class="input-group">
               <div class="input-group-addon">
                 <span class="glyphicon glyphicon-user"></span>
               </div>
               <input class="form-control" readonly id="cuota_restante" type="text" placeholder="Cuota restante" name="cuota_restante" value="0">
             </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
             <label for="datepicker2">Fecha inicio:</label>
             <div class="input-group">
               <input class="form-control" id="datepicker3" type="text" placeholder="Inicio Cobranza" name="datepicker3" value="">
               <div class="input-group-addon">
                 <span class="glyphicon glyphicon-calendar"></span>
               </div>
             </div>
        </div>
    </div>

</div> <!---End row-->
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="nro_cuotas">Nro Cuotas:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <input class="form-control" id="nro_cuotas" type="text" placeholder="Nombre de Usuario" name="nro_cuotas" value="">
            </div>
        </div>
    </div>
    <div class="col-sm-4">
      <div class="form-group">
       <label for="select_periodico">Select list:</label>
       <select class="form-control" id="select_periodico" name="select_periodico">
         <option value="1">Mensual</option>
         <option value="2">Semanal</option>
         <option value="3">Quincenal</option>
       </select>
      </div>
    </div>
    <div class="col-sm-4">
        <div class="form-group">
             <label for="monto_cuota">Monto Cuota:</label>
             <div class="input-group">
               <div class="input-group-addon">
                 <span class="glyphicon glyphicon-user"></span>
               </div>
               <input class="form-control" id="monto_cuota" type="text" placeholder="Monto cuota" name="monto_cuota" value="">
             </div>
        </div>
    </div>

</div> <!---End row-->
<div class="box">
<div class="box-header with-border">

    <div id="cuotas_grafica">Cuotas</div>


</div>
</div>
<div class="row">
  <div class="col-sm-6">
    <button class="btn btn-primary" type="button" onclick="graficar_cuotas(0)" >Calcular Cuotas por Numero</button>

  </div>
  <div class="col-sm-6">
    <button class="btn btn-primary" type="button" onclick="graficar_cuotas(1)" >Calcular Cuotas por Monto</button>

  </div>
</div><!--End row-->
<div class="row">


</div> <!---End row-->
<div class="row">
  <div class="col-sm-2">
  </div>
  <div class="col-sm-8">
<div id="agenda_data">
    <table class="table " >

      <tr>
        <th>Direccion</th><td><?=$agenda['direccion_cobranza']?></td>
        <th>Zona</th><td><?=$agenda['zona']?></td>
      </tr>
      <tr>
        <th>Telefono</th><td><?=$agenda['telefono_cobranza']?></td>
        <th>Hora</th><td><?=$agenda['hora_estimada']?></td>
      </tr>
      <tr>
        <th>Garante 1</th><td><?=$agenda['garante_1']?></td>
        <th>CI:</th><td><?=$agenda['ci_1']?></td>
      </tr>
      <tr>
        <th>Direccion 1</th><td><?=$agenda['direccion_1']?></td>
        <th>Telefono 1:</th><td><?=$agenda['telefono_1']?></td>
      </tr>
      <tr>
        <th>Garante 2</th><td><?=$agenda['garante_2']?></td>
        <th>CI:</th><td><?=$agenda['ci_2']?></td>
      </tr>
      <tr>
        <th>Direccion 2</th><td><?=$agenda['direccion_2']?></td>
        <th>Telefono 2:</th><td><?=$agenda['telefono_2']?></td>
      </tr>
    </table>
</div>
    <div>

</div> <!---End row-->
<div class="row">
    <button type="button" data-toggle="modal"  data-target="#myModalEdit2" > Modificar Agenda de Cobranzas</button>
</div> <!---End row-->
</div> <!--End panel body-->

<!--..........................................................----->
</div>

</div> <!--End panel body-->

    <div class="panel-footer text-center">
        <button class="btn btn-success" type="button" name="butt_ventas_pedidos" value="ok" onclick="validacion_formvc()" >Guardar Ventas de productos</button>
        <a href="<?php echo base_url()."ventas/ventas_suspendidas";?>" class="btn btn-default" role="button">Cancelar</a>
    </div>


</div>


<!--Mostrando Modal Productos Edit-->
<!-- Modal -->
<div id="myModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modificar Precio Convenido</h4>
      </div>
      <input type="hidden" id="edit_fila" value="0"/>
      <input type="hidden" id="img_src" value="0"/>
      <div class="modal-body box box-info">

            <!-- /.box-header -->
              <div class="form-horizontal box-body">
                <div class="row">
                  <div class="col-sm-3"></div>
                  <label class="col-sm-6 text-center" id="edit_producto" ></label>
                  <div class="col-sm-3"></div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Fecha Inicio</label>
                  <div class="col-sm-8">
                    <input type="text" disabled class="form-control" id="edit_fecha_inicio" >
                  </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Fecha Entrega</label>
                  <div class="col-sm-8">
                    <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker4">
                  </div>
                </div>
                </div>
                <div class="form-group">
                  <label for="fecha_entregado" class="col-sm-4 control-label">Fecha Entregado</label>
                  <div class="col-sm-8">
                    <div class="input-group">
                    <div class="input-group-addon">
                      <i class="fa fa-calendar"></i>
                    </div>
                    <input type="text" class="form-control pull-right" id="datepicker3">
                  </div>
                </div>
                </div>
                <div class="form-group">
                  <label class="col-sm-4 control-label">Cantidad</label>
                  <div class="col-sm-8">
                    <input type="number" class="form-control" id="edit_cantidad" >
                  </div>
                </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Monto</label>
                    <div class="col-sm-8">
                      <input type="text" class="form-control" id="edit_precio_convenido" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Anotacion</label>
                    <div class="col-sm-8">
                      <input type="text"  class="form-control" id="edit_anotacion" >
                    </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-4 control-label">Estado</label>
                    <div class="col-sm-8">
                      <select class="form-control" id="edit_estado">
                        <option selected value="Pendiente">Pendiente</option>
                        <option value="Entregado">Entregado</option>

                      </select>
                   </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-8 control-label">Descontar de inventario de la sucursal:</label>
                    <div class="col-sm-4">
                      <input type="checkbox" id="edit_remover_stock" >
                    </div>
                  </div>



              </div>

              <!-- /.box-footer -->


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cambiarDatosTabla()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<?php
    $attributtes=' id="ventas_formpagos" ';
    echo form_open('ventas/pedidos_cliente',$attributtes);
?>
<div class="box box-info">
<div class="box-header with-border">
  <h3 class="box-title">Realizando Pago de Pedidos (Deuda Total:<?=$cuenta_cliente['cuenta_cliente']['deuda']?>)</h3>
  <small>El monto de deuda no incluye los pedidos no guardados</small>
</div>
<div class="box-body">

    <div class="row">

      <input type="hidden" name="id_cliente" value="<?=$cuenta_cliente['id']?>"/>
      <input type="hidden" name="butt_pedidos_pago" value="ok"/>
      <input type="hidden" name="opt_pago" id="opt_pago"  value="0"/>
      <div class="col-sm-3">
        <label>Fecha de Pago</label>
        <div class="input-group date">
          <div class="input-group-addon">
            <i class="fa fa-calendar"></i>
          </div>
          <input type="text" name="fecha" class="form-control pull-right" id="datepicker5">
        </div>
        <!-- /input-group -->
      </div>
      <div class="col-sm-3">
        <label>Cobrador</label>
        <div class="input-group">
          <?php
            echo form_dropdown('select_cobrador', $combox_vendedores,$id_persona,'name="id_cobrador" id="select_cobrador" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" ' );
           ?>
        </div>
        <!-- /input-group -->
      </div>
      <div class="col-sm-3">
        <label>Monto a pagar</label>
        <div class="input-group">
          <input type="text" class="form-control" name="monto" id="monto_pagar" value="0">
        </div>
        <!-- /input-group -->
      </div>

      <div class="col-sm-3">
        <label>Confirmar Deposito</label>
        <div class="input-group">
              <span class="input-group-addon">
                <input type="checkbox"  checked>
              </span>
          <input type="text" class="form-control" id="monto_confirmar">
        </div>
        <!-- /input-group -->
      </div>
      <!-- /.col-lg-6 -->
    </div>

  </div>
<!-- /.box-body -->
<div class="box-footer text-center">
  <button class="btn btn-primary" type="button" onclick="validacion_formpagos(1)" >Guardar Pagos de Productos</button>
  <button class="btn btn-danger" type="button" onclick="validacion_formpagos(2)" >Finalizar Pedido Completado</button>
  <button class="btn btn-warning" type="button" onclick="ver_historial_pagos()" >ver Historial Pagos Pedidos</button>

</div>
</div>
<?php
    echo form_close();
?>


<!--Mostrando Modal Agenda Cobranzas Edit-->
<!-- Modal -->
<div id="myModalEdit2" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modificar agenda de cliente</h4>
      </div>
      <div class="modal-body box box-info">

            <!-- /.box-header -->
              <div class="form-horizontal box-body">
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Direccion Cobranza</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_direccion_cobranza" value="<?=$agenda['direccion_cobranza']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Zona Cobranza</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_zona_cobranza" value="<?=$agenda['zona']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Telf. Cobranza</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_telefono_cobranza" value="<?=$agenda['telefono_cobranza']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Hora estimada</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_hora_estimada" value="<?=$agenda['hora_estimada']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Garante 1</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_garante_1" value="<?=$agenda['garante_1']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Ci:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_ci_1" value="<?=$agenda['ci_1']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Direccion_1</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_direccion_1" value="<?=$agenda['direccion_1']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Telefono_1</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_telefono_1" value="<?=$agenda['telefono_1']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Garante 2</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_garante_2" value="<?=$agenda['garante_2']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Ci:</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_ci_2" value="<?=$agenda['ci_2']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Direccion_2</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_direccion_2" value="<?=$agenda['direccion_2']?>">
                  </div>
                </div>
                <div class="form-group">
                  <label for="edit_fecha_inicio" class="col-sm-4 control-label">Telefono_2</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_telefono_2" value="<?=$agenda['telefono_2']?>">
                  </div>
                </div>




              </div>

              <!-- /.box-footer -->


      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cambiarDatosAgendaTabla()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<script type="text/javascript">
//---variables NECESARIAS
id_elementos=0;//--identificador de filas
nro_productos=0;//--cantidad_productos
cant_pedidos=<?=$cantidad_pedidos?>;
id_elementos=cant_pedidos;
var id_color=0;
var id_grupo= Math.floor(Math.random() * 1000)+1;;
var table_color=['bg-aqua-active','bg-yellow-active','bg-red','bg-yellow','bg-aqua','bg-blue','bg-light-blue','bg-green',
'bg-navy','bg-teal','bg-olive','bg-lime','bg-orange','bg-fuchsia','bg-purple','bg-maroon',
'bg-black','bg-red-active','bg-blue-active','bg-light-blue-active',
'bg-green-active','bg-navy-active','bg-teal-active'];
//---FUNCIONES NECESARIAS

function limpiarDatosCliente(){
  document.getElementById("cicliente").value='';
  document.getElementById("clientename").value='';
  document.getElementById("id_cliente").value='';

  $("#clientename").empty().trigger("change");
  var newOption = new Option("NN",0, false, false);
  $('#clientename').append(newOption).trigger('change');
}
function buscarDatosCliente(){



 var ci=document.getElementById("cicliente").value;
 if(ci!=''){
   $.get( "<?php echo base_url('clientes/obtener_info_cicliente');?>",{ci:ci}, function( data) {

    var res=JSON.parse(data);
    var nombres=res['nombres'];
    var id_cliente=res['id'];
    if(id_cliente!=0){
      alert('Se ha encontrado al cliente');
      document.getElementById("clientename").value=nombres;
      document.getElementById("id_cliente").value=id_cliente;
      var newOption = new Option(nombres,id_cliente, false, false);
      $('#clientename').append(newOption).trigger('change');

    }
    else {
      alert('No encontrado');
    }

    })
    .fail(function() {
      alert( "No se pudo buscar al cliente" );
    });
}else{
  alert('Ingrese la Cedula de Identidad');
  }


}

function obtenerInfoProducto(valor){

    if(valor!=''){
    $.get( "<?php echo base_url('productos/obtener_info_producto');?>",
      {id_producto:valor},
      function( data ) {
       //---respuesta
        var res=JSON.parse(data);
        var precio=res['precio'];
        var path_image="<?php echo base_url()?>assets/img/catalogo/small/"+res['imagen'];
        document.getElementById('img-prod-thumb').src=path_image;
        document.getElementById('precio_label').innerHTML='Precio('+precio+')';
        document.getElementById('precio').value=precio;
        var cantidad=document.getElementById('cantidad').value;
        document.getElementById('precio_convenido').value=cantidad*precio;
        document.getElementById('img_src').value="<?php echo base_url()?>assets/img/catalogo/thumbs/"+res['imagen'];
        document.getElementById('info_producto').innerHTML='<div class="row">'+
                        '<div class="col-sm-6 text-right"><b>'+res['unidad_mayor']+'</b>:</div>'+
                        '<div class="col-sm-6">'+res['precio_mayor']+'</div>'+
                      '</div>';

    });
    }else{
      //alert('Es vacio');
       document.getElementById('img-prod-thumb').src="<?php echo base_url()?>assets/img/catalogo/thumbs/8c327-no-disponible.png";
        document.getElementById('precio').value="0";
        document.getElementById('precio_convenido').value="0";
        document.getElementById('info_producto').innerHTML='';
    }

};

function agregarproducto(){

  var options=document.getElementById('select_producto').length;
  if(options>0){

    id_elementos++;
    nro_productos++;
    var select_productos=document.getElementById('select_producto');
    var select_vendedor=document.getElementById("select_vendedor");
    var select_sucursal=document.getElementById("select_sucursal");
    var tr, td, tabla;
    var precio=document.getElementById('precio').value;
    var precio_convenido=document.getElementById('precio_convenido').value;
    var cantidad=document.getElementById('cantidad').value;
    var id_producto=select_producto.value;
    var img_thumbs=document.getElementById('img_src').value;
    var id_cliente=document.getElementById('id_cliente').value;

    var vendedor=select_vendedor.value;
    var sucursal =select_sucursal.value;
    tabla = document.getElementById('tabla');
    tr = tabla.insertRow(tabla.rows.length);
    /*//---modificando estulo de la fila
    if (id_grupo!=0){
      tr.setAttribute("class", table_color[id_color]);
    }else*/
    tr.setAttribute("class", "info");
    /**/

    td = tr.insertCell(tr.cells.length);
    //---modificando estilo de la fila
    if (id_grupo!=0){
      td.setAttribute("class", table_color[id_color]);
    }else
    td.setAttribute("class", "info");
    var estado='Pendiente';
    if (document.getElementById('grupo').checked )
    estado='Entregado';

    td.innerHTML =
    '<input type="hidden" value="'+id_producto.toString() +'"/>'+
    '<input type="hidden" value="'+id_elementos.toString()+'"/>'+
    '<input type="hidden" value="'+vendedor.toString()    +'"/>'+
    '<input type="hidden" value="'+sucursal.toString()+'"/>'+
    '<input type="hidden" value="'+id_cliente.toString()  +'"/>'+
    '<input type="hidden" value="'+id_grupo.toString()+'"/>'+
    '<input type="hidden" value="'+estado+'"/>'+
    '<input type="hidden" value="0"/>'+

    '<a class="btn-social-icon btn-bitbucket"><i class="fa fa-opencart"></i></a>';
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = cantidad; //---columna 2
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = '<img  align="left" class="img-responsive" width="50px" src="'+img_thumbs+'">'+' &nbsp;&nbsp; <span class="text-light-blue">[ID = '+id_producto+']</span> '+select_productos[select_producto.selectedIndex].text;  //---columna 3
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = document.getElementById('datepicker').value;  //---columna 4
    td = tr.insertCell(tr.cells.length);
    td.innerHTML =  document.getElementById('datepicker2').value;  //---columna 5
    td = tr.insertCell(tr.cells.length);
    td.innerHTML =  '';  //---columna 6
    td = tr.insertCell(tr.cells.length);
    if (document.getElementById('grupo').checked )
    td.innerHTML = 'Entregado'; //---columna 7
    else
    td.innerHTML = 'Pendiente'; //---columna 7
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = precio_convenido.toString();  //---columna 8
    td = tr.insertCell(tr.cells.length);
    td.innerHTML =  ((document.getElementById("nota").value).split(",")).join(".");//---columna 9
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = '<button type="button" data-toggle="modal" onclick="editarProducto('+id_elementos+')" data-target="#myModalEdit" class="btn btn-success btn-xs"> <span class="btn-xs glyphicon glyphicon-edit"></span></button>'+
    ' <button type="button" class="btn btn-danger btn-xs" onclick="borrar('+id_elementos+')"> <span class="btn-xs glyphicon glyphicon-remove"></span></button>';

    calcularTotal();
    document.getElementById('cantidad').value=1;
    calculo_monto_cantidad(1);


  }else{
      document.getElementById('select_categoria').focus();
      alert('Seleccione una categoria con productos');
  }

}
function calcularTotal(){
   var total_ventas = 0;
   tabla = document.getElementById('tabla');
   for(var q=0;q<tabla.rows.length;++q)
   {
      if(q>cant_pedidos){
         var aux=tabla.rows[q].cells[7].innerHTML;
         total_ventas = total_ventas+parseFloat(aux);
      }

   }

  document.getElementById('monto_ventas').value = total_ventas.toString();
  var aux=parseInt($('#deuda_anterior').val())+parseInt($('#monto_ventas').val());

  document.getElementById('div_total').innerHTML = aux;
}
function borrar(fila) {

   nro_productos--;
   tabla = document.getElementById('tabla');
   posicion=0;
   //var nuevo_id_fila=0;
   for(var q=0;q<tabla.rows.length;++q)
   {
    if(q>cant_pedidos){
      //---buscadno la posicion del elemento para borrarlo
       var aux=tabla.rows[q].cells[0].childNodes[1].value;
       if(aux==fila){
        posicion=q;
        break;
       }
    }
   }
   alert('se descartara los producto de la fila numero = '+posicion);
  tabla.deleteRow(posicion);
  calcularTotal();
}
function calculo_monto_cantidad(cantidad){
  var precio=document.getElementById('precio').value;
  precio=precio*cantidad;
  document.getElementById('precio_convenido').value=precio;
}
function editarProducto (fila) {
  tabla = document.getElementById('tabla');
  precio_convenido  =0;
  cantidad          =0;
  producto          =0;
  posicion=0;
  //--Calculando la fila a editar

  for(var q=0;q<tabla.rows.length;++q)
  {
   if(q>0){
     //---buscadno la posicion del elemento para borrarlo
      var aux=tabla.rows[q].cells[0].childNodes[1].value;


      if(aux==fila){
       posicion=q;

       //precio_convenido  =tabla.rows[q].cells[3].innerHTML;
       //cantidad          =tabla.rows[q].cells[1].innerHTML;
       document.getElementById('edit_fila').value=fila;
       document.getElementById('edit_producto').innerHTML=tabla.rows[q].cells[2].innerHTML;

       document.getElementById('edit_precio_convenido').value=tabla.rows[q].cells[7].innerHTML;
       document.getElementById('edit_fecha_inicio').value=tabla.rows[q].cells[3].innerHTML;
       document.getElementById('datepicker4').value=tabla.rows[q].cells[4].innerHTML;
       document.getElementById('datepicker3').value=tabla.rows[q].cells[5].innerHTML;
       document.getElementById('edit_cantidad').value=tabla.rows[q].cells[1].innerHTML;
       document.getElementById('edit_anotacion').value=tabla.rows[q].cells[8].innerHTML;
       document.getElementById('edit_estado').value=tabla.rows[q].cells[6].innerHTML;

       valor=tabla.rows[q].cells[0].childNodes[7].value;

       if(valor==1)
         document.getElementById('edit_remover_stock').checked = true;
       else {
         document.getElementById('edit_remover_stock').checked = false;

       }


       break;

     }
   }
  }



}
function cambiarDatosTabla(){
  tabla = document.getElementById('tabla');
  precio_convenido  = document.getElementById('edit_precio_convenido').value;
  fila=document.getElementById('edit_fila').value;

  //--Calculando la fila a editar
  for(var q=0;q<tabla.rows.length;++q)
  {
   if(q>0){
     //---buscadno la posicion del elemento para modificarlo
      var aux=tabla.rows[q].cells[0].childNodes[1].value;
      if(aux==fila){
        //---viendo si es pedido nuevo
        notas=document.getElementById('edit_anotacion').value;
        notas=(notas.split(",")).join(".");
        tabla.rows[q].cells[7].innerHTML=precio_convenido;
        tabla.rows[q].cells[8].innerHTML=notas;
        tabla.rows[q].cells[5].innerHTML=document.getElementById('datepicker3').value;
        tabla.rows[q].cells[4].innerHTML=document.getElementById('datepicker4').value;
        tabla.rows[q].cells[6].innerHTML=document.getElementById('edit_estado').value;
        valor=document.getElementById('edit_remover_stock').checked;
        if(valor==true)
          tabla.rows[q].cells[0].childNodes[7].value = 1;
        else {
          tabla.rows[q].cells[0].childNodes[7].value = 0;

        }
        if(q>cant_pedidos){
          ///alert('es nuevo');

        }else{

          //alert('es antiguo');
          id_pedido=      tabla.rows[q].cells[0].childNodes[6].value;
          nro_orden=      tabla.rows[q].cells[0].childNodes[5].value;
          descontar=      tabla.rows[q].cells[0].childNodes[7].value;
          fecha=          tabla.rows[q].cells[3].innerHTML;
          fecha_entregar= tabla.rows[q].cells[4].innerHTML;
          fecha_entregados=tabla.rows[q].cells[5].innerHTML;
          estado=tabla.rows[q].cells[6].innerHTML;


          $.ajax({
            url: '<?php echo base_url('ventas/modificar_pedidos');?>',
            dataType: 'json',
            type: 'post',
            //contentType: 'application/json',
            data: {'id':id_pedido,'orden':nro_orden,'fecha_inicio':fecha,
            'fecha_entrega':fecha_entregar,'fecha_entregado':fecha_entregados,
            'anotacion':notas,'estado':estado,'descontar_stock':descontar},
            //processData: false,
            success: function( data, textStatus, jQxhr ){
                //$('#response pre').html( JSON.stringify( data ) );

              //alert(JSON.stringify(data));
            },
            error: function( jqXhr, textStatus, errorThrown ){
                //console.log( errorThrown );
                alert("falla");
            }
          });


        }

       break;
      }
   }
  }
  calcularTotal();

}
function cambiarDatosAgendaTabla(){
  tabla = document.getElementById('tabla');


          $.ajax({
            url: '<?php echo base_url('clientes/modificar_agenda');?>',
            dataType: 'json',
            type: 'post',
            //contentType: 'application/json',
            data: {
            'id_cliente':<?=$agenda['id_cliente']?>,
            'direccion_cobranza':$('#edit_direccion_cobranza').val(),
            'zona'              :$('#edit_zona_cobranza').val(),
            'telefono_cobranza' :$('#edit_telefono_cobranza').val(),
            'hora_estimada'     :$('#edit_hora_estimada').val(),
            'garante_1'         :$('#edit_garante_1').val(),
            'ci_1'              :$('#edit_ci_1').val(),
            'direccion_1'       :$('#edit_direccion_1').val(),
            'telefono_1'        :$('#edit_telefono_1').val(),
            'garante_2'         :$('#edit_garante_2').val(),
            'ci_2'              :$('#edit_ci_2').val(),
            'direccion_2'       :$('#edit_direccion_2').val(),
            'telefono_2'        :$('#edit_telefono_2').val()
          },
            //processData: false,
            success: function( data, textStatus, jQxhr ){
              $('#agenda_data').html( data['html']);

              // alert(JSON.stringify(data));

            },
            error: function( jqXhr, textStatus, errorThrown ){
                //console.log( errorThrown );
                alert("falla");
            }
          });




}
//////////////////////////////////////////
function datosCliente(){

  alert("ID:  <?=$cuenta_cliente['id']?>"+"\n"+
  "Nombre: <?=$cuenta_cliente['nombres']?>"+"\n"+
  "Sexo: <?=$cuenta_cliente['sexo']?>"+"\n"+
  "Ci: <?=$cuenta_cliente['ci']?>"+"\n"+
  "Direccion: <?=$cuenta_cliente['direccion']?>"+"\n"+
  "Telefono: <?=$cuenta_cliente['telefono']?>"+"\n"+
  "Email: <?=$cuenta_cliente['email']?>"+"\n"+
  "Facebook: <?=$cuenta_cliente['facebook']?>"+"\n"+
  "Referencia: <?=$cuenta_cliente['referencia']?>"+"\n"+
  "Ocupacion: <?=$cuenta_cliente['oficio']?>"

);
}

///////////////////////////////////////////////////////////
//--------------------------------------------------------
//--------------FORM--------------------------------------

function validacion_formvc(){


  //alert(nro_productos);
   var concat='';
   document.getElementById('total_actual').value=document.getElementById('monto_ventas').value;
   tabla = document.getElementById('tabla');
   if(nro_productos>0){
   for(var q=0;q<tabla.rows.length;++q)
   {
      if(q>cant_pedidos){
      id_producto       =tabla.rows[q].cells[0].childNodes[0].value;
      vendedor          =tabla.rows[q].cells[0].childNodes[2].value;
      sucursal          =tabla.rows[q].cells[0].childNodes[3].value;
      //id_cliente        =tabla.rows[q].cells[0].childNodes[4].value;
      grupo             =tabla.rows[q].cells[0].childNodes[5].value;
      //estado            =tabla.rows[q].cells[0].childNodes[6].value;
      descontar         =tabla.rows[q].cells[0].childNodes[7].value;
      precio_convenido  =tabla.rows[q].cells[7].innerHTML;
      cont_productos    =tabla.rows[q].cells[1].innerHTML;
      notas             =tabla.rows[q].cells[8].innerHTML;
      notas=(notas.split(",")).join(".");
      fechas            =tabla.rows[q].cells[3].innerHTML;
      fechas_entregas   =tabla.rows[q].cells[4].innerHTML;
      fechas_entregados =tabla.rows[q].cells[5].innerHTML;
      estado            =tabla.rows[q].cells[6].innerHTML;


      //alert(estado);
      document.getElementById('array_id_productos').value=
      document.getElementById('array_id_productos').value+concat+id_producto;
      document.getElementById('array_precio_productos').value=
      document.getElementById('array_precio_productos').value+concat+precio_convenido;
      document.getElementById('array_cantidad_productos').value=
      document.getElementById('array_cantidad_productos').value+concat+cont_productos;
      document.getElementById('array_descontar_stock').value=
      document.getElementById('array_descontar_stock').value+concat+descontar;
      //document.getElementById('array_id_clientes').value=
    //  document.getElementById('array_id_clientes').value+concat+id_cliente;

      document.getElementById('array_vendedores').value=
      document.getElementById('array_vendedores').value+concat+vendedor;
      document.getElementById('array_sucursales').value=
      document.getElementById('array_sucursales').value+concat+sucursal;
      document.getElementById('array_notas').value=
      document.getElementById('array_notas').value+concat+notas;
      document.getElementById('array_fechas').value=
      document.getElementById('array_fechas').value+concat+fechas;
      document.getElementById('array_fechas_entregas').value=
      document.getElementById('array_fechas_entregas').value+concat+fechas_entregas;
      document.getElementById('array_grupos').value=
      document.getElementById('array_grupos').value+concat+grupo;
      document.getElementById('array_estados').value=
      document.getElementById('array_estados').value+concat+estado;
      document.getElementById('array_fechas_entregados').value=
      document.getElementById('array_fechas_entregados').value+concat+fechas_entregados;

      concat=',';

    }
   }


  $('#fecha_venta').val($('#datepicker').val());
  $('#id_sucursal').val($('#select_sucursal').val());
  $('#id_vendedor').val($('#select_vendedor').val());
  //---plan de pago
  $('#db_monto_restante').val($('#cuota_restante').val());
  $('#db_monto_inicial').val($('#monto_inicial').val());
  if($('#tipo_pago').val()==4){ //---si pago es al finalizar
    $('#db_monto_inicial').val($('#edit_monto_adelanto').val());
  }
  $('#db_nro_cuotas').val($('#nro_cuotas').val());
  $('#db_tipo_periodico').val($('#select_periodico').val());
  $('#db_monto_cuotas').val($('#monto_cuota').val());
  $('#db_fecha_inicio').val($('#datepicker3').val());
  ///-enviando form
  $('#ventas_formvc').submit();
  }else{
    alert("Ingrese algun producto");
  }
}
function forma_pago(tipo){
    //alert('ocultar'+tipo);
  $('#panel_pago').hide();
  $('#panel_pago_finalizar').hide();
  if(tipo==1){

  $('#tipo_pago').val(1);
  $('#panel_pago').hide();
}else if(tipo==4){ //--al finalizar

  $('#tipo_pago').val(4);
  $('#panel_pago_finalizar').show();
}else{
  $('#tipo_pago').val(tipo);
  $('#panel_pago').show();
  }
  calcular_restante();
}
function calcular_restante(){
  if($('#tipo_pago').val()==3){
    monto_total= parseInt($('#monto_ventas').val());
  }else{
  monto_total= parseInt($('#deuda_anterior').val())+parseInt($('#monto_ventas').val());
  }
  monto_inicial=parseInt(document.getElementById("monto_inicial").value);
  document.getElementById("cuota_restante").value=monto_total-monto_inicial;
  //$('#monto_restante').val(  $('#cuota_restante').val());
}
function calcular_restante_adelanto(){
  monto_total= parseInt($('#monto_ventas').val());
  monto_inicial=parseInt(document.getElementById("edit_monto_adelanto").value);
  document.getElementById("cuota_restante").value=monto_total-monto_inicial;
  //$('#emonto_restante').val(  $('#cuota_restante').val());
}

function graficar_cuotas(tipo){
  if(tipo==0)
    valor=document.getElementById('nro_cuotas').value;
  else
    valor=document.getElementById('monto_cuota').value;
  monto_credito=document.getElementById('cuota_restante').value;
  fecha_inicio=document.getElementById('datepicker2').value;
  select_periodico=document.getElementById('select_periodico');
  select_periodico=select_periodico.options[select_periodico.selectedIndex].value;
  //alert(select_periodico);
  if(valor!=''){
  if(monto_credito!=''){
  if(fecha_inicio!=''){
  //alert('enviando');
  $.get( "<?php echo base_url('ventas/graficar_cuotas');?>",
    {valor:valor,tipo:tipo,monto_credito:monto_credito,fecha_inicio:fecha_inicio,select_periodico:select_periodico},
    function( data ) {
     //---respuesta
     //alert(data);
      document.getElementById('cuotas_grafica').innerHTML=data;
      nro_cuotas=document.getElementById('res_nro_cuotas').value;
      document.getElementById('nro_cuotas').value=nro_cuotas;
      monto_cuota=document.getElementById('res_monto_cuota').value;
      document.getElementById('monto_cuota').value=monto_cuota;

  });
}else{
  alert('Debe ingresar una fecha de inicio para cobranza')
}}else{
  alert('Debe haber un monto de credito para generar un plan de pago')
}}else{
  alert('Debe especificar un numero o un monto de cuotas para calcular');
}

}
function validacion_formpagos(opt){
  document.getElementById('opt_pago').value=opt;
  if(opt==1){
    if(document.getElementById('monto_pagar').value>0){
    if(document.getElementById('monto_pagar').value==document.getElementById('monto_confirmar').value){
      $('#ventas_formpagos').submit();
    }else{
      alert('El monto a pagar debe ser igual al monto de Confirmar');
    }}else alert('Ingrese un monto');
 }else{
   var retVal = confirm("Desea finalizar el pedido, pago y entrega completada ?");
    if( retVal == true ) {
       //document.write ("User wants to continue!");
       $('#ventas_formpagos').submit();
       return true;
    }
 }


}
</script>
