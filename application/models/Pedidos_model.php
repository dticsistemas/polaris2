<?php
class Pedidos_model extends CI_Model {

    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
    }

    /**
    * Get productos en oferta by his is
    * @param int $product_id
    * @return array
    */

    public function get_pedidos_pendientes_global_group()
    {
        $this->db->select('*');
        $this->db->from('pedidos');
        $this->db->group_by('id');
        $this->db->where('estado !=','Finalizado');
        $this->db->where('estado !=','Cancelado');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function get_pedidos_pendientes_flash_view_group()
    {
        $this->db->select('*');
        $this->db->from('pedidos');
        $this->db->group_by('id');
        $this->db->where('estado !=','Finalizado');
        $this->db->where('estado !=','Cancelado');
        $this->db->order_by('fecha','desc');
        $this->db->limit(6);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function get_pedidos_pendientes_cliente($id_cliente)
    {
        $this->db->select('*');
        $this->db->from('pedidos');
        $this->db->where('id_cliente',$id_cliente);
        $this->db->where('estado !=','Finalizado');
        $this->db->where('estado !=','Cancelado');
        $this->db->order_by('fecha');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function insertar($data){
        $this->db->insert('pedidos', $data);
        return $this->db->insert_id();
    }
    public function actualizar($data,$id,$orden,$fecha_inicio){
      $this->db->where('id', $id);
      $this->db->where('orden', $orden);
      $this->db->where('fecha_inicio', $fecha_inicio);
      $this->db->update('pedidos', $data);
    }
    public function get_cant_productos_by_group($id,$fecha_inicio){
      $this->db->select_sum('cantidad');
      $this->db->where('id', $id);
      $this->db->where('fecha_inicio', $fecha_inicio);
      return $this->db->get('pedidos')->row('cantidad');
    }
    public function get_monto_by_group($id,$fecha_inicio){
      $this->db->select_sum('total');
      $this->db->where('id', $id);
      $this->db->where('fecha_inicio', $fecha_inicio);
      return $this->db->get('pedidos')->row('total');
    }
    public function insertarCotizacion($data){
        $this->db->insert('cotizaciones', $data);
        return $this->db->insert_id();
    }
    public function insertarProductoCotizacion($data){
        $this->db->insert('productos_cotizados', $data);
        return $this->db->insert_id();
    }
    public function get_cotizacion_pendientes()
    {
        $this->db->select('*');
        $this->db->from('cotizaciones');
        $this->db->where('estado','0');
        //$this->db->where('estado !=','Cancelado');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function get_cotizacion_id($id)
    {
        $this->db->select('*');
        $this->db->from('cotizaciones');
        $this->db->where('id',$id);
        //$this->db->where('estado !=','Cancelado');
        $query = $this->db->get();
        $data = $query->result_array();
        if(count($data)>0){
          return $data[0];
        }
        return $data;
    }
    public function get_productos_cotizacion_id($id_cotizacion){
      $this->db->select('*');
      $this->db->from('productos_cotizados');
      $this->db->where('id_cotizacion',$id_cotizacion);
      //$this->db->where('estado !=','Cancelado');
      $query = $this->db->get();
      $data = $query->result_array();
      return $data;
    }
    public function actualizar_cotizacion($id_cotizacion,$respuesta,$estado){
      $data=array('estado'=>$estado,
                  'respuesta'=>$respuesta,
                  'fecha_respuesta'=>date('Y-m-d H:i:s'));
      $this->db->where('id', $id_cotizacion);
      $this->db->update('cotizaciones', $data);
    }
    public function actualizar_producto_cotizacion($id_cotizacion,$id_producto,$monto){
      $data=array('precio'=>$monto);
      $this->db->where('id_cotizacion', $id_cotizacion);
      $this->db->where('id_producto', $id_producto);
      $this->db->update('productos_cotizados', $data);
    }

    public function get_cant_productos_by_cotizacion($id){
      $this->db->select_sum('cantidad');
      $this->db->where('id_cotizacion', $id);
      return $this->db->get('productos_cotizados')->row('cantidad');
    }


}
?>
