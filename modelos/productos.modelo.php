<?php
require_once "conexion.php";

class ModeloProductos{

	/*=============================================
	INGRESAR PRODUCTOS
	=============================================*/
	static public function mdlIngresarProductos($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(codigo,tipubicacion,familia,grupo,descripcion,idcliente,idusuario,foto_portada,multimedia,estado,desctecnica) VALUES (:codigo,:tipubicacion,:familia,:grupo,:descripcion,:idcliente,:idusuario,:foto_portada,:multimedia,1,:desctecnica)");

		$stmt->bindParam(":codigo",$datos["codigo"], PDO::PARAM_STR);
		$stmt->bindParam(":tipubicacion",$datos["tipoubicacion"], PDO::PARAM_STR);
		$stmt->bindParam(":familia",$datos["familia"], PDO::PARAM_STR);
		$stmt->bindParam(":grupo",$datos["grupo"], PDO::PARAM_STR);
		$stmt->bindParam(":descripcion",$datos["descripcion"], PDO::PARAM_STR);
		$stmt->bindParam(":idcliente",$datos["idcliente"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuario",$datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":foto_portada",$datos["fotoprincipal"], PDO::PARAM_STR);
		$stmt->bindParam(":multimedia",$datos["multimedia"], PDO::PARAM_STR);
		$stmt->bindParam(":desctecnica",$datos["descTecnica"], PDO::PARAM_STR);
		
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;

	}
	/*===========================================
	=            CONSULTAR PRODUCTOS            =
	===========================================*/
	static public function mdlConsultarProductos($tabla,$item,$valor){

		$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :idcliente");

		$stmt -> bindParam(":idcliente",$valor,PDO::PARAM_INT);

		$stmt -> execute();
          
		

			return $stmt -> fetchAll();	
		
		

		$stmt -> close();

		$stmt = null;
	}
	/*=============================================================
	=            ACTUALIZAR EL ESTADO DE LOS PRODUCTOS            =
	=============================================================*/
	static public function mdlActualizarProductos($tabla,$item1,$valor1,$item2,$valor2){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_INT);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;
	}
	/*========================================
	=            EDITAR PRODUCTOS            =
	========================================*/
	static public function mdlEditarProductos($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET codigo = :codigo, tipubicacion = :tipubicacion, familia = :familia, grupo = :grupo, descripcion = :descripcion, idusuario = :idusuario, foto_portada = :foto_portada, multimedia = :multimedia, desctecnica = :descripciontecnica WHERE idproducto = :idproducto");

		$stmt->bindParam(":codigo",$datos["codigo"] ,PDO::PARAM_STR);
		$stmt->bindParam(":tipubicacion",$datos["tipubicacion"] ,PDO::PARAM_STR);
		$stmt->bindParam(":familia",$datos["familia"] ,PDO::PARAM_STR);
		$stmt->bindParam(":grupo",$datos["grupo"] ,PDO::PARAM_STR);
		$stmt->bindParam(":descripcion",$datos["descripcion"] ,PDO::PARAM_STR);
		$stmt->bindParam(":idusuario",$datos["idusuario"] ,PDO::PARAM_STR);
		$stmt->bindParam(":foto_portada",$datos["foto_portada"] ,PDO::PARAM_STR);
		$stmt->bindParam(":multimedia",$datos["multimedia"] ,PDO::PARAM_STR);
		$stmt->bindParam(":idproducto",$datos["id"] ,PDO::PARAM_STR);
		$stmt->bindParam(":descripciontecnica",$datos["descripciontecnica"] ,PDO::PARAM_STR);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;


	}
	/*==========================================
	=            ELIMINAR PRODUCTOS            =
	==========================================*/
	static public function mdlEliminarProductos($tabla,$item,$valor){

		$stmt = Conexion::conectar()->prepare("DELETE FROM $tabla WHERE idproducto = :idproducto");

		$stmt -> bindParam(":idproducto",$valor, PDO::PARAM_STR);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
	
	
	
	
	
	
	
	


}