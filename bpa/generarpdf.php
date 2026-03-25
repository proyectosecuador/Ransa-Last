<?php

require_once "../controladores/checklistbpa.controlador.php";

require_once "../modelos/checklistbpa.modelo.php";


require_once "../controladores/localizacion.controlador.php";

require_once "../modelos/localizacion.modelo.php";


require_once "../controladores/clientes.controlador.php";

require_once "../modelos/clientes.modelo.php";


require_once "../controladores/usuarios.controlador.php";

require_once "../modelos/usuarios.modelo.php";


require_once "../extensiones/TCPDF/tcpdf.php";

require_once '../extensiones/PhpSpreadSheet/autoload.php';

require_once "../extensiones/SVGGraph/autoloader.php"; // liberia para generar el grafico


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

        $this->Image($image_file, 10, 5, 35, '', 'PNG', 'https://ransa.ranecu.com', 'M', false, 300, '', false, false, 0, false, false, false);

        // Set font

        $this->SetFont('helvetica', 'B', 15);

        // Title

        $this->Cell(0, 0,'Check List de Almacén' , 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 9);
		
		$this->writeHTMLCell(31, 0, 175, 4, "Código : FCME-0032" , '', 0, 0, true, '', true);
		$this->writeHTMLCell(20, 0, 180, 8, "Revisión : 02" , '', 0, 0, true, '', true);        

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

if (isset($_POST["idcheckbpa"])) {

	$rpta = ControladorCheckListBpa::ctrConsultarCheckListBpa($_POST["idcheckbpa"],"idchcklstbpa");

	// Creación del objeto de la clase heredada

	// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// create new PDF document

// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Nicola Asuni');

$pdf->SetTitle('Check_List_Almacen_'.date('d-m-Y',strtotime($rpta[0]["fecha_reg"])).$_POST["idcheckbpa"]);

$pdf->SetSubject('TCPDF Tutorial');

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

$pdf->SetFont('helveticaB', '', 6);



// add a page

$pdf->AddPage();


/*=============================================================================

=            CONSULTAMOS EL ALMACÉN DONDE SE REALIZO EL CHECK LIST            =

=============================================================================*/

$rptaalmacen = ControladorLocalizacion::ctrConsultarLocalizacion($rpta[0]["idlocalizacion"],"idlocalizacion");



/*=====================================================

=            OBTENEMOS EL VALOR DE CLIENTE            =

=====================================================*/

if ($rpta[0]["idcliente"] != null) {

	$rptacliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta[0]["idcliente"]);

	$cliente = $rptacliente["razonsocial"];

}else{

	$cliente = "GENERAL";

}

/*=============================================================

=            CONSULTAMOS EL AUDITOR DEL CHECK LIST            =

=============================================================*/

$rptaauditor = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rpta[0]["idauditor"]);

$nombre = explode(" ", $rptaauditor["primernombre"]);

$apellido = explode(" ", $rptaauditor["primerapellido"]);

/*==========================================================================

=            CONSULTAMOS OBSERVACIONES DEL CHECK LIST REALIZADO            =

==========================================================================*/

$rptaobservaciones = ControladorCheckListBpa::ctrConsultarObsCheckListBpa($rpta[0]["idchcklstbpa"],"idchcklstbpa");

if ($rptaobservaciones == false || $rptaobservaciones == null) {

	$rptaobservaciones = null;

}







// create some HTML content

$tbl = '

<table cellspacing="0" cellpadding="2" border="1">

	<tr>

		<td colspan="4" ><strong>Cuenta: </strong>'.$cliente.'</td>

	</tr>

    <tr>

        <td><strong>Fecha: </strong>'. date("d-m-Y",strtotime($rpta[0]["fecha_reg"])).' </td>

        <td><strong>Almacén: </strong>'.$rptaalmacen["nom_localizacion"].'</td>

        

        <td><strong>Evaluador: </strong>'.$nombre[0]." ".$apellido[0].'</td>

        <td><strong>Hora: </strong>'.date("H:i:s",strtotime($rpta[0]["fecha_reg"])).'</td>

    </tr>

</table>

';

$pdf->writeHTML($tbl, true, false, true, false, '');

