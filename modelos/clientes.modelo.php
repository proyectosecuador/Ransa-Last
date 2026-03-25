<?php

require_once "conexion.php";

class ModeloClientes{

	static public function mdlmostrarClientes($tabla,$item,$valor){
		if (!empty($valor)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :codigo AND estado = 1");

			$stmt -> bindParam(":codigo",$valor,PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();
		}
		else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = 1");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
		

		

		$stmt -> close();

		$stmt = null;

		
	}
}