<?php
class Banners_model extends CI_Model {
 
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

    public function get_banners()
    {
        $this->db->select('*');
        $this->db->from('banners');
        $query = $this->db->get();
        $data = $query->result_array();         
        return $data;
    } 
    
 
}
?>