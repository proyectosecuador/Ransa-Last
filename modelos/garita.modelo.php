<?php

// require_once "conexion.php";

// class ModeloGarita{

// 	/*=====================================
// 	=            INSERTAR DATOS DE GARITA            =
// 	=====================================*/
// 	static public function mdlInsertarGarita($tabla,$datos){

// 		/**
// 		 *
// 		 * ESTADOS DEL VEHICULO GARITA
// 		 * 
// 		 * 1 ==> INGRESO DE VEHICULO // A ESPERA
// 		 * 2 ==> INGRESO Y SE DIRIGE A PUERTA
// 		 * 3 ==> SALIDA DEL VEHICULO
// 		 * 0 ==> Eliminado
// 		 *
// 		 */
		

// 		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idmov_recep_desp,idusuarios_garita,fecha_llegada,idpers_autoriza,sellos_entrada,ci_chofer,comp_transp,tipo_vehiculo,cta_ransa,ayudantes,cedulas_ayudantes,obs_garita_ingreso,fecha_registro,estado,guia_entrada,fecha_sube_bodega,puerta_asignada) VALUES (:idmov_recep_desp,:idusuarios_garita,NOW(),:idpers_autoriza,:sellos_entrada,:ci_chofer,:comp_transp,:tipo_vehiculo,:cta_ransa,:ayudantes,:cedulas_ayudantes,:obs_garita_ingreso,NOW(),:estadov,:guia_entrada,:fecha_sube_bodega,:puerta_asignada)");

// 		$stmt->bindParam(":idmov_recep_desp",$datos["idmovimiento"], PDO::PARAM_INT);
// 		$stmt->bindParam(":idusuarios_garita",$datos["idusuarios_garita"], PDO::PARAM_INT);
// 		$stmt->bindParam(":idpers_autoriza",$datos["idPers_autoriza"], PDO::PARAM_INT);
// 		$stmt->bindParam(":sellos_entrada",$datos["sello"], PDO::PARAM_STR);
// 		$stmt->bindParam(":ci_chofer",$datos["cedula"], PDO::PARAM_STR);
// 		$stmt->bindParam(":comp_transp",$datos["comp_transp"], PDO::PARAM_STR);
// 		$stmt->bindParam(":tipo_vehiculo",$datos["tipovehiculo"], PDO::PARAM_STR);
// 		$stmt->bindParam(":cta_ransa",$datos["ctaR"], PDO::PARAM_STR);
// 		$stmt->bindParam(":ayudantes",$datos["ayudante"], PDO::PARAM_STR);
// 		$stmt->bindParam(":cedulas_ayudantes",$datos["ciayudante"], PDO::PARAM_STR);
// 		$stmt->bindParam(":obs_garita_ingreso",$datos["observIngreso"], PDO::PARAM_STR);
// 		$stmt->bindParam(":guia_entrada",$datos["guiaentrada"], PDO::PARAM_STR);
// 		$stmt->bindParam(":fecha_sube_bodega",$datos["fecha_sube_bodega"], PDO::PARAM_STR);
// 		$stmt->bindParam(":puerta_asignada",$datos["puerta_asignada"], PDO::PARAM_STR);
// 		$stmt->bindParam(":estadov",$datos["estadov"], PDO::PARAM_INT);
		

// 		if($stmt->execute()){

// 			return "ok";

// 		}else{

// 			return "error";
		
// 		}
	

// 		$stmt -> close();

// 		$stmt = null;


// 	}
	
	
	

// 	/*===============================================
// 	=            CONSULTAR DATOS DE GARITA            =
// 	===============================================*/
// 	static public function mdlConsultarGarita($tabla,$item,$datos){

// 		if (!empty($item)) {
// 			if ($item == "cantList") {
// 				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla G INNER JOIN mov_recep_desp M ON G.idmov_recep_desp = M.idmov_recep_desp WHERE M.idactividad IS NULL OR G.puerta_asignada IS NULL AND M.estado != 6 AND M.estado != 7 AND M.estado != 0 AND M.estado != 8 AND M.estado != 9");

// 				$stmt -> execute();

// 				return $stmt -> fetchAll();						
// 			}else if (isset($item["rangofechasGarita"])) {
// 				$stmt = Conexion::conectar()->prepare("CALL sp_download_garita(:idgarita,:desde,:hasta)");
// 				$stmt->bindParam(":desde",$datos["desde"], PDO::PARAM_STR);
// 				$stmt->bindParam(":hasta",$datos["hasta"], PDO::PARAM_STR);
// 				$stmt->bindParam(":idgarita",$datos["idgarita"], PDO::PARAM_INT);

// 				$stmt -> execute();
// 				$resultado = $stmt->setFetchMode(PDO::FETCH_NUM);

// 				return $stmt -> fetchAll();	
// 			}
// 			else{
// 				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");

// 				$stmt->bindParam(":item",$datos, PDO::PARAM_STR);

// 				$stmt -> execute();

// 				return $stmt -> fetch();						
// 			}
// 		}else{
// 			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

// 			$stmt -> execute();

// 			return $stmt -> fetchAll();			
// 		}



// 		$stmt -> close();

// 		$stmt = null;
// 	}

// 	/*=======================================================
// 	=            MODIFICAR DAROS DE TABLA GARITA            =
// 	=======================================================*/
// 	static public function mdlEditarGarita($tabla,$datos,$item){

// 		if (isset($item["puerta"])) {
// 			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_sube_bodega = NOW(), puerta_asignada = :puerta_asignada,estado = 2 WHERE idgarita = :idgarita");
			
// 			$stmt->bindParam(":puerta_asignada",$datos["puerta_asignada"], PDO::PARAM_STR);
// 			$stmt->bindParam(":idgarita",$item["puerta"], PDO::PARAM_STR);

			
// 		}else if(isset($item["salidaidgarita"])){
// 			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET obs_garita_salida = :obs_garita_salida, fecha_salida = NOW(), guia_salida = :guia_salida, sellos_salida = :sellos_salida, estado = 3 WHERE idgarita = :idgarita");
			
// 			$stmt->bindParam(":obs_garita_salida",$datos["observIngreso"], PDO::PARAM_STR);
// 			$stmt->bindParam(":guia_salida",$datos["guiaentrada"], PDO::PARAM_STR);
// 			$stmt->bindParam(":sellos_salida",$datos["sello"], PDO::PARAM_STR);
// 			$stmt->bindParam(":idgarita",$item["salidaidgarita"], PDO::PARAM_INT);
// 		}
// 		if($stmt->execute()){

// 			return "ok";

// 		}else{

// 			return "error";
		
// 		}
	

// 		$stmt -> close();

// 		$stmt = null;			



		

// 	}
	
	
	
// }