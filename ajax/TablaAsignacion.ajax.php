<?php
require_once "../controladores/equipos.controlador.php";
require_once "../modelos/equipos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
session_start();
class AjaxTablaAsignacion{

	/*=========================================================
	=            CONSULTAR ASIGNACION POR CIUDAD            =
	=========================================================*/
	public $idciudad;

	public function ajaxConsultaAsignacion(){
		$id = $this->idciudad;
/*================================================================================================================
=            CONSULTAMOS LA ASIGNACION DE EQUIPOS SEGUN EQUIPO Y WHERE CIUDAD / ESTADO DE EASIGNACION            =
================================================================================================================*/
	    $rpta = ControladorEquipos::ctrConsultarAsignacionEquipos($id,"idciudad");
    	
    	if (isset($rpta) && !empty($rpta)) {

        $datosJson = '{
  						"data": [';

        	for ($i=0; $i < count($rpta) ; $i++) {

        		/*=========================================================
        		=            CONSULTAMOS EL USUARIO SUPERVISOR            =
        		=========================================================*/
        		// $rptasupervisor = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rpta[$i]["idusuariosransa"]);
        		$nombres = explode(" ", $rpta["primernombre"]);
        		$apellido = explode(" ",$rpta["primerapellido"]);
        		
        		
	              
	              /*===================================================
	              =            ACCIONES DEL INVENTARIO            =
	              ===================================================*/	              
  			// $acciones = "<div class='btn-group'><button type='button' id=".$rpta[$i]['ideasignacion']." class='btn btn-primary btnEditarAsignacion' data-toggle='modal' data-target='#modalEditarProducto'><i class='fas fa-user-edit'></i></button></div>";

  			/*=====================================================
  			=            PRESENTAR DATOS EN LA TABLA            =
  			=====================================================*/
  			  		$datosJson .= '
        				    [';
  					$datosJson .= '"'.$rpta[$i]["ideasignacion"].'",
  							  "'.$nombres[0]." ".$apellido[0].'",
						      "'.$rpta[$i]['codigo'].'",
						      "'.$rpta[$i]['turno'].'",
						      "'.$rpta[$i]['responsable'].'",
						      "'.$rpta[$i]['llave'].'"';
					$datosJson .= '],';

        	}

        	$datosJson = substr($datosJson,0,-1);

        	$datosJson .= ']
        	}';

        	echo $datosJson;
		}else{
			 echo $datosJson = '{
  						"data": []}';

		}
	}




}
/*=================================================
=            ACTIVAR TABLA DEL CLIENTE            =
=================================================*/
if (isset($_SESSION['ciudad'])) {
	$asignacionEq = new AjaxTablaAsignacion();
	$asignacionEq-> idciudad = $_SESSION['ciudad'];
	$asignacionEq->ajaxConsultaAsignacion();
}






