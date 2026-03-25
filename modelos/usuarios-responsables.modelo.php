<?php

require_once "conexion.php";

class ModeloUserResponsable{


	/*===============================================
	=            CONSULTAR USUARIOS RESPONSABLES POR NEGOCIO            =
	===============================================*/
	static public function mdlConsultarUserResponsable($tabla,$item,$datos){

		if (!empty($item)) {
			if ($item == "idservicioransa") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");

				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");

				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

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