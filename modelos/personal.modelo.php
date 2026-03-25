<?php

require_once "conexion.php";

class ModeloPersonal{

	/*============================================
	=            INSERTAR PERSONAL            =
	============================================*/
	/*static public function mdlInsertarProveedores($tabla,$datos){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (ruc,nombre,email,estado) VALUES (:ruc,:nombre,:email,1)");

		$stmt->bindParam(":ruc",$datos["ruc"], PDO::PARAM_STR);
		$stmt->bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
		$stmt->bindParam(":email",$datos["correo"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;		
	}*/
	
	
	

	/*=============================================
	=            CONSULTAR PERSONAL            =
	=============================================*/
	static public function mdlConsultarPersonal($tabla,$item,$datos){

		if ($item != null) {
			if ($item == "idciudad") {
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