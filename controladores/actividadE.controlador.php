<?php
class ControladorActividadE{
/*===========================================
=            INSERTAR ACTIVIDAD DE ESTIBA            =
===========================================*/
public function ctrInsertarActividadE($datos){
	$tabla = "actividad_estiba";

	$rpta = ModeloActividadE::mdlInsertarActividadE($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR ACTIVIDAD DE ESTIBA            =
=======================================*/

	static public function ctrConsultarActividadE($item,$datos){
		$tabla = "actividad_estiba";

		$rpta = ModeloActividadE::mdlConsultarActividadE($tabla,$item,$datos);

		return $rpta;
	}
}