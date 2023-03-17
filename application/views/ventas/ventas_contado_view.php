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

<div class="row">

  <div class="col-sm-8">
    <div class="box box-primary">
      <div class="">
        <div class="input-group margin ">
                <div class="input-group-btn">
                  <button type="button" class="btn btn-primary"><i class="fa fa-edit"></i></button>
                </div>
                <!-- /btn-group -->
                <?php
                  echo form_dropdown('select_producto', $combox_productos,'0','class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" id="select_producto" onchange="obtenerInfoProducto(this.value)" ');
                ?>
                <span class="input-group-btn">
                <input class="form-control" type="number" id="cantidad" name="cantidad" value="1" min="1" max="99" style="width:65px; " onchange="calculo_monto_cantidad(this.value)"  value="1"/>
                </span>
                <span class="input-group-btn">
                  <button type="button" id="butt_agregar" onclick="agregarproducto()" class="btn btn-success btn-flat"><i class="fa fa-shopping-cart"></i><span class="hidden-xs"> Agregar</span></button>
                </span>

        </div>

      </div>
      <div class="row">
              <div class="box-body " style="min-height:150px">
              <div class="table-responsive">
              <table id="tabla" class="table table-hover table-striped" style="margin-bottom: 0px">
              <tbody>
                <tr>
                  <th style="width:30px;"><span class="glyphicon glyphicon-th-list"></span></th>
                  <th style="width:auto">Producto</th>
                  <th style="width:40px;">Cantidad</th>
                  <th style="width:40px;" >Precio</th>
                  <th style="width:40px;" >Descuento</th>
                  <th style="width:80px;" >Total</th>
                  <th style="width:40px;">Opcion</th>
                </tr>
                <tr>
                  <td colspan="5" class="text-right">
                    <div id="info_carrito" class="text-yellow"><h4>No hay articulo en el carrito de ventas <i class="text-green fa fa-shopping-cart"></i></h4></div>
                  </td>
                  <td>
                    <div id="ver_monto" hidden>
                      <input type="text" class="form-control" readonly="" id="monto_ventas" name="monto_ventas" value="0"/>
                    </div>
                  </td>
                  <td></td>
                </tr>
              </tbody>
              </table>
              </div>


                        <!-- /.montos globales de la venta-->
                </div><!-- /.box-body -->

    </div>
    </div>

    <?php
  $attributtes=' id="ventas_formvc" ';
  echo form_open('ventas/ventas_contado',$attributtes);
  ?>
  <input type="hidden" name="id_cliente" id="id_cliente" value=""/>
  <input type="hidden" name="array_id_productos" id="array_id_productos" />
  <input type="hidden" name="array_precio_productos" id="array_precio_productos" />
  <input type="hidden" name="array_cantidad_productos" id="array_cantidad_productos" />
  <input type="hidden" name="butt_vc_procesar"  value="procesar" id="butt_vc_procesar" />
  <input type="hidden" name="select_vendedor"  value="<?=$id_persona?>" id="select_vendedor"/>
  <input type="hidden" name="monto_ventas_vc"  value="0" id="monto_ventas_vc"/>
  <input type="hidden" name="descripcion_vc"  value="0" id="descripcion_vc"/>
  <input type="hidden" name="id_sucursal_vc"  value="<?=$id_sucursal?>" id="id_sucursal_vc"/>
  <?php echo form_close(); ?>
  <input type="hidden"  id="precio_convenido" name="precio_convenido" required="required" maxlength="15"/>


  </div>
  <div class="col-sm-4 ">
    <div>
    <div class="box invoice-content fix-margin-bottom">
      <div class="row">
          <div class="col-sm-6 col-xs-6">
            <div align="center">
            <img name="img-prod-thumb" style="max-height:150px" id="img-prod-thumb" class="img-responsive thumbnail" src="<?php echo base_url();?>/assets/img/catalogo/thumbs/no_image.png"/>
           </div>
          </div>
          <div class="col-sm-6 col-xs-6 fix-margin-left">

            <ul class="list-group-unbordered list-group-info ">
                <h3 class="profile-username text-center"><div id="codigo"></div></h3>
                <li class="list-group-item list-group-item_info">
                  <b id="medida"></b> <a class="pull-right"><div id="precio">0</div></a>
                </li>
                <li class="list-group-item list-group-item_info">
                  <b id="unidad_mayor"></b> <a class="pull-right"><div id="precio_mayor">0</div></a>
                </li>
                <li class="list-group-item list-group-item_info">
                  <b>Stock</b> <a class="pull-right"><div id="stock">0</div></a>
                </li>
              </ul>

          </div>
      </div>
    </div>
    </div>
  </div>
  <div class="col-sm-4 ">
    <div class="box invoice-content invoice-top">
      <div class="row">
        <div class="col-sm-12 form-group">
          <div align="center">
          <img class="img_foto" id="img_fotografia_cliente" src="<?=base_url()?>assets/img/fotografias/no_image.png"/>
          <div class="input-group radio-inline">
          <label class="radio-inline">
            <input type="radio" id="radioh" value="H" name="optsexocliente"/>
            <span class="fa fa-male"/>
          </label>
          <label class="radio-inline">
            <input type="radio" checked  value="M" name="optsexocliente"/>
            <span class="fa fa-female"/>
           </label>
          </div>
          </div>
        </div>
          <div class="col-sm-12 form-group">
            <div class="input-group">
              <div class="input-group-btn">
                <button type="button" data-toggle="modal"  data-target="#modalcliente" class="btn btn-info"> <i class="fa fa-user-plus"></i>
                </button>
              </div>
              <div class="input-group-btn">
              <button onclick="limpiarDatosCliente()" class="btn btn-danger" type="button" id="butt_clear_cliente" >
                  <i class="fa fa-ban"></i>
              </button>
              </div>
              <select id="clientename"  name="clientename"  class="clientename form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">
              </select>
            </div>
          </div>
          <div class="col-sm-12">
              <table class="table">
                <tbody><tr>
                  <th style="width:40%">Sucursal:</th>
                  <td><?=$nombre_sucursal?></td>
                </tr>
                <tr>
                  <th>Vendedor:</th>
                  <td><?=$nombre_persona?></td>
                </tr>
                <tr>
                  <th>Descripcion:</th>
                  <td><input class="form-control" id="descripcion" placeholder="descripcion" name="descripcion" type="text" value="Ventas al contado ">
  </td>
                </tr>
                <tr>
                  <th>Total:</th>
                  <td colspan="2"><div id="lb_total"></div></td>
                </tr>
              </tbody></table>
          </div>
          <div class="col-sm-12 form-group">
            <div class="col-sm-6 col-xs-6">
            <button class="btn btn-success btn-block" type="button" onclick="validacion_formvc()" >Guardar Venta</button>
            </div>
            <div class="col-sm-6 col-xs-6">
            <a href="<?php echo base_url()."ventas/ventas_suspendidas";?>" class="btn btn-default btn-block" role="button">Cancelar</a>
            </div>

          </div>
      </div>
    </div>
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
      <div class="modal-body">
        <p>Establecer precio para <label id="edit_cantidad"></label> producto:</p><label id="edit_producto"></label>
        <div>
              <input type="text" class="form-control" id="edit_precio_convenido" value="0"/>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal" onclick="cambiarDatosTabla()">Guardar</button>
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

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
            <label class="">Sexo <span class="text-red">(*)</span></label>
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
            <div class="input-group margin">
              <input type="text" class="form-control" id="edit_ci" placeholder="Cedula Identidad" value=""/>
            <div class="input-group-btn">
                <button onclick="buscarDatosCliente()" class="btn btn-success btn-flat" type="button" id="butt_datos_cliente" >
                    <span class="glyphicon glyphicon-search"></button>
            </div>
            </div>
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
<script type="text/javascript">
//---variables NECESARIAS
id_elementos=0;//--identificador de filas
nro_productos=0;//--cantidad_productos
//---FUNCIONES NECESARIAS

