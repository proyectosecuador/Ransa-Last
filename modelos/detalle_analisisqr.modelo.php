<?php

require_once "conexion.php";

class ModeloDetalleCRQR{

	/*=====================================
	=            INSERTAR DETALLE DE DOC CAUSA RAIZ            =
	=====================================*/
	static public function mdlIgresarDetalle($tabla,$datos){

		/**
		
			ESTADO ANALISIS:
			- 1 => ANALISIS CARGADO
			- 2 => NO ME PERTENECE
			- 3 => APROBADO
			- 4 => RE-CLASIFICAR
			- 5 => REVISAR NUEVAMENTE
		
		 */		
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idsolicitudes_qr,estado_analisis,fecha_regist,estado,motivo,archivo) VALUES(:idsolicitudes_qr,:estado_analisis,GETDATE(),1,:motivo,:archivo)");

		$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
		$stmt->bindParam(":estado_analisis",$datos["estado_analisis"], PDO::PARAM_INT);
		$stmt->bindParam(":motivo",$datos["motivo"], PDO::PARAM_STR);
		$stmt->bindParam(":archivo",$datos["archivo"], PDO::PARAM_STR);


		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	
	
	

	/*===============================================
	=            CONSULTAR AREAS ACTIVAS            =
	===============================================*/
	// static public function mdlConsultarAreas($tabla,$item,$datos){

	// 	if (!empty($item)) {
	// 		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

	// 		$stmt->bindParam(":valor",$datos, PDO::PARAM_STR);

	// 		$stmt -> execute();

	// 		return $stmt -> fetch();

	// 		$stmt -> close();

	// 		$stmt = null;
	// 	}else{
	// 		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

	// 		$stmt -> execute();

	// 		return $stmt -> fetchAll();

	// 		$stmt -> close();

	// 		$stmt = null;
	// 	}
	// }
	
	
	
}