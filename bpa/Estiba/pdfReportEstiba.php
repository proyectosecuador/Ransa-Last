<?php
require_once "../../controladores/movi_R_D.controlador.php";
require_once "../../modelos/movi_R_D.modelo.php";

require_once "../../extensiones/TCPDF/tcpdf.php";

require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";

require_once "../../controladores/actividadE.controlador.php";
require_once "../../modelos/actividadE.modelo.php";

require_once "../../controladores/t_transporte.controlador.php";
require_once "../../modelos/t_transporte.modelo.php";

// require_once '../extensiones/PhpSpreadSheet/autoload.php';

// require_once "../extensiones/SVGGraph/autoloader.php"; // liberia para generar el grafico


class MYPDF extends TCPDF {



    //Page header

    public function Header() {

        // get the current page break margin

        $this->SetAlpha(0.4);

        $bMargin = $this->getBreakMargin();

        // get current auto-page-break mode

        $auto_page_break = $this->AutoPageBreak;

        // disable auto-page-break

        $this->SetAutoPageBreak(false, 0);

        // set bacground image

        $img_file = dirname(__FILE__).'/../../vistas/img/plantilla/FONDO-SOLIDO-1.jpg';

        $this->Image($img_file, 0, 0, 150, 600, '', '', '', false, 200, '', false, false, 0);

        // restore full opacity

        $this->SetAlpha(1);

        // restore auto-page-break status

        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // set the starting point for the page content

        $this->setPageMark();

        // Logo

        $image_file = '../../vistas/img/plantilla/logotipo.png';

        $this->Image($image_file, 10, 5, 35, '', 'PNG', 'https://ransa.ranecu.com', 'M', false, 300, '', false, false, 0, false, false, false);

        // Set font

        $this->SetFont('helvetica', 'B', 15);

        // Title

        $this->Cell(0, 0,'Orden de Trabajo Estibas' , 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 9);
		
		// $this->writeHTMLCell(31, 0, 175, 4, "Código : FCME-0032" , '', 0, 0, true, '', true);
		// $this->writeHTMLCell(20, 0, 180, 8, "Revisión : 01" , '', 0, 0, true, '', true);        

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

if (isset($_POST["idmov"])) {

	 $rpta = ControladorMovRD::ctrConsultarMovRD($_POST["idmov"],"idmov_recep_desp");

	// Creación del objeto de la clase heredada

	// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// create new PDF document

// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Douglas Borbor');

$pdf->SetTitle('Orden de Trabajo '.date('d-m-Y',strtotime($rpta["fecha_programada"])));

$pdf->SetSubject('Ordenes de Trabajo');

$pdf->SetKeywords('TCPDF, PDF, example, test, guide');



// set default header data

// $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 006', PDF_HEADER_STRING);



// // set header and footer fonts

// $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));

// $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));



// set default monospaced font

$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



// set margins

$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



// set auto page breaks

$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



// set image scale factor

$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



// set some language-dependent strings (optional)

if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {

    require_once(dirname(__FILE__).'/lang/eng.php');

    $pdf->setLanguageArray($l);

}



// ---------------------------------------------------------



// set font

$pdf->SetFont('helvetica', '', 6);

/*==============================================
=            CONSULTAMOS EL CLIENTE            =
==============================================*/
$rptaCliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta["idcliente"]);
/*================================================
=            CONSULTAMOS LA ACTIVIDAD            =
================================================*/
$rptaActividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba",$rpta["idactividad"]);
/*===================================================
=            CONSULTA TIPO DE TRANSPORTE            =
===================================================*/
$rptaTTranspporte = ControladorTTransporte::ctrConsultarTTransporte("idtipo_transporte",$rpta["idtipo_transporte"]);






// add a page

$pdf->AddPage('P', 'A5');

$html = '
<style>

.cabecera{

	background-color: #dad414;

}

</style>
<table cellpadding="2" cellspacing="0" border="0.3" align="center">
	<tr>
		<td class="cabecera"><strong> Fecha: </strong></td>
		<td colspan="7">'.date("d-m-Y",strtotime($rpta["fecha_programada"])) .'</td>
	</tr>
	<tr>
		<td class="cabecera"><strong> Cliente: </strong></td>
		<td colspan="7">'.$rptaCliente["razonsocial"].'</td>
	</tr>
	<tr>
		<td class="cabecera"><strong>Servicio: </strong></td>
		<td colspan="7">'.$rptaActividad["descripcion"].'</td>
	</tr>
	<tr>
		<td class="cabecera" colspan="2"><strong>Tipo de Transporte: </strong></td>
		<td colspan="6">'.$rptaTTranspporte["descripcion"].'</td>
	</tr>
	<tr>
		<td class="cabecera"><strong>N° Contenedor: </strong></td>
		<td colspan="3">'.$rpta["ncontenedor"].'</td>
		<td class="cabecera"><strong>Guias: </strong></td>
		<td colspan="3">'.$rpta["nguias"].'</td>
	</tr>
	<tr>
		<td class="cabecera"><strong>Hora Garita: </strong></td>
		<td colspan="2">'.$rpta["h_garita"].'</td>
		<td class="cabecera"><strong>Hora Inicio: </strong></td>
		<td colspan="2">'.$rpta["h_inicio"].'</td>
		<td class="cabecera"><strong>Hora Fin: </strong></td>
		<td>'.$rpta["h_fin"].'</td>
	</tr>
	<tr>
		<td class="cabecera"><strong>Nombre Estibas: </strong></td>
		<td colspan="7">'.$rpta["nombre_estibas"].'</td>
	</tr>
	<tr>
		<td class="cabecera"><strong>Cant. Cod: </strong></td>
		<td>'.$rpta["cant_codigo"].'</td>
		<td class="cabecera"><strong>Cant. Fecha: </strong></td>
		<td>'.$rpta["cant_fecha"].'</td>
		<td class="cabecera"><strong>Cant. Pallet: </strong></td>
		<td>'.$rpta["cant_pallets"].'</td>
		<td class="cabecera"><strong>Cant. Bultos</strong></td>
		<td>'.$rpta["cant_bultos"].'</td>
	</tr>
	<tr>
		<td class="cabecera" colspan="2"><strong>Observaciones: </strong></td>
		<td colspan="6">'.$rpta["observaciones_estibas"].'</td>
	</tr>
	
</table>';

$pdf->writeHTML($html, true, false, true, false, '');








// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('Check List.pdf', 'I');

	

}else{

	echo "error";

}