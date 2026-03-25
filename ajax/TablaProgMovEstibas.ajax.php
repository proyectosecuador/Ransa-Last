<?php
session_start();
require_once "../controladores/movi_R_D.controlador.php";
require_once "../modelos/movi_R_D.modelo.php";

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

require_once "../controladores/actividadE.controlador.php";
require_once "../modelos/actividadE.modelo.php";

require_once "../controladores/tipo_carga.controlador.php";
require_once "../modelos/tipo_carga.modelo.php";

require_once "../controladores/estibas.controlador.php";
require_once "../modelos/estibas.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

class AjaxTablaProgMovEstibas{
	/*=================================================
	=            CONSULTA DE EQUIPOS RANSA            =
	=================================================*/
	public function ajaxConsultarProgMovEstibas(){

		$datos = array("cuadrilla" => 'SI',
						"estado1" => 1,
						"estado2" => 2); 
		$item = array("cuadrilla" => "cuadrilla",
						"estado" => "estado");
		$rpta = ControladorMovRD::ctrConsultarMovRD($datos,$item);
		
		if (isset($rpta) && !empty($rpta)) {
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			================================================*/
	        $datosJson = '{
	  						"data": [';
	  		
	  		for ($i=0; $i < count($rpta) ; $i++) {
	  			/*==============================================
	  			=            CONSULTAMOS EL CLIENTE            =
	  			==============================================*/
	  			$rptacliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta[$i]["idcliente"]);

	  			/*===========================================
	  			=            CONSULTAR ACTIVIDAD            =
	  			===========================================*/
	  			if ($rpta[$i]["idactividad"] == "" || $rpta[$i]["idactividad"] == 0) {
	  				$rptaactividad = ""	;
	  			}else{
	  				$rptaactividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba",$rpta[$i]["idactividad"]);
	  				$rptaactividad = $rptaactividad["descripcion"];

	  			}
	  			
	  			/*====================================================
	  			=            CONSULTAMOS EL TIPO DE CARGA            =
	  			====================================================*/
	  			if ($rpta[$i]["idtipo_carga"] == "" || $rpta[$i]["idtipo_carga"] == 0) {
	  				$rptatipocarga = ""	;
	  			}else{
	  				$rptatipocarga = ControladorTCarga::ctrConsultarTCarga($rpta[$i]["idtipo_carga"],"idtipo_carga");
	  				$rptatipocarga = $rptatipocarga["descripcion"];
	  			}	  			
	  			



                
                  
	  			if ($rpta[$i]["idproveedor_estiba"] != "" || $rpta[$i]["idproveedor_estiba"] != NULL) {
	  				$boqueoselect = "disabled";
	  				$buttonedit = "<button data-toggle='tooltip' title='Cambiar Cuadrilla'  class='btn-sm btnEditarAsigCuadrilla btn btn-warning'><i class='fas fa-pencil-alt'></i></button>";
	  			}else{
	  				$boqueoselect = "";
	  				$buttonedit = "";
	  			}
                


	  			$acciones = "<div class='btn-group contenedorselecbutton'><select ".$boqueoselect." idmovimiento='".$rpta[$i]["idmov_recep_desp"]."' class=' btn selectbutton selectEstibaProg'><option value='Seleccionar una opción'>Seleccionar una opción</option>";
		                  $rptaestiba = ControladorEstibas::ctrConsultarEstibas($_SESSION["ciudad"],"idciudad");
		                  for ($j=0; $j < count($rptaestiba) ; $j++) {
		                    if ($rptaestiba[$j]["estado"] == 1) {
		                    	if ($rpta[$i]["idproveedor_estiba"] ==  $rptaestiba[$j]["idproveedor_estiba"]) {
		                    		$acciones .= "<option selected value='".$rptaestiba[$j]['idproveedor_estiba']."'>".$rptaestiba[$j]['nombre_proveedor']."</option>";
		                    	}else{
		                    		$acciones .= "<option value='".$rptaestiba[$j]['idproveedor_estiba']."'>".$rptaestiba[$j]['nombre_proveedor']."</option>";
		                    	}
		                     
		                    }                    
		                  }	  			
	  			$acciones .= "</select>".$buttonedit."</div>";

			// if ($rpta[$i]["estado"] == 1 || $rpta[$i]["estado"] == 2 ) {
				// if ($rptatipocarga == "AL GRANEL" || $rptaactividad == "REPALETIZADO") {
	  			/*=======================================================================
	  			=            CONSULTAMOS EL USUARIO QUE REALIZA LA SOLICITUD            =
	  			=======================================================================*/
	  			// $idciudad = 1;
	  			// if  ($rptacliente["razonsocial"] == "NEGOCIOS Y LOGISTICA NEGOLOGIC SA"){
	  			//     $rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosclientes","id",$rpta[$i]["idusuario"]);    
	  			// }else{
	  			    $rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rpta[$i]["idusuario"]);    
	  			    $idciudad = $rptaUsuario["idciudad"];
	  			// }
	  			
	  			$UserNombres = explode(" ",$rptaUsuario["primernombre"]);
	  			$UserApellidos = explode(" ",$rptaUsuario["primerapellido"]);
	  			
	  			if ($idciudad == $_SESSION["ciudad"] ) {
	  			
		  			$datosJson .= '
		    				    [';
						$datosJson .= '"'.$rpta[$i]["idmov_recep_desp"].'",
									  "'.$UserNombres[0]." ".$UserApellidos[0].'",
									  "'.date("Y-m-d",strtotime($rpta[$i]["fecha_programada"])).'",
									  "'.date("H:i:s",strtotime($rpta[$i]["fecha_programada"])).'",
									  "'.$rptacliente["razonsocial"].'",
									  "'.$rptaactividad.'",
									  "'.$rpta[$i]["comentarios"].'",
									  "'.date("H:i:s",strtotime($rpta[$i]["fecha_registrado"])).'",
									  "'.$acciones.'"';
			    	$datosJson .= '],';
			    	$valorexistente = true;	
				}			
			// }
	  			
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
$consultarProgMovEstibas = new AjaxTablaProgMovEstibas();
$consultarProgMovEstibas -> ajaxConsultarProgMovEstibas();



