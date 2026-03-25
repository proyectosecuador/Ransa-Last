<?php
class ControladorMovRD
{
	/*===========================================
=            INSERTAR MOVIMIENTO DE RECEPCION O DESPACHO            =
===========================================*/
	static public function ctrRegistrarMovRD($datos)
	{
		$tabla = "mov_recep_desp";

		$rpta = ModeloMovRD::mdlRegistrarMovRD($tabla, $datos);

		return $rpta;
	}

	/*=======================================
=            CONSULTAR MOVIMIENTO DE RECEPCION O DESPACHO            =
=======================================*/

	static public function ctrConsultarMovRD($dato, $item)
	{
		$tabla = "mov_recep_desp";

		$rpta = ModeloMovRD::mdlConsultarMovRD($tabla, $dato, $item);

		return $rpta;
	}
	/*=====================================================
=            EDITAR EL MOVIMIENTO DE RECEPCION O DESPACHO            =
=====================================================*/
	static public function ctrEditarMovRD($datos, $item)
	{
		$tabla = "mov_recep_desp";

		$rpta = ModeloMovRD::mdlEditarMovRD($tabla, $datos, $item);

		return $rpta;
	}
	/*=======================================================
=            ELIMINAR AL MOVIMIENTO DE RECEPCION O DESPACHO            =
=======================================================*/
	static public function ctrEliminarMovRD($datos, $item)
	{
		$tabla = "mov_recep_desp";

		$rpta = ModeloMovRD::mdlEliminarMovRD($tabla, $datos, $item);

		return $rpta;
	}
	/*=================================================================
=            ALMACENAR LAS IMAGENES DE MOV AL SERVIDOR            =
=================================================================*/
	static public function ctrGuardarImagenesServidor($imagenes, $ruta)
	{
		if (isset($imagenes['tmp_name']) && !empty($imagenes['tmp_name'])) {


			/*=====  RUTA DONDE SE GUARDARÁ LA IMAGEN  ======*/

			$directorio = "../archivos/Check Transporte/" . $ruta . "/";
			/*============================================================
		=            PREGUNTAMOS SI EXISTE EL DIRECTORIO             =
		============================================================*/
			// var_dump(!file_exists($directorio));
			if (!file_exists($directorio)) {
				mkdir($directorio, 0777);
			}
			/*=========================================================
		=            MOVEMOS LA IMAGEN CON SUS NOMBRES            =
		=========================================================*/
			$nombre = uniqid();
			$rutimg = $directorio . $nombre . ".png";
			move_uploaded_file($imagenes['tmp_name'], $rutimg);

			return $rutimg;
		}
	}
	/*============================================================
=            EDITAR CAMPOS DE MOVIMIENTO DE R Y D            =
============================================================*/
	static public function ctrEditarMovRDEst($datos, $item)
	{
		$tabla = "mov_recep_desp";

		$rpta = ModeloMovRD::mdlEditarMovRDEst($tabla, $datos, $item);

		return $rpta;
	}

	// static public function ctrEditarMovRDcht($datos,$item){
	//     $tabla = "mov_recep_desp";

	// 	$rpta = ModeloMovRD::mdlEditarMovRDcht($tabla,$datos,$item);

	// 	return $rpta;

	// }

public static function ctrConsultarTodosMovPorActividad($actividad)
{
    $tabla = "mov_recep_desp";
    return ModeloMovRD::mdlConsultarTodosMovPorActividad($tabla, $actividad);
}

static public function ctrRegistrarMovRDConEstado($datos)
{
    $tabla = "mov_recep_desp";
    $rpta = ModeloMovRD::mdlRegistrarMovRDConEstado($tabla, $datos);
    return $rpta;
}


}
