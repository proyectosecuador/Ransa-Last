<?php

class ControladorDetalleCRQR{

	/*==========================================================
	=            INGRESAR DETALLE DE DOC CAUSA RAIZ            =
	==========================================================*/
	static public function ctrIgresarDetalle($datos){
	
		$tabla = "detalle_analisisqr";

		$rpta = ModeloDetalleCRQR::mdlIgresarDetalle($tabla,$datos);
		
		return $rpta;

	}
	
	
	
	
	
}

