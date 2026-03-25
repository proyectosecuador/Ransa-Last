<?php 
require_once "../controladores/personal.controlador.php";
require_once "../modelos/personal.modelo.php";
session_start();
$listProveedores = new ControladorPersonal();
$item = "idciudad";
$valor = $_SESSION["ciudad"];
$rpta = $listProveedores -> ctrConsultarPersonal($item,$valor);

$datosJson = '{
			"nombres": [';
for ($i=0; $i < count($rpta) ; $i++) {
	//$datosJson .= '[';
	//$datosJson .= '"'.$rpta[$i]["idpersonal"].'",';
	$datosJson .= '"'.$rpta[$i]["nombres_apellidos"].'",';
	//$datosJson .= '],';
}
$datosJson = substr($datosJson,0,-1);
$datosJson .= ']}';


echo $datosJson;
