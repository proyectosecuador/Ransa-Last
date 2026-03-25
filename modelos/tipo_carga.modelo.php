<?php

require_once "conexion.php";

class ModeloTCarga{

	/*=====================================
	=            INSERTAR TIPO DE CARGA            =
	=====================================*/
	public function mdlRegistrarTCarga($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_proveedor,fecha_registro,estado) VALUES (:valor1,GETDATE(),1)");

		
		$stmt->bindParam(":valor1",$datos, PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	
	
	

	/*===============================================
	=            CONSULTAR TIPO DE CARGA            =
	===============================================*/
	static public function mdlConsultarTCarga($tabla,$dato,$item){

		if (!empty($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item1");

			$stmt->bindParam(":item1",$dato, PDO::PARAM_INT);

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
	
	/*=====================================================
	=            EDITAR EL TIPO DE CARGA            =
	=====================================================*/
	static public function mdlEditarTCarga($tabla,$datos,$item){

		

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_proveedor = :valor1 WHERE $item = :item");



		$stmt->bindParam(":valor1",$datos["nombre_prov"], PDO::PARAM_STR);

		$stmt->bindParam(":item",$datos["idprovestiba"], PDO::PARAM_INT);



		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;		

	}	
	
	/*=======================================================
	=            ELIMINAR EL TIPO DE CARGA            =
	=======================================================*/
	static public function mdlEliminarTCarga($tabla,$datos,$item){

		

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :valor1 WHERE $item = :item");



		$stmt->bindParam(":valor1",$datos["estado"], PDO::PARAM_STR);

		$stmt->bindParam(":item",$datos["idproveedor_estiba"], PDO::PARAM_INT);



		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;		

	}		
	
	
	
	
}