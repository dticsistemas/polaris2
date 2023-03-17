<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  /**
   * Inventario class.
   *
   * @extends CI_Controller
   */
  class Compras extends CI_Controller {

  	/**
  	 * __construct function.
  	 *
  	 * @access public
  	 * @return void
  	 */
  	public function __construct() {
      parent::__construct();
      if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false)
      redirect('login');
  	}
    public function index() {
      //$this->load->model('persona_model');

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
    public function gastos(){
      $data=array();

      $this->load->library('grocery_CRUD');
      try {

        $crud = new grocery_CRUD();
        $crud->set_table('gastos');
        $crud->unset_clone();
        //$crud->unset_delete();
  			$crud->set_relation('id_persona','personas','{nombre} {apellidos}');
      /*  $crud->set_relation_n_n('categorias', 'categoria_productos', 'categorias', 'id_producto', 'id_categoria', 'nombre');
        $crud->add_action('Imagenes','../assets/img/upload_image.png', 'inventario/editar_imagenes_producto');
        */
        $crud->columns(array('id','detalle','monto','id_persona'));
        //$crud->add_fields(array('codigo','nombre','titulo','descripcion','especificaciones','categorias','precio_base','unidad_mayor','precio_mayor'));
        //if($crud->getState()!="add" && $crud->getState()!="edit" && $crud->getState()!="insert_validation" && $crud->getState()!="update_validation")
        $crud->display_as('id_persona','Personal');
        //------Mostrando imagenes del producto
      /*  $crud->unique_fields(array('nombre'));
        $crud->required_fields('codigo','nombre','titulo','precio_base','activo','unidad_mayor','precio_mayor');
        $crud->callback_column('imagen',array($this,'product_imagen_scale_callback'));
        $crud->callback_column('precio_mayor',array($this,'product_precio_mayor_callback'));
*/

        $output = $crud->render();
        $data = json_decode(json_encode($output), True);

  			$data['link_active']='compras/gastos';
        $data['nav']='catalogo';
        $this->vista_output('crud/plantilla_crud',$data);
      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }
    }


    public function proveedores(){
        $data=array();
        try{
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->unset_bootstrap();
        $crud->unset_jquery();
        $crud->unset_clone();
        $crud->set_table('proveedores');
        $crud->set_field_upload('fotografia','assets/img/fotografias');
        $crud->display_as('nit_rfc','NIT/RFC');
        $crud->display_as('empresa','Compañia/Empresa');
        $output = $crud->render();
        $data = json_decode(json_encode($output), True);
        $data['nav']='admin_web';
  			$data['link_active']='compras/proveedores';
        $this->vista_output('crud/plantilla_crud',$data);
      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }

    }
    public function compras(){
      $data=array();

      $this->load->library('grocery_CRUD');
      try {

        $crud = new grocery_CRUD();
        $crud->set_table('compras');
        $crud->unset_clone();
        //$crud->unset_delete();
        $crud->set_relation('id_persona','personas','{nombre} {apellidos}');
        $crud->set_relation('id_proveedor','proveedores','{nombre}');
        $crud->set_relation('id_producto','productos','{nombre}',['productos.tipo !=' => 'Producto']);
        $crud->set_relation('id_sucursal','sucursales','{nombre}');
        $crud->columns(array('id_persona','id_producto','id_usuario','id_proveedor','cantidad','monto','tipo','estado'));
        //$crud->fields(array('id_proveedor','id_producto','id_persona','fecha','tipo','estado','cantidad','monto','nota'));
        $crud->field_type('id_usuario', 'hidden',$_SESSION['user_id']);
        $crud->display_as('id_persona','Comprador');
        $crud->display_as('id_proveedor','Proveedor');
        $crud->display_as('id_producto','Producto');
        $crud->display_as('id_usuario','Imagen');

        $crud->callback_after_insert(array($this,  'log_compras_after_insert'));
        $crud->callback_column('id_usuario',array($this,'product_imagen_scale_callback'));


        $output = $crud->render();
        $data = json_decode(json_encode($output), True);

        $data['link_active']='compras/compras';
        $data['nav']='catalogo';
        $this->vista_output('crud/plantilla_crud',$data);
      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }
    }
    function product_imagen_scale_callback($value, $row)
    {
        $this->load->model('imagenes_model');
        $d=$this->imagenes_model->get_imagen_producto($row->id_producto);
        $imagen = base_url()."/assets/img/catalogo/small/".$d['imagen'];
        return '<div class="text-center "><img src="'.$imagen.'" height="50px"></div>';

    }
    function log_compras_after_insert($post_array,$primary_key)
    {
        $this->load->model('inventarios_model');
        $reposiciones = array(
            "id_producto" => $post_array['id_producto'],
            "cantidad" =>$post_array['cantidad'],
            "id_sucursal_destino" => $post_array['id_sucursal'],
            "id_sucursal_origen"=>0,
            "tipo"=>1, //adicionar
            "id_usuario"=>$post_array['id_usuario'],
            "nota"=>'compras id='.$primary_key
        );
        $this->db->insert('reposiciones',$reposiciones);
        $this->inventarios_model->actualizar_cantidad_productos($post_array['id_sucursal'],$post_array['id_producto'],$post_array['cantidad']);

        $this->db->insert('bitacora',array ('id_accion'=>13,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$primary_key ));



        return true;
    }
    /*public function compras_insumo(){


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
          $this->load->model('productos_model');
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
                'tipo'=>COMPRA_CONTADO
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
                //-----reponiendo producto por caso de compras en productos-Mercaderia

                if($this->inventarios_model->is_mercaderia($id_producto)){
                  $repo=array(
                    'id_producto'=>$id_producto,
                    'cantidad'=>$cant_producto,
                    'id_sucursal_destino'=>$id_sucursal,
                    'id_sucursal_origen'=>'',
                    'tipo'=>ADICIONAR,
                    'id_usuario'=>$this->session->userdata('user_id'),
                    'nota'=>'compras:'.$id_venta
                  );
                  $this->inventarios_model->insertar_reposicion($repo);
                  $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$id_producto,$cant_producto);
                }

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
                  //-----reponiendo producto por caso de compras en productos-Mercaderia

                  if($this->inventarios_model->is_mercaderia($id_producto)){

                    $repo=array(
                      'id_producto'=>$id_producto,
                      'cantidad'=>$cant_producto,
                      'id_sucursal_destino'=>$id_sucursal,
                      'id_sucursal_origen'=>'',
                      'tipo'=>ADICIONAR,
                      'id_usuario'=>$this->session->userdata('user_id'),
                      'nota'=>'compras:'.$id_venta
                    );
                    $this->inventarios_model->insertar_reposicion($repo);
                    $this->inventarios_model->actualizar_cantidad_productos($id_sucursal,$id_producto,$cant_producto);
                  }
              $i++;
              $response=$response."venta de ID=".$id_producto." cantidad ".$cant_producto." total= ".$monto_ventas."";
              $response=$response.'</p></div>';

            }




          }

        //----terminando d procesar las vntas Suspendidas
          $data['html_extra']=$response;


          //--Mostrando Formulario para realizar Venta Suspendida AL-CONTADO
          $this->load->model('categorias_model');
          $this->load->model('productos_model');
          $this->load->model('sucursales_model');
          $this->load->model('personas_model');
          //---preparando datos para la interfaz
          $categorias=$this->categorias_model->get_categorias();
          $productos=$this->productos_model->get_insumos_total();
          $sucursales=$this->sucursales_model->listSucursales();
          $vendedores=$this->personas_model->listVendedores();
          $combox_productos=array();
          foreach ($productos as $fila) {
              $combox_productos[$fila['id']]=$fila['nombre'];
          }
          $data['combox_productos'] = $combox_productos;
          $data['link_active']='compras/compras';
          $data['combox_sucursales']=$sucursales;
          $data['combox_vendedores']=$vendedores;
          $data['producto_inicial']=true;
          $data['datepicker']=true; //reemplazando datimepicker
          $data['timepicker']=true;
          $data['id_persona']=$_SESSION['id_persona'];
          $data['select2']=true;
          $data['clientename']=true;
          $data['success']='Compras registradas';



          $this->vista_output('compras/compras_view.php',$data);

          //$this->vista_output('compras_success.php',$data);
        //   redirect('compras/compras');
        }else{


            //--Mostrando Formulario para realizar Venta Suspendida AL-CONTADO
            $this->load->model('categorias_model');
            $this->load->model('productos_model');
            $this->load->model('sucursales_model');
            $this->load->model('personas_model');
						//---preparando datos para la interfaz
						$categorias=$this->categorias_model->get_categorias();
            $productos=$this->productos_model->get_insumos_total();
						$sucursales=$this->sucursales_model->listSucursales();
            $vendedores=$this->personas_model->listVendedores();
            $combox_productos=array();
            foreach ($productos as $fila) {
                $combox_productos[$fila['id']]=$fila['nombre'];
            }
            $data['combox_productos'] = $combox_productos;
            $data['link_active']='compras/compras';
            $data['combox_sucursales']=$sucursales;
            $data['combox_vendedores']=$vendedores;
						$data['producto_inicial']=true;
						$data['datepicker']=true; //reemplazando datimepicker
            $data['timepicker']=true;
            $data['id_persona']=$_SESSION['id_persona'];
            $data['select2']=true;
            $data['clientename']=true;
            //$data['modalcliente']=true;



            $this->vista_output('compras/compras_view.php',$data);
        }

    }*/

    }
