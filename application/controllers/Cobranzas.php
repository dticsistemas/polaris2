<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class Cobranzas extends CI_Controller {

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

		echo "Modulo Cobranzas";
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

	public function consignaciones(){

			 $this->load->model('consignacion_model');
			 $this->load->model('clientes_model');
			 $arr_consignacion=$this->consignacion_model->get_consignacion_pendientes_global_cliente();
			 $consignaciones=array();
			 foreach ($arr_consignacion as $consignacion) {
				 $id_producto=$consignacion['id_producto'];
				 $consignacion['nombre_cliente']=$this->clientes_model->get_namecliente_from_id($consignacion['id_cliente']);
				 $consignacion['cantidad']=$this->consignacion_model->get_cant_productos_by_cliente($consignacion['id_cliente']);
				 $consignacion['total']=$this->consignacion_model->get_monto_deuda_pendiente($consignacion['id_cliente']);
				 $consignaciones[]=$consignacion;
			 }
			 $data['title_crud']="Cobranzas Consignacion";
			 $data['select2']=true;
			 $data['clientename']=true;
			 $data['arr_consignaciones']=$consignaciones;
			 $error=$this->session->flashdata('pedidos_cliente');
			 if($error!=null)
			 $data['error']=$error;
			 $this->vista_output('cobranzas/list_consignacion_view',$data);

	 }
	public function consignacion_cobranzas(){

			$data['link_active']='cobranzas/consignaciones';
			$id_cliente=0;
			if($this->input->post('butt_gestionar')=="ok"){
				$id_cliente=$this->input->post('id_cliente');
			}
			$id_aux=$this->session->flashdata('id_cliente');
			if($id_aux!=null)
			$id_cliente=$id_aux;
			/////////////////////////////////////////////////////////////////
			if($this->input->post('butt_consignacion_procesar')=="ok"){
				//print_r($_POST);
				$id_cliente=$this->input->post('id_cliente');

				$this->load->model('clientes_model');
				$this->load->model('consignacion_model');
				$this->load->model('ventas_model');
				$this->load->model('inventarios_model');
				$arr_id           =explode(",",$this->input->post('arr_id'));
				$arr_orden        =explode(",",$this->input->post('arr_orden'));
				$arr_montos       =explode(",",$this->input->post('arr_montos'));
				$arr_fecha_inicio =explode(",",$this->input->post('arr_fecha_inicio'));
				$arr_vendidos     =explode(",",$this->input->post('arr_vendidos'));
				$arr_anotacion    =explode(",",$this->input->post('arr_anotacion'));
				$i=0;
				$monto_sumado=0;
				foreach ($arr_id as $id) {
					$orden=$arr_orden[$i];
					$fecha_inicio=$arr_fecha_inicio[$i];
					$cantidad_vendida=$arr_vendidos[$i];
					$anotacion=$arr_anotacion[$i];
					$this->consignacion_model->finalizar($id,$orden,$fecha_inicio,$cantidad_vendida,$anotacion);
					//----obteniendo consignacion----
					$consig=$this->consignacion_model->obtener_consignacion($id,$orden,$fecha_inicio);
					//---es un nuevo grupo de venta
					$cantidad=$consig['cantidad'];
					$cantidad_vendida=$consig['cantidad_vendida'];
					//$monto=$cantidad=$consig['total'];
					//$precio=round($cantidad/$monto);
					$total=$arr_montos[$i];

					$data_ventas= array(
							'id_usuario'=>$this->session->userdata('user_id'),
							'fecha'=>date('Y-m-d H:i:s'),
							'id_cliente'=>$id_cliente,
							'nota'=>'venta por consignacion ['.$id.'] pago total',
							'total'=>$total,//precio*$cantidad_vendida,
							'estado'=>'0',//--opt debe ser finalizada
							'transferida'=>$id.','.$orden.','.$consig['fecha_devolucion'],
							'id_vendedor'=>$consig['id_vendedor'],
							'id_sucursal'=>$consig['id_sucursal'],
							'tipo'=>VENTA_CONSIGNACION
							);
						$id_venta = $this->ventas_model->insertar_ventas($data_ventas);
					//-----caso ventas productos--------
 						 $data_venta_productos = array(
 								 'id_venta'=>$id_venta,
 								 'id_producto'=>$consig['id_producto'],
 								 'orden'=>$consig['orden'],
 								 'cantidad'=>$cantidad_vendida,//--solo las vendidas
 								 'precio'=>$total
 								 );
 						 $this->ventas_model->insert_ventas_productos($data_venta_productos);

 						 //------caso de stock-------------
 								 //-----reponiendo al stock de los productos
 						 if($cantidad>$cantidad_vendida){
 						 	$this->inventarios_model->actualizar_cantidad_productos($consig['id_sucursal'],$consig['id_producto'],($cantidad-$cantidad_vendida));
							//notificacion
							$this->db->insert('notificaciones',array ('title'=>'Consignacion.- Devolver Productos','mensaje'=>'La consignacion del cliente['.
							$id_cliente.'] ha devuelto '.($cantidad-$cantidad_vendida). ' deberan ser'.
							' devueltas al origen de la sucursal','tipo'=>'Informativo','estado'=>'Activo'));

					 	}


				$i++;
			}
			$this->session->set_flashdata('id_cliente',$id_cliente);
			redirect('cobranzas/consignacion_cobranzas');
		}

			////////////////////////////////////////////////////////////
			///----llamada inicial----
			if($id_cliente>0){
				//echo " validadnod id de cliente";
				$this->load->model('clientes_model');
				$this->load->model('consignacion_model');
				$this->load->model('productos_model');
				$this->load->model('imagenes_model');
				//--obteniendo o creando cuenta de cliente
				$cuenta=$this->clientes_model->get_cuenta_cliente($id_cliente);
				//print_r($cuenta);
				$data['monto_pendiente']=$this->consignacion_model->get_monto_deuda_pendiente($id_cliente);
				if($cuenta!=null){
					//---verificando cuenta de cliente y pdidos anteriores
					$old_pedidos=$this->consignacion_model->get_consignacion_pendientes_cliente($id_cliente);
					$pedidos=array();
					foreach ($old_pedidos as $pedido) {
						$id_producto=$pedido['id_producto'];
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
					$data['producto_inicial']=true;
					$data['datepicker']=true;
					$data['datepicker2']=true;
				  $data['title']='- Consignacion';
					$data['id_persona']=$_SESSION['id_persona'];
					$data['select2']=true;
					//$data['clientename']=true;
					//$data['modalcliente']=true;

					$this->vista_output('cobranzas/consignaciones_view',$data);

				}else{
					//---el cliente no es validao
					redirect('cobranzas/consignaciones');
					$this->session->set_flashdata('pedidos_cliente', 'El id del cliente no es valido');
				}

			}else{
				//---cliente no enviado
				$this->session->set_flashdata('pedidos_cliente', 'Seleccione un cliente para poder gestionar la consignacion');

				redirect('cobranzas/consignaciones');
			}

		}




}
