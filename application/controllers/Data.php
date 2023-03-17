<?php
// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';


class Data extends REST_Controller
{

  function actualizar_get()
  {
     $this->load->model('data_model');
     $keyAPK=$this->get('keyAPK');
     $id_usuario=$this->get('id_usuario');

     if (!$this->data_model->is_valid($id_usuario,$keyAPK)){
        $res['returned'] = 'Acceso No Autorizado';
        $this->response($res);
     }
     else {
     //----Si ha enviado el id del dispositivo
     $dispositivo=$this->data_model->get_dispositivo($keyAPK);
     //$res['res']=$dispositivo;

     if($dispositivo!=null){ /// si esta registrado el dispositivo
     if($dispositivo['estado']=='Habilitado'){ /// si esta habilitado el dispositivo
      $res['returned'] = 'true';
       // Display all categorias
    // $this->db->select('id,nombre,descripcion,tipo,id_categoria');
     $this->db->from('categorias');
     $query = $this->db->get();
     $res['categorias']= $query->result_array();

      // Display all categoriasproductos
     //$this->db->select('id_producto,id_categoria');
     $this->db->from('categoria_productos');
     $query = $this->db->get();
     $res['categoria_productos']= $query->result_array();

     // Display all productos
     //$this->db->select('id,codigo,nombre,titulo,subtitulo,especificaciones,descripcion,servicios,activo');
     $this->db->from('productos');
     //$this->db->where('activo','Habilitado')
     $this->db->order_by('id', 'Asc');
     $query = $this->db->get();
     $res['productos']= $query->result_array();

    // Display all sucursales
     //$this->db->select('id,nombre,direccion,telefono,tipo,location');
     $this->db->from('sucursales');
     $this->db->order_by('tipo', 'Asc');
     $query = $this->db->get();
     $res['sucursales']= $query->result_array();
     // Display all imagenes
    // $this->db->select('id,imagen,id_producto,orden');
     $this->db->from('imagenes');
     $query = $this->db->get();
     $res['imagenes']= $query->result_array();
     // Display all datos personales
    // $this->db->select('id,imagen,id_producto,orden');

		 $this->load->model('user_model');
     $user    = $this->user_model->get_usuario_id($id_usuario);
     $user = (array)$user;
     $persona= $this->user_model->get_persona($user['id_persona']);
     $user['grupo'] = $this->user_model->get_name_grupo($user['id_grupo']);
     $user['persona'] = $persona->nombre.' '.$persona->apellidos;
     $user['fotografia'] = $this->user_model->get_fotografia_user($user['id']);
     $user['sucursal'] = $this->user_model->get_nombre_sucursal($id_usuario);
     $res['perfil_usuario']= $user;

     //---registrando la lectura
      $logs_update = array(
      "id_usuario" => $dispositivo['id_usuario'],
      "ip"=>$_SERVER ['REMOTE_ADDR'],
      "id_accion"=>11,
      "data" => 'APKPolaris: '.$dispositivo['keyAPK']
      );
    $this->db->insert('bitacora',$logs_update);

     //----enviando la respuesta
     $this->response($res);
    }//si no esta registrado
    else{
        $res['returned'] = 'Acceso No Autorizado, No habilitado';
        $this->response($res);
    }
    }else{
        $res['returned'] = 'Acceso No Autorizado, No registrado';
        $this->response($res);
    }
    }
  }

