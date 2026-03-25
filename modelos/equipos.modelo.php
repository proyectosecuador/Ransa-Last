<?php

require_once "conexion.php";

//Estados
// 0 => Eliminado
// 1 => Activo
// 2 => Inoperativo

class ModeloEquipos{

	/*============================================

	=            REGISTRO DE EQUIPOS            =

	============================================*/

	static public function mdlRegistrarEquipos($tabla,$datos){

		

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (nom_equipo,modelo,idciudad,idtipo_equipo,serie,codigo,idusuario,idlocalizacion,idequi_padre,valor_concatenado,horo_inicial,estado,idcentro_costo,fecha_regis, codigo_bateria) VALUES (:Equipo,:modelo,:ciudad,:tipoEquipo,:serie,:codigo,:iduser,:localizacion,:epadre,:concatenar,:horometro,1,:centrocosto,GETDATE(),:baterias)");



		$stmt->bindParam(":Equipo",$datos["Equipo"], PDO::PARAM_STR);

		$stmt->bindParam(":modelo",$datos["modelo"], PDO::PARAM_STR);

		$stmt->bindParam(":ciudad",$datos["ciudad"], PDO::PARAM_INT);

		$stmt->bindParam(":tipoEquipo",$datos["tipoEquipo"], PDO::PARAM_INT);

		$stmt->bindParam(":serie",$datos["serie"], PDO::PARAM_STR);

		$stmt->bindParam(":baterias",$datos["baterias"], PDO::PARAM_STR);

		$stmt->bindParam(":codigo",$datos["codigo"], PDO::PARAM_STR);

		$stmt->bindParam(":iduser",$datos["iduser"], PDO::PARAM_INT);

		$stmt->bindParam(":localizacion",$datos["localizacion"], PDO::PARAM_INT);

		$stmt->bindParam(":epadre",$datos["epadre"], PDO::PARAM_INT);

		$stmt->bindParam(":horometro",$datos["horometro"], PDO::PARAM_INT);

		$stmt->bindParam(":concatenar",$datos["concatenar"], PDO::PARAM_STR);

		$stmt->bindParam(":centrocosto",$datos["centrocosto"], PDO::PARAM_INT);



		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}

	



		$stmt -> close();



