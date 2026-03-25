<?php
session_start();
require_once "../../controladores/productos.controlador.php";
require_once "../../modelos/productos.modelo.php";

require_once "../../extensiones/TCPDF/tcpdf.php";

require_once '../../extensiones/PhpSpreadSheet/autoload.php';
require_once '../../modelos/rutas.php';

$url = Ruta::ctrRuta();

class MYPDF extends TCPDF {



    //Page header

    public function Header() {

        // get the current page break margin

        // $this->SetAlpha(0.4);

        // $bMargin = $this->getBreakMargin();

        // get current auto-page-break mode

        // $auto_page_break = $this->AutoPageBreak;

        // disable auto-page-break

        // $this->SetAutoPageBreak(false, 0);

        // set bacground image

        // $img_file = dirname(__FILE__).'/../../vistas/img/plantilla/FONDO-SOLIDO-1.jpg';

        // $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        // restore full opacity

        $this->SetAlpha(1);

        // restore auto-page-break status

        // $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // set the starting point for the page content

        $this->setPageMark();

        // Logo

        $image_file = '../../vistas/img/plantilla/logotipo.png';

        $this->Image($image_file, 10, 5, 35, '', 'PNG', 'https://equipos.ranecu.com', 'M', false, 300, '', false, false, 0, false, false, false);

        

        // Set font

        $this->SetFont('helvetica', 'B', 15);

        // Title

        $this->Cell(0, 15, 'LISTADO DE CATÁLOGO', 0, false, 'C', 0, '', 0, false, 'M', 'M');

        $cliente = strpos($_SESSION["cliente"],"NETAFIN");
        if ($cliente === false) {
        }else{
         $image_file_metafin = '../../vistas/img/login/metafin_logo.png';   
         $this->Image($image_file_metafin, 250, 5, 35, '', 'PNG', 'https://equipos.ranecu.com', 'M', false, 300, '', false, false, 0, false, false, false);
        }



        

        

    }



    // Page footer

    public function Footer() {

        // Position at 15 mm from bottom

        $this->SetY(-15);

        // Set font

        $this->SetFont('helvetica', 'I', 8);

        // Page number

        $this->Cell(0, 10, 'Página '.$this->getAliasNumPage().' de '.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');

    }

}

if (isset($_SESSION["idcliente"])) {

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', true);

// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Douglas Borbor');

$pdf->SetTitle('Listado del Catálogo');

$pdf->SetSubject('Listado del Catálogo de los productos en RANSA');

$pdf->SetKeywords('Catalogo, Productos, Mercaderia, pdf, imagen ');



// set default monospaced font

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set margins

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);


// set margins

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

set_time_limit(600000);
ini_set('memory_limit', '-1');

// set image scale factor

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// set some language-dependent strings (optional)

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {

    require_once(dirname(__FILE__).'/lang/eng.php');

    $pdf->setLanguageArray($l);

}



// ---------------------------------------------------------



// set font

$pdf->SetFont('helvetica', '', 8);



// add a page

$pdf->AddPage("L");

$rptaListCat = ControladorProductos::ctrConsultarProductos($_SESSION["idcliente"]);

if ($rptaListCat) {
	$tbl = ' 
	<table align="center" cellspacing="0" cellpadding="5" border="1">
		<tr>
			<th >Código</th>
			<th>Descripción Técnica</th>
			<th>Descripción</th>
			<th>Fotos</th>
		</tr>';
		$imagen ="";
	for ($i=0; $i < count($rptaListCat) ; $i++) {

		$tbl .= '<tr>
			<td>'.$rptaListCat[$i]["codigo"].'</td>
			<td>'.$rptaListCat[$i]["desctecnica"].'</td>
			<td>'.$rptaListCat[$i]["descripcion"].'</td>';

		if (!empty($rptaListCat[$i]["foto_portada"])) {

		  $imagen = '../../'.$rptaListCat[$i]["foto_portada"];
		$tbl .= '<td><img src="'.$imagen.'" border="0" height="90" width="100"/></td>';


		}else{
        $tbl .= '<td></td>';
        }
		$tbl .=  '</tr>';
		


	}
	

	$tbl .= ' </table>
	';

	$pdf->writeHTML($tbl, true, false, false, false, '');


	$pdf->Output('example_048.pdf', 'I');
	
}







}else{
	echo "ERROR";
}

// class DescargaCatalogo{
// 	public $_idcliente;

// 	public function DescargarDataCatalogo(){

// 	}

// }




// if (isset($_POST["dwnidcliente"])) {
// 	$descargaData = new DescargaCatalogo();
// 	$descargaData -> _idcliente = $_POST["dwnidcliente"];
// 	$descargaData -> DescargarDataCatalogo();
// }