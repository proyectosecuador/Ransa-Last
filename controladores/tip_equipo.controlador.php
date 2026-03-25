<?php
class ControladorTEquipo{
/*===========================================
=            REGISTRO DE NUEVO TIPO DE EQUIPO            =
===========================================*/
public function ctrRegistroTequipo($dato){
	$tabla = "tipo_equipo";

	$rpta = ModeloTEquipo::mdlRegistroTEquipo($tabla,$dato);

	return $rpta;
}



/*=======================================
=            CONSULTAR TIPO DE EQUIPOS            =
=======================================*/

	static public function ctrConsultarTEquipo($dato,$item){
		$tabla = "tipo_equipo";

		$rpta = ModeloTEquipo::mdlConsultarTEquipo($tabla,$dato,$item);

		return $rpta;
	}
}