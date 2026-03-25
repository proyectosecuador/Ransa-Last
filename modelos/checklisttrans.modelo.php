<?php

require_once "conexion.php";

class ModeloCheckTransporte
{

	/*=======================================================================
	=            INSERTAR ID DE MOVIMIENTO CHECK LIST TRANSPORTE            =
	=======================================================================*/
	static public function mdlInsertarCheckTransporte($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idmov_recep_desp,transportista,placa,estado) VALUES (:valor1,:valor2,:valor3,1)");

		$stmt->bindParam(":valor1", $datos["idmovimiento"], PDO::PARAM_INT);
		$stmt->bindParam(":valor2", $datos["transportista"], PDO::PARAM_STR);
		$stmt->bindParam(":valor3", $datos["placa"], PDO::PARAM_STR);

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}


		$stmt->close();

		$stmt = null;
	}
/*=======================================================================
	=            INSERTAR SOLO PREGUNTAS CON SU RESPECTIVO ID            =
	=======================================================================*/
static public function mdlInsertarCheckCompleto($tabla, $datos)
{
    $stmt = Conexion::conectar()->prepare("
        INSERT INTO $tabla (
            idmov_recep_desp, realizadopor, transportista, placa, observaciones,
            ppt, obsppt, pa, obspa, mi, obsmi, plaga, obsplaga, oe, obsoe,
            oquimicos, obsoquimicos, sellos, obssellos, imagenes, estado
        ) VALUES (
            :idmov_recep_desp, :realizadopor, :transportista, :placa, :obstransporte,
            :ppt, :obsppt, :pa, :obspa, :mi, :obsmi, :plaga, :obsplaga, :oe, :obsoe,
            :oquimicos, :obsoquimicos, :sellos, :obssellos, :imagenes, 1
        )
    ");
    $stmt->bindParam(":idmov_recep_desp", $datos["idmov_recep_desp"], PDO::PARAM_INT);
    $stmt->bindParam(":realizadopor", $datos["realizadopor"], PDO::PARAM_STR);
    $stmt->bindParam(":transportista", $datos["transportista"], PDO::PARAM_STR);
    $stmt->bindParam(":placa", $datos["placa"], PDO::PARAM_STR);
    $stmt->bindParam(":obstransporte", $datos["observaciones"], PDO::PARAM_STR);
    $stmt->bindParam(":ppt", $datos["ppt"], PDO::PARAM_STR);
    $stmt->bindParam(":obsppt", $datos["obsppt"], PDO::PARAM_STR);
    $stmt->bindParam(":pa", $datos["pa"], PDO::PARAM_STR);
    $stmt->bindParam(":obspa", $datos["obspa"], PDO::PARAM_STR);
    $stmt->bindParam(":mi", $datos["mi"], PDO::PARAM_STR);
    $stmt->bindParam(":obsmi", $datos["obsmi"], PDO::PARAM_STR);
    $stmt->bindParam(":plaga", $datos["plaga"], PDO::PARAM_STR);
    $stmt->bindParam(":obsplaga", $datos["obsplaga"], PDO::PARAM_STR);
    $stmt->bindParam(":oe", $datos["oe"], PDO::PARAM_STR);
    $stmt->bindParam(":obsoe", $datos["obsoe"], PDO::PARAM_STR);
    $stmt->bindParam(":oquimicos", $datos["oquimicos"], PDO::PARAM_STR);
    $stmt->bindParam(":obsoquimicos", $datos["obsoquimicos"], PDO::PARAM_STR);
    $stmt->bindParam(":sellos", $datos["sellos"], PDO::PARAM_STR);
    $stmt->bindParam(":obssellos", $datos["obssellos"], PDO::PARAM_STR);
    $stmt->bindParam(":imagenes", $datos["imagenes"], PDO::PARAM_STR);

    if ($stmt->execute()) {
        return "ok";
    } else {
        return "error";
    }
}



	/*=====================================
	=            INSERTAR CHECK LIST DE TRANSPORTE            =
	=====================================*/
	// static public function mdlInsertarCheckTransporte($tabla,$datos){

	// 	$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idmov_recep_desp,realizadopor,transportista,placa,ppt,pa,mi,plaga,oe,oquimicos,observaciones,obsppt,obspa,obsmi,obsplaga,obsoe,obsoquimicos,imagenes,estado,fecha_regis) VALUES (:valor1,:valor2,:valor3,:valor4,:valor5,:valor6,:valor7,:valor8,:valor9,:valor10,:valor11,:valor12,:valor13,:valor14,:valor15,:valor16,:valor17,:valor18,1,NOW())");

	// 	$stmt->bindParam(":valor1",$datos["idmovimiento"], PDO::PARAM_INT);
	// 	$stmt->bindParam(":valor2",$datos["responsablechecktrans"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor3",$datos["transportista"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor4",$datos["placa"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor5",$datos["pptl"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor6",$datos["pa"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor7",$datos["mincom"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor8",$datos["plaga"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor9",$datos["oextranios"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor10",$datos["oquimicos"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor11",$datos["obstransporte"], PDO::PARAM_STR);


	// 	$stmt->bindParam(":valor12",$datos["obspptl"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor13",$datos["obspa"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor14",$datos["obsmincom"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor15",$datos["obsplaga"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor16",$datos["obsoextranios"], PDO::PARAM_STR);
	// 	$stmt->bindParam(":valor17",$datos["obsoquimicos"], PDO::PARAM_STR);




	// 	$stmt->bindParam(":valor18",$datos["imagenes"], PDO::PARAM_STR);

	// 	if($stmt->execute()){

	// 		return "ok";

	// 		// $stmt = Conexion::conectar()->query("SELECT MAX(idchcklsttrans) AS id FROM $tabla");
	// 		// $Id = $stmt->fetchColumn();
	// 		// return $Id;

	// 	}else{

	// 		return "error";

	// 	}


	// 	$stmt -> close();

	// 	$stmt = null;


	// }




	/*===============================================
	=            CONSULTAR CHECK LIST DE TRANSPORTE            =
	===============================================*/
	static public function mdlConsultarCheckTransporte($tabla, $item, $datos)
	{

		if (empty($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();
		} else {
			if ($item == "idciudad") {
				$c_sentece = "";
				if(isset($datos[0]["idusuario"])){
					$c_sentece = 'm.idusuario = :idusuario AND';
				} 
				$stmt = Conexion::conectar()->prepare("SELECT cht.idchcklsttrans,m.idmov_recep_desp, CONVERT(smalldatetime,m.fecha_programada) AS fecha_programada, nguias, c.razonsocial,a.descripcion,cht.realizadopor
														FROM chcklsttrans cht
														INNER JOIN mov_recep_desp m ON cht.idmov_recep_desp = m.idmov_recep_desp
														INNER JOIN clientes c ON m.idcliente = c.idcliente
														INNER JOIN actividad_estiba a ON m.idactividad = a.idactividad_estiba
														WHERE $c_sentece (m.estado = 4 OR m.estado = 7 OR m.estado = 8) 
														AND m.estado != 0 
														AND (a.descripcion = 'DESPACHO' OR a.descripcion = 'RECEPCIÓN' OR a.descripcion = 'REPALETIZADO')
														-- AND YEAR(cht.fecha_regis) = YEAR(GETDATE())
														 --AND YEAR(cht.fecha_regis) > YEAR(dateadd(YEAR,-2,GETDATE()))
														 --AND MONTH(cht.fecha_regis) > MONTH(dateadd(MONTH,-2,GETDATE()))
														 AND (
															(m.fecha_programada >= DATEADD(MONTH, -6, GETDATE()))
															  OR
															  (m.fecha_programada >= dateadd(MONTH, 10, DATEADD(YEAR, -1, GETDATE())))
															  OR
															  (m.fecha_programada = GETDATE())
														   )

														AND m.idciudad = :idciudad");
			
				
				$stmt->bindParam(":idciudad", $datos["idciudad"], PDO::PARAM_STR);

/*QUERY QUITAOD DE FILTRO DATA
 AND (
															(m.fecha_programada >= DATEADD(MONTH, -3, GETDATE()))
															  OR
															  (m.fecha_programada >= dateadd(MONTH, 10, DATEADD(YEAR, -1, GETDATE())))
															  OR
															  (m.fecha_programada = GETDATE())
														   )
*/

				if(isset($datos[0]["idusuario"])){
					$stmt->bindParam(":idusuario", $datos[0]["idusuario"], PDO::PARAM_STR);
				}
				$stmt->execute();

				return $stmt->fetchAll();				
			} else {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor1");

				$stmt->bindParam(":valor1", $datos, PDO::PARAM_STR);

				$stmt->execute();

				return $stmt->fetch();
			}
		}



		$stmt->close();

		$stmt = null;
	}

	/*==================================================================
	=            ACTUALIZAR LOS DATOS CHECK LIST TRANSPORTE            =
	==================================================================*/

	static public function mdlActualizarCheckTransporte($tabla, $item, $datos)
	{


		if ($item == "checklist") {
			/* REALIZAR CHECK LIST */

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET realizadopor = :valor1,transportista = :valor3,placa = :valor4,ppt = :valor5,pa = :valor6,mi = :valor7,plaga = :valor8,oe = :valor9, sellos = :valor19, oquimicos = :valor10,observaciones = :valor11,obsppt = :valor12,obspa = :valor13,obsmi = :valor14,obsplaga = :valor15,obsoe = :valor16,obsoquimicos = :valor17, obssellos = :valor20, imagenes = :valor18 WHERE idmov_recep_desp = :item");

			$stmt->bindParam(":item", $datos["idmovimiento"], PDO::PARAM_INT);
			$stmt->bindParam(":valor1", $datos["responsablechecktrans"], PDO::PARAM_STR);
			$stmt->bindParam(":valor3", $datos["transportista"], PDO::PARAM_STR);
			$stmt->bindParam(":valor4", $datos["placa"], PDO::PARAM_STR);
			$stmt->bindParam(":valor5", $datos["pptl"], PDO::PARAM_STR);
			$stmt->bindParam(":valor6", $datos["pa"], PDO::PARAM_STR);
			$stmt->bindParam(":valor7", $datos["mincom"], PDO::PARAM_STR);
			$stmt->bindParam(":valor8", $datos["plaga"], PDO::PARAM_STR);
			$stmt->bindParam(":valor9", $datos["oextranios"], PDO::PARAM_STR);
			$stmt->bindParam(":valor10", $datos["oquimicos"], PDO::PARAM_STR);
			$stmt->bindParam(":valor19", $datos["sellos"], PDO::PARAM_STR);
			$stmt->bindParam(":valor11", $datos["obstransporte"], PDO::PARAM_STR);


			$stmt->bindParam(":valor12", $datos["obspptl"], PDO::PARAM_STR);
			$stmt->bindParam(":valor13", $datos["obspa"], PDO::PARAM_STR);
			$stmt->bindParam(":valor14", $datos["obsmincom"], PDO::PARAM_STR);
			$stmt->bindParam(":valor15", $datos["obsplaga"], PDO::PARAM_STR);
			$stmt->bindParam(":valor16", $datos["obsoextranios"], PDO::PARAM_STR);
			$stmt->bindParam(":valor17", $datos["obsoquimicos"], PDO::PARAM_STR);
			$stmt->bindParam(":valor20", $datos["obssellos"], PDO::PARAM_STR);
			$stmt->bindParam(":valor18", $datos["imagenes"], PDO::PARAM_STR);
		} else {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET placa = :placa, transportista = :transportista  WHERE $item = :item");

			$stmt->bindParam(":placa", $datos["placa"], PDO::PARAM_STR);
			$stmt->bindParam(":item", $datos["idmovimiento"], PDO::PARAM_INT);
			$stmt->bindParam(":transportista", $datos["conductor"], PDO::PARAM_STR);
		}

		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}

		$stmt->close();
		$stmt = null;
	}
}
