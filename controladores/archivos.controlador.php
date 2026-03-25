<?php

class ControladorArchivos{

	static public function ctrInserArchivos($datos){
		$tabla = "archivos";

		$rpta = ModeloArchivos::mdlInserArchivos($tabla,$datos);
		
		return $rpta;

	}

	static public function ctrMostrarInventExcel($valor,$item){
		$tabla = "archivos";

		$rpta = ModeloArchivos::mdlMostrarInventExcel($tabla,$item,$valor);
		
		return $rpta;

	}
	/*=================================================================================================
	=            ACTUALIZAR EL VALOR ENCRIPTADO DEL ARCHIVO DEL INVENTARIO QUE SE NOTIFICA            =
	=================================================================================================*/
	static public function ctrActualizarArchivo($valor,$item){
		$tabla = "archivos";
		$rpta = ModeloArchivos::mdlActualizarArchivo($tabla,$valor,$item);
		
		return $rpta;

	}	
	
	
	
}