$tbl = '
<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera" align="center">

		<td colspan="3" ><strong>CRITERIOS DE CALIFICACION </strong></td>

	</tr>

    <tr align="center">
    	<td><label style="font-size:12px;">CUMPLE (2)</label><br>El ítems evaluado se cumple en su totalidad. No se evidencia incumplimiento alguno (0 hallazgos) </td>
    	<td><label style="font-size:12px;">PARCIAL (1) </label><br>El ítems evaluado se cumple de forma parcial y se evidencia un bajo número de incumplimientos (1-3 hallazgos)</td>
    	<td><label style="font-size:12px;">NO CUMPLE (0) </label><br>El ítems evaluado se cumple de forma parcial y se evidencia un número significativo de incumplimientos (más de 4 hallazgos)</td>

    </tr>

</table>

';

$pdf->writeHTML($tbl, true, false, true, false, '');

$tbl = '
<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera" align="center">

		<td colspan="4" ><strong>CALIFICACION</strong></td>

	</tr>

    <tr align="center">
    	<td>Requiere mejora =< 74</td>
    	<td>Regular 75 - 84 %</td>
    	<td>Bueno 85 - 90 %</td>
    	<td>Excelente => 91 %</td>

    </tr>

</table>

';

$pdf->writeHTML($tbl, true, false, true, false, '');

/*=======================================

=            SALTOS DE LINEA            =

=======================================*/

$pdf->Ln();$pdf->Ln();



/*=====================================================================

=            CONTRUIMOS UN ARRAY PARA GUARDAR LAS OPCIONES            =

=====================================================================*/

$opcionesdoc = ["Se archivan de forma correcta los documentos referentes a la recepción de los productos (Guía de remisión, packing-list, check-list de transporte físico o virtual, guía de recepción del WMS, etc.)",

			"Se archivan de forma correcta los documentos referentes al despacho de los productos (Guía de remisión, orden de despacho o pedido, Check-list de transporte físico o virtual, guía de despacho, etc.)",

			"Se cumple con la frecuencia de inventario para el control interno de existencias (ver cotización, contrato o ANS aprobado por el cliente o lo establecido en el
			PCME-0011).",

			"Se archivan de forma correcta los documentos utilizados para la toma de inventario físico de los productos (ordenados, identificados y fechados).",

			"Se llenan todos los campos de los registros y cuenta con firmas de responsabilidad (no aplica para registros virtuales).",

			"Los registros utilizados corresponden a las versiones vigentes (físicos o digitales).",

			"Se cumple con las Buenas Practicas de Documentación (carpetas/corrugados identificados y apilados de forma correcta sobre un pallets y sectorizados en un área rotulada)"];

$opcionesol = ["Los pasillos se encuentran limpios y sin acumulación de artículos en desuso (sin papel, pedazo de cartón, stretch film, retazos de madera, producto derramado, cajas vacias y desordenadas, canutos, etc.).",

				"Las paredes junto a pasillos y estructuras de rack se encuentran limpias (libres de insectos muertos, polvo y telarañas).",

				"Las estructuras de rack se encuentran identificadas con el rótulo de identificación según lo requerido por el WMS (no existen rótulos que no correspondan a los productos almacenados o zonas asignadas).",

				"No existe evidencia de consumo de producto almacenado en los rack o paredes del almacén (envoltura o botellas vacías).",

				"Módulos de andenes en buen estado, limpios y ordenados (sin acumulación de documentos, basura o cajas junto a tomas de corriente).",

				"Los tachos de basura ubicado en los andenes están limpios, rotulados, en buen estado y no contienen empaques de snack, envoltura o botellas de bebidas.",

				"El área de andenes está limpia y ordenada, sin acumulación de pallets en mal estado.",

				"Las tulas son utilizadas para el almacenamiento de material de reciclaje (Stretch film y cartón según aplique)",

				"Las estaciones de monitoreo de roedores ubicada en las puertas de los andenes se encuentran despejadas y en buen estado (sin obstrucciones de cualquier tipo).",

				// "El área de andenes está limpia y ordenada, libre de pallets en mal estado",

				// "Las tulas son utilizadas para el almacenamiento de material de reciclaje (Strech film y cartón)",

				// "Estaciones de monitoreo de roedores despejadas y en buen estado"
			];

