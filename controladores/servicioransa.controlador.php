<?php
class ControladorServiciosRansa{
/*=======================================
=            CONSULTAR SERVICIOS RANSA            =
=======================================*/

	static public function ctrConsultarServiciosRansa($item,$sdatos){
		$tabla = "servicioransa";

		$rpta = ModeloServicoRansa::mdlConsultarServicosRansa($tabla,$item,$sdatos);

		return $rpta;
	}
}