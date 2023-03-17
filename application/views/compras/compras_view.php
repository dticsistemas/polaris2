
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
    echo form_open('compras/compras',$attributtes);
?>


<input type="hidden" name="id_cliente" id="id_cliente" value=""/>
<input type="hidden" name="nombre_cliente" id="nombre_cliente" value="NN"/>
<input type="hidden" name="array_id_productos" id="array_id_productos" />
<input type="hidden" name="array_precio_productos" id="array_precio_productos" />
<input type="hidden" name="array_cantidad_productos" id="array_cantidad_productos" />
<input type="hidden" name="array_id_clientes" id="array_id_clientes"/>
<input type="hidden" name="array_sexo_clientes" id="array_sexo_clientes"/>
<input type="hidden" name="array_vendedores" id="array_vendedores"/>
<input type="hidden" name="array_sucursales" id="array_sucursales"/>
<input type="hidden" name="array_notas" id="array_notas"/>
<input type="hidden" name="array_fechas" id="array_fechas"/>
<input type="hidden" name="array_grupos" id="array_grupos"/>
<input type="hidden" id="butt_vc_procesar"  name="butt_vc_procesar"  value="procesar" id="butt_vc_procesar" />

<?php echo form_close(); ?>
<div class="panel panel-primary">
<div class="panel-heading">
    <h2 class="panel-title text-center">REGISTRANDO COMPRAS</h2>
</div>
<div class="panel-body">
<div>
    <p>Introduzca los datos </p>
</div>
<div class="row">
<div class="col-sm-10">
<div class="row">
  <div class="col-sm-4">
      <div class="form-group">
                <label>Fecha de Compra:</label>

                <div class="input-group date">
                  <div class="input-group-addon">
                    <i class="fa fa-calendar"></i>
                  </div>
                  <input type="text" class="form-control pull-right" id="datepicker">
                </div>
                <!-- /.input group -->
      </div>
  </div>
  <div class='col-sm-4'>
      <div class="form-group">
         <label for="password">Sucursal</label>
         <div class='input-group date' >
            <?php
              echo form_dropdown('select_sucursal', $combox_sucursales,'0','class="form-control" id="select_sucursal" ' );
             ?>
          </div>
      </div>
  </div>
  <div class='col-sm-4'>
      <div class="form-group">
         <label for="password">Comprador</label>
         <div class='input-group date' >
            <?php
              echo form_dropdown('select_vendedor', $combox_vendedores,$id_persona,'id="select_vendedor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" ' );
             ?>
          </div>
      </div>
  </div>
</div>
<div class="row">
    <div class="col-sm-4">
        <div class="form-group">
            <label for="username">Nombre:</label>
            <div class="input-group">
              <div class="input-group-addon">
                <span class="glyphicon glyphicon-user"></span>
              </div>
              <select id="clientename"  name="clientename"  class="clientename form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true">

              </select>
            </div>

        </div>
    </div>
    <div class="col-sm-2">
        <div class="form-group">
             <label for="password">Sexo:</label>
             <div class="input-group radio-inline">