$opcionesalmprod = ["Todos los productos se almacenan sobre pallets (no hay producto directamente en piso).",

					"Los pallets se encuentran limpios y buen estado (productos alimenticios almacenados en pallets sin manchas de aceite, pallets sin restos de producto adherido/derramado, pallets sin daños estructurales o elementos incompletos, pallets sin clavos expuestos, sin evidencia de plaga como barrenador de madera, comejen, húmedos o con moho, ver PCME-0057).",

					"Los productos se mantienen en buen estado (no hay cajas golpeadas, dañadas o producto derramando por golpe de montacarga o traspaleta).",

					"Los pallets están perchados correctamente (alineados en el rack sin esquinas en el aire) y las cajas están bien estibadas (orientación de la caja correcta y no existe picado en escalera).",

					"El producto en mal estado, averiado o caducado se encuentra ordenado, embalado, rotulado, su ubicación identificada, coincide el físico vs WMS y está bloqueado para el despacho).",

					"Se evita la incompatibilidad de mercadería (almacenamiento de producto por clase sin generar contaminación cruzada de olores o derrames, ver requisitos del cliente en cotización, contrato o ANS aprobado y/o el anexo 1 del PCME-0011).",

					"Se cumple con la carga máxima permitida por nivel de 1960 KG por nivel/nicho (verificar el peso de los productos en el FMCE-0033 levantado para cada cliente).",

					"La zona de picking se mantiene ordenada y no existen unidades de producto caídas debajo del pallets.",

					"Los productos se almacenan hasta el nivel de rack máximo solicitado por el cliente y acorde a los estándades de temperatura requeridos/ofertados (ver requisitos del cliente en cotización, contrato o ANS aprobado por el cliente vs los registros de temperatura de los datalogger).",

					// "Saldo en caja y caja entrecruzada",

					// "Todos los pallets cuentan con rótulo de identificación de pallets correspondiente (aprobado, cuarentena o rechazado)",

					// "Se llenan todos los campos de rótulo de identificación",

					// "Cumplimiento de estándares de conservación (T°C)"
				];



$docpuntobtenido = 0;

$olpuntobtenido = 0;

$almprodpuntobtenido = 0;

/*===================================================

=            SECCION DE ITEMS DOCUMENTOS            =

===================================================*/

$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td width="450" colspan="2" align="center"><strong>DOCUMENTOS DE CALIDAD</strong></td>

		<td width="50" align="center"><strong>PUNTAJE</strong></td>

		<td align="center"><strong>Detalle de hallazgos</strong></td>

	</tr>';

	for ($i=0; $i < count($opcionesdoc) ; $i++) { 

		$item = $i+1;

	$tbl .=	'<tr>

		    <td align="center" width="25"><strong>'.$item.'</strong> </td>

		    <td width="425"><span >'.$opcionesdoc[$i].'</span></td>';

		    switch ($rpta[0]["doc".$item]) {

		    	case 1:

		    		$tbl .=	'<td align="center" width="50">PARCIAL</td>';

		    		$docpuntobtenido += $rpta[0]["doc".$item];

		    		break;

		    	case 2:

		    		$tbl .=	'<td align="center" width="50">CUMPLE</td>';

		    		$docpuntobtenido += $rpta[0]["doc".$item];

		    		break;

		    	case 0:

		    		$tbl .=	'<td align="center" width="50">NO CUMPLE</td>';

		    		$docpuntobtenido += $rpta[0]["doc".$item];

		    		break;

		    }

		    if ($rptaobservaciones!= null) {

		    	$tbl .=	'<td >'.$rptaobservaciones["obsdoc".$item].'</td>';

		    }else{

		    	$tbl .='<td ></td>';

		    }

	

		$tbl .=	'</tr>';

	}

    $tbl .='

</table>';

$pdf->writeHTML($tbl, true, false, true, false, '');

/*============================================================

=            SECCION DE ITEMS DE ORDEN Y LIMPIEZA            =

============================================================*/

$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td width="450" colspan="2" align="center"><strong>ORDEN Y LIMPIEZA</strong></td>

		<td width="50" align="center"><strong>PUNTAJE</strong></td>

		<td align="center"><strong>Detalle de hallazgos</strong></td>

	</tr>';

	for ($i=0; $i < count($opcionesol) ; $i++) { 

		$item = $i+1;

	$tbl .=	'<tr>

		    <td align="center" width="25"><strong>'.$item.'</strong> </td>

		    <td width="425"><span >'.$opcionesol[$i].'</span></td>';

		    switch ($rpta[0]["ol".$item]) {

		    	case 1:

		    		$tbl .=	'<td align="center" width="50">PARCIAL</td>';

		    		$olpuntobtenido += $rpta[0]["ol".$item];

		    		break;

		    	case 2:

		    		$tbl .=	'<td align="center" width="50">CUMPLE</td>';

		    		$olpuntobtenido += $rpta[0]["ol".$item];

		    		break;

		    	case 0:

		    		$tbl .=	'<td align="center" width="50">NO CUMPLE</td>';

		    		$olpuntobtenido += $rpta[0]["ol".$item];

		    		break;

		    }	    

		    

		    if ($rptaobservaciones!= null) {

		    	$tbl .=	'<td >'.$rptaobservaciones["obsol".$item].'</td>';

		    }else{

		    	$tbl .='<td ></td>';

		    }

	

		$tbl .=	'</tr>';

	}

    $tbl .='

