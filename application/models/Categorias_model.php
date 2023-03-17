<?php
class Categorias_model extends CI_Model {

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
    public function get_categorias()
    {


		$this->db->select('*');
		$this->db->from('categorias');
		$query = $this->db->get();
		return $query->result_array();
    }
    public function get_categorias_visibles()
    {


        $this->db->select('*');
        $this->db->from('categorias');
        $this->db->where('visible',1);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_comboxcategorias(){
      $this->db->select('*');
      $this->db->from('categorias');
      $this->db->where('tipo','Activo');
      $query = $this->db->get();
      $query =$query->result_array();
      $result = array('Todos');
      foreach ($query as $usuario) {
          $result[trim($usuario['id'])]=$usuario['nombre'] ;
      }
      return $result;
    }
    public function get_categorias_primarias()
    {


        $this->db->select('*');
        $this->db->from('categorias');
        $this->db->where('tipo','Activo');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_subcategorias($id)
    {
        $this->db->select('*');
        $this->db->from('categorias');
        $this->db->where('id_parent',$id);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function obtenerCategoriasTotal(){
        $aux = $this->get_categorias_primarias();
        $res = null;
        if(count($aux)>0){
            foreach ($aux as $categoria) {
                $id=$categoria['id'];
                $tmp=$this->obtenerSubcategorias($id);
                $categoria['sub_categorias']=$tmp;
                $res[]=$categoria;
            }
        }
        return $res;
    }
    public function obtenerSubcategorias($id){
        $aux=$this->get_subcategorias($id);
        $res=null;
        if(count($aux)==0)return null;
        foreach ($aux as $categoria) {
            $id_categoria=$categoria['id'];
            $tmp=$this->obtenerSubcategorias($id_categoria);
            $categoria['sub_categorias']=$tmp;
            $res[]=$categoria;
        }
        return $res;
    }

}
?>
