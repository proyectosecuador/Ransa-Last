<?php

require_once "conexion.php";

class ModeloManejoeq{

	/*============================================
	=            INSERTAR PROVEEDORES            =
	============================================*/
	static public function mdlInsertarManejoeq($tabla,$datos){

		/**
		 *
		 * ESTADOS :
		 * 2 ==> equipo en uso
		 * 1 ==> equipo cerrado uso
		 * 3 ==> No se hizo el cierre de equipo
		 */
		
		
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idpersonal,idequipo,idusuario,opc1,opc2,opc3,opc4,opc5,opc6,opc7,identbateriainicio,rayacargaini,porcentcargainicio,horometroinicial,observaciones,estado,codigo_bateria) VALUES (:idpersonal,:idequipo,:idusuario,:opc1,:opc2,:opc3,:opc4,:opc5,:opc6,:opc7,:identbateriainicio,:rayacargaini,:porcentcargainicio,:horometroinicial,:observaciones,2,:codigo_bateria)");

		$stmt->bindParam(":idpersonal",$datos["idpersonal"], PDO::PARAM_INT);
		$stmt->bindParam(":idequipo",$datos["idequipo"], PDO::PARAM_INT);
		$stmt->bindParam(":idusuario",$datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":opc1",$datos["opc1"], PDO::PARAM_STR);
		$stmt->bindParam(":opc2",$datos["opc2"], PDO::PARAM_STR);
		$stmt->bindParam(":opc3",$datos["opc3"], PDO::PARAM_STR);
		$stmt->bindParam(":opc4",$datos["opc4"], PDO::PARAM_STR);
		$stmt->bindParam(":opc5",$datos["opc5"], PDO::PARAM_STR);
		$stmt->bindParam(":opc6",$datos["opc6"], PDO::PARAM_STR);
		$stmt->bindParam(":opc7",$datos["opc7"], PDO::PARAM_STR);
		$stmt->bindParam(":identbateriainicio",$datos["identbateriainicio"], PDO::PARAM_STR);
		$stmt->bindParam(":rayacargaini",$datos["rayacargaini"], PDO::PARAM_STR);
		$stmt->bindParam(":porcentcargainicio",$datos["porcentcargainicio"], PDO::PARAM_INT);
		$stmt->bindParam(":horometroinicial",$datos["horometroinicial"], PDO::PARAM_INT);
		$stmt->bindParam(":codigo_bateria",$datos["codigo_bateria"], PDO::PARAM_STR);
		$stmt->bindParam(":observaciones",$datos["observaciones"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;		
	}
	
	
	

	/*=============================================
	=            CONSULTAR USO DE EQUIPOS            =
	=============================================*/
	static public function mdlConsultarManejoeq($tabla,$item,$datos){

		if ($item != null) {
			if ($item == "idmanejoeq") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");

				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);
				$stmt -> execute();

				return $stmt -> fetch();
			}else if (isset($item["estado"])) {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE {$item['estado']} = :item");

				$stmt->bindParam(":item",$datos["estado"], PDO::PARAM_STR);
				$stmt -> execute();

				return $stmt -> fetchAll();
			}
			else if ($item == "idciudad") {
				$stmt = Conexion::conectar()->prepare("SET LANGUAGE español
													SELECT 
													me.idmanejoeq,
													e.codigo,
													e.codigo_bateria AS Bateria,
													CONCAT(ur.primernombre,' ',ur.primerapellido) AS solicitante,
													p.nombres_apellidos,
													me.fecha_inicio,
													me.fecha_fin,
													me.horometroinicial,
													me.horometrotermino,
													me.horoinicioproximo,
													me.codigo_bateria,
													me.observaciones,
													CASE 
														WHEN me.horometrotermino IS NULL AND me.estado = 3 
														THEN (me.horoinicioproximo - me.horometroinicial)
														ELSE (me.horometrotermino - me.horometroinicial)
													END AS h_trabajada,
													me.porcentcargainicio,
													me.porcencargatermino,
													me.ubicacionfinal,
													DATENAME(MONTH,me.fecha_inicio) as mes,
													me.estado,
													CONCAT('SEMANA ',DATENAME(WEEK,me.fecha_inicio)) as semana
													FROM manejoeq me
													INNER JOIN personal p ON me.idpersonal = p.idpersonal
													INNER JOIN equipomc e ON me.idequipo = e.idequipomc
													INNER JOIN usuariosransa ur ON me.idusuario = ur.id
													WHERE (me.estado = 3 OR me.estado = 1) AND e.idciudad = :idciudad AND YEAR(me.fecha_inicio) > YEAR(dateadd(YEAR,-1,GETDATE())) ORDER BY me.fecha_inicio DESC
													");
													                                                                            
				$stmt->bindParam(":idciudad",$datos, PDO::PARAM_STR);
				$stmt -> execute();
				return $stmt -> fetchAll();				
				
			}
		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");
			$stmt -> execute();
			return $stmt -> fetchAll();
		}
			

		

		$stmt -> close();

		$stmt = null;

		
	}

	/*======================================================
	=            ACTUALIZAR EL MANEJO DE EQUIPO            =
	======================================================*/

		static public function mdlActualizarManejoeq($tabla,$item,$datos){
		
		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET horometrotermino = :horometrotermino, fecha_fin = dateadd(hour,(-5),getdate()), rayacargafinal = :rayacargafinal, porcencargatermino = :porcencargatermino, identbateriatermino = :identbateriatermino, observacionesfinal =:observacionesfinales, ubicacionfinal = :ubicacionfinal, estado = 1 WHERE $item = :idmanejoeq");

		$stmt->bindParam(":idmanejoeq",$datos["idmanejoeq"], PDO::PARAM_INT);
		$stmt->bindParam(":horometrotermino",$datos["horometrotermino"], PDO::PARAM_INT);
		$stmt->bindParam(":rayacargafinal",$datos["rayacargafinal"], PDO::PARAM_INT);
		$stmt->bindParam(":porcencargatermino",$datos["porcencargatermino"], PDO::PARAM_INT);
		$stmt->bindParam(":identbateriatermino",$datos["identbateriatermino"], PDO::PARAM_STR);
		$stmt->bindParam(":observacionesfinales",$datos["observacionesfinales"], PDO::PARAM_STR);
		$stmt->bindParam(":ubicacionfinal",$datos["ubicacionfinal"], PDO::PARAM_STR);

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;		
	}

	/*==========================================================
	=            NOTIFICAR LA NO ENTREGA DE EQUIPOS            =
	==========================================================*/
	static public function mdlNotificarNoEntrega($tabla,$item,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = 3, usuarionotificador = :solicitante, idpersonalusaeqxnoti = :idpersonalusaeqxnoti, horoinicioproximo = :horoinicioproximo WHERE $item = :idmanejoeq");

		$stmt->bindParam(":idmanejoeq",$datos["idmanejoeq"], PDO::PARAM_INT);
		$stmt->bindParam(":solicitante",$datos["idsolicitante"], PDO::PARAM_INT);
		$stmt->bindParam(":idpersonalusaeqxnoti",$datos["idpersonalusaeqxnoti"], PDO::PARAM_INT);
		$stmt->bindParam(":horoinicioproximo",$datos["horometrodelotroInicio"], PDO::PARAM_INT);
		

		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}

		$stmt->close();
		$stmt = null;	

	}
	
	
	
	
	
	
}