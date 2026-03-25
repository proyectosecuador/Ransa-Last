<?php

require_once "../controladores/areas.controlador.php";
require_once "../modelos/areas.modelo.php";

class AjaxArea{

	public $nombre;

	public function ajaxIngresarArea(){
		$nombrenuevo = $this->nombre;

		$rpta = ControladorAreas::ctrInsertarArea($nombrenuevo);
		if ($rpta == "ok") {
			echo 1;
		}else{
			echo 2;
		}


	}
}

if (isset($_POST['nuevaArea'])) {
	$insertarArea = new AjaxArea();
	$insertarArea -> nombre = $_POST['nuevaArea'];
	$insertarArea -> ajaxIngresarArea();
}