function limpiarDatosCliente(){
  document.getElementById("edit_ci").value='';
  document.getElementById("clientename").value='';
  document.getElementById("id_cliente").value='';

  $("#clientename").empty().trigger("change");
  var newOption = new Option("NN",0, false, false);
  $('#clientename').append(newOption).trigger('change');
}
function buscarDatosCliente(){



 var ci=document.getElementById("edit_ci").value;
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
      //alert('No encontrado');
      document.getElementById("clientename").value='No encontrado'
      document.getElementById("id_cliente").value='0';
    }

    })
    .fail(function() {
      alert( "No se pudo buscar al cliente" );
    });
}else{
  alert('Ingrese la Cedula de Identidad');
  }


}

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


function obtenerInfoProducto(valor){

    if(valor!=''){
    $.get( "<?php echo base_url('productos/obtener_info_producto');?>",
      {id_producto:valor,id_sucursal:'<?=$id_sucursal?>'},
      function( data ) {
       //---respuesta
        var res=JSON.parse(data);
        var precio=res['precio'];
        var codigo=res['codigo'];
        var path_image="<?php echo base_url()?>assets/img/catalogo/small/"+res['imagen'];
        document.getElementById('img-prod-thumb').src=path_image;
        document.getElementById('precio').innerHTML=precio;
        document.getElementById('codigo').innerHTML=codigo;
        var cantidad=document.getElementById('cantidad').value;
        document.getElementById('precio_convenido').value=cantidad*precio;
        document.getElementById('img_src').value="<?php echo base_url()?>assets/img/catalogo/thumbs/"+res['imagen'];
        document.getElementById('medida').innerHTML=res['medida'];
        document.getElementById('unidad_mayor').innerHTML=res['unidad_mayor'];
        document.getElementById('precio_mayor').innerHTML=res['precio_mayor'];
        document.getElementById('stock').innerHTML=res['stock'];

    });
    }else{
      //alert('Es vacio');
       document.getElementById('img-prod-thumb').src="<?php echo base_url()?>assets/img/catalogo/thumbs/8c327-no-disponible.png";
       document.getElementById('precio').innerHTML="0";
       document.getElementById('precio_convenido').value="0";
    }

};

