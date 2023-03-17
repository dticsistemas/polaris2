<?php
class Cotizacion_model extends CI_Model {

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

    public function get_cotizacion_pendientes()
    {
        $this->db->select('*');
        $this->db->from('cotizaciones');
        $this->db->where('estado !=','Finalizado');
        $this->db->where('estado !=','Cancelado');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
  /*  public function get_consignacion_pendientes_global_cliente()
    {
        $this->db->select('*');
        $this->db->from('consignaciones');
        $this->db->group_by('id_cliente');
        $this->db->where('estado !=','Finalizado');
        $this->db->where('estado !=','Cancelado');
        $this->db->order_by('fecha_entrega','asc');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function get_consignacion_pendientes_cliente($id_cliente)
    {
        $this->db->select('*');
        $this->db->from('consignaciones');
        $this->db->where('id_cliente',$id_cliente);
        $this->db->where('estado !=','Finalizado');
        $this->db->where('estado !=','Cancelado');
        $this->db->order_by('fecha');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }*/
    public function insertar($data){
        $this->db->insert('consignaciones', $data);
        return $this->db->insert_id();
    }
    public function actualizar($data,$id,$orden,$fecha_inicio){
      $this->db->where('id', $id);
      $this->db->where('orden', $orden);
      $this->db->where('fecha_inicio', $fecha_inicio);
      $this->db->update('consignaciones', $data);
    }
    public function obtener_consignacion($id,$orden,$fecha_inicio){
      $this->db->select('*');
      $this->db->from('consignaciones');
      $this->db->where('id',$id);
      $this->db->where('orden',$orden);
      $this->db->where('fecha_inicio',$fecha_inicio);
      $query = $this->db->get();
      $data = $query->result_array();
      if(count($data)>0){
        $data=$data[0];
      }else{
          $data=array('id'=>0,
            'orden'=>0,
            'fecha_inicio'=>'0000-00-00',
            'cantidad'=>1,
            'total'=>0,
            'fecha_devolucion'=>'0000-00-00',
            'id_cliente'=>0,
            'cantidad_vendida'=>0
          );
      }
      return $data;
    }
    public function finalizar($id,$orden,$fecha_inicio,$cantidad_vendida,$anotacion){
      $data =array(
        'cantidad_vendida'=>$cantidad_vendida,
        'anotacion'=>$anotacion,
        'estado'=>'Finalizado',
        'fecha_devolucion'=>date('Y-m-d')
      );
      $this->db->where('id', $id);
      $this->db->where('orden', $orden);
      $this->db->where('fecha_inicio', $fecha_inicio);
      $this->db->update('consignaciones', $data);
    }

    public function get_cant_productos_by_group($id,$fecha_inicio){
      $this->db->select_sum('cantidad');
      $this->db->where('id', $id);
      $this->db->where('fecha_inicio', $fecha_inicio);
      return $this->db->get('consignaciones')->row('cantidad');
    }
    public function get_cant_productos_by_cliente($id_cliente){
      $this->db->select_sum('cantidad');
      $this->db->where('estado !=','Finalizado');
      $this->db->where('estado !=','Cancelado');
      $this->db->where('id_cliente',$id_cliente);
      return $this->db->get('consignaciones')->row('cantidad');
    }
    public function get_monto_by_group($id,$fecha_inicio){
      $this->db->select_sum('total');
      $this->db->where('id', $id);
      $this->db->where('fecha_inicio', $fecha_inicio);
      return $this->db->get('consignaciones')->row('total');
    }
    public function get_monto_deuda_pendiente($id_cliente){
      $this->db->select_sum('total');
      $this->db->where('id_cliente', $id_cliente);
      $this->db->where('estado !=','Finalizado');
      $this->db->where('estado !=','Cancelado');
      return $this->db->get('consignaciones')->row('total');
    }


}
?>
