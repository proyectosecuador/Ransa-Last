<?php

class ControladorProveedores{

	/*============================================
	=            INSERTAR PROVEEDORES            =
	============================================*/
	static public function ctrInsertarProveedores($datos){
		$tabla = "proveedores";

		$rpta = ModeloProveedores::mdlInsertarProveedores($tabla,$datos);

		return $rpta;
	}
	
	
	

	/*=============================================
	=            CONSULTAR PROVEEDORES            =
	=============================================*/
	
	static public function ctrConsultarProveedores($item,$datos){
		
		$tabla = "proveedores";

		$rpta = ModeloProveedores::mdlConsultarProveedores($tabla,$item,$datos);
		
		return $rpta;

	}
}

