<?php

require_once "conexion.php";

class ModeloDNegociacionQR{

	/*=====================================
	=            INSERTAR NEGOCIACION DE QR            =
	=====================================*/
	static public function mdlInsertarDNegociacionQR($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idsolicitudes_qr,observaciones,idusuario,fecha_regist,estado) VALUES (:idsolicitudes_qr,:observaciones,:idusuario,GETDATE(),1)");

		$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
		$stmt->bindParam(":observaciones",$datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":idusuario",$datos["idusuario"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	
	
	

	/*===============================================
	=            CONSULTAR NEGOCIACION            =
	===============================================*/
	static public function mdlConsultarDNegociacionQR($tabla,$item,$datos){

		if (!empty($item)) {
			if ($item == "idsolicitudes_qr") {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND estado = 1");

				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();
			}else if ($item == "tipo_analisis") {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE idsolicitudes_qr = :item AND $item = :valor2");
				$stmt->bindParam(":item",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
				$stmt->bindParam(":valor2",$datos["tipo_analisis"], PDO::PARAM_STR);

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
	=            ACTUALIZAR LAS NEGOCIACION REALIZADAS            =
	=================================================================*/
	static public function mdlActualizarDNegociacionQR($tabla,$item,$datos){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE $item = :item");

		$stmt->bindParam(":item",$datos["item"], PDO::PARAM_INT);
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