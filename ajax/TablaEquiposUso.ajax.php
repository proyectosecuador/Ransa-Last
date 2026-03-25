<?php
require_once "../controladores/manejoeq.controlador.php";
require_once "../modelos/manejoeq.modelo.php";

require_once "../controladores/personal.controlador.php";
require_once "../modelos/personal.modelo.php";

require_once "../controladores/equipos.controlador.php";
require_once "../modelos/equipos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

session_start();
class AjaxTablaEquiposUso{
	/*=================================================
	=            CONSULTA DE EQUIPOS RANSA            =
	=================================================*/
	public function ajaxConsultarEquiposUso(){
		/*=========================================================================================================
		=            CONSULTAMOS EL USO DE LOS EQUIPOS DONDE EL ESTADO INDIQUE QUE SE ENCUENTRA EN USO            =
		=========================================================================================================*/
		$datos = array("estado" => 2);
		$item = array("estado" => "estado");		
		$rpta = ControladorManejoeq::ctrConsultarManejoeq($item,$datos);
		
		if (isset($rpta) && !empty($rpta)) {
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			================================================*/
	        $datosJson = '{
	  						"data": [';
	  		
	  		for ($i=0; $i < count($rpta) ; $i++) {

				/*================================================================
				=            OBTENER DATOS DEL PERSONAL QUE USA EL EQ            =
				================================================================*/
				$item = "idpersonal";
				$valor = $rpta[$i]["idpersonal"];
				$rptapersonal = ControladorPersonal::ctrConsultarPersonal($item,$valor);

				/*=================================================
				=            OBTENER DATOS DEL EQUIPO             =
				=================================================*/
				$itemequipo = "idequipomc";
				$valorequipo = $rpta[$i]["idequipo"];
				$rptaequipo = ControladorEquipos::ctrConsultarEquipos($valorequipo,$itemequipo);
				/*=======================================================
				=            USUARIO QUIEN HACE LA SOLICITUD            =
				=======================================================*/
				$tabla = "usuariosransa";
				$itemuser = "id";
				$valoruser = $rpta[$i]["idusuario"];
				$rptauser = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$itemuser,$valoruser);
				
			

			$acciones = "<div class='btn-group'><button type='button' idmanejo='".$rpta[$i]['idmanejoeq']."' horoinicial='".$rpta[$i]['horometroinicial']."' nombre='".$rptapersonal['nombres_apellidos']."' class='btn btn-sm btn-primary btnTerminarUso'><i class='fas fa-sign-out-alt'></i></button></div>";

			/*==========================================================
			=            COLOCAR LAS OBSERVACIONES DE ITEMS            =
			==========================================================*/
			$concatenaritems ="";
			if ($rpta[$i]["opc1"] != "0") {
				$concatenaritems .= "1.===> ".$rpta[$i]["opc1"]."<br>";
			}
			if ($rpta[$i]["opc2"] != "0") {
				$concatenaritems .= "2.===> ".$rpta[$i]["opc2"]."<br>";
			}
			if ($rpta[$i]["opc3"] != "0") {
				$concatenaritems .= "3.===> ".$rpta[$i]["opc3"]."<br>";
			}
			if ($rpta[$i]["opc4"] != "0") {
				$concatenaritems .= "4.===> ".$rpta[$i]["opc4"]."<br>";
			}
			if ($rpta[$i]["opc5"] != "0") {
				$concatenaritems .= "5.===> ".$rpta[$i]["opc5"]."<br>";
			}
			if ($rpta[$i]["opc6"] != "0") {
				$concatenaritems .= "6.===> ".$rpta[$i]["opc6"]."<br>";
			}
			if ($rpta[$i]["opc7"] != "0") {
				$concatenaritems .= "7.===> ".$rpta[$i]["opc7"]."<br>";
			}			
			
			
			
			
			if ($rpta[$i]["estado"] == 2 && $rptaequipo[0]["idciudad"] == $_SESSION["ciudad"]) {
	  			$datosJson .= '
        				    [';
  				$datosJson .= '"'.$rpta[$i]['idmanejoeq'].'",
  							"'.$rptaequipo[0]["codigo"] .'",
  							"'.$rptapersonal['nombres_apellidos'].'",
  							  "'.$rpta[$i]['fecha_inicio'].'",';	    							  
  				   				if ($_SESSION["perfil"] == "ADMINISTRADOR") {
  				   					$datosJson .= '"'.$rptauser['primernombre']." ".$rptauser['primerapellido'].'",';
  								}

  				$datosJson .= '"'."BATERIA #".$rpta[$i]["identbateriainicio"] .'",
				              "'.$rpta[$i]["codigo_bateria"].'",
							  "'.$rptaequipo[0]["codigo_bateria"].'",
						      "'.$rpta[$i]["porcentcargainicio"]."%".'",
							  "'.$rpta[$i]["horometroinicial"].'",';
  				   				if ($_SESSION["perfil"] == "ADMINISTRADOR") {
  				   					$datosJson .='"'.$concatenaritems.'",';
  								}
				$datosJson .='"'.$rpta[$i]["observaciones"].'",
							  "'.$acciones.'"';
		    	$datosJson .= '],';	
		    	$valorexistente = true;
			}
	  			
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
	$consultaEquipouso = new AjaxTablaEquiposUso();
	$consultaEquipouso -> ajaxConsultarEquiposUso();
}


