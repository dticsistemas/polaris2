<?php
class Slideshow_model extends CI_Model {
 
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

    public function get_imagenes()
    {         
        
        $this->db->select('*');
        $this->db->from('slideshow');
        $this->db->order_by('priority',"asc");       
        $query = $this->db->get();
        return $query->result_array(); 
    } 
    
 
}
?>