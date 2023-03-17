<?php
class Personas_model extends CI_Model {

    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
    }
    public function get_full_name($id_persona){
      $this->db->select('CONCAT(nombre,apellidos) as nombre');
  		$this->db->from('personas');
  		$this->db->where('id', $id_persona);
      $query = $this->db->get();
  		$res=$query->result_array();
      if(count($res)>0){
      $aux=$res[0];
      return $aux['nombre'];
      }
      return "";

  	}
    public function get_fotografia($id_persona){
      $this->db->select('fotografia');
  		$this->db->from('personas');
  		$this->db->where('id', $id_persona);
      $query = $this->db->get();
  		$res=$query->result_array();
      if(count($res)>0){
      $aux=$res[0];
      return $aux['fotografia'];
      }
      return "0.png";

  	}

    /**
    * Get productos en oferta by his is
    * @param int $product_id
    * @return array
    */

    public function listVendedores()
    {

        $this->db->select('*');
        $this->db->from('personas');
        //$this->db->where('tipo','VENDEDOR');
        $query = $this->db->get();
        $query =$query->result_array();
        $result = array();
        foreach ($query as $usuario) {
            $result[trim($usuario['id'])]=$usuario['nombre'] .' '.$usuario['apellidos'] ;
        }
        return $result;
    }
    public function listCobradores()
    {

        $this->db->select('*');
        $this->db->from('personas');
        //$this->db->where('tipo','COBRADOR');
        $query = $this->db->get();
        $query =$query->result_array();
        $result = array();
        foreach ($query as $usuario) {
            $result[trim($usuario['id'])]=$usuario['nombre'] .' '.$usuario['apellidos'] ;
        }
        return $result;
    }
    public function update_perfil($email,$direccion,$telefono,$facebook,$id_persona){
      $data = array(
        'email'   => $email,
        'direccion'   => $direccion,
        'telefono'   => $telefono,
        'facebook'   => $facebook
      );
      $this->db->where('id', $id_persona);
      return $this->db->update('personas', $data);
    }


}
?>
