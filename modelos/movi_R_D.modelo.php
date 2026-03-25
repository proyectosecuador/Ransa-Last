<?php
set_time_limit(300);
require_once "conexion.php";

class ModeloMovRD
{

	/*=====================================
	=            INSERTAR MOVIMIENTO DE RECEPCION O DESPACHO            =
	=====================================*/
	static public function mdlRegistrarMovRD($tabla, $datos)
	{
		/**
		
			TODO:
			- ESTADO 0 ==> INDICA QUE EL MOVIMIENTO SE ENCUENTRA SUSENDIDO O ELIMINADO
			- ESTADOS 1 ==> POR ASIGNAR CUADRILLA
			- ESTADO 2 ==> CUADRILLA ASIGNADA
			- ESTADO 3  ==> INICIA PROCESO (RECEPCION - DESPACHO - REPALETIZADO)
			- ESTADO 4 ==> CHECK LIST TRANSPORTE TERMINADO
			- ESTADO 5 ==> DATOS INGRESADOS POR EL ESTABA X CONFIRMAR EL SUPERVISOR
			- ESTADO 6 ==> DATOS CONFIRMADOS POR EL SUPERVISOR
			- ESTADO 7 ==> DATOS CONFIRMADOS POR EL SUEPERVISOR DE ESTIBAS
			- ESTADO 8 ==> MOVIMIENTOS QUE NO SOLICITARON CUADRILLA Y SOLO SE HIZO CHECK
			- ESTADO 10 ==> POR CONFIRMAR DATOS DEL VEHICULO REPORTADO POR GARITA
			- 
		 */

		if ($datos["modo"] == "garita") {
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (idcliente,estado,idciudad,idlocalizacion,idusuariogarita) VALUES (:valor2,1,:idciudad,:idlocalizacion,:idusuariogarita)");


			// $stmt->bindParam(":valor1",$datos["fecha_prog"] , PDO::PARAM_STR);
			$stmt->bindParam(":valor2", $datos["idcliente"], PDO::PARAM_INT);
			// $stmt->bindParam(":valor3",$datos["idactividad"] , PDO::PARAM_INT);
			// $stmt->bindParam(":valor4",$datos["idtipo_carga"] , PDO::PARAM_INT);
			// $stmt->bindParam(":valor5",$datos["comentarios"] , PDO::PARAM_STR);
			// $stmt->bindParam(":valor6",null , PDO::PARAM_INT);
			// $stmt->bindParam(":valor7",$datos["cuadrilla"] , PDO::PARAM_STR);
			$stmt->bindParam(":idciudad", $datos["idciudad"], PDO::PARAM_INT);
			$stmt->bindParam(":idusuariogarita", $datos["idusuariogarita"], PDO::PARAM_INT);
			$stmt->bindParam(":idlocalizacion", $datos["idlocalizacion"], PDO::PARAM_INT);
		} else {
			$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (fecha_programada,idcliente,idactividad, nguias, idtipo_carga, comentarios, estado,idusuario,cuadrilla,idciudad,idlocalizacion) VALUES (:valor1,:valor2,:valor3,:valor4,:valor5,:valor6,1,:valor7,:valor8,:idciudad,:idlocalizacion)");


			$stmt->bindParam(":valor1", $datos["fecha_prog"], PDO::PARAM_STR);
			$stmt->bindParam(":valor2", $datos["idcliente"], PDO::PARAM_INT);
			$stmt->bindParam(":valor3", $datos["idactividad"], PDO::PARAM_INT);
			$stmt->bindParam(":valor4", $datos["nguias"], PDO::PARAM_STR);
			$stmt->bindParam(":valor5", $datos["idtipo_carga"], PDO::PARAM_INT);
			$stmt->bindParam(":valor6", $datos["comentarios"], PDO::PARAM_STR);
			$stmt->bindParam(":valor7", $datos["idusuario"], PDO::PARAM_INT);
			$stmt->bindParam(":valor8", $datos["cuadrilla"], PDO::PARAM_STR);
			$stmt->bindParam(":idciudad", $datos["idciudad"], PDO::PARAM_INT);
			$stmt->bindParam(":idlocalizacion", $datos["idlocalizacion"], PDO::PARAM_INT);
		}


		if ($stmt->execute()) {
			$stmt = Conexion::conectar()->query("SELECT MAX(idmov_recep_desp) AS id FROM $tabla");
			$Id = $stmt->fetchColumn();
			return $Id;
		} else {
			return "error";
		}


		$stmt->close();

		$stmt = null;
	}
	/*=====================================
	=            INSERTAR MOVIMIENTO DE RECEPCION O DESPACHO INCLUYENDO EL ESTADO           =
	=====================================*/
	static public function mdlRegistrarMovRDConEstado($tabla, $datos)
	{
		$stmt = Conexion::conectar()->prepare("INSERT INTO $tabla (fecha_programada,idcliente,idactividad, nguias, idtipo_carga, comentarios, estado,idusuario,cuadrilla,idciudad,idlocalizacion) VALUES (:valor1,:valor2,:valor3,:valor4,:valor5,:valor6,:estado,:valor7,:valor8,:idciudad,:idlocalizacion)");

		$stmt->bindParam(":valor1", $datos["fecha_prog"], PDO::PARAM_STR);
		$stmt->bindParam(":valor2", $datos["idcliente"], PDO::PARAM_INT);
		$stmt->bindParam(":valor3", $datos["idactividad"], PDO::PARAM_INT);
		$stmt->bindParam(":valor4", $datos["nguias"], PDO::PARAM_STR);
		$stmt->bindParam(":valor5", $datos["idtipo_carga"], PDO::PARAM_INT);
		$stmt->bindParam(":valor6", $datos["comentarios"], PDO::PARAM_STR);
		$stmt->bindParam(":estado", $datos["estado"], PDO::PARAM_INT);
		$stmt->bindParam(":valor7", $datos["idusuario"], PDO::PARAM_INT);
		$stmt->bindParam(":valor8", $datos["cuadrilla"], PDO::PARAM_STR);
		$stmt->bindParam(":idciudad", $datos["idciudad"], PDO::PARAM_INT);
		$stmt->bindParam(":idlocalizacion", $datos["idlocalizacion"], PDO::PARAM_INT);

		if ($stmt->execute()) {
			$stmt = Conexion::conectar()->query("SELECT MAX(idmov_recep_desp) AS id FROM $tabla");
			$Id = $stmt->fetchColumn();
			return $Id;
		} else {
			return "error";
		}
	}



