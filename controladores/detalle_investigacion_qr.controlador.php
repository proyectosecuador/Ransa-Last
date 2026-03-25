<?php
class ControladorDInvestigacionQR{
/*===========================================
=            INSERTAR NUEVA INVESTIGACION            =
===========================================*/
static public function ctrInsertarDInvestigacionQR($datos){
	$tabla = "detalle_investigacion_qr";

	$rpta = ModeloDInvestigacionQR::mdlInsertarDInvestigacionQR($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR LAS INVESTIGACION            =
=======================================*/

	static public function ctrConsultarDInvestigacionQR($item,$datos){
		$tabla = "detalle_investigacion_qr";

		$rpta = ModeloDInvestigacionQR::mdlConsultarDInvestigacionQR($tabla,$item,$datos);

		return $rpta;
	}

/*============================================================
=            ACTUALIZAR LA INVESTIGACION RELIZADA            =
============================================================*/
	static public function ctrActualizarDInvestigacionQR($item,$datos){
		$tabla = "detalle_investigacion_qr";

		$rpta = ModeloDInvestigacionQR::mdlActualizarDInvestigacionQR($tabla,$item,$datos);

		return $rpta;
	}



}