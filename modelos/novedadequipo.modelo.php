<?php

require_once "conexion.php";

class ModeloNovedades{

	/*=====================================
	=            INSERTAR NUEVA Novedad            =
	=====================================*/
	public static function mdlRegistroNovedad($tabla,$datos){
		if ($datos["modo"] == "CHECKLIST") {
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idequipo,ideasignacion,descripcion_novedad,idchcklstq,paralizacion,modo,estado) VALUES (:idequipo,:ideasignacion,:descripcion_novedad,:idchcklstq,0,:modo,3)");

			$stmt->bindParam(":idequipo",$datos["idequipo"], PDO::PARAM_INT);
			$stmt->bindParam(":ideasignacion",$datos["ideasignacion"], PDO::PARAM_INT);
			$stmt->bindParam(":descripcion_novedad",$datos["descripcion"], PDO::PARAM_STR);
			$stmt->bindParam(":idchcklstq",$datos["idchcklstq"], PDO::PARAM_STR);
			$stmt->bindParam(":modo",$datos["modo"], PDO::PARAM_STR);
			
		}else{
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idequipo,ideasignacion,descripcion_novedad,imagen,ubicacion,horometro,paralizacion,fecha_iniparalizacion,modo,estado,observacionesot) VALUES (:idequipo,:ideasignacion,:descripcion_novedad,:imagen,:ubicacion,:horometro,:paralizacion,:fechainiciopara,:modo,3,:observacionesot)");
			/*===================================================
			=            ESTADOS DE LAS NOVEDADES 
			             PENDIENTE ===> 3
			             EN PROCESO ===> 2
			             CONCLUIDO ===> 1           =
			             ELIMINADO ===> 0
			====================================================*/

