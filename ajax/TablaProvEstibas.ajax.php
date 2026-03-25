<?php
require_once "../controladores/estibas.controlador.php";
require_once "../modelos/estibas.modelo.php";

class AjaxTablaEstibas{
	/*=================================================
	=            CONSULTA DE EQUIPOS RANSA            =
	=================================================*/
	public function ajaxConsultarEstibas(){

		$rpta = ControladorEstibas::ctrConsultarEstibas("","");
		
		if (isset($rpta) && !empty($rpta)) {
			/*================================================
			=            CONVERTIMOS A DATOS JSON            =
			================================================*/
	        $datosJson = '{
	  						"data": [';
	  		
	  		for ($i=0; $i < count($rpta) ; $i++) {
		
			

			$acciones = "<div class='btn-group'><button type='button' data-toggle='modal' data-target='.modalEditarProvEstibas' idestibas='".$rpta[$i]['idproveedor_estiba']."' class='btn btn-sm btn-warning btnEditarProvEstibas'><i class='fas fa-pencil-alt'></i></button><button type='button' idestibas='".$rpta[$i]['idproveedor_estiba']."' class=' btn btn-sm btn-danger btnEliminarProvEstibas'><i class='fa fa-times'></i></button></div>";

			if ($rpta[$i]["estado"] != 0) {
	  			$datosJson .= '
        				    [';
  				$datosJson .= '"'.$rpta[$i]['nombre_proveedor'].'",
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
$consultaEstibas = new AjaxTablaEstibas();
$consultaEstibas -> ajaxConsultarEstibas();



