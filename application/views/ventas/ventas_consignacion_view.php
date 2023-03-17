
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


<?php
    $attributtes=' id="ventas_formvc" ';
    echo form_open('ventas/consignacion_cliente',$attributtes);
?>


<input type="hidden" name="id_cliente" id="id_cliente" value="<?=$cuenta_cliente['id']?>"/>
<input type="hidden" name="array_id_productos" id="array_id_productos" />
<input type="hidden" name="array_precio_productos" id="array_precio_productos" />
<input type="hidden" name="total_actual" id="total_actual" />
<input type="hidden" name="deuda_cliente" id="deuda_cliente"  value="<?=$monto_pendiente?>" />
<input type="hidden" name="saldo_cliente" value="<?=$cuenta_cliente['cuenta_cliente']['saldo']?>" />
<input type="hidden" name="array_cantidad_productos" id="array_cantidad_productos" />
<input type="hidden" name="array_precios_unitario_productos" id="array_precios_unitario_productos" />
<input type="hidden" name="array_medidas_productos" id="array_medidas_productos" />
<input type="hidden" name="array_precios_venta_productos" id="array_precios_venta_productos" />
<!--<input type="hidden" name="array_id_clientes" id="array_id_clientes"/>-->
<input type="hidden" name="array_vendedores" id="array_vendedores"/>
<input type="hidden" name="array_sucursales" id="array_sucursales"/>
<input type="hidden" name="array_notas" id="array_notas"/>
<input type="hidden" name="array_fechas" id="array_fechas"/>
<input type="hidden" name="array_fechas_entregas" id="array_fechas_entregas"/>
<input type="hidden" name="array_descontar_stock" id="array_descontar_stock"/>
<input type="hidden" name="array_grupos" id="array_grupos"/>
<input type="hidden" name="array_estados" id="array_estados"/>
<input type="hidden" name="array_fechas_entregados" id="array_fechas_entregados"/>
<input type="hidden" id="butt_vc_procesar"  name="butt_consignacion_procesar"  value="ok" />

<?php echo form_close(); ?>
<?php
    $attributtes=' id="reportesconsignacion_form" ';
    echo form_open('reportes/consignacion_cliente',$attributtes);
?>

  <input type="hidden" name="id_cliente" value="<?=$cuenta_cliente['id']?>"/>

  <?php echo form_close(); ?>
<div class="panel panel-primary">
<div class="panel-heading">
    <h2 class="panel-title text-center">CONSIGNACION DE PRODUCTOS</h2>
</div>
<div class="panel-body">
<div>
    <p>Introduzca y verifique los datos antes de guardarlos</p>
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
       <label >Monto Pendiente:</label>
  </div>
  <div class="col-sm-2 form-group">
       <input class="form-control" disabled type="text" id="deuda_anterior" name="deuda_anterior" value="<?=$monto_pendiente?>" >
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
                <label>Fecha de Entrega:</label>

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
                <label>Fecha a Cuadrar:</label>

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
   <label id="precio_label">Precio Unitario</label>
   <input type="hidden" id="precio" value="0" name="precio"></label>
   <input type="hidden" id="precio_unitario" value="0" name="precio_unitario"></label>
  <input class="form-control"  id="precio_convenido" name="precio_convenido" required="required" maxlength="15">

 </div>
 <div class="col-sm-2 form-group">
   <label>Precio Venta</label>

  <input class="form-control" disabled id="precio_venta" name="precio_venta" required="required" maxlength="15">

 </div>

  <div class="col-sm-2 form-group">
    <label >Medida</label>
   <input class="form-control"  id="nota" name="nota" required="required" maxlength="45">

  </div>
  <div class="col-sm-1 form-group">
    <label id="label_grupo" class="btn bg-aqua-active" data-toggle= "tooltip" data-placement= "top" title= "Agrupar" ><span class="fa  fa-object-group"></label>
    <input type="checkbox"  checked id="grupo"  onchange="iniciandoGrupo()">

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
              <h3 class="box-title">Productos en consignacion</h3>
          </div><!-- /.box-header -->
          <div class="box-body">
          <div class="row table-responsive">
          <table id="tabla" class="table table-hover">
          <thead>
            <tr>
              <th><span class="glyphicon glyphicon-th-list"></span></th>
              <th style="width:50px">Cant.</th>
              <th style="min-width: 200px">Producto</th>
              <th>Entregado</th>
              <th>Cuadrar</th>
              <th>Estado</th>
              <th>Monto</th>
              <th>Sucursal</th>
              <th style="min-width: 200px">Notas</th>
              <th>P.Unitario</th>
              <th>P.Venta</th>
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
  /><input type="hidden" value="<?=$pedido['id']?>"/><input type="hidden" value="<?=$pedido['id']?>"/><?=$pedido['id']?>
