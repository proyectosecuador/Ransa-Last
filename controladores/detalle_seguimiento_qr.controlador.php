<?php
class ControladorDSeguimientoQR{
/*===========================================
=            INSERTAR SEGUIMIENTO            =
===========================================*/
static public function ctrInsertarDSeguimientoQR($datos){
	$tabla = "detalle_seguimiento_qr ";

	$rpta = ModeloDSeguimientoQR::mdlInsertarDSeguimientoQR($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR SEGUIMIENTO            =
=======================================*/

	static public function ctrConsultarDSeguimientoQR($item,$datos){
		$tabla = "detalle_seguimiento_qr ";

		$rpta = ModeloDSeguimientoQR::mdlConsultarDSeguimientoQR($tabla,$item,$datos);

		return $rpta;
	}

/*============================================================
=            ACTUALIZAR SEGUIMIENTO            =
============================================================*/
	static public function ctrActualizarDSeguimientoQR($item,$datos){
		$tabla = "detalle_seguimiento_qr ";

		$rpta = ModeloDSeguimientoQR::mdlActualizarDSeguimientoQR($tabla,$item,$datos);

		return $rpta;
	}



}