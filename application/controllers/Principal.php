<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Principal extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

  public function __construct()
  {
          parent::__construct();
          // Your own constructor code
					//---añadimos los modelo a utilizar*/
			  	$this->load->model('categorias_model');
			 		$this->load->model('imagenes_model');
			 		$this->load->model('productos_model');
			 		$this->load->model('mensajes_model');
			 		$this->load->model('sucursales_model');
			 		$this->load->model('slideshow_model');
			 		$this->load->model('banners_model');
          $this->load->library('cart');
  }
	 public function index()
	 {


	 		$data = array();
	 		$data['slideshow']  = $this->slideshow_model->get_imagenes();
	 		$data['captcha'] = $this->iniciarCaptcha();
	 	  $this->mostrarVista($data,'principal_view');
			//$this->load->view('principals_view');

	 }
	 public function alternativa()
	{

		 //---añadimos los modelo a utilizar*/
		 $this->load->model('categorias_model');
		 $this->load->model('imagenes_model');
		 $this->load->model('productos_model');
		 $this->load->model('mensajes_model');
		 $this->load->model('sucursales_model');
		 $this->load->model('slideshow_model');
		 $this->load->model('banners_model');
		 $data = array();
		 $data['slideshow']  = $this->slideshow_model->get_imagenes();
		 //---parametros a enviar configurables
		 $data['mensaje'] = $this->obtenerMensajeBienvenida();
		 $data['empresa'] = EMPRESA;
		 $data['titulo']  = TITLE;
		 $data['categorias'] = $this->categorias_model->get_categorias_visibles();
		 $data['sucursales'] = $this->sucursales_model->get_sucursales();
		 $data['banners']    = $this->banners_model->get_banners();
     $data['carrito'] = $this->cart->total_items();
		 $destacados_aux  = $this->productos_model->get_productos_destacados();
		 $destacados = null; $cont = 0;
		 foreach ($destacados_aux as $producto) {
				 $imagen = $this->imagenes_model->get_imagen_producto($producto['id_producto']);
				 if($imagen==null){
						 $producto['imagen']='no_image.png';
				 }else{
						 $producto['imagen']= $imagen['imagen'];
				 }
				 $destacados[$cont]=$producto;
				 $cont++;
		 }
		 $data['productos_destacados']= $destacados ;

		 $this->load->view('web/template/tp_header_views',$data);
		 $this->load->view('principals_view',$data);
		 $this->load->view('web/template/tp_footer_views');

		 //$this->load->view('principals_view');

	}
	public function obtenerMensajeBienvenida()
	 {
			 //---permite mostrar mensaje de la Bd para ser mas interactivo la web
		/* $data=$this->mensajes_model->get_mensajes_mixed();
			 if(count($data)>0){
			 $m=$data[0];
			 $mensaje=$m['mensaje'];
			 }else{
					 $mensaje="Bienvenidos a mi pagina !!!";
			 }*/
      $mensaje="Bienvenidos a mi pagina !!!";
		 return $mensaje;
	 }
	 public function mostrarVista($data=null,$vista=null){
			 //---parametros a enviar configurables
			 $data['mensaje'] = $this->obtenerMensajeBienvenida();
			 $data['empresa'] = EMPRESA;
			 $data['titulo']  = TITLE;
			 $data['categorias'] = $this->categorias_model->get_categorias_visibles();
			 $data['sucursales'] = $this->sucursales_model->get_sucursales();
			 $data['banners']    = $this->banners_model->get_banners();
			 $destacados_aux  = $this->productos_model->get_productos_destacados();
			 $destacados = null; $cont = 0;
       $data['carrito'] = $this->cart->total_items();
			 foreach ($destacados_aux as $producto) {
					 $imagen = $this->imagenes_model->get_imagen_producto($producto['id_producto']);
					 if($imagen==null){
							 $producto['imagen']='no_image.png';
					 }else{
							 $producto['imagen']= $imagen['imagen'];
					 }
					 $destacados[$cont]=$producto;
					 $cont++;
			 }
			 $data['productos_destacados']= $destacados ;
			 
   
			 $data['inicio']=false;
			 if($vista=='principal_view')
			 $data['inicio']=true; 
			 $this->load->view('web/template/tp_header_view',$data);
			 $this->load->view($vista,$data);
			 $this->load->view('web/template/tp_footer_view');
	 }

	 public function empresa()
	 {
			 $this->mostrarVista(array(),'web/empresa_view');
	 }
	 public function productos(){
	 	     $this->mostrarVista(array(),'web/categorias_view');
	 }
	 public function novedades()
	 {
			 $this->mostrarVista(array(),'web/novedades_view');
	 }
	 public function iniciarCaptcha(){

			 $this->load->model('captcha_model');
			 $this->load->helper('captcha');
			 $vals = array(
					 'img_path' => './assets/img/captcha/',
					 'img_url' => base_url().'assets/img/captcha/',
					 'font_path' => './assets/fonts/Roboto-Black.ttf',
					 'img_width' => '250',
					 'img_height' => 45,
					 'word_length'   => 5,
					 'expiration' => 1200,
					 'font_size'     => 25,        
        // White background and border, black text and red grid
       	 'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
        )
			 );

			 $cap = create_captcha($vals);
     
			 $data = array(
					 'captcha_time' => $cap['time'],
					 'ip_address' => $this->input->ip_address(),
					 'word' => $cap['word']
					 );
				 //pasamos la info del captcha al modelo para
			 //insertarlo en la base de datos
			 $this->captcha_model->insertar_captcha($data);
			 //creamos una sesión con el string del captcha que hemos creado
			 //para utilizarlo en la función callback
			 $this->session->set_userdata('captcha', $cap['word']);
			 
			 return $cap;


	 }
	 public function validate_captcha()
	 {

			 if($this->input->post('captcha') != $this->session->userdata('captcha'))
			 {
					 //echo "<p>se envio eso = ".$this->input->post('captcha')."</p>";
					 $this->form_validation->set_message('validate_captcha', 'Error en el codigo de verificacion');
					 return false;
			 }else{
					 return true;
			 }

	 }
	 public function contacto()
	 {
				 $data['resultado'] = '';

			 if ($this->input->server('REQUEST_METHOD') === 'POST'){
					 //----------datos enviados por el Formulario------
						$data['fecha'] = ' 10/10/2015';
						$this->form_validation->set_rules('nombre', 'Nombre y Apellido', 'required');
						$this->form_validation->set_rules('telefono', 'Telefono', 'required');
						$this->form_validation->set_rules('motivo', 'Motivo', 'required');
						$this->form_validation->set_rules('mensaje', 'Mensaje', 'required');
						$this->form_validation->set_rules('email', 'Email', 'required|valid_email');
						$this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');


						if ($this->form_validation->run() == true)
						{
						$this->load->model('captcha_model');
						$expiration = time()-600; // Límite de 10 minutos
						$ip = $this->input->ip_address();//ip del usuario
						$captcha = $this->input->post('captcha');//captcha introducido por el usuario
					 //eliminamos los captcha con más de 2 minutos de vida
						$this->captcha_model->remover_old_captcha($expiration);
					 //comprobamos si es correcta la imagen introducida
						$check = $this->captcha_model->check($ip,$expiration,$captcha);

					 /*
					 |si el número de filas devuelto por la consulta es igual a 1
					 |es decir, si el captcha ingresado en el campo de texto es igual
					 |al que hay en la base de datos, junto con la ip del usuario
					 |entonces dejamos continuar porque todo es correcto
					 */
									if($check == 1)
									{
									 //---si los datos fueron correctos---
									 $email_to = EMAIL_CONTACTO;
									 $nombre  = $this->input->post('nombre');
									 $empresa = $this->input->post('empresa');
									 $telefono= $this->input->post('telefono');
									 $motivo  = $this->input->post('motivo');
									 $mensaje  = $this->input->post('mensaje');
									 $email   = $this->input->post('email');

									 $email_message = "Detalles del formulario de contacto:\n\n";
									 $email_message .= "Nombre: " .$nombre.  "\n";
									 $email_message .= "Empresa: " .$empresa."\n";
									 $email_message .= "E-mail: " . $email . "\n";
									 $email_message .= "Teléfono: " . $telefono. "\n";
									 $email_message .= "Motivo: " . $motivo . "\n";
									 $email_message .= "Mensaje: " . $mensaje . "\n\n";
									 $email_from = $email;

									 $this->load->library('email');

									 $this->email->from($email, $nombre);
									 $this->email->to($email_to);
									 //$this->email->cc('');
									 //$this->email->bcc('ellos@su-ejemplo.com');

									 $this->email->subject($motivo);
									 $this->email->message($email_message);

									 //descomenar eso para enviar
									 $this->email->send();
									 $data['resultado'] = '<p>Se ha enviado su consulta!!!</p>';

									 }else{ //---error en algunos datos recibidos

									 $data['resultado'] = '<p>Error en el captcha!!!</p>';
									 }
						}else{ //---error en algunos datos recibidos

									 $data['resultado'] = '<p>Ingrese los datos!!!</p>';
						}
			 //----fin de  revision datos recibidos
			 }

			 //---creando un captcha----
			 $data['captcha'] = $this->iniciarCaptcha();
			 $this->mostrarVista($data,'web/contacto_view');
	 }
   public function default_override(){
 		$data=array();
    if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
      redirect('seguridad/default_override');
    }else{
      $this->mostrarVista($data,'web/template/override_view');

    }


 	}
