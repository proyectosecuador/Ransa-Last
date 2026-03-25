<?php

require_once "../../controladores/checklisttrans.controlador.php";
require_once "../../modelos/checklisttrans.modelo.php";

require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

require_once "../../controladores/movi_R_D.controlador.php";
require_once "../../modelos/movi_R_D.modelo.php";

require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";

require_once "../../controladores/actividadE.controlador.php";
require_once "../../modelos/actividadE.modelo.php";

require_once "../../controladores/t_transporte.controlador.php";
require_once "../../modelos/t_transporte.modelo.php";

require_once "../../controladores/localizacion.controlador.php";
require_once "../../modelos/localizacion.modelo.php";

require_once "../../controladores/ciudad.controlador.php";
require_once "../../modelos/ciudad.modelo.php";

require_once "../../extensiones/TCPDF/tcpdf.php";

/*=========================================================
=            CONSULTAMOS LA RECEPCION ASIGNADA            =
=========================================================*/

$rpta = ControladorCheckTransporte::ctrConsultarCheckTransporte("idchcklsttrans",$_POST["idchecktrans"]);


class MYPDF extends TCPDF {
	


    // Page header

    public function Header() {
    	// $rpta = ControladorRecepcion::ctrConsultarRecepcion("idrecepcion",$_POST["idrecepcion"]);


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

        $this->Image($image_file, 10, 5, 35, '', 'PNG', 'https://ransa.ranecu.com', 'M', false, 300, '', false, false, 0, false, false, false);

        // Set font

        $this->SetFont('helvetica', 'B', 15);

        // Title

        $this->Cell(0, 0,'Check List de Transporte' , 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 9);
		
		$this->writeHTMLCell(31, 0, 175, 4, "Código : FCME-0020" , '', 0, 0, true, '', true);
		$this->writeHTMLCell(20, 0, 180, 8, "Revisión : 04" , '', 0, 0, true, '', true);

       

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
// create new PDF document

// $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information

$pdf->SetCreator(PDF_CREATOR);

$pdf->SetAuthor('Douglas Borbor');

$pdf->SetTitle('Recepcion Contenedor');

$pdf->SetSubject('Contenedore Recibido');

$pdf->SetKeywords('Recepcion, Contenedor, Recibi, pdf, ');




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

if ($rpta) {
	/*=================================================
	=            CONSULTAMOS EL MOVIMIENTO            =
	=================================================*/
	$rptamov = ControladorMovRD::ctrConsultarMovRD($rpta["idmov_recep_desp"],"idmov_recep_desp");

	/*============================================
	=            CONSULTAR EL CLIENTE            =
	============================================*/
	
	$rptacliente = ControladorClientes::ctrmostrarClientes("idcliente",$rptamov["idcliente"]);
	/*============================================
	=            COONSULTAR ACTIVIDAD            =
	============================================*/
	if (!empty($rptamov["idactividad"])) {
		$rptaActividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba",$rptamov["idactividad"]);
		$rptaActividad = $rptaActividad["descripcion"];
	}else{
		$rptaActividad = "";
	}
	
	/*======================================================
	=            CONSULTA EL TIPO DE TRANSPORTE            =
	======================================================*/
	if (!empty($rptamov["idtipo_transporte"])) {
		$rptaTipoTransporte = ControladorTTransporte::ctrConsultarTTransporte("idtipo_transporte",$rptamov["idtipo_transporte"]);
		$rptaTipoTransporte = $rptaTipoTransporte["descripcion"];
	}else{
		$rptaTipoTransporte = "";
	}
	
	/*=========================================
	=            CONSULTAR USUARIO            =
	=========================================*/
	$tabla = "usuariosransa";
	$item = "id";
	$valor = $rptamov["idusuario"];
	$rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$item,$valor);
	
	
	
	
	
	
	
	
	
	/*================================================
	=            CONSULTA DE LOCALIZACION            =
	================================================*/
	if (!empty($rptamov["idlocalizacion"])) {
		$rptaLocalizacion = ControladorLocalizacion::ctrConsultarLocalizacion($rptamov["idlocalizacion"],"idlocalizacion");		
		$rptaLocalizacion = $rptaLocalizacion["nom_localizacion"];
	}else{
		$rptaLocalizacion = "";
	}


	// var_dump($rptamov["idlocalizacion"]);

	/*===========================================
	=            CONSULTAR LA CIUDAD            =
	===========================================*/
	if (!empty($rptaUsuario["idciudad"])) {
		$rptaCiudad = ControladorCiudad::ctrConsultarCiudad("idciudad",$rptaUsuario["idciudad"]);	
		$rptaCiudad = $rptaCiudad["desc_ciudad"];
	}else{
		$rptaCiudad = "";
	}

	
	
	$pdf->AddPage();

// $rptachecktrans = ControladorCheckTransporte::ctrConsultarCheckTransporte("idrecepcion",$rpta["idrecepcion"]);
	// $pdf->SetFont('helvetica', 'B', 15);
	// $pdf->SetFillColor(0, 154,63);
	// $pdf->SetTextColor(255, 255, 255);
	
	// $pdf->writeHTML("Datos Generales", true, false, true, false, 'C');	
	$pdf->SetFont('helvetica', 'B', 18);
	$pdf->writeHTMLCell(0, 0, '', 20, "Datos Generales", 'B', 1, 0, true, 'C', false);
	$pdf->Ln(3);

	$pdf->SetFont('helvetica', '', 9);
	// if ($rptachecktrans["origen"] == null) {
	// 	$detalleorides = $rptachecktrans["destino"];
	// }else{
	// 	$detalleorides = $rptachecktrans["origen"];
	// }

		$html = '
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
		    <tr >
		        <td align="left" ><strong> Responsable de la inspección: </strong> </td>
		        <td colspan="5" ><strong>'.$rpta["realizadopor"].'</strong> </td>
		    </tr>		
		    <tr >
		        <td align="left" ><strong> Fecha: </strong> </td>
		        <td colspan="2">'.date('d-m-Y',strtotime($rpta["fecha_regis"])) .'</td>
		        <td align="left"><strong> Hora: </strong></td>
		        <td colspan="2">'.date('H:i:s',strtotime($rpta["fecha_regis"])).'</td>
		    </tr>
		    <tr >
		        <td align="left" ><strong> Cliente: </strong> </td>
		        <td colspan="5">'.$rptacliente["razonsocial"].'</td>
		    </tr>
		    <tr>
		        <td align="left"><strong> Bodega: </strong></td>
		        <td>'.$rptaLocalizacion.'</td>
		        <td align="left"><strong> Ciudad: </strong></td>
		        <td>'.$rptaCiudad.'</td> 
		        <td align="left"><strong> Proceso: </strong></td>
		        <td>'.$rptaActividad.'</td>        
		    </tr>
		    <tr>
		    	<td align="left"><strong> Guía: </strong></td>
		    	<td colspan="2" >'.$rptamov["nguias"].'</td>
		    	<td align="left"><strong> Contenedor: </strong></td>
		    	<td colspan="2">'.$rptamov["ncontenedor"].'</td>
		    </tr>';
		    	
				    $html .= '<tr><td align="left"><strong> Placa: </strong></td>
				    	<td colspan="2">'.$rpta["placa"].'</td>  
					    <td align="left"><strong> Tipo Unidad: </strong> </td>
					    <td colspan="2" >'.$rptaTipoTransporte.'</td>		    			    
				    </tr>
				    <tr>
				    	<td  align="left"><strong> Origen: </strong> </td>
					    <td colspan="2" >'.$rptamov["origen"].'</td>
					   	<td  align="left"><strong> Transportista: </strong> </td>
					    <td colspan="2" >'.$rpta["transportista"].'</td>
				    </tr>';


		$html .= '</table>';

			// $pdf->writeHTML(, true, false, true, false, '');
		$pdf->writeHTMLCell(0, 0, '', '', $html, '', 1, 0, true, 'C', false); 

	$pdf->SetFont('helvetica', 'B', 18);
	/*===============================================================
	=            TITULO DADO A LA RECEPCIÓN QUE SE TIENE            =
	===============================================================*/
	
	// add a page

	$pdf->SetTextColor(0, 0, 0);
	// $pdf->Write(0, , true, 0, 'C', true, 0, false, false, 0);
		$pdf->Ln(2);
		$pdf->writeHTMLCell(0, 0, '', '', "Lista de verificación", 'B', 0, 0, true, 'C', false);
		$pdf->Ln(8);
	

// 	==============================================================================================
// 	=            SECCION PARA VERIFICAR SI SE HA REALIZADO EL CHECK LIST DEL TRANSPORTE            =
// 	==============================================================================================
	
	// if ($rptachecktrans) {
		// $pdf->SetFont('helvetica', 'B', 15);
		// $pdf->SetFillColor(0, 154,63);
		// $pdf->SetTextColor(255, 255, 255);
		// $pdf->Ln(2);
		// $pdf->writeHTML("DATOS DEL CHECK LIST REALIZADO", true, true, true, false, 'C');
		// $pdf->writeHTMLCell(0, 0, '', 50, "SELLOS DE TRANSPORTE", 0, 0, 1, true, 'L', true);

		

		$html = '
		<table width="100%" border="1" cellspacing="0" cellpadding="3">
		    <tr style="background-color:#FFFF00;color:#0000FF;">
		        <td colspan="5" align="center" ><strong> Verificación del Interior </strong> </td>
			</tr>
		    <tr >
		    	<td colspan="2" align="left" >1.-  El vehículo se encuentra en buen estado</td>
	    		<td align="center">'.$rpta["ppt"].'</td>
	    		<td colspan="2" align="center">'.$rpta["obsppt"].'</td>
			</tr>
			<tr>
				<td colspan="2" align="left" >2.- El vehículo se encuentre en buenas condiciones de limpieza</td>
	    		<td align="center">'.$rpta["pa"].'</td>
	    		<td colspan="2" align="center">'.$rpta["obspa"].'</td>
			</tr>
			<tr>
				<td colspan="2" align="left" >3.- El vehículo está libre de residuos de cargas anteriores</td>
	    		<td align="center">'.$rpta["mi"].'</td>
	    		<td colspan="2" align="center">'.$rpta["obsmi"].'</td>
			</tr>
			<tr>
	    		<td colspan="2" align="left" >4.- El vehículo está libre de plagas</td>
	    		<td align="center">'.$rpta["plaga"].'</td>
	    		<td colspan="2" align="center">'.$rpta["obsplaga"].'</td>		
			</tr>
			<tr>
	    		<td colspan="2" align="left" >5.- El vehículo está libre de olores fuera de lo normal</td>
	    		<td align="center">'.$rpta["oe"].'</td>
	    		<td colspan="2" align="center">'.$rpta["obsoe"].'</td>	
			</tr>
			<tr>
	    		<td colspan="2" align="left" >6.- El vehículo está libre de químicos, sustancias o artículos contaminantes</td>
	    		<td align="center">'.$rpta["oquimicos"].'</td>			
	    		<td colspan="2" align="center">'.$rpta["obsoquimicos"].'</td>
			</tr>
             <tr>
	    		<td colspan="2" align="left" >7.- Los sellos de seguridad coinciden con los detallados en la guía o packing list (cuando aplique)</td>
	    		<td align="center">'.$rpta["sellos"].'</td>			
	    		<td colspan="2" align="center">'.$rpta["obssellos"].'</td>
			</tr>
			<tr>
				<td>Observaciones Adicionales:</td>
				<td colspan="4">'.$rpta["observaciones"].'</td>
			</tr>
		</table>';
		$pdf->Ln(2);
		$pdf->SetFont('helvetica', '', 9);
		$pdf->SetTextColor(0, 0, 0);
		$pdf->writeHTML($html, true, false, true, false, '');
	// }
	
	
	
	/*=======================================================================================
	=            PRESENTACION DE LAS IMAGENES SEGUN LA CLASIFICACION DEL USUARIO            =
	=======================================================================================*/	
	$pdf->SetFont('helvetica', '', 8);
	$fotos = json_decode($rpta["imagenes"],true); //CONVERTIMOS EN ARRAY EL LISTADO DE IMAGENES

	/*=================================================================================
	=            VERIFICAMOS SI EN EL ARRAY TENEMOS LA CLASIFICACION SELLO            =
	=================================================================================*/
	if ($fotos != null) {
	if (count($fotos)>0) {
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->SetFillColor(0, 154,63);
		// $pdf->SetTextColor(255, 255, 255);
		$pdf->Ln(2);
		// $pdf->writeHTML("Datos Generales", true, false, true, false, 'C');	
		$pdf->writeHTMLCell(0, 0, '', '', "Evidencia fotográfica", 'B', 1, 0, true, 'C', false);		
	}
	$column = array_column($fotos,"clasificacion"); //ESCOGEMOS LA COLUMNA DE CLASIFICACION PARA CONOCER SI EXISTE LA CLASIFICACION
	$convalores = array_count_values($column);
	if (isset($convalores["Sellos"])) {
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->SetFillColor(0, 154,63);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Ln(1);
		$pdf->writeHTML("Sellos de transporte", true, true, true, false, '');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->Ln(1);
			$contadorImg = 0;
			$tablaimg = '<table align="center" cellspacing="0" cellpadding="0" border="0">';
			$linea = false;
			/*======================================================================================
			=            RECORREMOS TODAS LAS IMAGENES Y SOLO PRESENTAMOS LAS DE SELLOS            =
			======================================================================================*/
			for ($i=0; $i < count($fotos) ; $i++) { 
				if ($fotos[$i]["clasificacion"] == "Sellos") {
					$img_evidencia = '../../'.$fotos[$i]["ImgRecepcion"];
					$comentarios = $fotos[$i]["comentario"];
					$contadorImg += 1;

					if ((($contadorImg) % 3) == 0) {
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
							$tablaimg .= '</tr>';
							$linea = true;
					}else{
						if ($contadorImg == 1 || $linea == true) {
							$linea = false;
							$tablaimg .= '<tr>';	
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
						}else{
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
						}
						if ($convalores["Sellos"] == $contadorImg) {
							$tablaimg .= '</tr>';
						}
						
							        	
							    	
					}
				}
			}
			$tablaimg .= '</table>';
			// echo $tablaimg;
			$pdf->writeHTML($tablaimg, true, true, true, false, '');


	}
	if (isset($convalores["Higiene"])) {
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->SetFillColor(0, 154,63);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Ln(1);
		$pdf->writeHTML("Condiciones sanitarias del transporte", true, true, true, false, '');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->Ln(1);
		$contadorImg = 0;
		$tablaimg = '<table align="center" cellspacing="0" cellpadding="0" border="0">';
		$linea = false;		
		for ($i=0; $i < count($fotos) ; $i++) { 
			if ($fotos[$i]["clasificacion"] == "Higiene") {
					$img_evidencia = '../../'.$fotos[$i]["ImgRecepcion"];
					$comentarios = $fotos[$i]["comentario"];
					$contadorImg += 1;

					if ((($contadorImg) % 3) == 0) {
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
							$tablaimg .= '</tr>';
							$linea = true;
					}else{
						if ($contadorImg == 1 || $linea == true) {
							$linea = false;
							$tablaimg .= '<tr>';	
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
						}else{
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
						}
						if ($convalores["Higiene"] == $contadorImg) {
							$tablaimg .= '</tr>';
						}
						
							        	
							    	
					}				
			}
		}
		$tablaimg .= '</table>';
		$pdf->writeHTML($tablaimg, true, true, true, false, '');
	}
	if (isset($convalores["Averia"])) {
		$pdf->SetFont('helvetica', 'B', 15);
		$pdf->SetFillColor(0, 154,63);
		$pdf->SetTextColor(255, 255, 255);
		$pdf->Ln(1);
		$pdf->writeHTML("Productos Averiados", true, true, true, false, '');
		$pdf->SetTextColor(0, 0, 0);
		$pdf->SetFont('helvetica', '', 8);
		$pdf->Ln(1);
		$contadorImg = 0;
		$tablaimg = '<table align="center" cellspacing="0" cellpadding="0" border="0">';
		$linea = false;		
		for ($i=0; $i < count($fotos) ; $i++) { 
			if ($fotos[$i]["clasificacion"] == "Averia") {
					$img_evidencia = '../../'.$fotos[$i]["ImgRecepcion"];
					$comentarios = $fotos[$i]["comentario"];
					$contadorImg += 1;

					if ((($contadorImg) % 3) == 0) {
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
							$tablaimg .= '</tr>';
							$linea = true;
					}else{
						if ($contadorImg == 1 || $linea == true) {
							$linea = false;
							$tablaimg .= '<tr>';	
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
						}else{
							$tablaimg .= '<td ><img width="160" height="140" src="'.$img_evidencia.'"><br>'.$comentarios.'</td>';
						}
						if ($convalores["Averia"] == $contadorImg) {
							$tablaimg .= '</tr>';
						}
						
							        	
							    	
					}				
			}
		}
		$tablaimg .= '</table>';
		$pdf->writeHTML($tablaimg, true, true, true, false, '');		
	}

	}
	
	// var_dump($column);
	
	


	
	// $pdf->writeHTMLCell(0, 0, '', 50, "SELLOS DE TRANSPORTE", 0, 0, 1, true, 'L', true);

























	/*===========================================================================
	=            CONSULTA SI LA CANTIDAD DE IMAGENES SON MAYOR DE 12            =
	===========================================================================*/	
	// if (count($fotos) > 12) {
	// 	$x = 20;

	// 	$y = 50;

	// 	$ycomentario = 100;

	// 	$w = 50;

	// 	$h = 50;

	// 	$hcomentario = 20;

	// 	if ($fotos) {






	// 		for ($i=0; $i < count($fotos) ; $i++) {
	// 			$valor = (($i) % 3);
	// 			/*======================================================
	// 			=            ASIGNAMOS 3 IMAGENES POR LINEA            =
	// 			======================================================*/
	// 			if ((($i) % 3) == 0) {
	// 				/*================================================================
	// 				=            EN TOTAL DEBE LLEVAR 9 IMAGENES POR HOJA            =
	// 				================================================================*/
	// 				if ((($i) % 9) == 0) {
	// 					if ($i==0) {
	// 						$x = 20;

	// 						$y = 50;
	// 						$ycomentario = 100; 
	// 					}else{
							// $pdf->AddPage();
	// 						$x = 20;

	// 						$y = 45;
	// 						$ycomentario = 95;

	// 					}

	// 				}else{
	// 					if ($i==0) {
	// 						$x = 20;

	// 						$y = 45;
	// 						$ycomentario = 95; 
	// 					}else{
	// 						$x -= 180;

	// 						$y += 75;
	// 						$ycomentario += 75;
	// 					}
	// 				}
	// 			}

	// 			// $pdf->writeHTMLCell(0, 0, $x, $y, $x."jj".$y."valor:".$valor, '', 1, 0, true, 'L', false);
	// 			$img_evidencia = '../../'.$fotos[$i]["ImgRecepcion"];

	// 			$pdf->Image($img_evidencia, $x, $y, $w, $h, '', '', '', true, 150, '', false, false, 0, false, false, false);

	// 			if ($fotos[$i]["comentario"] == "" || $fotos[$i]["comentario"] == null) {
	// 				$detallefoto = "";
	// 			}else{
	// 				$detallefoto = $fotos[$i]["comentario"];
	// 			}

	// 			$pdf->writeHTMLCell($w, $hcomentario, $x, $ycomentario, $fotos[$i]["comentario"] , '', 2, 0, true, 'C', true);


	// 			$x += 60;

	// 		}

	// 	}		
	// }else{

	// 	$pdf->SetFont('helvetica', '', 8);
	// 	$x = 20;

	// 	$y = 80;

	// 	$ycomentario = 120;

	// 	$w = 80;

	// 	$h = 70;

	// 	$hcomentario = 20;

	// 	if ($fotos) {

	// 		for ($i=0; $i < count($fotos) ; $i++) {
	// 			$valor = (($i) % 2);
	// 			if ((($i) % 2) == 0) {
	// 				if ((($i) % 4) == 0) {
	// 					if ($i==0) {
	// 						$x = 20;

	// 						$y = 80;
	// 						$ycomentario = 120; 
	// 					}else{
	// 						$pdf->AddPage();
	// 						$x = 20;

	// 						$y = 45;
	// 						$ycomentario = 115;

	// 					}

	// 				}else{
	// 					if ($i==0) {
	// 						$x = 20;

	// 						$y = 45;
	// 						$ycomentario = 115; 
	// 					}else{
	// 						$x -= 200;

	// 						$y += 105;
	// 						$ycomentario += 105;
	// 					}
	// 				}
	// 			}


	// 			// $pdf->writeHTMLCell('', '', '', '', $fotos[$i]["clasificacion"], '', 1, 0, true, 'L', false);
	// 			$pdf->SetFont('helvetica', '', 8);
	// 			$img_evidencia = '../../'.$fotos[$i]["ImgRecepcion"];

	// 			$pdf->Image($img_evidencia, $x, $y, $w, $h, '', '', '', true, 150, '', false, false, 0, false, false, false);

	// 			$pdf->writeHTMLCell($w, $hcomentario, $x, $ycomentario, $fotos[$i]["comentario"] , '', 2, 0, true, 'C', true);


	// 			$x += 100;

	// 		}

	// 	}
	// }



	//Close and output PDF document

	$pdf->Output('Recepcion.pdf', 'I');
}else{
	echo "Error";
}
