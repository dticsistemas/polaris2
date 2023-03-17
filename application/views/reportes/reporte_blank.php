<?php
if (!isset($title))
 $title='no existe title';

if (!isset($titulo))
 $titulo='no existe ';

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

<!-- Main content -->
   <section class="invoice">
   <!-- title row -->
   <div class="row">
     <div class="col-xs-12">
       <h2 class="page-header">
        <?=EMPRESA?>
         <?php
           if (isset($title_crud))
           echo " - ".$title_crud;

         ?>
         <small class="pull-right">Fecha: <?php echo date("d/m/Y H:i:s");?></small>
       </h2>
     </div>
     <!-- /.col -->
   </div>
   <!-- info row -->

 <?php
if (isset($array_head)){
 ?>
 <div class="box-body no-padding">
            <table class="table">
              <tbody><tr>
                <?php
                 foreach ($array_head as $value) {
                   echo '<th style="width: 10px">'.$value.'</th>';
                 }
                 echo '</tr>';
                 foreach ($array_data as $data) {
                   echo '<tr>';

                   foreach ($data as $val) {

                     echo '<td>'.$val.'</td>';
                   }
                   echo '</tr>';
                 }
                 ?>
            </tbody></table>
          </div>
          <!-- /.box-body -->
        </div>
        ?><?php
}

 ?>


   </section>
   <!-- /.content -->
   <div class="clearfix"></div>
