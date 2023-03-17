
</section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<footer class="main-footer no-print">
  <div class="pull-right hidden-xs">
    <b>Version</b> 2.5.0
  </div>
  <strong>Copyright &copy;<?=EMPRESA?> <a href="https://adminlte.io">Kitsoft</a>.</strong> All rights
  reserved.
</footer>
<!-- Control Sidebar -->
<aside class="control-sidebar control-sidebar-dark">
  <!-- Create the tabs -->
  <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
    <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
  </ul>
  <!-- Tab panes -->
  <div class="tab-content">

    <!-- Stats tab content -->
    <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
    <!-- /.tab-pane -->
    <!-- Settings tab content -->
    <div class="tab-pane" id="control-sidebar-settings-tab">
      <form method="post" action="<?=base_url()?>seguridad/store_settings_user">
        <h3 class="control-sidebar-heading">Inicio Dashboard</h3>

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Reporte Global Ventas
            <input type="checkbox" value="1" name='ventas_statistics' id='ventas_statistics' class="pull-right">
          </label>

          <p>
            Mostrando Reporte de 6 meses de ventas: contado, credito, pedidos y consignaciones

          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Lista Pedidos Pendientes
            <input type="checkbox" value="1" name='pedidos_vigentes' id='pedidos_vigentes' class="pull-right">
          </label>

          <p>
            Listado de los pedidos pendientes ordenados por prioridad
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Top de Productos vendidos
            <input type="checkbox" value="1" name='productos_top' id='productos_top'class="pull-right">
          </label>

          <p>
            Mostrando los productos mas vendidos en los ultimo meses
          </p>
        </div>
        <!-- /.form-group -->

        <div class="form-group">
          <label class="control-sidebar-subheading">
            Estadisticas Usuario
            <input type="checkbox" value="1" name='usuarios_statistics' id='usuarios_statistics'class="pull-right">
          </label>

          <p>
            Mostrando estaditicas
          </p>
        </div>
        <div class="form-group">
          <button type="submit" name="butt_settings_user" value="ok" class="btn btn-block btn-default">Guardar</button>
        </div>


      </form>
    </div>
    <!-- /.tab-pane -->
  </div>
</aside>
<!-- /.control-sidebar -->
<!-- Add the sidebar's background. This div must be placed
     immediately after the control sidebar -->
<div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->
<!-- jQuery 3 -->
<script src="<?=base_url()?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>assets/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- SlimScroll -->
<script src="<?=base_url()?>assets/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>assets/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url()?>assets/adminlte/dist/js/panel_configuracion.js"></script>
<?php
if(isset($js_files))
foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<?php
//-------------COMPONENTES-----------------------------
/////////////////////////////////////////////////////////
if (isset($datetimepicker)){
echo '<script type="text/javascript" src="//code.jquery.com/jquery-2.1.1.min.js"></script>'."\n";
echo '<script src="'.base_url().'assets/js/locales.js"></script>'."\n";
echo '<script src="//cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/e8bddc60e73c1ec2475f827be36e1957af72e2ea/src/js/bootstrap-datetimepicker.js"></script>'."\n";
}
if (isset($datepicker)){
echo '<script src="'.base_url().'assets/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>'."\n";
echo '<script src="'.base_url().'assets/adminlte/bower_components/bootstrap-datepicker/js/locales/bootstrap-datepicker.es.js"></script>'."\n";
}
if (isset($timepicker)){
echo '<script src="'.base_url().'assets/adminlte/plugins/timepicker/bootstrap-timepicker.min.js"></script>'."\n";
}
if (isset($daterangepicker)){
echo '<script src="'.base_url().'assets/adminlte/bower_components/moment/min/moment.min.js"></script>';
echo '<script src="'.base_url().'assets/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>';
}

if (isset($chart_line)){
echo '<script src="'.base_url().'assets/adminlte/bower_components/chart.js/Chart2.js"></script>';
}
if(isset($datatable)){
echo '<script src="'.base_url().'assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>';
echo '<script src="'.base_url().'assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>';
}

if(isset($msdropdown)){
?>
<script src="<?=base_url()?>assets/msdropdown/js/jquery/jquery-1.9.0.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/msdropdown/js/msdropdown/jquery.dd.js" type="text/javascript"></script>
<script>
$("#tech").msDropdown().data("dd");//{animStyle:'none'} /{animStyle:'slideDown'} {animStyle:'show'}
$("#tech").msDropdown({width:'200'});
</script>
<?php
}

//-----------------------END COMPONENTES--------------

