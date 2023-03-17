<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
    // Incluimos el archivo fpdf
    require_once APPPATH."/third_party/fpdf/fpdf.php";

    //Extendemos la clase Pdf de la clase fpdf para que herede todas sus variables y funciones
    class Pdf extends FPDF {
        public $sw_footer=true;
        public $sw_header=true;
        public function __construct() {
            parent::__construct();
        }
        // El encabezado del PDF
        public function Header(){
          if($this->sw_header){
            $this->Image('assets/img/logo.png',10,8,22);
            $this->SetFont('Arial','B',13);
            $this->Cell(30);
            $this->Cell(120,10,EMPRESA. ': '.TITLE,0,0,'C');
            $this->Ln('5');
            $this->SetFont('Arial','B',8);
            $this->Cell(30);
            $this->Cell(120,10,SUBTITLE,0,0,'C');
            $this->Ln(20);
          }
       }
      public function quitarFooter(){
         $this->sw_footer=false;
      }
      public function quitarHeader(){
        $this->sw_header=false;
     }
       // El pie del pdf
       public function Footer(){
           if($this->sw_footer){
           $this->SetY(-15);
           $this->SetFont('Arial','I',8);
           $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
           }
      }
      // Cargar los datos
function LoadData($file)
{
    // Leer las líneas del fichero
    $lines = file($file);
    $data = array();
    foreach($lines as $line)
        $data[] = explode(';',trim($line));
    return $data;
}

// Tabla simple
function BasicTable($header, $data)
{
    // Cabecera
    foreach($header as $col)
        $this->Cell(40,7,$col,1);
    $this->Ln();
    // Datos
    foreach($data as $row)
    {
        foreach($row as $col)
            $this->Cell(40,6,$col,1);
        $this->Ln();
    }
}

// Una tabla más completa
function ImprovedTable($header, $data)
{
    // Anchuras de las columnas
    $w = array(40, 35, 45, 40);
    // Cabeceras
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C');
    $this->Ln();
    // Datos
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[$header[0]],'LR');
        $this->Cell($w[1],6,$row[$header[1]],'LR');
        $this->MultiCell($w[2],6,$row[$header[2]]);
      //  $this->Cell($w[3],6,$row[$header[3]],'LR',0,'R');
        $this->Ln();
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}

// Tabla coloreada
function FancyTable($header, $data)
{
    // Colores, ancho de línea y fuente en negrita
    $this->SetFillColor(255,0,0);
    $this->SetTextColor(255);
    $this->SetDrawColor(128,0,0);
    $this->SetLineWidth(.3);
    $this->SetFont('','B');
    // Cabecera
    $w = array(40, 35, 45, 40);
    for($i=0;$i<count($header);$i++)
        $this->Cell($w[$i],7,$header[$i],1,0,'C',true);
    $this->Ln();
    // Restauración de colores y fuentes
    $this->SetFillColor(224,235,255);
    $this->SetTextColor(0);
    $this->SetFont('');
    // Datos
    $fill = false;
    foreach($data as $row)
    {
        $this->Cell($w[0],6,$row[0],'LR',0,'L',$fill);
        $this->Cell($w[1],6,$row[1],'LR',0,'L',$fill);
        $this->Cell($w[2],6,number_format($row[2]),'LR',0,'R',$fill);
        $this->Cell($w[3],6,number_format($row[3]),'LR',0,'R',$fill);
        $this->Ln();
        $fill = !$fill;
    }
    // Línea de cierre
    $this->Cell(array_sum($w),0,'','T');
}


public function MultiAlignCell($w,$h,$text,$border=0,$ln=0,$align='L',$fill=false)
{
    // Store reset values for (x,y) positions
    $x = $this->GetX() + $w;
    $y = $this->GetY();

    // Make a call to FPDF's MultiCell
    $this->MultiCell($w,$h,$text,$border,$align,$fill);

    // Reset the line position to the right, like in Cell
    if( $ln==0 )
    {
        $this->SetXY($x,$y);
    }
}


    }
?>