</table>';

$pdf->writeHTML($tbl, true, false, true, false, '');

/*================================================================

=            SECCION DE ITEMS DE ALMACEN DE PRODUCTOS            =

================================================================*/

$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td width="450" colspan="2" align="center"><strong>ALMACÉN DE PRODUCTOS</strong></td>

		<td width="50" align="center"><strong>PUNTAJE</strong></td>

		<td align="center"><strong>Detalle de hallazgos</strong></td>

	</tr>';

	for ($i=0; $i < count($opcionesalmprod) ; $i++) { 

		$item = $i+1;

	$tbl .=	'<tr>

		    <td align="center" width="25"><strong>'.$item.'</strong> </td>

		    <td width="425"><span >'.$opcionesalmprod[$i].'</span></td>';

		    switch ($rpta[0]["almprod".$item]) {

		    	case 1:

		    		$tbl .=	'<td align="center" width="50">PARCIAL</td>';

		    		$almprodpuntobtenido += $rpta[0]["almprod".$item];

		    		break;

		    	case 2:

		    		$tbl .=	'<td align="center" width="50">CUMPLE</td>';

		    		$almprodpuntobtenido += $rpta[0]["almprod".$item];

		    		break;

		    	case 0:

		    		$tbl .=	'<td align="center" width="50">NO CUMPLE</td>';

		    		$almprodpuntobtenido += $rpta[0]["almprod".$item];

		    		break;

		    }

		    if ($rptaobservaciones!= null) {

		    	$tbl .=	'<td >'.$rptaobservaciones["obsalmprod".$item].'</td>';

		    }else{

		    	$tbl .='<td ></td>';

		    }

	

		$tbl .=	'</tr>';

	}

    $tbl .='

</table>';

$pdf->writeHTML($tbl, true, false, true, false, '');

/*===============================================

=            TABLA DE PUNTAJE MAXIMO            =

===============================================*/

$puntajefinal = $docpuntobtenido+$olpuntobtenido+$almprodpuntobtenido; // resultado de la suma total del puntaje obtenido

/* PORCENTAJES OBTENIDOS */

$pordoc = ($docpuntobtenido / 14)*100;

$porol = ($olpuntobtenido / 18)*100;

$poralmprod = ($almprodpuntobtenido / 18)*100;

$promedio = ($pordoc+$porol+$poralmprod)/3;

/* CALIFICACIONM DOC */

if (number_format($pordoc,0,",",".")<= 74) {

	$calificaciondoc = "REQUIRE MEJORA";

}else if (number_format($pordoc,0,",",".") > 74 && number_format($pordoc,0,",",".") <= 84  ) {

	$calificaciondoc = "REGULAR";

}else if (number_format($pordoc,0,",",".") > 84 && number_format($pordoc,0,",",".") <= 90) {

	$calificaciondoc = "BUENO";

}else{

	$calificaciondoc = "EXCELENTE";

}

/* CALIFICACIONM OL */

if (number_format($porol,0,",",".")<= 74) {

	$calificacionol = "REQUIRE MEJORA";

}else if (number_format($porol,0,",",".") > 74 && number_format($porol,0,",",".") <= 84  ) {

	$calificacionol = "REGULAR";

}else if (number_format($porol,0,",",".") > 84 && number_format($porol,0,",",".") <= 90) {

	$calificacionol = "BUENO";

}else{

	$calificacionol = "EXCELENTE";

}

/* CALIFICACIONM ALMPROD */

if (number_format($poralmprod,0,",",".")<= 74) {

	$calificacionalmprod = "REQUIRE MEJORA";

}else if (number_format($poralmprod,0,",",".") > 74 && number_format($poralmprod,0,",",".") <= 84  ) {

	$calificacionalmprod = "REGULAR";

}else if (number_format($poralmprod,0,",",".") > 84 && number_format($poralmprod,0,",",".") <= 90) {

	$calificacionalmprod = "BUENO";

}else{

	$calificacionalmprod = "EXCELENTE";

}

/* CALIFICACIONM PROMEDIO */

