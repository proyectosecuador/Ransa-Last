<?php
require_once '../../extensiones/PhpSpreadSheet/autoload.php';

require_once "../../controladores/movi_R_D.controlador.php";
require_once "../../modelos/movi_R_D.modelo.php";

require_once "../../controladores/clientes.controlador.php";
require_once "../../modelos/clientes.modelo.php";

require_once "../../controladores/actividadE.controlador.php";
require_once "../../modelos/actividadE.modelo.php";

require_once "../../controladores/estibas.controlador.php";
require_once "../../modelos/estibas.modelo.php";

require_once "../../controladores/t_transporte.controlador.php";
require_once "../../modelos/t_transporte.modelo.php";

require_once "../../controladores/usuarios.controlador.php";
require_once "../../modelos/usuarios.modelo.php";

require_once "../../controladores/checklisttrans.controlador.php";
require_once "../../modelos/checklisttrans.modelo.php";

require_once "../../controladores/garita.controlador.php";
require_once "../../modelos/garita.modelo.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class DescargaData{
	public $_rangoFecha;

	public function DescargarDatos(){
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		$fechas = explode("-", $this->_rangoFecha);

		$valor1 = trim(str_replace("/", "-", $fechas[0]));
		$valor2 = trim(str_replace("/", "-", $fechas[1]));


		$datos =array("desde" => date("Y-m-d",strtotime($valor1)),
					  "hasta" => date("Y-m-d",strtotime($valor2)));
		$items = array("rangofechas" => "fecha_programada");

		$rpta = ControladorMovRD::ctrConsultarMovRD($datos,$items);
		if (!empty($rpta)) {
			/*===========================================
			=            CONFIGURACION LOCAL            =
			===========================================*/
			$locale = 'es';
			$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
			if (!$validLocale) {
			    echo 'Unable to set locale to ' . $locale . " - reverting to en_us" . PHP_EOL;
			}
			
			/*===============================================
			=            ENVABEZADO DE LOS DATOS            =
			===============================================*/
			$spreadsheet->getActiveSheet()->setTitle('Reporte de Actividades Estibas')
			->setCellValue('A3','Reporte de Actividades Estibas');
			$spreadsheet->getActiveSheet()->mergeCells('A3:v3');
			$spreadsheet->getActiveSheet()->getStyle('A3:v3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('4EC019');
			$spreadsheet->getActiveSheet()->getStyle('A3:v3')->getFont()->getColor()->setRGB('FFFFFF');
            $spreadsheet->getActiveSheet()->getStyle('A3')->getAlignment()->setHorizontal('center');
			$spreadsheet->getActiveSheet()->getStyle('A3')->getFont()->setBold(true)->setSize(18);
			$spreadsheet->getActiveSheet()->setCellValue('A5', 'Fecha Prog.');
			$spreadsheet->getActiveSheet()->setCellValue('B5', 'Mes');
			$spreadsheet->getActiveSheet()->setCellValue('C5', 'Cliente');
			$spreadsheet->getActiveSheet()->setCellValue('D5', 'Código');
			$spreadsheet->getActiveSheet()->setCellValue('E5', 'Proveedor Estiba');
			$spreadsheet->getActiveSheet()->setCellValue('F5', 'Actividad');
			$spreadsheet->getActiveSheet()->setCellValue('G5', 'C. Pallets');
			$spreadsheet->getActiveSheet()->setCellValue('H5', 'C. Bultos');
			$spreadsheet->getActiveSheet()->setCellValue('I5', '# Guía');
			$spreadsheet->getActiveSheet()->setCellValue('J5', 'Servicio');
			$spreadsheet->getActiveSheet()->setCellValue('K5', '# Personas');
			$spreadsheet->getActiveSheet()->setCellValue('L5', 'H. Progra.');
			$spreadsheet->getActiveSheet()->setCellValue('M5', 'H. Garita');
			$spreadsheet->getActiveSheet()->setCellValue('N5', 'H. Inicio');
			$spreadsheet->getActiveSheet()->setCellValue('O5', 'H. Fin');
			$spreadsheet->getActiveSheet()->setCellValue('P5', 'Aprobado Por');
			$spreadsheet->getActiveSheet()->setCellValue('Q5', '#Placa');
			$spreadsheet->getActiveSheet()->setCellValue('R5', '#Contenedor');
			$spreadsheet->getActiveSheet()->setCellValue('S5', 'Tiempo Total');
			$spreadsheet->getActiveSheet()->setCellValue('T5', 'Observaciones Estibas');
			$spreadsheet->getActiveSheet()->setCellValue('U5', 'Comentarios Sup.');
			$spreadsheet->getActiveSheet()->setCellValue('V5', 'ESTADO');
            $spreadsheet->getActiveSheet()->getStyle('A5:V5')->getFont()->setBold(true)->setSize(12);
			$spreadsheet->getActiveSheet()->getStyle('A5:V5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('3CB404');
			$spreadsheet->getActiveSheet()->getStyle('A5:V5')->getFont()->getColor()->setRGB('FFFFFF');

			/*=======================================================================
			=            ESTABLECIENDO EL ANCHO AUTOMATICO DE LA COLUMNA            =
			=======================================================================*/
			$spreadsheet->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('I')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('J')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('K')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('L')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('M')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('N')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('O')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('P')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('R')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('T')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('U')->setAutoSize(true);
			$spreadsheet->getActiveSheet()->getColumnDimension('V')->setAutoSize(true);

			// $spreadsheet->getActiveSheet()->getColumnDimension('S')->setAutoSize(true);
			
			
			

		// 	// $docpuntobtenido = 0; //variable para sumar
		//  //    $olpuntobtenido = 0;//variable para sumar
		//  //    $almprodpuntobtenido = 0;//variable para sumar
			/*****ubicacion de Zona Horaria*****/
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");

			
			
			$fila = 5;

		    $datos = array();
		    $tipo_trans = "";
		    for ($i=0; $i < count($rpta) ; $i++) {
		    	if ($rpta[$i]["estado"] == 7 || $rpta[$i]["estado"] == 6 || $rpta[$i]["estado"] == 5 || $rpta[$i]["estado"] == 4) {
		    	/*======================================================
		    	=            OBTENEMOS LA FECHA PROGRAMADA            =
		    	======================================================*/
		    	$fechaprog = date('d-m-Y', strtotime($rpta[$i]["fecha_programada"]));
		    	$horaprog = date("H:i:s",strtotime($rpta[$i]["fecha_programada"]));

		    	/*============================================
		    	=            CONSULTAR CHECK LIST            =
		    	============================================*/
		    	$rptacheck = ControladorCheckTransporte::ctrConsultarCheckTransporte("idmov_recep_desp",$rpta[$i]["idmov_recep_desp"]);
		    	

		    	
		    	/*========================================
		    	=            MES DE CHECK BPA            =
		    	========================================*/
		    	$mesletra = strtoupper(strftime("%B",strtotime($rpta[$i]["fecha_programada"])));

		    	/*=====================================================================
		    	=            CONSULTAR EL CLIENTE            =
		    	=====================================================================*/
	    		$rptaCliente = ControladorClientes::ctrmostrarClientes("idcliente",$rpta[$i]["idcliente"]);
				if ($rptaCliente["razonsocial"] == 'RANSA INGREDION/NETAFIM' || $rptaCliente["razonsocial"] == 'RANSA LIRIS' || $rptaCliente["razonsocial"] == 'RANSA ALICORP' || $rptaCliente["razonsocial"] == 'RANSA PRIMAX') {
					$rptaCliente = "RANSA";
				}else {
				 $rptaCliente = $rptaCliente["razonsocial"];
				}
	    		

	    		/*==========================================================
	    		=            CONSULTAMOS EL PROVEEDOR DE ESTIBA            =
	    		==========================================================*/
	    		$rptaEstibaProv = ControladorEstibas::ctrConsultarEstibas($rpta[$i]["idproveedor_estiba"],"idproveedor_estiba");

	    		/*================================================
	    		=            CONSULTAMOS LA ACTIVIDAD            =
	    		================================================*/
	    		$rptaActividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba",$rpta[$i]["idactividad"]);
	    		/*==========================================================
	    		=            CONSULTAMOS EL TIPO DE TRANSPORTE (TIPO DE SERVICIO)            =
	    		==========================================================*/
	    		$rptaTTranspporte = ControladorTTransporte::ctrConsultarTTransporte("idtipo_transporte",$rpta[$i]["idtipo_transporte"]);
	    		if ($rptaTTranspporte != null) {
	    			$tipo_trans = $rptaTTranspporte["descripcion"];
	    		}
	    		/*======================================================
	    		=            CONSULTAR SUPERVISOR APROBADOR            =
	    		======================================================*/
	    		$rptaAprbador = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rpta[$i]["idusuario"]);
	    		/*========================================================
	    		=            SEPARADOR DE NOMBRES Y APELLIDOS            =
	    		========================================================*/
	    		$nombre = explode(" ", $rptaAprbador["primernombre"]);
                $apellido = explode(" ", $rptaAprbador["primerapellido"]);
	    		
		    	$fila++;

		    	switch ($rpta[$i]["estado"]) {
		    		case 7:
		    			$estadofinal = "APROBADO";
		    			break;
		    		case 6:
		    			$estadofinal = "POR APROBAR";
		    			break;
		    		case 5:
		    			$estadofinal = "X APROBAR SUP.";
		    			break;
		    		case 4:
		    			$estadofinal = "PENDIENTE INGRESAR DATOS";
		    			break;
		    	}
    	
		    	array_push($datos, array($fechaprog,
		    							$mesletra,
		    							$rptaCliente,
		    							$rpta[$i]["codigo_generado"],
		    							$rptaEstibaProv["nombre_proveedor"],
		    							$rptaActividad["descripcion"],
		    							$rpta[$i]["cant_pallets"],
		    							$rpta[$i]["cant_bultos"],
		    							$rpta[$i]["nguias"],
		    							$tipo_trans,
		    							$rpta[$i]["cant_personas"],
		    							Date::PHPToExcel(date("Y-m-d H:i:s",strtotime($fechaprog." ".$horaprog))),
		    							Date::PHPToExcel(date("Y-m-d H:i:s",strtotime($fechaprog." ".$rpta[$i]["h_garita"]))),
		    							Date::PHPToExcel(date("Y-m-d H:i:s",strtotime($fechaprog." ".$rpta[$i]["h_inicio"]))),
		    							Date::PHPToExcel(date("Y-m-d H:i:s",strtotime($fechaprog." ".$rpta[$i]["h_fin"]))),
		    							$nombre[0]." ".$apellido[0],
		    							$placa = isset($rptacheck["placa"]) ? $rptacheck["placa"] : "",
		    							$contenedor = isset($rpta[$i]["ncontenedor"]) ? $rpta[$i]["ncontenedor"] : "",
		    							"=(O".$fila."-N".$fila.")",
		    							$rpta[$i]["observaciones_estibas"],
		    							$rpta[$i]["comentarios"],
		    							$estadofinal));

		    	}

		    }
			$spreadsheet->getActiveSheet()
			    ->fromArray(
			        $datos,  // The data to set
			        NULL,        // Array values with this value will not be set
			        'A6'         // Top left coordinate of the worksheet range where
			                     //    we want to set these values (default is A1)
			    );
			    $cant = count($rpta);

$spreadsheet->getActiveSheet()->getStyle("L6:O".($fila+$cant))->getNumberFormat()
    ->setFormatCode("h:mm:s");

$spreadsheet->getActiveSheet()->getStyle("S6:S".($fila+$cant))->getNumberFormat()
    ->setFormatCode("h:mm:s");
			/*===============================================
			=            ASIGNAREL TIPO DE DATOS            =
			===============================================*/
		}
		$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="file.xlsx"');
		$writer->save("php://output");	

	}

/*===========================================================
=            DESCARGA DE DATOS DE GARITA A EXCEL            =
===========================================================*/
	public function DescargarDatosGarita(){
		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();
		// var_dump($this->_rangoFecha);
		$fechas = explode("-", $this->_rangoFecha);

		$valor1 = trim(str_replace("/", "-", $fechas[0]));
		$valor2 = trim(str_replace("/", "-", $fechas[1]));


		$datos =array("desde" => date("Y-m-d",strtotime($valor1)),
					  "hasta" => date("Y-m-d",strtotime($valor2)),
					"idgarita" => $_COOKIE['usuarioGarita']);
		$items = array("rangofechasGarita" => "fecha_llegada");
		$rpta = ControladorGarita::ctrConsultarGarita($items,$datos);
		if (!empty($rpta)) {
			/*===========================================
			=            CONFIGURACION LOCAL            =
			===========================================*/
			$locale = 'es';
			$validLocale = \PhpOffice\PhpSpreadsheet\Settings::setLocale($locale);
			if (!$validLocale) {
			    echo 'Unable to set locale to ' . $locale . " - reverting to en_us" . PHP_EOL;
			}
			/* AGREGAMOS EL LOGO DE RANSA */
			$drawing = new \PhpOffice\PhpSpreadsheet\Worksheet\Drawing();
			$drawing->setName('Logo');
			$drawing->setDescription('Logo');
			$drawing->setPath('../../vistas/img/login/logotipo.png');
			$drawing->setHeight(50);
			$drawing->setCoordinates('A1');
			$drawing->setWorksheet($spreadsheet->getActiveSheet());

			
			/*===============================================
			=            ENVABEZADO DE LOS DATOS            =
			===============================================*/
			$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
			$spreadsheet->getActiveSheet()->mergeCells('A4:P4'); // COMBINAR CELDAS
			$spreadsheet->getActiveSheet()->mergeCells('Q4:U4'); // COMBINAR CELDAS
			$spreadsheet->getActiveSheet()->getStyle('A5:U'.(count($rpta)+5)) // AJUSTAR TEXTO
    		->getAlignment()->setWrapText(true);
    		$spreadsheet->getDefaultStyle()->getFont()->setSize(14);
			$spreadsheet->getActiveSheet()->setCellValue('A4', 'DATOS DE INGRESO');
			$spreadsheet->getActiveSheet()->getStyle('A4:U5') // CENTRAR EL TEXTO HORIZONTALMENTE
    		->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);

    		$spreadsheet->getActiveSheet()->setCellValue('Q4', 'DATOS DE SALIDA');
    		// $spreadsheet->getActiveSheet()->getStyle('N4') // CENTRAR EL TEXTO HORIZONTALMENTE
    		// ->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    		$spreadsheet->getDefaultStyle()->getFont()->setSize(10);
    		$spreadsheet->getActiveSheet()->setCellValue('A5', "#");
			$spreadsheet->getActiveSheet()->setCellValue('B5', 'Fecha llegada');
			$spreadsheet->getActiveSheet()->setCellValue('C5', 'Sube a bodega');
			$spreadsheet->getActiveSheet()->setCellValue('D5', 'Puerta asignada');
			$spreadsheet->getActiveSheet()->setCellValue('E5', 'Autorizado');
			$spreadsheet->getActiveSheet()->setCellValue('F5', 'Sello');
			$spreadsheet->getActiveSheet()->setCellValue('G5', 'Conductor');
			$spreadsheet->getActiveSheet()->setCellValue('H5', 'Placa');
			$spreadsheet->getActiveSheet()->setCellValue('I5', 'C.I.');
			$spreadsheet->getActiveSheet()->setCellValue('J5', 'Guías');
			$spreadsheet->getActiveSheet()->setCellValue('K5', 'Compañía Transporte');
			$spreadsheet->getActiveSheet()->setCellValue('L5', 'Tipo vehículo');
			$spreadsheet->getActiveSheet()->setCellValue('M5', 'Cuenta Ransa');
			$spreadsheet->getActiveSheet()->setCellValue('N5', 'Ayudantes');
			$spreadsheet->getActiveSheet()->setCellValue('O5', 'Cédula ayudante.');
			$spreadsheet->getActiveSheet()->setCellValue('P5', 'Observaciones');
			$spreadsheet->getActiveSheet()->setCellValue('Q5', 'Fecha Hora');
			$spreadsheet->getActiveSheet()->setCellValue('R5', 'Guía');
			$spreadsheet->getActiveSheet()->setCellValue('S5', 'Sellos');
			$spreadsheet->getActiveSheet()->setCellValue('T5', 'Observaciones');
			$spreadsheet->getActiveSheet()->setCellValue('U5', 'Estado');


			// =======================================================================
			// =            ESTABLECIENDO EL ANCHO AUTOMATICO DE LA COLUMNA            =
			// =======================================================================
			$spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(4, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('I')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('J')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('L')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('M')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('P')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('Q')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('R')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('s')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('T')->setWidth(15, 'px');
			$spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(15, 'px');
			
			/* ESTILO DEL ENCABEZADO */
			$styleArray = [
			    'font' => [
			        'bold' => true,
			    ],
			    'alignment' => [
			        'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
			    ],
			    'borders' => [
			        'allBorders' => [
			            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
			            'color' => ['argb' => '5f5e5e'],
			        ],
			    ]
			];

			$spreadsheet->getActiveSheet()->getStyle('A4:U5')->applyFromArray($styleArray);

			/*****ubicacion de Zona Horaria*****/
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");
			$spreadsheet->getActiveSheet()
			    ->fromArray(
			        $rpta,  // The data to set
			        NULL,        // Array values with this value will not be set
			        'A6'         // Top left coordinate of the worksheet range where
			                     //    we want to set these values (default is A1)
			    );
			/*===============================================
			=            ASIGNAREL TIPO DE DATOS            =
			===============================================*/
				$writer = new Xlsx($spreadsheet);
		header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		header('Content-Disposition: attachment; filename="file.xlsx"');
		$writer->save("php://output");
		
		}else{
			// echo "zndjfn";
			echo "<script>alert('No se encuentran registros en la fecha seleccionada..');  window.location = 'http://localhost/ransa/Gestion-Transporte';</script>";
		}
	



	}



}

if (isset($_POST["rangeFecha"])) {
	$desc_data = new DescargaData();
	$desc_data -> _rangoFecha = $_POST["rangeFecha"];
	$desc_data -> DescargarDatos();
}

if (isset($_POST['rangeFechaGarita'])) {
	$desc_data = new DescargaData();
	$desc_data -> _rangoFecha = $_POST["rangeFechaGarita"];
	$desc_data -> DescargarDatosGarita();	
}