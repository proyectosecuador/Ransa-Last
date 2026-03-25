<?php

require_once "conexion.php";

class ModeloSolQR{

	/*=============================================
	=            CONSULTAR SOLICITUDES QR            =
	=============================================*/
	static public function mdlConsultarSolQR($tabla,$item,$datos){

		/**
		
			ESTADOS:
			- 1 =>  REGISTRO
			- 2 => CLASIFICADO A ESPERA DE CARGAR ANALISIS
			- 3 => ANALISIS CARGADO A ESPERA DE APROBACION
			- 4 => ANALISIS APROBADO A ESPERA DE REPUESTA CLIENTE
		
		 */
		/**
		
			ESTADO ANALISIS:
			- 1 => ANALISIS CARGADO
			- 2 => NO ME PERTENECE
			- 3 => APROBADO
			- 4 => RE-CLASIFICAR
			- 5 => REVISAR NUEVAMENTE
		
		 */

		if ($item != null) {
			 var_dump($item);
			if ($item == "idusuarioresponsable") {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item LIKE :item");
			   // var_dump($stmt);
			 	$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

			 	$stmt -> execute();

			 	return $stmt -> fetchAll();
			   }
			if ($item == "negocio_asignado") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");
				// var_dump($stmt);
				$stmt->bindParam(":item",$datos, PDO::PARAM_INT);

				$stmt -> execute();

				return $stmt -> fetchAll();
			} else{
				// var_dump($datos);
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");

				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

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
	/*=========================================================
	=            ACTUALIZACION DE SOLICITUDES Q R             =
	=========================================================*/
	static public function mdlActualizarSolQR($tabla,$item,$datos){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :estado WHERE $item = :idsolicitudes_qr");

		$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
		$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);
		

		if($stmt->execute()){



			return "ok";



		}else{



			return "error";

		

		}



		$stmt->close();

		$stmt = null;	

		
	}	
	/*=============================================
	=            ACTUALIZAR AL NIVEL 3            =
	=============================================*/
	static public function mdlActualizarSolQRNivel($tabla,$item,$datos){
		// var_dump($datos);
		// die();
		if ($datos["estado"] == 3) {
			if ($datos["estado_analisi"] == 5) {//VOLVER A REVISAR ANALISIS
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_analisis = GETDATE(), iduseraproanali = :iduseraproanali, estado = :estado, estado_analisi = :estado_analisi,motivo_causar = :motivo_causar WHERE $item = :idsolicitudes_qr");

				$stmt->bindParam(":iduseraproanali",$datos["iduseraproanali"], PDO::PARAM_INT);
				$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);
				$stmt->bindParam(":motivo_causar",$datos["motivo_causar"], PDO::PARAM_STR);
				$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
				$stmt->bindParam(":estado_analisi",$datos["estado_analisi"], PDO::PARAM_INT);			
			}else{
				$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_analisis = GETDATE(), idusercarganalisis = :idusercarganalisis, archivo_causar = :archivo_causar,coment_causar = :coment_causar ,estado = :estado, estado_analisi = :estado_analisi,motivo_causar = :motivo_causar WHERE $item = :idsolicitudes_qr");

				$stmt->bindParam(":archivo_causar",$datos["archivo_causar"], PDO::PARAM_STR);
				$stmt->bindParam(":coment_causar",$datos["coment_causar"], PDO::PARAM_STR);
				$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);
				$stmt->bindParam(":motivo_causar",$datos["motivo_causar"], PDO::PARAM_STR);
				$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
				$stmt->bindParam(":idusercarganalisis",$datos["idusercarganalisis"], PDO::PARAM_INT);
				$stmt->bindParam(":estado_analisi",$datos["estado_analisi"], PDO::PARAM_INT);
			}

			
		}else if ($datos["estado"] == 4) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_analisis = GETDATE(), estado_analisi = :estado_analisi, iduseraproanali = :iduseraproanali, estado = :estado WHERE $item = :idsolicitudes_qr");

			$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);
			$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
			$stmt->bindParam(":iduseraproanali",$datos["iduseraproanali"], PDO::PARAM_INT);
			$stmt->bindParam(":estado_analisi",$datos["estado_analisi"], PDO::PARAM_INT);
		}else if ($datos["estado"] == 5) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET notificadoa = :notificadoa, fech_resp_enviada = GETDATE(),iduser_respuesta_enviada = :iduser_respuesta_enviada, text_respuesta = :text_respuesta,  estado = :estado WHERE $item = :idsolicitudes_qr");

			$stmt->bindParam(":iduser_respuesta_enviada",$datos["iduser_respuesta_enviada"], PDO::PARAM_INT);
			$stmt->bindParam(":text_respuesta",$datos["text_respuesta"], PDO::PARAM_STR);
			$stmt->bindParam(":notificadoa",$datos["notificadoa"], PDO::PARAM_STR);
			$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);
			$stmt->bindParam(":idsolicitudes_qr",$datos["idsolicitudes_qr"], PDO::PARAM_INT);
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