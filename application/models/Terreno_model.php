<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Horario_model class.
 * 
 * @extends CI_Model
 */
class Terreno_model extends CI_Model {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		
	}	
	
	
    public function get_terreno($id_terreno) {     
        $this->db->select('*'); 
        $this->db->from('terrenos');
        $this->db->where('id',$id_terreno);
        $query = $this->db->get();
        $aux= $query->result_array();                      
        if(count($aux)>0){
            return $aux[0];
        }
        return null;                        
            
    }
   
    public function get_AreasZonasTerreno($id_terreno) {     
        $this->db->select('*'); 
        $this->db->from('zonas');
        $this->db->where('id_terreno',$id_terreno);
        $query = $this->db->get();
        $aux= $query->result_array();                      
        if(count($aux)>0){
            return $aux;
        }
        return null;                        
            
    }
	
	
}
