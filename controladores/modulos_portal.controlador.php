<?php
class ControladorModulosPortal{
/*===========================================
=            REGISTRO DE MODULOS DEL PORTAL            =
===========================================*/
/*public function ctrRegistroTequipo($dato){
	$tabla = "tipo_equipo";

	$rpta = ModeloTEquipo::mdlRegistroTEquipo($tabla,$dato);

	return $rpta;
}*/



/*=======================================
=            CONSULTAR MODULOS DEL PORTAL            =
=======================================*/

	static public function ctrConsultarModulosPortal($dato,$item){
		$tabla = "modulos_portal";

		$rpta = ModeloModulosPortal::mdlConsultarModulosPortal($tabla,$dato,$item);

		return $rpta;
	}
}