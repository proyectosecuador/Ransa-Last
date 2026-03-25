<?php

class ControladorClientes{

	static public function ctrmostrarClientes($item,$valor){
		
		$tabla = "clientes";

		$rpta = ModeloClientes::mdlmostrarClientes($tabla,$item,$valor);
		
		return $rpta;

	}
}

