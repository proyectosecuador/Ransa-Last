<?php
session_start();

require_once "../controladores/checklist.controlador.php";

require_once "../modelos/checklist.modelo.php";




class AjaxTablaConsultaCheckEquipo{

		public $_mes;
		public $_idequipomc;

	/*=================================================

	=            CONSULTA DE CHECK LIST REALIZADOS            =

	=================================================*/

	public function ajaxCheckRealizados(){
		$datos =array("valor1" => $this->_mes,
					  "valor2" => $this->_idequipomc == 'Seleccionar una opción' ? '' : $this->_idequipomc,
					  "valor3" => $_SESSION['ciudad']);
		$items = array("item1" => "fecha",
					   "item2" => "idequipomc");

		$rpta = ControladorCheckList::ctrConsultarCheckResult($datos,$items);

		if (isset($rpta)) {
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			================================================*/
	        $datosJson = '{
	  						"data": [';			

	  		for ($i=0; $i < count($rpta) ; $i++) {
	  			/*================================================
	  			=            OBTENER DATOS DEL EQUIPO            =
	  			================================================*/
				// $itemequipo = "idequipomc";
				// $valorequipo = $rpta[$i]["idequipomc"];
				// $rptaequipo = ControladorEquipos::ctrConsultarEquipos($valorequipo,$itemequipo);
				/*=============================================
				=            ESTADO DE CHECKL LIST            =
				=============================================*/
				// if ($rpta[$i]["estado"] == 1) {
				// 	$estado = "<span style= 'font-size: 13px' class='label label-success'>CUMPLIDO</span>";	
				// }else if ($rpta[$i]["estado"] == 2) {
				// 	$estado = "<span style= 'font-size: 13px' class='label label-warning'>ATRASO</span>";	
				// }else if ($rpta[$i]["estado"] == 3) {
				// 	$estado = "<span style= 'font-size: 13px' class='label label-warning'>NO CUMPLE</span>";	
				// }else if ($rpta[$i]["estado"] == 4) {
				// 	$estado = "<span style= 'font-size: 13px' class='label label-info'>NO OPERATIVO</span>";
				// }
				$estado = "<span style= 'font-size: 13px' class='label label-info'>".$rpta[$i]["estado"]."</span>";
				/*======================================================
				=            MOTIVO ATRASO O MOTIVO BLOQUEO            =
				======================================================*/
				// if ($rpta[$i]['motivoatraso'] == null) {
				// 	$justificacion = $rpta[$i]['motivo_bloqueo'];
				// }else if ($rpta[$i]['motivo_bloqueo'] == null) {
				// 	$justificacion = $rpta[$i]['motivoatraso'];
				// }else{
				// 	$justificacion = $rpta[$i]['motivoatraso']."---".$rpta[$i]['motivo_bloqueo'] ;
				// }

				/*=============================================================
				=            RESPONASBLE DE REALIZAR EL CHECK LIST            =
				=============================================================*/
				// $itemasignacion = "ideasignacion";
				// $rptaresponsable = ControladorEquipos::ctrConsultarAsignacionEquipos($rpta[$i]["ideasignacion"],$itemasignacion);
				
				
				
				
				
				
				
				

			// if ($rptaequipo[0]["idciudad"] == $_SESSION["ciudad"]) {
	  			$datosJson .= '
        				    [';
  				$datosJson .= '"'.$rpta[$i]['idchcklstq'].'",
  							  "'.$rpta[$i]["codigo"].'",';
  				$datosJson .= '"'.$rpta[$i]['fecha'].'",';
  				$datosJson .= '"'.$rpta[$i]["responsable"].'",
  							  "'.$rpta[$i]['horometro'].'",
						      "'.$rpta[$i]['justificacion'].'",
							  "'.$rpta[$i]['estado'].'"';
		    	$datosJson .= '],';	
		    	$valorexistente = true;


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

/*===========================================

=            CONSULTA DE LISTADO DE CHECK LIST REALIZADOS            =

===========================================*/

if (isset($_SESSION['id'])) {

	$consultaCheckListR = new AjaxTablaConsultaCheckEquipo();

	if (isset($_POST["mes"])) {

		$consultaCheckListR -> _mes = $_POST["mes"];

	}else{
		$consultaCheckListR-> _mes = "";

	}
	if (isset($_POST["idequipocHECK"])) {

		$consultaCheckListR -> _idequipomc = $_POST["idequipocHECK"];

	}else{
		$consultaCheckListR-> _idequipomc = "";

	}


	$consultaCheckListR-> ajaxCheckRealizados();

}


