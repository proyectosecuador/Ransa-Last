<?php
require_once "../controladores/archivos.controlador.php";
require_once "../modelos/archivos.modelo.php";
require_once "../extensiones/PHPExcel/Classes/PHPExcel.php";
date_default_timezone_set('America/Bogota');//ubicacion de Zona Horaria
$nombre = $_POST['nombre_archi'];
$codigo = $_POST['codigoarch'];
$fecha = date('Y/m/d');
$valor = array("nombre" => $nombre,
			   "fecha" => $fecha);
$item = array("nombre"=>"nomarchivo",
			  "fecha"=> "fechainvent");
$rpta = ControladorArchivos::ctrMostrarInventExcel($valor,$item);
$rutaarchi = $rpta['ruta'].$rpta['nomarchivo'];
$rows = file($rutaarchi);

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Douglas Borbor");
$objPHPExcel->getProperties()->setLastModifiedBy("Douglas Borbor");
$objPHPExcel->getProperties()->setTitle("Inventario");
$objPHPExcel->getProperties()->setSubject("Office 2007 XLSX Test Document");
$objPHPExcel->getProperties()->setDescription("Test document for Office 2007 XLSX,generated using PHP classes.");
$objPHPExcel->getProperties()->setKeywords("office 2007 openxml php");
$objPHPExcel->getProperties()->setCategory("Inventario");

$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('prueba');
$objPHPExcel->getDefaultStyle()->getFont()->setSize(8); 

/*=====  COLOCAR LA IMAGEN  ======*/
$objDrawing = new PHPExcel_Worksheet_Drawing();
$objDrawing->setName('Logo');
$objDrawing->setDescription('Logo');
$objDrawing->setPath('../vistas/img/plantilla/logotipo.png');
$objDrawing->setHeight(35);
$objDrawing->setCoordinates('B4');
$objDrawing->setWorksheet($objPHPExcel->getActiveSheet());
/*=====  SIRVE PARA VISUALIZAR LAS LINEAS DE LAS CELDAS   ======*/
$objPHPExcel->getActiveSheet()->setShowGridlines(false);
/*=====  SE DETALLA EL ENCABEZADO DE LA TABLA   ======*/
$objPHPExcel->getActiveSheet()->setCellValue('B6', 'Ubicación');
$objPHPExcel->getActiveSheet()->setCellValue('C6', 'Subnivel');
$objPHPExcel->getActiveSheet()->setCellValue('D6', 'Tipo.Ubicacion');
$objPHPExcel->getActiveSheet()->setCellValue('E6', 'Familia');
$objPHPExcel->getActiveSheet()->setCellValue('F6', 'Grupo');
$objPHPExcel->getActiveSheet()->setCellValue('G6', 'Tp');
$objPHPExcel->getActiveSheet()->setCellValue('H6', 'Al');
$objPHPExcel->getActiveSheet()->setCellValue('I6', 'Codigo');
$objPHPExcel->getActiveSheet()->setCellValue('J6', 'Descripcion');
$objPHPExcel->getActiveSheet()->setCellValue('K6', 'Fac.con');
$objPHPExcel->getActiveSheet()->setCellValue('L6', 'Saldo');
$objPHPExcel->getActiveSheet()->setCellValue('M6', 'Uni');
$objPHPExcel->getActiveSheet()->setCellValue('N6', 'Fech.ingr');
$objPHPExcel->getActiveSheet()->setCellValue('O6', 'Fech.venci');
$objPHPExcel->getActiveSheet()->setCellValue('P6', 'lote');
$objPHPExcel->getActiveSheet()->setCellValue('Q6', 'cajas');
$objPHPExcel->getActiveSheet()->setCellValue('R6', 'unid');
$objPHPExcel->getActiveSheet()->setCellValue('S6', 'Id');
$objPHPExcel->getActiveSheet()->setCellValue('T6', 'Paleta');
/*=====  PARA QUE LAS CELDAS SE AJUSTAN AL TAMAÑO DE LETRAS   ======*/
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(2);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
/*=====  BORDE PARA TOP DEL ENCABEZADO   ======*/
$estilo = array( 
  'borders' => array(
    'top' => array(
      'style' => PHPExcel_Style_Border::BORDER_DOUBLE
    )
  )
);
 $objPHPExcel->getActiveSheet()->getStyle('B6:T6')->applyFromArray($estilo);