</td>
    <td><?=$pedido['cantidad']?></td>
    <td><img  align="left" class="img-responsive" width="50px" src="<?php echo base_url()?>assets/img/catalogo/thumbs/<?=$pedido['img_producto']?>">
      <span class="text-light-blue"><?=$pedido['codigo']?> </span>&nbsp;&nbsp;<?=$pedido['nombre_producto']?>
    </td>
    <td><?=$pedido['fecha_inicio']?></td>
    <td><?=$pedido['fecha_entrega']?></td>

    <td><?=$pedido['estado']?></td>
    <td><?=$pedido['total']?></td>
    <td><?=$pedido['sucursal']?></td>
    <td><?=$pedido['descripcion']?></td>
    <td><?=$pedido['precio_unitario']?></td>
    <td><?=$pedido['precio_venta']?></td>
    <td>
      <button type="button" data-toggle="modal" disabled onclick="editarProducto(<?=$i+1?>)" data-target="#myModalEdit" class="btn btn-primary btn-xs"> <span class="btn-xs glyphicon glyphicon-edit"></span>
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
                      <label for="monto_ventas" class="col-sm-8 control-label text-right">Monto Anterior (<?=$monto_pendiente?>) &nbsp;&nbsp;&nbsp;Total Actual</label>
                      <div class="col-sm-2">
                            <input type="text" class="form-control" readonly="" id="monto_ventas" name="monto_ventas" value="0"/>
                      </div>
                      <div class="col-sm-2 input-group">
                            <span class="input-group-addon">=</span>
                            <input type="text" class="form-control" readonly="" id="monto_global" name="monto_global" value="<?=$monto_pendiente?>"/>
                      </div>
                  </div>

                    <!-- /.montos globales de la venta-->
            </div><!-- /.box-body -->
      </div><!-- /.box -->
<!-----------------End Tabla Productos-------------------->


