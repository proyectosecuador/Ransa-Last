<?php
require_once "../controladores/ciudad.controlador.php";
require_once "../modelos/ciudad.modelo.php";

require_once "../controladores/checklistbpa.controlador.php";
require_once "../modelos/checklistbpa.modelo.php";

// require_once '../extensiones/mpdf/vendor/autoload.php';
require_once "../extensiones/fpdf/fpdf.php";

session_start();
class AjaxCheckBpa{
	public $idchcklstbpa;
	public $doc;
	public $ol;
	public $aproductos;
	public $idcliente;
	public $idauditor;
	public $nombrecliente;
	public $nombreauditor;
	public $registroimgevidencia;
	public $observaciones;
	public $idlocalizacion;
	public $fecha;

	public function ajaxRegistroimgEvidencia(){
		$datos = $this->registroimgevidencia;
		/*==================================================================================
		=            OBTENEMOS EL NOMBRE DE LA CIUDAD QUE PERTENECE EL USUARIO (PARA GUARDAR LA IMAGEN EN UNA CARPETA EN ESPECIFICO)            =
		==================================================================================*/
		$rptaciudad = ControladorCiudad::ctrConsultarCiudad("idciudad",$_SESSION["ciudad"]); 
		/*========================================================
		=            CONSULTAMOS SI EXISTE EL ARCHIVO            =
		========================================================*/
		/*****ubicacion de Zona Horaria*****/
		date_default_timezone_set('America/Guayaquil');
		/******para presentar la fecha en español******/
		setlocale(LC_ALL, "esp");		
		if ( isset($datos["tmp_name"]) && !empty($datos['tmp_name'])) {
			/* OBTENEMOS EL MES EN TEXTO */
			$date = date('Y-m-d');
			$mes_actual = strftime("%B",strtotime($date));
			
			$directorio = "../archivos/CheckBpa/".$rptaciudad["desc_ciudad"]."/";

			if (!file_exists($directorio)) {
				mkdir($directorio,0777);
			}
			// if(!file_exists($directorio."/".$mes_actual."/")){
			// 	 CREAMOS LA CARPETA CON EL NOMBRE DEL MES 
			// 	mkdir($directorio.$mes_actual."/",0777);
			// }
			// $rutafinal = $directorio.$mes_actual."/";
			$nombre = uniqid();
			$rutaimgevidencia = $directorio.$nombre.".png";
			move_uploaded_file($datos['tmp_name'],$rutaimgevidencia);

			echo $rutaimgevidencia;			
		}

	}
	/*==================================================
	=            REGISTRO DE CHECK LIST BPA            =
	==================================================*/
	public function ajaxRegistroCheckBpa(){
		$checkdocument  = array();
		$obserdocument = array();
		/*===========================================
		=            CHECK DE DOCUMENTOS            =
		===========================================*/
		$documentos = json_decode($this->doc,true);
		foreach ($documentos as $keydoc => $valuedoc) {
			foreach ($valuedoc as $keydocum => $valuedocum) {
				if (is_int($keydocum)) {
					array_push($obserdocument,array("obsdoc".$keydocum => $valuedocum));
				}else{
					array_push($checkdocument,array("doc".substr($keydocum,-1)  => $valuedocum));
				}
				
			}
		}
		/*=================================================
		=            CHECK DE ORDEN Y LIMPIEZA            =
		=================================================*/
		$olimpieza = json_decode($this->ol,true);
		foreach ($olimpieza as $keyol => $valueol) {
			foreach ($valueol as $keyolim => $valueolim) {
				if (is_int($keyolim)) {
					array_push($obserdocument,array("obsol".$keyolim => $valueolim));
				}else{
					if (substr($keyolim,-2) == 8 || substr($keyolim,-2) == 9 ) {
						array_push($checkdocument,array("ol".substr($keyolim,-2)  => $valueolim));	
					}else{
						array_push($checkdocument,array("ol".substr($keyolim,-1)  => $valueolim));	
					}
					
				}
			}
		}

		/*=====================================================
		=            CHECK DE ALMACEN DE PRODUCTOS            =
		=====================================================*/
		$almproduc = json_decode($this->aproductos,true);
		foreach ($almproduc as $keyap => $valueap) {
			foreach ($valueap as $keyalmpro => $valuealmpro) {
				if (is_int($keyalmpro)) {
					array_push($obserdocument,array("obsalmprod".$keyalmpro => $valuealmpro));
				}else{
					if (substr($keyalmpro,-2) == 7 || substr($keyalmpro,-2) == 8 || substr($keyalmpro,-2) == 9 ) {
						array_push($checkdocument,array("almprod".substr($keyalmpro,-2)  => $valuealmpro));	
					}else{
						array_push($checkdocument,array("almprod".substr($keyalmpro,-1)  => $valuealmpro));	
					}
					
				}				
				
			}
		}
		$checkbpa = array();
		$chackobs = array();
		$numob = 0;
		/*=================================================================================================
		=            CONVERTIR EL ARRAY MULTIDIMENSIONAL EN UNO SIMPLE DE VALORES DE CHECK BPA            =
		=================================================================================================*/
		foreach ($checkdocument as $key => $value) {
			foreach ($value as $keys => $values) {
				$checkbpa[$keys] = $values;
			}
		}
		/*=================================================================================================
		=            CONVERTIR EL ARRAY MULTIDIMENSIONAL EN UNO SIMPLE DE OBSERVACIONES DE CHECK BPA            =
		=================================================================================================*/
		foreach ($obserdocument as $keyob => $valueob) {
			foreach ($valueob as $keysobs => $valuesobs) {
				if (!empty($valuesobs)) {
					$chackobs[$keysobs] = strtoupper($valuesobs);
				}else{
					$numob += 1;
				}
				
			}
		}
		/*====================================================
		=            LLENAMOS LOS DATOS FALTANTES            =
		====================================================*/
		$checkbpa["rutaimagenes"] = $this->registroimgevidencia;
		$checkbpa["observaciones"] = preg_replace('[\n|\r|\n\r]','',nl2br(strtoupper($this->observaciones))); // Eliminamos los saltos de linea y colocamos <br> para guardar en base
		if ($this->idcliente == "Global") {
			$checkbpa["idcliente"] = null;
		}else{
			$checkbpa["idcliente"] = $this->idcliente;
		}
		$checkbpa["idauditor"] = $this->idauditor;
		$checkbpa["idciudad"] = $_SESSION["ciudad"];
		$checkbpa["idlocalizacion"] = $this->idlocalizacion;
		$checkbpa["fecha"] = $this->fecha;
		/*=========================================================
		=            ENVIAMOS LOS DATOS AL CONTROLADOR            =
		=========================================================*/
		$rptacheckbpa = ControladorCheckListBpa::ctrRegistroCheckListBpa($checkbpa);

		/*=====================================================================================================
		=            GUARDAMOS LAS OBSERVACIONES Y OBTENEMOS EL ULTIMO ID DE LA TABLA DE CHECK BPA            =
		=====================================================================================================*/
		if ($rptacheckbpa != 0) {
			
			$checkbpasalida = array_slice($checkbpa, 0,25);
			$idcheckbpa = $rptacheckbpa;
			if (!empty($chackobs)) {
				$rptaObserCheck = ControladorCheckListBpa::ctrRegistroObservacionCheckBpa($chackobs,$checkbpasalida,$idcheckbpa);	
				if ($rptaObserCheck == "ok") {
					echo 1;
				}				
			}else{
				echo 1;
			}
		}
	}	
}
/*=====================================================================
=            REGISTRO DE IMAGENES EVIDENCIA CHECK LIST BPA            =
=====================================================================*/
if (isset($_FILES['registroimgevidencia']["tmp_name"])) {
	$regischeckbpa = new AjaxCheckBpa();

	$regischeckbpa -> registroimgevidencia = $_FILES["registroimgevidencia"];
	
	$regischeckbpa -> ajaxRegistroimgEvidencia();
}
/*==================================================
=            REGISTRO DE CHECK LIST BPA            =
==================================================*/
if (isset($_POST["RegistBaseobservaciones"])) {
	$regischeckbpa = new AjaxCheckBpa();
	$regischeckbpa -> doc = $_POST["doc"];
	$regischeckbpa -> ol = $_POST["ol"];
	$regischeckbpa -> aproductos = $_POST["aproductos"];
	$regischeckbpa -> idcliente = $_POST["idcliente"];
	$regischeckbpa -> idauditor = $_POST["idauditor"];
	$regischeckbpa -> nombrecliente = $_POST["nombrecliente"];
	$regischeckbpa -> nombreauditor = $_POST["nombreauditor"];
	$regischeckbpa -> observaciones = $_POST["RegistBaseobservaciones"];
	$regischeckbpa -> idlocalizacion = $_POST["idlocalizacion"];
	$regischeckbpa -> fecha = $_POST["fechabpa"];
	$regischeckbpa -> registroimgevidencia = $_POST["listaoImgEvidencia"];
	$regischeckbpa -> ajaxRegistroCheckBpa();
}



