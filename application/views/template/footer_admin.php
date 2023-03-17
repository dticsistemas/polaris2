 </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <footer class="main-footer">
    <div class="pull-right hidden-xs">
      <b>Version</b> 2.2.5
    </div>
    <strong><?=EMPRESA?> <a href="https://kitsoft.com.bo"> KitSoft-Desarrollo</a>.</strong>
    <?=TITLE?>.
  </footer>


</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->
<script src="<?=base_url()?>assets/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="<?=base_url()?>assets/adminlte/bower_components/bootstrap/dist/js/bootstrap.js"></script>
<!-- SlimScroll -->
<script src="<?=base_url()?>assets/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="<?=base_url()?>assets/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- AdminLTE App -->
<script src="<?=base_url()?>assets/adminlte/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?=base_url()?>assets/adminlte/dist/js/demo.js"></script>

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
if(isset($select2)){
echo '<script src="'.base_url().'assets/adminlte/bower_components/select2/dist/js/select2.full.min.js"></script>';
}

if (isset($chart_line)){
echo '<script src="'.base_url().'assets/adminlte/bower_components/chart.js/Chart2.js"></script>';
}
//-----------------------END COMPONENTES--------------
///////////////////////////////////////////////////////////////
if (isset($charts)){
echo '<script src="'.base_url().'assets/adminlte/bower_components/raphael/raphael.min.js"></script>';
echo '<script src="'.base_url().'assets/adminlte/bower_components/morris.js/morris.min.js"></script>';

}
if(isset($js_files))
foreach($js_files as $file): ?>
<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>
<?php
if(isset($datatable)){
?>
<script src="<?=base_url()?>assets/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?=base_url()?>assets/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<?php
}
?>


<script>
  $(document).ready(function () {
    var url = window.location;
      // Will only work if string in href matches with location
     $('.treeview-menu li a[href="' + url + '"]').parent().addClass('active');
     // Will also work for relative and absolute hrefs
     $('.treeview-menu li a').filter(function() {
       return this.href == url;
     }).parent().parent().parent().addClass('active');
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
}
if(isset($producto_inicial)){
    //---Cargar Info Producto Inicial
  echo' obtenerInfoProducto(document.getElementById("select_producto").value);'."\n";

  }
if (isset($data_table_source)){
  echo "$('#data_table').DataTable( {";
  echo '   "ajax": '."'".base_url().$data_table_source."'";
  //echo '  "serverSide": true,';
  //echo  ' "processing": true';
  echo '   } );';
}
if (isset($timepicker)){
//Timepicker
echo "\n"."    $('.timepicker').timepicker({";
echo ' showInputs: false,';
echo " showMeridian: false,";
echo " showSeconds: false";
echo '    });'."\n";
}
?>
$('#fecha').datetimepicker({
    defaultDate: "<?php echo(strftime( "%Y/%m/%d %H:%M", time() ));?>",
    format:"YYYY-MM-DD HH:mm",
    sideBySide:true,
    ignoreReadonly:true,
    showTodayButton:true,
    locale: 'es'
});
$('.sidebar-menu').tree();
 });


</script>

<script type="text/javascript">
   <?php
 //Date range picker
  if (isset($daterangepicker)){ ?>
    $('#reservation').daterangepicker({
    locale: {
            format: 'DD/MM/YYYY'
            }
    });

    <?php
  }
  ?>
  //Initialize Select2 Elements
    $('.select2').select2();
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

<?php

if(isset($eventual)){

echo ' $(document).ready(function()';
echo '{';
echo '$( ".datepicker-input" ).datepicker( "option", "minDate", "'.date('d/m/Y').'" );';
echo '});';
}

?>



</script>
<?php
if(isset($msdropdown)){
?>
<script src="<?=base_url()?>assets/msdropdown/js/jquery/jquery-1.9.0.min.js" type="text/javascript"></script>
<script src="<?=base_url()?>assets/msdropdown/js/msdropdown/jquery.dd.js" type="text/javascript"></script>
<script>
$("#tech").msDropdown().data("dd");//{animStyle:'none'} /{animStyle:'slideDown'} {animStyle:'show'}
$("#tech").msDropdown({width:'200'});
</script>
<?php
}if(isset($clientename)){
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
  $('#nombre_cliente').val(repo.text);
  return repo.text;
}

</script>
<?php
}
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
}//-----End Chart Line
?>
<script language="JavaScript">
function fullScreen() {
  if ((document.fullScreenElement && document.fullScreenElement !== null) ||    // metodo alternativo
    (!document.mozFullScreen && !document.webkitIsFullScreen)) {               // metodos actuales
  if (document.documentElement.requestFullScreen) {
    document.documentElement.requestFullScreen();
  } else if (document.documentElement.mozRequestFullScreen) {
    document.documentElement.mozRequestFullScreen();
  } else if (document.documentElement.webkitRequestFullScreen) {
    document.documentElement.webkitRequestFullScreen(Element.ALLOW_KEYBOARD_INPUT);
  }
} else {
  if (document.cancelFullScreen) {
    document.cancelFullScreen();
  } else if (document.mozCancelFullScreen) {
    document.mozCancelFullScreen();
  } else if (document.webkitCancelFullScreen) {
    document.webkitCancelFullScreen();
  }
}

}
// End -->
</script>
</body>
</html>
