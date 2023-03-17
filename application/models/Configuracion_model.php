<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Configuracion_model class.
 *
 * @extends CI_Model
 */
class Configuracion_model extends CI_Model {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		parent::__construct();

	}

	/**
	 * get_configuracion function.
	 *
	 * @access public
	 * @param mixed none
	 * @return object the configuracion object
	 */
	public function get_configuracion() {

		$this->db->select('*');
        $this->db->from('configuracion');
        $query = $this->db->get();
        $aux= $query->result_array();
        if(count($aux)>0)
        return $aux[0];
        else
            return array('id' => 1,
             'nombre'  => 'Polaris',
             'resenia' => 'Sistema catalogo de Ventas WEB',
             'lema'    => 'Sistema CVO');

	}
	public function get_name_tipo_venta($tipo) {
		/*define('VENTA_CONTADO',0);
		define('VENTA_CREDITO',1);
		define('VENTA_SUSPENDIDA_CONTADO',2);
		define('VENTA_SUSPENDIDA_CREDITO',3);*/
		switch ($tipo) {
			case VENTA_CONTADO:
				return "VENTA AL CONTADO";
				break;
			case VENTA_CREDITO:
				return "VENTA AL CREDITO";
				break;
			case VENTA_SUSPENDIDA_CONTADO:
				return "VENTA SUSPENDIDA";
				break;
			case VENTA_SUSPENDIDA_CREDITO:
				return "VENTA SUSPENDIDA CREDITO";
				break;

			default:
				return "NO IDENTIFICADO";
				break;
		}

	}
	public function update_Configuracion($nombre,$resenia,$lema){
	//----actualizadno la fecha_anterio por la fecha actual de la
	//----ultima revision----
		$this->db->set('nombre', $nombre);
		$this->db->set('resenia', $resenia);
		$this->db->set('lema', $lema);
		$this->db->where('id', 1);
		$this->db->update('configuracion');
	}
	public function get_notificaciones_pendientes() {
				$this->db->select('*');
        $this->db->from('notificaciones');
        $this->db->where('estado','Activo');
        $this->db->order_by('fecha','desc');
        $query = $this->db->get();
        $aux= $query->result_array();
				return $aux;

	}
	public function set_inactivo_notificacion($id){
		$this->db->set('estado', 'Inactivo');
		$this->db->where('id', $id);
		$this->db->update('notificaciones');
	}
	public function get_setting_usuario($id){

		    $this->db->select('*');
        $this->db->from('settings_users');
        $query = $this->db->get();
        $aux= $query->result_array();
        if(count($aux)>0)
        return $aux[0];
        else
            return array('id' => 0,
             'top_panel'  => 0,
             'left_panel' => 0,
             'right_panel'=> 0,
						 'fullscreen'=>0,
						 'ventas_statistics'=>0,
						 'usuarios_statistics'=>0,
						 'productos_top'=>0,
						 'pedidos_vigentes'=>0,	
					   'skin'=>'skin-blue');

	}
	public function insertar_setting_usuario($data,$id_usuario){
		$this->db->select('*');
    $this->db->from('settings_users');
		$this->db->where('id', $id_usuario);
    $query = $this->db->get();
    $aux= $query->result_array();
    if(count($aux)>0){//---existe
				//---actualizando
				//$this->db->set('top_panel', $data['top_panel']);
				$this->db->where('id', $id_usuario);
				$this->db->update('settings_users',$data);
		}
    else{
			$data['id']=$id_usuario;
			$this->db->insert('settings_users', $data);
	  }
	}
}