function agregarproducto(){

  var options=document.getElementById('select_producto').length;
  if(options>0){

    id_elementos++;
    nro_productos++;
    var select_productos=document.getElementById('select_producto');
    var tr, td, tabla;
    var precio=document.getElementById('precio').innerHTML;
    var precio_convenido=document.getElementById('precio_convenido').value;
    var codigo=document.getElementById('codigo').innerHTML;
    var cantidad=document.getElementById('cantidad').value;
    var id_producto=select_producto.value;
    var img_thumbs=document.getElementById('img_src').value;

    tabla = document.getElementById('tabla');
    tr = tabla.insertRow(tabla.rows.length-1);
    //tr.setAttribute("class", "info");
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = '<input type="hidden" value="'+id_producto.toString()+'"/><input type="hidden" value="'+id_elementos.toString()+'"/>';
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = '<img  align="left" class="img-responsive" width="50px" src="'+img_thumbs+'">'+' &nbsp;&nbsp; <span class="text-light-blue">['+codigo+']</span> '+select_productos[select_producto.selectedIndex].text;  //---columna 3
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = cantidad; //---columna 2
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = ""+precio.toString();  //---columna 4
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = "";  //---columna 5
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = precio_convenido.toString();  //---columna 6
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = '<button type="button" data-toggle="modal" onclick="editarProducto('+id_elementos+')" data-target="#myModalEdit" class="btn btn-primary btn-xs"> <span class="glyphicon glyphicon-edit"></span></button>'+
    ' <button type="button" class="btn btn-danger btn-xs" onclick="borrar('+id_elementos+')"> <span class="glyphicon glyphicon-remove"></span></button>';
    document.getElementById('cantidad').value=1;
    $('#ver_monto').show();
    document.getElementById('info_carrito').innerHTML='<b>Total</b>';
    calcularTotal();

  }else{
      alert('Seleccione un producto');
  }

}
function calcularTotal(){
   var total_ventas = 0;
   tabla = document.getElementById('tabla');
   for(var q=0;q<tabla.rows.length-1;++q)
   {
      if(q>0){
         //alert(tabla.rows[q].cells[4].innerHTML);
         var aux=tabla.rows[q].cells[5].innerHTML;
         //var id_fila=parseInt(aux);
         total_ventas = total_ventas+parseFloat(aux);
      }

   }
  document.getElementById('monto_ventas').value = total_ventas.toString();
  document.getElementById('lb_total').innerHTML = total_ventas.toString();
}
function borrar(fila) {

   nro_productos--;
   tabla = document.getElementById('tabla');
   posicion=0;
   //var nuevo_id_fila=0;
   for(var q=0;q<tabla.rows.length-1;++q)
   {
    if(q>0){
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
  if(nro_productos<=0){
    document.getElementById('info_carrito').innerHTML='<h4>No hay articulo en el carrito de ventas <i class="text-green fa fa-shopping-cart"></i><h4>';
    $('#ver_monto').hide();
  }
  calcularTotal();
}
function calculo_monto_cantidad(cantidad){
  var precio=document.getElementById('precio').innerHTML;
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
  for(var q=0;q<tabla.rows.length-1;++q)
  {
   if(q>0){
     //---buscadno la posicion del elemento para borrarlo
      var aux=tabla.rows[q].cells[0].childNodes[1].value;
      if(aux==fila){
       posicion=q;
       precio_convenido  =tabla.rows[q].cells[4].innerHTML;
       cantidad          =tabla.rows[q].cells[1].innerHTML;
       producto          =tabla.rows[q].cells[2].innerHTML;
       break;
      }
   }
  }

  document.getElementById('edit_precio_convenido').value=precio_convenido;
  document.getElementById('edit_fila').value=fila;
  document.getElementById('edit_producto').innerHTML=producto;
  document.getElementById('edit_cantidad').innerHTML=cantidad;

}
function cambiarDatosTabla(){
  tabla = document.getElementById('tabla');
  precio_convenido  = document.getElementById('edit_precio_convenido').value;
  fila=document.getElementById('edit_fila').value;
  //--Calculando la fila a editar
  for(var q=0;q<tabla.rows.length-1;++q)
  {
   if(q>0){
     //---buscadno la posicion del elemento para borrarlo
      var aux=tabla.rows[q].cells[0].childNodes[1].value;
      if(aux==fila){
       tabla.rows[q].cells[5].innerHTML=precio_convenido;
       break;
      }
   }
  }
  calcularTotal();

}
///////////////////////////////////////////////////////////
//--------------------------------------------------------
//--------------FORM--------------------------------------

function validacion_formvc(){


  //alert(nro_productos);
   var concat='';
   tabla = document.getElementById('tabla');
   if(nro_productos>0){
   for(var q=0;q<tabla.rows.length-1;++q)
   {
      if(q>0){
      id_producto       =tabla.rows[q].cells[0].childNodes[0].value;
      precio_convenido  =tabla.rows[q].cells[5].innerHTML;
      cont_productos    =tabla.rows[q].cells[2].innerHTML;
     // alert(precio_convenido);
      document.getElementById('array_id_productos').value=
      document.getElementById('array_id_productos').value+concat+id_producto;
      document.getElementById('array_precio_productos').value=
      document.getElementById('array_precio_productos').value+concat+precio_convenido;
      document.getElementById('array_cantidad_productos').value=
      document.getElementById('array_cantidad_productos').value+concat+cont_productos;

      concat=',';
      }
   }
     document.getElementById('monto_ventas_vc').value=document.getElementById('monto_ventas').value;
     document.getElementById('descripcion_vc').value=document.getElementById('descripcion').value;
     //document.getElementById('id_sucursal_vc').value=document.getElementById('select_sucursal').value;



  $('#ventas_formvc').submit();
  }else{
    alert("Ingrese algun producto");
  }
}

</script>
