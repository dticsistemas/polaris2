<?php
class Mensajes_model extends CI_Model {

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

    public function get_mensajes()
    {
        $this->db->select('*');
        $this->db->from('mensajes');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function get_mensajes_usuarios($id_usuario)
    {
        $this->db->select('*');
        $this->db->from('mensajes');
        $this->db->where('id_remitente',$id_usuario);
        $this->db->or_where('id_destinatario',$id_usuario);
        $this->db->order_by('fecha','desc');
        $this->db->limit(6);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function get_mensajes_usuarios_pendientes($id_usuario)
    {
        $this->db->select('*');
        $this->db->from('mensajes');
        $this->db->where('id_destinatario',$id_usuario);
        $this->db->where('estado','pendiente');
        //$this->db->limit(6);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;
    }
    public function set_mensajes_leidos($id_usuario)
    {
        $this->db->set('estado' , 'leido');
        //$this->db->where('id_remitente',$id_usuario);
        $this->db->or_where('id_destinatario',$id_usuario);
        //$this->db->order_by('fecha');
        $this->db->update( 'mensajes' );

    }
    public function registrar($data)
    {
        $this->db->insert('mensajes', $data);

    }


    public function get_mensajes_mixed()
    {
        $this->db->select('*');
        $this->db->from('mensajes');
        $query = $this->db->get();
        $data = $query->result_array();
        shuffle($data);
        return $data;
    }


}
?>
