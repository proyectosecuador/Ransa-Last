<?php

require_once "conexion.php";

class ModeloTTransporte{

	/*=====================================
	=            INSERTAR AREA            =
	=====================================*/
	// public function mdlInsertarArea($tabla,$datos){

	// 	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre,estado) VALUES (:nombre,1)");

	// 	$stmt->bindParam(":nombre",$datos, PDO::PARAM_STR);

	// 	if($stmt->execute()){

	// 		return "ok";

	// 	}else{

	// 		return "error";
		
	// 	}
	

	// 	$stmt -> close();

	// 	$stmt = null;


	// }
	
	
	

	/*===============================================
	=            CONSULTAR TIPOS DE TRANSPORTE ACTIVAS            =
	===============================================*/
	static public function mdlConsultarTTransporte($tabla,$item,$datos){

		if (!empty($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor1");

			$stmt->bindParam(":valor1",$datos, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();			
			
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();			
		}
		$stmt -> close();

		$stmt = null;
	}
	
	
	
}