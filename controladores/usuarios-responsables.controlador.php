<?php
class ControladorUserResponsable{


/*=======================================
=            CONSULTAR USUARIOS RESPONSABLES POR NEGOCIO            =
=======================================*/

	static public function ctrConsultarUserResponsable($item,$datos){
		$tabla = "responsable_servicio";

		$rpta = ModeloUserResponsable::mdlConsultarUserResponsable($tabla,$item,$datos);

		return $rpta;
	}
}