<label class="radio-inline"><input type="radio" id="radioh" value="H" name="optsexocliente"><span class="fa fa-male"> </label>
<label class="radio-inline"><input type="radio" checked  value="M" name="optsexocliente"><span class="fa fa-female"> </label>
             </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
             <label for="password">Ci:</label>
             <div class="input-group margin">
               <input class="form-control" id="cicliente" placeholder="Cedula Identidad" name="cicliente" type="text" value="">

               <div class="input-group-btn">
                 <button onclick="buscarDatosCliente()" class="btn btn-success btn-flat" type="button" id="butt_datos_cliente" >
                     <span class="glyphicon glyphicon-search"></button>
               </div>
                </div>
        </div>
    </div>

    <div class="col-sm-3">
        <div class="form-group">
             <label for="password">Proveedor</label>
             <div class="input-group margin">
             <button type="button" data-toggle="modal"  data-target="#modalcliente" class="btn btn-warning"> <span class="glyphicon glyphicon-user"></span>
             Nuevo</button>
             <button onclick="limpiarDatosCliente()" class="btn btn-default" type="button" id="butt_clear_cliente" >
                 <span class="fa fa-ban"> NN</button>
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
 <div class="col-sm-2 form-group">
       <label>Time picker:</label>

       <div class="input-group">
         <input id="hora" type="text" class="form-control timepicker">

         <div class="input-group-addon">
           <i class="fa fa-clock-o"></i>
         </div>
       </div>
       <!-- /.input group -->
  </div>
  <div class="col-sm-2 form-group">
    <label >Nota</label>
   <input class="form-control"  id="nota" name="nota" required="required" maxlength="45">

  </div>
  <div class="col-sm-1 form-group">
      <label >Grupo</label>
    <button id="btn_grupo" class="btn btn-default " onclick="iniciandoGrupo()" value="0"><span class="fa fa-object-group"></button>
    <!--<input type="checkbox"  id="grupo"  onchange="iniciandoGrupo()">-->

  </div>


</div> <!--End subrow-->



</div>


<div class="col-sm-2 form-group">
  <div class="row">
    <img name="img-prod-thumb" id="img-prod-thumb" class="img-responsive thumbnail" src="<?php echo base_url();?>/assets/img/catalogo/thumbs/no_image.png"/>
  </div>
    <div class="row form-group">
      <label></label>
      <button class="btn btn-primary" type="button" id="butt_agregar" onclick="agregarproducto()">Agregar Producto</button>

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
              <th>Precio</th>
              <th>Monto</th>
              <th>Hora</th>
              <th>Comprador</th>
              <th>Sucursal</th>
              <th>Notas</th>
              <th>Proveedor</th>
              <th>Accion</th>
            </tr>
          </thead>
          <tbody>
          </tbody>
          </table>
          </div>


                 <div class="form-group row">
                      <label for="monto_ventas" class="col-sm-8 control-label text-right">Total de Ventas</label>
                      <div class="col-sm-4">
                            <input type="text" class="form-control" readonly="" id="monto_ventas" name="monto_ventas" value="0"/>
                      </div>
                  </div>

                    <!-- /.montos globales de la venta-->
            </div><!-- /.box-body -->
      </div><!-- /.box -->
<!-----------------End Tabla Productos-------------------->


</div> <!--End panel body-->

    <div class="panel-footer text-center">
        <button class="btn btn-success" type="button" onclick="validacion_formvc()" >Guardar Compras</button>
        <a href="<?php echo base_url()."compras/compras";?>" class="btn btn-default" role="button">Cancelar</a>
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


