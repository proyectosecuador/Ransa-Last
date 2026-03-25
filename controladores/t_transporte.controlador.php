<?php
class ControladorTTransporte{
/*===========================================
=            INSERTAR AREA NUEVA            =
===========================================*/
// public function ctrInsertarArea($datos){
// 	$tabla = "areas";

// 	$rpta = ModeloAreas::mdlInsertarArea($tabla,$datos);

// 	return $rpta;
// }



/*=======================================
=            CONSULTAR AREAS            =
=======================================*/

	static public function ctrConsultarTTransporte($item,$datos){
		$tabla = "tipo_transporte";

		$rpta = ModeloTTransporte::mdlConsultarTTransporte($tabla,$item,$datos);

		return $rpta;
	}
	 /*===============================================
    =            OBTENER OPCIONES FILTRADAS         =
    ===============================================*/
    static public function ctrObtenerOpcionesTransporte($idCliente) {
        // Consulta los tipos de transporte
        $rptaTTransporte = self::ctrConsultarTTransporte("", "");

        // Definir las opciones permitidas por cliente
        $opcionesPermitidas = [
            14 => [42,43, 45, 47, 49, 51, 53, 60, 61, 83, 93, 94, 44, 46, 48, 50, 52, 54, 56, 95],
            88 => [71, 73, 74,61, 67, 68, 93],
            70 => [71, 73, 74,61, 67, 68, 93],
            65 => [71, 73, 74,61, 67, 68, 93],
            74 => [71, 73, 74,61, 67, 68, 93],
            89 => [61,93],
            58 => [71, 73, 74,61, 67, 68, 93],
            86 => [71, 73, 74,61, 67, 68, 93],
            50 => [71, 73, 74,61, 67, 68, 93],
            43 => [71, 73, 74,61, 67, 68, 93],
            2  => [43,44, 58,61, 69, 93],
            3  => [73, 74,61, 67, 68, 93, 110],
            93 => [61,93],
            94 => [61,71, 73, 74, 67, 68, 93],
            27 => [61,71, 73, 74, 67, 68],
            64 => [61,71, 73, 74, 67, 68, 93],
            38 => [61,91, 90, 66, 63, 64, 65, 83, 93],
            25 => [61,73, 74, 67, 68, 93],
            44 => [71, 73, 74,61, 67, 68, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 93],
            73 => [61,106, 73, 107, 67, 68, 93],
            22 => [61,71, 73, 74, 67, 68, 93],
            78 => [61,71, 73, 74, 67, 68, 83, 93],
            8  => [61,69, 70, 83, 93],
            11 => [91, 90,61,  66, 63, 64, 65, 83],
            53 => [61,71, 73, 74, 67, 68],
            6  => [61,69, 70, 83, 93],
            20 => [61,93, 108, 109],
            13 => [61,83, 88],
            31 => [61,71, 72, 73, 74, 67, 68, 94],
            10 => [61,69, 70],
            9  => [61,71, 73, 74, 67, 68, 93],
            67 => [61,71, 73, 74, 67, 68, 93],
        ];

        // Verificar si el cliente tiene opciones permitidas
        $permitidos = $opcionesPermitidas[$idCliente] ?? null;

        // Filtrar las opciones de transporte
        $opcionesFiltradas = [];
        foreach ($rptaTTransporte as $transporte) {
            if ($transporte["estado"] == 1 && ($permitidos === null || in_array($transporte["idtipo_transporte"], $permitidos))) {
                $opcionesFiltradas[] = $transporte;
            }
        }

        return $opcionesFiltradas;
    }
}