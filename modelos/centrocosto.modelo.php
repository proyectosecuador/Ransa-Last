<?php

require_once "conexion.php";

class ModeloCentroCosto{

	/*=====================================
	=            INSERTAR NUEVO CENTRO DE COSTO            =
	=====================================*/
	public function mdlRegistroCentroCosto($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_cc,descripcion,estado) VALUES (:nombre,:descripcion,1)");

		$stmt->bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion",$datos["descripcion"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	
	
	

	/*===============================================
	=            CONSULTAR CENTRO DE COSTO            =
	===============================================*/
	static public function mdlConsultarCentroCosto($tabla,$dato,$item){

		if (isset($item) && !empty($item)) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :idcentro_costo");

			$stmt->bindParam(":idcentro_costo",$dato, PDO::PARAM_STR);

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