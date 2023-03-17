<div class="row">
  <div class="col-md-10 col-md-offset-1">
          <!-- DIRECT CHAT PRIMARY -->
          <div class="box ">
            <div class="box-header with-border">
              <h3 class="box-title">Mensajes</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <div class="row">
                <div class="col-md-7 col-md-offset-1">
              <div class="">
                <!-- Conversations are loaded here -->
                <?php
                foreach ($arr_mensajes as $mensaje){
                //  var_dump($mensaje);
                  $id_remitente=$mensaje['id_remitente'];
                  $mss=$mensaje['mensaje'];
                  $fecha=$mensaje['fecha'];
                //  echo $fecha."<br>";
                  $fecha=date('Y-M-d H:i',strtotime($fecha));
                  //$fecha=strftime('%Ba',$fecha);


                  $date = new DateTime($fecha);
                  //echo $date->format('D, d M y H:i');
                  if($id_remitente==$id_usuario){
                    $aux='';
                    if($mensaje['estado']=='pendiente')
                    $aux='direct-chat';
                  ?>
                  <!-- Message. Default to the left -->
                  <div class="direct-chat-msg ">
                    <div class="direct-chat-info clearfix">
                      <span class="direct-chat-name pull-left"><?=$mensaje['remitente'].' - <i class="fa fa-user text-'.$mensaje['estilo'].'"> '.$mensaje['destinatario'].'</i>'?></span>
                      <?php if($mensaje['estado']=='pendiente')
                      echo '<i class="pull-right text-aqua fa fa-exclamation-circle"></i>';
                      ?>;
                      <span class="direct-chat-timestamp pull-right"><?=' '.$fecha.' '?>&nbsp;</span>
                    </div>
                    <!-- /.direct-chat-info -->
                    <img class="direct-chat-img" src="<?=base_url().'assets/img/fotografias/'.$mensaje['avatar_remitente']?>" alt="Message User Image"><!-- /.direct-chat-img -->
                    <div class="direct-chat-text <?=$aux?>">
                      <?=$mss?>
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <?php
                }else{
                  ?>
                  <!-- Message to the right -->
                  <div class="direct-chat-msg direct-chat<?='-'.$mensaje['estilo']?> right">
                    <div class=" clearfix">
                      <span class="direct-chat-name pull-right"><?=$mensaje['remitente']?></span>
                      <?php if($mensaje['estado']=='pendiente')
                      echo '<i class="pull-left text-green fa fa-check-circle-o"></i>';
                      ?>;
                      <span class="direct-chat-timestamp pull-left">&nbsp;<?=$fecha?> </span>
                    </div>
                    <!-- /.direct-chat-info -->
                    <img class="direct-chat-img" src="<?=base_url().'assets/img/fotografias/'.$mensaje['avatar_remitente']?>" alt="Message User Image"><!-- /.direct-chat-img -->

                    <div class="right">
                      <div class="direct-chat-text">
                      <?=$mss?>
                    </div>
                    </div>
                    <!-- /.direct-chat-text -->
                  </div>
                  <?php
                }
              } ?>

                <!-- /.direct-chat-msg -->

                <!-- /.direct-chat-msg -->
              </div>
            </div>
              <!--/.direct-chat-messages-->
            <div class="col-sm-4">
              <h3>  <!-- User image -->
                <ul>
                <div class="user-header text-center">
                  <img src="<?=base_url()?>assets/img/fotografias/<?=$_SESSION['fotografia']?>" class="img-circle" alt="User Image">

                  <p>
                    <?=$_SESSION['username']?> <br>
                    <?php echo $_SESSION['grupo'] ;?><br>
                    <small><?php setlocale(LC_TIME, 'spanish'); echo strftime('%d de %B del %Y',strtotime($_SESSION['create_user']));?></small>
                  </p>
                </div>
              </ul>
              </h3>
            </div>

              <!-- /.direct-chat-pane -->
            </div>
            <!-- /.box-body -->
            <div class="box-footer">

              <form action="<?=base_url()?>administracion/mensajes" method="post">
              <div class="row">
              <div class="col-sm-2 text-right">
                <b>Usuario</b>
              </div>
              <div class="col-sm-2">
                <?php
                  echo form_dropdown('id_destinatario', $combox_usuario,0,'id="select_vendedor" class="form-control select2 select2-hidden-accessible" style="width: 100%;" tabindex="-1" aria-hidden="true" ' );
                 ?>
              </div>
              <div class="col-sm-7">
                <div class="input-group">
                  <input type="text" name="message" placeholder="Escriba Mensage ..." class="form-control">
                      <span class="input-group-btn">
                        <button type="submit" name='butt_mensaje' value='ok' class="btn btn-success btn-flat">Enviar</button>
                      </span>
                </div>
            </div>
            </div>

          </form>
            </div>
            <!-- /.box-footer-->
          </div>
          <!--/.direct-chat -->
        </div>
</div>
