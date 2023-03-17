<?php
class Data_model extends CI_Model {

    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
    }

    public function get_dispositivo($keyAPK)
    {
        $this->db->select('*');
        $this->db->from('dispositivos');
        $this->db->where('keyAPK',$keyAPK);
        $query = $this->db->get();
        $data = $query->result_array();
        if(count($data)>0)
            return $data[0];
        else
            return null;
    }
    public function insertar_venta($data){
       $this->db->insert('ventas', $data);
       return $this->db->insert_id();
    }
    public function insertar_transferencia_apk($id_venta,$keyAPK,$id_venta_apk){
       $data=array(
        'id_venta'=>$id_venta,
        'keyAPK'=>$keyAPK,
        'id_venta_apk'=>$id_venta_apk
        );
       $this->db->insert('transferencias_apk', $data);
    }
    public function insertar_ventaproductos($dataventaproducto){
        $this->db->insert('venta_productos', $dataventaproducto);
    }
    public function insertar_cliente($data){
        $this->db->insert('clientes', $data);
        return $this->db->insert_id();
    }
    public function is_valid($id_usuario,$keyAPK) {

      $this->db->select('*');
      $this->db->from('dispositivos');
      $this->db->where('id_usuario', $id_usuario);
      $this->db->where('keyAPK', $keyAPK);
      $query = $this->db->get();
      $res = $query->result_array();
      if(count($res)>0)
      return true;
      else
      return false;
    }
    

}
?>