</div> <!--End panel body-->

    <div class="panel-footer text-center">
        <button class="btn btn-success" type="button" onclick="validacion_formvc()" >Guardar Consignacion de productos</button>
        <button class="btn btn-primary" type="button" onclick="imprimir_consignacion()" ><i class="fa fa-edit"></i> Exportar Excel</button>
      <a href="<?php echo base_url()."ventas/consignacion";?>" class="btn btn-default" role="button">Cancelar</a>
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
                  <label class="col-sm-4 control-label">Fecha a Cuadrar</label>
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
                  <label class="col-sm-4 control-label">Cantidad</label>
                  <div class="col-sm-8">
                    <input type="text" class="form-control" id="edit_cantidad" >
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
                    <label class="col-sm-4 control-label">Sucursal</label>
                    <div class="col-sm-8">
                      <input type="text"  disabled class="form-control" id="edit_sucursal">
                   </div>
                  </div>
                  <div class="form-group">
                    <label class="col-sm-8 control-label">Descontar de inventario de la sucursal:</label>
                    <div class="col-sm-4">
                      <input type="checkbox" checked value="edit_remover_stock"  disabled id="edit_remover_stock" >
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
function iniciandoGrupo(){

  var sw=document.getElementById("grupo").checked;
  if(sw){

    id_color++;
    if(id_color>22)
    id_color=0;
  //  alert(id_color);
    //alert(table_color[id_color]);
    id_grupo= Math.floor(Math.random() * 1000)+1;
    document.getElementById('label_grupo').className = 'btn '+table_color[id_color];
      //alert('Iniciando grupo '+id_grupo);
  }else{

    document.getElementById("grupo").checked=true;
    iniciandoGrupo()
  //  document.getElementById('label_grupo').className = 'btn btn-default';
  }
}
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
        var precio_unitario=parseFloat(res['precio_unitario']).toFixed(2);
        var precio=res['precio_unitario'];
        var path_image="<?php echo base_url()?>assets/img/catalogo/small/"+res['imagen'];
        document.getElementById('img-prod-thumb').src=path_image;
        document.getElementById('precio_label').innerHTML='Precio Unitario('+precio_unitario+')';
        document.getElementById('precio').value=precio;
        document.getElementById('precio_unitario').value=precio_unitario;
        document.getElementById('precio_venta').value=res['precio'];
        document.getElementById('nota').value=res['precio_mayor']+' Bs. la '+res['unidad_mayor'];
        var cantidad=document.getElementById('cantidad').value;
        var precio_convenido=cantidad*precio;
        if(precio_convenido % 1 == 0)
        document.getElementById('precio_convenido').value=precio_convenido;
        else
        document.getElementById('precio_convenido').value=parseFloat(precio_convenido).toFixed(2);


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
    var precio=document.getElementById('precio_unitario').value;
    var precio_venta=document.getElementById('precio_venta').value;
    var precio_convenido=document.getElementById('precio_convenido').value;
    var cantidad=document.getElementById('cantidad').value;
    var id_producto=select_producto.value;
    var img_thumbs=document.getElementById('img_src').value;
    var id_cliente=document.getElementById('id_cliente').value;

    var vendedor=select_vendedor.value;
    var sucursal =select_sucursal.value;
    var name_sucursal=select_sucursal.options[select_sucursal.selectedIndex].text;
    var arr_aux=name_sucursal.split(',');
    tabla = document.getElementById('tabla');
    tr = tabla.insertRow(tabla.rows.length);
    /*//---modificando estulo de la fila
    if (id_grupo!=0){
      tr.setAttribute("class", table_color[id_color]);
    }else*/
    tr.setAttribute("class", "info");
    /**/

    td = tr.insertCell(tr.cells.length);
    //---modificando estulo de la fila
    if (id_grupo!=0){
      td.setAttribute("class", table_color[id_color]);
    }else
    td.setAttribute("class", "info");
    td.innerHTML =
    '<input type="hidden" value="'+id_producto.toString() +'"/>'+
    '<input type="hidden" value="'+id_elementos.toString()+'"/>'+
    '<input type="hidden" value="'+vendedor.toString()    +'"/>'+
    '<input type="hidden" value="'+sucursal.toString()+'"/>'+
    '<input type="hidden" value="'+id_cliente.toString()  +'"/>'+
    '<input type="hidden" value="'+id_grupo.toString()+'"/>'+
    '<input type="hidden" value="Pendiente"/>'+
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
    td.innerHTML = 'Pendiente' //---columna 6
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = precio_convenido.toString();  //---columna 7
    td = tr.insertCell(tr.cells.length);
    td.innerHTML =arr_aux[0]; //---columna 8
    td = tr.insertCell(tr.cells.length);
    td.innerHTML =  ((document.getElementById("nota").value).split(",")).join(".");//---columna 9
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = precio.toString();  //---columna 9
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = precio_venta.toString();  //---columna 10
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
         var aux=tabla.rows[q].cells[6].innerHTML;
         total_ventas = total_ventas+parseFloat(aux);

      }

   }
  // total_global=total_ventas+total_global;
   //document.getElementById('monto_global').value = total_ventas.toString();
   //document.getElementById('monto_ventas').value = total_global;
   if (total_ventas % 1 != 0)
   total_ventas=Math.round(total_ventas * 10) / 10;
   deuda=parseInt(document.getElementById('deuda_cliente').value);
   deuda=deuda+parseInt(total_ventas);
   document.getElementById('monto_global').value=deuda;
   document.getElementById('monto_ventas').value = total_ventas.toString();
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
  if(precio % 1 == 0)
  document.getElementById('precio_convenido').value=precio;
  else

  document.getElementById('precio_convenido').value=parseFloat(precio).toFixed(2);
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

       document.getElementById('edit_precio_convenido').value=tabla.rows[q].cells[6].innerHTML;
       document.getElementById('edit_fecha_inicio').value=tabla.rows[q].cells[3].innerHTML;
       document.getElementById('datepicker4').value=tabla.rows[q].cells[4].innerHTML;
      // document.getElementById('datepicker3').value=tabla.rows[q].cells[5].innerHTML;
       document.getElementById('edit_cantidad').value=tabla.rows[q].cells[1].innerHTML;
       document.getElementById('edit_anotacion').value=tabla.rows[q].cells[8].innerHTML;
       //document.getElementById('edit_estado').value=tabla.rows[q].cells[5].innerHTML;
       document.getElementById('edit_sucursal').value=tabla.rows[q].cells[7].innerHTML;

      /* valor=tabla.rows[q].cells[0].childNodes[7].value;

       if(valor==1)
         document.getElementById('edit_remover_stock').checked = true;
       else {
         document.getElementById('edit_remover_stock').checked = false;

       }*/


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
     //---buscadno la posicion del elemento para borrarlo
      var aux=tabla.rows[q].cells[0].childNodes[1].value;
      if(aux==fila){
        //---viendo si es pedido nuevo
        notas=document.getElementById('edit_anotacion').value;
        notas=(notas.split(",")).join(".");
        tabla.rows[q].cells[6].innerHTML=precio_convenido;
        tabla.rows[q].cells[7].innerHTML=notas;
        //tabla.rows[q].cells[5].innerHTML=document.getElementById('datepicker3').value;
        tabla.rows[q].cells[4].innerHTML=document.getElementById('datepicker4').value;
        tabla.rows[q].cells[5].innerHTML=document.getElementById('edit_estado').value;
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
          //fecha_entregados=tabla.rows[q].cells[5].innerHTML;
          estado=tabla.rows[q].cells[5].innerHTML;
          //---no se permitira el cambio por ajax
/*

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
          });*/


        }

       break;
      }
   }
  }
  calcularTotal();

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
/*function validacion_formpagos(opt){
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


}*/
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
      estado            =tabla.rows[q].cells[0].childNodes[6].value;
      descontar         =tabla.rows[q].cells[0].childNodes[7].value;
      precio_convenido  =tabla.rows[q].cells[6].innerHTML;
      precio_unitario   =tabla.rows[q].cells[9].innerHTML;
      precio_venta      =tabla.rows[q].cells[10].innerHTML;
      cont_productos    =tabla.rows[q].cells[1].innerHTML;
      notas             =tabla.rows[q].cells[8].innerHTML;
      notas=(notas.split(",")).join(".");

      fechas            =tabla.rows[q].cells[3].innerHTML;
      fechas_entregas   =tabla.rows[q].cells[4].innerHTML;
      fechas_entregados =tabla.rows[q].cells[5].innerHTML;


     // alert(precio_convenido);
      document.getElementById('array_id_productos').value=
      document.getElementById('array_id_productos').value+concat+id_producto;
      document.getElementById('array_precio_productos').value=
      document.getElementById('array_precio_productos').value+concat+precio_convenido;
      document.getElementById('array_cantidad_productos').value=
      document.getElementById('array_cantidad_productos').value+concat+cont_productos;

      document.getElementById('array_precios_unitario_productos').value=
      document.getElementById('array_precios_unitario_productos').value+concat+precio_unitario;
      document.getElementById('array_medidas_productos').value=
      document.getElementById('array_medidas_productos').value+concat+notas;
      document.getElementById('array_precios_venta_productos').value=
      document.getElementById('array_precios_venta_productos').value+concat+precio_venta;
      document.getElementById('array_descontar_stock').value=
      document.getElementById('array_descontar_stock').value+concat+descontar;
      //document.getElementById('array_id_clientes').value=
    //  document.getElementById('array_id_clientes').value+concat+id_cliente;

      document.getElementById('array_vendedores').value=
      document.getElementById('array_vendedores').value+concat+vendedor;
      document.getElementById('array_sucursales').value=
      document.getElementById('array_sucursales').value+concat+sucursal;
    /*  document.getElementById('array_notas').value=
      document.getElementById('array_notas').value+concat+notas;*/
      document.getElementById('array_fechas').value=
      document.getElementById('array_fechas').value+concat+fechas;
      document.getElementById('array_fechas_entregas').value=
      document.getElementById('array_fechas_entregas').value+concat+fechas_entregas;
      document.getElementById('array_grupos').value=
      document.getElementById('array_grupos').value+concat+grupo;
      document.getElementById('array_estados').value=
      document.getElementById('array_estados').value+concat+estado;
    //  document.getElementById('array_fechas_entregados').value=
    //  document.getElementById('array_fechas_entregados').value+concat+fechas_entregados;

      concat=',';

    }
   }


  $('#ventas_formvc').submit();
  }else{
    alert("Ingrese algun producto");
  }
}
function imprimir_consignacion(){
  $('#reportesconsignacion_form').submit();
}
</script>
