<?php
class ControladorCiudad{
/*===========================================
=            REGISTRO DE NUEVA CIUDAD            =
===========================================*/
public function ctrRegistroCiudad($dato){
	$tabla = "ciudad";

	$rpta = ModeloCiudad::mdlRegistroCiudad($tabla,$dato);

	return $rpta;
}



/*=======================================
=            CONSULTAR CIUDADES            =
=======================================*/

	static public function ctrConsultarCiudad($item,$valor){
		$tabla = "ciudad";

		$rpta = ModeloCiudad::mdlConsultarCiudad($tabla,$item,$valor);

		return $rpta;
	}
}