     //crear una nueva venta realizada por el usuario APK
    //dvuelve el id de la venta_transferida
    public function insertar_post()
    {

    	/* recive esto
 {"keyAPK":"e41bb1ad47830d1e",
 "id_usuario_apk":"6",
 "id":2,"id_usuario":1,"
 fecha":"2019-04-15 00:40:58","
 id_cliente":0,"
 nota":"Venta al contado","
 total":10,"estado":"A","
 transferida":"0",
 "id_sucursal":0,
 "tipo":1,
 "id_vendedor":0,
 "venta_productos":[
            {"id_venta":2,"id_producto":36,"cantidad":1,"precio":10,"orden":0}],
            "cliente":{"id":0,"nombres":"NN","sexo":"Hombre","ci":"0","nit":"0","procedencia":"proce","direccion":"NN","telefono":"0","fecha_nacimiento":""
          }}
2019-04-16 07:05:14.896 4601-4639/com.kitsoft.apkpolaris E/ERROR: Internal Server Error
    	*/
     $this->load->model('data_model');

     $keyAPK=$this->post("keyAPK");
     $logs_update = array(
       "id_usuario" => 0
       "ip"=>$_SERVER ['REMOTE_ADDR'],
       "id_accion"=>11,
       "data" => $keyAPK.' Ingresando peticion'.$this->post('id_usuario_apk')
     );
     $this->db->insert('bitacora',$logs_update);

     $id_usuario_apk=$this->post('id_usuario_apk');
     if (!$this->data_model->is_valid($id_usuario_apk,$keyAPK)){
        $res['returned'] = 'Acceso No Autorizado'.$id_usuario.' ky='.$keyAPK;
        $this->response($res);
     }
     else {
     $dispositivo=$this->data_model->get_dispositivo($keyAPK);
     if($dispositivo!=null){ /// si esta registrado el dispositivo


     if($dispositivo['estado']=='Habilitado'){ /// si esta habilitado el dispositivo

        $id_venta_apk=$this->post("id");
        $keyAPK=$dispositivo['id'];
        $id_usuario=$this->post('id_usuario');
        $fecha=$this->post("fecha");
        $hora=$this->post("hora");
        //$id_cliente=$this->post("id_cliente");//se tomara por el otro lado
        $nota=$this->post("nota");
        $total=$this->post("total");
        $estado=$this->post("estado");
        $estado=$this->post("transferida");
        $id_sucursal=post("id_sucursal");
        $tipo=$this->post("tipo");
       // $id_vendedor=$this->post("id_vendedor");
       //---antes se debe registrar al cliente caso de ser nuevo
       //---por defecto no verificara excepto el vacio
        $cliente = $this->post("cliente");
        $id_cliente=$cliente['id'];
        if($id_cliente!="0"){
            $data_cliente = array(
                //'id'=>$cliente['id'], es autoincrement
                'nombres'=>$cliente['nombres'],
                'sexo'=>$cliente['sexo'],
                'ci'=>$cliente['ci'],
              //  'nit'=>$cliente['nit'],
              //  'procedencia'=>$cliente['procedencia'],
                'direccion'=>$cliente['direccion'],
                'telefono'=>$cliente['telefono'],
                'fecha_nacimiento'=>$cliente['fecha_nacimiento']
                );
        //---se debe actualizar el id en la BD central respectiva
        $id_cliente=$this->data_model->insertar_cliente($data_cliente);
        }
        //---ahora si registrando la venta   con el cliente ya ingresado si era difrente de NN id=0
        //--------caso de venta------------
        $data_ventas = array(
               'id_usuario' => $id_usuario_apk,
               'fecha' =>      $fecha,
               'id_cliente' => $id_cliente,
               'nota' =>       $nota,
               'total' =>      $total,
               'estado' => FINALIZADA,
               'transferida' =>$id_venta_apk,
               'id_vendedor'=>$id_usuario,
               'id_sucursal'=>$id_sucursal,
               'tipo'=>VENTA_CONTADO
            );

        $id_venta = $this->data_model->insertar_venta($data_ventas);
        ////////////////////////////////////////////////////
         $venta_productos=$this->post("venta_productos");
        foreach ($venta_productos as $fila ) {
            //--muy bueno eso de enviar arrays

            $id_producto = $fila['id_producto'];
            $cantidad= $fila['cantidad'];
            $precio= $fila['precio'];
            $orden=$fila['orden'];
            $dataventa_producto = array(
                'id_venta' => $id_venta,
                'id_producto' => $id_producto,
                'orden' =>$orden,
                'cantidad' => $cantidad,
                'precio' => $precio
            );
             $this->data_model->insertar_ventaproductos($dataventa_producto);
             //  $logs_update = array("id_usuario" =>0,"accion" => 'venta-producto registrada' );$this->db->insert('bitacora',$logs_update);


        }
        //---si todo esta bien----
        //registro transferenia para debugear mejor
        $this->data_model->insertar_transferencia_apk($id_venta,$keyAPK,$id_venta_apk);
        //---registrando la bitacora
        $logs_update = array(
          "id_usuario" => $dispositivo['id_usuario'],
          "ip"=>$_SERVER ['REMOTE_ADDR'],
          "id_accion"=>11,
          "data" => 'APKPolaris: '.$dispositivo['keyAPK']
        );
        $this->db->insert('bitacora',$logs_update);
        //-------------------
         $res['returned']='true';
         $res['id_venta']=$id_venta;
        $this->response($res);
     }else{
        $res['returned'] = 'Acceso No Autorizado, No habilitado';
        $this->response($res);
    }
    }else{
        $res['returned'] = 'Acceso No Autorizado, KEY No Registrado';
        $this->response($res);

     }

    }
  }

}