		$stmt = null;		

	}



	/*===========================================

	=            CONSULTA DE EQUIPOS            =

	===========================================*/

	static public function mdlConsultarEquipos($tabla,$dato,$item){



		if (isset($item) && !empty($item)) {

			if (is_array($item) && is_array($dato) && $dato["codigov"] == "%MC%") {

if($_SESSION["ciudad"]==1) //gye
{
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE {$item["codigo"]} LIKE :vcodigo AND {$item["estado"]} != :vestado AND {$item["idciudad"]} = :vciudad  OR codigo LIKE '%YALE%'  ORDER BY codigo asc ");

} else {
	$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE {$item["codigo"]} LIKE :vcodigo AND {$item["estado"]} != :vestado AND {$item["idciudad"]} = :vciudad  ORDER BY codigo asc ");

}


				$stmt->bindParam(":vcodigo",$dato["codigov"], PDO::PARAM_STR);

				$stmt->bindParam(":vestado",$dato["estadov"], PDO::PARAM_INT);

				$stmt->bindParam(":vciudad",$dato["idciudadv"], PDO::PARAM_STR);



			}else if($item == "idciudad"){
				$stmt = Conexion::conectar()->prepare("SELECT eq.idlocalizacion, eq.codigo_bateria, eq.idequipomc, eq.fecha_regis, eq.valor_concatenado, te.nom_eq,l.nom_localizacion,CASE WHEN eq.estado = 1 THEN 'OPERATIVO' WHEN eq.estado = 2 THEN 'INOPERATIVO' ELSE 'Mantenimiento' END AS 'estado' FROM equipomc eq  INNER JOIN localizacion l ON eq.idlocalizacion = l.idlocalizacion INNER JOIN tipo_equipo te ON eq.idtipo_equipo = te.idtipo_equipo WHERE eq.estado != 0 AND eq.$item = :idciudad");

				$stmt->bindParam(":idciudad",$dato, PDO::PARAM_STR);
			}else{

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :id ");

				$stmt->bindParam(":id",$dato, PDO::PARAM_STR);

			}

			$stmt -> execute();

			return $stmt -> fetchAll();

			

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();			

		}



		$stmt -> close();



		$stmt = null;		

	}

	/*==========================================================

	=            MODELO EDITAR DATOS DE LOS EQUIPOS            =

	==========================================================*/

	static public function mdlEditarEquipos($tabla,$datos,$item){

		

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nom_equipo = :Equipo, idciudad = :ciudad, modelo = :modelo, idtipo_equipo = :tipoEquipo, codigo = :codigo, horo_inicial = :horometro, serie = :serie, idlocalizacion = :idlocalizacion, idequi_padre = :epadre, idusuario = :iduser, valor_concatenado = :concatenar, idcentro_costo = :idcentro_costo, codigo_bateria = :baterias WHERE $item = :idequipo");



		$stmt->bindParam(":Equipo",$datos["Equipo"], PDO::PARAM_STR);

		$stmt->bindParam(":ciudad",$datos["ciudad"], PDO::PARAM_INT);

		$stmt->bindParam(":modelo",$datos["modelo"], PDO::PARAM_STR);

		$stmt->bindParam(":tipoEquipo",$datos["tipoEquipo"], PDO::PARAM_INT);

		$stmt->bindParam(":codigo",$datos["codigo"], PDO::PARAM_STR);

		$stmt->bindParam(":horometro",$datos["horometro"], PDO::PARAM_INT);

		$stmt->bindParam(":serie",$datos["serie"], PDO::PARAM_STR);

		$stmt->bindParam(":baterias",$datos["baterias"], PDO::PARAM_STR);

		$stmt->bindParam(":idequipo",$datos["idequipo"], PDO::PARAM_INT);

		$stmt->bindParam(":idlocalizacion",$datos["idlocalizacion"], PDO::PARAM_INT);

		$stmt->bindParam(":epadre",$datos["epadre"], PDO::PARAM_INT);

		$stmt->bindParam(":iduser",$datos["iduser"], PDO::PARAM_INT);

		$stmt->bindParam(":concatenar",$datos["concatenar"], PDO::PARAM_STR);

		$stmt->bindParam(":idcentro_costo",$datos["idcentro_costo"], PDO::PARAM_INT);



		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;		

	}

	/*===========================================================

	=            ACTUALIZAR EL ESTADO DE LOS EQUIPOS            =

	===========================================================*/

	static public function mdlActualizarEquiposEstado($tabla,$datos,$item){

		

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE $item = :idequipo");



		$stmt->bindParam(":idequipo",$datos["idequipo"], PDO::PARAM_INT);

		$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_STR);



		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;		

	}	

	

	

	

	/*=========================================================

	=            REGISTRO DE ASIGNACION DE EQUIPOS            =

	=========================================================*/



	static public function mdlAsignarEquipos($tabla,$datos){

		

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idusuariosransa,llave,responsable,turno,idequipomc,estado,idusuarioasignador,fecha_ingreso) VALUES (:idusuariosransa,:llave,:responsable,:turno,:idequipomc,1,:idusuarioasignador,GETDATE())");



		$stmt->bindParam(":idusuariosransa",$datos["idusuarioransa"], PDO::PARAM_STR);

		$stmt->bindParam(":llave",$datos["llave"], PDO::PARAM_STR);

		$stmt->bindParam(":responsable",$datos["responsable"], PDO::PARAM_STR);

		$stmt->bindParam(":turno",$datos["turno"], PDO::PARAM_STR);

		$stmt->bindParam(":idequipomc",$datos["idequipomc"], PDO::PARAM_STR);

		$stmt->bindParam(":idusuarioasignador",$datos["iduser"], PDO::PARAM_INT);



		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}

	



		$stmt -> close();



		$stmt = null;		

	}

	/*=========================================================

	=            CONSULTA DE ASIGNACION DE EQUIPOS            =

	=========================================================*/

	static public function mdlConsultarAsignacionEquipos($tabla,$datos,$item){

		if (isset($item) != "" && !empty($item)) {

			if (isset($item) && !empty($item) && $item == "idequipomc") {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :id");

				$stmt->bindParam(":id",$datos, PDO::PARAM_STR);



				$stmt -> execute();

				return $stmt -> fetchAll();	

				

			}else if (isset($item) && $item == "ideasignacion" ) {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :id");

				$stmt->bindParam(":id",$datos, PDO::PARAM_STR);



				$stmt -> execute();

				return $stmt -> fetch();	

			}
			else if ((isset($item) && $item == "idciudad")) {

				$stmt = Conexion::conectar()->prepare("SELECT ea.ideasignacion,e.codigo,ur.primernombre,ur.primerapellido,CONCAT('TURNO',ea.turno) AS turno,ea.responsable,ea.llave
														FROM easignacion ea 
														INNER JOIN equipomc e ON ea.idequipomc = e.idequipomc
														INNER JOIN usuariosransa ur ON ea.idusuariosransa = ur.id
														WHERE e.$item = :id AND ea.estado = 1 AND e.estado != 0 order by ea.llave desc");

				$stmt->bindParam(":id",$datos, PDO::PARAM_STR);



				$stmt -> execute();

				return $stmt -> fetchAll();

			}else if (isset($item) && $item["turno"] == "turno" ) {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE {$item["idequipo"]} = :idequipo AND {$item["turno"]} = :turno AND estado = '1'");

				$stmt->bindParam(":idequipo",$datos["idequipo"], PDO::PARAM_STR);

				$stmt->bindParam(":turno",$datos["turno"], PDO::PARAM_STR);



				$stmt -> execute();

				return $stmt -> fetch();					

				

			}	

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();	



		}

	}



	/*================================================================================================

	=            ELIMINAR LA ASIGNACION REGISTRADA EN LA BASE SOLO SE ACTUALIZA EL ESTADO            =

	================================================================================================*/

	static public function mdlEliminarAsignacion($tabla,$dato,$item){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado, fecha_eliminado = GETDATE() WHERE ideasignacion = :ideasignacion");

		$estado = 0;

		$stmt->bindParam(":estado",$estado, PDO::PARAM_INT);

		$stmt->bindParam(":ideasignacion",$dato, PDO::PARAM_STR);



		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;		

	}

	/*============================================================================

		=            ELIMINAR EL EQUIPO EN LA BASE SE ACTUALIZA EL ESTADO            =

	============================================================================*/

	static public function mdlEliminarEquipo($tabla,$item1,$valor1,$item2,$valor2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item2 = :estado, fecha_eliminado = GETDATE() WHERE $item1 = :idequipo");

		$stmt->bindParam(":estado",$valor2, PDO::PARAM_INT);

		$stmt->bindParam(":idequipo",$valor1, PDO::PARAM_STR);



		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;



	}

		

			

	

}