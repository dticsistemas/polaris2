<?php
class Imagenes_model extends CI_Model {

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

    public function get_imagenes_productos($id_producto)
    {
        $this->db->select('*');
        $this->db->from('imagenes');
        $this->db->where('id_producto',$id_producto);
        $this->db->order_by('orden',"asc");
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function get_imagen_producto($id_producto)
    {
        $this->db->select('*');
        $this->db->from('imagenes');
        $this->db->where('id_producto',$id_producto);
        $this->db->order_by('orden',"asc");
        $query = $this->db->get();
        $data = $query->result_array();
        if(count($data)>0)
        return $data[0];
        else{
            $aux['id_producto']=$id_producto;
            $aux['descripcion']="No Images";
            $aux['imagen']="no_image.png";
            return $aux;
        }




    }
    public function get_imagen_producto_one($id_producto)
    {
        $this->db->select('*');
        $this->db->from('imagenes');
        $this->db->where('id_producto',$id_producto);
        $this->db->order_by('orden',"asc");
        $query = $this->db->get();
        $data = $query->result_array();
        if(count($data)>0){
        $aux=$data[0];
        return $aux['imagen'];
        }
        else{
            return "no_image.png";
        }




    }


}
?>
