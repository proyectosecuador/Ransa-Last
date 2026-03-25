<?php
class Conexion{



	public static function conectar(){



		try {
			$cone = new PDO("sqlsrv:server=tcp:srv-ranecucoransa.database.windows.net,1433;Database=ranecuco_ransa",
			"redrovan",
			"Didacta_123");
			$cone->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			return $cone;
		} catch (PDOException $e) {
			print("Error connecting to SQL Server.");
			die(print_r($e));
		}

	}

}