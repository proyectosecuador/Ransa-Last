<?php

require_once "conexion.php";

class ModeloDocumentos{

	/*============================================
	=            INSERTAR DOCUMENTOS            =
	============================================*/
	static public function mdlInsertarDocumentos($tabla,$datos){
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (tipo_documento,cc,idproveedor,idarea,num_documento,fech_documento,estado_documento,movimiento_doc,nombreencriptado,idusuario) VALUES (:tipo_documento,:cc,:idproveedor,:idarea,:num_documento,:fech_documento,1,:movimiento_doc,:nombreencriptado,:idusuario)");//estado 1 EN PROCESO

		$stmt->bindParam(":tipo_documento",$datos["tipo_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":idproveedor",$datos["idproveedor"], PDO::PARAM_INT);
		$stmt->bindParam(":cc",$datos["centrocosto"], PDO::PARAM_STR);
		$stmt->bindParam(":idarea",$datos["idarea"], PDO::PARAM_INT);
		$stmt->bindParam(":num_documento",$datos["num_documento"], PDO::PARAM_INT);
		$stmt->bindParam(":movimiento_doc",$datos["movimiento_doc"], PDO::PARAM_STR);
		$stmt->bindParam(":fech_documento",$datos["fech_documento"], PDO::PARAM_STR);
		$stmt->bindParam(":nombreencriptado",$datos["nombreencriptado"], PDO::PARAM_STR);
		$stmt->bindParam(":idusuario",$datos["idusuario"], PDO::PARAM_STR);
	
		if($stmt->execute()){


			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;		
	}

	/*==========================================
	=            MOSTRAR DOCUMENTOS            =
	==========================================*/
	static public function mdlMostrarDocumentos($tabla, $item, $valor){

		if (isset($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");

			$stmt -> bindParam(":".$item, $valor, PDO::PARAM_STR);

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt-> close();

			$stmt = null;
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

			$stmt-> close();

			$stmt = null;

		}



	}
	/*=============================================
	=            ACTUALIZAR DOCUMENTOS            =
	=============================================*/
	static public function mdlActualizarDocumentos($tabla,$item,$valor){

		$stmt =  Conexion::conectar()->prepare("UPDATE $tabla SET {$item['item1']} = :movimiento_doc, {$item['item3']} = :nombreencriptado WHERE {$item['item2']} = :valor2");

		$stmt -> bindParam(":movimiento_doc", $valor["valor1"], PDO::PARAM_STR);
		$stmt -> bindParam(":valor2", $valor["valor2"], PDO::PARAM_STR);
		$stmt -> bindParam(":nombreencriptado", $valor["nombreencriptado"], PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;		
	}
	
	
	
	
	
	
	
}