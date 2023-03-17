<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if ( ! function_exists('getScriptsInit'))
{
    function getScriptsInit(){
    //require_once(APPPATH."views/common/scripts.php");

    $ci=& get_instance();
    $ci->load->database();

    //$sql = "select * from mensajes where id_destinatario ='".$_SESSION['user_id']."' ".
    " and estado='pendiente'";
    $sql="select mensajes.*,fotografia,username as usuario from (mensajes inner join usuarios on".
    " usuarios.id=mensajes.id_remitente) inner join personas on usuarios.id_persona=personas.id ".
    " where id_destinatario = ".$_SESSION['user_id']." and mensajes.estado='pendiente'";
    $query = $ci->db->query($sql);
    $data['mensajes']= $query->result_array();
    $sql = "select * from notificaciones where estado='Activo' ".
    " ORDER BY FIELD(tipo, 'Critico','Advertencia','Informativo','Mensaje')";
    $query = $ci->db->query($sql);
    $data['notificaciones']=$query->result_array();

    return $data;
    //echo "probando el include";
    }

}
