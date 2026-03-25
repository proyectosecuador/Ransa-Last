<?php

require_once "conexion.php";

class ModeloUserGarita{


	/*===============================================
	=            CONSULTAR USUARIOS GARITA            =
	===============================================*/
	static public function mdlConsultarUserGarita($tabla,$item,$datos){

		if (!empty($item)) {
			if ($item == "idciudad") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");

				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();
			}else if ($item["item1"] == "idlocalizacion") {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE {$item["item1"]} = :item1 AND  {$item["item2"]} = :item2");

				$stmt->bindParam(":item1",$datos["dato1"], PDO::PARAM_STR);
				$stmt->bindParam(":item2",$datos["dato2"], PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetch();

				
			}
			else{
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