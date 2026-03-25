<?php

class ControladorUrlPlataformas{

	static public function ctrinsertarUrl($valor){
		
		$tabla = "urlplataformas";

		$rpta = ModeloUrlPlataformas::mdlinsertarUrl($tabla,$valor);
		
		return $rpta;

	}

	/*================================================
	=            CONSULTAR TODOS LOS URLS            =
	================================================*/
	public function ctrConsultarUrl(){
		$tabla = "urlplataformas";

		$rpta = ModeloUrlPlataformas::mdlConsultarUrl($tabla);

		return $rpta;
	}
	/*==============================================================
	=            CAMBIAR EL ESTADO DEL BOTON A DISABLED            =
	==============================================================*/
	static public function ctrEstadoBoton($id,$valorestado){
		
		$tabla = "urlplataformas";
		$item1 = "botonestado";
		$valor1 = $valorestado;

		$item2 = "idurlplataforma";
		$valor2 = $id;

		$rpta = ModeloUrlPlataformas::mdlEstadoBoton($tabla,$item1,$valor1,$item2,$valor2);

		return $rpta;
	}
	/*=====================================================
	=            CAMBIO DE ESTADO GRAL BOTONES            =
	=====================================================*/
	public function ctrEstadoGral(){
		$tabla = "urlplataformas";
		$item = "botonestado";
		$valor = 0;

		$rpta = ModeloUrlPlataformas::mdlEstadoGral($tabla,$item,$valor);

		return $rpta;
	}
	
	
	
	
	
	
}

