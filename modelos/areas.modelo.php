<?php

require_once "conexion.php";

class ModeloAreas{

	/*=====================================
	=            INSERTAR AREA            =
	=====================================*/
	public function mdlInsertarArea($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre,estado) VALUES (:nombre,1)");

		$stmt->bindParam(":nombre",$datos, PDO::PARAM_STR);

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
	static public function mdlConsultarAreas($tabla,$item,$datos){

		if (!empty($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

			$stmt->bindParam(":valor",$datos, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetch();

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
	
	
	
}