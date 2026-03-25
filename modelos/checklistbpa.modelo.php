<?php

require_once "conexion.php";

class ModeloCheckListBpa{

	/*=====================================
	=            INSERTAR NUEVO REGISTRO DE CHECKLIST BPA       =
	=====================================*/
	public static function mdlRegistroCheckListBpa($tabla,$datos){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (doc1,doc2,doc3,doc4,doc5,doc6,doc7,ol1,ol2,ol3,ol4,ol5,ol6, ol7,ol8,ol9,almprod1,almprod2,almprod3,almprod4,almprod5,almprod6,almprod7,almprod8,almprod9,observaciones,evi_foto,idcliente,idauditor,idciudad,fecha_reg,estado,idlocalizacion)VALUES(:doc1,:doc2,:doc3,:doc4,:doc5,:doc6,:doc7,:ol1,:ol2,:ol3,:ol4,:ol5,:ol6,:ol7,:ol8,:ol9,:almprod1,:almprod2,:almprod3,:almprod4,:almprod5,:almprod6,:almprod7,:almprod8,:almprod9,:observaciones,:evi_foto,:idcliente,:idauditor,:idciudad,:fecha,1,:idlocalizacion)");

		$stmt->bindParam(":doc1",$datos["doc0"], PDO::PARAM_INT);
		$stmt->bindParam(":doc2",$datos["doc1"], PDO::PARAM_INT);
		$stmt->bindParam(":doc3",$datos["doc2"], PDO::PARAM_INT);
		$stmt->bindParam(":doc4",$datos["doc3"], PDO::PARAM_INT);
		$stmt->bindParam(":doc5",$datos["doc4"], PDO::PARAM_INT);
		$stmt->bindParam(":doc6",$datos["doc5"], PDO::PARAM_INT);
		$stmt->bindParam(":doc7",$datos["doc6"], PDO::PARAM_INT);
		$stmt->bindParam(":ol1",$datos["ol0"], PDO::PARAM_INT);
		$stmt->bindParam(":ol2",$datos["ol1"], PDO::PARAM_INT);
		$stmt->bindParam(":ol3",$datos["ol2"], PDO::PARAM_INT);
		$stmt->bindParam(":ol4",$datos["ol3"], PDO::PARAM_INT);
		$stmt->bindParam(":ol5",$datos["ol4"], PDO::PARAM_INT);
		$stmt->bindParam(":ol6",$datos["ol5"], PDO::PARAM_INT);
		$stmt->bindParam(":ol7",$datos["ol6"], PDO::PARAM_INT);
		$stmt->bindParam(":ol8",$datos["ol7"], PDO::PARAM_INT);
		$stmt->bindParam(":ol9",$datos["ol8"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod1",$datos["almprod0"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod2",$datos["almprod1"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod3",$datos["almprod2"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod4",$datos["almprod3"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod5",$datos["almprod4"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod6",$datos["almprod5"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod7",$datos["almprod6"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod8",$datos["almprod7"], PDO::PARAM_INT);
		$stmt->bindParam(":almprod9",$datos["almprod8"], PDO::PARAM_INT);
		$stmt->bindParam(":observaciones",$datos["observaciones"], PDO::PARAM_STR);
		$stmt->bindParam(":evi_foto",$datos["rutaimagenes"], PDO::PARAM_STR);
		$stmt->bindParam(":idcliente",$datos["idcliente"], PDO::PARAM_INT);
		$stmt->bindParam(":idauditor",$datos["idauditor"], PDO::PARAM_INT);
		$stmt->bindParam(":idciudad",$datos["idciudad"], PDO::PARAM_INT);
		$stmt->bindParam(":idlocalizacion",$datos["idlocalizacion"], PDO::PARAM_INT);
		$stmt->bindParam(":fecha",$datos["fecha"], PDO::PARAM_STR);
		

		if($stmt->execute()){
			$stmt = Conexion::conectar()->query("SELECT MAX(idchcklstbpa) AS id FROM $tabla");
			$Id = $stmt->fetchColumn(); 
			return $Id;

		}else{

			return "error";
		
		}
	

		$stmt -> close();

		$stmt = null;


	}
	/*===============================================================
	=            REGISTRO DE OBSERVACIONES DEL CHECK BPA            =
	===============================================================*/
	public static function mdlRegistroObservacionCheckBpa($tabla,$datos,$lista,$idcheckbpa){

		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idchcklstbpa,obsdoc1,obsdoc2,obsdoc3,obsdoc4,obsdoc5,obsdoc6,obsdoc7,obsol1,obsol2,obsol3,obsol4,obsol5,obsol6,obsol7,obsol8,obsol9,obsalmprod1,obsalmprod2,obsalmprod3,obsalmprod4,obsalmprod5,obsalmprod6,obsalmprod7,obsalmprod8,obsalmprod9,fecha_ingreso)VALUES(:idchcklstbpa,:obsdoc0,:obsdoc1,:obsdoc2,:obsdoc3,:obsdoc4,:obsdoc5,:obsdoc6,:obsol0,:obsol1,:obsol2,:obsol3,:obsol4,:obsol5,:obsol6,:obsol7,:obsol8,:obsalmprod0,:obsalmprod1,:obsalmprod2,:obsalmprod3,:obsalmprod4,:obsalmprod5,:obsalmprod6,:obsalmprod7,:obsalmprod8,GETDATE())");

		$total = array();
		$keysdentro = array();

		$stmt->bindParam(":idchcklstbpa",$idcheckbpa,PDO::PARAM_STR);
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
	
	
	
	
	

	/*===============================================
	=            CONSULTAR CHECK LIST BPA            =
	===============================================*/
	static public function mdlConsultarCheckListBpa($tabla,$item,$valor){

		if (!empty($item)) {
			if($item == "idciudad"){

				$stmt = Conexion::conectar()->prepare("SELECT cb.idchcklstbpa,cb.fecha_reg,cb.idcliente,c.razonsocial,CONCAT(ur.primernombre,' ',ur.primerapellido) AS usuario, 
													cb.observaciones,
													CAST(ROUND((ROUND((((doc1+doc2+doc3+doc4+doc5+doc6+doc7)/14.0)*100),0)+
													ROUND((((ol1+ol2+ol3+ol4+ol5+ol6+ol7+ol8+ol9)/18.0)*100),0)+
													ROUND((((almprod1+almprod2+almprod3+almprod4+almprod5+almprod6+almprod7+almprod8+almprod9)/18.0)*100),0))/3,0) AS INT) AS porcentaje_global
													from chcklstbpa cb
													INNER JOIN usuariosransa ur ON cb.idauditor = ur.id
													LEFT JOIN clientes c ON cb.idcliente = c.idcliente
													WHERE cb.estado = 1 AND cb.idciudad = :idciudad
													");
				$stmt->bindParam(":idciudad",$valor, PDO::PARAM_INT);
				$stmt -> execute();

				return $stmt -> fetchAll();

			}else if($item == "anio"){
				$stmt = Conexion::conectar()->prepare("SELECT DISTINCT YEAR(cb.fecha_reg) AS anio FROM chcklstbpa cb");
				$stmt -> execute();

				return $stmt -> fetchAll();
			}else if($item == "mes"){
				$stmt = Conexion::conectar()->prepare("SET language Español SELECT DISTINCT DATENAME(MONTH,cb.fecha_reg ) AS mes, MONTH(cb.fecha_reg) as mes_num FROM chcklstbpa cb ORDER BY mes_num  asc");
				$stmt -> execute();
				return $stmt -> fetchAll();
			}else if($item == "clientes"){
				$stmt = Conexion::conectar()->prepare("SELECT DISTINCT cb.idcliente, c.razonsocial  from chcklstbpa cb
														INNER JOIN clientes c ON cb.idcliente = c.idcliente");
				$stmt -> execute();
				return $stmt -> fetchAll();
			}
			else{
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");
				$stmt->bindParam(":item",$valor, PDO::PARAM_INT);
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
	
	/*==============================================================
	=            CONSULTAR OBSERVACIONES CHECK LIST BPA            =
	==============================================================*/
	static public function mdlConsultarObsCheckListBpa($tabla,$item,$valor){

		if (!empty($item)) {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item");
			$stmt->bindParam(":item",$valor, PDO::PARAM_INT);
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
	/*================================================================================
	=            CONSULTA REALIZADA PARA DESCARGAR DATA PARA INDICADORES (EXCEL)            =
	================================================================================*/
	static public function mdlConsultDescargaDatos($tabla,$datos,$item){
		if (!empty($datos["valor1"]) || !empty($datos["valor2"]) || !empty($datos["valor3"])) {
			/*======================================================================
			=            CONCATEMOS LA SENTENCIA PARA CONSULTA DE MYSQL            =
			======================================================================*/
			$sentencia = "SELECT * FROM $tabla WHERE ";
			$numitem = 0;
			for ($i=0; $i < 4 ; $i++) { 
				if (!empty($datos["valor".$i])) {
					switch ($i) {
						case 1:
							$sentencia .= "YEAR({$item['item1']}) = :item1";
							$numitem += 1;
							break;
						case 2:
							if ($numitem == 0) {
								$sentencia .= " MONTH({$item['item2']}) = :item2";
							}else{
								$sentencia .= " AND MONTH({$item['item2']}) = :item2";	
							}
							$numitem += 1;
							break;
						case 3:
							if ($numitem == 0) {
								$sentencia .= " {$item['item3']} = :item3";
							}else{
								$sentencia .= " AND {$item['item3']} = :item3";
							}
							$numitem += 1;
							break;
					}
				}
			}			
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
						case 3:
							$stmt->bindParam(":item3",$datos["valor3"] , PDO::PARAM_STR);
							break;
					}
				}
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
	
	
	
	
	
	
	
	
}