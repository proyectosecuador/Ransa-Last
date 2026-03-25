<?php

require_once "conexion.php";

class ModeloUrlPlataformas{

	static public function mdlinsertarUrl($tabla,$valor){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nombre,url,usuarios,estado)
			VALUES (:nombre, :url, :usuarios,1)");

			$stmt->bindParam(":nombre",$valor["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":url",$valor["url"], PDO::PARAM_STR);
			$stmt->bindParam(":usuarios",$valor["usuarios"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;

		
	}

	/*========================================
	=            CONSULTA DE URLS            =
	========================================*/
	static public function mdlConsultarUrl($tabla){
		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

		$stmt -> execute();

		return $stmt -> fetchAll();

		$stmt -> close();

		$stmt = null;
	}

	/*===================================================================
	=            CAMBIAR EL ESTADO DE LOS BOTONES A DISABLED            =
	===================================================================*/
	static public function mdlEstadoBoton($tabla,$item1,$valor1,$item2,$valor2){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla  SET $item1 = :botonestado WHERE $item2 = :id");

		$stmt->bindParam(":botonestado",$valor1, PDO::PARAM_STR);
		$stmt->bindParam(":id",$valor2, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
	/*====================================================
	=            CAMBIO DE ESTADO GRL BOTONES            =
	====================================================*/
	public function mdlEstadoGral($tabla,$item,$valor){
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla  SET $item = :botonestado");

		$stmt->bindParam(":botonestado",$valor, PDO::PARAM_STR);
		

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;		
	}
	
	
	
	
	
	
	
	
}