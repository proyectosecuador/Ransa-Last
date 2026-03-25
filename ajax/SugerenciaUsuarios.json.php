<?php
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

$listUsuarios = new ControladorUsuarios();
$tabla = "usuariosransa";
$item = null;
$datos = null;
$rpta = $listUsuarios -> ctrMostrarUsuariosRansa($tabla,$item,$datos);

$datosJson = '[';
for ($i=0; $i < count($rpta) ; $i++) {
	$datosJson .= '{"idusuario":';
	$datosJson .= '"'.$rpta[$i]["id"].'",';
	$datosJson .= '"nombres":';
	$datosJson .= '"'.$rpta[$i]["primernombre"]." ".$rpta[$i]["primerapellido"].'"},';
}
$datosJson = substr($datosJson,0,-1);
$datosJson .= ']';


echo $datosJson;