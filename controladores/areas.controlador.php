<?php
class ControladorAreas{
/*===========================================
=            INSERTAR AREA NUEVA            =
===========================================*/
public function ctrInsertarArea($datos){
	$tabla = "areas";

	$rpta = ModeloAreas::mdlInsertarArea($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR AREAS            =
=======================================*/

	static public function ctrConsultarAreas($item,$valor){
		$tabla = "areas";

		$rpta = ModeloAreas::mdlConsultarAreas($tabla,$item,$valor);

		return $rpta;
	}
}