public function listarProductos(){
	    $this->load->library('pagination');
        $this->load->library('cart');
		//---parametros a enviar configurables
        $data['empresa'] = "Artesanias Mariscal";
        $data['titulo']  = "PRODUCTOS POLARIS Promocion  Difusion de Productos en la WEB";
        $data['categorias'] = $this->categorias_model->get_categorias_visibles();
        $data['sucursales'] = $this->sucursales_model->get_sucursales();

     //pagination settings
        $config['per_page'] = 5;
        $config['base_url'] = base_url().'productos/listar';
        $config['use_page_numbers'] = TRUE;
        $config['num_links'] = 4;
        $config['full_tag_open'] = '<ul class="pagination">';
        $config['full_tag_close'] = '</ul>';
        $config['num_tag_open'] = '<li>';
        $config['num_tag_close'] = '</li>';
        $config['cur_tag_open'] = '<li class="active"><a>';
        $config['cur_tag_close'] = '</a></li>';
        $config['next_link'] = 'Siguiente → ';
        $config['next_tag_open'] = '<li class="next">';
        $config['next_tag_close'] = '</li>';
        $config['first_link'] = 'Primero';
        $config['first_tag_open'] = '<li class="first">';
        $config['first_tag_close'] = '</li>';
        $config['last_link'] = 'Último';
        $config['last_tag_open'] = '<li class="last">';
        $config['last_tag_close'] = '</li>';
        $config['prev_link'] = '← Anterior';
        $config['prev_tag_open'] = '<li class="pev">';
        $config['prev_tag_close'] = '</li>';
        //---capturando y limpiando campos enviados----
        $search_string ='';

        if($this->input->post('butt_buscar_inicio')=='ok'){
            $this->limpiarConfigListaProductos();
            $search_string = $this->input->post('search_string_inicio');
        }
        if($this->input->post('mysubmit')=='Buscar'){
            $this->limpiarConfigListaProductos();
            $search_string = $this->input->post('search_string');
        }
        $order = $this->input->post('order');
        $order_type = $this->input->post('order_type');
        $id_categoria = $this->input->post('categoria_id');


        if($this->session->userdata('categoria_selected')){
        	$id_categoria = $this->session->userdata('categoria_selected');
        	$this->session->unset_userdata('categoria_selected');

        }


        //limit end
        $page = 1;
        if($this->uri->segment(3)){
        	$page = $this->uri->segment(3);
        }

        //math to get the initial record to be select in the database
        $limit_end = ($page * $config['per_page']) - $config['per_page'];

        if ($limit_end < 0){
            $limit_end = 0;
        }


        //if order type was changed
        if($order_type){
            $filter_session_data['order_type'] = $order_type;
        }
        else{
            //we have something stored in the session?
            if($this->session->userdata('order_type')){
                $order_type = $this->session->userdata('order_type');
            }else{
                //if we have nothing inside session, so it's the default "Asc"
                $order_type = 'Asc';
            }
        }
        //make the data type var avaible to our view
        $data['order_type_selected'] = $order_type;


        //we must avoid a page reload with the previous session data
        //if any filter post was sent, then it's the first time we load the content
        //in this case we clean the session filter data
        //if any filter post was sent but we are in some page, we must load the session data

        //filtered && || paginated

        if($id_categoria !== false && $search_string !== false && $order !== false || $this->uri->segment(3) == true){


            if($id_categoria !== 0){
                $filter_session_data['categoria_selected'] = $id_categoria;

            }else{
                $id_categoria = $this->session->userdata('categoria_selected');
            }
            $data['categoria_selected'] = $id_categoria;



            if($search_string){
                $filter_session_data['search_string_selected'] = $search_string;


            }else{
                $search_string = $this->session->userdata('search_string_selected');

            }
            $search_string = trim($search_string);

            $data['search_string_selected'] = $search_string;

            if($order){
                $filter_session_data['order'] = $order;
            }
            else{
                $order = $this->session->userdata('order');
            }
            $data['order'] = $order;

            //save session data into the session
            $this->session->set_userdata($filter_session_data);


            //fetch manufacturers data into arrays
            //$data['manufactures'] = $this->manufacturers_model->get_manufacturers();

            $data['count_products']= $this->productos_model->count_productos($id_categoria, $search_string, $order);
            $config['total_rows'] = $data['count_products'];

            //fetch sql data into arrays
            if($search_string){
                if($order){
                    $data['productos'] = $this->productos_model->get_productos($id_categoria, $search_string, $order, $order_type, $config['per_page'],$limit_end);
                }else{
                    $data['productos'] = $this->productos_model->get_productos($id_categoria, $search_string, '', $order_type, $config['per_page'],$limit_end);
                }
            }else{
                if($order){
                    $data['productos'] = $this->productos_model->get_productos($id_categoria, '', $order, $order_type, $config['per_page'],$limit_end);
                }else{
                    $data['productos'] = $this->productos_model->get_productos($id_categoria, '', '', $order_type, $config['per_page'],$limit_end);
                }
            }

        }else{
        	//echo "<p>supongo que lo contrario</p>";


            //clean filter data inside section
            $filter_session_data['categoria_selected'] = null;
            $filter_session_data['search_string_selected'] = null;
            $filter_session_data['order'] = null;
            $filter_session_data['order_type'] = null;
            $this->session->set_userdata($filter_session_data);

            //pre selected options
            $data['search_string_selected'] = '';
            $data['manufacture_selected'] = 0;
            $data['order'] = 'id';

            //fetch sql data into arrays
            $data['count_products']= $this->productos_model->count_products();
            $data['productos'] = $this->productos_model->get_productos('', '', '', $order_type, $config['per_page'],$limit_end);
            $config['total_rows'] = $data['count_products'];


        }//!isset($id_categoria) && !isset($search_string) && !isset($order)

        //---enviando las imagenes del producto
        $imagen_productos = null;
        $img_cont=0;
        foreach ($data['productos'] as $row) {
           $imagen=$this->imagenes_model->get_imagen_producto($row['id']);
           $imagen_productos[$img_cont] = $imagen;
           $img_cont++;

        }
        $data['imagen_productos']= $imagen_productos;
        //initializate the panination helper
        $this->pagination->initialize($config);
        $data['carrito'] = $this->cart->total_items();
        $this->load->view('web/template/tp_header_view',$data);
        $this->load->view('web/catalogo/productos_view', $data);
        $this->load->view('web/template/tp_footer_view');

	}
	public function listarDetalleProducto(){


        //---parametros a enviar configurables
        $data['empresa'] = "Artesanias Mariscal";
        $data['titulo']  = "PRODUCTOS POLARIS Promocion  Difusion de Productos en la WEB";
        $data['categorias'] = $this->categorias_model->get_categorias_visibles();
        $data['sucursales'] = $this->sucursales_model->get_sucursales();
        $cantidad_similares = 4;
        $producto = array();
        $similares = array();
        $imagenes = array();

		if ($this->uri->segment(3))
		{
			$id_producto = $this->uri->segment(3);
			$res = $this->productos_model->get_detalle_producto_by_id($id_producto);

		    if(count($res)>0){
		    	$producto = $res[0];
                //-----obteniendo los productos similares
		    	$aux = $this->productos_model->get_producto_similares($id_producto,$cantidad_similares);
                 if(count($aux)>0){
                    foreach ($aux as $value) {
                        $id_producto_similar = $value['id'];
                        $aux2 = $this->imagenes_model->get_imagen_producto($id_producto_similar);
                        $datasimilar['id']=$id_producto_similar;
                        $datasimilar['nombre']=$value['nombre'];
                        $datasimilar['codigo']=$value['codigo'];
                        $datasimilar['imagen']=$aux2['imagen'];
                        $similares[]=$datasimilar;
                    }
                 } //--End productos similares

                $aux2 = $this->imagenes_model->get_imagenes_productos($id_producto);
                $imagenes = $aux2;


            $data['producto'] = $producto;
            $data['imagenes'] = $imagenes;
            $data['similares'] = $similares;
            $data['carrito'] = $this->cart->total_items();
            $this->load->view('web/template/tp_header_view',$data);
            $this->load->view('web/catalogo/detalle_producto_view',$data);
            $this->load->view('web/template/tp_footer_view');

		    } else{
            $data['producto'] = $producto;
            $data['imagenes'] = $imagenes;
            $data['similares'] = $similares;
            $data['carrito'] = $this->cart->total_items();
            $this->load->view('web/template/tp_header_view',$data);
            $this->load->view('web/catalogo/detalle_producto_not_found_view',$data);
            $this->load->view('web/template/tp_footer_view');

            }


		}

	}
}
