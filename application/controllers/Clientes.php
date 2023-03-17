<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Clientes extends CI_Controller {


    function __construct()
    {
        parent::__construct();
        $this->load->model('productos_model');
        $this->load->model('imagenes_model');
        $this->load->model('categorias_model');
        $this->load->model('sucursales_model');
        $this->load->library('pagination');
    }

	public function index()
	{

		//$this->mostrarVista(array(),'web/categorias_view');

	}
     public function mostrarVista($data=null,$vista=null){
       //---Enviando datos de inicio
       $data_aux=getScriptsInit();
       $output = (object) $output;
       $output->mensajes=$data_aux['mensajes'];
       $output->notificaciones=$data_aux['notificaciones'];

       $this->load->view('template/tp_header_view',$data);
       $this->load->view($vista,$data);
       $this->load->view('template/tp_footer_view');
    }
    public function listar_clientes_select(){
      $this->load->model('clientes_model');
      if($this->input->is_ajax_request())
       {
         $word=$this->input->get('q');

         $arr_clientes=$this->clientes_model->get_id_namecliente_by_search($word);
         $data['total_count']=count($arr_clientes);
         $data['incomplete_results']=false;
         $clientes=array();

         foreach ($arr_clientes as $cli) {
           if(empty($cli['fotografia']))
           $cli['fotografia']='no_image.jpg';
           $aux =array(
                  'id'=>$cli['id'],
                  'text'=> $cli['nombres'],
                  'direccion'=> $cli['direccion'],
                  'foto'=> $cli['fotografia']);
           $clientes[]=$aux;
         }

        //$var=implode($_GET,' ');
         $data['items']=$clientes;

         echo json_encode($data);

       }
    }
    public function gestionar_cliente(){
      $this->load->model('clientes_model');
      $data=array(
        'nombres'=>$this->input->post('nombre'),
        'sexo'=>$this->input->post('sexo'),
        'direccion'=>$this->input->post('direccion'),
        'ci'=>$this->input->post('ci'),
        'facebook'=>$this->input->post('facebook'),
        'email'=>$this->input->post('email'),
        'referencia'=>$this->input->post('referencia')
      );
      //print_r($data);
      //---evitando el ingreso de ci repetido

      $resp['result']=true;
      $resp['nombres']=$this->input->post('nombre');
      if($this->input->post('ci')=='')
      $id_cliente=$this->clientes_model->insertar($data);
      $cli=$this->clientes_model->get_cliente_by_ci($this->input->post('ci'));
      if($cli!=null){
        $id_cliente=$cli['id'];
        $resp['nombres']=$cli['nombres'];
        $resp['result']=false;
      }else {
        $id_cliente=$this->clientes_model->insertar($data);
      }
      $resp['id_cliente']=$id_cliente;

      echo json_encode($resp);
    }

    public function obtener_info_cicliente(){
        //-------
      $this->load->model('clientes_model');
      $response['id']=0;
      $response['nombres']='';
      if($this->input->get('ci')){
          $ci=$this->input->get('ci');
          $cliente = $this->clientes_model->get_cliente_by_ci($ci);
           if($cliente!=null){
              $response['nombres']=$cliente['nombres'];
              $response['id']=$cliente['id'];
              $response['direccion']=$cliente['direccion'];
              $response['telefono']=$cliente['telefono'];
              $response['email']=$cliente['email'];
              $response['sexo']=$cliente['sexo'];
              $response['facebook']=$cliente['facebook'];
              $response['fecha_nacimiento']=$cliente['fecha_nacimiento'];
              $response['referencia']=$cliente['referencia'];
              $response['oficio']=$cliente['oficio'];
              $response['dir_trabajo']=$cliente['dir_trabajo'];
              $response['fotografia']=$cliente['fotografia'];
              if($cliente['fotografia']=='')
              $response['fotografia']='no_image.jpg';
              //----------verificando si solicita cuenta_cliente
              if($this->input->get('cuenta_cliente')){
                //---obteniendo info de cuenta clientes
                $cuenta_cliente = $this->clientes_model->get_cuenta_cliente($cliente['id']);
                if($cuenta_cliente==null){
                  $response['cuenta_cliente']='
                  <div class="alert alert-info alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-info"></i> Cliente Nuevo!</h4>
                  Au no tiene Cuenta creada.
                  </div>';
                  $response['deuda']=0;
                }else {
                  //--pasando informacion de la cuenta cliente
                $response['deuda']=$cuenta_cliente['deuda'];
                $response['saldo']=$cuenta_cliente['saldo'];
                if($cuenta_cliente['estado']=='M'){
                $response['cuenta_cliente']='
                  <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Cliente Advertido!</h4>
                    No tiene cuentas claras, ni historial bueno .
                  </div>';
                }else if($cuenta_cliente['estado']=='P'){
                  $response['cuenta_cliente']='
                <div class="alert alert-warning alert-dismissible">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                  <h4><i class="icon fa fa-warning"></i> Cliente Activo!</h4>
                  El cliente esta pagando aun sus cuotas. Deuda: '.$cuenta_cliente['deuda'].'
                </div>';
              }else if($cuenta_cliente['estado']=='A'){
                  $response['cuenta_cliente']='
                    <div class="alert alert-success alert-dismissible">
                      <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                      <h4><i class="icon fa fa-check"></i> Cliente Libre!</h4>
                      El cliente no tiene deudas.
                    </div>';
                }
              }
              }
          }
      }
      echo json_encode($response);
    }
    public function modificar_agenda(){

      //---recibir datos agenda
      $data=array(
        'id_cliente'        =>$this->input->post('id_cliente'),
        'direccion_cobranza'=>$this->input->post('direccion_cobranza'),
        'zona'              =>$this->input->post('zona'),
        'telefono_cobranza' =>$this->input->post('telefono_cobranza'),
        'hora_estimada'     =>$this->input->post('hora_estimada'),
        'garante_1'         =>$this->input->post('garante_1'),
        'ci_1'              =>$this->input->post('ci_1'),
        'direccion_1'       =>$this->input->post('direccion_1'),
        'telefono_1'        =>$this->input->post('telefono_1'),
        'garante_2'         =>$this->input->post('garante_2'),
        'ci_2'              =>$this->input->post('ci_2'),
        'direccion_2'       =>$this->input->post('direccion_2'),
        'telefono_2'        =>$this->input->post('telefono_2'),
        'estado'            =>'A'
      );
      $this->load->model('clientes_model');
      //---actualizar los anteriores
    //  $this->clientes_model->update_agenda_cobranzas_cliente($data);
      //---preparar respuesta
      $html=
      '<table class="table " >'.
        '<tr>'.
          '<th>Direccion</th><td>'.$data['direccion_cobranza'].'</td>'.
          '<th>Zona</th><td>'.$data['zona'].'</td>'.
        '</tr>'.
        '<tr>'.
          '<th>Telefono</th><td>'.$data['telefono_cobranza'].'</td>'.
          '<th>Hora</th><td>'.$data['hora_estimada'].'</td>'.
        '</tr>'.
        '<tr>'.
          '<th>Garante 1</th><td>'.$data['garante_1'].'</td>'.
          '<th>CI:</th><td>'.$data['ci_1'].'</td>'.
        '</tr>'.
        '<tr>'.
          '<th>Direccion 1</th><td>'.$data['direccion_1'].'</td>'.
          '<th>Telefono 1:</th><td>'.$data['telefono_1'].'</td>'.
        '</tr>'.
        '<tr>'.
          '<th>Garante 2</th><td>'.$data['garante_2'].'</td>'.
          '<th>CI:</th><td>'.$data['ci_2'].'</td>'.
        '</tr>'.
        '<tr>'.
          '<th>Direccion 2</th><td>'.$data['direccion_2'].'</td>'.
          '<th>Telefono 2:</th><td>'.$data['telefono_2'].'</td>'.
        '</tr>'.
      '</table>';

      $response=array(
        'success'=>'true',
        'html'=>$html
      );

      echo json_encode($response);


    }

}
