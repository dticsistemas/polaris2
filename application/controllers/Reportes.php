<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 *
 * @extends CI_Controller
 */
class Reportes extends CI_Controller {

	/**
	 * __construct function.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() {
		parent::__construct();
		if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] === false)
			redirect('login');

	}
	public function index() {

		echo "Modulo reportes";
	}
	public function vista_output($file_view,$output = null)
	{
		//---Enviando datos de inicio
		$data_aux=getScriptsInit();
		$output = (object) $output;
		$output->mensajes=$data_aux['mensajes'];
		$output->notificaciones=$data_aux['notificaciones'];

		$this->load->view('template/header_admin_view', $output);
		$this->load->view($file_view,(array)$output);
		$this->load->view('template/footer_admin_view', $output);

	}
  public function inventario_global(){
		$data=array();
		$data['title_crud']=" Inventario Global";
		//---obteniendo listado de cantidad de productos total agrupados por id_producto
		$this->load->model('productos_model');
		$data['array_data']=$this->productos_model->obtener_productos_cantidad_total_group_by_id();
		$data['array_head']=array('ID','Nombre','Descripcion','Precio','Cantidad');

		$this->vista_output('reportes/reporte_blank',$data);
	}
	public function ventas(){


			 $this->load->library('grocery_CRUD');
			 $crud = new grocery_CRUD();
			 $crud->unset_add();
			 $crud->unset_clone();
			 $crud->unset_edit();
			 $crud->unset_delete();
			 $crud->unset_read();
			 $crud->set_table('ventas');
			 $crud->set_relation('id_vendedor','personas','{nombre} {apellidos}');
			 $crud->set_relation('id_sucursal','sucursales','nombre');
			 $crud->set_relation('id_cliente','clientes','nombres');
			 $crud->set_relation('id_usuario','usuarios','username');

			 $crud->display_as('id_vendedor','Vendedor');
			 $crud->display_as('id_sucursal','Sucursal');
			 $crud->display_as('id_cliente','Cliente');
			 $crud->display_as('id_usuario','Usuario');
			 $crud->order_by('fecha','des');

			 $data = $crud->render();
			 //$data = json_decode(json_encode($data), True);
			 $this->vista_output('crud/plantilla_crud',$data);

	 }
	 public function ventas_global(){

	  $data=array();
		$this->load->model('reporte_model');
		$this->load->model('sucursales_model');
	//	$this->load->model('caterin_model');
		if($this->input->post('btn_fecha_ranged')=='ok'){

			$fecha_ranged=$this->input->post('reservation');
			$id_sucursal =$this->input->post('select_sucursal');
			$arr_aux=explode('-',$fecha_ranged);
			$s1=trim($arr_aux[0]);
			$s2=trim($arr_aux[1]);
			$arr1=explode('/', $s1);
			$arr2=explode('/', $s2);
			//---cambiando el formato
			$fecha_inicio=$arr1[2].'-'.$arr1[1].'-'.$arr1[0];
			$fecha_fin   =$arr2[2].'-'.$arr2[1].'-'.$arr2[0];
			$fecha=$fecha_inicio;
			$nro_year = date("Y",strtotime($fecha));
			$nro_month  = date('m',strtotime($fecha));
			//----
		    $datetime1 = new DateTime($fecha_inicio);
		    $datetime2 = new DateTime($fecha_fin);
			$interval = $datetime1->diff($datetime2);
			$dias= $interval->days;


			$ventas_global=array();
			$reporte_ventas_global=array();
			$monto_total=0;
			//------obteniendo ventas de fecha  ranged
			$ventas_global=$this->reporte_model->obtener_ventas_global_fecha_ranged($fecha_inicio,$fecha_fin,$id_sucursal);
			if(count($ventas_global)>0){
				//----obteniendo detalle de esas ventas----
				//-----necesarios
				$this->load->model('clientes_model');
				$this->load->model('user_model');
				$this->load->model('personas_model');
				$this->load->model('ventas_model');
				$this->load->model('productos_model');
				$this->load->model('configuracion_model');


				foreach ($ventas_global as $ventas) {
					$data = array(
						'id'          => $ventas['id'],
						'fecha'       => $ventas['fecha'],
						'vendedor' => $this->personas_model->get_full_name($ventas['id_vendedor']),
						'sucursal' => $this->sucursales_model->get_namesucursal_from_id($ventas['id_sucursal']),
						'usuario'  => $this->user_model->get_username_from_id($ventas['id_usuario']),
						'cliente'  => $this->clientes_model->get_namecliente_from_id($ventas['id_cliente']),
						'nota'        => $ventas['nota'],
						'total'       => $ventas['total'],
						'estado'      => $ventas['estado'],
						'transferida' => $ventas['transferida'],
						'tipo'        => $this->configuracion_model->get_name_tipo_venta($ventas['tipo'])
				);
				//----obteniendo detalle producto y otros---
				$detalle=array();
				$arr_detalle_venta=$this->ventas_model->obtener_detalle_venta_productos_name($ventas['id']);
				//print_r($arr_detalle_venta);
				//echo "<p>";
				foreach ($arr_detalle_venta as $venta_producto) {
					$data_detalle = array(
						'orden'   =>$venta_producto['orden'],
						'cantidad'   =>$venta_producto['cantidad'],
						'producto'   =>$venta_producto['nombre'],
						'precio'   =>$venta_producto['precio']
					);
					$detalle[]=$data_detalle;
				}

				//----adicionando los detalles a la venta
				$data['detalle_venta']=$detalle;
				$monto_total+=$ventas['total'];
				//---añadiendo el resultado
				$reporte_ventas_global[]=$data;
				}
			}
			$data['ventas_global']=$reporte_ventas_global;
			$data['costo_total']=$monto_total;


		}else{

			$fecha=date('Y-m-d');
			$nro_year = date("Y",strtotime($fecha));
			$nro_month  = date('m',strtotime($fecha));
			$fecha_inicio = $fecha;//$nro_year.'-'.$nro_month.'-01';
			//$dias  = date('t',strtotime( $fecha ));
			//$fecha_fin = $nro_year.'-'.$nro_month.'-'.$dias;
			//echo "mostarndo fecha=".$fecha_inicio."<br>";
			$fecha_aux=strtotime ('+1 day',strtotime($fecha));
			$fecha_fin=date("Y-m-d",$fecha_aux);
			//echo "mostarndo fecha fin=".$fecha_fin."<br>";

		}



		$sucursales=$this->sucursales_model->listSucursales();
		array_unshift($sucursales, "GLOBAL");
		//var_dump($sucursales);
		$data['fecha_inicio']=date('d/m/Y',strtotime($fecha_inicio));
		$data['fecha_fin']=date('d/m/Y',strtotime($fecha_fin));
		$data['combox_sucursales']=$sucursales;

		$data['daterangepicker']=true;
		$data['title']="<b>REPORTE GLOBAL<br> VENTAS</b>";

 	 $this->vista_output('reportes/reporte_ventas_global',$data);

 	 }
	 public function pedidos_global(){ //--incompleto


 			 $this->load->library('grocery_CRUD');
 			 $crud = new grocery_CRUD();
 			 $crud->unset_add();
 			 $crud->unset_clone();
 			 $crud->unset_edit();
 			 $crud->unset_delete();
 			 $crud->unset_read();
 			 $crud->set_table('pedidos');
 			 $crud->set_relation('id_vendedor','personas','{nombre} {apellidos}');
 			 $crud->set_relation('id_sucursal','sucursales','nombre');
 			 $crud->set_relation('id_cliente','clientes','nombres');
 			 $crud->set_relation('id_usuario','usuarios','username');

 			 $crud->display_as('id_vendedor','Vendedor');
 			 $crud->display_as('id_sucursal','Sucursal');
 			 $crud->display_as('id_cliente','Cliente');
 			 $crud->display_as('id_usuario','Usuario');
 		//	 $crud->order_by('fecha','des');

 			 $data = $crud->render();
 			 //$data = json_decode(json_encode($data), True);
 			 $this->vista_output('crud/plantilla_crud',$data);

 	 }
	public function notificaciones(){
		//--report_notificaciones_activas
		$data=array();
		$this->load->model('reporte_model');
		$notificaciones=$this->reporte_model->get_notificaciones_vigentes() ;
		$arr_error=array();
		$arr_success=array();
		$arr_info=array();
		$arr_warning=array();
		foreach ($notificaciones as $nota) {
        $mensaje=$nota['mensaje'];
        $tipo   =$nota['tipo'];
        $id     =$nota['id'];
        $estilo='fa fa-users text-aqua';
        switch ($tipo) {
          case 'Informativo':
              $arr_info[]=$mensaje;
            break;
          case 'Advertencia':
               $arr_warning[]=$mensaje;
            break;
          case 'Mensaje':
               $arr_success[]=$mensaje;
            break;
          case 'Critico':
               $arr_error[]=$mensaje;
            break;
        }

		}
		$data['arr_error']=$arr_error;
		$data['arr_success']=$arr_success;
		$data['arr_info']=$arr_info;
		$data['arr_warning']=$arr_warning;

		$this->vista_output('reportes/reporte_blank',(object)$data);

	}
	public function catalogo_inventario_excel(){

		$data=array();
		$this->load->model('sucursales_model');
		$this->load->model('productos_model');
		$this->load->model('imagenes_model');
		$this->load->model('inventarios_model');
		//------EXPORTANDO A EXCEL
		$this->load->library('excel');
		//$this->excel=PHPExcel_IOFactory::load('plantilla.xlsx');

		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$this->excel->setActiveSheetIndex(0)
					->setTitle('INICIO')
    			->setCellValue('A1', 'LISTADO DE INVENTARIO DE PRODUCTOS');
    $this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

    $this->excel->getActiveSheet()->setCellValue('A2', 'CODIGO: ');
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);


    $this->excel->getActiveSheet()->setCellValue('B2', 'IMAGEN: ');
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setBold(true);
	  $this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		$this->excel->getActiveSheet()->setCellValue('C2', 'NOMBRE: ');
		$this->excel->getActiveSheet()->getStyle('C2')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('C2')->getFont()->setBold(true);
	  //$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setWidth(35);
		$nueva_hoja = $this->excel->getActiveSheet();
		//               sucursales
		$sucursales=$this->sucursales_model->listSucursales();
		$letra='D';
		foreach ($sucursales as $key => $value) {
		  $nueva_hoja->setCellValue($letra.'2',substr($value,0,strpos($value,',')));
			$nueva_hoja->getStyle($letra.'2')->getFont()->setSize(14);
			$nueva_hoja->getStyle($letra.'2')->getFont()->setBold(true);
		  $nueva_hoja->getColumnDimension($letra)->setAutoSize(true);
			$letra++;
		}

		//////////////////////////////////////////////////////
		//// LOGO Encabezado y pie de pagina HOJA DE INICIO
		/////////////////////////////////////////////////////
		$img ='assets/img/logo_icon.png';
		$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setPath($img);
		$nueva_hoja->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_RIGHT);

		$nueva_hoja->getHeaderFooter()->setOddHeader(EMPRESA.PHP_EOL.TITLE.'3&R&G&');
		$nueva_hoja->getPageSetup() ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT); $nueva_hoja->getPageSetup() ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		//--Margenes de Pagina
		$nueva_hoja->getPageMargins()->setTop(1); $nueva_hoja->getPageMargins()->setRight(0.75); $nueva_hoja->getPageMargins()->setLeft(0.75); $nueva_hoja->getPageMargins()->setBottom(1);

		$nueva_hoja->getPageSetup()->setFitToPage(true);
		$nueva_hoja->getPageSetup()->setFitToWidth(1);
		$nueva_hoja->getPageSetup()->setFitToHeight(0);
		/////////////////////////////////////////////////////////
		//		DataTable
		//////////////////////////////////////////////////////////
		$arr_productos=$this->inventarios_model-> get_productos_inventarios();
		$fila=3;
		$total=0;
		foreach ($arr_productos as $p) {
			$img_src=$this->imagenes_model->get_imagen_producto($p['id']);
			$codigo=$p['codigo'];
			$imagen=$img_src['imagen'];
			$nombre=$p['nombre'];
			$total=0;
			//$nueva_hoja->getRowDimension($fila)->setRowHeight(-1);
			$nueva_hoja->getRowDimension($fila)->setRowHeight(30);
			$nueva_hoja->setCellValue('A'.$fila,$codigo);
			$nueva_hoja->setCellValue('C'.$fila,$nombre);
			//---imagenes
			$img_producto ='assets/img/catalogo/thumbs/'.$imagen;
			$objDrawing = new PHPExcel_Worksheet_Drawing();
	    $objDrawing->setName('imagen producto');
	    $objDrawing->setDescription('imagen del producto');
	    $objDrawing->setPath($img_producto);
	    $objDrawing->setHeight(30);
			//$objDrawing->setWidth(50);
			$objDrawing->setResizeProportional(true);
	    $objDrawing->setCoordinates('B'.$fila);
	   // $objDrawing->setOffsetX(100);
	    $objDrawing->setWorksheet($nueva_hoja);
			///end imagen
				$letra='D';

		  foreach ($sucursales as $key => $value) {
				$cant=$this->inventarios_model->get_cantidad_productos($key,$p['id']);
				$total+=$cant;
			  $nueva_hoja->setCellValue($letra.$fila,$cant);
			  $letra++;
			}
				$fila++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="myfile.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, "Excel2007");
		$objWriter->save('php://output');


	}

	public function print_catalogo_pdf(){

    // Se carga el modelo
    $this->load->model('productos_model');
    $this->load->model('imagenes_model');
    // Se carga la libreria fpdf
    $this->load->library('pdf');

    // Se obtienen los alumnos de la base de datos
    $productos = $this->productos_model->obtener_productos_total();

    // Creacion del PDF

    /*
     * Se crea un objeto de la clase Pdf, recuerda que la clase Pdf
     * heredó todos las variables y métodos de fpdf
     */
    $this->pdf = new Pdf();
    // Agregamos una página
    $this->pdf->AddPage();
    // Define el alias para el número de página que se imprimirá en el pie
    $this->pdf->AliasNbPages();

