<?php
class ControladorCheckList{
	/*===========================================
	=            REGISTRO DE NUEVO CHECK LIST            =
	===========================================*/
	public static function ctrRegistroCheckList($dato){
		$tabla = "chcklstq";

		$rpta = ModeloCheckList::mdlRegistroCheckList($tabla,$dato);

		return $rpta;
	}



	/*=======================================
	=            CONSULTAR CHECK LIST            =
	=======================================*/

	static public function ctrConsultarCheckList($valor1,$valor2,$item1,$item2){
		$tabla = "chcklstq";

		$rpta = ModeloCheckList::mdlConsultarCheckList($tabla,$valor1,$valor2,$item1,$item2);

		return $rpta;
	}
	/*=======================================
	=            CONSULTAR CHECK LIST POR IDcheckList          =
	=======================================*/

	static public function ctrConsultarCheckListID($datos,$item){
		$tabla = "chcklstq";

		$rpta = ModeloCheckList::mdlConsultarCheckListID($tabla,$datos,$item);

		return $rpta;
	}	

	/*==================================================================
	=            CONSULTAR NOVEDADES DE CHECK LIST PARA PDF            =
	==================================================================*/
	static public function ctrConsultarObsCheckList($datos,$item){
		$tabla = "obschcklstq";

		$rpta = ModeloCheckList::mdlConsultarObsCheckList($tabla,$datos,$item);

		return $rpta;
	}
	/*=======================================================================
	=            CHECK LIST REALIZADOS CONSULTA POR MES Y EQUIPO            =
	=======================================================================*/
	static public function ctrConsultarCheckResult($datos,$item){
		$tabla = "chcklstq";

		$rpta = ModeloCheckList::mdlConsultarCheckResult($tabla,$datos,$item);

		return $rpta;
	}	
	
	
	

}