	/*===============================================
	=    CONSULTAR MOVIMIENTO DE RECEPCION O DESPACHO            =
	===============================================*/
	static public function mdlConsultarMovRD($tabla, $dato, $item)
	{

		if (!empty($item)) {
			if ($item == "idusuario" || $item == "estado" || $item == "idcliente") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item1");

				$stmt->bindParam(":item1", $dato, PDO::PARAM_INT);

				$stmt->execute();

				return $stmt->fetchAll();
			} else if ($item == "idConfSupMaq") {

				$stmt = Conexion::conectar()->prepare("SELECT m.idmov_recep_desp,m.fecha_programada,m.comentarios,m.nguias,
														CASE 
														WHEN c.razonsocial LIKE '%NEGOCIOS Y LOGISTICA NEGOLOGIC SA%' THEN CONCAT(uc.primernombre,' ',uc.primerapellido) ELSE CONCAT(ur.primernombre,' ',ur.primerapellido)END AS usuario_cliente,
														c.razonsocial,
														m.codigo_generado,ae.descripcion as actividad,pe.nombre_proveedor,
														CASE 
														WHEN m.estado = 7 THEN 'Visualizar'
														WHEN m.estado = 6 THEN 'X Confirmar Sup. Estibas'
														WHEN m.estado = 5 THEN 'X APROBAR SUP.'
														WHEN m.estado = 4 THEN 'PENDIENTE INGRESAR DATOS'
														WHEN m.estado = 3 THEN 'PROCESO INICIADO'
														WHEN m.estado = 2 THEN 'CUADRILLA ASIGNADA'
														WHEN m.estado = 1 THEN 'INGRESADA'END AS estado
														FROM mov_recep_desp m
														INNER JOIN clientes c ON m.idcliente = c.idcliente
														INNER JOIN actividad_estiba ae ON m.idactividad = ae.idactividad_estiba
														INNER JOIN usuariosransa ur ON m.idusuario = ur.id
														LEFT JOIN proveedor_estibas pe ON m.idproveedor_estiba = pe.idproveedor_estiba
														FULL OUTER JOIN usuariosclientes uc ON m.idcliente = uc.idcliente
														WHERE m.estado in (1,2,3,4,5,6,7) 
														AND (
															(m.fecha_programada >= DATEADD(MONTH, -4, GETDATE()))
															  OR
															  (m.fecha_programada >= dateadd(MONTH, 10, DATEADD(YEAR, -1, GETDATE())))
															  OR
															  (m.fecha_programada = GETDATE())
														   )
														--  AND (
                                                        --    (YEAR(m.fecha_registrado) = YEAR(GETDATE()) AND MONTH(m.fecha_registrado) >= MONTH(dateadd(MONTH,-3,GETDATE())))
                                                        --    OR
                                                        --    (YEAR(m.fecha_registrado) = YEAR(GETDATE()) - 1 AND MONTH(m.fecha_registrado) >= MONTH(dateadd(MONTH, 10, GETDATE())))
                                                        --    OR
                                                        --    (YEAR(DATEADD(DAY,1,m.fecha_programada)) = YEAR(GETDATE()) 
			                     						-- 	AND MONTH(DATEADD(DAY,1,m.fecha_programada)) = MONTH(GETDATE()) 
														-- 	AND DATEADD(DAY,1,m.fecha_programada) >= DATEADD(DAY, DATEDIFF(DAY, 0, GETDATE()), 0))
                                                        --    )
														--   AND YEAR(CONVERT(date,m.fecha_registrado))  > YEAR(dateadd(YEAR,-1,CONVERT(date,GETDATE())))
														--   AND MONTH(m.fecha_registrado) > MONTH(dateadd(MONTH,-3,GETDATE()))
														AND m.cuadrilla = 'SI'
														AND m.idciudad = :idciudad
														ORDER BY m.fecha_registrado desc");

				$stmt->bindParam(":idciudad", $dato, PDO::PARAM_INT);

				$stmt->execute();

				return $stmt->fetchAll();
			} else if (isset($item["rangofechas"])) {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE CONVERT(DATE,{$item['rangofechas']}) BETWEEN  :desde AND :hasta");

				$stmt->bindParam(":desde", $dato["desde"], PDO::PARAM_STR);
				$stmt->bindParam(":hasta", $dato["hasta"], PDO::PARAM_STR);

				$stmt->execute();

				return $stmt->fetchAll();
			} else if (isset($item["idproveedor_estiba"])) {

				$stmt = Conexion::conectar()->prepare("SELECT m.idmov_recep_desp, m.fecha_programada, c.razonsocial, ae.descripcion, m.fecha_registrado, m.codigo_generado, m.comentarios, m.nguias,
														CASE WHEN m.estado = 7 THEN 'APROBADO'
														WHEN m.estado = 6 THEN 'APROBADO'
														WHEN m.estado = 5 THEN 'PENDIENTE APROBACIÓN'
														WHEN m.estado = 4 THEN 'PENDIENTE INGRESAR DATOS'
														WHEN m.estado = 3 THEN 'ACTIVIDAD INICIADA'
														WHEN m.estado = 2 THEN 'ACTIVIDAD ASIGNADA'
														WHEN m.estado = 1 THEN 'INGRESADA'END AS estado
														FROM $tabla m 
														INNER JOIN clientes c ON m.idcliente = c.idcliente
														INNER JOIN actividad_estiba ae ON m.idactividad = ae.idactividad_estiba
														WHERE {$item['idproveedor_estiba']} = :item1 AND m.estado != 0 
														-- AND YEAR(m.fecha_programada) > YEAR(dateadd(YEAR,-1,GETDATE()))
														AND (
															(m.fecha_programada >= DATEADD(MONTH, -3, GETDATE()))
															  OR
															  (m.fecha_programada >= dateadd(MONTH, 10, DATEADD(YEAR, -1, GETDATE())))
															  OR
															  (m.fecha_programada = GETDATE())
														   )
														   ORDER BY m.idmov_recep_desp DESC");


				$stmt->bindParam(":item1", $dato, PDO::PARAM_STR);

				$stmt->execute();

				return $stmt->fetchAll();
			} else if (isset($item["cuadrilla"])) {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE {$item['cuadrilla']} = :item1 AND {$item['estado']} BETWEEN :estado1 AND :estado2");
				$stmt->bindParam(":item1", $dato["cuadrilla"], PDO::PARAM_STR);
				$stmt->bindParam(":estado1", $dato["estado1"], PDO::PARAM_INT);
				$stmt->bindParam(":estado2", $dato["estado2"], PDO::PARAM_INT);


				$stmt->execute();

				return $stmt->fetchAll();
			} else if ($item == "idciudad") {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item1 AND idlocalizacion = :item2  AND estado != 9 AND estado != 0");

				$stmt->bindParam(":item1", $dato["idciudad"], PDO::PARAM_INT);
				$stmt->bindParam(":item2", $dato["idlocalizacion"], PDO::PARAM_INT);

				$stmt->execute();

				return $stmt->fetchAll();
			} else {
				$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla WHERE $item = :item1");

				$stmt->bindParam(":item1", $dato, PDO::PARAM_INT);

				// print_r($dato);

				$stmt->execute();

				return $stmt->fetch();
			}
		} else {
			$stmt = Conexion::conectar()->prepare("SELECT * FROM $tabla");

			$stmt->execute();

			return $stmt->fetchAll();
		}



		$stmt->close();

		$stmt = null;
	}

	/*=====================================================
	=            EDITAR EL MOVIMIENTO DE RECEPCION O DESPACHO            =
	=====================================================*/
	static public function mdlEditarMovRD($tabla, $datos, $item)
	{

		if (isset($datos["asignarcuadrillaid"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET idproveedor_estiba = :valor1, estado = 2 WHERE $item = :item");



			$stmt->bindParam(":valor1", $datos["asignarcuadrillaid"], PDO::PARAM_STR);

			$stmt->bindParam(":item", $datos["idmov"], PDO::PARAM_INT);
		} else if (isset($datos["codigo_generado"])) {

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :valor1, codigo_generado = :valor2,responactividad = :valor3 WHERE $item = :item");



			$stmt->bindParam(":valor1", $datos["valor1"], PDO::PARAM_STR);
			$stmt->bindParam(":valor2", $datos["codigo_generado"], PDO::PARAM_STR);
			$stmt->bindParam(":valor3", $datos["nombrerespon"], PDO::PARAM_STR);


			$stmt->bindParam(":item", $datos["idmov"], PDO::PARAM_INT);
		} else if ($item == "fecha_llegada") {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET fecha_llegada = GETDATE() WHERE idmov_recep_desp = :item");
			$stmt->bindParam(":item", $datos, PDO::PARAM_STR);
		} else if (isset($datos["estado8"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :valor1,responactividad = :valor3 WHERE $item = :item");



			$stmt->bindParam(":valor1", $datos["estado8"], PDO::PARAM_STR);
			$stmt->bindParam(":valor3", $datos["nombrerespon"], PDO::PARAM_STR);


			$stmt->bindParam(":item", $datos["idmov"], PDO::PARAM_INT);
		} else if (isset($datos["nguias"])) {

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET nguias = :valor1 WHERE $item = :item");

			$stmt->bindParam(":valor1", $datos["nguias"], PDO::PARAM_STR);

			$stmt->bindParam(":item", $datos["idmovimiento"], PDO::PARAM_INT);
		} else {

			$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :valor1 WHERE $item = :item");

			$stmt->bindParam(":valor1", $datos["valor1"], PDO::PARAM_STR);

			$stmt->bindParam(":item", $datos["idmov"], PDO::PARAM_INT);
		}





		if ($stmt->execute()) {



			return "ok";
		} else {



			return "error";
		}



		$stmt->close();

		$stmt = null;
	}

	/*=======================================================
	=    ELIMINAR EL MOVIMIENTO DE RECEPCION O DESPACHO     =
	=======================================================*/
	static public function mdlEliminarMovRD($tabla, $datos, $item)
	{



		$stmt = Conexion::conectar()->prepare("UPDATE $tabla SET estado = :valor1 WHERE $item = :item");



		$stmt->bindParam(":valor1", $datos["estado"], PDO::PARAM_STR);

		$stmt->bindParam(":item", $datos["idproveedor_estiba"], PDO::PARAM_INT);



		if ($stmt->execute()) {



			return "ok";
		} else {



			return "error";
		}



		$stmt->close();

		$stmt = null;
	}
	/*=========================================================================
	=            EDITAR CAMPOS DEL MOVIMIENTO DE RECEPC Y DESPACHO            =
	=========================================================================*/
	static public function mdlEditarMovRDEst($tabla, $datos, $item)
	{

		if (isset($item["idmov_recep_desp"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE mov_recep_desp SET idtipo_transporte = :idtipo_transporte,ncontenedor = :ncontenedor,nguias = :nguias,h_garita = :h_garita,h_inicio = :h_inicio,h_fin = :h_fin,nombre_estibas = :nombre_estibas,cant_film = :cant_film,cant_codigo = :cant_codigo,cant_fecha = :cant_fecha,cant_pallets = :cant_pallets,cant_bultos = :cant_bultos,observaciones_estibas = :observaciones_estibas,fecha_dat_estiba = :fecha_dat_estiba, estado = 5 WHERE idmov_recep_desp = :idmov_recep_desp");
			/*============================================
			=            RECORREMOS BINDPARAM            =
			============================================*/
			$stmt->bindParam(":idtipo_transporte", $datos["idtipo_transporte"], PDO::PARAM_STR);
			$stmt->bindParam(":ncontenedor", $datos["ncontenedor"], PDO::PARAM_STR);
			$stmt->bindParam(":nguias", $datos["nguias"], PDO::PARAM_STR);
			$stmt->bindParam(":h_garita", $datos["h_garita"], PDO::PARAM_STR);
			$stmt->bindParam(":h_inicio", $datos["h_inicio"], PDO::PARAM_STR);
			$stmt->bindParam(":h_fin", $datos["h_fin"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre_estibas", $datos["nombre_estibas"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_film", $datos["cant_film"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_codigo", $datos["cant_codigo"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_fecha", $datos["cant_fecha"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_pallets", $datos["cant_pallets"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_bultos", $datos["cant_bultos"], PDO::PARAM_STR);
			$stmt->bindParam(":observaciones_estibas", $datos["observaciones_estibas"], PDO::PARAM_STR);
			$stmt->bindParam(":fecha_dat_estiba", $datos["fecha_dat_estiba"], PDO::PARAM_STR);
			$stmt->bindParam(":idmov_recep_desp", $item["idmov_recep_desp"], PDO::PARAM_INT);
		} else if (isset($item["Confiridmov_recep_desp"])) {
			/*=====================================================================================
			=            SENTENCIA PARA EL EL SUPERVISOR CONFIRME LOS DATOS A INGRESAR            =
			=====================================================================================*/
			$stmt = Conexion::conectar()->prepare("UPDATE mov_recep_desp SET idtipo_transporte = :idtipo_transporte,ncontenedor = :ncontenedor,nguias = :nguias,h_garita = :h_garita,h_inicio = :h_inicio,h_fin = :h_fin,nombre_estibas = :nombre_estibas,cant_film = :cant_film,cant_codigo = :cant_codigo,cant_fecha = :cant_fecha,cant_pallets = :cant_pallets,cant_bultos = :cant_bultos,observaciones_estibas = :observaciones_estibas,idciudad = :idciudad,origen = :origen, estado = 6,cant_personas = :cant_persona, observaciones_sup = :observaciones_sup, idusuarioaprobador = :idaprobador WHERE idmov_recep_desp = :Confiridmov_recep_desp");
			/*============================================
			=            RECORREMOS BINDPARAM            =
			============================================*/
			$stmt->bindParam(":idtipo_transporte", $datos["ttransporte"], PDO::PARAM_STR);
			$stmt->bindParam(":ncontenedor", $datos["ncontenedor"], PDO::PARAM_STR);
			$stmt->bindParam(":nguias", $datos["nguias"], PDO::PARAM_STR);
			$stmt->bindParam(":h_garita", $datos["hgarita"], PDO::PARAM_STR);
			$stmt->bindParam(":h_inicio", $datos["hinicio"], PDO::PARAM_STR);
			$stmt->bindParam(":h_fin", $datos["hfin"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre_estibas", $datos["nom_estibas"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_film", $datos["cant_film"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_codigo", $datos["cant_cod"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_fecha", $datos["cant_fecha"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_pallets", $datos["cant_pallets"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_bultos", $datos["cant_bulto"], PDO::PARAM_STR);
			$stmt->bindParam(":observaciones_estibas", $datos["observa_estibas"], PDO::PARAM_STR);
			$stmt->bindParam(":Confiridmov_recep_desp", $item["Confiridmov_recep_desp"], PDO::PARAM_INT);
			// $stmt->bindParam(":idlocalizacion",$datos["idlocalizacion"], PDO::PARAM_INT);
			$stmt->bindParam(":idciudad", $datos["idciudad"], PDO::PARAM_INT);
			$stmt->bindParam(":origen", $datos["origen"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_persona", $datos["cant_persona"], PDO::PARAM_INT);
			$stmt->bindParam(":observaciones_sup", $datos["observaciones_sup"], PDO::PARAM_STR);
			$stmt->bindParam(":idaprobador", $datos["idusuarioaprobador"], PDO::PARAM_INT);
		} else if (isset($item["ConfirmSuperEst"])) {
			/*=========================================================================================================================
			=            SENTENCIA PARA EL SUPERVISOR DE ESTIBA CONFIRME LOS DATOS APROBADOS POR EL SUPERVISOR OPERACIONES            =
			=========================================================================================================================*/
			$stmt = Conexion::conectar()->prepare("UPDATE mov_recep_desp SET idtipo_transporte = :idtipo_transporte,ncontenedor = :ncontenedor,nguias = :nguias,h_garita = :h_garita,h_inicio = :h_inicio,h_fin = :h_fin,nombre_estibas = :nombre_estibas,cant_film = :cant_film,cant_codigo = :cant_codigo,cant_fecha = :cant_fecha,cant_pallets = :cant_pallets,cant_bultos = :cant_bultos, estado = 7,cant_personas = :cant_persona, observaciones_estibas = :observaciones_estibas WHERE idmov_recep_desp = :ConfirmSuperEst");
			/*============================================
			=            RECORREMOS BINDPARAM            =
			============================================*/
			$stmt->bindParam(":idtipo_transporte", $datos["ttransporte"], PDO::PARAM_STR);
			$stmt->bindParam(":ncontenedor", $datos["ncontenedor"], PDO::PARAM_STR);
			$stmt->bindParam(":nguias", $datos["nguias"], PDO::PARAM_STR);
			$stmt->bindParam(":h_garita", $datos["hgarita"], PDO::PARAM_STR);
			$stmt->bindParam(":h_inicio", $datos["hinicio"], PDO::PARAM_STR);
			$stmt->bindParam(":h_fin", $datos["hfin"], PDO::PARAM_STR);
			$stmt->bindParam(":nombre_estibas", $datos["nom_estibas"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_film", $datos["cant_film"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_codigo", $datos["cant_cod"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_fecha", $datos["cant_fecha"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_pallets", $datos["cant_pallets"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_bultos", $datos["cant_bulto"], PDO::PARAM_STR);
			$stmt->bindParam(":observaciones_estibas", $datos["observa_estibas"], PDO::PARAM_STR);
			$stmt->bindParam(":cant_persona", $datos["cant_persona"], PDO::PARAM_INT);
			$stmt->bindParam(":ConfirmSuperEst", $item["ConfirmSuperEst"], PDO::PARAM_INT);
		} else if (isset($item["EliminaMov"])) {
			/*===============================================================================
		=            SENTENCIA PARA REGISTRAR EL MOTIVO DE PORQUE SE ELIMINA            =
		===============================================================================*/
			$stmt = Conexion::conectar()->prepare("UPDATE mov_recep_desp SET motivo_elimina = :motivo_elimina ,fecha_elimina = GETDATE(), estado = 0,iduser_elimina = :iduser_elimina  WHERE idmov_recep_desp = :EliminaMov");

			$stmt->bindParam(":motivo_elimina", $datos["motivo_elimina"], PDO::PARAM_STR);
			$stmt->bindParam(":EliminaMov", $item["EliminaMov"], PDO::PARAM_INT);
			$stmt->bindParam(":iduser_elimina", $datos["iduserElimina"], PDO::PARAM_INT);
		} else if (isset($item["EditClienteAnun"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE mov_recep_desp SET idcliente = :idcliente ,idusuariomodcliente = :idusuariomodcliente, fecha_mod_cliente = GETDATE()  WHERE idmov_recep_desp = :idmov_recep_desp");

			$stmt->bindParam(":idcliente", $datos["idcliente"], PDO::PARAM_INT);
			$stmt->bindParam(":idusuariomodcliente", $datos["idusermodCliente"], PDO::PARAM_INT);
			$stmt->bindParam(":idmov_recep_desp", $item["EditClienteAnun"], PDO::PARAM_INT);
		} else if (isset($item["editComple"])) {
			$stmt = Conexion::conectar()->prepare("UPDATE mov_recep_desp SET idactividad = :idactividad ,idtipo_carga = :idtipo_carga, comentarios = :comentarios, cuadrilla = :cuadrilla, idusuario = :idusuario WHERE idmov_recep_desp = :idmov_recep_desp");

			$stmt->bindParam(":idactividad", $datos["idactividad"], PDO::PARAM_INT);
			$stmt->bindParam(":idtipo_carga", $datos["tipo_carga"], PDO::PARAM_INT);
			$stmt->bindParam(":cuadrilla", $datos["cuadrilla"], PDO::PARAM_STR);
			$stmt->bindParam(":comentarios", $datos["comentSup"], PDO::PARAM_STR);
			$stmt->bindParam(":idmov_recep_desp", $item["editComple"], PDO::PARAM_INT);
			// $stmt->bindParam(":puerta_asignada",$datos["numPuerta"], PDO::PARAM_INT);
			$stmt->bindParam(":idusuario", $datos["idusuario"], PDO::PARAM_INT);
		}
		if ($stmt->execute()) {

			return "ok";
		} else {

			return "error";
		}


		$stmt->close();

		$stmt = null;
	}

	// static public function mdlEditarMovRDcht($tabla,$datos,$item){

	// 	if (isset($item["idmov_recep_desp"])) {

	// 		$stmt = Conexion::conectar()->prepare("UPDATE mov_recep_desp SET nguias = :nguias  WHERE idmov_recep_desp = :idmov_recep_desp");

	// 		$stmt->bindParam(":nguias", $datos["nguias"], PDO::PARAM_INT);
	// 	}
	// 	if ($stmt->execute()) {

	// 		return "ok";
	// 	} else {

	// 		return "error";
	// 	}


	// 	$stmt->close();

	// 	$stmt = null;
	// }

	/*============================================================
  =            CONSULTAR TODOS LOS MOVIMIENTOS POR ACTIVIDAD   =
  ============================================================*/

	public static function mdlConsultarTodosMovPorActividad($tabla, $actividad)
	{
		// Verificar el tipo de usuario
		if (substr_count($_SESSION["email"], 'ransa')) {
			$tablaUsuario = "usuariosransa";
			$item = "email";
			$valor = $_SESSION["email"];
		} else {
			if (isset($_SESSION["perfil"]) && $_SESSION["perfil"] == "Cliente") {
				$tablaUsuario = "usuariosclientes";
				$item = "email";
				$valor = $_SESSION["email"];
			}
		}

		// Obtener información del usuario
		$rptaUsuario = ModeloUsuarios::mdlMostrarUsuarios($tablaUsuario, $item, $valor);

		// Determinar los clientes asociados al usuario
		$clientes = [];
		if ($tablaUsuario == "usuariosransa") {
			$cuentas = json_decode($rptaUsuario["cuentas"], true); // Obtener las cuentas asociadas al usuario
			foreach ($cuentas as $cuenta) {
				$clientes[] = $cuenta["idcliente"];
			}
		} else {
			$clientes[] = $rptaUsuario["idcliente"];
		}

		// Convertir los clientes en una lista para la consulta SQL
		$clientesList = implode(",", array_map("intval", $clientes));

		// Construir la consulta SQL
		$stmt = Conexion::conectar()->prepare("
        SELECT 
            m.idmov_recep_desp, 
            m.fecha_programada, 
            m.comentarios, 
            m.nguias, 
            m.codigo_generado, 
            pe.nombre_proveedor AS cuadrilla,
            m.estado,
			 m.idproveedor_estiba,
            c.razonsocial AS cliente, 
            a.descripcion AS actividad, 
            pe.nombre_proveedor,
            CASE 
                WHEN c.razonsocial LIKE '%NEGOCIOS Y LOGISTICA NEGOLOGIC SA%' THEN CONCAT(uc.primernombre, ' ', uc.primerapellido) 
                ELSE CONCAT(ur.primernombre, ' ', ur.primerapellido) 
            END AS usuario_cliente,
            CASE 
                WHEN m.estado = 7 THEN 'Visualizar'
                WHEN m.estado = 6 THEN 'X Confirmar Sup. Estibas'
                WHEN m.estado = 5 THEN 'X APROBAR SUP.'
                WHEN m.estado = 4 THEN 'PENDIENTE INGRESAR DATOS'
                WHEN m.estado = 3 THEN 'PROCESO INICIADO'
                WHEN m.estado = 2 THEN 'CUADRILLA ASIGNADA'
                WHEN m.estado = 1 THEN 'INGRESADA'
            END AS estado_descripcion
        FROM $tabla m
        INNER JOIN clientes c ON m.idcliente = c.idcliente
        INNER JOIN actividad_estiba a ON m.idactividad = a.idactividad_estiba
        LEFT JOIN proveedor_estibas pe ON m.idproveedor_estiba = pe.idproveedor_estiba
        LEFT JOIN usuariosclientes uc ON m.idcliente = uc.idcliente
        LEFT JOIN usuariosransa ur ON m.idusuario = ur.id
		WHERE m.idactividad = :idactividad
				AND m.estado NOT IN (0,6,7,8)
				AND m.idcliente IN ($clientesList)
				AND (
						(m.fecha_programada >= DATEADD(MONTH, -4, GETDATE()))
						OR
						(m.fecha_programada >= DATEADD(MONTH, 10, DATEADD(YEAR, -1, GETDATE())))
						OR
						(m.fecha_programada = GETDATE())
				)
				ORDER BY m.fecha_programada DESC
    ");
		$stmt->bindParam(":idactividad", $actividad, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
	public static function mdlMovCuadrillaAsignadaOptimizado($idclientes, $idciudad)
	{
		$clientesList = implode(",", array_map("intval", $idclientes));
		$stmt = Conexion::conectar()->prepare("
        SELECT
            m.idmov_recep_desp,
            m.fecha_programada,
            m.comentarios,
            m.codigo_generado,
            m.estado,
            m.idactividad,
            m.idtipo_carga,
            m.idproveedor_estiba,
            m.cuadrilla,
            m.idusuario,
            m.idciudad,
            c.razonsocial,
            a.descripcion AS actividad,
            pe.nombre_proveedor AS nombre_estiba,
            ur.primernombre AS user_nombre,
            ur.primerapellido AS user_apellido
        FROM mov_recep_desp m
        INNER JOIN clientes c ON m.idcliente = c.idcliente
        LEFT JOIN actividad_estiba a ON m.idactividad = a.idactividad_estiba
        LEFT JOIN proveedor_estibas pe ON m.idproveedor_estiba = pe.idproveedor_estiba
        LEFT JOIN usuariosransa ur ON m.idusuario = ur.id
        WHERE m.estado NOT IN (0,6,7,8)
          AND m.idactividad != ''
          AND m.idcliente IN ($clientesList)
          AND m.idciudad = :idciudad
        ORDER BY m.fecha_programada DESC
    ");
		$stmt->bindParam(":idciudad", $idciudad, PDO::PARAM_INT);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}
}
