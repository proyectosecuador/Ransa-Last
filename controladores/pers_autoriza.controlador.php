<?php
class ControladorPersAutoriza{
/*===========================================
=            INSERTAR PERSNAL QUE AUTOIZA            =
===========================================*/
public function ctrInsertarPersAutoriza($datos){
	$tabla = "pers_autoriza";

	$rpta = ModeloPersAutoriza::mdlInsertarPersAutoriza($tabla,$datos);

	return $rpta;
}



/*=======================================
=            CONSULTAR PERSNAL QUE AUTOIZA            =
=======================================*/

	static public function ctrConsultarPersAutoriza($item,$datos){
		$tabla = "pers_autoriza";

		$rpta = ModeloPersAutoriza::mdlConsultarPersAutoriza($tabla,$item,$datos);

		return $rpta;
	}
}