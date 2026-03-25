<?php
require_once "../controladores/urlplataforma.controlador.php";
require_once "../modelos/urlplataforma.modelo.php";

class AjaxUrlPlataformas{

	public $nombre;
	public $url;
	public $usuarios;
	public $idurlplataforma;
	/*===================================================
	=            INSERTAR UN NUEVO LINk O URL            =
	===================================================*/
	public function ajaxInsertarLink(){
		$nom = $this->nombre;
		$link = $this->url;
		$usuario = $this->usuarios;

		$datos = array("nombre" =>$nom,
						"url" => $link,
						"usuarios" => $usuario );
		$rpta = ControladorUrlPlataformas::ctrinsertarUrl($datos);
		if ($rpta == "ok") {
				echo 1;			
			
		}else{
			echo 2;
		}
	}
	/*====================================================
	=            CAMBIAR EL ESTADO DEL BUTTON            =
	====================================================*/

	public function ajaxEstadoBoton(){
		$id = $this->idurlplataforma;

		$rpta = ControladorUrlPlataformas::ctrEstadoBoton($id,1);
		if ($rpta == "ok") {
				echo 1;			
			
		}else{
			echo 2;
		}

	}
	/*====================================================
	=            CAMBIO DE ESTADO BTN GENERAL            =
	====================================================*/
	public function ajaxEstadoGral(){
		
		$rpta = ControladorUrlPlataformas::ctrEstadoGral();
		if ($rpta == "ok") {
				echo 1;			
			
		}else{
			echo 2;
		}


	}
	
	
	
}
/*===============================================
=            INSERTAR UNA NUEVA URL             =
===============================================*/
if (isset($_POST["urlnueva"])) {
	$insertar = new AjaxUrlPlataformas();
	$insertar-> nombre = $_POST['nombre'];
	$insertar-> url = $_POST['urlnueva'];
	$insertar-> usuarios = $_POST['usuarios'];
	$insertar -> ajaxInsertarLink();	
}
/*===================================================
=            CAMBIAR EL ESTADO DEL BOTON            =
===================================================*/
if (isset($_POST["estadobtn"])) {
	$estadoboton = new AjaxUrlPlataformas();
	$estadoboton -> idurlplataforma = $_POST["estadobtn"];
	$estadoboton->ajaxEstadoBoton();
}
/*====================================================
=            CAMBIAR EL ESTADO BTN EN GENERAL            =
====================================================*/
if (isset($_POST["estadobtngral"])) {
	$estgral = new AjaxUrlPlataformas();
	$estgral -> ajaxEstadoGral();
}






