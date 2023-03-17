<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class Administracion extends CI_Controller {

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

		echo "Modulo Administracion";
		//$this->load->model('persona_model');

	}
	public function vista_output($file_view,$output = null)
	{
		//---Enviando datos de inicio
		$data_aux=getScriptsInit();
		$output = (object) $output;
		$output->mensajes=$data_aux['mensajes'];
		//print_r($output->mensajes);
		$output->notificaciones=$data_aux['notificaciones'];

		$this->load->view('template/header_admin_view', $output);
		$this->load->view($file_view,(array)$output);
		$this->load->view('template/footer_admin_view', $output);

	}
	public function admin_personas(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			//$crud->unset_delete();
			$crud->set_table('personas');
			$crud->set_primary_key('id','personas');
			$crud->set_relation('id_sucursal','sucursales','nombre');
			$crud->set_rules( 'nombre', 'Nombre', 'required|regex_match[/^[a-z ,.]*$/i]' );
			$crud->set_rules( 'apellidos','Apellidos', 'required|regex_match[/^[a-z ,.]*$/i]' );
			$crud->set_relation_n_n('zonas', 'personal_zonas', 'zonas', 'id_persona', 'id_zona', 'nombre','orden');
			//$crud->add_fields(array('nombres','apellidos','fecha_nacimiento','sexo','direccion','telefono','tipo','fotografia','id_sucursal'));
			//$crud->edit_fields(array('nombre','apellidos','fecha_nacimiento','sexo','direccion','telefono','tipo','fotografia','id_sucursal','estado'));
			$crud->required_fields(array('nombre','apellidos','sexo','estado'));
			$crud->columns(array('fotografia','nombre','apellidos','ocupacion','id_sucursal','estado','direccion','telefono'));
			$crud->set_field_upload('fotografia','assets/img/fotografias');
			$crud->display_as('id_sucursal','Sucursal');
			$crud->callback_after_insert(array($this, 'persona_after_insert'));
			$crud->callback_before_delete(array($this,'persona_before_delete'));
			$data = $crud->render();
			$data->title_crud="Administrar Personas";
			$data->link_active='administracion/admin_personas';

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}

	}

	public function persona_after_insert($post_array,$primary_key){
			//--registrando en bitacora
		$this->db->insert('bitacora',array ('id_accion'=>5,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$primary_key ));;
		return $primary_key;
	}
	public function persona_before_delete($primary_key){
			//--registrando en bitacora
		$this->db->insert('bitacora',array ('id_accion'=>15,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$primary_key ));
		return $primary_key;
	}
	public function admin_zonas(){
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('zonas');
			$crud->required_fields(array('nombre','descripcion'));
			$crud->order_by('id','asc');
			$data = $crud->render();
			$data->title_crud="Administrar Area/Zonas";

			$data->link_active='administracion/admin_zonas';
			$this->vista_output('crud/plantilla_crud',$data);
		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}

		public function admin_sucursales(){
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('sucursales');
			$crud->required_fields(array('nombre','direccion','telefono','email','nota','tipo','location'));
			$data = $crud->render();
			$data->title_crud="Administrar Sucursales";
			$data->link_active='administracion/admin_sucursales';
			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function admin_clientes(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->unset_delete();
			$crud->set_table('clientes');
			$crud->set_primary_key('id','clientes');
			//$crud->set_rules( 'nombres', 'Nombre', 'required|regex_match[/^[a-z ,.]*$/i]' );
		///	$crud->set_rules( 'apellidos','Apellidos', 'required|regex_match[/^[a-z ,.]*$/i]' );
			$crud->set_field_upload('fotografia','assets/img/fotografias');
		//	$crud->fields(array('nombres','fecha_nacimiento','sexo','direccion','telefono','fotografia'));
			$crud->required_fields(array('nombres','sexo'));
			$data = $crud->render();
			$data->title_crud="Administrar Clientes";
			$data->link_active='administracion/admin_clientes';
			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function admin_cuentaclientes(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->unset_delete();
			$crud->set_table('cuenta_cliente');
			$crud->set_primary_key('id');
			$crud->set_relation('id','clientes','{nombres})');
			//$crud->set_rules( 'nombres', 'Nombre', 'required|regex_match[/^[a-z ,.]*$/i]' );
		///	$crud->set_rules( 'apellidos','Apellidos', 'required|regex_match[/^[a-z ,.]*$/i]' );
		//	$crud->set_field_upload('fotografia','assets/img/fotografias');
		//	$crud->fields(array('nombres','fecha_nacimiento','sexo','direccion','telefono','fotografia'));
			//$crud->required_fields(array('nombres','sexo'));
			if($crud->getState()=='edit'){
				$this->session->set_flashdata('id_cliente', $crud->getStateInfo()->primary_key);
				redirect('administracion/admin_cuenta_plan_pagos');
		  }
			$data = $crud->render();
			$data->title_crud="Administrar Cuenta de Clientes";
			$data->link_active='administracion/admin_cuentaclientes';
			//---notificando mensaje de error
			$mensaje=$this->session->flashdata('mensaje');
			if(!empty($mensaje))
			$data->error=$mensaje;
      $this->session->flashdata('id_cliente');

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function admin_cuenta_plan_pagos(){
		$data = array();
		$id_cliente=$this->session->flashdata('id_cliente');
		if($this->input->post('id_cliente'))
		$id_cliente=$this->input->post('id_cliente');

		$this->load->model('clientes_model');
		$this->load->model('plan_pago_model');
		$this->load->model('productos_model');
		$this->load->model('imagenes_model');
		$this->load->model('personas_model');
		//--obteniendo o creando cuenta de cliente
		$cuenta=$this->clientes_model->get_cuenta_cliente($id_cliente);
		if($cuenta==null){
			$this->session->set_flashdata('mensaje','Error al editar cuenta del cliente ID='.$id_cliente.' estado=null');
			redirect('administracion/admin_cuentaclientes');
		}
		if($this->input->post('butt_actualizar_cc')=='ok'){
			///actualizando cuenta cliente
			$data_cuenta=array(
				'id_cobrador'=> $this->input->post('id_cobrador'),
				'monto_credito_maximo'=>$this->input->post('monto_credito_maximo')
			);
			//-----actualizar la cuenta cliente--
			$this->clientes_model->actualizar_cuenta_cliente($data_cuenta,$id_cliente);
			$cuenta=$this->clientes_model->get_cuenta_cliente($id_cliente);
		}
		//----obteniendo plan pagos vigente----
		$plan_pago=$this->plan_pago_model->get_planpago_vigente_cliente($id_cliente);
		//----obteniendo cuotas generadas------
		$arr_cuotas=array();
		if($plan_pago!=null){
			$id_plan_pago=$plan_pago['id'];
			$arr_cuotas=$this->plan_pago_model->get_cuotas_planpago($id_plan_pago);
		}
			//echo "<p>sdsds<p>sdsd<p><entradno pasdas><p>asdasdasd<p>";
		//--obteniendo historico de pagos del clientes
		$arr_pagos=$this->plan_pago_model->get_pagos_by_id_cliente($id_cliente);
	//	echo "<p><p><p><p><p><p>"; var_dump($arr_pagos);
		$historico_pagos=array();
		if($arr_pagos!=null){
			foreach ($arr_pagos as $pago) {
				$id_pago=$pago['id'];
				$tipo=$pago['tipo'];
			//	echo "--------------------------->".$id_pago." - ".$tipo."<br>";
				if($tipo!=0){
				$arr_cuotas_tmp=array();
				$tmp_cuotas=$this->plan_pago_model->get_cuotas_pagadas($id_pago);
				$id_plan_pago_aux=0;

				if($tmp_cuotas!=null){
					foreach ($tmp_cuotas as $pago_cuota) {
						$id_plan_pago=$pago_cuota['id_plan_pago'];
						$id_plan_pago_aux=$id_plan_pago;
						$numero=$pago_cuota['numero'];
						$cuota=$this->plan_pago_model->get_cuota_pagada_by_id_numero($id_plan_pago,$numero);
						if($cuota==null){
							$cuota=array();
							//---rellenando por default u vacio
						}
						$cuota['pago_monto']=$pago_cuota['monto'];
						$arr_cuotas_tmp[]=$cuota;

					}
				}
				$pago['cuotas']=$arr_cuotas_tmp;
				$pago['id_plan_pago']=$id_plan_pago_aux;
				//--obteniendo una referencia al plan de pago relacionado al pago de esa cuota
				///$plan_pago_ref=$this->plan_pago_model->get_planpago_by_id($id_cliente);
				//---anexando la info del pagos

				$historico_pagos[]=$pago;
			}else{
				//---el tipo==0 es pago por otros motivos no pagando cuotas
			}

			}


		}
	 	if($this->input->post('info')=='ok')
		$data['info']='Cuenta del Cliente Reprogramada';
		if($this->input->post('success')=='ok')
	  $data['success']='Cuenta del Cliente Actualizada';
		$data['link_active']='administracion/admin_cuentaclientes';
		$data['select_cobrador']=$this->personas_model->listCobradores();
		$data['cuenta_cliente']=$cuenta;
		$data['plan_pago']=$plan_pago;
		$data['cuotas']=$arr_cuotas;
		$data['historico_pagos']=$historico_pagos;
		$this->vista_output('clientes/cuenta_clientes_view',$data);
	}
	public function mensajes(){
		//$data['title_crud']="Mensajes";
		$this->load->model('mensajes_model');
		$this->load->model('user_model');
		$id_usuario=$this->session->userdata('user_id');
		if($this->input->post('butt_mensaje')=='ok'){
			$data_mensaje=array(
				'id_remitente'=>$id_usuario,
				'mensaje'=>$this->input->post('message'),
				'id_destinatario'=>$this->input->post('id_destinatario'),
				'estado'=>'pendiente'
			);
			$this->mensajes_model->registrar($data_mensaje);
		}
		$arr_color=array('primary','warning','info ','success','danger');
		$id_color=0;
		$arr_users_colors=array();
		$arr_colors_users=array();
    $arr_mensajes=$this->mensajes_model->get_mensajes_usuarios_pendientes($id_usuario);
		if(count($arr_mensajes)==0)
		$arr_mensajes=$this->mensajes_model->get_mensajes_usuarios($id_usuario);
		$this->mensajes_model->set_mensajes_leidos($this->session->userdata('user_id'));
		$data['link_active']='mensajes';
		$data['combox_usuario']=$this->user_model->get_otros_usuarios($id_usuario);
		$mensajes=array();
		foreach ($arr_mensajes as $mensaje) {
			$id_remit=$mensaje['id_remitente'];
			$id_desti=$mensaje['id_destinatario'];
			$rem=$this->user_model->get_usuario_id($id_remit);
			$dest=$this->user_model->get_usuario_id($id_desti);
			$mensaje['remitente']=$rem['username'];
			$mensaje['avatar_remitente']=$this->user_model->get_fotografia_user($id_remit);
			$mensaje['destinatario']=$dest['username'];
			$mensaje['avatar_destinatario']=$this->user_model->get_fotografia_user($id_desti);
			$buscar=$id_remit;
			if($id_remit==$id_usuario){
				$buscar=$id_desti;
			}else{

			}
			$color=array_search($buscar, $arr_users_colors);
			//echo "bucando ".$id_remit." encntrando:".$color."<-<br><p><p><p>ds";
			if(is_bool($color)){

			if($id_color>4)$id_color=0;
			$arr_users_colors[]=$buscar;
			$arr_colors_users[]=$arr_color[$id_color];
		//	echo "entra poniendo:".$arr_color[$id_color]." <p>";
			$color=$id_color;
			$id_color++;

			}
			$mensaje['estilo']=$arr_colors_users[$color];


			$mensajes[]=$mensaje;
		}
		$data['arr_mensajes']=$mensajes;
		$data['id_usuario']=$id_usuario;

		$this->vista_output('sistema/mensajes_admin_view',$data);
	}
	public function admin_dispositivos(){
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->unset_delete();
			$crud->set_table('dispositivos');
			$crud->set_relation('id_usuario','usuarios','username');
			//$crud->set_rules( 'nombres', 'Nombre', 'required|regex_match[/^[a-z ,.]*$/i]' );
		///	$crud->set_rules( 'apellidos','Apellidos', 'required|regex_match[/^[a-z ,.]*$/i]' );
			$crud->required_fields(array('keyAPK','id_usuario'));
			$crud->display_as('id_usuario','Usuario');
			$data = $crud->render();
			$data->title_crud="Administrar Dispositivos";
			$data->link_active='administracion/admin_dispositivos';
			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function notificaciones(){
		$data['title_crud']="No implementado";
		$this->load->model('configuracion_model');

		if($this->input->post('butt_notificacion')=='ok'){
			$id=$this->input->post('id');
			$this->configuracion_model->set_inactivo_notificacion($id);
			$res=array('result'=>true);
			echo json_encode($res);
		}else{
			$data['notificaciones']=$this->configuracion_model->get_notificaciones_pendientes();
			if(count($data['notificaciones'])<=0)
			$data['info']='No Existe notificaciones activas en el sistma';
			$data['link_active']='notificaciones';
			$this->vista_output('sistema/notificaciones_admin_view',$data);
	  }
	}
	//////////////////////////
	public function generar_fichas_cuota(){
		//---generar fichas de cuotas html
		$this->load->model('plan_pago_model');

		if($this->input->post('id_plan_pago')){
				$id_plan_pago=$this->input->post('id_plan_pago');
				$cuotas=$this->plan_pago_model->get_cuotas_planpago($id_plan_pago);

				foreach ($cuotas as $cuota) {
		    echo '<div class="col-sm-3" id="ficha_'.$cuota['numero'].'">';
		    if($cuota['estado']=='A')//pendiente
		    echo '<div class="info-box bg-aqua">';
		    else if($cuota['estado']=='P')//pagado
		    echo '<div class="info-box bg-green">';
		    else if($cuota['estado']=='M')//mora
		    echo '<div class="info-box bg-red">';
		    else if($cuota['estado']=='B')//a medias
		    echo '<div class="info-box bg-yellow">';
		    if($cuota['estado']=='X')//cancelado
		    echo '<div class="info-box bg-black">';

		    echo 'Nro:'.$cuota['numero'].'<br>';
		    echo 'Monto:'.$cuota['monto_cuota'].'<br>';
		    echo 'Pagado:'.$cuota['monto_pagado'].'<br>';
		    echo 'Estado:'.$cuota['estado'].'<br>';
		    echo 'Fecha a cobrar:'.$cuota['fecha_pago'].'<br>';
		    echo 'Fecha pagada:'.$cuota['fecha_pagada'].'<br>';
		    echo 'Cobrador:'.$cuota['id_cobrador'].'<br>';
		    echo '</div>';
		    //echo '<input type="checkbox"  class="btn btn-danger" id="check_<?=>';
		    echo '<button type="button" id="btn_<?=$i?>" data-toggle="modal"';
		    echo '  onclick="editarCuota('.$cuota['numero'].','.$cuota['id_plan_pago'].')" data-target="#myModalEdit"';
		    echo '  class="btn btn-primary btn-xs">';
		    echo '  <span class="btn-xs glyphicon glyphicon-edit"> Edit</span>';
		    echo '</button>';
		    echo '</div>';
		    }
		}

	}
	public function obtener_cuota(){

		$this->load->model('plan_pago_model');

		if($this->input->post('id_plan_pago')){

			$id_plan_pago=$this->input->post('id_plan_pago');
			$numero=$this->input->post('numero');
			$res=$this->plan_pago_model->get_cuota_pagada_by_id_numero($id_plan_pago,$numero);
			echo json_encode($res);
		}
	}
	public function modificar_cuota(){

		$this->load->model('plan_pago_model');

		if($this->input->post('id_plan_pago')){

			$data=array(
			 			'fecha_pago'=>$this->input->post('fecha_pago'),
						'monto_cuota'=>$this->input->post('monto_cuota'),
						'monto_pagado'=>$this->input->post('monto_pagado'),
						'fecha_pagada'=>$this->input->post('fecha_pagada'),
						'estado'=>$this->input->post('estado'),
						'id_cobrador'=>$this->input->post('id_cobrador')
					);
			$id_plan_pago=$this->input->post('id_plan_pago');
			$numero=$this->input->post('numero');
			$motivo=$this->input->post('motivo');
			//----validando si es factible modificar la cuota
			// .....
			//----realizando calculo de cuotas desplazadas
			//--obteniendo el plana de pago
			//---generando el actualizado de cuotas desplzando los siguientes segun corresponda
			//-----------------------solo montos
			$res['resultado']=$this->plan_pago_model->update_cuota($id_plan_pago,$numero,$data);

			echo json_encode($res);
		}
	}
	public function reprogramar_plan_pago(){
		$this->load->model('plan_pago_model');
		$this->load->model('clientes_model');


		if($this->input->post('id_plan_pago')){

		/*data: {'id_plan_pago': id_plan_pago,'id_cliente':<?=$cuenta_cliente['id']?>,'monto_total':$('#rep_monto_total').val(),
    'monto_inicial':$('#rep_multa').val(),'nro_cuotas':$('#rep_nro_cuotas').val(),'tipo_periodico':$('#rep_tipo_periodico').val(),
    'multa':$('#rep_multa').val(),'monto_cuotas':$('#rep_monto_cuota').val(),
    'fecha_inicio':$('#rep_fecha_inicio').val(),'estado':$('#rep_estado').val(),'nota':$('#rep_nota').val()},
  */
			$id_plan_pago=$this->input->post('id_plan_pago');
			$id_cliente=$this->input->post('id_cliente');
			$deuda_anterior=$this->input->post('monto_total');
			$multa=$this->input->post('multa');
			$monto_total=$deuda_anterior+$multa;
			$nro_cuotas=$this->input->post('nro_cuotas');
			$monto_inicial=$this->input->post('monto_inicial');
			$monto_cuotas=$this->input->post('monto_cuotas');
			$tipo_periodico=$this->input->post('tipo_periodico');
			$fecha_inicio=$this->input->post('fecha_inicio');
			$estado='A';//$this->input->post('estado');
			$nota=$this->input->post('nota');
			$res['resultado']=false;
			//---verificando las cifras antes de reprogramarPlanPago---
			//       deuda+saldo == deuda anterior
			$cc_revisar=$this->clientes_model->get_cuenta_cliente($id_cliente);
			$cc_cuenta_cliente=$cc_revisar['cuenta_cliente'];
			//----validando que la cuenta del cliente no se haya modificado


			if(($cc_cuenta_cliente['deuda']+$cc_cuenta_cliente['saldo'])==$deuda_anterior){
			//   plan de pago debe estar vigentes y cambiar a reprogramado
			// cuotas pendientes deben actualizarce a cancelado
			//---creando el nuevo plan de pago

			//-----------cuenta cliente-------------
			$data_cuenta=array(
				'id'=>	$id_cliente,
				'monto_credito_maximo'=>$cc_cuenta_cliente['monto_credito_maximo'],
				'deuda'=>$monto_total,//sustituye  deudas que es anterior
				'saldo'=>0,
				'estado'=>'P',//Pendiente
				'tipo'=>0
			);


			//-----actualizar la cuenta cliente--
			$this->clientes_model->actualizar_cuenta_cliente($data_cuenta,$id_cliente);
			//anulando el anterio plan de PAGO
			//anulando las cuotas faltantes a pagar
			$id_plan_anterior=$this->plan_pago_model->anular_plan_pagos_cuotas($id_cliente);
			//registrando nuevo plan de PAGO
			//	echo "anulando plan anterior<p>";

			$data_plan=array(
				'id_cliente'=>$id_cliente,
				'monto_total'=>$monto_total,
				'deuda_anterior'=>$deuda_anterior,
				'monto_inicial'=>$monto_inicial,
				'nro_cuotas'=>$nro_cuotas,
				'tipo_periodico'=>$tipo_periodico,
				'monto_cuotas'=>$monto_cuotas,
				'fecha_inicio'=>$fecha_inicio,
				'estado'=>'A',//Activo
				'nota'=>$nota,
				'id_plan_anterior'=>$id_plan_anterior

			);
			$id_plan=$this->plan_pago_model->insertar_plan_pagos($data_plan);
			//generando las cuotas
			$monto_final=$monto_total;
			$fecha_aux = new DateTime($fecha_inicio);

			$a=1;
			while ($a <$nro_cuotas) {
				$monto_final=$monto_final-$monto_cuotas;
				//---insertando las cuotas
				$data_cuota=array(
					'id_plan_pago'=>$id_plan,
					'numero'=>$a,
					'fecha_pago'=>$fecha_aux->format('Y-m-d'),
					'monto_cuota'=>$monto_cuotas,
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
				else
					$fecha_aux->add(new DateInterval('P1M'));
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
				$res['resultado']=true;


		  }

			echo json_encode($res);
		}
	}




}
