<?php

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

class AjaxProveedores{

	public $ruc;
	public $nombre;
	public $correo;
	/*==========================================
	=            INGRESAR PROVEEDOR            =
	==========================================*/
	public function ajaxIngresarProveedores(){
		$ru = $this->ruc;
		$nom = $this->nombre;
		$corre = $this->correo;

		$datos = array("ruc" => $ru,
						"nombre" => $nom,
						"correo" => $corre);

		$rpta = ControladorProveedores::ctrInsertarProveedores($datos);
		if ($rpta == "ok") {
			echo 1;
		}else{
			echo 2;
		}
	}
	/*======================================================
	=            VALIDAR SI EXISTE EL PROVEEDOR            =
	======================================================*/
	public function ajaxValidarProveedor(){
		$valor = $this->ruc;
		$item = "ruc";

		$rpta = ControladorProveedores::ctrConsultarProveedores($item,$valor);

		echo json_encode($rpta);



	}
	
	
	

}
/*===================================================
=            INGRESAR UN NUEVO PROVEEDOR            =
===================================================*/
if (isset($_POST['insertruc'])) {
	$insertarProveedor = new AjaxProveedores();
	$insertarProveedor -> ruc = $_POST['insertruc'];
	$insertarProveedor -> nombre = $_POST['nombre'];
	$insertarProveedor -> correo = $_POST['correo'];
	$insertarProveedor -> ajaxIngresarProveedores();
}
/*=========================================================
=            VALIDAR PARA NO REPETIR PROVEEDOR            =
=========================================================*/



if (isset($_POST["validadrucproveedor"])) {

	$valrucproveedor = new AjaxProveedores();
	$valrucproveedor -> ruc = $_POST["validadrucproveedor"];
	$valrucproveedor -> ajaxValidarProveedor();	
}