if (number_format($promedio,0,",",".")<= 74) {

	$calificacionpromedio = "REQUIRE MEJORA";

}else if (number_format($promedio,0,",",".") > 74 && number_format($promedio,0,",",".") <= 84  ) {

	$calificacionpromedio = "REGULAR";

}else if (number_format($promedio,0,",",".") > 84 && number_format($promedio,0,",",".") <= 90) {

	$calificacionpromedio = "BUENO";

}else{

	$calificacionpromedio = "EXCELENTE";

}

$tbl = '

<style>

.cabecera{

	background-color: #45bf1d;

}

</style>

<table  width="280" cellspacing="0" cellpadding="2" border="1">

	<tr class="cabecera">

		<td width="150" align="center"><strong>INDICE TOTAL ALMACÉN</strong></td>

		<td align="center"><strong>PUNTAJE MAXIMO</strong></td>

		<td align="center"><strong>PUNTAJE OBTENIDO</strong></td>

		<td align="center"><strong>%</strong></td>

		<td width="60" align="center"><strong>CALIFICACIÓN</strong></td>

	</tr>

	<tr>

		<td width="150" align="center"><strong>DOCUMENTOS DE CALIDAD</strong></td>

		<td align="center">14</td>

		<td align="center">'.$docpuntobtenido.'</td>

		<td align="center">'.number_format($pordoc,0,",",".").' % </td>

		<td align="center">'.$calificaciondoc.'</td>

	</tr>

	<tr>

		<td width="150" align="center"><strong>ORDEN Y LIMPIEZA</strong></td>

		<td align="center">18</td>

		<td align="center">'.$olpuntobtenido.'</td>

		<td align="center">'.number_format($porol,0,",",".").' % </td>

		<td align="center">'.$calificacionol.'</td>

	</tr>

	<tr>

		<td width="150" align="center"><strong>ALMACÉN DE PRODUCTOS</strong></td>

		<td align="center">18</td>

		<td align="center">'.$almprodpuntobtenido.'</td>

		<td align="center">'.number_format($poralmprod,0,",",".").' %</td>

		<td align="center">'.$calificacionalmprod.'</td>

	</tr>

	<tr>

		<td width="150" align="center"><strong>TOTAL</strong></td>

		<td align="center">50</td>

		<td align="center">'.$puntajefinal.'</td>

		<td align="center">'.number_format($promedio,0,",",".").' % </td>

		<td align="center">'.$calificacionpromedio.'</td>

	</tr>

</table>

';

$pdf->writeHTMLCell(0, 0, 50, '', $tbl, 0, 1, 0, true, 'C', false);

/*======================================================

=            CREAMOS EL GRAFICO PARA EL PDF            =

======================================================*/
$pdf->AddPage();
$settings = [

  'auto_fit' => true,

  'back_colour' => '#eee',

  'back_stroke_width' => 0,

  'back_stroke_colour' => '#eee',

  'show_data_labels' => true,

  'data_label_back_colour' => ['#ccc', null, null, null, null,

  null, null, null, null, null],  

  'stroke_colour' => '#000',

  'axis_colour' => '#333',

  'axis_overlap' => 2,

  'grid_colour' => '#666',

  'label_colour' => '#000',

  'axis_font' => 'Arial',

  'axis_font_size' => 10,

  'pad_right' => 20,

  'pad_left' => 20,

  'link_base' => '/',

  'link_target' => '_top',

  'minimum_grid_spacing' => 10,

  'show_subdivisions' => false,

  'show_grid_subdivisions' => false,

  'grid_subdivision_colour' => '#ccc',

  'graph_title' => 'RESULTADO DE LA INSPECCIÓN',

  'label_y' => '% DE CUMPLIMIENTO',

];



$width = 500;

$height = 200;

$type = 'BarGraph';

$values = [

  ['DOCUMENTOS DE CALIDAD' => number_format($pordoc,0,",","."), 'ORDEN Y LIMPIEZA' => number_format($porol,0,",","."), 'ALMACÉN DE PRODUCTOS' => number_format($poralmprod,0,",",".")]

];



$colours = [ ['#4f81bd', '#4f81bd'], ['#4f81bd', '#4f81bd'] ];



$graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);

$graph->colours($colours);



$links = ['Dough' => 'jpegsaver.php', 'Ray' => 'crcdropper.php', 'Me' => 'svggraph.php'];

$graph->values($values);



$graph->links($links);

// $output = $graph->fetch('BarGraph');

$grafico = $graph->fetch($type, true);

// $var = $graph->render($type);

// var_dump($grafico);

