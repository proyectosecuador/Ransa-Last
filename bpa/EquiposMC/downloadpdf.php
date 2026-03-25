<?php

require_once "../../controladores/novedadequipo.controlador.php";
require_once "../../modelos/novedadequipo.modelo.php";

require_once "../../controladores/equipos.controlador.php";
require_once "../../modelos/equipos.modelo.php";


require_once "../../extensiones/TCPDF/tcpdf.php";



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

        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        // restore full opacity

        $this->SetAlpha(1);

        // restore auto-page-break status

        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // set the starting point for the page content

        $this->setPageMark();

        // Logo

        $image_file = '../../vistas/img/plantilla/logotipo.png';

        $this->Image($image_file, 10, 5, 35, '', 'PNG', 'https://equipos.ranecu.com', 'M', false, 300, '', false, false, 0, false, false, false);

        // Set font

        $this->SetFont('helvetica', 'B', 15);

        // Title

        $this->Cell(0, 15, 'REPORTE DE LA NOVEDAD', 0, false, 'C', 0, '', 0, false, 'M', 'M');

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

	// Creación del objeto de la clase heredada

	// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// create new PDF document

// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Douglas Borbor');

$pdf->SetTitle('Reporte de la Novedad');

$pdf->SetSubject('Reporte Completo de la Novedad');

// $pdf->SetKeywords('TCPDF, PDF, example, test, guide');



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

if (isset($_POST["idnovedad"])) {
	// add a page
	$pdf->AddPage();
	$rpta = ControladorNovedades::ctrConsultarNovedadesEquipos($_POST["idnovedad"],"idnovequipos");

	// set font

	

	$equipomc = ControladorEquipos::ctrConsultarEquipos($rpta["idequipo"],"idequipomc");
	/*=========================================================
	=            COLOCAMOS EL TITULO DEL EQUIPO MC            =
	=========================================================*/
	$pdf->SetFont('helveticaB', '', 18);
	$html = '<h1>EQUIPO '.$equipomc[0]["codigo"].'</h1>';
	// $pdf->writeHTML($html, true, false, true, false, 'C');
	$pdf->writeHTMLCell(0, '', '', 15, $html, 'B', 1, 0, true, 'C', false);
	$pdf->Ln(2);
	$pdf->SetFont('helveticaB', '', 10);
	$html = '<h2>NOVEDAD REPORTADA:</h2>';
	$pdf->writeHTML($html, true, false, true, false, 'L');
	$pdf->Ln(2);
	$pdf->SetFont('helvetica', '', 8);
	$html = $rpta["descripcion_novedad"];
	$pdf->writeHTML($html, true, false, true, false, 'L');
	/*========================================================================================
	=            INSERTAR IMAGEN SI SE HA ADJUNTADO ALGUNA AL REPORTAR LA NOVEDAD            =
	========================================================================================*/
	if ($rpta["imagen"] != null) {
		$pdf->Ln(2);
		$html = '<div align="center"><img width="300" src="../../'.$rpta["imagen"].'"></div>';
		$pdf->writeHTML($html, true, false, true, false, 'L');
		
	}
	$pdf->Ln(2);
	$pdf->SetFont('helvetica', '', 8);
	$html = '
	<table width="100%" border="1" cellspacing="0" cellpadding="3">
	    <tr >
	        <td ><strong> Fecha Reportada: </strong> </td>
	        <td >'.date('d-m-Y',strtotime($rpta["fecha"])) .'</td>
	        <td ><strong> Hora: </strong></td>
	        <td >'.date('H:i:s',strtotime($rpta["fecha"])).'</td>
	    </tr>
		<tr>
	        <td ><strong> Modalidad: </strong> </td>
	        <td >'.$rpta["modo"].'</td>
	        <td ><strong> Fecha Propuesta: </strong></td>';
	        if ($rpta["fecha_propuesta"] != null || $rpta["fecha_propuesta"] != "") {
	        	$fecha_pro = date('d-m-Y',strtotime($rpta["fecha_propuesta"]));
	        }else{
	        	$fecha_pro = "";
	        }
	        $html .= '<td >'.$fecha_pro.'</td>
	    </tr>
	</table>';
	$pdf->writeHTML($html, true, false, true, false, 'L');
	/*========================================
	=            NOVEDAD RESUELTA            =
	========================================*/
	$pdf->SetFont('helveticaB', '', 10);
	$html = '<h2>NOVEDAD RESUELTA:</h2>';
	$pdf->writeHTML($html, true, false, true, false, 'L');
	$pdf->Ln(2);
	$pdf->SetFont('helvetica', '', 8);
	$html = $rpta["observacionesot"];
	$pdf->writeHTML($html, true, false, true, false, 'L');
	$pdf->Ln(4);
	$pdf->SetFont('helveticaB', '', 10);
	$html = '<h1 style="background-color: rgb(255, 0, 0); color: rgb(255, 255, 255);">OT:'.$rpta["otnum"].'</h1>';
	$pdf->writeHTML($html, true, false, true, false, 'C');

	/*=======================================================
	=            EN CASO DE APLICAR PARALIZACIÓN            =
	=======================================================*/
	$pdf->SetFont('helvetica', '', 8);
	if ($rpta["paralizacion"] == 1) {
		/*=============================================================
		=            CALCULAMOS LOS DIAS DE INOPERATIVIDAD            =
		=============================================================*/
			$fechainipara = new DateTime($rpta["fecha_iniparalizacion"]);

			$fechaactualfinal = new DateTime($rpta["fecha_concluida"]);

			$diasparo = $fechainipara->diff($fechaactualfinal);

			$presentdiaspara = $diasparo->days.' Día(s)';	
		
		
		$html = '
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
		    <tr >
		        <td ><strong> Paralización: </strong> </td>
		        <td >SI APLICA</td>
		        <td ><strong> Fecha / Hora Inicio: </strong></td>
		        <td >'.$rpta["fecha_iniparalizacion"].'</td>
		        <td ><strong> Fecha / Hora Final: </strong></td>
		        <td >'.$rpta["fecha_concluida"].'</td>
		    </tr>
			<tr>
		        <td ><strong> Ubicación: </strong> </td>
		        <td colspan="3" >'.$rpta["ubicacion"].'</td>
		        <td ><strong> Horometro: </strong></td>
		        <td >'.$rpta["horometro"].'</td>
		    </tr>
		    <tr>
		    	<td ><strong>INOPERATIVIDAD: </strong></td>
		    	<td colspan="5">'.$presentdiaspara.'</td>
		    </tr>
		</table>';
		$pdf->writeHTML($html, true, false, true, false, 'L');		
		
	}

	
	
	



	//Close and output PDF document

	$pdf->Output('novedad.pdf', 'I');	
}else{

	echo "error";
}
