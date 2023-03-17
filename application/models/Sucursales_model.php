<?php
class Sucursales_model extends CI_Model {

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

    public function get_sucursales()
    {

        $this->db->select('*');
        $this->db->from('sucursales');
        $this->db->order_by('tipo',"asc");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function listSucursales()
    {

        $this->db->select('*');
        $this->db->from('sucursales');
        $this->db->order_by('tipo',"asc");
        $query = $this->db->get();
        $query =$query->result_array();
        $result = array();
        foreach ($query as $sucursal) {
            $result[trim($sucursal['id'])]=$sucursal['nombre'];
        }
        return $result;
    }
    public function get_namesucursal_from_id($id) {

  		$this->db->select('nombre');
  		$this->db->from('sucursales');
  		$this->db->where('id', $id);

  		return $this->db->get()->row('nombre');

  	}
    public function listSucursalesDiferentes($id_sucursal)
    {

        $this->db->select('*');
        $this->db->from('sucursales');
        $this->db->where('id!= ',$id_sucursal);
        $this->db->order_by('tipo',"asc");
        $query = $this->db->get();
        $query =$query->result_array();

        return $query;
    }


}
?>
