<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class Portal extends CI_Controller {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		/*if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false)
			redirect('login');
*/
	}
	public function index() {

		echo "Modulo Portal";
		//$this->load->model('persona_model');

	}
	public function vista_output($file_view,$output = null)
	{
		//---Enviando datos de inicio
		$data_aux=getScriptsInit();
		$output = (object) $output;
		$output->mensajes=$data_aux['mensajes'];
		$output->notificaciones=$data_aux['notificaciones']; ;

		$this->load->view('template/header_admin_view', $output);
		$this->load->view($file_view,(array)$output);
		$this->load->view('template/footer_admin_view', $output);

	}

	public function admin_diapositivas(){
		//--preparando la ediciones para administrar las imagende diapositivas
		$this->load->library('Image_CRUD');
		$image_crud = new Image_CRUD();

		$image_crud->set_primary_key_field('id');
		$image_crud->set_url_field('url');
		$image_crud->set_title_field('title');
		$image_crud->set_table('slideshow')
		->set_ordering_field('priority')
		->set_image_path('assets/img/web/slideshow');

		$output = $image_crud->render();
		$data=json_decode(json_encode($output), True);
		$data['nav']='catalogo';
		$data['extra_html']='<div class="alert alert-info"><h4>Subir Imagenes para el inicio de sitio Web</h4>'.
		'<p class="text-center">para su mejor visualizacion asegurese subir imagenes de una resolucion alta mayor a 600x300 pixeles</p></div>';
		$data['img_crud']=true;
		$this->vista_output('crud/plantilla_imgcrud',$data);
		//$this->load->view('crud/plantilla_imgcrud',$data);
	}
	public function admin_productos_destacados(){
		$data=array();
		$this->load->library('grocery_CRUD');
		try{
			$crud = new grocery_CRUD();
			$crud->unset_bootstrap();
			$crud->unset_jquery();
			$crud->unset_clone();
			$crud->set_table('destacados');
			$crud->display_as('id_producto','Nombre del Producto');
			$crud->set_relation('id_producto','productos','nombre');
			$data = $crud->render();
			$data->title_crud="Administrar Productos Destacados";
			$data->link_active='portal/admin_productos_destacados';
			$this->vista_output('crud/plantilla_crud',$data);

		}catch(Exception $e){
			echo $e->getMessage().' --- '.$e->getTraceAsString();
		}

	}
	public function admin_banners(){

			$data=array();

			$this->load->library('grocery_CRUD');
			try{
				$crud = new grocery_CRUD();
				$crud->unset_bootstrap();
				$crud->unset_jquery();
				$crud = new grocery_CRUD();
         $crud->set_table('banners');
         $crud->unset_delete();
         $crud->unset_add();
         $crud->set_field_upload('imagen','assets/img/web/banners');
         $data = $crud->render();

				$data->title_crud="Administrar Banners";
				$data->link_active='portal/admin_banners';
				$this->vista_output('crud/plantilla_crud',$data);
			}catch(Exception $e){
				$e->getMessage().' --- '.$e->getTraceAsString();
			}

		//echo 'prueba de configuracion';
	}

}
