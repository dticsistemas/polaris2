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
                  <th>Codigo</th>
                  <th>Imagen</th>
                  <th>Nombre</th>
                  <?php
                  $arr_estilo=array('bg-red','bg-yellow','bg-green','bg-aqua','bg-orange','bg-blue','bg-navy','bg-teal','bg-black');
                  $i=0;
                foreach ($sucursales as $sucursal): ?>
                    <th class="<?=$arr_estilo[$i]?>"><?=substr($sucursal['nombre'],0,strpos($sucursal['nombre'],','));?></th>
                  <?php
                  $i++;
                  endforeach; ?>
                  <th>Total</th>

                </tr>
                </thead>
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
        <div class="row">
          <?php
          $i=0;

          foreach ($sucursales as $sucursal): ?>
          <div class="col-sm-4">
          <div class="info-box <?=$arr_estilo[$i]?>">
            <span class="info-box-icon"><i class="ion ion-ios-pricetag-outline"></i></span>

            <div class="info-box-content">
              <span class="info-box-text"><?=substr($sucursal['nombre'],0,strpos($sucursal['nombre'],','));?></span>
              <span class="info-box-number"><div id="lb_cant<?=$sucursal['id']?>"><?=$sucursal['cantidad']?></div></span>

              <div class="progress">
                <div class="progress-bar" style="width: <?=$sucursal['porcentaje']?>%"></div>
              </div>
              <span class="progress-description">
                    <?=$sucursal['porcentaje']?>% del Total <?=$sucursal['total']?>
                    <a href="<?=base_url()?>reportes/catalogo_inventario_excel" target="_blank" class="pull-right">Excel <i class="fa fa-download"></i></a>
                  </span>
            </div>
            <!-- /.info-box-content -->
          </div>
        </div>
          <?php
          $i++;
          if($i>7)
          $i=0;
         endforeach; ?>


        </div>
      </div>
      <!-- /.row -->

</section>
<!--Mostrando Modal Productos Edit-->
<!-- Modal -->
<div id="myModalEdit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Inventario de Productos</h4>
      </div>
      <input type="hidden" id="id_producto" value="0"/>
      <input type="hidden" id="id_sucursal" value="0"/>
      <input type="hidden" id="id_cantidad" value="0"/>
      <div class="modal-body">
        <div class="row form-group">
          <div class="col-sm-4">
          producto:</div>
          <div class="col-sm-8"><label id="edit_inventario_producto"></label>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-sm-4">
          sucursal:</div>
          <div class="col-sm-8"><label id="edit_inventario_sucursal"></label>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-sm-4">
          cantidad:</div>
          <div class="col-sm-8"><input type="text" id="edit_inventario_cantidad" class="form-control" value="0"/>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-sm-4">
          opcion:</div>
          <div class="col-sm-8">
            <select class="form-control" id="opcion_inventario" onchange="verOpciones()">
            <option value="1">Agregar</option>
            <option value="2">Remover</option>
            <option value="3">Trasladar</option>
          </select>
          </div>
        </div>
        <div class="row form-group " id="traslado" hidden>
          <div class="col-sm-4" id="label_traslado">
          opcion:</div>
          <div class="col-sm-8">
              <select class="form-control" id="select_sucursal">
                <?php foreach ($sucursales as $sucursal): ?>
                  <option value="<?=$sucursal['id']?>"><?=$sucursal['nombre']?></option>
                <?php endforeach; ?>
              </select>
          </div>
        </div>
        <div class="row form-group">
          <div class="col-sm-4">
          notas:</div>
          <div class="col-sm-8"><input type="text" id="edit_inventario_notas" class="form-control" value="nuevos productos realizados"/>
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
function edit_inventario(producto,sucursal,id_producto,id_sucursal,cantidad){
  //alert("Hola "+id_sucursal+" "+id_producto);
  $('#edit_inventario_cantidad').val('0');
  $('#id_producto').val(id_producto);
  $('#id_sucursal').val(id_sucursal);
  $('#edit_inventario_producto').html(producto);
  $('#edit_inventario_sucursal').html(sucursal);
  $('#label_traslado').html('maxima cantidad['+cantidad+']');
  $('#id_cantidad').val(cantidad);
  $('#edit_inventario_notas').val('');
}
function verOpciones(){

  option=$('#opcion_inventario').val();
  if(option==3){
    $('#traslado').show();
  }else{
    $('#traslado').hide();
  }
}
function cambiarDatosTabla(){

  id_pro=$('#id_producto').val();
  cant_max= parseInt($('#id_cantidad').val());

  cant=parseInt($('#edit_inventario_cantidad').val());
  id_sucur_origen=$('#id_sucursal').val();
  tipo=$('#opcion_inventario').val();
  id_sucur_destino=$('#id_sucursal').val();
  nota=$('#edit_inventario_notas').val();
  option=$('#opcion_inventario').val();
  sw=true;
  //notas=(notas.split(",")).join(".");

  if(cant<1){
    alert('Ingrese una cantidad valida');
    sw=false;
  }
  if(option==3){
    id_sucur_destino=$('#select_sucursal').val();
    if(id_sucur_destino==id_sucur_origen){
      sw=false;
      alert('Error,el destino debe ser diferente al origen');
    }
    var cant_limite=1*cant_max-1;
    if(cant>cant_limite){
      sw=false;
      alert('Error,la cantidad de traslado no puede superar al existente');
    }else{

      //alert('es meno a 25');
    }

  }else{
    $id_sucur_origen='';
    if(option==2){
      if(cant>cant_max){
        sw=false;
        alert('Error,la cantidad de remover no puede superar al existente');
      }
    }
  }


  if(sw){

    $.ajax({
      url: '<?=base_url()?>inventario/reposicion_inventario',
      dataType: 'json',
      type: 'post',
      data: {'id_producto':id_pro, 'cantidad': cant,'id_sucursal_destino':id_sucur_destino,'id_sucursal_origen':id_sucur_origen,
           'tipo':tipo,'nota':nota},
      //processData: false,
      success: function( data, textStatus, jQxhr ){

          //data= JSON.stringify( data );
          //alert(data.result);
        if(data.result==true){

          $('#data_table').DataTable().ajax.reload();
          valor1=document.getElementById('lb_cant'+id_sucur_destino).innerHTML;
          valor2=document.getElementById('lb_cant'+id_sucur_origen).innerHTML;

          if(tipo==1){
            valor1=parseInt(valor1)+0+parseInt(cant);
            document.getElementById('lb_cant'+id_sucur_destino).innerHTML=valor1;
          }else if(tipo==2){
            valor1=parseInt(valor1)+0-parseInt(cant);
            document.getElementById('lb_cant'+id_sucur_destino).innerHTML=valor1;
          }else{

          }

        }
      },
      error: function( jqXhr, textStatus, errorThrown ){
          //console.log( errorThrown );
          alert("falla");
      }
  });

  }


}
</script>
