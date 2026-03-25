<?php
require_once "../controladores/movi_R_D.controlador.php";
require_once "../modelos/movi_R_D.modelo.php";

require_once "../controladores/checklisttrans.controlador.php";
require_once "../modelos/checklisttrans.modelo.php";

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

require_once "../controladores/actividadE.controlador.php";
require_once "../modelos/actividadE.modelo.php";

session_start();

class AjaxTablaOTEstibas{
	/*=================================================
	=            CONSULTA DE RECEPCION DE CONTENEDORES            =
	=================================================*/
	public function ajaxConsultarOTEstibas(){

		/*=========================================================================================================
		=            CONSULTAMOS LAS RECEPCIONES DE CONTENEDORES REGISTRADAS            =
		=========================================================================================================*/
		$item = array("idproveedor_estiba" => "idproveedor_estiba");
			$rpta = ControladorMovRD::ctrConsultarMovRD($_SESSION["id"],$item);

		if (isset($rpta) && !empty($rpta)) {
			
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			 ================================================*/
	        $datosJson = '{
	  						"data": [';
	  		
	  		for ($i=0; $i < count($rpta) ; $i++) {
								$botonvisualizar ="";
								$botondescarga = "";
								$texto =$rpta[$i]["estado"];
				  				if ($rpta[$i]["estado"] == "APROBADO") {
									  $texto = "";
				  					$botonvisualizar ="<button idmov_recep_desp='".$rpta[$i]["idmov_recep_desp"]."' class='btn btn-sm btn-default btnVisualizarEstiba' data-toggle='modal' data-target='.modalVisualEstiba'><i class='fas fa-eye'></i></button>";
				  					$botondescarga = "<form method='POST' target='_blank' action='".htmlspecialchars('bpa/Estiba/pdfReportEstiba.php')."' class='btn-group'> <input type='hidden' value='".$rpta[$i]['idmov_recep_desp']."' name='idmov'><button type='submit' class='btn btn-sm btn-default '><i class='fas fa-file-pdf'></i></button></form>";
				  				}




				  				/*===================================================================
				  				=            ACCIONES QUE SE PUEDEN REALIZAR EN LA TABLA            =
				  				===================================================================*/ 	  				
								$acciones = "<div class='btn-group'>".$texto.$botonvisualizar.$botondescarga."</div> ";  				

								$datosJson .= '
								[';
					  $datosJson .= '"'.date("d-m-Y",strtotime(trim($rpta[$i]["fecha_programada"]))).'",
									"'.trim($rpta[$i]["razonsocial"]).'",';
					  $datosJson .= '"'.trim($rpta[$i]["descripcion"]).'",';
					  $datosJson .= '"'.trim($rpta[$i]["comentarios"]).'",';
					  $datosJson .= '"'.trim($rpta[$i]["codigo_generado"]).'",';
					  $datosJson .= '"'.trim($rpta[$i]["nguias"]).'",';
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
	$consultOTEstibas = new AjaxTablaOTEstibas();
	$consultOTEstibas -> ajaxConsultarOTEstibas();
}


