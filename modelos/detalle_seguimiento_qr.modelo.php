<?php

require_once "conexion.php";

class ModeloDSeguimientoQR{

	/*=====================================
	=            INSERTAR NUEVAO REGISTRO DE SEGUIMIENTO            =
	=====================================*/
	static public function mdlInsertarDSeguimientoQR($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idsolicitudes_qr,idusuario,observaciones,tipo_seguimiento,fecha_regist,estado) VALUES (:idsolicitudes_qr,:idusuario,:observaciones,:tipo_seguimiento,GETDATE(),1)");

		$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuario",$datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":observaciones",$datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":tipo_seguimiento",$datos["tipo_seguimiento"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	
	
	

	/*===============================================
	=            CONSULTAR SEGUIMIENTO REALIZADO            =
	===============================================*/
	static public function mdlConsultarDSeguimientoQR($tabla,$item,$datos){

		if (!empty($item)) {
			if ($item == "idsolicitudes_qr") {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND estado = 1");

				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();
			}			
			$stmt -> close();

			$stmt = null;
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;
		}
	}
	/*=================================================================
	=            ACTUALIZAR LAS RESPUESTAS ENVIADAS AL CLIENTE            =
	=================================================================*/
	static public function mdlActualizarDSeguimientoQR($tabla,$item,$datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE $item = :idsolicitudes_qr");

		$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
		$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";

		}

		$stmt->close();

		$stmt = null;	
	}
	
	
	
	
	
	
}