//----------------------INICIALIZAR DATAS--------------------------
//Initialize Select2 Elements
if (isset($select2)){
echo "<script>";
  echo "$('.select2').select2();";
echo "</script>";
}
if (isset($timepicker)){
//Timepicker
echo "<script>";
echo "\n"."$('.timepicker').timepicker({";
echo ' showInputs: false,';
echo " showMeridian: false,";
echo " showSeconds: false";
echo '    });'."\n";
echo "</script>";
}
if(isset($producto_inicial)){
    //---Cargar Info Producto Inicial
echo "<script>";
echo' obtenerInfoProducto(document.getElementById("select_producto").value);'."\n";
echo "</script>";
}
if (isset($data_table_source)){
  echo "<script>";
  echo "$('#data_table').DataTable( {";
  echo '   "ajax": '."'".base_url().$data_table_source."'";
  //echo '  "serverSide": true,';
  //echo  ' "processing": true';
  echo '   } );';
  echo "</script>";
}
if(isset($datepicker)){?>
<script>
//Date picker
 $('#datepicker').datepicker({
   format: 'yyyy-mm-dd',
   language: 'es',
   autoclose: true,

 }).datepicker("setDate", new Date());
 //Date picker
  $('#datepicker2').datepicker({
      format: 'yyyy-mm-dd',
      language: 'es',
      autoclose: true,

    }).datepicker("setDate", new Date());
//Date picker
 $('#datepicker3').datepicker({
     format: 'yyyy-mm-dd',
     language: 'es',
     autoclose: true,

   }).datepicker("setDate", new Date());
   //Date picker
    $('#datepicker4').datepicker({
        format: 'yyyy-mm-dd',
        language: 'es',
        autoclose: true,

      }).datepicker("setDate", new Date());
      $('#datepicker5').datepicker({
          format: 'yyyy-mm-dd',
          language: 'es',
          autoclose: true,

        }).datepicker("setDate", new Date());

</script>
<?php
}
if(isset($clientename)){
  ?>
  <script>

  $('#clientename').select2({
    ajax: {
      //url: "https://api.github.com/search/repositories",
      url: "<?=base_url()?>clientes/listar_clientes_select",
      dataType: 'json',
      delay: 250,
      allowClear: true,
      data: function (params) {
        return {
          q: params.term, // search term
          page: params.page
        };
      },
      processResults: function (data, params) {
        // parse the results into the format expected by Select2
        // since we are using custom formatting functions we do not need to
        // alter the remote JSON data, except to indicate that infinite
        // scrolling can be used
        params.page = params.page || 1;
        //alert(JSON.stringify(data));
        return {
          results: data.items,
          pagination: {
            more: (params.page * 30) < data.total_count
          }
        };
      },
      cache: true
    },
    placeholder: 'Nombre de Cliente',
    //escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
    minimumInputLength: 3,
    //templateResult: formatRepo,
    templateSelection: formatRepoSelection
  });

  function formatRepoSelection (repo) {
    //return repo.full_name || repo.text;
    $('#id_cliente').val(repo.id);
    //$('#nombre_cliente').val(repo.text);
    //------mostrando imagen--
    if (typeof repo.foto != "undefined")
    if ( $("#img_fotografia_cliente").length>0) {
        // hacer algo aquí si el elemento existe
        $("#img_fotografia_cliente").attr("src","<?=base_url()?>assets/img/fotografias/"+repo.foto);
    }
    <?php
      if(isset($gestionar_cliente)){
    ?>
      $('#edit_nombre').val(repo.text);
      $('#edit_direccion').val(repo.direccion);
      $('#butt_nuevo').hide();
      $('#butt_modificar').show();
    <?php
      }
    ?>
    return repo.text;
  }

  </script>
  <?php
}

?>

<?php
///////////////////////////////////////////////////////////////
//---------------------------COMPONENTES--------------------//
/*****************************************************************************/
///////////////////////////////////////////////////////////////////////////////
//---------------------CHART------------------OPT[lINE]
if(isset($chart_line)){
?>
<script>
$(document).ready(function () {

  window.chartColors = {
  	red: 'rgb(255, 99, 132)',
  	orange: 'rgb(255, 159, 64)',
  	yellow: 'rgb(255, 205, 86)',
  	green: 'rgb(75, 192, 192)',
  	blue: 'rgb(54, 162, 235)',
  	purple: 'rgb(153, 102, 255)',
  	grey: 'rgb(201, 203, 207)'
  };
  <?php
  $arr_color_name=array('red','blue','yellow','orange','yellow','green','blue','purple','gray');
  ?>
  var config = {
    type: 'line',
    data: {
      labels: [<?=$chart_line['labels']?>],
      datasets: [
        <?php $i=0;
          foreach ($chart_line['data'] as $key => $value):
          if($i>0)
          echo  ',';
          ?>

        {
        label: '<?=$key?>',
        backgroundColor:window.chartColors.<?=$arr_color_name[$i]?> ,
        borderColor:    window.chartColors.<?=$arr_color_name[$i]?>,
        data: [
         <?=$value?>
        ],
        fill: false,
      }
        <?php
          $i++;
          endforeach;
        ?>

    ]
    },
    options: {
      responsive: true,
      title: {
        display: false,
      },
      tooltips: {
        mode: 'index',
        intersect: false,
      },
      hover: {
        mode: 'nearest',
        intersect: true
      },
      scales: {
        xAxes: [{
          display: true,
          scaleLabel: {
            display: false,
            labelString: 'Mes'
          }
        }],
        yAxes: [{
          display: true,
          scaleLabel: {
            display: true,
            labelString: 'Cantidad'
          }
        }]
      }
    }
  };
  //-------------
  //- LINE CHART -
  //--------------
  var lineChartCanvas          = $('#lineChart').get(0).getContext('2d');
  var lineChart                = new Chart(lineChartCanvas,config);



});
</script>
<?php
}
?>
<script>

