<?php

require_once "../controladores/checklist.controlador.php";
require_once "../modelos/checklist.modelo.php";

require_once "../controladores/equipos.controlador.php";
require_once "../modelos/equipos.modelo.php";

require_once "../controladores/ciudad.controlador.php";
require_once "../modelos/ciudad.modelo.php";

require_once "../extensiones/TCPDF/tcpdf.php";

// require_once '../extensiones/PhpSpreadSheet/autoload.php';

// require_once "../extensiones/SVGGraph/autoloader.php"; //LIBERIA PARA GENERAR GRAFICO




// require '../extensiones/PhpSpreadSheet/phpoffice/phpspreadsheet/samples/Header.php';



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

        $img_file = dirname(__FILE__).'/../vistas/img/plantilla/FONDO-SOLIDO-1.jpg';

        $this->Image($img_file, 0, 0, 210, 297, '', '', '', false, 300, '', false, false, 0);

        // restore full opacity

        $this->SetAlpha(1);

        // restore auto-page-break status

        $this->SetAutoPageBreak($auto_page_break, $bMargin);

        // set the starting point for the page content

        $this->setPageMark();

        // Logo

        $image_file = '../vistas/img/plantilla/logotipo.png';

        $this->Image($image_file, 10, 5, 35, '', 'PNG', 'https://equipos.ranecu.com', 'M', false, 300, '', false, false, 0, false, false, false);

        // Set font

        $this->SetFont('helvetica', 'B', 15);

        // Title

        $this->Cell(0, 15, 'CHECK LIST DE EQUIPOS', 0, false, 'C', 0, '', 0, false, 'M', 'M');

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

