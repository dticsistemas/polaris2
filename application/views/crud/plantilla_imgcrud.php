
<?php foreach($js_files as $file): ?>
	<script src="<?php echo $file; ?>"></script>
<?php endforeach; ?>

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
      <div class="row invoice-info">

       <div class="col-sm-12 invoice-col">
       <?php
          if(isset($extra_html)){
          echo $extra_html;
          }
        ?>
	     <?php echo $output; ?>
       </div>
	  </div>

    </section>
    <!-- /.content -->
    <div class="clearfix"></div>
