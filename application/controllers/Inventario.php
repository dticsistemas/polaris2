<?php
  defined('BASEPATH') OR exit('No direct script access allowed');

  /**
   * Inventario class.
   *
   * @extends CI_Controller
   */
  class Inventario extends CI_Controller {

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
    public function productos(){
      $data=array();

      $this->load->library('grocery_CRUD');
      try {

        $crud = new grocery_CRUD();
        $crud->set_table('productos');
        $crud->unset_bootstrap();
        $crud->unset_jquery();
        $crud->unset_clone();
        //$crud->unset_delete();
        $crud->set_relation_n_n('categorias', 'categoria_productos', 'categorias', 'id_producto', 'id_categoria', 'nombre');
        $crud->add_action('Imagenes','../assets/img/upload_image.png', 'inventario/editar_imagenes_producto');
        $crud->columns(array('id','codigo','nombre','titulo','imagen','precio_base','precio_mayor','categorias','activo'));
        //$crud->add_fields(array('codigo','nombre','titulo','descripcion','especificaciones','categorias','precio_base','unidad_mayor','precio_mayor'));
        //if($crud->getState()!="add" && $crud->getState()!="edit" && $crud->getState()!="insert_validation" && $crud->getState()!="update_validation")
        $crud->display_as('precio_base','Precio');
        $crud->where('tipo !=','Insumo');
        //------Mostrando imagenes del producto
        $crud->unique_fields(array('nombre'));
        $crud->unique_fields(array('codigo'));
        $crud->required_fields('codigo','nombre','titulo','precio_base','activo','unidad_mayor','precio_mayor');
        $crud->callback_column('imagen',array($this,'product_imagen_scale_callback'));
        $crud->callback_column('precio_mayor',array($this,'product_precio_mayor_callback'));
        $crud->callback_after_insert(array($this, 'log_producto_after_insert'));
        $this->session->set_flashdata('inventario','productos');
        $output = $crud->render();
        $data = json_decode(json_encode($output), True);

  			$data['link_active']='inventario/productos';
        $this->vista_output('crud/plantilla_crud',$data);
      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }
    }
    function log_producto_after_insert($post_array,$primary_key)
    {
    $this->load->model('inventarios_model');
    $this->inventarios_model->habilitarProductosInventarioAllSucursales();
    return true;
    }
    public function insumos(){
      $data=array();

      $this->load->library('grocery_CRUD');
      try {

        $crud = new grocery_CRUD();
        $crud->set_table('productos');
        $crud->unset_bootstrap();
  			$crud->unset_jquery();
  			$crud->unset_clone();
        //$crud->unset_delete();
        $crud->set_relation_n_n('categorias', 'categoria_productos', 'categorias', 'id_producto', 'id_categoria', 'nombre');
        $crud->add_action('Imagenes','../assets/img/upload_image.png', 'inventario/editar_imagenes_producto');
        $crud->columns(array('id','codigo','nombre','titulo','imagen','precio_base','medida','tipo'));
        //$crud->add_fields(array('codigo','nombre','titulo','descripcion','especificaciones','categorias','precio_base','unidad_mayor','precio_mayor'));
        //if($crud->getState()!="add" && $crud->getState()!="edit" && $crud->getState()!="insert_validation" && $crud->getState()!="update_validation")
        $crud->display_as('precio_base','Precio');
        $crud->where('tipo !=','Producto');
        //------Mostrando imagenes del producto
        $crud->unique_fields(array('nombre'));
        $crud->unique_fields(array('codigo'));
        $crud->required_fields('codigo','nombre','titulo','precio_base','activo','unidad_mayor','precio_mayor');
        $crud->callback_column('imagen',array($this,'product_imagen_scale_callback'));
        $crud->callback_after_insert(array($this, 'log_producto_after_insert'));

      //  $crud->callback_column('precio_mayor',array($this,'product_precio_mayor_callback'));

        $this->session->set_flashdata('inventario','insumos');
        $output = $crud->render();
        $data = json_decode(json_encode($output), True);

  			$data['link_active']='inventario/insumos';
        $this->vista_output('crud/plantilla_crud',$data);
      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }
    }
    function product_precio_mayor_callback($value, $row){
        return '<div class="text-left "><b>'.$row->unidad_mayor.':</b>'.$value.'</div>';
    }

    function product_imagen_scale_callback($value, $row)
    {
        $this->load->model('imagenes_model');
        $d=$this->imagenes_model->get_imagen_producto($row->id);
        $imagen = base_url()."/assets/img/catalogo/small/".$d['imagen'];
        return '<div class="text-center "><img src="'.$imagen.'" height="50px"></div>';

    }
    public function editar_imagenes_producto()
    {
         $id_producto = $this->uri->segment(3);
        //--preparando la ediciones para administrar las imagende diapositivas
        $this->load->library('image_CRUD');
        $this->load->model('productos_model');
        $image_crud = new image_CRUD();

        $image_crud->set_primary_key_field('id');
        $image_crud->set_url_field('imagen');
        $image_crud->set_title_field('descripcion');
        $image_crud->set_table('imagenes')
        ->set_relation_field('id_producto')
        ->set_ordering_field('orden')
        ->set_image_path('assets/img/catalogo');

        $output = $image_crud->render();
        $data=json_decode(json_encode($output), True);
        $data['nav']='admin_web';
        $productos = $this->productos_model->get_detalle_producto_by_id($id_producto);
        $producto=$productos[0];
        $volver='inventario/productos';
        if($this->session->flashdata('inventario')=='insumos')
        $volver='inventario/insumos';

        $data['extra_html']='<div class="callout callout-info" style="margin-bottom: 0!important;">
        <h4><i class="fa fa-info"></i> IMAGENES: ['.$producto['codigo'].'] "'.$producto['nombre'].'"</h4>'.
        '<div class="row"><div class="col-sm-3"><a href="'.site_url($volver).'" class="btn btn-primary"> Volver a Productos</a></div>'.
        '<div class="col-sm-8"><p class="text-center">para su mejor visualizacion asegurese subir imagenes de una resolucion alta mayor a 600x400 pixeles y en una relacion de aspecto de 4:3</p></div>'.
        '</div></div>';
        $this->vista_output('crud/plantilla_imgcrud',$data);
    }

    public function categorias(){
        $data=array();
        try{
        $this->load->library('grocery_CRUD');
        $crud = new grocery_CRUD();
        $crud->unset_bootstrap();
        $crud->unset_jquery();
        $crud->unset_clone();
        $crud->set_table('categorias');
        $crud->display_as('id_parent','Nombre Categoria');
        $crud->set_relation('id_parent','categorias','nombre');
        $output = $crud->render();
        $data = json_decode(json_encode($output), True);
  			$data['link_active']='inventario/categorias';
        $this->vista_output('crud/plantilla_crud',$data);

      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }

    }
    ////////////////////////////////////////////////////////////////////////////
    //                  INVENTARIOS
    ////////////////////////////////////////////////////////////////////////////
    public function reposicion_inventario(){

      $data=$_POST;
      $this->load->model('inventarios_model');
      $data['id_usuario']=$this->session->userdata('user_id');
      $id=$this->inventarios_model->insertar_reposicion($data);
      if($data['tipo']==ADICIONAR)//adicionar
      $this->inventarios_model->actualizar_cantidad_productos($data['id_sucursal_destino'],$data['id_producto'],$data['cantidad']);
      if($data['tipo']==REMOVER)//quitar
      $this->inventarios_model->actualizar_cantidad_productos($data['id_sucursal_destino'],$data['id_producto'],-1*$data['cantidad']);
      if($data['tipo']==TRASLADAR){//trasladar
        $this->inventarios_model->actualizar_cantidad_productos($data['id_sucursal_destino'],$data['id_producto'],$data['cantidad']);
        $this->inventarios_model->actualizar_cantidad_productos($data['id_sucursal_origen'],$data['id_producto'],-1*$data['cantidad']);
      }
      $resp=array('result'=>true);
      echo json_encode($resp);

    }
    public function inventario_productos_global(){

      $this->load->model('inventarios_model');
      $this->load->model('imagenes_model');
      $this->load->model('sucursales_model');
      $sucursales=$this->sucursales_model->listSucursales();
      $arr_productos=$this->inventarios_model-> get_productos_inventarios();
      $data=array();
      foreach ($arr_productos as $p) {
        $img_src=$this->imagenes_model->get_imagen_producto($p['id']);
        $aux=array(
          '0'=>$p['codigo'],
          '1'=>'<img  align="left" class="img-responsive" width="70px" src="'.base_url().'assets/img/catalogo/thumbs/'.$img_src['imagen'].'">',

          '2'=>$p['nombre']
        );
        $total=0;
        foreach ($sucursales as $key => $value) {
          $cant=$this->inventarios_model->get_cantidad_productos($key,$p['id']);
          $total+=$cant;
          $aux[]='<div class="row"><div class="col-sm-7 text-right">'.$cant.
          '</div><div class="col-sm-5"><button type="button" data-target="#myModalEdit" data-toggle="modal"  class="btn btn-default pull-right"'.
          ' onclick="edit_inventario('."'".$p['nombre']."','".$value."'".','.$p['id'].','.$key.','.$cant.')"><i class="fa fa-edit"></i></button></div></div>';
          //'<span class="text-center">'.$cant.'</span><';
        }
        $aux[]=$total;
        $data[]=$aux;
      }
      $result=array("data"=>$data);
      echo json_encode($result);

    }
    public function inventario_insumos_global(){

      $this->load->model('inventarios_model');
      $this->load->model('imagenes_model');
      $this->load->model('sucursales_model');
      $sucursales=$this->sucursales_model->listSucursales();
      $arr_productos=$this->inventarios_model-> get_insumos_inventarios();
      $data=array();
      foreach ($arr_productos as $p) {
        $img_src=$this->imagenes_model->get_imagen_producto($p['id']);
        $aux=array(
          '0'=>$p['codigo'],
          '1'=>'<img  align="left" class="img-responsive" width="70px" src="'.base_url().'assets/img/catalogo/thumbs/'.$img_src['imagen'].'">',

          '2'=>$p['nombre']
        );
        $total=0;
        foreach ($sucursales as $key => $value) {
          $cant=$this->inventarios_model->get_cantidad_insumos($key,$p['id']);
          $total+=$cant;
          $aux[]='<div class="row"><div class="col-sm-7 text-right">'.$cant.
          '</div><div class="col-sm-5"><button type="button" data-target="#myModalEdit" data-toggle="modal"  class="btn btn-default pull-right"'.
          ' onclick="edit_inventario('."'".$p['nombre']."','".$value."'".','.$p['id'].','.$key.','.$cant.')"><i class="fa fa-edit"></i></button></div></div>';
          //'<span class="text-center">'.$cant.'</span><';
        }
        $aux[]=$total;
        $data[]=$aux;
      }
      $result=array("data"=>$data);
      echo json_encode($result);

    }
    public function inventario_productos(){
      $data=array();
      $this->load->model('sucursales_model');
      $this->load->model('inventarios_model');
      $data['datatable']=true;
      $data['data_table_source']="inventario/inventario_productos_global";
      $data['title']="- Administrar inventarios";
      //---automatizando revision de inventarios
      $this->inventarios_model->habilitarProductosInventarioAllSucursales();
      $arr_sucursales=$this->sucursales_model->listSucursales();
      $cant_total=$this->inventarios_model->get_cantidad_productos_total();
      $sucursales=array();
      foreach ($arr_sucursales as $key => $value) {
        $cant=$this->inventarios_model->get_cantidad_productos_sucursal($key);
        $aux=array();
        $aux['id']=$key;
        $aux['nombre']=$value;
        $aux['cantidad']=$cant;
        $aux['total']=$cant_total;
        if($cant_total==0){
          $cant_total=0;
          $aux['porcentaje']=0;
        }else
        $aux['porcentaje']=round($cant / $cant_total* 100, 0);
        $sucursales[]=$aux;
      }
      $data['sucursales']=$sucursales;
      $this->vista_output('inventarios/inventarios_view',$data);
    }
    public function inventario_insumos(){
      $data=array();
      $this->load->model('sucursales_model');
      $this->load->model('inventarios_model');
      $data['datatable']=true;
      $data['data_table_source']="inventario/inventario_insumos_global";
      $data['title']="- Administrar inventarios insumos";
      //---automatizando revision de inventarios
      $this->inventarios_model->habilitarProductosInventarioAllSucursales();
      $arr_sucursales=$this->sucursales_model->listSucursales();
      $cant_total=$this->inventarios_model->get_cantidad_insumos_total();
      $sucursales=array();
      foreach ($arr_sucursales as $key => $value) {
        $cant=$this->inventarios_model->get_cantidad_insumos_sucursal($key);
        $aux=array();
        $aux['id']=$key;
        $aux['nombre']=$value;
        $aux['cantidad']=$cant;
        $aux['total']=$cant_total;
        if($cant_total==0){
          $cant_total=0;
          $aux['porcentaje']=0;
        }else
        $aux['porcentaje']=round($cant / $cant_total* 100, 0);
        $sucursales[]=$aux;
      }
      $data['sucursales']=$sucursales;
      $this->vista_output('inventarios/inventarios_view',$data);

    }
    public function trasladar_producto_inventario(){
      $data=array();

      $this->load->library('grocery_CRUD');
      $this->load->model('inventarios_model');
      $this->load->model('sucursales_model');
      try{
        $crud = new grocery_CRUD();
        $crud->set_table('reposiciones');
        $id_sucursal_temp=$this->session->userdata('id_sucursal_temp');
        if($crud)
        if(($crud->getState()=='list') || ($crud->getState()=='success')){
            $id_sucursal_temp=$this->session->userdata('id_sucursal_temp');
            redirect('inventario/inventario_productos?sucursal_id='.$id_sucursal_temp);
        }
        $id_producto=$this->uri->segment(4);
        $cantidad_max=$this->inventarios_model->get_cantidad_productos($id_sucursal_temp,$id_producto);
        $this->session->set_userdata('cant_max_mover_producto',$cantidad_max);

        $crud->callback_add_field('id_sucursal_destino',array($this,'add_field_sucursal_diferente'));

        $crud->field_type('id_sucursal_origen','hidden',$id_sucursal_temp);
        //---el destino no existe debe ser el taller si no seria repóner
        $crud->field_type('id_producto','hidden',$id_producto);
        $crud->field_type('tipo','hidden',3);
        $crud->field_type('id_usuario','hidden',$this->session->userdata('id_usuario'));
        $crud->field_type('cantidad', 'integer', 1);
        $crud->callback_after_insert(array($this, 'log_inventario_insert'));
        $output = $crud->render();
        $data = json_decode(json_encode($output), True);
        //$data['html_extra']='("#datepicker")'."'.datepicker('setDate', now.format('DD/MM/YYYY'));";
      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }
        $this->vista_output('crud/plantilla_crud',$data);
    }
    public function reposicion(){
      $data=array();

  		$this->load->library('grocery_CRUD');
  		try{
  			$crud = new grocery_CRUD();
        $crud = new grocery_CRUD();
        $crud->set_table('reposiciones');
        $id_sucursal_temp=$this->session->userdata('id_sucursal_temp');
        if($crud)
        if(($crud->getState()=='list') || ($crud->getState()=='success')){
            $id_sucursal_temp=$this->session->userdata('id_sucursal_temp');
            redirect('inventario/inventario_productos?sucursal_id='.$id_sucursal_temp);
        }
        $id_producto=$this->uri->segment(4);

        //$crud->field_type('tipo','hidden','1');
        $crud->callback_add_field('tipo',array($this,'add_field_tipo_reponer'));

        $crud->field_type('id_sucursal_origen','hidden','0');
        //---el origen no existe debe ser el taller si no seria mover
        $crud->field_type('id_sucursal_destino','hidden',$id_sucursal_temp);
        $crud->field_type('id_producto','hidden',$id_producto);
        $crud->field_type('fecha','hidden',date('Y-m-d H:i:s'));
        $crud->field_type('id_usuario','hidden',$this->session->userdata('id_usuario'));
        $crud->callback_after_insert(array($this, 'log_inventario_insert'));
        $output = $crud->render();
        $data = json_decode(json_encode($output), True);

        $state = $crud->getState();
        $state_info = $crud->getStateInfo();
        if($state == 'add'){
          $id_producto = $state_info->primary_key;
          $this->load->model('productos_model');
          $productos = $this->productos_model->get_detalle_producto_by_id($id_producto);
          $producto=$productos[0];
          $data['extra_html']='<div class="callout callout-info" style="margin-bottom: 0!important;">
          <h4><i class="fa fa-info"></i> INVENTARIO: ['.$producto['codigo'].'] "'.$producto['nombre'].'"</h4>'.
          '</div>';
        }
        $data['nav']='inventario';
        $modulo='7';//--modulo de inventario
      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }
        $this->vista_output('crud/plantilla_crud',$data);

    }
    function add_field_tipo_reponer()
    {
    return "<select id='field-tipo' name='tipo' class='form-control'".
    " data-placeholder='Seleccionar Tipo'><option value='1'  >agregar´producto</option><option value='2'".
    " >Quitar o dar de baja</option></select> ";
     }
     function add_field_sucursal_diferente()
    {
        $id_sucursal=$this->session->userdata('id_sucursal_temp');
        $cantidad_max=$this->session->userdata('cant_max_mover_producto');
        $cad="<p><label>Cantidad Maxima de Productos a Trasladar ".$cantidad_max." </label></p><select id='combox_destino' name='id_sucursal_destino' class='form-control'".
        " data-placeholder='Seleccionar Destino'>";
        $arrsucursales = $this->sucursales_model->listSucursalesDiferentes($id_sucursal);
        foreach ($arrsucursales as $sucursal) {
            $cad=$cad.'<option value='.$sucursal['id'].'  >'.$sucursal['nombre'].'</option>';
        }
        $cad=$cad."</select> ";

        return $cad;

     }
    function log_inventario_insert($post_array,$primary_key)
    {
        //Permite actualizar el inventario cuando se
        //---realiza una reposiciom
        $id_sucursal_destino=$post_array['id_sucursal_destino'];
        $id_sucursal_origen=$post_array['id_sucursal_origen'];
        $id_producto=$post_array['id_producto'];
        $cantidad=$post_array['cantidad'];
        $tipo=$post_array['tipo'];


        if($tipo==3){//---si se trata de mover-----

         $cantidad_max=$this->inventarios_model->get_cantidad_productos($id_sucursal_origen,$id_producto);
         if($cantidad >= $cantidad_max){
            $cantidad = $cantidad_max;
          }
           /* script util para comprobar los datos
           $data = array(
            'id'=>'1',
            'nombre'=>$cantidad_max.'===>'.$cantidad_max2.'///'.print_r($post_array,true)
            //'nombre'=>$id_producto
            );
          $this->db->insert('vacios',$data);
          $this->db->flush_cache();*/

         //----quitando productos-----
        $this->db->set('cantidad', 'cantidad-'.$cantidad, FALSE);
        $this->db->where('id_sucursal', $id_sucursal_origen);
        $this->db->where('id_producto', $id_producto);
        $this->db->update('inventarios');
        //---verificar si el producto existe en la nueva sucursal
        $this->inventarios_model->habilitarProductoInventario($id_producto,$id_sucursal_destino);
        //-----adicionando productos
        $this->db->set('cantidad', 'cantidad+'.$cantidad, FALSE);
        $this->db->where('id_sucursal', $id_sucursal_destino);
        $this->db->where('id_producto', $id_producto);
        $this->db->update('inventarios');

        }
        else
        {
        if($tipo==1)//----si es agregar
            $this->db->set('cantidad', 'cantidad+'.$cantidad, FALSE);
        else if($tipo==2)//---si es quitar o dar de baja
            $this->db->set('cantidad', 'cantidad-'.$cantidad, FALSE);
        $this->db->where('id_sucursal', $id_sucursal_destino);
        $this->db->where('id_producto', $id_producto);
        $this->db->update('inventarios');

        }

      /*  $data = array(
            'id'=>'1',
            'nombre'=>print_r($post_array,true)
            //'nombre'=>$id_producto
            );
        $this->db->insert('vacios',$data);
        // gives UPDATE mytable SET field = field+1 WHERE id = 2*/

    return true;
    }
    public function catalogo(){
      $this->load->model('reporte_model');
      $this->load->model('categorias_model');
      $id_producto=false;
      $codigo=false;
      $nombre=false;
      $titulo=false;
      $descripcion=false;
      $tipo=false;
      $imagen=false;
      $precio=false;
      $medida=false;
      $cabecera=false;
      $pie_pagina=false;
      $bordes=0;
      $id_categoria=null;
      if($this->input->post('id_producto')=='ok')
      $id_producto=true;
      if($this->input->post('codigo')=='ok')
      $codigo=true;
      if($this->input->post('nombre')=='ok')
      $nombre=true;
      if($this->input->post('titulo')=='ok')
      $titulo=true;
      if($this->input->post('descripcion')=='ok')
      $descripcion=true;
      if($this->input->post('tipo')=='ok')
      $tipo=true;
      if($this->input->post('imagen')=='ok')
      $imagen=true;
      if($this->input->post('precio')=='ok')
      $precio=true;
      if($this->input->post('medida')=='ok')
      $medida=true;
      if($this->input->post('cabecera')=='ok')
      $cabecera=true;
      if($this->input->post('pie_pagina')=='ok')
      $pie_pagina=true;
      if($this->input->post('categoria'))
      $id_categoria=$this->input->post('categoria');
      if($this->input->post('bordes')=='ok')
      $bordes=1;

      if($this->input->post('butt_catalogo_pdf')=='ok'){
       ///////////////////////////////////////////////////////////////////
        // Se carga el modelo
        $this->load->model('productos_model');
        $this->load->model('imagenes_model');
        // Se carga la libreria fpdf
        $this->load->library('pdf');

        // Se obtienen los productos
        $productos = $this->productos_model->obtener_productos_total($id_categoria);

        // Creacion del PDF

        /*
         * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
         * heredó todos las variables y métodos de fpdf
         */
        $this->pdf = new Pdf();

        // Define el alias para el número de página que se imprimirá en el pie
        if($cabecera==false)
        $this->pdf->quitarHeader();
        if($pie_pagina==false)
        $this->pdf->quitarFooter();
        $this->pdf->AliasNbPages();
        $this->pdf->AddPage();

        $this->pdf->SetTitle(TITLE);
        $this->pdf->SetLeftMargin(12);
        $this->pdf->SetRightMargin(12);
        $this->pdf->SetFillColor(200,200,200);
        // Se define el formato de fuente: Arial, negritas, tamaño 9
        $this->pdf->SetFont('Arial', 'B', 9);
        /*
         * TITULOS DE COLUMNAS
         *
         * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
         */
         // Anchuras de las columnas
         $w = array(40, 35, 45, 40);
         $alto=5;


        if($id_producto)
        $this->pdf->Cell(15,7,'ID'      ,$bordes,0,'C');
        if($codigo)
        $this->pdf->Cell(35,7,'CODIGO'  ,$bordes,0,'C');
        if($nombre)
        $this->pdf->Cell(45,7,'PRODUCTO',$bordes,0,'C');
        if($precio)
        $this->pdf->Cell(30,7,'PRECIO'  ,$bordes,0,'C');
        if($imagen){
          $alto=25;
          $this->pdf->Cell(40,7,'IMAGEN'  ,$bordes,0,'C');
        }
        $this->pdf->Ln();
        // La variable $x se utiliza para mostrar un número consecutivo
        $x = 1;
        foreach ($productos as $producto) {
          // se imprime el numero actual y despues se incrementa el valor de $x en uno
          if($id_producto)
          $this->pdf->Cell(15,$alto,$producto->id,$bordes);
          if($codigo)
          $this->pdf->Cell(35,$alto,$producto->codigo,$bordes);
          if($nombre){
          //$this->pdf->Cell(45,5,utf8_decode($producto->nombre),1,'L',false);
          if($bordes==0)
          $this->pdf->MultiAlignCell(45,5,utf8_decode($producto->nombre),0);
          else
          $this->pdf->MultiAlignCell(45,5,utf8_decode($producto->nombre),'TRL');
          }
          if($precio)
          $this->pdf->Cell(30,$alto,$producto->precio_base,$bordes);
          if($imagen){
          $imagen=$this->imagenes_model->get_imagen_producto($producto->id);
          $this->pdf->Cell(40,$alto,$this->pdf->Image('assets/img/catalogo/small/'.$imagen['imagen'], $this->pdf->GetX(), $this->pdf->GetY(),0,25),$bordes,0,'L',0);
          }
          //Se agrega un salto de linea
          $this->pdf->Ln();

        }
        //$this->Cell(array_sum($w),0,'','T');
        /*
         * Se manda el pdf al navegador
         *
         * $this->pdf->Output(nombredelarchivo, destino);
         *
         * I = Muestra el pdf en el navegador
         * D = Envia el pdf para descarga
         *
         */
        $this->pdf->Output("Catalogo Productos.pdf", 'I');
        ////////////////////////////////////////////////////////////
        //
        //
      }
      if($this->input->post('butt_catalogo_xls')=='ok'){

        redirect('reportes/catalogo_inventario_excel');
      }
      $data=array();
      $data['cant_productos']=$this->reporte_model->get_cantidad_productos_total();
      $data['cant_items']=$this->reporte_model->get_cantidad_stock_productos_total();
      $data['combox_categorias']=$this->categorias_model->get_comboxcategorias();
      $this->vista_output('inventarios/catalogo_view',$data);
    }
    public function cotizaciones(){
      $data=array();

      $this->load->library('grocery_CRUD');
      try {

        $crud = new grocery_CRUD();
        $crud->set_table('cotizaciones');
        $crud->unset_clone();
        $crud->unset_add();
        $crud->unset_read();
        $crud->columns(array('id','nombre','empresa','mensaje','telefono','fecha','estado'));
        $crud->callback_column('telefono',array($this,'_callback_items'));
        $crud->callback_column('estado',array($this,'_callback_estado'));
        $crud->display_as('telefono','Items');
        $output = $crud->render();
        $data = json_decode(json_encode($output), True);
        if(($crud->getState()=='edit')){
             $state_info = $crud->getStateInfo();
             $id_cotizacion= $state_info->primary_key;
             redirect('inventario/gestionarcotizacion/'.$id_cotizacion);
        }

        $data['link_active']='inventario/cotizaciones';
        //$data['nav']='ventas';
        $this->vista_output('crud/plantilla_crud',$data);
      }catch(Exception $e){
        echo $e->getMessage().' --- '.$e->getTraceAsString();
      }
    }
    public function _callback_items($value, $row)
    {

      $this->load->model('pedidos_model');
      $value=$this->pedidos_model->get_cant_productos_by_cotizacion($row->id);

      return "<a>$value</a>";
    }
    public function _callback_estado($value, $row)
    {
      if($value==0)
      return '<a class="text-red">PENDIENTE</a>';
      else
      return '<a class="text-blue">PROCESADO</a>';
    }

    public function gestionarcotizaciones($id_cotizacion=null){

         $this->load->model('pedidos_model');
         $this->load->model('clientes_model');


         if($this->input->post('butt_consignacion_procesar')=='ok'){
           $arr_id           =explode(",",$this->input->post('arr_id'));
           $arr_montos       =explode(",",$this->input->post('arr_montos'));
           $id_cotizacion    =$this->input->post('id_cotizacion');
           $respuesta        =$this->input->post('respuesta');
           $enviar_email     =$this->input->post('enviar_email');
           $email_to     =$this->input->post('email_to');
           $i=0;
           if($enviar_email=='ok'){
             $data['info']='se ha finalizado la cotizacion y enviado un email al solicitante';
             $this->pedidos_model->actualizar_cotizacion($id_cotizacion,$respuesta,2);
             //-------enviando el email de respuesta al cliente-----
 //---si los datos fueron correctos---

              //echo "<p>m<p><p>m<p>";
             // var_dump($this->input->post());
                  
                   $email_message = "Mensaje: " . $respuesta . "\n\n";
                   $email_from = EMAIL_CONTACTO;

                   $this->load->library('email');

                   $this->email->from(EMAIL_CONTACTO, EMPRESA);
                    
                   $this->email->to($email_to);
                   //$this->email->cc('');
                   //$this->email->bcc('ellos@su-ejemplo.com');

                   $this->email->subject(EMPRESA.' Nuestra Respuesta');
                   $this->email->message($email_message);
                    $this->email->send();




                 ///---
           }else{
             $data['success']='se ha finalizado la cotizacion';
             $this->pedidos_model->actualizar_cotizacion($id_cotizacion,$respuesta,1);
           }
           foreach ($arr_id as $id_producto) {
             $monto=$arr_montos[$i];
             $this->pedidos_model->actualizar_producto_cotizacion($id_cotizacion,$id_producto,$monto);
             $i++;
           }

         }
         //if($this->input->post('butt_gestionar')=='ok'){
          if($id_cotizacion!=null){
          // $id_cotizacion=$this->input->post('id_cotizacion');
            //echo "Mostrando la cotizacion del cliente $id_cotizacion";
            $this->load->model('clientes_model');
    				$this->load->model('pedidos_model');
    				$this->load->model('productos_model');
    				$this->load->model('imagenes_model');
    				//--obteniendo o creando cuenta de cliente
    				//$cuenta=$this->clientes_model->get_cuenta_cliente($id_cliente);
    				//print_r($cuenta);
    				//$data['monto_pendiente']=$this->consignacion_model->get_monto_deuda_pendiente($id_cliente);
    			//	if($cuenta!=null){
    					//---verificando cuenta de cliente y pdidos anteriores
    					$cotizacion_solicitada=$this->pedidos_model->get_cotizacion_id($id_cotizacion);

              $old_cotizaciones=$this->pedidos_model->get_productos_cotizacion_id($id_cotizacion);
              $cotizacion_solicitada['items']=count($old_cotizaciones);
              $cotizaciones=array();
    					foreach ($old_cotizaciones as $cotizacion) {
    						$id_producto=$cotizacion['id_producto'];
    						$p=$this->productos_model->get_producto_by_id($id_producto);
    						$cotizacion['nombre_producto']=$p['nombre'];
    						$cotizacion['codigo']=$p['codigo'];
                $cotizacion['precio_base']=$p['precio_base'];
    						$imagen=$this->imagenes_model->get_imagen_producto($id_producto);
    						$cotizacion['img_producto']=$imagen['imagen'];
    						$cotizaciones[]=$cotizacion;
    					}
              $data['cotizacion']=$cotizacion_solicitada;

    					$data['cuenta_cliente']=$data['cotizacion'];
    					$data['arr_pedidos']=$cotizaciones;
    					$this->load->model('categorias_model');
    					$this->load->model('productos_model');
    					$this->load->model('sucursales_model');
    					$this->load->model('personas_model');
              $data['link_active']='inventario/cotizaciones';
    				  $data['title']='- Cotizacion';
    					$data['id_persona']=$_SESSION['id_persona'];

              $this->vista_output('ventas/cotizacion_view',$data);

         }else{
        redirect('inventario/cotizacion');
         }


     }

    }
