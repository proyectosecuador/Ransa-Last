<?php 
require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

$listProveedores = new ControladorProveedores();

$rpta = $listProveedores -> ctrConsultarProveedores("","");

$datosJson .= '[';
for ($i=0; $i < count($rpta) ; $i++) {
	
	$datosJson .= '"'.$rpta[$i]["nombre"].'",';
}
$datosJson = substr($datosJson,0,-1);
$datosJson .= ']';

if($datosJson==']'){
	$datosJson = '[]';
} else  {}
echo $datosJson;

