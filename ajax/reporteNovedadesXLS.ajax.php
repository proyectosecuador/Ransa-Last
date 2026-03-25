<?php
/*===================================================
=            RUTA PARA LIBERRIA DE EXCEL            =
===================================================*/
require_once "../extensiones/PHPspreadsheet/vendor/autoload.php";
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
/*=============================================================
=            DATOS OBTENDIOS DE LA TABLA DATATABLE            =
=============================================================*/
$dato = "";
if (isset($_GET["datosTabla"])) {
	$valor= "bien";
	$dato = json_encode($_GET["datosTabla"]); //Se convierte a ARRAY	
}else{
	$valor="mal";
}
$spreadsheet = new Spreadsheet();
$sheet = $spreadsheet->getActiveSheet();
$sheet->setCellValue('A3', '#');
$sheet->setCellValue('B3', 'Equipo');
$sheet->setCellValue('C3', 'Turno');
$sheet->setCellValue('D3', 'Responsable');
$sheet->setCellValue('E3', 'Modo');
$sheet->setCellValue('F3', 'Descripci贸n');
$sheet->setCellValue('G3', 'Paralizaci贸n');
$sheet->setCellValue('H3', 'Fecha');
$sheet->setCellValue('A4',$_GET["datosTabla"]);
$celdaInicial=3;
/*for ($i=0; $i <count($dato) ; $i++) { 
	$celdaInicial += 1;
	$spreadsheet->getActiveSheet()->setCellValue('A1', 'PhpSpreadsheet');
	/*$sheet->setCellValue('A'.$celdaInicial,'DSFDSF');
	$sheet->setCellValue('A'.$celdaInicial,'DSFDSF');
	$sheet->setCellValue('A'.$celdaInicial,'DSFDSF');
	$sheet->setCellValue('A'.$celdaInicial,'DSFDSF');
	$sheet->setCellValue('A'.$celdaInicial,'DSFDSF');
	$sheet->setCellValue('A'.$celdaInicial,'DSFDSF');
	$sheet->setCellValue('A'.$celdaInicial,'DSFDSF');
	$sheet->setCellValue('A'.$celdaInicial,'DSFDSF');*/
	
//}*/
//echo $valor;
//var_dump($dato);
$filename = 'sample-'.time().'.xlsx';
// Redirect output to a client's web browser (Xlsx)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$filename.'"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');
 
// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.

$writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
$writer->save('php://output');
