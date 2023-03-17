<?php
class Clientes_model extends CI_Model {

    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
      parent::__construct();
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
    public function update_agenda_cobranzas_cliente($data){
      //---actualizando las anteriores
      $this->db->where('id_cliente', $data['id_cliente']);
      $data_aux=array('estado'=>'C');
      $this->db->update('agenda_cobranzas_clientes', $data_aux);
      //---insertando agenda
      $this->db->insert('agenda_cobranzas_clientes', $data);
    }
    public function get_agenda_cobranzas_cliente($id_cliente){
      $this->db->select('*');
      $this->db->from('agenda_cobranzas_clientes');
      $this->db->where('id_cliente',$id_cliente);
      $this->db->where('estado','A');
      $query = $this->db->get();
      $aux= $query->result_array();
      if(count($aux)>0)
      return $aux[0];
      else{ //--- se creara---

        $data=array(
          'id_cliente'=>$id_cliente,
          'direccion_cobranza'=>'NN',
          'telefono_cobranza'=>'000-000-000',
          'zona'=>'NN',
          'hora_estimada'=>'00:00',
          'garante_1'=>'NN',
          'ci_1'=>'000',
          'direccion_1'=>'NN',
          'telefono_1'=>'000',
          'garante_2'=>'NN',
          'ci_2'=>'000',
          'direccion_2'=>'NN',
          'telefono_2'=>'000',
          'estado'=>'A'

      );
        $this->db->insert('agenda_cobranzas_clientes', $data);
        return $data;

      }
    }
    public function get_namecliente_from_id($id) {
      if($id==0){
        return 'NN <span class="fa fa-female"> </span>';
      }else if($id==1){
        return 'NN <span class="fa fa-male"> </span>';
      }else{
      $this->db->select('nombres');
      $this->db->from('clientes');
      $this->db->where('id', $id);
      return $this->db->get()->row('nombres');
    }

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
    public function  get_id_namecliente_by_search($word)
    {
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->like('nombres',$word);
        $query = $this->db->get();
        $aux= $query->result_array();
        return $aux;
    }
    public function get_cuenta_cliente($id_cliente)
    {
        $this->db->select('*');
        $this->db->from('clientes');
        $this->db->where('id',$id_cliente);
        $query = $this->db->get();
        $aux= $query->result_array();
        if(count($aux)>0){
          $cliente=$aux[0];
          if($cliente['fotografia']==''){
            $cliente['fotografia']='no_image.png';
          }
          if($cliente['oficio']==''){
            $cliente['oficio']='No especificado';
          }
          if($cliente['email']==''){
            $cliente['email']='Sin especificar';
          }
          $cuenta_cliente=null;
          $this->db->select('*');
          $this->db->from('cuenta_cliente');
          $this->db->where('id',$id_cliente);
          $query = $this->db->get();
          $aux= $query->result_array();
          if(count($aux)>0){
            $cuenta_cliente=$aux[0];
          }else{//--creando la cuenta_cliente
            $cuenta_cliente=array(
              'id'=>$id_cliente,
              'monto_credito_maximo'=>'3500',
              'deuda'=>'0',
              'saldo'=>'0',
              'estado'=>'A',
              'tipo'=>0

            );
            $this->db->insert('cuenta_cliente', $cuenta_cliente);

          }

          //--enviando info de la cuenta-cliente
          $cliente['cuenta_cliente']=$cuenta_cliente;
          return $cliente;
        }
        else{
          return null;
          //echo "No existe el id de cliente<br>";
        }
        return null;

    }

    public function insertar($data){
        $this->db->insert('clientes', $data);
        return $this->db->insert_id();
    }
    public function actualizar($data,$id_cliente){
      $this->db->where('id', $id_cliente);
      $this->db->update('clientes', $data);
    }
    public function insertar_cuenta_cliente($data){
        $this->db->insert('cuenta_cliente', $data);
    }
    public function actualizar_cuenta_cliente($data,$id_cliente){
      $this->db->where('id', $id_cliente);
      $this->db->update('cuenta_cliente', $data);
    }

}
?>
