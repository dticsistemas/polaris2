<?php
class Plan_pago_model extends CI_Model {

    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
    }

    /**
    * Get product by his is
    * @param int $product_id
    * @return array
    */
    /*
    public function get_settings()
    {


		$this->db->select('*');
		$this->db->from('settings');
		$query = $this->db->get();
		return $query->result_array();
    }*/
    public function get_cliente($id_cliente)
    {


        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('id',$id_cliente);
        $query = $this->db->get();
        $aux= $query->result_array();
        if(count($aux)>0)
        return $aux[0];
        else
            return array();

    }
    public function   get_cliente_by_ci($ci)
    {


        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('ci',$ci);
        $query = $this->db->get();
        $aux= $query->result_array();
        if(count($aux)>0)
        return $aux[0];
        else
            return null;

    }
    public function get_cuenta_cliente($id_cliente)
    {
        $this->db->select('*');
        $this->db->from('cuenta_cliente');
        $this->db->where('id_cliente',$id_cliente);
        $query = $this->db->get();
        $aux= $query->result_array();
        if(count($aux)>0)
        return $aux[0];
        else
            return null;

    }
    public function get_planpago_vigente_cliente($id_cliente)
    {
        $this->db->select('*');
        $this->db->from('plan_pagos');
        $this->db->where('id_cliente',$id_cliente);
        $this->db->where('estado','A');///Activo
        $query = $this->db->get();
        $aux= $query->result_array();
        if(count($aux)>0)
        return $aux[0];
        else
            return null;

    }
    public function get_pagos_by_id_cliente($id_cliente){
      $this->db->select('*');
      $this->db->from('pagos');
      $this->db->where('id_cliente',$id_cliente);
      //$this->db->where('estado','A');///Activo
      $query = $this->db->get();
      $aux= $query->result_array();
      if(count($aux)>0)
      return $aux;
      else
          return null;
    }

    public function get_cuotas_pagadas($id_pago){
      $this->db->select('*');
      $this->db->from('pagos_cuotas');
      $this->db->where('id_pago',$id_pago);
      $query = $this->db->get();
      $aux= $query->result_array();
      if(count($aux)>0)
      return $aux;
      else
          return null;
    }
    public function get_cuota_pagada_by_id_numero($id_plan_pago,$numero){
      $this->db->select('*');
      $this->db->from('cuotas');
      $this->db->where('id_plan_pago',$id_plan_pago);
      $this->db->where('numero',$numero);
      $query = $this->db->get();
      $aux= $query->result_array();
      if(count($aux)>0)
      return $aux[0];
      else
          return null;
    }
    public function get_cuotas_planpago($id_plan_pago)
    {
        $this->db->select('*');
        $this->db->from('cuotas');
        $this->db->where('id_plan_pago',$id_plan_pago);
        //$this->db->where('estado','A');///Activo
        $query = $this->db->get();
        $aux= $query->result_array();
        if(count($aux)>0)
        return $aux;
        else
            return null;

    }
    public function insertar_plan_pagos($data){
        $this->db->insert('plan_pagos', $data);
        return $this->db->insert_id();
    }
    public function insertar_cuotas($data){
        $this->db->insert('cuotas', $data);
    }
    public function anular_plan_pagos_cuotas($id_cliente){
      //---anular plan de pagos activos---
      $id_plan_anterior=0;
      //1) buscando paln activo de cliente
      $this->db->select('*');
      $this->db->from('plan_pagos');
      $this->db->where('id_cliente',$id_cliente);
      $this->db->where('estado','A');//-- este activo
      $query = $this->db->get();
      $aux= $query->result_array();
      if(count($aux)>0){
        $plan_pago=$aux[0];
        //--anulando plan pago
        $id_plan_anterior=$plan_pago['id'];
        $plan_pago['estado']='R';//reprogramado a un nuevo palna
        $this->db->where('id', $id_plan_anterior);
        $this->db->update('plan_pagos', $plan_pago);
        //--anulando ahora sus anular cuotas
        $cuotas=array('estado'=>'R');
        $this->db->from('cuotas');
        $this->db->where('id_plan_pago', $id_plan_anterior);
        $this->db->where('estado','A');
        $this->db->update('cuotas', $cuotas);
        return $id_plan_anterior;
      }
      else //--no existe plan vigente
          return $id_plan_anterior;


    }
    public function update_cuota($id_plan_pago,$numero,$data){

      $this->db->where('id_plan_pago', $id_plan_pago);
      $this->db->where('numero', $numero);
      $this->db->update('cuotas', $data);

      if($this->db->affected_rows()>0)
      return true;
      else
          return false;
    }

}
?>
