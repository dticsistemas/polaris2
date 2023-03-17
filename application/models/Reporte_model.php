<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Horario_model class.
 *
 * @extends CI_Model
 */
class Reporte_model extends CI_Model {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {

		parent::__construct();

	}

	public function get_count_personas() {
		$this->db->select('*');
		$this->db->from('personas');
        return $this->db->count_all_results();

	}

	public function get_cantidad_productos_total()
	{
		$this->db->from('productos');
		$this->db->where('activo','Habilitado');
		return $this->db->count_all_results();
	}
	public function get_pedidos_pendientes_global_group_persona($id_persona)
	{
			$this->db->select('*');
			$this->db->from('pedidos');
			$this->db->where('id_vendedor',$id_persona);
			$this->db->where('estado !=','Cancelado');
			$this->db->group_by('id');
			return $this->db->count_all_results();
	}
	public function get_cantidad_ventas_persona($id_persona)
	{
		$this->db->from('ventas');
		$this->db->where('estado','0');
		$this->db->where('id_vendedor',$id_persona);
		$this->db->where('tipo',VENTA_CONTADO);
		$this->db->or_where('tipo',VENTA_SUSPENDIDA_CONTADO);
		$this->db->or_where('estado','');
		return $this->db->count_all_results();
	}
	/////////////////////////////////////////////////////
	//-------------------SUMAS
	////////////////////////////////////////////////////
	public function get_total_ventas_mensual_tipo($fecha,$tipo)
	{
		$this->db->select_sum('total');
		$this->db->where('fecha >=',$fecha.' 00:00:00');
		$timestamp = strtotime( $fecha );
		$diasdelmes = date( "t", $timestamp );
		$fecha_fin=date('Y-m',$timestamp).'-'.$diasdelmes.' 23:59:59';
		$this->db->where('fecha <=',$fecha_fin);
		$this->db->where('tipo',$tipo);
		$query = $this->db->get('ventas');
		$total= $query->row('total');;
		if($total==null)
			return 0;
		else
			return $total;
	}
	public function get_cantidad_stock_productos_total()
	{
		$this->db->select_sum('cantidad');
		return $this->db->get('inventarios')->row('cantidad');
	}
	public function get_count_actividades_presente() {
		$year=date('Y');
		$this->db->select('*');
		$this->db->from('actividades');
		$this->db->like('fecha_inicio', $year);
        return $this->db->count_all_results();

	}
	public function get_count_notas_presente() {
		$year=date('Y');
		$this->db->select('*');
		$this->db->from('notificaciones');
		$this->db->like('fecha_inicio', $year);
        return $this->db->count_all_results();

	}
	public function get_experiencias_vigentes() {

		$this->db->select('*');
		$this->db->from('experiencias');
		$this->db->where('estado', 'Activo');
		$query = $this->db->get();
		$aux= $query->result_array();
        return $aux;

	}
	public function obtener_ventas_global_fecha_ranged($fecha_inicio,$fecha_fin,$id_sucursal){

		$this->db->select('*');
		$this->db->from('ventas');
		$this->db->where('fecha >=', $fecha_inicio.' 00:00:00');
		$this->db->where('fecha <=', $fecha_fin.' 00:00:00');
		if($id_sucursal!=0)
		$this->db->where('id_sucursal', $id_sucursal);
		$this->db->order_by('fecha','asc');

		$query = $this->db->get();
		$aux= $query->result_array();
		return $aux;
	}

	public function get_notificaciones_vigentes() {
		//---Actualizar el estado de las notificaciones que han expirado de fecha fin

		$fecha_actual=date('Y-m-d');
		$this->db->set('estado','Inactivo');
		$this->db->where('fecha_fin <', $fecha_actual);
		$this->db->update('notificaciones');

		$this->db->select('*');
		$this->db->from('notificaciones');
		$this->db->where('estado', 'Activo');
		$query = $this->db->get();
		$aux= $query->result_array();
        return $aux;

	}
	public function get_programaciones_vigentes(){
		//---Actualizar el estado de las programaciones que han expirado de fecha fin

		$fecha_actual=date('Y-m-d');
		$this->db->set('estado','Inactivo');
		$this->db->where('fecha_limite <', $fecha_actual);
		$this->db->update('programaciones');

		$this->db->select('*');
		$this->db->from('programaciones');
		$this->db->where('estado', 'Activo');
		$this->db->where('fecha_limite >=', $fecha_actual);
		$query = $this->db->get();
		$aux= $query->result_array();
        return $aux;

	}

}
