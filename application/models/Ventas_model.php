<?php
class Ventas_model extends CI_Model {

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

    public function insertar_ventas($data)
    {
        $this->db->insert('ventas', $data);
        return $this->db->insert_id();
    }
    public function insert_ventas_productos($data)
    {

        $this->db->insert('venta_productos', $data);
        //------descontar del inventario-------
        //-----si es asi se debera tener en cuenta
        //------la bandera de configuracion de inventario stock=true

    }
    public function update_monto_ventas_productos($id_venta,$monto_final){

      $this->db->set('total' , $monto_final);
      $this->db->where('id',$id_venta);
      $this->db->update( 'ventas' );

    }
    public function obtener_venta($id_venta)
    {
        $query = $this->db->get_where('ventas', array('id' => $id_venta));
        $aux = $query->result_array();
        if(count($aux)>0){
        $res = $aux[0];
        return $res;
        }else{
            return $aux;
        }


    }
    public function obtener_monto_venta($id_venta)
    {
        $this->db->select('total');
        $query = $this->db->get_where('ventas', array('id' => $id_venta));
        $aux = $query->result_array();
        if(count($aux)>0){
        $res = $aux[0];
        return $res['total'];
        }else{
            return 0;
        }


    }
    public function obtener_cantidad_detalle_venta($id_venta)
    {

        $this->db->select('*');
        $this->db->from('venta_productos');
        $this->db->join('productos', 'productos.id = venta_productos.id_producto');
        $this->db->where('id_venta',$id_venta);
        $this->db->order_by('orden','asc');
        
        return $this->db->count_all_results();;

    }
    public function obtener_detalle_venta($id_venta)
    {

        $this->db->select('*');
        $this->db->from('venta_productos');
        $this->db->join('productos', 'productos.id = venta_productos.id_producto');
        $this->db->where('id_venta',$id_venta);
        $this->db->order_by('orden','asc');
        $query = $this->db->get();
        return $query->result_array();

    }
    public function obtener_detalle_venta_productos_name($id_venta)
    {

        $this->db->select('id_producto,orden,precio,cantidad,nombre');
        $this->db->from('venta_productos');
        $this->db->join('productos', 'productos.id = venta_productos.id_producto');
        $this->db->where('id_venta',$id_venta);
        $this->db->order_by('orden','asc');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function reponer_adetalle_venta($id_venta)
    {

        $this->db->select('*');
        $this->db->from('venta_productos');
        $this->db->join('productos', 'productos.id = venta_productos.id_producto');
        $this->db->where('id_venta',$id_venta);
        $this->db->order_by('orden','asc');
        $query = $this->db->get();
        return $query->result_array();

    }
    public function get_top_productos_vendidos_ranged($fecha_inicio,$fecha_fin,$limit){
      $this->db->select('id_producto, SUM(cantidad) AS cantidad', FALSE);
      $this->db->from('venta_productos');
      $this->db->join('ventas', 'ventas.id = venta_productos.id_venta');
      $this->db->where('ventas.fecha >=', $fecha_inicio);
      $this->db->where('ventas.fecha <=', $fecha_fin);
      $this->db->where('ventas.estado !=', ANULADA);
      $this->db->group_by("id_producto");
      $this->db->limit($limit,0);
      $this->db->order_by('cantidad','desc');
      $query = $this->db->get();
      return $query->result_array();
    }
    public function insertar_pagos($data)
    {
        $this->db->insert('pagos', $data);
        return $this->db->insert_id();
    }
    ///------------------_PEDIDOS----------------
    public function get_ventas_pendientes_cliente($id_cliente)
    {
        $this->db->select('id,total,venta_productos.*');
        $this->db->from('venta_productos');
        $this->db->join('ventas', 'ventas.id = venta_productos.id_venta');
        $this->db->where('id_cliente',$id_cliente);
        $this->db->where('ventas.estado','P');
        $this->db->order_by('id_venta,orden');
        $query = $this->db->get();
        $data = $query->result_array();

        return $data;
    }
    public function update_estado_venta($id_venta,$estado){

      $this->db->set('estado' , $estado);
      $this->db->where('id',$id_venta);
      $this->db->update( 'ventas' );

    }
     public function actualizar_venta_productos($data){
      $this->db->where('id_venta', $data['id_venta']);
      $this->db->where('id_producto', $data['id_producto']);
      $this->db->where('orden', $data['orden']);
      $this->db->update('venta_productos', $data);
    }
    public function get_ventas_pedidos_pendientes_global_group()
    {
        $this->db->select('*');
        $this->db->from('venta_productos');
        $this->db->join('ventas', 'ventas.id = venta_productos.id_venta');
        $this->db->group_by('ventas.id');
        $this->db->where('ventas.estado ','P');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }

}
?>