$pdf->ImageSVG('@' . $grafico, $x=15, $y=20, $w=180, $h=52, $link='', $align='', $palign='', $border=0, $fitonpage=false);



/*================================================

=            SECCION DE OBSERVACIONES            =

================================================*/



$pdf->SetFont('helvetica', 'B', 18);

// $pdf->SetLineStyle(array('width' => 0.5, 'cap' => 'butt', 'join' => 'miter', 'dash' => 4, 'color' => array(255, 0, 0)));

// $pdf->SetFillColor(171,249,180);

// $pdf->SetTextColor(0,0,128);

// $pdf->writeHTML(, $ln=true, $fill=false, $reseth=false, $cell=false, $align='')

$pdf->writeHTMLCell(0, 0, 15, 80, "OBSERVACIONES:", 'B', 1, 0, true, 'L', false);

// $pdf->writeHTML("OBSERVACIONES:", true, false, true, false, '');

// $pdf->Cell(0, 0, , 'B', 1, 'L', false, 0);

$pdf->SetFont('helveticaB', '', 8);

$pdf->writeHTMLCell(0, 0, 15, 95, $rpta[0]["observaciones"], 0, 1, 0, true, 'L', false);

// $pdf->Write(0, $rpta[0]["observaciones"], '', 0, 'L', true, 0, false, false, 0);




$pdf->AddPage();
/*=====================================================================================

=            CONVERTIMOS A UN ARRAY EL VALOR DE LAS EVIDENCIAS DE IMÀGENES            =

=====================================================================================*/

$fotos = json_decode($rpta[0]["evi_foto"],true);

// var_dump($fotos);

if ($fotos != null) {
if (count($fotos) <=10) {
	$x = 20;

	$y = 30;

	$w = 50;

	$h = 50;

	$pdf->SetFont('helvetica', 'B', 18);

	$pdf->writeHTMLCell(0, 0, 15, 20, "EVIDENCIA FOTOGRAFICAS:", 'B', 1, 0, true, 'L', false);

	// $pdf->Cell(0, 0, "EVIDENCIA FOTOGRAFICAS:", 'B', 1, 'L', false, 0);

	if ($fotos) {

		for ($i=0; $i < count($fotos) ; $i++) {
			$valor = (($i) % 3);
			if ((($i) % 3) == 0) {
				if ($i==0) {
					$x = 20;

					$y = 30;
				}else{
					$x -= 180;

					$y += 65;
				}

			}
			// $pdf->writeHTMLCell(0, 0, $x, $y, $x."jj".$y."valor:".$valor, '', 1, 0, true, 'L', false);
			$img_evidencia = '../'.$fotos[$i]["ImgEvidencia"];

			$pdf->Image($img_evidencia, $x, $y, $w, $h, '', '', '', true, 150, '', false, false, 0, false, false, false);

           //var_dump($pdf->Image($img_evidencia, $x, $y, $w, $h, '', '', '', true, 150, '', false, false, 0, false, false, false));

			$x += 60;

		}

	}
}else{

	$x = 20;

	$y = 30;

	$w = 50;

	$h = 50;

	$pdf->SetFont('helvetica', 'B', 18);

	$pdf->writeHTMLCell(0, 0, 15, 20, "EVIDENCIA FOTOGRAFICAS:", 'B', 1, 0, true, 'L', false);

	if ($fotos) {

		for ($i=0; $i < count($fotos) ; $i++) {
			$valor = (($i) % 3);
			/*======================================================
			=            ASIGNAMOS 3 IMAGENES POR LINEA            =
			======================================================*/
			if ((($i) % 3) == 0) {
				/*================================================================
				=            EN TOTAL DEBE LLEVAR 9 IMAGENES POR HOJA            =
				================================================================*/
				if ((($i) % 9) == 0) {
					if ($i==0) {
						$x = 20;

						$y = 30;
					}else{
						$pdf->AddPage();
						$x = 20;

						$y = 25;

					}

				}else{
					if ($i==0) {
						$x = 20;

						$y = 30;
					}else{
						$x -= 180;

						$y += 75;
					}
				}
			}

			$img_evidencia = '../'.$fotos[$i]["ImgEvidencia"];

			$pdf->Image($img_evidencia, $x, $y, $w, $h, '', '', '', true, 150, '', false, false, 0, false, false, false);

			$x += 60;

		}

	}		
}


}




// ---------------------------------------------------------



//Close and output PDF document

$pdf->Output('Check List.pdf', 'I');

	

}else{

	echo "error";

}