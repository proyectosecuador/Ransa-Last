<?php

require_once "conexion.php";

class ModeloCheckList{

	/*=====================================
	=            INSERTAR NUEVO REGISTRO DE CHECKLIST            =
	=====================================*/
	public static function mdlRegistroCheckList($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idequipomc,eqp1, eqp2, eqp3, eqp4, eqp5, eqp6, eqp7, btr1, btr2, cbtr1, cbtr2, crgd1, crgd2, crgd3,oprc1,oprc2,oprc3,oprc4,oprc5,oprc6,oprc7,oprc8,oprc9, cantinovedad ,horometro,ideasignacion,observacion,motivoatraso,estado,motivo_bloqueo)VALUES(:idequipomc,:eqp1,:eqp2,:eqp3,:eqp4,:eqp5,:eqp6,:eqp7,:btr1,:btr2,:cbtr1,:cbtr2,:crgd1,:crgd2,:crgd3,:oprc1,:oprc2,:oprc3,:oprc4, :oprc5,:oprc6,:oprc7,:oprc8,:oprc9,:cantinovedad,:horometro,:ideasignacion,:observacion,:motivoatraso,:estado,:motivobloq)");

		$stmt->bindParam(":idequipomc",$datos["idequipomc"], PDO::PARAM_INT);
		$stmt->bindParam(":eqp1",$datos["eqp1"], PDO::PARAM_INT);
		$stmt->bindParam(":eqp2",$datos["eqp2"], PDO::PARAM_INT);
		$stmt->bindParam(":eqp3",$datos["eqp3"], PDO::PARAM_INT);
		$stmt->bindParam(":eqp4",$datos["eqp4"], PDO::PARAM_INT);
		$stmt->bindParam(":eqp5",$datos["eqp5"], PDO::PARAM_INT);
		$stmt->bindParam(":eqp6",$datos["eqp6"], PDO::PARAM_INT);
		$stmt->bindParam(":eqp7",$datos["eqp7"], PDO::PARAM_INT);
		$stmt->bindParam(":btr1",$datos["btr1"], PDO::PARAM_INT);
		$stmt->bindParam(":btr2",$datos["btr2"], PDO::PARAM_INT);
		$stmt->bindParam(":cbtr1",$datos["cbtr1"], PDO::PARAM_INT);
		$stmt->bindParam(":cbtr2",$datos["cbtr2"], PDO::PARAM_INT);
		$stmt->bindParam(":crgd1",$datos["crgd1"], PDO::PARAM_INT);
		$stmt->bindParam(":crgd2",$datos["crgd2"], PDO::PARAM_INT);
		$stmt->bindParam(":crgd3",$datos["crgd3"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc1",$datos["oprc1"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc2",$datos["oprc2"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc3",$datos["oprc3"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc4",$datos["oprc4"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc5",$datos["oprc5"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc6",$datos["oprc6"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc7",$datos["oprc7"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc8",$datos["oprc8"], PDO::PARAM_INT);
		$stmt->bindParam(":oprc9",$datos["oprc9"], PDO::PARAM_INT);
		$stmt->bindParam(":cantinovedad",$datos["cantinovedad"], PDO::PARAM_INT);
		$stmt->bindParam(":horometro",$datos["horometro"], PDO::PARAM_INT);
		$stmt->bindParam(":ideasignacion",$datos["ideasignacion"], PDO::PARAM_INT);
		$stmt->bindParam(":observacion",$datos["observacion"], PDO::PARAM_STR);
		$stmt->bindParam(":motivoatraso",$datos["motivoatraso"], PDO::PARAM_STR);
		$stmt->bindParam(":estado",$datos["estado"], PDO::PARAM_INT);
		$stmt->bindParam(":motivobloq",$datos["motivobloq"], PDO::PARAM_STR);
		

		

		if($stmt->execute()){
			$stmt = Conexion::conectar()->query("SELECT MAX(idchcklstq ) AS id FROM $tabla");
			$Id = $stmt->fetchColumn();
			return $Id;

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	
	
	

	/*===============================================
	=            CONSULTAR CHECK LIST            =
	===============================================*/
	static public function mdlConsultarCheckList($tabla,$valor1,$valor2,$item1,$item2){

		if ($item1 != "" || $item2 != "") {
			if ($item2 == "fecha") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM chcklstq WHERE CAST($item2 AS DATE) = :fecha AND $item1 = :idequipo");
				$stmt->bindParam(":idequipo",$valor1, PDO::PARAM_INT);
				$stmt->bindParam(":fecha",$valor2, PDO::PARAM_STR);
				$stmt -> execute();

				return $stmt -> fetchAll();

			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item1 = :idequipo AND $item2 = :ideasignacion ");
				$stmt->bindParam(":idequipo",$valor1, PDO::PARAM_INT);
				$stmt->bindParam(":ideasignacion",$valor2, PDO::PARAM_INT);
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

	/*===============================================
	=            CONSULTAR CHECK LIST POR ID           =
	===============================================*/
	static public function mdlConsultarCheckListID($tabla,$datos,$item){

		if (!empty($item)) {

				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");
				$stmt->bindParam(":valor",$datos, PDO::PARAM_INT);
				$stmt -> execute();

				return $stmt -> fetch();


		}else{
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}




		$stmt -> close();

		$stmt = null;
	}

	/*==================================================================
	=            CONSULTAR NOVEDADES DE CHEC LIST PARA PDF             =
	==================================================================*/
	static public function mdlConsultarObsCheckList($tabla,$datos,$item){

		if (!empty($item)) {

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :valor");
			$stmt->bindParam(":valor",$datos, PDO::PARAM_INT);
			$stmt -> execute();

			return $stmt -> fetch();

		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}




		$stmt -> close();

		$stmt = null;
	}
	/*=========================================================================
	=            CONSULTA DE CHECK LIST RESULTADO POR EQUIPO Y MES            =
	=========================================================================*/
	static public function mdlConsultarCheckResult($tabla,$datos,$item){
		if (!empty($datos["valor1"]) || !empty($datos["valor2"])) {
			/*======================================================================
			=            CONCATEMOS LA SENTENCIA PARA CONSULTA DE MYSQL            =
			======================================================================*/
			$sentencia = "SELECT ce.idchcklstq, e.codigo, CONVERT(date,ce.fecha) as fecha, ea.responsable,ce.horometro,
							CASE
							WHEN ce.motivoatraso IS NULL THEN ce.motivo_bloqueo ELSE ce.motivoatraso END AS 'justificacion',
							CASE 
							WHEN ce.estado = 1 THEN 'CUMPLIDO'
							WHEN ce.estado = 2 THEN 'ATRASO'
							WHEN ce.estado = 3 THEN 'NO CUMPLE' ELSE 'NO OPERATIVO' END AS 'estado'
							from $tabla ce 
							INNER JOIN equipomc e ON ce.idequipomc = e.idequipomc
							INNER JOIN easignacion ea ON ce.ideasignacion = ea.ideasignacion WHERE
							";

  




			$numitem = 0;
			for ($i=0; $i < 3 ; $i++) {
				if (!empty($datos["valor".$i])) {
					switch ($i) {
						case 1:
							$sentencia .= "MONTH(ce.{$item['item1']}) = :item1 ";
							$numitem += 1;
							break;
						case 2:
							if ($numitem == 0) {
								$sentencia .= " e.{$item['item2']} = :item2 ";
							}else{
								$sentencia .= " AND e.{$item['item2']} = :item2 ";	
							}
							$numitem += 1;
							break;
					}
				}
			}
			$sentencia .= "AND YEAR(ce.fecha) = YEAR(GETDATE()) AND e.idciudad = :idciudad order by ce.fecha asc";
			$stmt = Conexion::conectar()->prepare($sentencia);
			/*=============================================
			=            AÑADIMOS LOS BINPARAM            =
			=============================================*/
			for ($i=0; $i < 4 ; $i++) { 
				if (!empty($datos["valor".$i])) {
					switch ($i) {
						case 1:
							$stmt->bindParam(":item1",$datos["valor1"] , PDO::PARAM_STR);
							break;
						case 2:
							$stmt->bindParam(":item2",$datos["valor2"] , PDO::PARAM_STR);
							break;
					}
				}
			}			
			$stmt->bindParam(":idciudad",$datos["valor3"], PDO::PARAM_INT);
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
	
	
	
	
	
	
	
}