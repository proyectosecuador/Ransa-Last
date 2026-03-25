<?php
class ControladorEstibas{
/*===========================================
=            INSERTAR PROVEEDOR ESTIBAS            =
===========================================*/
static public function ctrRegistrarEstibas($datos){
	$tabla = "proveedor_estibas";

	$rpta = ModeloEstibas::mdlRegistrarEstibas($tabla,$datos);

	return $rpta;
}

/*=======================================
=            CONSULTAR PROVEEDOR ESTIBAS            =
=======================================*/

static public function ctrConsultarEstibas($dato,$item){
	$tabla = "proveedor_estibas";

	$rpta = ModeloEstibas::mdlConsultarEstibas($tabla,$dato,$item);

	return $rpta;
}
/*=====================================================
=            EDITAR EL PROVEEDOR DE ESTIBA            =
=====================================================*/
static public function ctrEditarEstibas($datos,$item){
	$tabla = "proveedor_estibas";

	$rpta = ModeloEstibas::mdlEditarEstibas($tabla,$datos,$item);

	return $rpta;
}
/*=======================================================
=            ELIMINAR AL PROVEEDOR DE ESTIBA            =
=======================================================*/
static public function ctrEliminarEstibas($datos,$item){
	$tabla = "proveedor_estibas";

	$rpta = ModeloEstibas::mdlEliminarEstibas($tabla,$datos,$item);

	return $rpta;
}






}