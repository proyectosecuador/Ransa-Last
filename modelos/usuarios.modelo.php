<?php
require_once "conexion.php";

//Estado
 // 1 => Activo
 // 0 => Eliminado
 // 2 => Inactivo

class ModeloUsuarios{

	static public function mdlIngresarUsuarios($tabla, $datos){

		if ($datos["cliente"] == "") {
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(primernombre,primerapellido,cargo,perfil,email,clave,cuentas,estado,idareas,idciudad,idmodulos)
				VALUES (:nombre, :apellido, :cargo, :perfil,:email,:clave,:cuentas,1,:area,:ciudad,:modulos)");

			$stmt->bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":apellido",$datos["apellidos"], PDO::PARAM_STR);
			$stmt->bindParam(":cargo",$datos["cargo"], PDO::PARAM_STR);
			$stmt->bindParam(":perfil",$datos["perfil"], PDO::PARAM_STR);
			$stmt->bindParam(":email",$datos["correo"], PDO::PARAM_STR);
			$stmt->bindParam(":clave",$datos["password"], PDO::PARAM_STR);
			$stmt->bindParam(":cuentas",$datos["cuentas"], PDO::PARAM_STR);
			$stmt->bindParam(":area",$datos["area"], PDO::PARAM_STR);
			$stmt->bindParam(":ciudad",$datos["ciudad"], PDO::PARAM_STR);
			$stmt->bindParam(":modulos",$datos["modulos"], PDO::PARAM_STR);
		}else{
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla(primernombre,primerapellido,perfil,email,clave,idcliente,estado)
			VALUES (:nombre, :apellido, :perfil,:email,:clave,:idcliente,1)");

			$stmt->bindParam(":nombre",$datos["nombre"], PDO::PARAM_STR);
			$stmt->bindParam(":apellido",$datos["apellidos"], PDO::PARAM_STR);
			$stmt->bindParam(":perfil",$datos["perfil"], PDO::PARAM_STR);
			$stmt->bindParam(":email",$datos["correo"], PDO::PARAM_STR);
			$stmt->bindParam(":clave",$datos["password"], PDO::PARAM_STR);
			$stmt->bindParam(":idcliente",$datos["cliente"], PDO::PARAM_STR);

		}
		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;
		
		
	}

	static public function mdlMostrarUsuarios($tabla,$item,$valor){
		
		if ($item != null) {
			
			if ($tabla != "usuariosclientes") {

				if ($item == "perfil") {
					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor1 OR $item = :valor2");

					$stmt -> bindparam(":valor1", $valor["valor1"], PDO::PARAM_STR);
					$stmt -> bindparam(":valor2", $valor["valor2"], PDO::PARAM_STR);
					$stmt -> execute();


					return $stmt -> fetchAll();						
					
				}else if (isset($item["idciudad"])) {
					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE {$item["idciudad"]} = :idciudad AND {$item["perfil"]} = :perfil");

					$stmt -> bindparam(":idciudad", $valor["idciudad"], PDO::PARAM_STR);
					$stmt -> bindparam(":perfil", $valor["perfil"], PDO::PARAM_STR);
					$stmt -> execute();


					return $stmt -> fetchAll();											
					
				}else if ($item == "cuentas") {
					/*=============================================================================================
					=            BUSCAR TODOS LOS USUARIOS QUE CONTENGAN EL CLIENTE SEGUN RAZON SOCIAL            =
					=============================================================================================*/
					$stmt = Conexion::conectar()->prepare("SELECT * FROM usuariosransa WHERE $item  LIKE  :valor AND perfil = :perfil AND idciudad = :idciudad");

					$stmt -> bindparam(":valor", $valor["cuentas"], PDO::PARAM_STR);
					$stmt -> bindparam(":perfil", $valor["perfil"], PDO::PARAM_STR);
					$stmt -> bindparam(":idciudad", $valor["idciudad"], PDO::PARAM_STR);
					// $stmt -> bindparam(":perfil", $valor["perfil"], PDO::PARAM_STR);
					$stmt -> execute();


					return $stmt -> fetchAll();
				}else if ($item == "idareas") {
					/*==========================================================================
					=            BUSCA TODOS LOS USUARIOS DE UNA AREA EN ESPECIFICO            =
					==========================================================================*/
					$stmt = Conexion::conectar()->prepare("SELECT * FROM usuariosransa WHERE $item = :valor AND estado != 0");

					$stmt -> bindparam(":valor", $valor, PDO::PARAM_STR);
					$stmt -> execute();


					return $stmt -> fetchAll();
					
				}
				else{
					
					$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :$item");
					$stmt -> bindparam(":".$item, $valor, PDO::PARAM_STR);	
					$stmt -> execute();					
					return $stmt -> fetch();



				}


			
			}else{
				
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla 
													INNER JOIN clientes
													ON $tabla.idcliente = clientes.idcliente 
													WHERE $item = :$item");
													
				$stmt -> bindparam(":".$item, $valor, PDO::PARAM_STR);
				$stmt -> execute();

				return $stmt -> fetch();
				
			}
		}else{
			if ($tabla == "usuariosclientes") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla 
													   INNER JOIN clientes
													   ON $tabla.idcliente = clientes.idcliente");

				$stmt -> execute();

				return $stmt -> fetchAll();				
			}else{
				
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

				$stmt -> execute();

				return $stmt -> fetchAll();

			}
		}

		$stmt -> close();

		$stmt = null;

	}

	static public function mdlActualizarUsuario($tabla,$item1,$item2,$valor1,$valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item2 = :$item2 WHERE $item1 = :$item1");

		$stmt -> bindParam(":".$item1, $valor1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $valor2, PDO::PARAM_STR);
		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";

		}

		$stmt -> close();

		$stmt = null;		
	}


}