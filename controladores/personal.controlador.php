<?php

class ControladorPersonal{

	/*============================================
	=            INSERTAR PERSONAL            =
	============================================*/
	/*static public function ctrInsertarProveedores($datos){
		$tabla = "proveedores";

		$rpta = ModeloProveedores::mdlInsertarProveedores($tabla,$datos);

		return $rpta;
	}*/
	
	
	

	/*=============================================
	=            CONSULTAR PERSONAL            =
	=============================================*/
	
	static public function ctrConsultarPersonal($item,$datos){
		
		$tabla = "personal";

		$rpta = ModeloPersonal::mdlConsultarPersonal($tabla,$item,$datos);
		
		return $rpta;

	}
}

