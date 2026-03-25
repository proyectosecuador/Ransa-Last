<?php
class ControladorCheckListBpa{
/*===========================================
=            REGISTRO DE NUEVO CHECK LIST            =
===========================================*/
public static function ctrRegistroCheckListBpa($dato){
	$tabla = "chcklstbpa";

	$rpta = ModeloCheckListBpa::mdlRegistroCheckListBpa($tabla,$dato);

	return $rpta;
}

/*========================================================================
=            REGISTRO DE LAS OBSERVACIONES DEL CHECK LIST BPA            =
========================================================================*/
public static function ctrRegistroObservacionCheckBpa($dato,$lista,$idcheckbpa){
	$tabla = "obscheckbpa";

	$rpta = ModeloCheckListBpa::mdlRegistroObservacionCheckBpa($tabla,$dato,$lista,$idcheckbpa);

	return $rpta;	

}
/*=======================================
=            CONSULTAR CHECK LIST BPA       =
=======================================*/
static public function ctrConsultarCheckListBpa($datos,$item){
	$tabla = "chcklstbpa";

	$rpta = ModeloCheckListBpa::mdlConsultarCheckListBpa($tabla,$item,$datos);

	return $rpta;
}
/*=====================================================================
=            CONSULTAR LAS OBSERVACIONES DE CHECK LIST BPA            =
=====================================================================*/
static public function ctrConsultarObsCheckListBpa($datos,$item){
	$tabla = "obscheckbpa";

	$rpta = ModeloCheckListBpa::mdlConsultarObsCheckListBpa($tabla,$item,$datos);

	return $rpta;
}
/*==============================================
=            CONSULTA PARA DESCARGA            =
==============================================*/
static public function ctrConsultDescargaDatos($datos,$item){
	$tabla = "chcklstbpa";

	$rpta = ModeloCheckListBpa::mdlConsultDescargaDatos($tabla,$datos,$item);

	return $rpta;
}







}