<script type="text/javascript">
//---variables NECESARIAS
id_elementos=0;//--identificador de filas
nro_productos=0;//--cantidad_productos
var id_color=-1;
var id_grupo=0;
var table_color=['bg-red','bg-yellow','bg-aqua','bg-blue','bg-light-blue','bg-green',
'bg-navy','bg-teal','bg-olive','bg-lime','bg-orange','bg-fuchsia','bg-purple','bg-maroon',
'bg-black','bg-red-active','bg-yellow-active','bg-aqua-active','bg-blue-active','bg-light-blue-active',
'bg-green-active','bg-navy-active','bg-teal-active'];
//---FUNCIONES NECESARIAS
function iniciandoGrupo(){

  var sw=document.getElementById("btn_grupo").value;
  if(sw==0){
    document.getElementById("btn_grupo").value=1;
    id_color++;
    if(id_color>22)
    id_color=0;
    //alert(table_color[id_color]);
    id_grupo= Math.floor(Math.random() * 1000)+1;
    document.getElementById('btn_grupo').className = 'btn '+table_color[id_color];
      //alert('Iniciando grupo '+id_grupo);
  }else{
    id_grupo=0;
    document.getElementById("btn_grupo").value=0;
    document.getElementById('btn_grupo').className = 'btn btn-default';
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
        var precio=res['precio'];
        var path_image="<?php echo base_url()?>assets/img/catalogo/small/"+res['imagen'];
        document.getElementById('img-prod-thumb').src=path_image;
        document.getElementById('precio_label').innerHTML='Precio('+precio+')';
        document.getElementById('precio').value=precio;
        var cantidad=document.getElementById('cantidad').value;
        document.getElementById('precio_convenido').value=cantidad*precio;
        document.getElementById('img_src').value="<?php echo base_url()?>assets/img/catalogo/thumbs/"+res['imagen'];

    });
    }else{
      //alert('Es vacio');
       document.getElementById('img-prod-thumb').src="<?php echo base_url()?>assets/img/catalogo/thumbs/8c327-no-disponible.png";
        document.getElementById('precio').value="0";
        document.getElementById('precio_convenido').value="0";
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
    document.getElementById('cantidad').value=1;
    document.getElementById('precio_convenido').value=precio;
    var id_producto=select_producto.value;
    var img_thumbs=document.getElementById('img_src').value;
    var id_cliente=document.getElementById('id_cliente').value;
    var vendedor=select_vendedor.value;
    var sucursal =select_sucursal.value;
    var cliente_name=" NN ";
    var cliente_sexo="M";
    var imgsexo='<span class="fa fa-female">';
    if(document.getElementById('radioh').checked){
      cliente_sexo="H";
      imgsexo='<span class="fa fa-male">';
    }
    if(id_cliente==''){
      id_cliente=0;
    }
    if(id_cliente!=0){
      cliente_name=document.getElementById('nombre_cliente').value;
    }
    tabla = document.getElementById('tabla');
    tr = tabla.insertRow(tabla.rows.length);
    //---modificando estulo de la fila
    if (id_grupo!=0){
      tr.setAttribute("class", table_color[id_color]);
    }else
    tr.setAttribute("class", "info");

    td = tr.insertCell(tr.cells.length);
    td.innerHTML =
    '<input type="hidden" value="'+id_producto.toString() +'"/>'+
    '<input type="hidden" value="'+id_elementos.toString()+'"/>'+
    '<input type="hidden" value="'+vendedor.toString()    +'"/>'+
    '<input type="hidden" value="'+sucursal.toString()+'"/>'+
    '<input type="hidden" value="'+id_cliente.toString()  +'"/>'+
    '<input type="hidden" value="'+cliente_name.toString()+'"/>'+
    '<input type="hidden" value="'+cliente_sexo.toString()+'"/>'+
    '<input type="hidden" value="'+id_grupo.toString()+'"/>';
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = cantidad; //---columna 2
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = '<img  align="left" class="img-responsive" width="50px" src="'+img_thumbs+'">'+' &nbsp;&nbsp; <span class="text-light-blue">[ID = '+id_producto+']</span> '+select_productos[select_producto.selectedIndex].text;  //---columna 3
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = ""+precio.toString();  //---columna 4
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = precio_convenido.toString();  //---columna 5
    td = tr.insertCell(tr.cells.length);
    td.innerHTML =  document.getElementById('datepicker').value+' '+document.getElementById('hora').value;  //---columna 6
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = select_vendedor.options[select_vendedor.selectedIndex].innerText; //---columna 7
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = select_sucursal.options[select_sucursal.selectedIndex].innerText;//---columna 8
    td = tr.insertCell(tr.cells.length);
    td.innerHTML =  ((document.getElementById("nota").value).split(",")).join(".");//---columna 9
    td = tr.insertCell(tr.cells.length);
    td.innerHTML =  imgsexo.toString()+ cliente_name.toString();//---columna 10
    td = tr.insertCell(tr.cells.length);
    td.innerHTML = '<button type="button" data-toggle="modal" onclick="editarProducto('+id_elementos+')" data-target="#myModalEdit" class="btn btn-primary btn-xs"> <span class="glyphicon glyphicon-edit"></span></button>'+
    ' <button type="button" class="btn btn-danger btn-xs" onclick="borrar('+id_elementos+')"> <span class="glyphicon glyphicon-remove"></span></button>';
    document.getElementById("nota").value="";
    calcularTotal();

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
      if(q>0){
         //alert(tabla.rows[q].cells[4].innerHTML);
         var aux=tabla.rows[q].cells[4].innerHTML;
         //var id_fila=parseInt(aux);
         total_ventas = total_ventas+parseFloat(aux);
      }

   }
  document.getElementById('monto_ventas').value = total_ventas.toString();
}
function borrar(fila) {

   nro_productos--;
   tabla = document.getElementById('tabla');
   posicion=0;
   //var nuevo_id_fila=0;
   for(var q=0;q<tabla.rows.length;++q)
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
  for(var q=0;q<tabla.rows.length;++q)
  {
   if(q>0){
     //---buscadno la posicion del elemento para borrarlo
      var aux=tabla.rows[q].cells[0].childNodes[1].value;
      if(aux==fila){
       tabla.rows[q].cells[4].innerHTML=precio_convenido;
       break;
      }
   }
  }
  calcularTotal();

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
///////////////////////////////////////////////////////////
//--------------------------------------------------------
//--------------FORM--------------------------------------

function validacion_formvc(){


  //alert(nro_productos);
   var concat='';
   tabla = document.getElementById('tabla');
   if(nro_productos>0){
   for(var q=0;q<tabla.rows.length;++q)
   {
      if(q>0){
      id_producto       =tabla.rows[q].cells[0].childNodes[0].value;
      vendedor          =tabla.rows[q].cells[0].childNodes[2].value;
      sucursal          =tabla.rows[q].cells[0].childNodes[3].value;
      id_cliente        =tabla.rows[q].cells[0].childNodes[4].value;
      //cliente_name      =tabla.rows[q].cells[0].childNodes[5].value;
      cliente_sexo      =tabla.rows[q].cells[0].childNodes[6].value;
      grupo             =tabla.rows[q].cells[0].childNodes[7].value;

      precio_convenido  =tabla.rows[q].cells[4].innerHTML;
      cont_productos    =tabla.rows[q].cells[1].innerHTML;
      notas             =tabla.rows[q].cells[8].innerHTML;
      notas=(notas.split(",")).join(".");
      fechas            =tabla.rows[q].cells[5].innerHTML;
      //alert(vendedor+'-'+sucursal+' '+id_cliente+' '+cliente_sexo);

     // alert(precio_convenido);
      document.getElementById('array_id_productos').value=
      document.getElementById('array_id_productos').value+concat+id_producto;
      document.getElementById('array_precio_productos').value=
      document.getElementById('array_precio_productos').value+concat+precio_convenido;
      document.getElementById('array_cantidad_productos').value=
      document.getElementById('array_cantidad_productos').value+concat+cont_productos;

      document.getElementById('array_id_clientes').value=
      document.getElementById('array_id_clientes').value+concat+id_cliente;
      document.getElementById('array_sexo_clientes').value=
      document.getElementById('array_sexo_clientes').value+concat+cliente_sexo;
      document.getElementById('array_vendedores').value=
      document.getElementById('array_vendedores').value+concat+vendedor;
      document.getElementById('array_sucursales').value=
      document.getElementById('array_sucursales').value+concat+sucursal;
      document.getElementById('array_notas').value=
      document.getElementById('array_notas').value+concat+notas;
      document.getElementById('array_fechas').value=
      document.getElementById('array_fechas').value+concat+fechas;
      document.getElementById('array_grupos').value=
      document.getElementById('array_grupos').value+concat+grupo;

      concat=',';
      }
   }


  $('#ventas_formvc').submit();
  }else{
    alert("Ingrese algun producto");
  }
}

</script>
