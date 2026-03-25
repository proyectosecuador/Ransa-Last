<?php
require_once '../extensiones/PhpSpreadSheet/autoload.php';
require_once '../controladores/checklistbpa.controlador.php';
require_once '../modelos/checklistbpa.modelo.php';

require_once '../controladores/localizacion.controlador.php';
require_once '../modelos/localizacion.modelo.php';

require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class DescargaData{
	public $_anio;
	public $_mes;
	public $_cliente;
	public function DescargarDatos(){
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$datos =array("valor1" => $this->_anio,
					  "valor2" =>$this->_mes,
					  "valor3" =>$this->_cliente);
		$items = array("item1" => "fecha_reg",
					   "item2" => "fecha_reg",
					   "item3" => "idcliente");

		$rpta = ControladorCheckListBpa::ctrConsultDescargaDatos($datos,$items);
		if (!empty($rpta)) {
			/*===============================================
			=            ENVABEZADO DE LOS DATOS            =
			===============================================*/
			$spreadsheet->getActiveSheet()->setCellValue('A5', 'AÑO');
			$spreadsheet->getActiveSheet()->setCellValue('B5', 'MES');
			$spreadsheet->getActiveSheet()->setCellValue('C5', 'ALMACÉN');
			$spreadsheet->getActiveSheet()->setCellValue('D5', 'CLIENTES');
			$spreadsheet->getActiveSheet()->setCellValue('E5', 'PUNTAJE');

			/*=======================================================================
			=            ESTABLECIENDO EL ANCHO AUTOMATICO DE LA COLUMNA            =
			=======================================================================*/
			$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			
			
			

			// $docpuntobtenido = 0; //variable para sumar
		 //    $olpuntobtenido = 0;//variable para sumar
		 //    $almprodpuntobtenido = 0;//variable para sumar
			/*****ubicacion de Zona Horaria*****/
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");

		    $datos = array();

		    for ($i=0; $i < count($rpta) ; $i++) {
		    	/*======================================================
		    	=            OBTENEMOS EL AÑO DEL CHECK BPA            =
		    	======================================================*/
		    	$anio = date('Y', strtotime($rpta[$i]["fecha_reg"]));
		    	/*========================================
		    	=            MES DE CHECK BPA            =
		    	========================================*/
		    	$mesletra = strtoupper(strftime("%B",strtotime($rpta[$i]["fecha_reg"])));
		    	/*=======================================================
		    	=            ALMACÉN DONDE SE REALIZO CHECK             =
		    	=======================================================*/
		    	$rptalocalizacion = ControladorLocalizacion::ctrConsultarLocalizacion($rpta[$i]["idlocalizacion"],"idlocalizacion");
		    	/*=====================================================================
		    	=            CONSULTAR EL CLIENTE QUE SE REALIZO CHECK BPA            =
		    	=====================================================================*/
		    	if (!is_null($rpta[$i]["idcliente"]) || !empty($rpta[$i]["idcliente"])) {
		    		$rptaCliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta[$i]["idcliente"]);
		    		$rptaCliente = $rptaCliente["razonsocial"];
		    	}else{
		    		$rptaCliente = "GENERAL";
		    	}
		    	
		    	/*=======================================================
		    	=            PUNTAJE OBTENIDO DEL CHECK LIST            =
		    	=======================================================*/
			    $docpuntobtenido = 0;
			    $olpuntobtenido = 0;
			    $almprodpuntobtenido = 0;

			    for ($j=0; $j < 7 ; $j++) {
			        $item = $j+1;
			        $docpuntobtenido += $rpta[$i]["doc".$item];
			    }
			    for ($j=0; $j < 12 ; $j++) { 
			        $item = $j+1;
			        $olpuntobtenido += $rpta[$i]["ol".$item];
			    }
			    for ($j=0; $j < 13 ; $j++) { 
			        $item = $j+1;
			        $almprodpuntobtenido += $rpta[$i]["almprod".$item];
			    }
			    /* PORCENTAJES OBTENIDOS */
			    $pordoc = ($docpuntobtenido / 14)*100;
			    $porol = ($olpuntobtenido / 24)*100;
			    $poralmprod = ($almprodpuntobtenido / 26)*100;

			    $promedio = ($pordoc+$porol+$poralmprod)/3;
		    	
		    	
		    	
		    	

		    	

		    	
		    	array_push($datos, array($anio,$mesletra,$rptalocalizacion["nom_localizacion"],$rptaCliente,number_format($promedio,0,",","."))
		    						);
		    }
			$spreadsheet->getActiveSheet()
			    ->fromArray(
			        $datos,  // The data to set
			        NULL,        // Array values with this value will not be set
			        'A6'         // Top left coordinate of the worksheet range where
			                     //    we want to set these values (default is A1)
			    );

		}


		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="file.xlsx"');
		$writer->save("php://output");		

	}


}

if (isset($_POST["anioDesc"])) {
	$desc_data = new DescargaData();
	$desc_data -> _anio = $_POST["anioDesc"];
	$desc_data -> _mes = $_POST["mesesIng"];
	$desc_data -> _cliente = $_POST["clientesIng"];
	$desc_data -> DescargarDatos();
}