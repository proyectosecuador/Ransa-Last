<?php
session_start();
require_once "../controladores/checklistbpa.controlador.php";

require_once "../modelos/checklistbpa.modelo.php";


require_once "../modelos/rutas.php";







class AjaxTablaCheckBpa{

	public $perfil;

	public $idciudad;



	public function ajaxConsultarListCheckBpa(){

		/*=======================================================================

		=            CONSULTAR LOS CHECK LIST DE BPA SEGUN LA CIUDAD            =

		=======================================================================*/

		$rpta = ControladorCheckListBpa::ctrConsultarCheckListBpa($this->idciudad,"idciudad");

		if ($rpta) {

			/*================================================

			=            CONVERTIMOS A DATOS JSON            =

			================================================*/

			$datosJson = '{

	  			"data": [';

  			/*=================================================================

  			=            OBTENER EL PORCENTAJE GLOBAL QUE OBTIENEN            =

  			=================================================================*/





	  		for ($i=0; $i < count($rpta) ; $i++) {

	  			/*===========================================

	  			=            BOTONES DE ACCIONES            =

	  			===========================================*/

	  			$url = Ruta::ctrRuta();

	  			$acciones = "<div class='btn-group'><form method='POST' action='".$url."bpa/generarpdf.php' class='btn-group' target='_blank'> <input type='hidden' value='".$rpta[$i]["idchcklstbpa"] ."' name='idcheckbpa' > <button type='submit' class='btn btn-default' ><i class='fas fa-file-pdf'></i></button></form></div>";



					$cliente = is_null($rpta[$i]['razonsocial']) ? 'GENERAL' : $rpta[$i]['razonsocial'];
					$datosJson .= '

	        				    [';

	  				$datosJson .= '"'.$rpta[$i]['idchcklstbpa'].'",

	  							  "'.$rpta[$i]['fecha_reg'].'",

	  							  "'.$cliente.'",

	  							  "'.$rpta[$i]['usuario'].'",';

	  				$datosJson .= '"'.$rpta[$i]['observaciones'].'",';

	  				$datosJson .= '"'.$rpta[$i]['porcentaje_global'].' %",';

	  				$datosJson .= '"'.$acciones.'"';

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



if (isset($_SESSION['perfil'])) {

	$tablanovedades = new AjaxTablaCheckBpa();

	$tablanovedades -> perfil = $_SESSION['perfil'];

	$tablanovedades -> idciudad = $_SESSION['ciudad'];

	$tablanovedades -> ajaxConsultarListCheckBpa();

}



	





