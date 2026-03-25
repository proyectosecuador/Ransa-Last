<?php

require_once "../controladores/personal.controlador.php";
require_once "../modelos/personal.modelo.php";
session_start();

class AjaxPersonal{
	public $_nombre;
	public $_codigo;
	
	public function ajaxmostrarPersonal(){

		$item = "nombres_apellidos";
		$rpta = ControladorPersonal::ctrConsultarPersonal($item,$this->_nombre);

		if ($rpta["codigo_sistema"] == $this->_codigo) {
			echo '{"resultado":"Códido Correcto..","nombres":"'.$rpta["nombres_apellidos"].'"}';
		}else{
			echo '{"resultado":"Códido Incorrecto..","nombres":"'.$rpta["nombres_apellidos"].'"}';
		}
		
	}
	/*================================================================================
	=            VALIDAMOS EL NOMBRE AL MOMENTO DE GUARDAR LA INFORMACION            =
	================================================================================*/
	public function ajaxmostrarvalidPersonal(){

		$item = "nombres_apellidos";
		$rpta = ControladorPersonal::ctrConsultarPersonal($item,$this->_nombre);
		if ($rpta) {
			if ($rpta["nombres_apellidos"] == $this->_nombre) {
				echo '{"resultado":"Nombre Correcto.."}';
			}else{
				echo '{"resultado":"Nombre Incorrecto.."}';
			}
		}else{
			echo '{"resultado":"Nombre no registrado"}';
		}

		
	}
	
	


}

if (isset($_GET['nombre'])) {
	$objeto = new AjaxPersonal();
	$objeto -> _nombre = $_GET['nombre'];
	$objeto -> _codigo = $_GET['codigo'];
	$objeto ->ajaxmostrarPersonal();
}
if (isset($_GET['validnombre'])) {
	$objeto = new AjaxPersonal();
	$objeto -> _nombre = $_GET['validnombre'];
	$objeto ->ajaxmostrarvalidPersonal();
}