if (isset($_POST["idchcklstq"])) {
	/*==================================================================
	=            CONSULTAMOS DATOS DEL CHECK LIST REALIZADO            =
	==================================================================*/
	$rpta = ControladorCheckList::ctrConsultarCheckListID($_POST["idchcklstq"],"idchcklstq");


	// Creación del objeto de la clase heredada

	// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// create new PDF document

// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Douglas Borbor');

$pdf->SetTitle('Check_List_Equipos_');

$pdf->SetSubject('Check List de Equipos Montacargas y Traspaletas');

$pdf->SetKeywords('Check List, Equipos, Montacargas, pdf, ');



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

$pdf->SetFont('helvetica', '', 8);



// add a page

$pdf->AddPage();
/*=============================================
=            CONSULTAMOS EL EQUIPO            =
=============================================*/

$rptaEquipoMc = ControladorEquipos::ctrConsultarEquipos($rpta["idequipomc"],"idequipomc");

/*=====================================================
=            USUARIO RESPONSABLE DE EQUIPO            =
=====================================================*/

$rptaasignador = ControladorEquipos::ctrConsultarAsignacionEquipos($rpta["ideasignacion"],"ideasignacion");

/*========================================================
=            CONSULTAMOS LA CIUDAD DEL EQUIPO            =
========================================================*/
$rptaciudad = ControladorCiudad::ctrConsultarCiudad("idciudad",$rptaEquipoMc[0]["idciudad"]);




/*=======================================================================
=            CONSULTAMOS NOVEDADES DEL CHECK LIST REALIZADOS            =
=======================================================================*/

$rptanovedadeschecklis = ControladorCheckList::ctrConsultarObsCheckList($_POST["idchcklstq"],"idchcklstq");

if ($rptanovedadeschecklis == false || $rptanovedadeschecklis == null) {

	$rptanovedadeschecklis = null;

}

// create some HTML content

$tbl = '

<table cellspacing="0" cellpadding="3" border="1">

	<tr>

		<td colspan="3" ><strong>Usuario Responsable: </strong><label>'.$rptaasignador["responsable"].'</label></td>
	</tr>
	<tr>

		<td ><strong>Equipo: </strong><label>'.$rptaEquipoMc[0]["codigo"].'</label></td>
		<td colspan="2" ><strong>Turno: </strong><label>'.$rptaasignador["turno"].'</label></td>
	</tr>
	<tr>

		<td ><strong>Modelo: </strong><label>'.$rptaEquipoMc[0]["modelo"].'</label></td>
		<td ><strong>Cantidad de Novedades: </strong><label>'.$rpta["cantinovedad"].'</label></td>
		<td ><strong>Horometro: </strong><label>'.$rpta["horometro"].'</label></td>
	</tr>
	<tr>

		<td ><strong>Ciudad: </strong><label>'.$rptaciudad["desc_ciudad"].'</label></td>
		<td ><strong>Fecha: </strong><label>'.date('d-m-Y',strtotime($rpta["fecha"])).'</label></td>
		<td ><strong>Hora: </strong><label>'.date('H:i:s',strtotime($rpta["fecha"])).'</label></td>
	</tr>		

</table>

';

$pdf->writeHTMLCell(0, 0, 10, 20, $tbl, 0, 1, 0, true, 'L', false);


/*===========================================
=            DATOS DE CHECK LIST            =
===========================================*/

$equipo = ["COMPROBAR DAÑOS EN CHASIS Y ESTRUCTURA DEL EQUIPO",
			"COMPROBAR SI LA TRANSMISION PRESENTA FUGAS DE ACEITE",
			"COMPROBAR SI LAS RUEDAS PRESENTA DAÑOS O DESGASTE EXCESIVO",
			"COMPROBAR SI EXISTE FUGA DE ACEITE HIDRAULICO",
			"COMPROBAR ESTADO DE MANGUERAS Y CAÑERIAS",
			"REVISAR CILINDROS HIDRAULICOS Y SI EXISTE FUGAS DE ACEITE",
			"COMPROBAR DAÑOS EN TABLERO DE INSTRUMENTOS, SWITCH, PALANCA DE MANDOS"];
$bateria = ["COMPROBAR DAÑOS EN BATERIA, CABLES Y CONECTORES",
			"REVISAR EL NIVEL ADECUADO DE ELECTROLITO (AGUA DE BATERIA)"];
$carrobateria = ["REVISAR ESTADO DE CARRO PORTABATERIAS",
				"REVISAR SEGURO DE CARRO PORTABATERIAS (FUNCIONA CORRECTAMENTE)"];
$cargador = ["REVISION DE ESTRUCTURA",
			"COMPROBAR DAÑOS EN CABLES Y CONECTOR",
			"REVISAR FUNCIONAMIENTO (LUCES ENCIENDE AL CARGAR)"];
$operacional = ["COMPROBAR BUEN ENCENDIDO DEL EQUIPO",
				"PROBAR FUNCIONAMIENTO DE BOCINA",
				"REVISAR FUNCIONAMIENTO DE LUCES Y BALIZA",
				"COMPROBAR EL BUEN FUNCIONAMIENTO DE LA DIRECCION",
				"COMPROBAR BUEN FUNCIONAMIENTO DE MARCHA ADELANTE, ATRÁS",
				"COMPROBAR FUNCIONES HIDRAULICAS OPERATIVAS",
				"COMPROBAR FUNCIONAMIENTO DEL SIST. DE FRENOS (PEDAL Y PARQUEO)",
				"COMPROBAR SI EMITE RUIDOS DURANTE LA MARCHA",
				"COMPROBAR DESLIZAMIENTO DEL CARRO PORTABATERIA Y SI ESTE ENCLAVA"];

$pdf->SetFont('helvetica', '', 6);
/*===================================================

=            SECCION DE ITEMS EQUIPOS            =

===================================================*/

$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td style="font-size:10px;" colspan="3" align="center"><strong>INSPECCIÓN VISUAL DEL EQUIPO</strong></td>

	</tr>

	<tr class="cabecera">

		<td width="300" align="center"><strong>Descripción</strong></td>
		<td width="38" align="center"><strong>Estado</strong></td>
		<td width="310" align="center"><strong>Novedad</strong></td>
	</tr>';

	for ($i=0; $i < count($equipo) ; $i++) {
		$item = $i+1;

	$tbl .=	'<tr>
		    <td><span >'.$equipo[$i].'</span></td>';

		    if ($rptanovedadeschecklis["obseqp".$item] != null) {
		    	$tbl .=	'<td align="center" >REVISAR</td>';
		    	$tbl .=	'<td align="center" >'.$rptanovedadeschecklis["obseqp".$item].'</td>';

		    }else{
		    	$tbl .='<td align="center">OK</td>';
		    	$tbl .='<td></td>';

		    }

		$tbl .=	'</tr>';

	}

    $tbl .='

</table>';

$pdf->writeHTMLCell(0, 0, 10, 46, $tbl, 0, 1, 0, true, 'L', false);

/*==========================================
=            SECCION DE BATERIA            =
==========================================*/
$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td style="font-size:10px;" colspan="3" align="center"><strong>INSPECCIÓN VISUAL DE BATERIA</strong></td>

	</tr>

	<tr class="cabecera">

		<td width="300" align="center"><strong>Descripción</strong></td>
		<td width="38" align="center"><strong>Estado</strong></td>
		<td width="310" align="center"><strong>Novedad</strong></td>
	</tr>';

	for ($i=0; $i < count($bateria) ; $i++) {
		$item = $i+1;

	$tbl .=	'<tr>
		    <td><span >'.$bateria[$i].'</span></td>';

		    if ($rptanovedadeschecklis["obsbtr".$item] != null) {
		    	$tbl .=	'<td align="center" >REVISAR</td>';
		    	$tbl .=	'<td align="center" >'.$rptanovedadeschecklis["obsbtr".$item].'</td>';

		    }else{
		    	$tbl .='<td align="center">OK</td>';
		    	$tbl .='<td></td>';

		    }

		$tbl .=	'</tr>';

	}

    $tbl .='

</table>';

$pdf->writeHTMLCell(0, 0, 10, 86, $tbl, 0, 1, 0, true, 'L', false);

/*================================================
=            SECCION DE CARRO BATERIA            =
================================================*/
$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td style="font-size:10px;" colspan="3" align="center"><strong>INSPECCIÓN VISUAL DE CARRO BATERIA</strong></td>

	</tr>

	<tr class="cabecera">

		<td width="300" align="center"><strong>Descripción</strong></td>
		<td width="38" align="center"><strong>Estado</strong></td>
		<td width="310" align="center"><strong>Novedad</strong></td>
	</tr>';

	for ($i=0; $i < count($carrobateria) ; $i++) {
		$item = $i+1;

	$tbl .=	'<tr>
		    <td><span >'.$carrobateria[$i].'</span></td>';

		    if ($rptanovedadeschecklis["obscbtr".$item] != null) {
		    	$tbl .=	'<td align="center" >REVISAR</td>';
		    	$tbl .=	'<td align="center" >'.$rptanovedadeschecklis["obscbtr".$item].'</td>';

		    }else{
		    	$tbl .='<td align="center">OK</td>';
		    	$tbl .='<td></td>';

		    }

		$tbl .=	'</tr>';

	}

    $tbl .='

</table>';

$pdf->writeHTMLCell(0, 0, 10, 105, $tbl, 0, 1, 0, true, 'L', false);

/*========================================
=            SECCION CARGADOR            =
========================================*/
$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td style="font-size:10px;" colspan="3" align="center"><strong>INSPECCIÓN VISUAL DE CARGADOR</strong></td>

	</tr>

	<tr class="cabecera">

		<td width="300" align="center"><strong>Descripción</strong></td>
		<td width="38" align="center"><strong>Estado</strong></td>
		<td width="310" align="center"><strong>Novedad</strong></td>
	</tr>';

	for ($i=0; $i < count($cargador) ; $i++) {
		$item = $i+1;

	$tbl .=	'<tr>
		    <td><span >'.$cargador[$i].'</span></td>';

		    if ($rptanovedadeschecklis["obscrgd".$item] != null) {
		    	$tbl .=	'<td align="center" >REVISAR</td>';
		    	$tbl .=	'<td align="center" >'.$rptanovedadeschecklis["obscrgd".$item].'</td>';

		    }else{
		    	$tbl .='<td align="center">OK</td>';
		    	$tbl .='<td></td>';

		    }

		$tbl .=	'</tr>';

	}

    $tbl .='

</table>';

$pdf->writeHTMLCell(0, 0, 10, 124, $tbl, 0, 1, 0, true, 'L', false);

/*=========================================
=            SECCION OPERACIÓN            =
=========================================*/

$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td style="font-size:10px;" colspan="3" align="center"><strong>INSPECCIÓN DE LA OPERACION</strong></td>

	</tr>

	<tr class="cabecera">

		<td width="300" align="center"><strong>Descripción</strong></td>
		<td width="38" align="center"><strong>Estado</strong></td>
		<td width="310" align="center"><strong>Novedad</strong></td>
	</tr>';

	for ($i=0; $i < count($operacional) ; $i++) {
		$item = $i+1;

	$tbl .=	'<tr>
		    <td><span >'.$operacional[$i].'</span></td>';

		    if ($rptanovedadeschecklis["obsoprc".$item] != null) {
		    	$tbl .=	'<td align="center" >REVISAR</td>';
		    	$tbl .=	'<td align="center" >'.$rptanovedadeschecklis["obsoprc".$item].'</td>';

		    }else{
		    	$tbl .='<td align="center">OK</td>';
		    	$tbl .='<td></td>';

		    }

		$tbl .=	'</tr>';

	}

    $tbl .='

</table>';

$pdf->writeHTMLCell(0, 0, 10, 147, $tbl, 0, 1, 0, true, 'L', false);

/*===================================================
=            COLOCANDO LAS OBSERVACIONES            =
===================================================*/

if (!empty($rpta["observacion"])) {
	$pdf->SetFont('helvetica', '', 15);
	$pdf->writeHTMLCell(0, 0, 10, 190, "Observaciones: ", 0, 1, 0, true, 'L', false);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->writeHTMLCell(0, 0, 50, 192, $rpta["observacion"], 0, 1, 0, true, 'L', false);
}else{
	$pdf->SetFont('helvetica', '', 15);
	$pdf->writeHTMLCell(0, 0, 10, 190, "Observaciones: ", 0, 1, 0, true, 'L', false);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->writeHTMLCell(0, 0, 50, 192, "_________________________________________________________", 0, 1, 0, true, 'L', false);
}

if (!empty($rpta["motivoatraso"]) || $rpta["motivoatraso"] != null ) {
	$pdf->SetFont('helvetica', '', 15);
	$pdf->writeHTMLCell(0, 0, 10, 210, "Motivo de Atraso: ", 0, 1, 0, true, 'L', false);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->writeHTMLCell(0, 0, 55, 213, $rpta["motivoatraso"], 0, 1, 0, true, 'L', false);
}else{
	$pdf->SetFont('helvetica', '', 15);
	$pdf->writeHTMLCell(0, 0, 10, 210, "Motivo de Atraso: ", 0, 1, 0, true, 'L', false);
	$pdf->SetFont('helvetica', '', 8);
	$pdf->writeHTMLCell(0, 0, 55, 213, "_________________________________________________________", 0, 1, 0, true, 'L', false);
}

// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('Check List.pdf', 'I');

	

}else{

	echo "error";

}
