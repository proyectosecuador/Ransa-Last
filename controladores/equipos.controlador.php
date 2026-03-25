<?php

class ControladorEquipos{
	/*==========================================
	=            REGISTRO DE EQUIPO            =
	==========================================*/

	static public function ctrRegistrarEquipo($datos){
		$tabla = "equipomc";
		$rpta = ModeloEquipos::mdlRegistrarEquipos($tabla,$datos);
		return $rpta;

	}
	/*=========================================
	=            CONSULTAR EQUIPOS            =
	=========================================*/
	static public function ctrConsultarEquipos($dato,$item){
		$tabla = "equipomc";
		$rpta = ModeloEquipos::mdlConsultarEquipos($tabla,$dato,$item);
		return $rpta;
	}

	/*=======================================================
	=            EDITAR LOS DATOS DE LOS EQUIPOS            =
	=======================================================*/
	static public function ctrEditarEquipos($datos,$item){
		$tabla = "equipomc";

		$rpta = ModeloEquipos::mdlEditarEquipos($tabla,$datos,$item);

		return $rpta;
	}
	/*===========================================================
	=            ACTUALIZAR EL ESTADO DE LOS EQUIPOS            =
	===========================================================*/
	static public function ctrActualizarEquiposEstado($datos,$item){
		$tabla = "equipomc";

		$rpta = ModeloEquipos::mdlActualizarEquiposEstado($tabla,$datos,$item);

		return $rpta;
	}	
	
	
	
	/*=======================================================
	=            ASIGNAR RESPONSABLES DE EQUIPOS            =
	=======================================================*/
	static public function ctrAsignarEquipos($datos){
		$tabla = "easignacion";

		$rpta = ModeloEquipos::mdlAsignarEquipos($tabla,$datos);

		return $rpta;
	}
	/*=======================================================
	=            CONSULTAR ASIGNACION DE EQUIPOS (HISTORIAL)            =
	=======================================================*/
	static public function ctrConsultarAsignacionEquipos($datos,$item){
		$tabla = "easignacion";

		$rpta = ModeloEquipos::mdlConsultarAsignacionEquipos($tabla,$datos,$item);

		return $rpta;
	}
	/*=============================================================================
	=            ELIMINAR ASIGNACION ACTUALIZA ESTADO EN BASE DE DATOS            =
	=============================================================================*/
	static public function ctrEliminarAsignacion($dato,$item){
		$tabla = "easignacion";

		$rpta = ModeloEquipos::mdlEliminarAsignacion($tabla,$dato,$item);

		return $rpta;
	}
	/*===========================================
	=            ELIMINAR EL EQUIPO             =
	===========================================*/
	static public function ctrEliminarEquipo($item1,$valor1,$item2,$valor2){
		$tabla = "equipomc";

		$rpta = ModeloEquipos::mdlEliminarEquipo($tabla,$item1,$valor1,$item2,$valor2);

		return $rpta;
	}
	/*====================================================
	=            SUBIR PDF DE LA OT REALIZADA            =
	====================================================*/
	static public function ctrSubirPdfOT($file,$equipomc,$ciudad){
		if ( isset($file['tmp_name']) && !empty($file['tmp_name'])) {
			/*====================================================================================
			=            CONSULTAMOS EL MC PARA GUARDAR EN LA CARPETA CORRESPONDIENTE            =
			====================================================================================*/
			$ruta = ModeloEquipos::mdlConsultarEquipos("equipomc",$equipomc,"idequipomc");
			
						
			/*================================================================
			=            CREAMOS LA RUTA PARA ALMACENAR LA IMAGEN MULTIMEDIA            =
			================================================================*/
			if ($ciudad == 1) {
				$ciudaddir = "GYE/" ;
			}else if ($ciudad == 2) {
				$ciudaddir = "UIO/" ;
			}
			$directorio =  "../archivos/OT/".$ciudaddir.$ruta[0]["codigo"]."/";
			/*============================================================
			=            PREGUNTAMOS SI EXISTE EL DIRECTORIO             =
			============================================================*/
			if (!file_exists($directorio)) {
				mkdir($directorio,0777);
			}
			/*=========================================================
			=            MOVEMOS LA IMAGEN CON SUS NOMBRES            =
			=========================================================*/
			$nombre = uniqid();
			$rutamultimedia = $directorio.$nombre.".pdf";
			move_uploaded_file($file['tmp_name'],$rutamultimedia);

			return $rutamultimedia;
			
		}		

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}


