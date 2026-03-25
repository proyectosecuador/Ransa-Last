<?php

require_once "conexion.php";

class ModeloModulosPortal{

	/*=====================================
	=            INSERTAR MODULOS DEL PORTAL            =
	=====================================*/
	/*public function mdlRegistroTEquipo($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nom_eq,descrip_breve,estado) VALUES (:nombre,:descrip,1)");

		$stmt->bindParam(":nombre",$datos["tip_Equipo"], PDO::PARAM_STR);
		$stmt->bindParam(":descrip",$datos["descrip_EQuipo"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}*/
	
	
	

	/*===============================================
	=            CONSULTAR MODULOS DEL PORTAL            =
	===============================================*/
	static public function mdlConsultarModulosPortal($tabla,$dato,$item){

		if (isset($item) && !empty($item)) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :idtipo_equipo");

			$stmt->bindParam(":idtipo_equipo",$dato, PDO::PARAM_STR);

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