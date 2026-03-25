<?php
require_once "../controladores/equipos.controlador.php";
require_once "../modelos/equipos.modelo.php";

session_start();
class AjaxTablaEquipos{
	/*=================================================
	=            CONSULTA DE EQUIPOS RANSA            =
	=================================================*/
	public function ajaxConsultarEquipos(){

		$rpta = ControladorEquipos::ctrConsultarEquipos($_SESSION["ciudad"],"idciudad");;
		if (isset($rpta) && !empty($rpta)) {
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			================================================*/
	        $datosJson = '{
	  						"data": [';
	  		
	  		for ($i=0; $i < count($rpta) ; $i++) {
			$acciones = "<div class='btn-group'><button type='button' data-toggle='modal' data-target='#modalEditarEquipo' idequipo='".$rpta[$i]['idequipomc']."' class='btn btn-sm btn-warning btnEditarEquipo'><i class='fas fa-pencil-alt'></i></button><button type='button' class=' btn btn-sm btn-info btnAsignarEquipo' data-toggle='modal' data-target='#modalAsignarEquipo' idequipo='".$rpta[$i]['idequipomc']."' ><i class='fa fa-user-plus'></i></button><button type='button' idequipoE='".$rpta[$i]['idequipomc']."' class=' btn btn-sm btn-danger btnEliminarEquipo'><i class='fa fa-times'></i></button></div>";

	  			$datosJson .= '
        				    [';
  				$datosJson .= '"'.$rpta[$i]['idequipomc'].'",
  							  "'.$rpta[$i]['fecha_regis'].'",
  							  "'.$rpta[$i]['valor_concatenado'].'",';
  				$datosJson .= '"'.$rpta[$i]['nom_eq'].'",
						      "'.$rpta[$i]['nom_localizacion'].'",
							  "'.$rpta[$i]['codigo_bateria'].'",';
		    	if ($_SESSION["perfil"] != "OPERATIVO") {
		    		$datosJson .= '"'.$rpta[$i]['estado'].'",';            
		    		$datosJson .= '"'.$acciones.'"';

		    	}else{
		    		$datosJson .= '"'.$rpta[$i]['estado'].'"';
		    	}
								
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
	$consultaEquipo = new AjaxTablaEquipos();
	$consultaEquipo -> ajaxConsultarEquipos();
}


