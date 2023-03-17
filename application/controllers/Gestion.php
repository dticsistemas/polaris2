<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class Gestion extends CI_Controller {

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

		echo "Modulo Gestion";
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
		$this->load->view('template/footer_admin_view', $output);s

	}
	public function compras(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('compras');
			$crud->set_relation('id_material','materiales','{nombre} | Medida:{medida}');
			$crud->set_relation('id_persona','personas','{nombres} {apellidos}');
			$crud->add_fields(array('descripcion','id_material','cantidad','costo','fecha','id_persona'));
			$crud->required_fields(array('descripcion','id_material','cantidad','costo','fecha','id_persona'));
			$crud->display_as('id_material ', 'Material');
			$crud->display_as('id_personas', 'Personal');
			$crud->callback_after_insert(array($this, 'compras_after_insert'));
			$data = $crud->render();
			$data->title_crud="Gestionar Compras";

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	function compras_after_insert($post_array,$primary_key){
			//--registrando en bitacora
		$cantidad    =$post_array['cantidad'];
		$id_material =$post_array['id_material'];
		$this->db->insert('bitacora',array ('id_accion'=>3,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$primary_key));

		$this->db->set('cantidad', 'cantidad+'.$cantidad, FALSE);
		$this->db->where('id', $id_material);
		$this->db->update('materiales');
		return $primary_key;

	}
	public function gastos(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('gastos');
			$crud->set_relation('id_persona','personas','{nombres} {apellidos}');
			$crud->add_fields(array('descripcion','motivo','costo','fecha','id_persona'));
			$crud->required_fields(array('descripcion','motivo','costo','fecha','id_persona'));
			$crud->display_as('id_personas', 'Personal');
			$crud->callback_after_insert(array($this, 'compras_after_insert'));
			$data = $crud->render();
			$data->title_crud="Gestionar Gastos";

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function ventas(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('ventas');
			$crud->set_relation('vendedor','personas','{nombres} {apellidos}');
			$crud->set_relation('cliente','clientes','{nombres} {apellidos}');
			$crud->set_relation('id_actividad','actividades','nombre');
			$crud->set_relation('id_variedad','variedades','nombre');
			$crud->required_fields(array('id_actividad','id_variedad','cantidad','medida','monto','tipo','vendedor'));
			$crud->display_as('id_actividad', 'Produccion');
			$crud->field_type('estado','invisible');
			$crud->callback_after_insert(array($this, 'compras_after_insert'));
			$data = $crud->render();
			$data->title_crud="Gestionar Ventas";

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function clientes(){
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
			$crud->set_rules( 'nombres', 'Nombre', 'required|regex_match[/^[a-z ,.]*$/i]' );
			$crud->set_rules( 'apellidos','Apellidos', 'required|regex_match[/^[a-z ,.]*$/i]' );
			$crud->add_fields(array('nombres','apellidos','fecha_nacimiento','sexo','direccion','telefono'));
			$crud->required_fields(array('nombres','apellidos','sexo'));
			$data = $crud->render();
			$data->title_crud="Administrar Clientes";

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function viajes(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('viajes');
			$crud->set_relation('id_zona_1','zonas','nombre');
			$crud->set_relation('id_zona_2','zonas','nombre');
			$crud->set_relation('id_zona_3','zonas','nombre');
			$crud->set_relation_n_n('pasajeros', 'viaje_persona', 'personas', 'id_viaje', 'id_persona', '{nombres} {apellidos}');
			$crud->columns(array('fecha','descripcion','observacion','transporte','costo','img_zona_1','img_zona_2','img_zona_3'));
			$crud->required_fields(array('fecha','descripcion','observacion','transporte','costo'));
			$crud->unset_texteditor('observacion');
			$crud->set_field_upload('img_zona_1','assets/uploads/files');
			$crud->set_field_upload('img_zona_2','assets/uploads/files');
			$crud->set_field_upload('img_zona_3','assets/uploads/files');
			$crud->display_as('id_zona_1', 'Zona 1');
			$crud->display_as('id_zona_2', 'Zona 2');
			$crud->display_as('id_zona_3', 'Zona 3');
			$crud->display_as('img_zona_1', 'IMGZona 1');
			$crud->display_as('img_zona_2', 'IMGZona 2');
			$crud->display_as('img_zona_3', 'IMGZona 3');
			$data = $crud->render();
			$data->title_crud="Gestionar Viajes";

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function actividades(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->unset_read();
			$crud->set_table('actividades');
			$crud->set_relation_n_n('areas', 'actividad_zona', 'zonas', 'id_actividad', 'id_zona', 'nombre');
			$crud->set_relation_n_n('tareas', 'actividad_tarea', 'tareas', 'id_actividad', 'id_tarea', 'nombre');
			$crud->set_relation_n_n('herramientas', 'uso_herramienta', 'herramientas', 'id_actividad', 'id_herramienta', 'nombre',null,array('estado'=>'Disponible') );
			//$crud->set_relation_n_n('personas', 'actividad_persona', 'personas', 'id_actividad', 'id_persona', 'nombres',null,null,TRUE);
			$crud->columns(array('nombre','fecha_inicio','fecha_fin'));
			$crud->fields(array('nombre','tareas','areas','fecha_inicio','fecha_fin','descripcion','herramientas'));
			$crud->required_fields(array('nombre','fecha_inicio','descripcion'));
			$crud->add_action('Personas', base_url().'assets/img/personas.jpg', 'gestion/actividades_personas','ui-icon-image');
			$crud->add_action('Consumos', base_url().'assets/img/consumos.png', 'gestion/actividades_consumos','ui-icon-image');
			$crud->add_action('Cosechas', base_url().'assets/img/cosechas.jpg', 'gestion/actividades_cosechas','ui-icon-image');

			$data = $crud->render();
			$data->title_crud="Gestionar Actividades";

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function actividades_personas($id_actividad){
		//$id_actividad=$this->input->get(3);
		//echo "<p>".$id_actividad."</p>";
		$this->session->set_userdata('id_actividad', $id_actividad);
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			//$crud->unset_edit();
			$crud->set_table('actividad_persona');
			$crud->set_relation('id_persona','personas','{nombres} {apellidos}');
			$crud->fields(array('id_actividad','tiempo','costo','id_persona'));
			$crud->where('id_actividad',$id_actividad);
			$crud->required_fields(array('tiempo','costo','id_persona'));
			$crud->field_type('id_actividad','invisible');
			$crud->display_as('id_personas', 'Persona');
			$crud->display_as('id_actividad', 'Actividad');
			//-----------------//
			$crud->callback_before_insert(array($this,'add_id_actividad_callback'));
			$data = $crud->render();
			$data->title_crud="Gestionar Personas de Actividad";
			$data->extra_html='<div class="pull-right">
                    <a href="'.base_url().'gestion/actividades" class="btn btn-primary"> Volver a Actividades</a>
                  </div>';

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	function add_id_actividad_callback($post_array) {
		$id_actividad = $this->session->userdata('id_actividad');


		$post_array['id_actividad'] =$id_actividad;

		//$this->db->insert('bitacora',array ('id_accion'=>3,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>$primary_key.'=>'.implode(',',$post_array)));

		return $post_array;
	}
	public function actividades_consumos($id_actividad){
		//$id_actividad=$this->input->get(3);
		//echo "<p>".$id_actividad."</p>";
		$this->session->set_userdata('id_actividad', $id_actividad);
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			//$crud->unset_edit();
			$crud->set_table('consumos');
			$crud->set_relation('id_material','materiales','{nombre} | Medida:{medida}');
			$crud->fields(array('id_actividad','id_material','consumido','estado','notificacion'));
			$crud->where('id_actividad',$id_actividad);
			$crud->required_fields(array('id_material','consumido','estado','notificacion'));
			$crud->field_type('id_actividad','invisible');
			$crud->display_as('id_material', 'Material');
			//-----------------//
			$crud->callback_before_insert(array($this,'add_id_actividad_callback'));
			$crud->callback_after_insert(array($this, 'consumo_after_insert'));
			$data = $crud->render();
			$data->title_crud="Gestionar Materiales de Actividad";
			$data->extra_html='<div class="pull-right">
                    <a href="'.base_url().'gestion/actividades" class="btn btn-primary"> Volver a Actividades</a>
                  </div>';

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	function consumo_after_insert($post_array,$primary_key){
			//--registrando en bitacora
		$cantidad    =$post_array['consumido'];
		$estado      =$post_array['estado'];
		if($estado=="Agotado"){
			//----se debera informar en notificacion
			$this->db->insert('bitacora',array ('id_accion'=>4,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>'Agotado insumo'));
			$id_material =$post_array['id_material'];
			$this->db->set('cantidad', '0', FALSE);
			$this->db->where('id', $id_material);
			$this->db->update('materiales');
		}else if($estado=="Dañado"){
			//----se debera informar en notificacion
			$this->db->insert('bitacora',array ('id_accion'=>4,'id_usuario'=>$_SESSION['user_id'],'ip'=>$_SERVER ['REMOTE_ADDR'],'data'=>'Daño herramienta'));
		}else{
			$id_material =$post_array['id_material'];
			$this->db->set('cantidad', 'cantidad-'.$cantidad, FALSE);
			$this->db->where('id', $id_material);
			$this->db->update('materiales');
		}
		return $primary_key;


	}
	public function actividades_cosechas($id_actividad){
		//$id_actividad=$this->input->get(3);
		//echo "<p>".$id_actividad."</p>";
		$this->session->set_userdata('id_actividad', $id_actividad);
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			//$crud->unset_edit();
			$crud->set_table('producciones');
			$crud->set_relation('id_variedad','variedades','nombre');
			$crud->fields(array('id_actividad','id_variedad','cantidad','medida'));
			$crud->where('id_actividad',$id_actividad);
			$crud->required_fields(array('id_variedad','cantidad','medida'));
			$crud->field_type('id_actividad','invisible');
			$crud->display_as('id_variedad', 'Variedad');
			//-----------------//
			$crud->callback_before_insert(array($this,'add_id_actividad_callback'));
			$data = $crud->render();
			$data->title_crud="Gestionar Cosecha de Actividad";
			$data->extra_html='<div class="pull-right">
                    <a href="'.base_url().'gestion/actividades" class="btn btn-primary"> Volver a Actividades</a>
                  </div>';

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function programaciones(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('programaciones');
			$crud->set_relation('id_tarea','tareas','nombre');
			$crud->set_relation('id_terreno','terrenos','nombre');
			$crud->required_fields(array('fecha_estimada','fecha_limite','descripcion','tipo','estado','id_terreno'));
			$crud->display_as('id_terreno','Terreno');
			$data = $crud->render();
			$data->title_crud="Gestionar Programacion Tareas";
			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function notificaciones(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('notificaciones');
			$crud->required_fields(array('mensaje','fecha_inicio','fecha_fin','tipo','estado'));
			$data = $crud->render();
			$data->title_crud="Administrar Notificaciones";

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
	public function experiencias(){
		$data=array();

		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('experiencias');
			$crud->set_relation('id_zona','zonas','nombre');
			$crud->fields(array('id_zona','nombre','fecha_inicio','fecha_fin','descripcion','metodologia','resultado','conclusiones','estado'));
			$crud->required_fields(array('id_zona','nombre','fecha_inicio','fecha_fin','descripcion','metodologia','estado'));
			$crud->display_as('id_zona', 'Zona');
			$data = $crud->render();
			$data->title_crud="Gestionar Experiencias";

			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}
	}
}
