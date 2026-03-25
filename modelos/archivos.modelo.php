<?php

require_once "conexion.php";

class ModeloArchivos{

	/*===========================================================================
	=            GUARDAR DATOS DEL ARCHIVO QUE SE HA DADO ESTRUCTURA            =
	===========================================================================*/

	static public function mdlInserArchivos($tabla,$datos){

			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(nomarchivo,idcliente,idusuario,ruta,fechainvent,estado) VALUES (:nombre,:cliente,:usuario,:ruta,:fecha,:estado)");

			$stmt->bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":cliente",$datos["cliente"], PDO::PARAM_STR);
			$stmt->bindParam(":usuario",$datos["usuario"], PDO::PARAM_STR);
			$stmt->bindParam(":ruta",$datos["ruta"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha",$datos["fecha"], PDO::PARAM_STR);
			$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);

			if($stmt->execute()){

				return "ok";

			}else{

				return "error";
			
			}
	

		$stmt -> close();

		$stmt = null;

		
	}
	/*============================================================================================
	=            CONSULTAR EL ARCHIVO QUE SE HA DADO EXTRUCTURA PARA EXPORTAR A EXCEL            =
	============================================================================================*/	
	static public function mdlMostrarInventExcel($tabla,$item,$valor){

		if ($item != null) {

			if ($item == "nombre_encriptado") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :nombre_encriptado");
				$stmt -> bindparam(":nombre_encriptado", $valor, PDO::PARAM_STR);				
				$stmt -> execute();

				return $stmt -> fetch();				
			}else if ($item == "idcliente") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :idcliente");
				$stmt -> bindparam(":idcliente", $valor, PDO::PARAM_INT);
				$stmt -> execute();

				return $stmt -> fetchAll();				
			}
			else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE {$item['nombre']} = :nombre AND {$item['fecha']} = :fecha");

				$stmt -> bindparam(":nombre", $valor['nombre'], PDO::PARAM_STR);
				$stmt -> bindparam(":fecha", $valor['fecha'], PDO::PARAM_STR);
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
	/*=================================================================================
	=            COLOCAR EL VALOR ENCRIPTADO PARA CONFIRMAR POR EL CLIENTE            =
	=================================================================================*/
	static public function mdlActualizarArchivo($tabla,$datos,$item){

		if (isset($datos["cantidad"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_encriptado = :nombre_encriptado, estado_confirmacion = :estado_confirmacion,cantidad =:cantidad WHERE $item = :nomarchivo");

			$stmt->bindParam(":nombre_encriptado",$datos["nombre_encriptado"], PDO::PARAM_STR);
			$stmt->bindParam(":estado_confirmacion",$datos["estado_confirmacion"], PDO::PARAM_INT);
			$stmt->bindParam(":nomarchivo",$datos["nomarchivo"], PDO::PARAM_STR);	
			$stmt->bindParam(":cantidad",$datos["cantidad"], PDO::PARAM_INT);	
		}else{
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nombre_encriptado = :nombre_encriptado, estado_confirmacion = :estado_confirmacion WHERE $item = :nomarchivo");

			$stmt->bindParam(":nombre_encriptado",$datos["nombre_encriptado"], PDO::PARAM_STR);
			$stmt->bindParam(":estado_confirmacion",$datos["estado_confirmacion"], PDO::PARAM_INT);
			$stmt->bindParam(":nomarchivo",$datos["nomarchivo"], PDO::PARAM_STR);
		}		
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;		
	}
	
	
	
}