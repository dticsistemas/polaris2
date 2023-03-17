<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Captcha_model extends CI_Model {
 
public function __construct()
{
   parent::__construct();
}
 
public function insertar_captcha($data)
{
//insertamos el captcha en la bd    
$query = $this->db->insert_string('captcha', $data);
$this->db->query($query);
 
}
 
public function remover_old_captcha($expiration)
{
//eliminamos los registros de la base de datos cuyo
//captcha_time sea menor a expiration
$this->db->where('captcha_time <',$expiration);
$this->db->delete('captcha');
 
}
 
public function check($ip,$expiration,$captcha)
{
//comprobamos si existe un registro con los datos
//envíados desde el formulario
$this->db->where('word',$captcha);
$this->db->where('ip_address',$ip);
$this->db->where('captcha_time >',$expiration);
 
$query = $this->db->get('captcha');
//devolvemos el número de filas que coinciden
return $query->num_rows();
}
 
}
?>