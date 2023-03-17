<?php
class Productos_model extends CI_Model {

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

    public function get_productos_destacados()
    {
        $this->db->select('*');
        $this->db->from('destacados');
        $this->db->join('productos', 'destacados.id_producto = productos.id');
        $query = $this->db->get();
        $data = $query->result_array();
        shuffle($data);
        return $data;
    }
    public function get_detalle_producto_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('productos');
		$this->db->where('id', $id);
		$query = $this->db->get();
		return $query->result_array();
    }
    public function get_producto_by_id($id)
    {
		$this->db->select('*');
		$this->db->from('productos');
		$this->db->where('id', $id);
		$query = $this->db->get();
    $aux=$query->result_array();
    if(count($aux)>0)
    return $aux[0];
    else
        return array();
    }
     public function get_productos_by_categoria($id_categoria)
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->join('categoria_productos', 'categoria_productos.id_producto = productos.id');
        $this->db->where('id_categoria', $id_categoria);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_precio_producto_by_sucursal($id_producto,$id_sucursal)
    {
        $this->db->select('*');
        $this->db->from('inventarios');
        $this->db->where('id_producto', $id_producto);
        $this->db->where('id_sucursal', $id_sucursal);
        $query = $this->db->get();
        $res = $query->result_array();
        $result = array();
        if (count($res)==0){
            $result['precio']=-1;
            $result['id_producto']=$id_producto;
            $result['id_sucursal']=$id_sucursal;
            $result['medida']='unidad';
        }else{
            $result=$res[0];
        }
        return $result;
    }
    public function get_productos_by_categoria_sucursal($id_categoria,$id_sucursal)
    {

        $this->db->select('id_producto');
        $this->db->from('inventarios');
        $this->db->where('id_sucursal', $id_sucursal);
        $query = $this->db->get();
        $aux=$query->result_array();
        $inventarios=array();
        foreach ($aux as $aux1) {
        $inventarios[]=$aux1['id_producto'];
        }
        $productos=array();
        if (count($aux)>0){
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->join('categoria_productos', 'categoria_productos.id_producto = productos.id');
        $this->db->where('id_categoria', $id_categoria);
        $this->db->where_in('productos.id', $inventarios);
        $query = $this->db->get();
        $productos= $query->result_array();
        }

        return $productos;
    }
    public function get_productos_total_sucursal($id_sucursal)
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->join('inventarios', 'id_producto = productos.id');
        $this->db->where('id_sucursal', $id_sucursal);
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_productos_total()
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('tipo !=','Insumo');
        $this->db->where('activo', 'Habilitado');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_insumos_total()
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->where('tipo !=','Producto');
        $this->db->where('activo', 'Habilitado');
        $query = $this->db->get();
        return $query->result_array();
    }
    public function get_productos_total_by_sucursal($id_sucursal)
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->join('inventarios', 'inventarios.id_producto = productos.id');
        $this->db->where('id_sucursal', $id_sucursal);
        $query = $this->db->get();
        return $query->result_array();

    }
     public function obtener_productos_total($id_categoria=null)
    {
        $this->db->select('*');
        $this->db->from('productos');
        $this->db->join('categoria_productos', 'productos.id = categoria_productos.id_producto');
        $this->db->group_by('productos.id');

        if($id_categoria != null && $id_categoria != 0){

            $this->db->where('categoria_productos.id_categoria', $id_categoria);

        }
        $query = $this->db->get();
        return $query->result();
    }
    public function obtener_arrayproductos_total($id_categoria=null)
   {
       $this->db->select('*');
       $this->db->from('productos');
       $this->db->join('categoria_productos', 'productos.id = categoria_productos.id_producto');
       $this->db->group_by('productos.id');

       if($id_categoria != null && $id_categoria != 0){

           $this->db->where('categoria_productos.id_categoria', $id_categoria);

       }
       $query = $this->db->get();
       return $query->result_array();
   }
    public function obtener_productos_cantidad_total_group_by_id()
   {
       $this->db->select('id,nombre,titulo,precio_base,cantidad');
       $this->db->from('productos');
       $this->db->join('inventario_global', 'productos.id = inventario_global.id_producto');

       $query = $this->db->get();
       return $query->result_array();
   }
    public function get_producto_similares($id_producto,$cantidad)
    {
        //---obteniendo las categorias
        $this->db->select('id_categoria');
        $this->db->from('categoria_productos');
        $this->db->where('categoria_productos.id_producto', $id_producto);
        $query = $this->db->get();
        $data1 = null;
        foreach ($query->result() as $row)
        {
           $data1[]=$row->id_categoria;
        }

        //---obteniendo los productos
        $this->db->select('id_producto');
        $this->db->from('categoria_productos');
        $this->db->where_in('id_categoria', $data1);
        $query = $this->db->get();
        $data2 = null;
        foreach ($query->result() as $row)
        {
            $data2[]=$row->id_producto;
        }
        $this->db->select('id');
        $this->db->select('nombre');
        $this->db->select('codigo');
        $this->db->from('productos');
        $this->db->where_in('id', $data2);
        $this->db->where('id !=', $id_producto);
        $this->db->order_by('rand()');
        $this->db->limit($cantidad);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_productos($id_categoria=null, $search_string=null, $order=null, $order_type='Asc', $limit_start, $limit_end)
    {


        $this->db->select('productos.id');
        $this->db->select('productos.nombre');
        $this->db->select('productos.codigo');
        $this->db->select('productos.descripcion');
        //$this->db->select('productos.precio_venta');
       // $this->db->select('productos.id_categoria');
        //$this->db->select('categorias.nombre as categoria_nombre');
        $this->db->from('productos');
        $this->db->join('categoria_productos', 'productos.id = categoria_productos.id_producto', 'left');

        if($id_categoria != null && $id_categoria != 0){

            $this->db->where('categoria_productos.id_categoria', $id_categoria);

        }
        if($search_string){
            $this->db->like('productos.nombre', $search_string);
        }


        $this->db->group_by('productos.id');

        if($order){
            $this->db->order_by($order, $order_type);
        }else{
            $this->db->order_by('productos.id', $order_type);
        }


        $this->db->limit($limit_start, $limit_end);
        //$this->db->limit('4', '4');


        $query = $this->db->get();
        $res = $query->result_array();
        $s = $this->db->last_query();
        //echo "<p> Consulta =  $s </p>";

        return $res;

    }

    /**
    * Count the number of rows
    * @param int $manufacture_id
    * @param int $search_string
    * @param int $order
    * @return int
    */
    function count_productos($id_categoria=null, $search_string=null, $order=null)
    {
		$this->db->select('*');
		$this->db->from('productos');
        $this->db->join('categoria_productos', 'productos.id = categoria_productos.id_producto', 'left');

		if($id_categoria != null && $id_categoria != 0){
			$this->db->where('categoria_productos.id_categoria', $id_categoria);

		}
		if($search_string){
			$this->db->like('nombre', $search_string);
		}
		if($order){
			$this->db->order_by($order, 'Asc');
		}else{
		    $this->db->order_by('productos.id', 'Asc');
		}
		$query = $this->db->get();
		return $query->num_rows();
    }

    /**
    * Store the new item into the database
    * @param array $data - associative array with data to store
    * @return boolean
    *//*
    function store_producto($data)
    {
		$insert = $this->db->insert('productos', $data);
	    return $insert;
	}*/

    /**
    * Update product
    * @param array $data - associative array with data to store
    * @return boolean
    *//*
    function update_producto($id, $data)
    {
		$this->db->where('id_producto', $id);
		$this->db->update('productos', $data);
		$report = array();
		$report['error'] = $this->db->_error_number();
		$report['message'] = $this->db->_error_message();
		if($report !== 0){
			return true;
		}else{
			return false;
		}
	}*/

    /**
    * Delete product
    * @param int $id - product id
    * @return boolean
    */
	/*function delete_producto($id){
		$this->db->where('id_producto', $id);
		$this->db->delete('productos');
	}/*/

}
?>
