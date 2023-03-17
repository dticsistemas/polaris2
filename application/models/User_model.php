<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User_model class.
 *
 * @extends CI_Model
 */
class User_model extends CI_Model {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
	}

	/**
	 * create_user function.
	 *
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function create_user($username, $persona, $password,$grupo,$avatar) {

		$data = array(
			'username'   => $username,
			'id_grupo'   => $grupo,
			'id_persona' => $persona,
			'id_sucursal'=> 0,  ///aun no justificado
			'password'   => $this->hash_password($password),
			'estado'=> 'Activo',
			'avatar'=>$avatar,
			'logged_in'=>0
		);

		return $this->db->insert('usuarios', $data);

	}
	/**
	 * edit_user function.
	 *
	 * @access public
	 * @param mixed $username
	 * @param mixed $email
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function edit_user($user_id,$username, $password,$id_sucursal) {

		$data = array(
			'username'   => $username,
			'password'   => $this->hash_password($password),
			'id_sucursal'=>$id_sucursal
		);

		$this->db->where('id', $user_id);
		return $this->db->update('usuarios', $data);
	}

	/**
	 * resolve_user_login function.
	 *
	 * @access public
	 * @param mixed $username
	 * @param mixed $password
	 * @return bool true on success, false on failure
	 */
	public function resolve_user_login($username, $password) {

		$this->db->select('password');
		$this->db->from('usuarios');
		$this->db->where('username', $username);
		$this->db->where('estado', 'Activo');
		$hash = $this->db->get()->row('password');
		return $this->verify_password_hash($password, $hash);
	}

	/**
	 * get_user_id_from_username function.
	 *
	 * @access public
	 * @param mixed $username
	 * @return int the user id
	 */
	public function get_user_id_from_username($username) {

		$this->db->select('id');
		$this->db->from('usuarios');
		$this->db->where('username', $username);

		return $this->db->get()->row('id');

	}
	public function get_name_grupo($id){
		$this->db->select('nombre');
		$this->db->from('grupos');
		$this->db->where('id', $id);
		return $this->db->get()->row('nombre');
	}
	public function get_nombre_sucursal($id){
		$this->db->select('nombre');
		$this->db->from('sucursales');
		$this->db->where('id', $id);
		return $this->db->get()->row('nombre');
	}


	/**
	 * get_user function.
	 *
	 * @access public
	 * @param mixed $user_id
	 * @return object the user object
	 */
	public function get_user($user_id) {

		$this->db->from('usuarios');
		$this->db->where('id', $user_id);
		return $this->db->get()->row();

	}
	public function get_fotografia_user($id_persona){
		$this->db->select('fotografia');
		$this->db->from('personas');
		$this->db->join('usuarios','usuarios.id_persona = personas.id');
		$this->db->where('usuarios.id', $id_persona);
		$query = $this->db->get();
		$res=$query->result_array();
		if(count($res)>0){
		$aux=$res[0];
		return $aux['fotografia'];
		}
		return "0.png";

	}
	public function get_otros_usuarios($user_id) {

		$this->db->from('usuarios');
		$this->db->where('id !=', $user_id);
		$query = $this->db->get();
		$res=array();
		foreach ($query->result_array()	as $fila) {
			$res[$fila['id']]=$fila['username'];
		}
		return $res;
	}
	public function get_usuario_id($user_id) {

		$this->db->from('usuarios');
		$this->db->where('id', $user_id);
		$query = $this->db->get();
		$res=$query->result_array();
		if(count($res)>0){
		$aux=$res[0];
		return $aux;
		}
		return array('username'=>'NN',
								'avatar'=>'0');

	}
	public function get_username_from_id($id) {

		$this->db->select('username');
		$this->db->from('usuarios');
		$this->db->where('id', $id);

		return $this->db->get()->row('username');

	}
	public function get_persona($id_persona){
		$this->db->from('personas');
		$this->db->where('id', $id_persona);
		return $this->db->get()->row();

	}
	/**
	 * get_all_users function.
	 *
	 * @access public
	 * @param none
	 * @return object the user object
	 */
	public function get_all_users() {

		$this->db->from('usuarios');
		$query = $this->db->get();
        return $query->result_array();

	}
	/**
	 * get_all_personas_activas_users function.
	 *
	 * @access public
	 * @param none
	 * @return object the user object
	 */
	public function get_all_personas_activas_users() {

		$this->db->from('personas');
		$this->db->select('id,nombre,apellidos');
		$this->db->where('estado','Activo');
		$query = $this->db->get();
        return $query->result_array();

	}
	/**
	 * get_all_grupos function.
	 *
	 * @access public
	 * @param none
	 * @return object the user object
	 */
	public function get_all_grupos() {

		$this->db->from('grupos');
		$query = $this->db->get();
				return $query->result_array();

	}
	/**
	 * hash_password function.
	 *
	 * @access private
	 * @param mixed $password
	 * @return string|bool could be a string on success, or bool false on failure
	 */
	private function hash_password($password) {

		return password_hash($password, PASSWORD_BCRYPT);

	}

	/**
	 * verify_password_hash function.
	 *
	 * @access private
	 * @param mixed $password
	 * @param mixed $hash
	 * @return bool
	 */
	private function verify_password_hash($password, $hash) {

		return password_verify($password, $hash);

	}

}
