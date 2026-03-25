<?php
class ControladorCheckTransporte{
/*===========================================
=            INSERTAR CHECK LIST TRANSPORTE NUEVA            =
===========================================*/
static public function ctrInsertarCheckTransporte($datos){
	$tabla = "chcklsttrans";

	$rpta = ModeloCheckTransporte::mdlInsertarCheckTransporte($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR CHECK LIST TRANSPORTE            =
=======================================*/

	static public function ctrConsultarCheckTransporte($item,$datos){
		$tabla = "chcklsttrans";

		$rpta = ModeloCheckTransporte::mdlConsultarCheckTransporte($tabla,$item,$datos);

		return $rpta;
	}

	/*==========================================================================
	=            ACTUALIZAR CHECK LIST TRANSPORTE            =
	==========================================================================*/
	static public function ctrActualizarCheckTransporte($item,$datos){
		
		$tabla = "chcklsttrans";

		$rpta = ModeloCheckTransporte::mdlActualizarCheckTransporte($tabla,$item,$datos);
		
		return $rpta;		
	}	

/*==========================================================================
	=            INSERCION DE PREGUNTAS PARA CHECKLIST TRANSPORTE           =
	==========================================================================*/

	static public function ctrInsertarCheckCompleto($datos){
    $tabla = "chcklsttrans";
    return ModeloCheckTransporte::mdlInsertarCheckCompleto($tabla, $datos);
}
}