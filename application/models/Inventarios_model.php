<?php
class Inventarios_model extends CI_Model {

    /**
    * Responsable for auto load the database
    * @return void
    */
    public function __construct()
    {
      parent::__construct();
    }

    /**
    * Get cantidad de productos total
    * @param none
    * @return array
    */
    public function get_cantidad_productos_total()
    {
      $this->db->select_sum('cantidad');
      $this->db->from('inventarios');
      $this->db->join('productos', 'productos.id = inventarios.id_producto');
      $this->db->where('tipo !=','Insumo');
      return $this->db->get()->row('cantidad');
    }
    public function get_cantidad_insumos_total()
    {
      $this->db->select_sum('cantidad');
      $this->db->from('inventarios');
      $this->db->join('productos', 'productos.id = inventarios.id_producto');
      $this->db->where('tipo !=','Producto');
      return $this->db->get()->row('cantidad');
    }
    public function get_cantidad_productos($id_sucursal,$id_producto)
    {
        $this->db->select_sum('cantidad');
        $this->db->from('inventarios');
        $this->db->join('productos', 'productos.id = inventarios.id_producto');
        $this->db->where('tipo !=','Insumo');
        $this->db->where('id_sucursal',$id_sucursal);
        $this->db->where('id_producto',$id_producto);
        return $this->db->get()->row('cantidad');
    }
    public function get_cantidad_insumos($id_sucursal,$id_producto)
    {
        $this->db->select_sum('cantidad');
        $this->db->from('inventarios');
        $this->db->join('productos', 'productos.id = inventarios.id_producto');
        $this->db->where('tipo !=','Producto');
        $this->db->where('id_sucursal',$id_sucursal);
        $this->db->where('id_producto',$id_producto);
        return $this->db->get()->row('cantidad');
    }
    public function get_stock_minimo_productos($id_producto)
    {
        $cantidad = 0;
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('id',$id_producto);
        $query = $this->db->get();
        $data = $query->result_array();
        if(count($data)>0){
            $aux = $data[0];
            $cantidad=$aux['stock_minimo'];
        }
        return $cantidad;
    }
    public function get_cantidad_productos_sucursal($id_sucursal)
    {
        $this->db->select_sum('cantidad');
        $this->db->where('id_sucursal',$id_sucursal);
        $this->db->join('productos', 'productos.id = inventarios.id_producto');
        $this->db->where('tipo !=','Insumo');
        $cant=$this->db->get('inventarios')->row('cantidad');

        if($cant==null)
        $cant=0;
        return $cant;

    }
    public function get_cantidad_insumos_sucursal($id_sucursal)
    {
        $this->db->select_sum('cantidad');
        $this->db->where('id_sucursal',$id_sucursal);
        $this->db->join('productos', 'productos.id = inventarios.id_producto');
        $this->db->where('tipo !=','Producto');
        $cant=$this->db->get('inventarios')->row('cantidad');

        if($cant==null)
        $cant=0;
        return $cant;

    }
    public function actualizar_cantidad_productos($id_sucursal,$id_producto,$cantidad)
    {
         $this->db->set('cantidad' , 'cantidad +('.$cantidad.')', FALSE);
         $this->db->where('id_sucursal',$id_sucursal);
         $this->db->where('id_producto',$id_producto);
         $this->db->update( 'inventarios' );
         //-----disparar trigger-----------
         $stock_minimo =$this->get_stock_minimo_productos($id_producto);
         $cantidad     =$this->get_cantidad_productos($id_sucursal,$id_producto);
         if($cantidad<=$stock_minimo){
             $tipo="Advertencia";
             $mssg='Stock minimo en el producto Id:'.$id_producto;
            if($cantidad<=0){
             $tipo="Critico";
             $mssg='No Existe stock para el producto Id:'.$id_producto;
           }
             $data=array('title'=>'Inventario',
                         'mensaje'=>$mssg,
                         'tipo'=>$tipo,
                         'estado'=>'Activo');
             $this->db->insert('notificaciones', $data);
         }

    }
    public function habilitarProductoInventario($id_producto,$id_sucursal){


        $this->db->select('*');
        $this->db->from('inventarios');
        $this->db->where('id_sucursal',$id_sucursal);
        $this->db->where('id_producto',$id_producto);
        $query = $this->db->get();
        $data = $query->result_array();
        if(count($data)==0){//----si no existe
             $data = array(
             'id_producto' => $id_producto ,
             'id_sucursal' => $id_sucursal ,
             'cantidad' => '0'
             );
             $this->db->insert('inventarios',$data);
        }

    }
     public function habilitarProductosInventarioAllSucursales(){

        $this->db->select('*');
        $this->db->from('sucursales');
        $this->db->order_by('tipo',"asc");
        $query = $this->db->get();
        $sucursales=$query->result_array();
        foreach ($sucursales as $value) {
            $id_sucursal=$value['id'];
            $arr_productos=$this->get_productos_faltantes_sucursal($id_sucursal);
            foreach ($arr_productos as $producto) {
                //----habilitando los productos en la sucursal
                $data = array(
                 'id_producto' => $producto['id'],
                 'id_sucursal' => $id_sucursal ,
                 'cantidad' => '0',
                 'estado'=>'Habilitado'
                 );
                 $this->db->insert('inventarios',$data);
            }
        }

    }
    public function get_productos_inventarios(){
        $this->db->select('id,nombre,codigo,activo');
        $this->db->from('productos');
        $this->db->where('tipo !=','Insumo');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;

    }
    public function get_insumos_inventarios(){
        $this->db->select('id,nombre,codigo,activo');
        $this->db->from('productos');
        $this->db->where('tipo !=','Producto');
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;

    }
    public function get_productos_faltantes_sucursal($id_sucursal){

        $this->db->select('id,nombre');
        $this->db->from('productos');
        $this->db->where('`id` not in', '(select `id_producto` from `inventarios` where `id_sucursal` = '.$id_sucursal.')', false);
        $query = $this->db->get();
        $data = $query->result_array();
        return $data;

    }
    public function insertar_reposicion($data){
        $this->db->insert('reposiciones', $data);
        return $this->db->insert_id();
    }
    public function is_mercaderia($id){
      $sw=false;
      $this->db->select('tipo');
      $this->db->from('productos');
      $this->db->where('id',$id);
      $this->db->where('tipo','Mercaderia');
      $query = $this->db->get();
      $data = $query->result_array();

      if(count($data)>0){
        $sw=true;
      }

      return $sw;
    }

}
?>
