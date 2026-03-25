<?php

require_once "conexion.php";

class ModeloEstibas{

	/*=====================================
	=            INSERTAR PROVEEDOR ESTIBAS            =
	=====================================*/
	static public function mdlRegistrarEstibas($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nombre_proveedor,ruc,clave,email,fecha_registro,estado) VALUES (:valor1,:valor2,:valor3,:valor4,GETDATE(),1)");

		
		$stmt->bindParam(":valor1",$datos["nombre_proveedor"], PDO::PARAM_STR);
		$stmt->bindParam(":valor2",$datos["RucEstibas"], PDO::PARAM_STR);
		$stmt->bindParam(":valor3",$datos["ContraEstibas"], PDO::PARAM_STR);
		$stmt->bindParam(":valor4",$datos["CorreoEstibas"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	
	
	

	/*===============================================
	=            CONSULTAR PROVEEDOR ESTIBAS            =
	===============================================*/
	static public function mdlConsultarEstibas($tabla,$dato,$item){

		if (!empty($item)) {
			if ($item == "idciudad") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item1");

				$stmt->bindParam(":item1",$dato, PDO::PARAM_INT);

				$stmt -> execute();

				return $stmt -> fetchAll();
			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item1");

				$stmt->bindParam(":item1",$dato, PDO::PARAM_INT);

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
	
	/*=====================================================
	=            EDITAR EL PROVEEDOR DE ESTIBA            =
	=====================================================*/
	static public function mdlEditarEstibas($tabla,$datos,$item){

		

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
	=            ELIMINAR EL PROVEEDOR DE ESTIBA            =
	=======================================================*/
	static public function mdlEliminarEstibas($tabla,$datos,$item){

		

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