
<div class="container">

<?php

//print_r($venta);
//print_r($detalle_venta);
      $attributtes=' id="ventas_formvc" ';
      echo form_open('ventas/ventas_print',$attributtes);
?>




<div class="panel panel-default">
  <div class="panel-body">
  <h3 class="text-center">NOTA VENTA</h3>
  <?php  echo'<input type="hidden" name="id_venta" value="'.$venta['id'].'" />';?>
  <div class="row">
  <div class="col-sm-offset-8 col-sm-4">Nro:=<?php
  echo $venta['id'];
  $linea1='Nro: '.$venta['id'];?>  </div>
  </div>
  <div class="row">
    <div class="col-sm-8">Descripcion:=<?php echo $venta['id'];
    $linea2='Descripcion: '.$venta['id'];
    ?> </div>
    <div class="col-sm-4">Fecha:=<?php echo $venta['fecha'];
    $linea3='Fecha: '.$venta['fecha'];?></div>
  </div>
  <div class="row">
    <div class="col-sm-8">Cliente: <?php echo $cliente['nombres'];
    $linea4='Cliente: '.$cliente['nombres']; ?> </div>
    <div class="col-sm-4">Ci: <?php echo $cliente['ci'];
    $linea5='Ci/Nit: '.$cliente['ci'];?> </div>
  </div>
  <div class="row">
  <table class="table">
    <thead>
      <tr>
        <th>Nro</th>
        <th>Producto</th>
        <th>Cantidad</th>
        <th>Precio</th>
      </tr>
    </thead>
    <tbody>



  <?php
  foreach ($detalle_venta as $detalle) {

    echo"<tr>";
    echo '<td>'.$detalle['orden'].'</td><td>'.$detalle['nombre'].'</td><td>'.$detalle['cantidad'].'</td><td>'.$detalle['precio'].'</td>';
     echo"</tr>";
  }
  ?>
  </tbody>
  </table>

  </div>
  <div class="row">
  <div class="col-sm-offset-9 col-sm-3">
    <p class>Total: <?php echo $venta['total'];?></p>
  </div>
  </div>
  <div class="row">
      <div class="col-sm-offset-3 col-sm-4 text-center">
      <a href="<?=$ventas?>" class="btn btn-info" role="button">Volver a Ventas</a>
      <button type="submit" name="butt_imprimir_venta" value="ok" class="btn btn-info">Imprimir Factura</button>
      </div>
  </div>
  </div>
</div>

<?php
/*  error_reporting(E_ALL);

  $handle = printer_open('Canon MP280 series Printer');
  //echo $handle." Fin <p>";
  if($handle){
    printer_set_option($handle, PRINTER_MODE, 'RAW');
    printer_start_doc($handle);
    printer_start_page($handle);
    $linea0 = 'NOTA DE VENTA';

    $font = printer_create_font('Arial', 150, 80, 700, false, false, false, 0);
    printer_select_font($handle, $font);
    printer_draw_text($handle, $linea0, 150, 50);

    $font = printer_create_font('Arial', 90, 50, 100, false, false, false, 0);
    printer_select_font($handle, $font);
    printer_draw_text($handle, $linea1, 150, 250);
    printer_draw_text($handle, $linea2, 150, 350);
    printer_draw_text($handle, $linea3, 150, 450);
    printer_draw_text($handle, $linea4, 150, 550);
    printer_draw_text($handle, $linea5, 150, 650);
    $dx=0;
    foreach ($detalle_venta as $detalle) {
      $dx=$dx+10;
      $linea6='->'.$detalle['orden'].' '.$detalle['nombre'].' '.$detalle['cantidad'].''.$detalle['precio'].' ';
      printer_draw_text($handle, $linea6, 150, 650+$dx);
    }
    printer_draw_text($handle,'Monto Total:'.$venta['total'], 150, 650);


    printer_delete_font($font);
    printer_end_page($handle);
    printer_end_doc($handle);
    printer_close($handle);
    echo 'Impresion exitosa.';
  }else{
    echo 'No se pudo conectar a la impresora.';
  }
  */
?>

<?php echo form_close(); ?>
</div>
