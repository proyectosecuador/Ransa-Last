<?php

require_once "conexion.php";

class ModeloCiudad{

	/*=====================================
	=            INSERTAR CIUDAD            =
	=====================================*/
	public function mdlRegistroCiudad($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (desc_ciudad,estado,fech_creacion) VALUES (:nombre,1,GETDATE())");

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
	static public function mdlConsultarCiudad($tabla,$item,$datos){
		if (isset($item) && !empty($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");

			$stmt->bindParam(":valor",$datos, PDO::PARAM_STR);
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