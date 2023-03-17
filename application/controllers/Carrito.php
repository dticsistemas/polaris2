<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class Carrito extends CI_Controller
{
    function __construct() {
      parent::__construct();
      $this->load->model('productos_model');
      $this->load->library('cart');
    }

    function index()
    {
      $productos=array();
      $this->load->model('imagenes_model');
      $this->load->model('categorias_model');
      $this->load->model('sucursales_model');
      $carrito = $this->cart->contents();
      foreach ($carrito as $item) {
        $id=$item['id'];
        //--obteniendo info
        $producto = $this->productos_model->get_producto_by_id($id);
        $item['codigo']=$producto['codigo'];
        $item['imagen']=$this->imagenes_model->get_imagen_producto_one($id);
        $productos[]=$item;
      }


        $data['carrito'] = $this->cart->total_items();
        $data['productos'] = $productos;
        //---parametros a enviar configurables
        $data['empresa'] = "Artesanias Mariscal";
        $data['titulo']  = "PRODUCTOS POLARIS Promocion  Difusion de Productos en la WEB";
        $data['categorias'] = $this->categorias_model->obtenerCategoriasTotal();
        $data['sucursales'] = $this->sucursales_model->get_sucursales();

        $producto = array();
        $similares = array();
        $imagenes = array();
      //  print_r($productos);



      $data['resultado'] = '';

    if ($this->input->server('REQUEST_METHOD') === 'POST'){
        //----------datos enviados por el Formulario------
         $data['fecha'] = ' 10/10/2015';
         $this->form_validation->set_rules('nombre', 'Nombre y Apellido', 'required');
         $this->form_validation->set_rules('telefono', 'Telefono', 'required');
         $this->form_validation->set_rules('direccion', 'Direccion', 'required');
         $this->form_validation->set_rules('mensaje', 'Mensaje', 'required');
         $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
      //   $this->form_validation->set_rules('captcha', 'Captcha', 'callback_validate_captcha');


         if ($this->form_validation->run() == true)
         {
         $this->load->model('captcha_model');
         $expiration = time()-600; // Límite de 10 minutos
         $ip = $this->input->ip_address();//ip del usuario
         $captcha = $this->input->post('captcha');//captcha introducido por el usuario
        //eliminamos los captcha con más de 2 minutos de vida
         $this->captcha_model->remover_old_captcha($expiration);
        //comprobamos si es correcta la imagen introducida
         //$check = $this->captcha_model->check($ip,$expiration,$captcha);

        /*
        |si el número de filas devuelto por la consulta es igual a 1
        |es decir, si el captcha ingresado en el campo de texto es igual
        |al que hay en la base de datos, junto con la ip del usuario
        |entonces dejamos continuar porque todo es correcto
        */
               if($this->validate_captcha())
               {
                //---si los datos fueron correctos---
                $nombre  = $this->input->post('nombre');
                $empresa = $this->input->post('empresa');
                $telefono= $this->input->post('telefono');
                $direccion  = $this->input->post('direccion');
                $mensaje  = $this->input->post('mensaje');
                $email   = $this->input->post('email');
                $data_cotizacion=array(
                  'nombre'=> $nombre,
                  'empresa'=> $empresa,
                  'telefono'=>$telefono,
                  'direccion'=> $direccion,
                  'mensaje'=> $mensaje ,
                  'email'=>  $email,
                  'estado'=>0
                );
                $this->load->model('pedidos_model');
                $id_cotizacion=$this->pedidos_model->insertarCotizacion($data_cotizacion);
                //obtenemos el contenido del carrito
                $carrito = $this->cart->contents();

                foreach ($carrito as $item) {
                    $data_pc=array(
                      'id_cotizacion'=>$id_cotizacion,
                      'id_producto'=>$item['id'],
                      'cantidad'=>$item['qty'],
                      'precio'=>0
                    );
                    $this->pedidos_model->insertarProductoCotizacion($data_pc);
                }
                $this->cart->destroy();
                $this->session->set_flashdata('destruido', 'El carrito fue eliminado correctamente');
                

                $data['resultado'] = '<p>Se ha enviado su consulta!!!</p>';

                }else{ //---error en algunos datos recibidos

                $data['resultado'] = '<p>Error en la validacion del  captcha!!!</p>';
                }
         }else{ //---error en algunos datos recibidos

                $data['resultado'] = '<p>Ingrese los datos!!!</p>';
         }
    //----fin de  revision datos recibidos
    }

    //---creando un captcha----
    $data['captcha'] = $this->iniciarCaptcha();

        $this->load->view('web/template/tp_header_view',$data);
        $this->load->view('web/catalogo/carrito_cotizacion_view',$data);
        $this->load->view('web/template/tp_footer_view');
    }

    function agregarProducto()
    {
        $id = $this->input->post('id_producto');
        $producto = $this->productos_model->get_producto_by_id($id);
        $cantidad = 1;
        //obtenemos el contenido del carrito
        $carrito = $this->cart->contents();

        foreach ($carrito as $item) {
            //si el id del producto es igual que uno que ya tengamos
            //en la cesta le sumamos uno a la cantidad
            if ($item['id'] == $id) {
                $cantidad = 1 + $item['qty'];
            }
        }
        //cogemos los productos en un array para insertarlos en el carrito
        $insert = array(
            'id' => $id,
            'qty' => $cantidad,
            'price' => 0,
            'name' => $producto['nombre']
        );

        //si hay opciones creamos un array con las opciones y lo metemos
        //en el carrito
        //if ($producto->opcion) {
          //  $insert['options'] = array(
          //  $producto->opcion => $producto->opciones[$this->input->post($producto->opcion)]
          //  );
        //}
        //insertamos al carrito
        $this->cart->insert($insert);
        //cogemos la url para redirigir a la página en la que estabamos
        //$uri = $this->input->post('uri');
        //redirigimos mostrando un mensaje con las sesiones flashdata
        //de codeigniter confirmando que hemos agregado el producto
        //$this->session->set_flashdata('agregado', 'El producto fue agregado correctamente');
        //redirect('../catalogo/pagina/'.$uri, 'refresh');
        echo " ".$this->cart->total_items()." Cotizar";
    }

    function eliminarProducto($rowid)
    {
        //para eliminar un producto en especifico lo que hacemos es conseguir su id
        //y actualizarlo poniendo qty que es la cantidad a 0
        $producto = array(
            'rowid' => $rowid,
            'qty' => 0
        );
        //después simplemente utilizamos la función update de la librería cart
        //para actualizar el carrito pasando el array a actualizar
        $this->cart->update($producto);

        $this->session->set_flashdata('productoEliminado', 'El producto fue eliminado correctamente');
        redirect('cotizacion', 'refresh');
    }

    function eliminarCarrito() {
        $this->cart->destroy();
        $this->session->set_flashdata('destruido', 'El carrito fue eliminado correctamente');
        redirect('cotizacion', 'refresh');
    }
    public function iniciarCaptcha(){

 			 $this->load->model('captcha_model');
 			 $this->load->helper('captcha');
       $vals = array(
      //  'word'          => 'Random word',
        'img_path'      => './assets/img/captcha/',
        'img_url'       => base_url().'assets/img/captcha/',
        'font_path'     => './path/to/fonts/texb.ttf',
        'img_width'     => '150',
        'img_height'    => 45,
        'expiration'    => 7200,
        'word_length'   => 6,
        'font_size'     => 35,/*,
        'img_id'        => 'Imageid'/*,
        'pool'          => '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
*/
        // White background and border, black text and red grid
        'colors'        => array(
                'background' => array(255, 255, 255),
                'border' => array(255, 255, 255),
                'text' => array(0, 0, 0),
                'grid' => array(255, 40, 40)
        )
);

$cap = create_captcha($vals);


/*
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
       */
 			 $this->session->set_userdata('captcha', $cap['word']);


 			 return $cap;




 	 }
 	 public function validate_captcha()
 	 {
//echo "esto era ".$this->session->userdata('captcha')."<p>";
 			 if($this->input->post('captcha') != $this->session->userdata('captcha'))
 			 {
 					 //echo "<p>se envio eso = ".$this->input->post('captcha')."</p>";
 					 $this->form_validation->set_message('validate_captcha', 'Error en el codigo de verificacion');
 					 return false;
 			 }else{
 					 return true;
 			 }

 	 }

}
