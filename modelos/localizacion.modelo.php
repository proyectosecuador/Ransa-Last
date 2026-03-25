<?php

require_once "conexion.php";

class ModeloLocalizacion{

	/*=====================================
	=            INSERTAR NUEVA LOCALIZACION            =
	=====================================*/
	public function mdlRegistroLocalizacion($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nom_localizacion,estado) VALUES (:nombre,1)");

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
	=            CONSULTAR LOCALIZACION            =
	===============================================*/
	static public function mdlConsultarLocalizacion($tabla,$dato,$item){

		if (isset($item) && !empty($item)) {
			if ($item == "idciudad") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :idciudad");

				$stmt->bindParam(":idciudad",$dato, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :idlocalizacion");

				$stmt->bindParam(":idlocalizacion",$dato, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetch();
			}			
			
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;
	}
	
	
	
}