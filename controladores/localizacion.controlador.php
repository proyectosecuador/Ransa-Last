<?php
class ControladorLocalizacion{
/*===========================================
=            REGISTRO DE NUEVA LOCALIZACION            =
===========================================*/
public function ctrRegistroLocalizacion($dato){
	$tabla = "localizacion";

	$rpta = ModeloLocalizacion::mdlRegistrolocalizacion($tabla,$dato);

	return $rpta;
}



/*=======================================
=            CONSULTAR LOCALIZACION            =
=======================================*/

	static public function ctrConsultarLocalizacion($dato,$item){
		$tabla = "localizacion";

		$rpta = ModeloLocalizacion::mdlConsultarLocalizacion($tabla,$dato,$item);

		return $rpta;
	}
}