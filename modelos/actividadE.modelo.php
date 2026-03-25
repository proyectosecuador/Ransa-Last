<?php

require_once "conexion.php";

class ModeloActividadE{

	/*=====================================
	=            INSERTAR ACTIVIDAD DE ESTIBA            =
	=====================================*/
	public function mdlInsertarActividadE($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (descripcion,fecha_registro,estado) VALUES (:nombre,GETDATE(),1)");

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
	=            CONSULTAR ACTIVDAD DE ESTIBAS            =
	===============================================*/
	static public function mdlConsultarActividadE($tabla,$item,$datos){

		if (!empty($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");

			$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

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