/*=====  BORDE PARA BOTTOM DEL ENCABEZADO   ======*/
$estilo1 = array( 
  'borders' => array(
    'bottom' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
 $objPHPExcel->getActiveSheet()->getStyle('B6:T6')->applyFromArray($estilo1);
/*=====  CENTRAR EL ENCABEZADO   ======*/
 $objPHPExcel->getActiveSheet()->getStyle("B6:T6")->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER);
 $objPHPExcel->getActiveSheet()->getStyle("B6:T6")->getAlignment()->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
/*=====  SE COLOCA EL TEXTO EN NEGRITAS ENCABEZADO   ======*/
 $objPHPExcel->getActiveSheet()->getStyle("B6:T6")->getFont()->setBold(true);//negritas

$celda = 6;
switch ($codigo) {
	case 1588:

			for ($i=0; $i < count($rows) ; $i++) { 
				$cadena1 = trim(substr($rows[$i], 0,15));//ubicacion
				$cadena19 = trim(substr($rows[$i], 15,4));//subnivel
				$cadena2 = trim(substr($rows[$i], 19,16));//tipo ubicacion
				$cadena3 = trim(substr($rows[$i], 35,21));//familia
				$cadena4 = trim(substr($rows[$i], 56,21));//grupo
				$cadena5 = trim(substr($rows[$i], 77,3));//tp
				$cadena6 = trim(substr($rows[$i], 80,3));//al
				$cadena7 = trim(substr($rows[$i], 83,26));//codigo
				$cadena8 = trim(substr($rows[$i], 109,51));//descripcion
				$cadena9 = trim(substr($rows[$i], 160,10));//fact.conv
				$cadena10 = trim(substr($rows[$i], 170,12));//saldo
				$cadena11 = trim(substr($rows[$i], 182,4));//uni
				$cadena12 = trim(substr($rows[$i], 186,11));//fech.ingr
				$cadena13 = trim(substr($rows[$i], 197,11));//fech.venci
				$cadena14 = trim(substr($rows[$i], 208,11));//lote
				$cadena15 = trim(substr($rows[$i], 219,15));//cajas
				$cadcaj = explode(" ", trim($cadena15));
				$cadena16 =trim(substr($rows[$i], 234,12));//unid
				$caduni = explode(" ", trim($cadena16));
				$cadena17 = trim(substr($rows[$i], 246,3));//id
				$cadena18 = trim(substr($rows[$i], 249,6));//paleta
				if (trim($cadena5) != "" && trim($cadena5) == "AT") {
					$celda += 1;
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$celda, $cadena1);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$celda, $cadena19);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$celda, utf8_encode($cadena2));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$celda, utf8_encode($cadena3));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$celda, utf8_encode($cadena4));
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$celda, $cadena5);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$celda, $cadena6);
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$celda, utf8_encode($cadena7));
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$celda, utf8_encode($cadena8));
					$objPHPExcel->getActiveSheet()->setCellValue('K'.$celda, $cadena9);
					$objPHPExcel->getActiveSheet()->setCellValue('L'.$celda, $cadena10);
					$objPHPExcel->getActiveSheet()->setCellValue('M'.$celda, $cadena11);
					$objPHPExcel->getActiveSheet()->setCellValue('N'.$celda, $cadena12);
					$objPHPExcel->getActiveSheet()->setCellValue('O'.$celda, $cadena13);
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$celda, $cadena14);

					if ($cadcaj[0] != "CAJ" && $cadcaj[0] != "CJA") {
						$objPHPExcel->getActiveSheet()->setCellValue('Q'.$celda, $cadcaj[0]);
					}else{
						$objPHPExcel->getActiveSheet()->setCellValue('Q'.$celda, "");
					}
					if ($caduni[0] != "BOT" && $caduni[0] != "PZS" && $caduni[0] != "PAC" && $caduni[0] != "UNI" && $caduni[0] != "CAJ") {
						$objPHPExcel->getActiveSheet()->setCellValue('R'.$celda, $caduni[0]);
					}else{
						$objPHPExcel->getActiveSheet()->setCellValue('R'.$celda, "");
					}
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$celda, $cadena17);
					$objPHPExcel->getActiveSheet()->setCellValue('T'.$celda, $cadena18);

				}
			}
			
		break;
	case 740:

			for ($i=0; $i < count($rows) ; $i++) { 
				$cadena1 = trim(substr($rows[$i], 0,15));//ubicacion
				$cadena19 = trim(substr($rows[$i], 15,4));//subnivel
				$cadena2 = trim(substr($rows[$i], 9,16));//tipo ubicacion
				$cadena3 = trim(substr($rows[$i], 35,21));//familia
				$cadena4 = trim(substr($rows[$i], 56,21));//grupo
				$cadena5 = trim(substr($rows[$i], 77,3));//tp
				$cadena6 = trim(substr($rows[$i], 80,3));//al
				$cadena7 = trim(substr($rows[$i], 83,26));//codigo
				$cadena8 = trim(substr($rows[$i], 109,51));//descripcion
				$cadena9 = trim(substr($rows[$i], 160,10));//fact.conv
				$cadena10 = trim(substr($rows[$i], 170,12));//saldo
				$cadena11 = trim(substr($rows[$i], 182,4));//uni
				$cadena12 = trim(substr($rows[$i], 186,11));//fech.ingr
				$cadena13 = trim(substr($rows[$i], 197,11));//fech.venci
				$cadena14 = trim(substr($rows[$i], 208,17));//lote
				$cadena15 = trim(substr($rows[$i], 225,15));//cajas
				$cadcaj = explode(" ", trim($cadena15));
				$cadena16 =trim(substr($rows[$i], 240,12));//unid
				$caduni = explode(" ", trim($cadena16));
				$cadena17 = trim(substr($rows[$i], 252,9));//id
				$cadena18 = trim(substr($rows[$i], 261,3));//paleta
				if (trim($cadena5) != "" && trim($cadena5) == "AT") {
					$celda += 1;
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$celda, $cadena1);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$celda, $cadena19);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$celda, utf8_encode($cadena2));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$celda, utf8_encode($cadena3));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$celda, utf8_encode($cadena4));
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$celda, $cadena5);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$celda, $cadena6);
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$celda, utf8_encode($cadena7));
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$celda, utf8_encode($cadena8));
					$objPHPExcel->getActiveSheet()->setCellValue('K'.$celda, $cadena9);
					$objPHPExcel->getActiveSheet()->setCellValue('L'.$celda, $cadena10);
					$objPHPExcel->getActiveSheet()->setCellValue('M'.$celda, $cadena11);
					$objPHPExcel->getActiveSheet()->setCellValue('N'.$celda, $cadena12);
					$objPHPExcel->getActiveSheet()->setCellValue('O'.$celda, $cadena13);
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$celda, $cadena14);

					if ($cadcaj[0] != "CAJ" && $cadcaj[0] != "CJA") {
						$objPHPExcel->getActiveSheet()->setCellValue('Q'.$celda, $cadcaj[0]);
					}else{
						$objPHPExcel->getActiveSheet()->setCellValue('Q'.$celda, "");
					}
					if ($caduni[0] != "BOT" && $caduni[0] != "PZS" && $caduni[0] != "PAC" && $caduni[0] != "UNI" && $caduni[0] != "CAJ") {
						$objPHPExcel->getActiveSheet()->setCellValue('R'.$celda, $caduni[0]);
					}else{
						$objPHPExcel->getActiveSheet()->setCellValue('R'.$celda, "");
					}
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$celda, $cadena17);
					$objPHPExcel->getActiveSheet()->setCellValue('T'.$celda, $cadena18);

				}
			}
			
		break;		
	
	default:
			
			for ($i=0; $i < count($rows) ; $i++) { 
				$cadena1 = trim(substr($rows[$i], 0,15));//ubicacion
				$cadena19 = trim(substr($rows[$i], 15,4));//subnivel
				$cadena2 = trim(substr($rows[$i], 19,16));//tipo ubicacion
				$cadena3 = trim(substr($rows[$i], 35,21));//familia
				$cadena4 = trim(substr($rows[$i], 56,21));//grupo
				$cadena5 = trim(substr($rows[$i], 77,3));//tp
				$cadena6 = trim(substr($rows[$i], 80,3));//al
				$cadena7 = trim(substr($rows[$i], 83,26));//codigo
				$cadena8 = trim(substr($rows[$i], 109,31));//descripcion
				$cadena9 = trim(substr($rows[$i], 140,10));//fact.conv
				$cadena10 = trim(substr($rows[$i], 150,12));//saldo
				$cadena11 = trim(substr($rows[$i], 162,4));//uni
				$cadena12 = trim(substr($rows[$i], 166,11));//fech.ingr
				$cadena13 = trim(substr($rows[$i], 177,11));//fech.venci
				$cadena14 = trim(substr($rows[$i], 188,11));//lote
				$cadena15 = trim(substr($rows[$i], 199,15));//cajas
				$cadcaj = explode(" ", trim($cadena15));
				$cadena16 = trim(substr($rows[$i], 214,12));//unid
				$caduni = explode(" ", trim($cadena16));
				$cadena17 = trim(substr($rows[$i], 225,3));//id
				$cadena18 = trim(substr($rows[$i], 228,6));//paleta
				if (trim($cadena5) != "" && trim($cadena5) == "AT") {
					$celda += 1;
					$objPHPExcel->getActiveSheet()->setCellValue('B'.$celda, $cadena1);
					$objPHPExcel->getActiveSheet()->setCellValue('C'.$celda, $cadena19);
					$objPHPExcel->getActiveSheet()->setCellValue('D'.$celda, utf8_encode($cadena2));
					$objPHPExcel->getActiveSheet()->setCellValue('E'.$celda, utf8_encode($cadena3));
					$objPHPExcel->getActiveSheet()->setCellValue('F'.$celda, utf8_encode($cadena4));
					$objPHPExcel->getActiveSheet()->setCellValue('G'.$celda, $cadena5);
					$objPHPExcel->getActiveSheet()->setCellValue('H'.$celda, $cadena6);
					$objPHPExcel->getActiveSheet()->setCellValue('I'.$celda, utf8_encode($cadena7));
					$objPHPExcel->getActiveSheet()->setCellValue('J'.$celda, utf8_encode($cadena8));
					$objPHPExcel->getActiveSheet()->setCellValue('K'.$celda, $cadena9);
					$objPHPExcel->getActiveSheet()->setCellValue('L'.$celda, $cadena10);
					$objPHPExcel->getActiveSheet()->setCellValue('M'.$celda, $cadena11);
					$objPHPExcel->getActiveSheet()->setCellValue('N'.$celda, $cadena12);
					$objPHPExcel->getActiveSheet()->setCellValue('O'.$celda, $cadena13);
					$objPHPExcel->getActiveSheet()->setCellValue('P'.$celda, $cadena14);

					if ($cadcaj[0] != "CAJ" && $cadcaj[0] != "CJA" && $cadcaj[0] != "BOT" && $cadcaj[0] != "PAC" && $cadcaj[0] != "PAQ") {
						$objPHPExcel->getActiveSheet()->setCellValue('Q'.$celda, $cadcaj[0]);
					}else{
						$objPHPExcel->getActiveSheet()->setCellValue('Q'.$celda, "");
					}
					if ($caduni[0] != "UNI" && $caduni[0] != "PAQ" && $caduni[0] != "BOT" && $caduni[0] != "DIS" && $caduni[0] != "CAJ" && $caduni[0] != "TIR" && $caduni[0] != "PZS" && $caduni[0] != "PAC" && $caduni[0] != "ATD" && $caduni[0] != "BOL" && $caduni[0] != "BTO" && $caduni[0] != "EXH" && $caduni[0] != "PAK" && $caduni[0] != "SAC") {
						$objPHPExcel->getActiveSheet()->setCellValue('R'.$celda, $caduni[0]);
					}else{
						$objPHPExcel->getActiveSheet()->setCellValue('R'.$celda, "");
					}
					
					$objPHPExcel->getActiveSheet()->setCellValue('S'.$celda, $cadena17);
					$objPHPExcel->getActiveSheet()->setCellValue('T'.$celda, $cadena18);

				}
			}
		break;
}

							//Redirigir la salida al navegador del cliente
			header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
			header('Content-Disposition: attachment;filename="prueba.xlsx"');
			header('Cache-Control: max-age=0');
			$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
			$objWriter->save('php://output');