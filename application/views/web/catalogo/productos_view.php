<div class="container">

<div class="panel panel-primary">
  <div class="panel-heading text-center">
    <h2>
        Productos - Listado de Productos
    </h2>
  </div>
  <div class="panel-body">
    <?php

    $attributes = array('class' => 'form-inline', 'id' => 'myform');

    $options_categorias = array(0 => "all");
    foreach ($categorias as $row)
    {
      $options_categorias[$row['id']] = $row['nombre'];
    }
    //save the columns names in a array that we will use as filter
    $options_productos = array();
    $options_productos['productos.id'] = 'ID';
    $options_productos['productos.nombre'] = 'Nombre';
    $options_productos['productos.descripcion'] = 'Descripcion';



      echo form_open('productos/listar', $attributes);
      echo form_label('Valor:', 'search_string','class="form-control"');
      echo form_input('search_string', $search_string_selected, 'class="form-control" maxlength="20" ');
      echo form_label('Categoria:', 'categoria_id','class="form-control"');
      echo form_dropdown('categoria_id', $options_categorias, $categoria_selected,'class="form-control" ');
      echo form_label('Ordenar por:', 'order','class="form-control"');
      echo form_dropdown('order', $options_productos, $order,'class="form-control"');

      $data_submit = array('name' => 'mysubmit', 'class' => 'btn btn-primary form-control', 'value' => 'Buscar');

      $options_order_type = array('Asc' => 'Asc', 'Desc' => 'Desc');
      echo form_dropdown('order_type', $options_order_type, $order_type_selected, 'class="form-control"');
      echo form_submit($data_submit);
      echo form_close();

    ?><!---Formulario de busqueda -->






    <div class="table_productos_listar">
      <?php if(isset($count_products))
      if($count_products>0){ ?>

      <div class="alert alert-success">Se ha encontrado <?php echo $count_products;?> productos
      </div>
    <table  class="table table-condensed table-hover table-striped table-bordered">
        <thead>
            <tr role="row">
              <th>ID</th>
              <th>Imagen</th>
              <th>Producto</th>
              <th>Descripcion</th>
              <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
                <?php
                $img_cont=0;

              foreach($productos as $row)
              {
                $imagen=$imagen_productos[$img_cont];
                $nombre_imagen= $imagen['imagen'];
                $descripcion_imagen = $imagen['descripcion'];
                $img_cont++;

              	$descripcion = substr($row['descripcion'],0,150)."...";
                echo '<tr>';
                echo '<td>'.$row['codigo'].'</td>';
                echo '<td><img src="'.base_url()."assets/img/catalogo/thumbs/";
                echo $nombre_imagen.'" alt="producto '.$row['id'].'" class="img-responsive" />';
                echo '</td>';
                echo '<td>'.$row['nombre'].'</td>';
                echo '<td>'.$descripcion.'</td>';

                echo '<td class="crud-actions">
                  <a href="'.site_url("productos").'/detalle/'.$row['id'].'" class="btn btn-info">ver Detalle</a>';
                  if(CARRITO){
                  echo '<button onclick="agregarCarrito('.$row['id'].')" class="btn btn-default" role="button"><i class="glyphicon glyphicon-shopping-cart"></i> +</button>';
                  }
                echo '</td>';

                echo '</tr>';
              }
              ?>
        </tbody>
    </table>
    <div >
        <?php echo ($this->pagination->create_links()); ?>
    </div>
    <?php }else {
      echo '<div class="alert alert-danger">'.
      '<h3><p> No se encontraron productos</p></h3></div>';
    }
    ?>
    </div><!-- /.ddiv table -->
  </div>
</div> <!--End panel primary-->
</div> <!--End container-->
