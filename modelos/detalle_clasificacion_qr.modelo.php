<?php

require_once "conexion.php";

class ModeloDClasificacionQR{

	/*=====================================
	=            INSERTAR CLASIFICACION DE QR            =
	=====================================*/
	static public function mdlInsertarDClasificacionQR($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idsolicitudes_qr,idusuarios_responsables,idusuario_negocio,idusuario_asignador,fecha_registro,estado) VALUES (:idsolicitudes_qr,:idusuarios_responsables,:idusuario_negocio,:idusuario_asignador,GETDATE(),1)");

		$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuarios_responsables",$datos["idusuarios_responsables"], PDO::PARAM_STR);
		$stmt->bindParam(":idusuario_negocio",$datos["idusuario_negocio"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuario_asignador",$datos["idusuario_asignador"], PDO::PARAM_INT);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	
	
	

	/*===============================================
	=            CONSULTAR CLASIFICACIONES            =
	===============================================*/
	static public function mdlConsultarDClasificacionQR($tabla,$item,$datos){

		if (!empty($item)) {
			if ($item == "idusuarios_responsables" || $item == "idsolicitudes_qr") {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item LIKE :item AND estado = 1");
				// var_dump($stmt);
				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();
			}else if ($item == "idusuario_negocio") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item AND estado = 1");
				// var_dump($stmt);
				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

				$stmt -> execute();

				return $stmt -> fetchAll();
			}
			
			$stmt -> close();

			$stmt = null;
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt -> close();

			$stmt = null;
		}
	}

	/*===================================================
	=            ACTUALIZAR LA CLASIFICACION            =
	===================================================*/
	static public function mdlActualizarDClasificacionQR($tabla,$item,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE $item = :iddetalle_clasificacion_qr");

		$stmt->bindParam(":iddetalle_clasificacion_qr",$datos["iddetalle_clasificacion_qr"], PDO::PARAM_INT);
		$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);
		

		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;
	}
	
	
	
	
	
	
}