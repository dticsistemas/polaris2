<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productos extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        $this->load->model('productos_model');
        $this->load->model('imagenes_model');
        $this->load->model('categorias_model');
        $this->load->model('sucursales_model');
        $this->load->library('pagination');
        $this->load->library('cart');
    }

	public function index()
	{
		$this->mostrarVista(array(),'web/categorias_view');

	}
     public function mostrarVista($data=null,$vista=null){
        //---parametros a enviar configurables
        $data['empresa'] = "Artesanias Mariscal";
        $data['titulo']  = "POLARIS Promocion  Difusion de Productos en la WEB";
        $data['categorias'] = $this->categorias_model->obtenerCategoriasTotal();
        $data['sucursales'] = $this->sucursales_model->get_sucursales();
        $data['carrito'] = $this->cart->total_items();
        /*$this->load->view('template/tp_header_view',$data);
        $this->load->view($vista,$data);
        $this->load->view('template/tp_footer_view');*/
        $this->load->view('web/template/tp_header_views',$data);
   		 $this->load->view($vista,$data);
   		 $this->load->view('web/template/tp_footer_views');
    }
	public function listarProductosCategoria(){

		$id_categoria = $this->uri->segment(3);
        $this->limpiarConfigListaProductos();
		$this->session->set_userdata('categoria_selected', $id_categoria);
        redirect('productos/listar');

	}
    public function limpiarConfigListaProductos(){
        $this->session->unset_userdata('categoria_selected');
        $this->session->unset_userdata('search_string_selected');
        $this->session->unset_userdata('order');
        $this->session->unset_userdata('order_type');
    }
    /*
	public function listarProductos(){
		//---parametros a enviar configurables
        $data['empresa'] = "Artesanias Mariscal";
        $data['titulo']  = "PRODUCTOS POLARIS Promocion  Difusion de Productos en la WEB";
        $data['categorias'] = $this->categorias_model->obtenerCategoriasTotal();
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

	}*/
	
    function llenar_productos_by_categorias(){
        //-------


        if(($this->input->post('id_categoria'))||($this->input->post('id_categoria')==0))
        {
            $id_categoria=$this->input->post('id_categoria');
            if($id_categoria==0)
                $productos = $this->productos_model->get_productos_total();
            else
                $productos = $this->productos_model->get_productos_by_categoria($id_categoria);
            foreach($productos as $fila)
            {
            ?>
                <option value="<?=$fila['id']?>"><?=$fila['nombre']?></option>
            <?php
            }
        }

    }
    function llenar_productos_by_categorias_sucursal(){
        //-------


        if(($this->input->get('id_sucursal'))||($this->input->get('id_sucursal')==0))
        {
            $id_categoria=$this->input->get('id_categoria');
            $id_sucursal=$this->input->get('id_sucursal');
            if($id_categoria==0)
                $productos = $this->productos_model->get_productos_total_sucursal($id_sucursal);
            else
                $productos = $this->productos_model->get_productos_by_categoria_sucursal($id_categoria,$id_sucursal);
            foreach($productos as $fila)
            {
            ?>
                <option value="<?=$fila['id']?>"><?=$fila['nombre']?></option>
            <?php
            }
        }

        // $productos = $this->productos_model->get_productos_by_categoria_sucursal(31,6);

        // print_r($productos);

    }
    function obtener_info_producto(){
        //-------
        if($this->input->get('id_producto')){
            $id_producto=$this->input->get('id_producto');
            $arr_producto = $this->productos_model->get_detalle_producto_by_id($id_producto);
             if(count($arr_producto)>0){
                $producto=$arr_producto[0];
              //  $response=array_merge($aux[0],$precios);
                $this->load->model('inventarios_model');
                $id_sucursal=$this->input->get('id_sucursal');
                $response['descripcion']='';
                $response['medida']=$producto['medida'];
                $response['especificaciones']='';
                $response['titulo']='';
                $response['codigo']=$producto['codigo'];
                $response['precio']=$producto['precio_base'];
								$response['unidad_mayor']=$producto['unidad_mayor'];
                $response['precio_mayor']=$producto['precio_mayor'];
                $response['stock']=$this->inventarios_model->get_cantidad_productos($id_sucursal,$id_producto);
                $res = $this->imagenes_model->get_imagen_producto($id_producto);
                $cant=1;
                switch ($producto['unidad_mayor']) {
                  case 'Unidad':
                    $cant=1;
                    break;
                  case 'Docena':
                    $cant=12;
                    break;
                  case 'Cuarta':
                    $cant=3;
                    break;

                  default:
                    $cant=1;
                    break;
                }
                $response['precio_unitario']=$producto['precio_mayor']/$cant;
                $response['imagen']=$res['imagen'];
                echo json_encode($response);
               // echo json_encode($precios);
            }
        }else
          echo 'no_image.png';

    }

}
