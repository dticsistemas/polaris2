<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pruebas extends CI_Controller {


    function __construct()
    {
        parent::__construct();
    }

	public function index()
	{
    $this->load->view('prueba_view');
	}
  public function mostrar(){

    $output=array();
    //---Enviando datos de inicio
    $data_aux=getScriptsInit();
    $output = (object) $output;
    $output->mensajes=$data_aux['mensajes'];
    $output->notificaciones=$data_aux['notificaciones'];
    $this->load->view('template/header_admin_view', $output);
		$this->load->view('template/footer_admin_view', $output);
  }
  public function recibir()
  {
    // En versiones de PHP anteriores a la 4.1.0, debería utilizarse $HTTP_POST_FILES en lugar
    // de $_FILES.

    $dir_subida = '/var/www/html/polaris/assets/img/fotografias';
    $fichero_subido = $dir_subida . basename($_FILES['fichero_usuario']['name']);

    echo '<pre>';
    if (move_uploaded_file($_FILES['fichero_usuario']['tmp_name'], $fichero_subido)) {
        echo "El fichero es válido y se subió con éxito.\n";
    } else {
        echo "¡Posible ataque de subida de ficheros!\n";
    }

    echo 'Más información de depuración:';
    print_r($_FILES);

    print "</pre>";


  }


}
