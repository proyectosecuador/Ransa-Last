<?php
class ControladorCentroCosto{
/*===========================================
=            REGISTRO DE NUEVA CENTRO DE COSTO            =
===========================================*/
public function ctrRegistroCentroCosto($dato){
	$tabla = "centro_costo";

	$rpta = ModeloCentroCosto::mdlRegistroCentroCosto($tabla,$dato);

	return $rpta;
}



/*=======================================
=            CONSULTAR CENTRO DE COSTO            =
=======================================*/

	static public function ctrConsultarCentroCosto($dato,$item){
		$tabla = "centro_costo";

		$rpta = ModeloCentroCosto::mdlConsultarCentroCosto($tabla,$dato,$item);

		return $rpta;
	}
}