			$stmt->bindParam(":idequipo",$datos["idequipo"], PDO::PARAM_INT);
			$stmt->bindParam(":ideasignacion",$datos["ideasignacion"], PDO::PARAM_INT);
			$stmt->bindParam(":descripcion_novedad",$datos["descripcion"], PDO::PARAM_STR);
			$stmt->bindParam(":imagen",$datos["img"], PDO::PARAM_STR);
			$stmt->bindParam(":ubicacion",$datos["ubicacion_para"], PDO::PARAM_STR);
			$stmt->bindParam(":horometro",$datos["horometro_para"], PDO::PARAM_STR);
			$stmt->bindParam(":paralizacion",$datos["paralizacion"], PDO::PARAM_INT);
			$stmt->bindParam(":fechainiciopara",$datos["fechainicio"], PDO::PARAM_STR);
			$stmt->bindParam(":modo",$datos["modo"], PDO::PARAM_STR);
			$stmt->bindParam(":observacionesot",$datos["observacionesot"],PDO::PARAM_STR);			
						
		}


		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	

	

	/*===============================================
	=            CONSULTAR NOVEDADES           =
	===============================================*/

	static public function mdlConsultarNovedadesEquipos($tabla,$dato,$item){

		if (isset($item) && !empty($item)) {

			if ($item == "rutaot") {//para conocer el archivo que se va a visualizar
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item LIKE :idlocalizacion");

				$stmt->bindParam(":idlocalizacion",$dato, PDO::PARAM_STR);

				$stmt -> execute();
				return $stmt -> fetch();
			}else if($item == "idciudad"){
				$stmt = Conexion::conectar()->prepare("SELECT ne.idnovequipos,e.idequipomc ,e.codigo, ea.responsable,CONCAT('TURNO ',ea.turno) AS turno, ne.modo, ne.descripcion_novedad,
														CASE WHEN ne.paralizacion = 1 THEN 'SI APLICA' ELSE 'NO APLICA' END AS paralizacion,ne.fecha,
														CASE WHEN ne.estado = 3 THEN 'PENDIENTE' 
															WHEN ne.estado = 2 THEN 'EN PROCESO'
															WHEN ne.estado = 1 THEN 'CONCLUIDO'END AS estado,
														CASE WHEN ne.fecha_propuesta IS NULL THEN 'POR ASIGNAR' ELSE CONVERT(nvarchar,ne.fecha_propuesta) END AS fecha_propuesta,
														ne.fecha_concluida,ne.fecha_iniparalizacion,ne.imagen
														FROM $tabla ne
														INNER JOIN equipomc e ON ne.idequipo = e.idequipomc
														INNER JOIN easignacion ea ON ne.ideasignacion = ea.ideasignacion
														WHERE ne.estado != 0 AND e.$item = :idciudad AND YEAR(ne.fecha) > YEAR(dateadd(YEAR,-1,GETDATE())) order by ne.idnovequipos desc");
				
				$stmt->bindParam(":idciudad",$dato, PDO::PARAM_INT);
				$stmt -> execute();	
				return $stmt -> fetchAll();

			}else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :idlocalizacion");

				$stmt->bindParam(":idlocalizacion",$dato, PDO::PARAM_STR);

				$stmt -> execute();				
				return $stmt -> fetch();
			}


				
			
		}else{

			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla ORDER BY fecha DESC");

			$stmt -> execute();

			return $stmt -> fetchAll();

		}

		$stmt -> close();

		$stmt = null;
	}
	/*=================================================================
	=            REGISTRO DE FECHA PROPUESTA PARA SOLUCIÓN            =
	=================================================================*/
	public function mdlRegistroFechaPropuesta($tabla,$datos,$items){
		/*========================================================================
		=            ACTUALIZAR LA FECHA DONDE SE CONCLUYE EL TRABAJO            =
		========================================================================*/
		if (isset($items["fecha_concluida"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET {$items["fecha_concluida"]} = :fecha_concluida, {$items["otnum"]} = :otnum, {$items["observacionesot"]}= :observacionesot,{$items["estado"]} = :estado, {$items["rutaot"]} = :rutaot  WHERE {$items["idnovequipos"]} = :idnovequipos");
			$stmt -> bindParam(":fecha_concluida", $datos["fecha_concluida"], PDO::PARAM_STR);
			$stmt -> bindParam(":otnum", $datos["otnum"], PDO::PARAM_INT);
			$stmt -> bindParam(":observacionesot", $datos["observacionesot"], PDO::PARAM_STR);			
			$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
			$stmt -> bindParam(":idnovequipos", $datos["idnovequipos"], PDO::PARAM_INT);
			$stmt -> bindParam(":rutaot", $datos["rutaot"], PDO::PARAM_STR);
			/*===================================================================
			=            ACTUALIZAR LA FECHA PROPUESTA DE REPARACIÓN            =
			===================================================================*/
		}else if (isset($items["fecha_propuesta"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET {$items["fecha_propuesta"]} = :fecha_propuesta,{$items["estado"]} = :estado WHERE {$items["idnovequipos"]} = :idnovequipos");
			$stmt -> bindParam(":fecha_propuesta", $datos["fecha_propuesta"], PDO::PARAM_STR);
			$stmt -> bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
			$stmt -> bindParam(":idnovequipos", $datos["idnovequipos"], PDO::PARAM_INT);			
		}


		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;

	}
	public function mdlEliminarNovedad($tabla,$dato1,$dato2,$item1,$item2){

		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET $item1 = :$item1 WHERE $item2 = :$item2");

		$stmt -> bindParam(":".$item1, $dato1, PDO::PARAM_STR);
		$stmt -> bindParam(":".$item2, $dato2, PDO::PARAM_INT);

		if($stmt -> execute()){

			return "ok";
		
		}else{

			return "error";	

		}

		$stmt -> close();

		$stmt = null;		

	}
	/*=============================================================
	=            REGISTRO DE NOVEDADES PARA CADA ITEMS            =
	=============================================================*/
	public static function mdlRegistroItemsNovedades($tabla,$datos,$lista,$idcheckbpa){
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idchcklstq,obseqp1,obseqp2,obseqp3,obseqp4,obseqp5,obseqp6,obseqp7,obsbtr1,obsbtr2,obscbtr1,obscbtr2,obscrgd1,obscrgd2,obscrgd3,obsoprc1,obsoprc2,obsoprc3,obsoprc4,obsoprc5,obsoprc6,obsoprc7,obsoprc8,obsoprc9,fecha_registro) VALUES (:idchcklstq,:obseqp1,:obseqp2,:obseqp3,:obseqp4,:obseqp5,:obseqp6,:obseqp7,:obsbtr1,:obsbtr2,:obscbtr1,:obscbtr2,:obscrgd1,:obscrgd2,:obscrgd3,:obsoprc1,:obsoprc2,:obsoprc3,:obsoprc4,:obsoprc5,:obsoprc6,:obsoprc7,:obsoprc8,:obsoprc9,GETDATE())");

		$total = array();
		$keysdentro = array();

		$stmt->bindParam(":idchcklstq",$idcheckbpa,PDO::PARAM_INT);

		/*===============================================================
		=            RECORREMOS LA CANTIDAD DE ITEMS TOTALES            =
		===============================================================*/
		foreach ($lista as $keylista => $valuelista) {			
			if (!isset($total[$keylista])) {
				$total[$keylista] = 1;
				/*========================================================================
				=            RECORREMOS LA CANTIDAD DE NOVEDADES QUE TENEMOS             =
				========================================================================*/
				if (array_key_exists("obs".$keylista, $datos) ) {
					// echo $keylista;
					$stmt->bindParam(":obs".$keylista,$datos["obs".$keylista],PDO::PARAM_STR);
					$keysdentro["obs".$keylista] = 1;
				}
				/*======================================================================
				=            ASIGNAMOS EL VALOR A LOS ITEMS QUE TIENEN NULO            =
				======================================================================*/
				if (!array_key_exists("obs".$keylista, $keysdentro)) {
					$valor = null;
					 // echo "----".$keylista."nulo";
					$stmt->bindParam(":obs".$keylista,$valor,PDO::PARAM_STR);
				}
			}
		}


		if($stmt->execute()){

			return "ok";

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;			

	}
	
	
	
}