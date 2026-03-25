<?php
class ControladorTCarga{
/*===========================================
=            INSERTAR TIPO DE CARGA            =
===========================================*/
public function ctrRegistrarTCarga($datos){
	$tabla = "tipo_carga";

	$rpta = ModeloTCarga::mdlRegistrarTCarga($tabla,$datos);

	return $rpta;
}

/*=======================================
=            CONSULTAR TIPO DE CARGA            =
=======================================*/

static public function ctrConsultarTCarga($dato,$item){
	$tabla = "tipo_carga";

	$rpta = ModeloTCarga::mdlConsultarTCarga($tabla,$dato,$item);

	return $rpta;
}
/*=====================================================
=            EDITAR EL TIPO DE CARGA            =
=====================================================*/
static public function ctrEditarTCarga($datos,$item){
	$tabla = "tipo_carga";

	$rpta = ModeloTCarga::mdlEditarTCarga($tabla,$datos,$item);

	return $rpta;
}
/*=======================================================
=            ELIMINAR EL TIPO DE CARGA            =
=======================================================*/
static public function ctrEliminarTCarga($datos,$item){
	$tabla = "tipo_carga";

	$rpta = ModeloTCarga::mdlEliminarTCarga($tabla,$datos,$item);

	return $rpta;
}






}