<?php
if (isset($link_active)){

echo'var url2="'.base_url().$link_active.'";';
?>
$('.treeview-menu li a[href="' + url2 + '"]').parent().addClass('active');
//$('.treeview-menu li a[href="' + url2 + '"]').parent().addClass('menu-open');
// Will also work for relative and absolute hrefs
$('.treeview-menu li a').filter(function() {
  return this.href == url2;
}).parent().parent().parent().addClass('active menu-open');
<?php
}else{
  ?>
  var url = window.location;
    // Will only work if string in href matches with location
   $('.treeview-menu li a[href="' + url + '"]').parent().addClass('active');
   // Will also work for relative and absolute hrefs
   $('.treeview-menu li a').filter(function() {
     return this.href == url;
   }).parent().parent().parent().addClass('active');

  <?php
}
?>
function guardar_configuracion(){

  var opt1=0;
  var opt2=0;
  var opt3=0;
  var opt4=0;

  var skin ='';
  if (typeof (Storage) !== 'undefined') {
      skin=localStorage.getItem('skin');
  };
  if(document.getElementById("panel_check_1").checked)
  opt1=1;
  if(document.getElementById("panel_check_2").checked)
  opt2=1;
  if(document.getElementById("panel_check_3").checked)
  opt3=1;
  if(document.getElementById("panel_check_4").checked)
  opt4=1;

  $.ajax({
    url: '<?=base_url()?>seguridad/store_settings_user',
    dataType: 'json',
    type: 'post',
    //contentType: 'application/json',
    data: {'top_panel':opt1, 'left_panel': opt2,'right_panel':opt3,'fullscreen':opt4,'skin':skin},
    //processData: false,
    success: function( data, textStatus, jQxhr ){
        //$('#response pre').html( JSON.stringify( data ) );

        if(data.estado==false){
        alert("No se pudo guardar la configuracion");
      }else{
        alert("OK, se ha guardado su configuracion");

      }
    },
    error: function( jqXhr, textStatus, errorThrown ){
        //console.log( errorThrown );
        alert("falla");
    }
    });

}
var mySkins = [
    'skin-blue',
    'skin-black',
    'skin-red',
    'skin-yellow',
    'skin-purple',
    'skin-green',
    'skin-blue-light',
    'skin-black-light',
    'skin-red-light',
    'skin-yellow-light',
    'skin-purple-light',
    'skin-green-light'
];
$( document ).ready(function() {
  //-- Default Settings---
<?php
      $setting=$_SESSION['settings_user'];
  ?>
  var opt1='<?=$setting['top_panel']?>';
  var opt2='<?=$setting['left_panel']?>';
  var opt3='<?=$setting['right_panel']?>';
  var opt4='<?=$setting['fullscreen']?>';
  var skin='<?=$setting['skin']?>';

  var $pushMenu = $('[data-toggle="push-menu"]').data('lte.pushmenu')
  var $controlSidebar = $('[data-toggle="control-sidebar"]').data('lte.controlsidebar')
  var $layout = $('body').data('lte.layout')


 if(opt1==1){
  document.getElementById("panel_check_1").click();
 }
 if(opt2==1){
    document.getElementById("panel_check_2").click();
 }
 if(opt3==1){
    document.getElementById("panel_check_3").click();
 }
 if(opt4==1){
   document.getElementById("panel_check_4").click();
 }
  if(skin!=''){
    $.each(mySkins, function (i) {
        $('body').removeClass(mySkins[i]);
    });

    $('body').addClass(skin);
    if (typeof (Storage) !== 'undefined') {
        localStorage.setItem('skin',skin);
    } else {
        window.alert('Por favor use un navegadro mas moderno ej: Firefox !');
    }
  }
  if(<?=$setting['ventas_statistics']?>==1){
    document.getElementById("ventas_statistics").checked=true;
  }
  if(<?=$setting['usuarios_statistics']?>==1){
    document.getElementById("usuarios_statistics").checked=true;
  }
  if(<?=$setting['productos_top']?>==1){
    document.getElementById("productos_top").checked=true;
  }
  if(<?=$setting['pedidos_vigentes']?>==1){
    document.getElementById("pedidos_vigentes").checked=true;
  }

  //document.getElementById("panel_check_4").checked=opt4;
       //alert( "document loaded" );


   });
</script>
</body>
</html>
