<?php

class ControladorDocumentos{

	/*============================================
	=            INSERTAR DOCUMENTOS            =
	============================================*/
	static public function ctrInsertarDocumentos($datos){
		$tabla = "gestiondoc";

		$rpta = ModeloDocumentos::mdlInsertarDocumentos($tabla,$datos);

		return $rpta;
	}
	/*============================================
	=            CONSULTAR DOCUMENTOS            =
	============================================*/
	static public function ctrMostrarDocumentos($item,$datos){

		$tabla = "gestiondoc";

		$rpta = ModeloDocumentos::mdlMostrarDocumentos($tabla,$item,$datos);

		return $rpta;
	}

	static public function ctrActualizarDocumentos($item,$datos){
		$tabla = "gestionDoc";
		
		$rpta = ModeloDocumentos::mdlActualizarDocumentos($tabla,$item,$datos);

		return $rpta;
	}
	
	
	
	

}

