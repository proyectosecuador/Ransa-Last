<?php

require_once "conexion.php";

class ModeloServicoRansa{
	
	
	

	/*===============================================
	=            CONSULTAR SERVICIO RANSA            =
	===============================================*/
	static public function mdlConsultarServicosRansa($tabla,$item,$datos){

		if (!empty($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND estado = 1");

			$stmt->bindParam(":item",$datos, PDO::PARAM_INT);

			$stmt -> execute();

			return $stmt -> fetch();
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE estado = 1");

			$stmt -> execute();

			return $stmt -> fetchAll();			
		}



		$stmt -> close();

		$stmt = null;
	}
	
	
	
}