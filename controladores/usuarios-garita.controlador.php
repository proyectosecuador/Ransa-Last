<?php
class ControladorUserGarita{


/*=======================================
=            CONSULTAR USUARIOS RESPONSABLES POR NEGOCIO            =
=======================================*/

	static public function ctrConsultarUserGarita($item,$datos){
		$tabla = "usuarios_garita";

		$rpta = ModeloUserGarita::mdlConsultarUserGarita($tabla,$item,$datos);

		return $rpta;
	}
}