    /* Se define el titulo, márgenes izquierdo, derecho y
     * el color de relleno predeterminado
     */
    $this->pdf->SetTitle(TITLE);
    $this->pdf->SetLeftMargin(15);
    $this->pdf->SetRightMargin(15);
    $this->pdf->SetFillColor(200,200,200);

    // Se define el formato de fuente: Arial, negritas, tamaño 9
    $this->pdf->SetFont('Arial', 'B', 9);
    /*
     * TITULOS DE COLUMNAS
     *
     * $this->pdf->Cell(Ancho, Alto,texto,borde,posición,alineación,relleno);
     */

    $this->pdf->Cell(15,7,'ID'        ,'TBL',0,'C','1');
    $this->pdf->Cell(45,7,'PRODUCTO'  ,'TB',0,'L','1');
   // $this->pdf->Cell(25,7,'TITULO'  ,'TB',0,'L','1');
    //$this->pdf->Cell(30,7,'DESCRIPCION','TB',0,'L','1');
    $this->pdf->Cell(40,7,'CODIGO'     ,'TB',0,'C','1');
    $this->pdf->Cell(40,7,'PRECIO'     ,'TB',0,'L','1');
    $this->pdf->Cell(40,7,'IMAGEN'     ,'TBR',0,'C','1');
    $this->pdf->Ln(7);
    // La variable $x se utiliza para mostrar un número consecutivo
    $x = 1;
    foreach ($productos as $producto) {
      // se imprime el numero actual y despues se incrementa el valor de $x en uno
      $this->pdf->Cell(15,25,$producto->id,'BL',0,'C',0);
      // Se imprimen los datos de cada alumno
     // $this->pdf->Cell(45,5,$producto->id,'B',0,'L',0);
      $this->pdf->Cell(45,25,$producto->nombre,'B',0,'L',0);
      //$this->pdf->Cell(25,5,$producto->titulo,'B',0,'L',0);
      //$this->pdf->Cell(40,5,$producto->descripcion,'B',0,'C',0);
      $this->pdf->Cell(40,25,$producto->codigo,'B',0,'L',0);
      $this->pdf->Cell(40,25,$producto->precio_base,'BR',0,'L',0);
//$pdf->Cell(11,11, $pdf->Image('images/prueba.jpg', $pdf->GetX(), $pdf->GetY(),11),1);
      $imagen=$this->imagenes_model->get_imagen_producto($producto->id);
      $this->pdf->Cell(40,25,$this->pdf->Image('assets/img/catalogo/small/'.$imagen['imagen'], $this->pdf->GetX(), $this->pdf->GetY(),0,25),'BR',0,'L',0);
      //Se agrega un salto de linea
      $this->pdf->Ln(25);
    }
    /*
     * Se manda el pdf al navegador
     *
     * $this->pdf->Output(nombredelarchivo, destino);
     *
     * I = Muestra el pdf en el navegador
     * D = Envia el pdf para descarga
     *
     */
    $this->pdf->Output("Catalogo Productos.pdf", 'I');

	}

	function consignacion_cliente(){
		$data=array();
		//echo " validando id de cliente";
		$this->load->model('clientes_model');
		$this->load->model('sucursales_model');
		$this->load->model('consignacion_model');
		$this->load->model('productos_model');
		$this->load->model('imagenes_model');
		$id_cliente=$this->input->post('id_cliente');
		$nombre_cliente=$this->clientes_model->get_namecliente_from_id($id_cliente);
		//---verificando cuenta de cliente y consignaciones pendientes
		$old_pedidos=$this->consignacion_model->get_consignacion_pendientes_cliente($id_cliente);
		$pedidos=array();
		foreach ($old_pedidos as $pedido) {
			$id_producto=$pedido['id_producto'];
			$p=$this->productos_model->get_producto_by_id($id_producto);
			$pedido['nombre_producto']=$p['nombre'];
			$pedido['codigo']=$p['codigo'];
			$sucursal=explode( ',',$this->sucursales_model->get_namesucursal_from_id($pedido['id_sucursal']));
			$pedido['sucursal']=$sucursal[0];
			$imagen=$this->imagenes_model->get_imagen_producto($id_producto);
			$pedido['img_producto']=$imagen['imagen'];
			$pedidos[]=$pedido;
		}
		//------EXPORTANDO A EXCEL
		$this->load->library('excel');
		//$this->excel=PHPExcel_IOFactory::load('plantilla.xlsx');

		$this->excel->getActiveSheet()->getPageSetup()->setFitToPage(true);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToWidth(1);
		$this->excel->getActiveSheet()->getPageSetup()->setFitToHeight(0);
		$this->excel->setActiveSheetIndex(0)
					->setTitle('INICIO')
					->setCellValue('A1', 'LISTADO DE CONSIGNACION DE PRODUCTOS');
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->mergeCells('A1:F1');
		$this->excel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);

		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->getStyle('A2')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->setCellValue('A2', 'Cliente: ');

		$this->excel->getActiveSheet()->mergeCells('B2:F2');

				$this->excel->getActiveSheet()->getStyle('B2')->getFont()->setSize(16);
		$this->excel->getActiveSheet()->setCellValue('B2', $nombre_cliente);

		$this->excel->getActiveSheet()->setCellValue('A4', 'Nombre: ');
		$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('A4')->getFont()->setBold(true);


		$this->excel->getActiveSheet()->setCellValue('B4', 'Imagen: ');
		$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('B4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

		$this->excel->getActiveSheet()->setCellValue('C4', 'P. Unitario: ');
		$this->excel->getActiveSheet()->getStyle('C4')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('C4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);

		$this->excel->getActiveSheet()->setCellValue('D4', 'Cantidad: ');
		$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('D4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);

		$this->excel->getActiveSheet()->setCellValue('E4', 'Descripcion: ');
		$this->excel->getActiveSheet()->getStyle('E4')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('E4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);

		$this->excel->getActiveSheet()->setCellValue('F4', 'Precio Venta: ');
		$this->excel->getActiveSheet()->getStyle('F4')->getFont()->setSize(14);
		$this->excel->getActiveSheet()->getStyle('F4')->getFont()->setBold(true);
		$this->excel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		$nueva_hoja = $this->excel->getActiveSheet();


		//////////////////////////////////////////////////////
		//// LOGO Encabezado y pie de pagina HOJA DE INICIO
		/////////////////////////////////////////////////////
		$img ='assets/img/logo_icon.png';
		$objDrawing = new PHPExcel_Worksheet_HeaderFooterDrawing();
		$objDrawing->setName('PHPExcel logo');
		$objDrawing->setPath($img);
		$nueva_hoja->getHeaderFooter()->addImage($objDrawing, PHPExcel_Worksheet_HeaderFooter::IMAGE_HEADER_RIGHT);

		$nueva_hoja->getHeaderFooter()->setOddHeader(EMPRESA.PHP_EOL.TITLE.'3&R&G&');
		$nueva_hoja->getPageSetup() ->setOrientation(PHPExcel_Worksheet_PageSetup::ORIENTATION_DEFAULT); $nueva_hoja->getPageSetup() ->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_LEGAL);
		//--Margenes de Pagina
		$nueva_hoja->getPageMargins()->setTop(1); $nueva_hoja->getPageMargins()->setRight(0.75); $nueva_hoja->getPageMargins()->setLeft(0.75); $nueva_hoja->getPageMargins()->setBottom(1);

		$nueva_hoja->getPageSetup()->setFitToPage(true);
		$nueva_hoja->getPageSetup()->setFitToWidth(1);
		$nueva_hoja->getPageSetup()->setFitToHeight(0);
		/////////////////////////////////////////////////////////
		//		DataTable
		//////////////////////////////////////////////////////////
		//$arr_productos=$this->inventarios_model-> get_productos_inventarios();
		$fila=5;
		$total=0;
		foreach ($pedidos as $p) {
			$codigo=$p['codigo'];
			$imagen=$p['img_producto'];
			$nombre=$p['nombre_producto'];
			$total=0;
			//$nueva_hoja->getRowDimension($fila)->setRowHeight(-1);
			$nueva_hoja->getRowDimension($fila)->setRowHeight(30);
			$nueva_hoja->setCellValue('A'.$fila,$nombre);
			$nueva_hoja->setCellValue('C'.$fila,$p['precio_unitario']);
			$nueva_hoja->setCellValue('D'.$fila,$p['cantidad']);
			$nueva_hoja->setCellValue('E'.$fila,$p['descripcion']);
			$nueva_hoja->setCellValue('F'.$fila,$p['precio_venta']);
			//---imagenes
			$img_producto ='assets/img/catalogo/thumbs/'.$imagen;
			$objDrawing = new PHPExcel_Worksheet_Drawing();
			$objDrawing->setName('imagen producto');
			$objDrawing->setDescription('imagen del producto');
			$objDrawing->setPath($img_producto);
			$objDrawing->setHeight(30);
			//$objDrawing->setWidth(50);
			$objDrawing->setResizeProportional(true);
			$objDrawing->setCoordinates('B'.$fila);
		 // $objDrawing->setOffsetX(100);
			$objDrawing->setWorksheet($nueva_hoja);
			///end imagen
				$letra='D';

			/*foreach ($sucursales as $key => $value) {
				$cant=$this->inventarios_model->get_cantidad_productos($key,$p['id']);
				$total+=$cant;
				$nueva_hoja->setCellValue($letra.$fila,$cant);
				$letra++;
			}*/
				$fila++;
		}

		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment;filename="myfile.xlsx"');
		header('Cache-Control: max-age=0');
		$objWriter = PHPExcel_IOFactory::createWriter($this->excel, "Excel2007");
		$objWriter->save('php://output');

	}

}
