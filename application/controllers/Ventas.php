<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ventas extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false)
          redirect('login');

    }
		public function vista_output($file_view,$output = null)
		{
      //---Enviando datos de inicio
      $data_aux=getScriptsInit();
      $output = (object) $output;
      $output->mensajes=$data_aux['mensajes'];
      $output->notificaciones=$data_aux['notificaciones'];


			$this->load->view('template/header_admin_view', $output);
			$this->load->view($file_view,(array)$output);
			$this->load->view('template/footer_admin_view', $output);

		}
    public function index()
    {
      redirect('ventas/ventas_contado');
    }

    public function productos(){

        $crud = new grocery_CRUD();
        $crud->set_table('productos');
        $crud->set_relation_n_n('categorias', 'categoriaproductos', 'categorias', 'id_producto', 'id_categoria', 'nombre');
        $crud->add_action('Imagenes','../assets/img/upload_image.png', 'admin/editar_imagenes_producto');
        $crud->columns(array('id','codigo','nombre','titulo','subtitulo','precio'));
        $crud->edit_fields(array('codigo','nombre','titulo','precio','categorias'));
        $crud->display_as('subtitulo','Imagen');
        //------Mostrando imagenes del producto
        $crud->callback_column('subtitulo',array($this,'product_imagen_scale_callback'));

        $output = $crud->render();
        $data = json_decode(json_encode($output), True);
        $data['nav']='catalogo';

        $this->_example_output($data);
    }

    function product_imagen_scale_callback($value, $row)
    {
        $this->load->model('imagenes_model');
        $d=$this->imagenes_model->get_imagen_producto($row->id);
        $imagen = base_url()."/assets/img/catalogo/".$d['imagen'];
        return '<div class="text-center"><a href="'.$imagen.'"class="image-thumbnail"><img src="'.$imagen.'" height="50px"></a></div>';

    }
    public function ventas_print(){
        //-----imprimir datos venta----
        $output='';
        $js_files=array(base_url().'assets/grocery_crud/js/jquery-1.11.1.min.js',
            base_url().'assets/bootstrap/js/bootstrap.min.js');
        $css_files=array();
        $data['output']=$output;
        $data['js_files']=$js_files;
        $data['css_files']=$css_files;
        $data['nav']='ventas';
        $modulo='5';//--modulo de ventas
        $data['acciones'] = $this->acciones_model->get_acciones_modulo($modulo);
        $data['settings'] = $this->settings_model->get_setting();
        $settings=$data['settings'];

        if($this->input->post('butt_imprimir_venta')=="ok"){
             $id_venta=$this->input->post('id_venta');
        if($settings['mostrar_venta_realizada']==1){

                $venta=$this->ventas_model->obtener_venta($id_venta);
                $detalle_venta=$this->ventas_model->obtener_detalle_venta($id_venta);

                $id_cliente=$venta['id_cliente'];
                $cliente=$this->clientes_model->get_cliente($id_cliente);
                $data['venta']=$venta;
                $data['detalle_venta']=$detalle_venta;
                $data['cliente']=$cliente;
                $this->_example_output($data,'admin/web/nota_ventas_view.php');
            }
            else{
                redirect('ventas/ventas_contado');

            }
        }     else {
            redirect('ventas/ventas_contado');
        }

    }

    /*public function ventas_contado(){
      //-----registrando ventas al contado para permitir ingreso de horas especificas
      $data['link_active']='ventas/ventas_contado';
      if($this->input->post('butt_vc_procesar')=="procesar"){
          //-----------Datos enviados-------------------
          $id_cliente         =$this->input->post('id_cliente');
          $id_productos       =$this->input->post('array_id_productos');
          $precio_productos   =$this->input->post('array_precio_productos');
          $cantidad_productos =$this->input->post('array_cantidad_productos');
          $cliente_procedencia=$this->input->post('select_procedencia');

          $sexocliente =$this->input->post('optsexocliente');
          $id_sucursal =$this->input->post('id_sucursal_vc');
          $monto_ventas=$this->input->post('monto_ventas_vc');
          $descripcion =$this->input->post('descripcion_vc');
          $id_vendedor =$this->session->userdata('id_persona');
          $array_id_productos=explode(',', $id_productos);
          $array_precio_productos=explode(',',$precio_productos);
          $array_cantidad_productos=explode(',', $cantidad_productos);
          //---------------------
          $this->load->model('ventas_model');
          $this->load->model('inventarios_model');
          $this->load->model('clientes_model');
          $this->load->model('configuracion_model');
          //$settings=$data['settings'];
          //print_r($_POST);
          //---saca del sistema
          $fecha= date('Y-m-d H:i:s');
          //--------caso de  cliente--------
          if($id_cliente==0){
            if($sexocliente='H'){
              $id_cliente=1;
            }
          }
          //--------caso de venta------------
          $data_ventas= array(
              'id_usuario'=>$this->session->userdata('user_id'),
              'fecha'=>$fecha,
              'id_cliente'=>$id_cliente,
              'nota'=>$descripcion,
              'total'=>$monto_ventas,
              'estado'=>FINALIZADA,
              'transferida'=>'',
              'id_vendedor'=>$id_vendedor,
              'id_sucursal'=>$id_sucursal,
              'tipo'=>VENTA_CONTADO
              );
          $id_venta = $this->ventas_model->insertar_ventas($data_ventas);
          //-----caso ventas productos--------
          $i=0;
          foreach ($array_id_productos as $producto_id) {
              $producto_precio = $array_precio_productos[$i];
              $producto_cantidad=$array_cantidad_productos[$i];
              $data_venta_productos = array(
                  'id_venta'=>$id_venta,
                  'id_producto'=>$producto_id,
                  'orden'=>$i+1,
                  'cantidad'=>$producto_cantidad,
                  'precio'=>$producto_precio
                  );
              $this->ventas_model->insert_ventas_productos($data_venta_productos);

              //------caso de stock-------------
              //if($settings['validar_stock']=='1'){
                  //-----descontar los productos
              $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$producto_id,-$producto_cantidad);
            // }

              $i++;
          }

         //-------Una vez realizadaa la venta redireccionar o mostrar

        //  if($settings['mostrar_venta_realizada']==1){
        if(1==1){

              $venta=$this->ventas_model->obtener_venta($id_venta);
              $detalle_venta=$this->ventas_model->obtener_detalle_venta($id_venta);
              $id_cliente=$venta['id_cliente'];
              $cliente=$this->clientes_model->get_cliente($id_cliente);
              $data['venta']=$venta;
              $data['detalle_venta']=$detalle_venta;
              $data['cliente']=$cliente;
              $data['ventas']='ventas_contado';
              $this->vista_output('ventas/nota_ventas_view.php',$data);
          }
          else{
              redirect('ventas/ventas_contado');

          }



      }else{
          //--Mostrando Formulario para realizar Venta Suspendida AL-CONTADO
          $this->load->model('productos_model');
          $this->load->model('sucursales_model');
          $this->load->model('personas_model');
          //---preparando datos para la interfaz
          $productos=$this->productos_model->get_productos_total();
          $sucursales=$this->sucursales_model->listSucursales();
          //$vendedores=$this->personas_model->listVendedores();
          $combox_productos=array();
          foreach ($productos as $fila) {
              $combox_productos[$fila['id']]=$fila['nombre'];
          }
          $data['combox_productos'] = $combox_productos;
          $data['combox_sucursales']=$sucursales;
          //$data['combox_vendedores']=$vendedores;
          $data['producto_inicial']=true;
          $data['id_persona']=$_SESSION['id_persona'];
          $data['nombre_persona']=$_SESSION['nombre_persona'];
          $data['id_sucursal']=$_SESSION['id_sucursal'];
          $data['nombre_sucursal']=$_SESSION['nombre_sucursal'];
          //--habilitando componentes
          $data['select2']=true;
          $data['clientename']=true;
          $this->vista_output('ventas/ventas_contado_view.php',$data);
      }

    }
    */
    public function ventas_suspendidas(){
        //-----registrando ventas al contado para permitir ingreso de horas especificas
				//--a una venta que no ha podido ser ingresada en su momento real

        $data['link_active']='ventas/ventas_suspendidas';
        if($this->input->post('butt_vc_procesar')=="procesar"){
          //var_dump($_POST);
          $arr_id_productos         = explode(',',$this->input->post('array_id_productos'));
          $arr_precio_productos   = explode(',',$this->input->post('array_precio_productos'));
          $arr_cantidad_productos = explode(',',$this->input->post('array_cantidad_productos'));
          $arr_id_clientes   = explode(',',$this->input->post('array_id_clientes'));
          $arr_sexo_clientes = explode(',',$this->input->post('array_sexo_clientes'));
          $arr_vendedores    = explode(',',$this->input->post('array_vendedores'));
          $arr_sucursales    = explode(',',$this->input->post('array_sucursales'));
          $arr_notas         = explode(',',$this->input->post('array_notas'));
          $arr_fechas        = explode(',',$this->input->post('array_fechas'));
          $arr_grupos        = explode(',',$this->input->post('array_grupos'));
          //---------------------
          $this->load->model('ventas_model');
          $this->load->model('inventarios_model');
          $this->load->model('clientes_model');
          $response="";
          $data['success']="Se ha registrado las ventas Suspendidas !!!";
          //$settings=$data['settings'];

          $cantidad_ventas=count($arr_id_productos);
          $i=0;
          $response=$response.'<p class="lead">Procesando cantidad = '. $cantidad_ventas." ventas suspendidas</p>";
          while ($i < $cantidad_ventas) {

            $id_producto=$arr_id_productos[$i]; // id del producto
            $cant_producto=$arr_cantidad_productos[$i];
            $fecha=$arr_fechas[$i];
            $id_cliente=$arr_id_clientes[$i];
            $sexo=$arr_sexo_clientes[$i];
            $descripcion=$arr_notas[$i];
            $monto_ventas=$arr_precio_productos[$i];
            $id_vendedor=$arr_vendedores[$i];
            $id_sucursal=$arr_sucursales[$i];
            $monto_final=0;
            //--------caso de cliente
            if($id_cliente==0){
              $id_cliente=CLIENTE_NN_MUJER; // por defecto
              if($sexo=='H')
              $id_cliente=CLIENTE_NN_HOMBRE;
            }
            //--------caso de venta------------
            $data_ventas= array(
                'id_usuario'=>$this->session->userdata('user_id'),
                'fecha'=>$fecha,
                'id_cliente'=>$id_cliente,
                'nota'=>$descripcion,
                'total'=>$monto_ventas,
                'estado'=>'',
                'transferida'=>'',
                'id_vendedor'=>$id_vendedor,
                'id_sucursal'=>$id_sucursal,
                'tipo'=>VENTA_SUSPENDIDA_CONTADO
                );

            $id_venta = $this->ventas_model->insertar_ventas($data_ventas);
            //----procesando cada venta-productos registrada

            $id_grupo=$arr_grupos[$i];
            if($id_grupo!=0){//---si perteneces a una venta agrupada
              $response=$response.'<div class="post"><span class="username">procesando venta agrupada cod['.$id_grupo."]</span><p><ol>";
              $orden=0;
              while ($id_grupo==$arr_grupos[$i] & $i < $cantidad_ventas){
                $orden++;
                //---sacando los datos del item pertenciente al grupo
                $id_producto=$arr_id_productos[$i]; // id del producto
                $cant_producto=$arr_cantidad_productos[$i];
                $cant_producto=$arr_cantidad_productos[$i];
                $monto_ventas=$arr_precio_productos[$i];
                $monto_final=$monto_final+$monto_ventas;

                $response=$response."<li>venta de ID=".$id_producto." cantidad ".$cant_producto." total= ".$monto_ventas."</li>";
                $data_venta_productos = array(
                    'id_venta'=>$id_venta,
                    'id_producto'=>$id_producto,
                    'orden'=>$orden,
                    'cantidad'=>$cant_producto,
                    'precio'=>$monto_ventas
                    );
                $this->ventas_model->insert_ventas_productos($data_venta_productos);
                    //-----descontar los productos
                $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$id_producto,-$cant_producto);

                //---inspeccionado el proximo elemento
                $i++;
                if($i >= $cantidad_ventas)
                break;

              }
              //---actualizando el monto final total dl grupo
              $this->ventas_model->update_monto_ventas_productos($id_venta,$monto_final);
              $response=$response.'</ol></p></div>';
            }else{ //---no esta asociado a un Grupo
              $response=$response.'<div class="post"><span class="username">procesando venta normal</span><p>';
              $data_venta_productos = array(
                  'id_venta'=>$id_venta,
                  'id_producto'=>$id_producto,
                  'orden'=>1,
                  'cantidad'=>$cant_producto,
                  'precio'=>$monto_ventas
                  );
              $this->ventas_model->insert_ventas_productos($data_venta_productos);
                  //-----descontar los productos
              $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$id_producto,-$cant_producto);

              $i++;
              $response=$response."venta de ID=".$id_producto." cantidad ".$cant_producto." total= ".$monto_ventas."";
              $response=$response.'</p></div>';

            }




          }

        //----terminando d procesar las vntas Suspendidas
          $data['html_extra']=$response;
          $this->vista_output('ventas/ventas_suspendidas_success.php',$data);

        }else{


            //--Mostrando Formulario para realizar Venta Suspendida AL-CONTADO
            $this->load->model('categorias_model');
            $this->load->model('productos_model');
            $this->load->model('sucursales_model');
            $this->load->model('personas_model');
						//---preparando datos para la interfaz
						$categorias=$this->categorias_model->get_categorias();
            $productos=$this->productos_model->get_productos_total();
						$sucursales=$this->sucursales_model->listSucursales();
            $vendedores=$this->personas_model->listVendedores();
            $combox_productos=array();
            foreach ($productos as $fila) {
                $combox_productos[$fila['id']]=$fila['nombre'];
            }
            $data['combox_productos'] = $combox_productos;
            //$data['categorias_productos']=$categorias;
            $data['combox_sucursales']=$sucursales;
            $data['combox_vendedores']=$vendedores;
						$data['producto_inicial']=true;
						$data['datepicker']=true; //reemplazando datimepicker
            $data['timepicker']=true;
            $data['id_persona']=$_SESSION['id_persona'];
            $data['select2']=true;
            $data['clientename']=true;
            //$data['modalcliente']=true;



            $this->vista_output('ventas/ventas_suspendidascontado_view.php',$data);
        }

    }
  public function ventas_credito(){

  $sw_venta=false;
      
  $this->load->model('categorias_model');
  $this->load->model('clientes_model');          
  $this->load->model('imagenes_model');
  $this->load->model('inventarios_model');
  $this->load->model('pedidos_model');
  $this->load->model('personas_model');
  $this->load->model('plan_pago_model');
  $this->load->model('productos_model');
  $this->load->model('sucursales_model');
  $this->load->model('ventas_model');
  /////////////////////////////////////////////////////////////////
  //                 PROCESANDO VENTAS
  //
  /////////////////////////////////////////////////////////////////
  if($this->input->post('butt_ventas_procesar')=="ok"){
        
 //--obteniendo o creando cuenta de cliente
    $id_cliente=$this->input->post('id_cliente');
    $aux_cliente=$this->clientes_model->get_cuenta_cliente($id_cliente);
    $cuenta_cliente=$aux_cliente['cuenta_cliente'];
   
    $total_actual=$this->input->post('total_actual');
    $tipo_pago=$this->input->post('tipo_pago');
    $deuda_anterior=$this->input->post('deuda_cliente');
    $saldo=$this->input->post('saldo_cliente');
    $id_venta_anterior=$this->input->post('id_venta_anterior');
    $arr_id_productos      =explode(",",$this->input->post('array_id_productos'));
    $arr_precio_productos  =explode(",",$this->input->post('array_precio_productos'));
    $arr_cantidad_productos=explode(",",$this->input->post('array_cantidad_productos'));
    $arr_descontar_stock   =explode(",",$this->input->post('array_descontar_stock'));
    $arr_vendedores        =explode(",",$this->input->post('array_vendedores'));
    $arr_sucursales        =explode(",",$this->input->post('array_sucursales'));
    $arr_notas=explode(",",$this->input->post('array_notas'));
    $arr_fechas=explode(",",$this->input->post('array_fechas'));
    $arr_fechas_entregas=explode(",",$this->input->post('array_fechas_entregas'));
    $arr_fechas_entregados=explode(",",$this->input->post('array_fechas_entregados'));
    $arr_grupos=explode(",",$this->input->post('array_grupos'));
    $arr_estados=explode(",",$this->input->post('array_estados'));
    $i=0;
    $orden=1;
    $monto_sumado=0;
    //---calcaulando el monto total del pedidos
    foreach ($arr_precio_productos as  $value) {
      $monto_sumado+=$value;
    }
  /////////////////////////////////////////////////////////////////
  //                 PROCESANDO VENTAS PAGO AL CONTADO
  //
  ///////////////////////////////////////////////////////////////////
if($tipo_pago==1){ 

  $data_ventas= array(
      'id_usuario'=>$this->session->userdata('user_id'),
      'fecha'=>$this->input->post('fecha_venta'),
      'id_cliente'=>$id_cliente,
      'nota'=>'ventas tipo ',
      'total'=>$monto_sumado,
      'estado'=>'F',//---preguntarse si existen pedidos dentro de los productos
      'transferida'=>'',
      'id_vendedor'=>$this->input->post('id_vendedor'),
      'id_sucursal'=>$this->input->post('id_sucursal'),
      'tipo'=>VENTA_CONTADO,
      'id_venta_anterior'=>0
      );
  $id_venta = $this->ventas_model->insertar_ventas($data_ventas);
      ///----ahora los nuevos item a poner----
    foreach ($arr_id_productos as $id_producto) {
      //obtener cuenta de clientes
      //validando pedidos admitido por cliente
      //recorriendo el listado de pedidos-productos para registralos o actualizarlos
      //ahora fusionado a ventas-pedidos
      //----registrando las nuevas ventas-productos
    $data_venta_productos = array(
        'id_venta'=>$id_venta,
        'id_producto'=>$id_producto,
        'orden'=>$orden,
        'cantidad'=>$arr_cantidad_productos[$i],
        'precio'=>$arr_precio_productos[$i],
        //`fecha` => time inicio desde la fecha real del pedido sacar del anterior registro si lo hay,
         'anotacion'=>$arr_notas[$i],
         'fecha_inicio'=>$arr_fechas[$i],
         'fecha_entrega'=>$arr_fechas_entregas[$i],
         'fecha_entregado'=>$arr_fechas_entregados[$i],
         'descontar_stock'=>$arr_descontar_stock[$i],
         'estado'=>$arr_estados[$i]
        );
    $this->ventas_model->insert_ventas_productos($data_venta_productos);

    //------caso de stock si toca descontar-------------
    //if($settings['validar_stock']=='1'){
        //-----descontar los productos
    //???????    $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$producto_id,-$producto_cantidad);

    $i++;
    $orden++;
    }
    $sw_venta=true;
    $data['success']='Se ha registrado una venta al contado';

} //-------------END PAGO AL CONTADO
      /////////////////////////////////////////////////////////////////
      //                 PROCESANDO VENTAS PAGO AL CREDITO
      //
      ///////////////////////////////////////////////////////////////////

else if ($tipo_pago>=2){ 


        if(($cuenta_cliente['deuda']==$deuda_anterior) && ($cuenta_cliente['saldo']==$saldo) &&
        ($total_actual==$monto_sumado))
        {///actualizando cuenta del cliente
          $deuda=$saldo-$deuda_anterior-$monto_sumado;
          if($deuda<0){
            $cuenta_cliente['deuda']=$deuda*(-1);
            $cuenta_cliente['saldo']=0;
          }else{
            $cuenta_cliente['deuda']=0;
            $cuenta_cliente['saldo']=$deuda;
          }
          $this->clientes_model->actualizar_cuenta_cliente($cuenta_cliente,$id_cliente);
          // /////////////////////////////////////////////////////////////////
          //                 PROCESANDO VENTAS PAGO AL CREDITO
          //
          ///////////////////////////////////////////////////////////////////
          if ($tipo_pago == 2){ //creando plana para credito
             //---eligiendo un plan de pago y fusionando deudas
            //----quitando los anteriores planes de apgo vigente
            //---creando el nuevo plan pago

            ///--generando sus cuotas de pago                   -
            //----caso plan de PAGO

            $nro_cuotas=$this->input->post('db_nro_cuotas');
            $monto_inicial=$this->input->post('db_monto_inicial');
            $fecha_inicio=$this->input->post('db_fecha_inicio');
            $monto_restante=$this->input->post('db_monto_restante');
            $tipo_periodico=$this->input->post('db_tipo_periodico');
            $monto_cuota=$this->input->post('db_monto_cuotas');



           
            //anulando el anterio plan de PAGO
            //anulando las cuotas faltantes a pagar
            $id_plan_anterior=$this->plan_pago_model->anular_plan_pagos_cuotas($id_cliente);
            //registrando nuevo plan de PAGO
            $data_plan=array(
              'id_cliente'=>$id_cliente,
              'monto_total'=>$monto_restante,
              'deuda_anterior'=>$deuda_anterior,
              'monto_inicial'=>$monto_inicial,
              'nro_cuotas'=>$nro_cuotas,
              'tipo_periodico'=>$tipo_periodico,
              'monto_cuotas'=>$monto_cuota,
              'fecha_inicio'=>$fecha_inicio,
              'estado'=>'A',//Activo
              'id_plan_anterior'=>$id_plan_anterior
            );
            $id_plan=$this->plan_pago_model->insertar_plan_pagos($data_plan);
            //generando las cuotas
            $monto_final=$monto_restante;
            $fecha_aux = new DateTime($fecha_inicio);

            $a=1;
            while ($a <$nro_cuotas) {
              $monto_final=$monto_final-$monto_cuota;
              //---insertando las cuotas
              $data_cuota=array(
                'id_plan_pago'=>$id_plan,
                'numero'=>$a,
                'fecha_pago'=>$fecha_aux->format('Y-m-d'),
                'monto_cuota'=>$monto_cuota,
                'monto_pagado'=>0,
                'fecha_pagada'=>'',
                'estado'=>'A',
                'id_cobrador'=>''
              );
              $this->plan_pago_model->insertar_cuotas($data_cuota);
              if($tipo_periodico==1)
                $fecha_aux->add(new DateInterval('P1M'));
              else if($tipo_periodico==2)//Semanal
                $fecha_aux->add(new DateInterval('P7D'));
              else if($tipo_periodico==3)//quincenal
                $fecha_aux->add(new DateInterval('P15D'));
              $a++;
            }
            //---insertando la cuota final
            $data_cuota=array(
              'id_plan_pago'=>$id_plan,
              'numero'=>$a,
              'fecha_pago'=>$fecha_aux->format('Y-m-d'),
              'monto_cuota'=>$monto_final,
              'monto_pagado'=>0,
              'fecha_pagada'=>'',
              'estado'=>'A',
              'id_cobrador'=>''
            );
            $this->plan_pago_model->insertar_cuotas($data_cuota);
            ////////////////////////////////////////////////
            //--Aun falta definir las cobranzas nombre y direccion de garantes
            //---la horas y zona de cobrar al cliente


          }
           /////////////////////////////////////////////////////////////////
          //                 PROCESANDO VENTAS PAGO AL CREDITO PARALELO
          //
          ///////////////////////////////////////////////////////////////////
          else if($tipo_pago == 3){ //---creando plan de pago paralelo
            $id_venta_anterior=0;
             //---eligiendo un plan de pago sin fusionar deudas
            //----quitando los anteriores planes de apgo vigente
            //---creando el nuevo plan pago

            ///--generando sus cuotas de pago                   -
            //----caso plan de PAGO

            $nro_cuotas=$this->input->post('db_nro_cuotas');
            $monto_inicial=$this->input->post('db_monto_inicial');
            $fecha_inicio=$this->input->post('db_fecha_inicio');
            $monto_restante=$this->input->post('db_monto_restante');
            $tipo_periodico=$this->input->post('db_tipo_periodico');
            $monto_cuota=$this->input->post('db_monto_cuotas');



            //anulando el anterio plan de PAGO
            //anulando las cuotas faltantes a pagar
            $id_plan_anterior=0;//$this->plan_pago_model->anular_plan_pagos_cuotas($id_cliente);
            //registrando nuevo plan de PAGO
            $data_plan=array(
              'id_cliente'=>$id_cliente,
              'monto_total'=>$monto_restante,
              'deuda_anterior'=>0,//$deuda_anterior,
              'monto_inicial'=>$monto_inicial,
              'nro_cuotas'=>$nro_cuotas,
              'tipo_periodico'=>$tipo_periodico,
              'monto_cuotas'=>$monto_cuota,
              'fecha_inicio'=>$fecha_inicio,
              'estado'=>'A',//Activo
              'id_plan_anterior'=>$id_plan_anterior
            );
            $id_plan=$this->plan_pago_model->insertar_plan_pagos($data_plan);
            //generando las cuotas
            $monto_final=$monto_restante;
            $fecha_aux = new DateTime($fecha_inicio);

            $a=1;
            while ($a <$nro_cuotas) {
              $monto_final=$monto_final-$monto_cuota;
              //---insertando las cuotas
              $data_cuota=array(
                'id_plan_pago'=>$id_plan,
                'numero'=>$a,
                'fecha_pago'=>$fecha_aux->format('Y-m-d'),
                'monto_cuota'=>$monto_cuota,
                'monto_pagado'=>0,
                'fecha_pagada'=>'',
                'estado'=>'A',
                'id_cobrador'=>''
              );
              $this->plan_pago_model->insertar_cuotas($data_cuota);
              if($tipo_periodico==1)
                $fecha_aux->add(new DateInterval('P1M'));
              else if($tipo_periodico==2)//Semanal
                $fecha_aux->add(new DateInterval('P7D'));
              else if($tipo_periodico==3)//quincenal
                $fecha_aux->add(new DateInterval('P15D'));
              $a++;
            }
            //---insertando la cuota final
            $data_cuota=array(
              'id_plan_pago'=>$id_plan,
              'numero'=>$a,
              'fecha_pago'=>$fecha_aux->format('Y-m-d'),
              'monto_cuota'=>$monto_final,
              'monto_pagado'=>0,
              'fecha_pagada'=>'',
              'estado'=>'A',
              'id_cobrador'=>''
            );
            $this->plan_pago_model->insertar_cuotas($data_cuota);
            ////////////////////////////////////////////////
            //--Aun falta definir las cobranzas nombre y direccion de garantes
            //---la horas y zona de cobrar al cliente


          }
           /////////////////////////////////////////////////////////////////
           //                 PROCESANDO VENTAS PAGO AL CREDITO ABIERTO
           //
           ///////////////////////////////////////////////////////////////////
          else if($tipo_pago == 4){ //---creando plan de pago abierto al finalizar pedido
            $id_venta_anterior=0;
             //---eligiendo un plan de pago sin fusionar deudas
            //----quitando los anteriores planes de apgo vigente
            //---creando el nuevo plan pago

            ///--generando sus cuotas de pago                   -
            //----caso plan de PAGO

            $nro_cuotas=$this->input->post('db_nro_cuotas');
            $monto_inicial=$this->input->post('db_monto_inicial');
            $fecha_inicio=$this->input->post('db_fecha_inicio');
            $monto_restante=$this->input->post('db_monto_restante');
            $tipo_periodico=$this->input->post('db_tipo_periodico');
            $monto_cuota=$this->input->post('db_monto_cuotas');



            //anulando el anterio plan de PAGO
            //anulando las cuotas faltantes a pagar
            $id_plan_anterior=0;//$this->plan_pago_model->anular_plan_pagos_cuotas($id_cliente);
            //registrando nuevo plan de PAGO
            $data_plan=array(
              'id_cliente'=>$id_cliente,
              'monto_total'=>$monto_restante,
              'deuda_anterior'=>0,//$deuda_anterior,
              'monto_inicial'=>$monto_inicial,
              'nro_cuotas'=>1,//$nro_cuotas,
              'tipo_periodico'=>$tipo_periodico,
              'monto_cuotas'=>$monto_restante,//$monto_cuota,
              'fecha_inicio'=>$fecha_inicio,
              'estado'=>'A',//Activo
              'id_plan_anterior'=>$id_plan_anterior
            );
            $id_plan=$this->plan_pago_model->insertar_plan_pagos($data_plan);
            //generando las cuotas
            $monto_final=$monto_restante;
            $fecha_aux = new DateTime($fecha_inicio);

            $a=1;
            while ($a <$nro_cuotas) {
              $monto_final=$monto_final-$monto_cuota;
              //---insertando las cuotas
              $data_cuota=array(
                'id_plan_pago'=>$id_plan,
                'numero'=>$a,
                'fecha_pago'=>$fecha_aux->format('Y-m-d'),
                'monto_cuota'=>$monto_cuota,
                'monto_pagado'=>0,
                'fecha_pagada'=>'',
                'estado'=>'A',
                'id_cobrador'=>''
              );
              $this->plan_pago_model->insertar_cuotas($data_cuota);
              if($tipo_periodico==1)
                $fecha_aux->add(new DateInterval('P1M'));
              else if($tipo_periodico==2)//Semanal
                $fecha_aux->add(new DateInterval('P7D'));
              else if($tipo_periodico==3)//quincenal
                $fecha_aux->add(new DateInterval('P15D'));
              $a++;
            }
            //---insertando la cuota final
            //---dandole plazo amximo de pago 1mes scaa de config del sistema
            $fecha_aux->add(new DateInterval('P1M'));
            $data_cuota=array(
              'id_plan_pago'=>$id_plan,
              'numero'=>$a,
              'fecha_pago'=>$fecha_aux->format('Y-m-d'),
              'monto_cuota'=>$monto_final,
              'monto_pagado'=>0,
              'fecha_pagada'=>'',
              'estado'=>'A',
              'id_cobrador'=>''
            );
            $this->plan_pago_model->insertar_cuotas($data_cuota);
            ////////////////////////////////////////////////
            //--Aun falta definir las cobranzas nombre y direccion de garantes
            //---la horas y zona de cobrar al cliente


          }
          //----con la fusionde ventas-pedidos se continuara como ventas
          //---verificando si existe venta anterior----
          if($id_venta_anterior==0)
          $id_venta_anterior==null;
          //-----registrando la nueva venta-------
          $data_ventas= array(
              'id_usuario'=>$this->session->userdata('user_id'),
              'fecha'=>$this->input->post('fecha_venta'),
              'id_cliente'=>$id_cliente,
              'nota'=>'ventas tipo ',
              'total'=>$monto_sumado,
              'estado'=>'P',//---preguntarse si existen pedidos dentro de los productos
              'transferida'=>'',
              'id_vendedor'=>$this->input->post('id_vendedor'),
              'id_sucursal'=>$this->input->post('id_sucursal'),
              'tipo'=>VENTA_CREDITO,
              'id_venta_anterior'=>$id_venta_anterior
              );
          $id_venta = $this->ventas_model->insertar_ventas($data_ventas);

          //-----anulando la anterior venta
          if($id_venta_anterior!=null){
            //-----actualizando anterior venta a reeditadanueva venta
            $this->ventas_model->update_estado_venta($id_venta_anterior,'R');
            //---pasando los producto a la nueva venta--------
            $db_venta_productos=$this->ventas_model->obtener_detalle_venta($id_venta_anterior);
            foreach ($db_venta_productos as $dp_vp) {
              $id_venta_anterior=$dp_vp['id_venta_anterior'];
              if($dp_vp['id_venta_anterior']==null){
                $id_venta_anterior=$dp_vp['id'];
              }
              $data_venta_productos = array(
                  'id_venta'=>$id_venta,/// id nuevo
                  'id_producto'=>$dp_vp['id_producto'],
                  'orden'=>$orden,
                  'cantidad'=>$dp_vp['cantidad'],
                  'precio'=>$dp_vp['precio'],
                  //'fecha' => $dp_vp['fecha'],
                  'anotacion'=>$dp_vp['anotacion'],
                  'fecha_inicio'=>$dp_vp['fecha_inicio'],
                  'fecha_entrega'=>$dp_vp['fecha_entrega'],
                  'fecha_entregado'=>$dp_vp['fecha_entregado'],
                  'descontar_stock'=>$dp_vp['descontar_stock'],
                  'estado'=>$dp_vp['estado'],
                  'id_venta_anterior'=>$id_venta_anterior
                  );
                  $orden++;
              $this->ventas_model->insert_ventas_productos($data_venta_productos);
            }
          }

          ///----ahora los nuevos item a poner----
        foreach ($arr_id_productos as $id_producto) {
          //obtener cuenta de clientes
          //validando pedidos admitido por cliente
          //recorriendo el listado de pedidos-productos para registralos o actualizarlos
          //ahora fusionado a ventas-pedidos
          //----registrando las nuevas ventas-productos
        $data_venta_productos = array(
            'id_venta'=>$id_venta,
            'id_producto'=>$id_producto,
            'orden'=>$orden,
            'cantidad'=>$arr_cantidad_productos[$i],
            'precio'=>$arr_precio_productos[$i],
            //`fecha` => time inicio desde la fecha real del pedido sacar del anterior registro si lo hay,
             'anotacion'=>$arr_notas[$i],
             'fecha_inicio'=>$arr_fechas[$i],
             'fecha_entrega'=>$arr_fechas_entregas[$i],
             'fecha_entregado'=>$arr_fechas_entregados[$i],
             'descontar_stock'=>$arr_descontar_stock[$i],
             'estado'=>$arr_estados[$i]
            );
        $this->ventas_model->insert_ventas_productos($data_venta_productos);

        //------caso de stock si toca descontar-------------
        //if($settings['validar_stock']=='1'){
            //-----descontar los productos
           // $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$producto_id,-$producto_cantidad);
            //$i++;
            //$orden++;
          //}
        }// End Foreach
        $data['success']='LA VENTA SE HA REGISTRADO CORRECTAMENTE';
        $sw_venta=true;
    }
    else{
        $data['error']='Los datos no cuadran con la cuenta cliente, se ha modificado en el tiempo transcurrido';

    }
  }//---end if tipo_pago ==2 o ==3
}
     
      /////////////////////////////////////////////////////////////////
      //             INICIO DE VENTAS - 
      //
      ///////////////////////////////////////////////////////////////////
    //if ($this->input->post("butt_gestionar")=="ok" || $sw_venta=true){
        $id_cliente=$this->input->post("id_cliente");
       
        //--obteniendo o creando cuenta de cliente
        $id_venta_anterior=0;
        $cuenta=$this->clientes_model->get_cuenta_cliente($id_cliente);
        if($cuenta!=null){
          //---verificando cuenta de cliente y pedidos (ventas pendientes) anteriores
          //$old_pedidos=$this->pedidos_model->get_pedidos_pendientes_cliente($id_cliente);
          $old_venta_pendiente=$this->ventas_model->get_ventas_pendientes_cliente($id_cliente);
          $pedidos=array();

          foreach ($old_venta_pendiente as $pedido) {
            //  print_r($pedido);
              //echo "<p>";
            $id_producto=$pedido['id_producto'];
            $id_venta_anterior=$pedido['id_venta'];
            $p=$this->productos_model->get_producto_by_id($id_producto);
            $pedido['nombre_producto']=$p['nombre'];
            $pedido['codigo']=$p['codigo'];
            $imagen=$this->imagenes_model->get_imagen_producto($id_producto);
            $pedido['img_producto']=$imagen['imagen'];
            $pedidos[]=$pedido;
          }
          //print_r($cuenta);
          $data['cuenta_cliente']=$cuenta;
          $data['arr_pedidos']=$pedidos;
          //--Mostrando Formulario para realizar Venta
        
          //---preparando datos para la interfaz;
          $productos=$this->productos_model->get_productos_total();
          $sucursales=$this->sucursales_model->listSucursales();
          $vendedores=$this->personas_model->listVendedores();
          $combox_productos=array();
          foreach ($productos as $fila) {
              $combox_productos[$fila['id']]=$fila['nombre'];
          }
          $data['agenda']=$this->clientes_model->get_agenda_cobranzas_cliente($id_cliente);
          $data['combox_productos'] = $combox_productos;
          //$data['categorias_productos']=$categorias;
          $data['combox_sucursales']=$sucursales;
          $data['combox_vendedores']=$vendedores;
          $data['id_venta_anterior']=$id_venta_anterior;
          $data['producto_inicial']=true;
          $data['datepicker']=true;
          $data['datepicker2']=true;
        //  $data['timepicker']=true;
          $data['id_persona']=$_SESSION['id_persona'];
          $data['select2']=true;
          //$data['clientename']=true;
          //$data['modalcliente']=true;
          $this->vista_output('ventas/ventas_pedidos_view',$data);

        }else{
          //---el cliente no es validao         
          $this->session->set_flashdata('pedidos_cliente', 'El id del cliente no es valido');
          redirect('ventas/pedidos');
        }

     // }
     

}

    public function modificar_pedidos(){

      $data_pedido=$_POST;
      $this->load->model('pedidos_model');
      $this->pedidos_model->actualizar($data_pedido,$data_pedido['id'],$data_pedido['orden'],$data_pedido['fecha_inicio']);

      $data=array('success'=>true,
                'result'=>'ok');
      echo json_encode($data);
    }
    public function pedidos(){
         if($this->input->post("butt_realizar_pedidos")=="ok"){


           $this->vista_output('ventas/lista_pedidos_view',$data);
         }else{
           //-----listando pedidos pendientes global
           //$this->load->model('pedidos_model');
           $this->load->model('ventas_model');
           $this->load->model('clientes_model');
           //$arr_pedidos=$this->pedidos_model->get_pedidos_pendientes_global_group();
           $arr_pedidos=$this->ventas_model->get_ventas_pedidos_pendientes_global_group();
           
           $pedidos=array();
           foreach ($arr_pedidos as $pedido) {
             $id_producto=$pedido['id_producto'];
             $id_venta=$pedido['id_venta'];
             $pedido['nombre_cliente']=$this->clientes_model->get_namecliente_from_id($pedido['id_cliente']);
             $pedido['cantidad']=$this->ventas_model->obtener_monto_venta($id_venta);
             //$this->pedidos_model->get_cant_productos_by_group($pedido['id'],$pedido['fecha_inicio']);
             $pedido['total']=$this->ventas_model->obtener_cantidad_detalle_venta($id_venta);//$this->pedidos_model->get_monto_by_group($pedido['id'],$pedido['fecha_inicio']);


             $pedidos[]=$pedido;
           }
           $data['title_crud']="Lista Pedidos Pendientes";
           $data['select2']=true;
           $data['clientename']=true;
           $data['arr_pedidos']=$pedidos;
           $error=$this->session->flashdata('pedidos_cliente');
           if($error!=null)
           $data['error']=$error;
    			 //$data = json_decode(json_encode($data), True);
    			 $this->vista_output('ventas/lista_pedidos_view',$data);
         }

  	 }
     public function pedidos_cliente(){

      $data['link_active']='ventas/pedidos';
       $id_cliente=0;
        $id_venta_anterior=0;
       if($this->input->post('butt_pedidos')=="ok"){
         if($this->input->post('clientename')!=null)
         $id_cliente=$this->input->post('clientename');
       }else if($this->input->post('butt_gestionar')=="ok"){
         $id_cliente=$this->input->post('id_cliente');
       }
       /////////////////////////////////////////////////////////////////
       if($this->input->post('butt_pedidos_procesar')=="ok"){
         $this->load->model('clientes_model');
         $this->load->model('pedidos_model');
         $this->load->model('inventarios_model');
         //--obteniendo o creando cuenta de cliente
         $id_cliente=$this->input->post('id_cliente');
         $aux_cliente=$this->clientes_model->get_cuenta_cliente($id_cliente);
         $cuenta_cliente=$aux_cliente['cuenta_cliente'];
         // datos recibidos
         //foreach ($_POST as $key => $value) {
         //  echo "$key = $value <br>";
         //}
         $total_actual=$this->input->post('total_actual');
         $deuda_anterior=$this->input->post('deuda_cliente');
         $saldo=$this->input->post('saldo_cliente');
         $arr_id_productos      =explode(",",$this->input->post('array_id_productos'));
         $arr_precio_productos  =explode(",",$this->input->post('array_precio_productos'));
         $arr_cantidad_productos=explode(",",$this->input->post('array_cantidad_productos'));
         $arr_descontar_stock   =explode(",",$this->input->post('array_descontar_stock'));
         $arr_vendedores        =explode(",",$this->input->post('array_vendedores'));
         $arr_sucursales        =explode(",",$this->input->post('array_sucursales'));
         $arr_notas=explode(",",$this->input->post('array_notas'));
         $arr_fechas=explode(",",$this->input->post('array_fechas'));
         $arr_fechas_entregas=explode(",",$this->input->post('array_fechas_entregas'));
         $arr_fechas_entregados=explode(",",$this->input->post('array_fechas_entregados'));
         $arr_grupos=explode(",",$this->input->post('array_grupos'));
         $arr_estados=explode(",",$this->input->post('array_estados'));
         $i=0;
         $monto_sumado=0;
         //---calcaulando el monto total del pedidos
         foreach ($arr_precio_productos as  $value) {
           $monto_sumado+=$value;
         }
       //  echo $cuenta_cliente['deuda']." == ".$deuda_anterior." ) && ( ".$cuenta_cliente['saldo']."==".$saldo.") &&
         //(".$total_actual."==".$monto_sumado.") ";
         if(($cuenta_cliente['deuda']==$deuda_anterior) && ($cuenta_cliente['saldo']==$saldo) &&
         ($total_actual==$monto_sumado))
         {///actualizando cuenta del cliente
           $deuda=$saldo-$deuda_anterior-$monto_sumado;
           if($deuda<0){
             $cuenta_cliente['deuda']=$deuda*(-1);
             $cuenta_cliente['saldo']=0;
           }else{
             $cuenta_cliente['deuda']=0;
             $cuenta_cliente['saldo']=$deuda;
           }
           $this->clientes_model->actualizar_cuenta_cliente($cuenta_cliente,$id_cliente);
         foreach ($arr_id_productos as $id_producto) {
           //obtener cuenta de clientes
           //validando pedidos admitido por cliente
           //recorriendo el listado de pedidos-productos para registralos o actualizarlos
           $data_pedidos=array(
             'id'=>$arr_grupos[$i],
             'orden'=>$i+1,
             'fecha_inicio'=>$arr_fechas[$i],
             'id_cliente'=>$id_cliente,
             'id_usuario'=>$this->session->userdata('user_id'),
             'id_vendedor'=>$arr_vendedores[$i],
             'id_sucursal'=>$arr_sucursales[$i],
             'id_producto'=>$id_producto,
             'cantidad'=>$arr_cantidad_productos[$i],
             'anotacion'=>$arr_notas[$i],
             'fecha_entrega'=>$arr_fechas_entregas[$i],
             'fecha_entregado'=>$arr_fechas_entregados[$i],
             'descontar_stock'=>$arr_descontar_stock[$i],
             'total'=>$arr_precio_productos[$i],
             'estado'=>$arr_estados[$i]
           );
           $this->pedidos_model->insertar($data_pedidos);
         $i++;
       }}else{
         $data['error']='Los datos no cuadran con la cuenta cliente, se ha modificado en el tiempo transcurrido';

       }
       }
       else /////////////////////////////////////////////////////////////
       if($this->input->post('butt_pedidos_pago')=="ok"){
         $this->load->model('clientes_model');
         $this->load->model('pedidos_model');
         $this->load->model('ventas_model');
         $this->load->model('inventarios_model');

           //obtener cuenta de clientes
           $id_cliente=$this->input->post('id_cliente');
           $opt_pago=$this->input->post('opt_pago');
           $fecha=$this->input->post('fecha');
           $id_cobrador=$this->input->post('select_cobrador');
           $monto=$this->input->post('monto');
           $data_pago=array(
             'id_cliente'=>$id_cliente,
             'fecha'=>$fecha,
             'id_cobrador'=>$id_cobrador,
             'monto'=>$monto,
             'tipo'=>0
           );
           $aux_cliente=$this->clientes_model->get_cuenta_cliente($id_cliente);
           $cuenta_cliente=$aux_cliente['cuenta_cliente'];
           if($opt_pago==2)
           $monto=$cuenta_cliente['deuda'];
           //---registrando Pagos
           $this->ventas_model->insertar_pagos($data_pago);
           //validando pedidos admitido por cliente
           //verificando finalizacion de pagos
           $deuda=$monto+$cuenta_cliente['saldo']-$cuenta_cliente['deuda'];
           if($deuda<0){
             $cuenta_cliente['deuda']=$deuda*(-1);
             $cuenta_cliente['saldo']=0;
           }else{
             $cuenta_cliente['deuda']=0;
             $cuenta_cliente['saldo']=$deuda;
           }
           //actualizando estado de clientes
           $this->clientes_model->actualizar_cuenta_cliente($cuenta_cliente,$id_cliente);
           ////////////////////////////////////////////
           //actualizando estado de pedidos caso especial pagar todo
           if($opt_pago==2){ //...finalizando todo
             $id_grupo=0;
             $id_venta=0;
             //cambiado de pedidos            
             $venta_pendientes=$this->ventas_model->get_ventas_pendientes_cliente($id_cliente);

             foreach ($venta_pendientes as $vp){
                 $venta_producto=$vp;
                 unset($venta_producto['id']);
                 unset($venta_producto['total']);
                 if($id_venta!=$venta_producto['id_venta']){
                    $id_venta=$venta_producto['id_venta'];
                    $this->ventas_model->update_estado_venta($id_venta,'F');
                 }                                                                  
                 $venta_producto['estado']='F';
                 if($venta_producto['fecha']=='')
                 $venta_producto['fecha_entregado']=date('Y-m-d');
                 $this->ventas_model->actualizar_venta_productos($venta_producto);
                 //------------------------------ventas_suspendidas_pedidos

                 //--------caso de venta------------
                 /*
                 if($id_grupo!=$pedido['id']){
                 //  echo "CREANDO VENTA PARA:".$pedido['id']."<br>";
                   $id_grupo=$pedido['id']; //---es otro grupo de pedidos
                   $data_ventas= array(
                       'id_usuario'=>$this->session->userdata('user_id'),
                       'fecha'=>$pedido['fecha_inicio'],
                       'id_cliente'=>$id_cliente,
                       'nota'=>'venta por pedido ['.$pedido['id'].'] pago total',
                       'total'=>$this->pedidos_model->get_monto_by_group($pedido['id'],$pedido['fecha_inicio']),
                       'estado'=>'0',//--opt debe ser finalizada
                       'transferida'=>'',
                       'id_vendedor'=>$pedido['id_vendedor'],
                       'id_sucursal'=>$pedido['id_sucursal'],
                       'tipo'=>VENTA_PEDIDO
                       );
                   $id_venta = $this->ventas_model->insertar_ventas($data_ventas);
                 }
                 
                 //-----caso ventas productos--------
                 //echo "realizando venta-productos para id_venta:$id_venta <br> ";
                     $data_venta_productos = array(
                         'id_venta'=>$id_venta,
                         'id_producto'=>$pedido['id_producto'],
                         'orden'=>$pedido['orden'],
                         'cantidad'=>$pedido['cantidad'],
                         'precio'=>$pedido['total']
                         );
                     $this->ventas_model->insert_ventas_productos($data_venta_productos);
                */
                     //------caso de stock-------------
                     //if($settings['validar_stock']=='1'){
                         //-----descontar los productos
                     //if($venta_producto['descontar_stock'])
                    // $this->inventarios_model->actualizar_cantidad_productos($ve['id_sucursal'],$pedido['id_producto'],-$pedido['cantidad']);
                   // }


                 //------------------------------end ventas
             }

           }
           //---liberando pedidos
           ///////////////////////////////////////////
           //.....
           //----pendiente



       }

       ////////////////////////////////////////////////////////////
       ///----llamada inicial----
       if($id_cliente>0){
         //echo " validadnod id de cliente";
         $this->load->model('clientes_model');
         $this->load->model('pedidos_model');
         $this->load->model('ventas_model');
         $this->load->model('productos_model');
         $this->load->model('imagenes_model');
         //--obteniendo o creando cuenta de cliente
         $cuenta=$this->clientes_model->get_cuenta_cliente($id_cliente);
         if($cuenta!=null){
           //---verificando cuenta de cliente y pedidos anteriores
           $old_pedidos=$this->pedidos_model->get_pedidos_pendientes_cliente($id_cliente);
          $old_ventas=$this->ventas_model->get_ventas_pendientes_cliente($id_cliente);
         
          $old_pedidos=$old_ventas;

           $pedidos=array();
           foreach ($old_pedidos as $pedido) {
             $id_producto=$pedido['id_producto'];
             $id_venta_anterior=$pedido['id_venta'];
             $p=$this->productos_model->get_producto_by_id($id_producto);
             $pedido['nombre_producto']=$p['nombre'];
             $pedido['codigo']=$p['codigo'];
             $imagen=$this->imagenes_model->get_imagen_producto($id_producto);
             $pedido['img_producto']=$imagen['imagen'];
             $pedidos[]=$pedido;
           }
           //print_r($cuenta);
           $data['cuenta_cliente']=$cuenta;
           $data['arr_pedidos']=$pedidos;
           //--Mostrando Formulario para realizar Venta Suspendida AL-CONTADO
           $this->load->model('categorias_model');
           $this->load->model('productos_model');
           $this->load->model('sucursales_model');
           $this->load->model('personas_model');
           //---preparando datos para la interfaz;
           $productos=$this->productos_model->get_productos_total();
           $sucursales=$this->sucursales_model->listSucursales();
           $vendedores=$this->personas_model->listVendedores();
           $combox_productos=array();
           foreach ($productos as $fila) {
               $combox_productos[$fila['id']]=$fila['nombre'];
           }
           $data['combox_productos'] = $combox_productos;
           //$data['categorias_productos']=$categorias;
           $data['combox_sucursales']=$sucursales;
           $data['combox_vendedores']=$vendedores;
           $data['id_venta_anterior']=$id_venta_anterior;
           $data['agenda']=$this->clientes_model->get_agenda_cobranzas_cliente($id_cliente);
           $data['producto_inicial']=true;
           $data['datepicker']=true;
           $data['datepicker2']=true;
         //  $data['timepicker']=true;
           $data['id_persona']=$_SESSION['id_persona'];
           $data['select2']=true;
           //$data['clientename']=true;
           //$data['modalcliente']=true;


            $this->vista_output('ventas/ventas_pedidos_view',$data);

         }else{
           //---el cliente no es validao
           redirect('ventas/pedidos');
           $this->session->set_flashdata('pedidos_cliente', 'El id del cliente no es valido');
         }

       }else{
         //---cliente no enviado
         $this->session->set_flashdata('pedidos_cliente', 'Seleccione un cliente para poder gestionar el pedido');
         redirect('ventas/pedidos');
       }

     }
     public function consignacion(){
          if($this->input->post("butt_realizar_consignacion")=="ok"){
            $this->vista_output('ventas/lista_consignacion_view',$data);
          }else{
            //-----listando pedidos pendientes global
            $this->load->model('consignacion_model');
            $this->load->model('clientes_model');
            $arr_consignacion=$this->consignacion_model->get_consignacion_pendientes_global_group();
            $consignaciones=array();
            foreach ($arr_consignacion as $consignacion) {
              $id_producto=$consignacion['id_producto'];
              $consignacion['nombre_cliente']=$this->clientes_model->get_namecliente_from_id($consignacion['id_cliente']);
              $consignacion['cantidad']=$this->consignacion_model->get_cant_productos_by_group($consignacion['id'],$consignacion['fecha_inicio']);
              $consignacion['total']=$this->consignacion_model->get_monto_by_group($consignacion['id'],$consignacion['fecha_inicio']);
              $consignaciones[]=$consignacion;
            }
            $data['title_crud']="Lista Consignacion Pendientes";
            $data['select2']=true;
            $data['clientename']=true;
            $data['arr_consignaciones']=$consignaciones;
            $error=$this->session->flashdata('pedidos_cliente');
            if($error!=null)
            $data['error']=$error;
            //$data = json_decode(json_encode($data), True);
            $this->vista_output('ventas/lista_consignacion_view',$data);
          }

      }
      public function consignacion_cliente(){

  			$data['link_active']='ventas/consignacion';
        $id_cliente=0;
        if($this->input->post('butt_pedidos')=="ok"){
          if($this->input->post('clientename')!=null)
          $id_cliente=$this->input->post('clientename');
        }else if($this->input->post('butt_gestionar')=="ok"){
          $id_cliente=$this->input->post('id_cliente');
        }
        /////////////////////////////////////////////////////////////////
        if($this->input->post('butt_consignacion_procesar')=="ok"){
          $this->load->model('clientes_model');
          $this->load->model('consignacion_model');
          $id_cliente=$this->input->post('id_cliente');
          $arr_id_productos      =explode(",",$this->input->post('array_id_productos'));
          $arr_precio_productos  =explode(",",$this->input->post('array_precio_productos'));
          $arr_cantidad_productos=explode(",",$this->input->post('array_cantidad_productos'));
          $arr_precios_unitario_productos=explode(",",$this->input->post('array_precios_unitario_productos'));
          $arr_medidas_productos =explode(",",$this->input->post('array_medidas_productos'));
          $arr_precios_venta_productos =explode(",",$this->input->post('array_precios_venta_productos'));
          $arr_descontar_stock   =explode(",",$this->input->post('array_descontar_stock'));
          $arr_vendedores        =explode(",",$this->input->post('array_vendedores'));
          $arr_sucursales        =explode(",",$this->input->post('array_sucursales'));
          $arr_notas=explode(",",$this->input->post('array_notas'));
          $arr_fechas=explode(",",$this->input->post('array_fechas'));
          $arr_fechas_entregas=explode(",",$this->input->post('array_fechas'));
          $arr_fechas_entregados=explode(",",$this->input->post('array_fechas_entregas'));
          $arr_grupos=explode(",",$this->input->post('array_grupos'));
          $arr_estados=explode(",",$this->input->post('array_estados'));
          $i=0;
          $monto_sumado=0;
          foreach ($arr_id_productos as $id_producto) {
            //obtener cuenta de clientes
            //validando pedidos admitido por cliente
            //recorriendo el listado de pedidos-productos para registralos o actualizarlos
            $data_consignacion=array(
              'id'=>$arr_grupos[$i],
              'orden'=>$i+1,
              'fecha_inicio'=>$arr_fechas[$i],
              'id_cliente'=>$id_cliente,
              'id_usuario'=>$this->session->userdata('user_id'),
              'id_vendedor'=>$arr_vendedores[$i],
              'id_sucursal'=>$arr_sucursales[$i],
              'id_producto'=>$id_producto,
              'cantidad'=>$arr_cantidad_productos[$i],
              'precio_unitario'=>$arr_precios_unitario_productos[$i],
              'descripcion'=>$arr_medidas_productos[$i],
              'precio_venta'=>$arr_precios_venta_productos[$i],
              'cantidad_vendida'=>0,
              'anotacion'=>'',//$arr_notas[$i], obs
              'fecha_entrega'=>$arr_fechas_entregas[$i],
              'fecha_devolucion'=>$arr_fechas_entregados[$i],
              'total'=>$arr_precio_productos[$i],
              'estado'=>$arr_estados[$i]
            );
            $this->consignacion_model->insertar($data_consignacion);
            //----actualizando inventario
             $this->load->model('inventarios_model');
             $this->inventarios_model->actualizar_cantidad_productos($arr_sucursales[$i],$id_producto,-$arr_cantidad_productos[$i]);

          $i++;
        }
      }

        ////////////////////////////////////////////////////////////
        ///----llamada inicial----
        if($id_cliente>0){
          //echo " validando id de cliente";
          $this->load->model('clientes_model');
          $this->load->model('sucursales_model');
          $this->load->model('consignacion_model');
          $this->load->model('productos_model');
          $this->load->model('imagenes_model');
          //--obteniendo o creando cuenta de cliente
          $cuenta=$this->clientes_model->get_cuenta_cliente($id_cliente);

          $data['monto_pendiente']=$this->consignacion_model->get_monto_deuda_pendiente($id_cliente);

          if($cuenta!=null){
            //---verificando cuenta de cliente y consignaciones pendientes
            $old_pedidos=$this->consignacion_model->get_consignacion_pendientes_cliente($id_cliente);
            $pedidos=array();
            foreach ($old_pedidos as $pedido) {
              $id_producto=$pedido['id_producto'];
              $p=$this->productos_model->get_producto_by_id($id_producto);
              $pedido['nombre_producto']=$p['nombre'];
              $pedido['codigo']=$p['codigo'];
              $sucursal=explode( ',',$this->sucursales_model->get_namesucursal_from_id($pedido['id_sucursal']));
              $pedido['sucursal']=$sucursal[0];
              $imagen=$this->imagenes_model->get_imagen_producto($id_producto);
              $pedido['img_producto']=$imagen['imagen'];
              $pedidos[]=$pedido;
            }
            //print_r($cuenta);
            $data['cuenta_cliente']=$cuenta;
            $data['arr_pedidos']=$pedidos;
            //--Mostrando Formulario para realizar Venta Suspendida AL-CONTADO
            $this->load->model('categorias_model');
            $this->load->model('productos_model');
            $this->load->model('sucursales_model');
            $this->load->model('personas_model');
            //---preparando datos para la interfaz;
            $productos=$this->productos_model->get_productos_total();
            $sucursales=$this->sucursales_model->listSucursales();
            $vendedores=$this->personas_model->listVendedores();
            $combox_productos=array();
            foreach ($productos as $fila) {
                $combox_productos[$fila['id']]=$fila['nombre'];
            }
            $data['combox_productos'] = $combox_productos;
            //$data['categorias_productos']=$categorias;
            $data['combox_sucursales']=$sucursales;
            $data['combox_vendedores']=$vendedores;
            $data['producto_inicial']=true;
            $data['datepicker']=true;
            $data['datepicker2']=true;
          //  $data['timepicker']=true;
            $data['id_persona']=$_SESSION['id_persona'];
            $data['select2']=true;
            //$data['clientename']=true;
            //$data['modalcliente']=true;


     			  $this->vista_output('ventas/ventas_consignacion_view',$data);

          }else{
            //---el cliente no es validao
            redirect('ventas/consignacion');
            $this->session->set_flashdata('pedidos_cliente', 'El id del cliente no es valido');
          }

        }else{
          //---cliente no enviado
          $this->session->set_flashdata('pedidos_cliente', 'Seleccione un cliente para poder gestionar la consignacion');
          redirect('ventas/consignacion');
        }

      }
     public function anular(){

   			 $this->load->library('grocery_CRUD');
         if($this->input->get('id_venta')){
           $this->load->model('ventas_model');
           $this->load->model('inventarios_model');
           $primary_key=$this->input->get('id_venta');
           //---registrando Bitacora
           $this->db->insert('bitacora',array ('id_accion'=>9,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$primary_key ));
           //----reponer el stock al inventario de la venta en el sucursal
           $venta=$this->ventas_model->obtener_venta($primary_key);
           if(count($venta)>0){
             if($venta['estado']!=VENTA_ANULADA){
               $this->db->where('id',$primary_key);
               $this->db->update('ventas',
                 array(
                   'id' => $primary_key,
                   'estado'=>VENTA_ANULADA
                 )
               );
               $id_sucursal=$venta['id_sucursal'];
               $arr_detalle_venta=$this->ventas_model->obtener_detalle_venta($primary_key);

               foreach ($arr_detalle_venta as $venta_producto) {
                 $id_producto=$venta_producto['id_producto'];
                 $cantidad=$venta_producto['cantidad'];
                 $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$id_producto,$cantidad);
               }
               $info='Se ha anulado la venta asociada a ese ID:'.$primary_key. ' productos repuestos';
             }else{
               $info='la venta ID:'.$primary_key. 'ya estaba anulada';
             }
           }else {
             $info='No existes la venta asociada a ese ID:'.$primary_key. 'No se ha anulado';
           }
           $info=$info.' <a href="'.base_url().'ventas/anular"'.'<h1>REGRESAR URL</h1></a>';

         }
   			 $crud = new grocery_CRUD();
   			 $crud->unset_add();
   			 $crud->unset_clone();
   			 $crud->unset_edit();
   			 $crud->unset_read();
   			 $crud->set_table('ventas');
   			 $crud->set_relation('id_vendedor','personas','{nombre} {apellidos}');
   			 $crud->set_relation('id_sucursal','sucursales','nombre');
   			 $crud->set_relation('id_cliente','clientes','nombres');
   			 $crud->set_relation('id_usuario','usuarios','username');
          //$crud->set_relation('id_producto','productos','nombre');
         $crud->columns(array('id','fecha','total','id_cliente','id_vendedor','nota','estado','tipo','transferida','id_sucursal','id_usuario'));
   			 $crud->display_as('id_vendedor','Vendedor');
   			 $crud->display_as('id_sucursal','Sucursal');
   			 $crud->display_as('id_cliente','Cliente');
   			 $crud->display_as('id_usuario','Usuario');
         $crud->display_as('acciones','Anular');
         //$crud->callback_before_delete(array($this,'anular_ventas'));;
         $crud->add_action('Anular', '', 'demo/action_more','fa fa-remove text-red ',array($this,'anular_ventas'));
         $crud->callback_column('tipo',array($this,'tipo_callback'));
         $crud->callback_column('estado',array($this,'estado_callback'));
         $crud->callback_before_delete(array($this,'venta_before_delete'));


   			 $data = $crud->render();

   		   $data->link_active='ventas/anular';
         $data->title_crud=" Anular/Eliminar Ventas";
         $data->warning="Las venta anulada y los productos asociados a esta venta seran considerados
         nuevamente como parte del stock";
         $data->error="La venta eliminada seran registros borrados junto a sus datos asociadas, productos regresaran a inventario !!!!";
   			 if(isset($info))
         $data->info=$info;
   			 $this->vista_output('crud/plantilla_crud',$data);

   	 }

    public function anular_ventas($primary_key , $row)
    {
      return site_url('ventas/anular').'?id_venta='.$primary_key;

    }
    public function venta_before_delete($primary_key){

      $this->load->model('ventas_model');
      $this->load->model('inventarios_model');
      //----reponer el stock al inventario de la venta en el sucursal
      $venta=$this->ventas_model->obtener_venta($primary_key);
      if(count($venta)>0){
        if($venta['estado']!=VENTA_ANULADA){
          $id_sucursal=$venta['id_sucursal'];
          $arr_detalle_venta=$this->ventas_model->obtener_detalle_venta($primary_key);
          foreach ($arr_detalle_venta as $venta_producto) {
            $id_producto=$venta_producto['id_producto'];
            $cantidad=$venta_producto['cantidad'];
            $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$id_producto,$cantidad);
          }
          return true;
        }else{
          return true;
        }
      }else {
        return false;
      }

    }
    public function tipo_callback($value, $row)
    {
      $name="NN";
      switch ($value) {
        case VENTA_CONTADO:
          $name='<span class=" text-green">'."CONTADO";
          break;
        case VENTA_CREDITO:
          $name='<span class=" text-yellow">'."CREDITO";
          break;
        case VENTA_SUSPENDIDA_CONTADO:
          $name='<span class=" text-blue">'."S.CONTADO";
          break;
        case VENTA_PEDIDO:
            $name='<span class=" text-blue">'."PEDIDO";
            break;
        case VENTA_CONSIGNACION:
              $name='<span class=" text-blue">'."CONSIGNACION";
              break;
        case ANULADA:
          $name='<span class=" text-red">'."ANULADA";
          break;

        default:
          $name='<span class=" text-blue">'."";
          break;
      }
    return $name."</span>";
    }
    public function estado_callback($value, $row)
    {
      $name="NN";
      switch ($value) {

        case ANULADA:
          $name='<span class=" text-red">'."ANULADA";
          break;

        default:
          $name='<span class=" text-blue">'."";
          break;
      }
    return $name."</span>";
    }

    public function graficar_cuotas(){
      $tipo=$this->input->get('tipo');
      $valor=$this->input->get('valor');
      $monto_credito=$this->input->get('monto_credito');
      $fecha_inicio=$this->input->get('fecha_inicio');//se debe validar
      //-- que fecha no sea pasada
      $select_periodico=$this->input->get('select_periodico');
      $monto_cuota=0;
      $monto_final=0;
      $nro_cuotas=0;

      if($tipo==0){//por numero de cuotas
        $nro_cuotas=$valor;
        $monto_credito=$monto_credito+($nro_cuotas-1);
        // Obtener la Parte Entera de un Numero Decimal
        $a=$monto_credito/$valor;
        $parte_int_a=(int)$a; // 10
        $monto_cuota=$parte_int_a;
        $monto_final = ($monto_credito%$valor)+$monto_cuota-($nro_cuotas-1);
        if($monto_final==0)
        $monto_final=$monto_cuota;

      }else{//por monto fijo
        $monto_cuota=$valor;
        $a=$monto_credito/$valor;
        $parte_int_a=(int)$a;
        $nro_cuotas=$parte_int_a;
        $monto_final=$monto_credito%$valor;
        $nro_cuotas++;
        if($monto_final==0){
          $monto_final=$monto_cuota;
          $nro_cuotas--;
        }
      }
      echo "<p>PLAN DE PAGO GENERADO</p>";// tipo $tipo valor =$valor  monto_credito $monto_credito monto $monto_cuota  final $monto_final count $nro_cuotas<p>";
      echo'<div class="row">';
      $a=1;

      $fecha = new DateTime($fecha_inicio);


      while ($a < $nro_cuotas) {

        echo '<div class="col-sm-3 with-border" style="padding:2px;"><div class="bg-red" style="padding:5px;">'.
        'Cuota Nro: '.$a.'<br>Monto:'.$monto_cuota.'<br>'.'Fecha: '.$fecha->format('d-m-Y').
        '</div></div>';
        $a++;

        if($select_periodico==1){//Mensual

          $fecha->add(new DateInterval('P1M'));
          //$fecha = date("Y,m,d", strtotime("-1 month", $fecha));
        /*$fecha->add(new DateInterval('P1M')); No funca para dias 31 febrero no tiene
          $oldDay = $fecha->format("d");
          $fecha->add(new DateInterval("P1M")); // 2016-03-02
          $newDay = $fecha>format("d");

          if($oldDay != $newDay) {
              // Check if the day is changed, if so we skipped to the next month.
              // Substract days to go back to the last day of previous month.
              $fecha->sub(new DateInterval("P" . $newDay . "D"));
          }
*/
        }
        else if($select_periodico==2)//Semanal
          $fecha->add(new DateInterval('P7D'));
        else if($select_periodico==3)//quincenal
          $fecha->add(new DateInterval('P15D'));

      }
      echo '<div class="col-sm-3 with-border" style="padding:2px;"><div class="bg-yellow" style="padding:5px;">'.
      'Cuota Nro: '.$a.'<br>Monto:'.$monto_final.'<br>'.'Fecha: '.$fecha->format('d-m-Y').
      '</div></div>';
        echo "</div>";
        echo '<input type="hidden" id="res_nro_cuotas" value="'.$nro_cuotas.'"></input>';
        echo '<input type="hidden" id="res_monto_cuota" value="'.$monto_cuota.'"></input>';

    }


}
