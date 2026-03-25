<?php
session_start();
require_once "../controladores/checklisttrans.controlador.php";
require_once "../modelos/checklisttrans.modelo.php";

class AjaxTablaCheckTransporte{
	/*=================================================
	=            CONSULTA DE RECEPCION DE CONTENEDORES            =
	=================================================*/
	public function ajaxConsultarCheckTrans(){
		/*=========================================================================================================
		=            CONSULTAMOS LAS RECEPCIONES DE CONTENEDORES REGISTRADAS            =
		=========================================================================================================*/
		$datos = array("idciudad" => $_SESSION["ciudad"]);
		if ($_SESSION["perfil"] == "OPERATIVO") {
			array_push($datos,['idusuario' => $_SESSION["id"]]);
		}
		$rpta = ControladorCheckTransporte::ctrConsultarCheckTransporte("idciudad",$datos);

		
		if (isset($rpta) && !empty($rpta)) {
			
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			 ================================================*/
	        $datosJson = '{
	  						"data": [';

	  		for ($i=0; $i < count($rpta) ; $i++) { 

				/*===================================================================
				=            ACCIONES QUE SE PUEDEN REALIZAR EN LA TABLA            =
				===================================================================*/	  			
				$acciones = "<div class='btn-group'><form method='POST' target='_blank' action='".htmlspecialchars('bpa/Transporte/pdfRecepcion.php')."' class='btn-group'> <input type='hidden' value='".$rpta[$i]['idchcklsttrans']."' name='idchecktrans'><button type='submit' class='btn btn-sm btn-default '><i class='fas fa-file-pdf'></i></button></form></div> ";

				$datosJson .= '
							[';
				
				$datosJson .= '"'.trim($rpta[$i]["idchcklsttrans"]).'",
				               "'.trim($rpta[$i]["fecha_programada"]).'",
								"'.trim($rpta[$i]["razonsocial"]).'",';
				 $datosJson .= '"'.trim($rpta[$i]["nguias"]).'",';				
				$datosJson .= '"'.trim($rpta[$i]['descripcion']).'",
								"'.trim($rpta[$i]['realizadopor']).'",';
				$datosJson .= '"'.trim($acciones).'"';
				$datosJson .= '],';
				$valorexistente = true;	  							

		  		}

        	$datosJson = substr($datosJson,0,-1);
        	if (!isset($valorexistente)) {
        		$datosJson .= '[';
        	}

        	$datosJson .= ']
        	}';
        	echo $datosJson;	  		
		}else{
			echo $datosJson = '{
  					"data": []}';
		}
	}
}
/*===========================================
=            CONSULTA DE EQUIPOS            =
===========================================*/
if (isset($_SESSION['id'])) {
	$consultCheck = new AjaxTablaCheckTransporte();
	$consultCheck -> ajaxConsultarCheckTrans();
}


