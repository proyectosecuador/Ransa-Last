<?php
// session_start();
// require_once "../controladores/usuarios-garita.controlador.php";
// require_once "../modelos/usuarios-garita.modelo.php";

// require_once "../controladores/localizacion.controlador.php";
// require_once "../modelos/localizacion.modelo.php";

// require_once "../controladores/movi_R_D.controlador.php";
// require_once "../modelos/movi_R_D.modelo.php";

// require_once "../controladores/checklisttrans.controlador.php";
// require_once "../modelos/checklisttrans.modelo.php";

// require_once "../controladores/garita.controlador.php";
// require_once "../modelos/garita.modelo.php";

// use  PHPMailer\PHPMailer\PHPMailer ; 
// use  PHPMailer\PHPMailer\Exception ;

// // require_once "../extensiones/TCPDF/tcpdf.php";

// require_once '../extensiones/PHPMailer/PHPMailer/src/Exception.php';
// require_once '../extensiones/PHPMailer/PHPMailer/src/PHPMailer.php';
// require_once '../extensiones/PHPMailer/PHPMailer/src/SMTP.php';

// require_once  "../extensiones/PHPMailer/vendor/autoload.php";


// class AjaxGarita{
// 	/* VARIABLES PUBLICAS */
// 	public $_idmovimiento;
// 	public $_idciudad;
// 	public $_idlocalizacion;
// 	public $_idactividad;
// 	public $_tipo_carga;
// 	public $_cuadrilla;
// 	public $_comentSup;

// 	public $_clave;

// 	public $_placa;
// 	public $_conductor;
// 	public $_cedula;
// 	public $_ctaR;
// 	public $_sello;
// 	public $_tipovehiculo;
// 	public $_comp_transp;
// 	public $_personaAutoriza;
// 	public $_ayudante;
// 	public $_ciayudante;
// 	public $_observIngreso;
// 	public $_guiaentrada;
// 	public $_numPuerta;
// 	public $_idcliente;
// 	public $_idgarita;
// 	/*=======================================================================
// 	=            FUNCION PARA CONSULTAR LA GARITA SEGÚN LA CLAVE            =
// 	=======================================================================*/
// 	public function ajaxConsultaLocalizacion(){

// 		$rptaLocalizacion = ControladorLocalizacion::ctrConsultarLocalizacion($this->_idciudad,"idciudad");

// 		echo json_encode($rptaLocalizacion);

// 	}

// 	/*===============================================================
// 	=            CONSULTAR GARITA Y VERIFICAR CONTRASEÑA            =
// 	===============================================================*/
// 	public function ajaxConsultarGarita(){

// 		$item = array("item1" => "idlocalizacion",
// 									"item2" => "idciudad");
// 		$datos = array("dato1" => $this->_idlocalizacion,
// 									 "dato2" => $this->_idciudad);


// 		$rptaGarita = ControladorUserGarita::ctrConsultarUserGarita($item,$datos);
// 		if (!$rptaGarita) {
// 			echo 3;
// 		}else if (password_verify($this->_clave, $rptaGarita["clave"])) {
// 			// setcookie("usuarioGarita",$rptaGarita["idusuarios_garita"],time()+86400);
// 			echo json_encode($rptaGarita,true);
// 		}else{
// 			echo 2;
// 		}

// 	}
// 		/*==========================================================================
// 	=            REPORTAR QUE EL VEHICULO SE HA ANUNCIADO EN GARITA            =
// 	==========================================================================*/
// 	public function ajaxAnuncioTransporte(){
// 		// CONSULTAMOS SI EXISTE UN REGISTRO CON EL ID DEL VEHICULOS
// 		$rptaCheckConsult = ControladorCheckTransporte::ctrConsultarCheckTransporte("idmov_recep_desp",$this->_idmovimiento);
// 		$rptaChec = '';
// 		if ($rptaCheckConsult) { //EN EL CASO DE EXISTIR UN REGSISTRO SE ACTUALIZA LOS DATOS REGISTRADOS
// 			$datoscheck = array("placa" => $placa = $this->_placa != "" ? strtoupper($this->_placa) : null,
// 								"idmovimiento" => $this->_idmovimiento,
// 								"conductor" => $conductor = $this->_conductor != "" ? strtoupper($this->_conductor) : null);

// 			$rptaChec = ControladorCheckTransporte::ctrActualizarCheckTransporte("idmov_recep_desp",$datoscheck);
			
// 		}else{ // EN CASO DE NO EXISTTIR SE REALIZA UN NUEVO REGISTRO
// 			$datoscheck = array("transportista" => $conductor = $this->_conductor != "" ? strtoupper($this->_conductor) : null,
// 							"placa" => $placa = $this->_placa != "" ? strtoupper($this->_placa) : null,
// 							"idmovimiento" => $this->_idmovimiento);
// 			$rptaChec = ControladorCheckTransporte::ctrInsertarCheckTransporte($datoscheck);
// 		}
// 		// UNA VEZ INGRESADA LA INFORMACION DE CHECK LIST INGRESAR LOS DATOS DE GARITA
// 		if ($rptaChec == "ok") {
// 			if ($this->_numPuerta != null || $this->_numPuerta != "") {
// 				/*****ubicacion de Zona Horaria*****/
// 				date_default_timezone_set('America/Bogota');
// 				/******para presentar la fecha en espa単ol******/
// 				setlocale(LC_ALL, "esp");
// 				$fecha_sube_bodega = date("Y-m-d H:i:s");
// 				$puerta_asignada = $this->_numPuerta;
// 				$estado = 2;
// 			}else{
// 				$fecha_sube_bodega = null;
// 				$puerta_asignada = null;
// 				$estado = 1;

// 			}
// 			$datosgarita = array("idmovimiento" => $this->_idmovimiento,
// 								"idusuarios_garita" => $_COOKIE['usuarioGarita'],
// 								"cedula" => $this->_cedula,
// 								"ctaR" => $this->_ctaR,
// 								"sello" => $sello = $this->_sello != "" ? $this->_sello : null,
// 								"tipovehiculo" => $this->_tipovehiculo,
// 								"idPers_autoriza" => $this->_personaAutoriza,
// 								"comp_transp" => $this->_comp_transp,
// 								"fecha_sube_bodega" => $fecha_sube_bodega,
// 								"puerta_asignada" => $puerta_asignada,
// 								"estadov" => $estado,
// 								"ayudante" => $ayudante =  $this->_ayudante != "" ? $this->_ayudante : null,
// 								"ciayudante" => $ciayudante = $this->_ciayudante != "" ? $this->_ciayudante : null,
// 								"guiaentrada" => $guiaentrada = $this->_guiaentrada != "" ? $this->_guiaentrada : null,
// 								"observIngreso" => $obsingreso = $this->_observIngreso != "" ? $this->_observIngreso : null);

// 			$rptaGarita = ControladorGarita::ctrInsertarGarita($datosgarita);

// 			if ($rptaGarita) {
// 				echo 1; 
// 			}else{
// 				echo 2;
// 			}
// 		}		
// 	}
// 	/*===============================================================
// 	=            REGISTAR UN NUEVO TRANSPORTE POR GARITA            =
// 	===============================================================*/
// 	public function ajaxNuevoTransporte(){
// 		/*==========================================================
// 		=            PRIMERO GUARDAR EL TIPO MOVIMIENTO            =
// 		==========================================================*/
// 		$datosmov = array("idcliente" => $this->_idcliente,
// 						"idlocalizacion" => $_COOKIE['idlocalizacion'],
// 						"idciudad" => $_COOKIE['ciudadGarita'],
// 						"idusuariogarita" => $_COOKIE['usuarioGarita'],
// 						"modo" => "garita");
// 		$rpta = ControladorMovRD::ctrRegistrarMovRD($datosmov);
// 		/*=========================================
// 		=            LUEGO INGRESAMOS DATOS PARA CHECK LIST TRANSPORTE          =
// 		=========================================*/
// 		if ($rpta) {
// 			/*=====================================================================================
// 			=            ALMACENAMOS EL DATOS INCIALES DE CONDUCTOR Y PLACA CHECK LIST            =
// 			=====================================================================================*/
// 			$datoscheck = array("transportista" => $conductor = $this->_conductor != "" ? strtoupper($this->_conductor) : null,
// 							"placa" => $placa = $this->_placa != "" ? strtoupper($this->_placa) : null,
// 							"idmovimiento" => $rpta);
// 			$rptacheck = ControladorCheckTransporte::ctrInsertarCheckTransporte($datoscheck);
// 				if ($rptacheck == "ok") {
// 					if ($this->_numPuerta != null || $this->_numPuerta != "") {
// 						/*****ubicacion de Zona Horaria*****/
// 						date_default_timezone_set('America/Bogota');
// 						/******para presentar la fecha en espa単ol******/
// 						setlocale(LC_ALL, "esp");
// 						$fecha_sube_bodega = date("Y-m-d H:i:s");
// 						$puerta_asignada = $this->_numPuerta;
// 						$estado = 2;
// 					}else{
// 						$fecha_sube_bodega = null;
// 						$puerta_asignada = null;
// 						$estado = 1;

// 					}
// 					$datosgarita = array("idmovimiento" => $rpta,
// 										"idusuarios_garita" => $_COOKIE['usuarioGarita'],
// 										"cedula" => $this->_cedula,
// 										"ctaR" => $this->_ctaR,
// 										"sello" => $sello = $this->_sello != "" ? $this->_sello : null,
// 										"tipovehiculo" => $this->_tipovehiculo,
// 										"idPers_autoriza" => $this->_personaAutoriza,
// 										"comp_transp" => $this->_comp_transp,
// 										"fecha_sube_bodega" => $fecha_sube_bodega,
// 										"puerta_asignada" => $puerta_asignada,
// 										"estadov" => $estado,
// 										"ayudante" => $ayudante =  $this->_ayudante != "" ? $this->_ayudante : null,
// 										"ciayudante" => $ciayudante = $this->_ciayudante != "" ? $this->_ciayudante : null,
// 										"guiaentrada" => $guiaentrada = $this->_guiaentrada != "" ? $this->_guiaentrada : null,
// 										"observIngreso" => $obsingreso = $this->_observIngreso != "" ? $this->_observIngreso : null);

// 					$rptaGarita = ControladorGarita::ctrInsertarGarita($datosgarita);
// 					if ($rptaGarita) {
// 						echo 1; 
// 					}else{
// 						echo 2;
// 					}
// 				}
// 		}
		
// 	}
// 	/*========================================================================
// 	=            EDITAR EL CLIENTE EN CASO QUE GARITA INGRESE MAL            =
// 	========================================================================*/
// 	public function ajaxEditCliente(){
// 		$datos = array("idcliente" => $this->_idcliente,
// 						"idusermodCliente" => $_SESSION["id"]);
// 		$item = array("EditClienteAnun" => $this->_idmovimiento);

// 		$rpta = ControladorMovRD::ctrEditarMovRDEst($datos,$item);

// 		echo $rpta;
// 	}
// 	/*============================================================================
// 	=            COMPLETA DATOS EL SUPERVISOR QUE HACE FALTA A GARITA            =
// 	============================================================================*/
// 	public function ajaxCompletarDatosSup(){
// 		$datos = array("idactividad" => $this->_idactividad,
// 						"tipo_carga" => $this->_tipo_carga,
// 						"cuadrilla" => $this->_cuadrilla,
// 						"idusuario" => $_SESSION['id'],
// 						"comentSup" => strtoupper($this->_comentSup));
// 		$item = array("editComple" => $this->_idmovimiento);
// 		$rpta = ControladorMovRD::ctrEditarMovRDEst($datos,$item);
// 		if ($rpta == "ok") {
// 			echo $rpta;
// 			/*========================================================================
// 			=            ASIGNAMOS LA PUERTA EN CASO DE YA HABER INDICADO            =
// 			========================================================================*/
// 			// if ($this->_numPuerta != "" || $this->_numPuerta != null) {
// 			// 	$datosPuerta = array("numpuerta" => $this->_numPuerta);
// 			// 	$item = array("puerta" => $this->_idmovimiento);
// 			// 	$rptaPuerta = ControladorGarita::ctrEditarGarita($datosPuerta,$item);

// 			// 	echo $rptaPuerta;
// 			// }else{
				
// 			// 	echo $rpta;
// 			// }

			
			
// 		}

// 	}
// 	/*===============================================
// 	=            ASIGNAMOS PUERTA GARITA            =
// 	===============================================*/
// 	public function ajaxAsignarPuertaGarita(){
// 		$datos = array("puerta_asignada" => $this->_numPuerta);
// 		$item = array("puerta" => $this->_idgarita);

// 		$rpta = ControladorGarita::ctrEditarGarita($datos,$item);
// 		if ($rpta) {
// 			echo $rpta;
// 		}
// 	}
// 	/*===========================================
// 	=            SALIDA DEL VEHICULO            =
// 	===========================================*/
// 	public function ajaxSalidaVehiculo(){
// 		$datos = array("sello" => $this->_sello == "" ? null : $this->_sello,
// 						"observIngreso" => $this->_observIngreso == "" ? null:$this->_observIngreso,
// 						"guiaentrada" => $this->_guiaentrada == "" ? null : $this->_guiaentrada);
// 		$item = array("salidaidgarita" => $this->_idgarita);
// 		$rpta = ControladorGarita::ctrEditarGarita($datos,$item);
// 		if ($rpta) {
// 			echo $rpta;
// 		}
// 	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
// }

// /*===========================================
// =            REGISTRO DE EQUIPOS            =
// ===========================================*/
// if (isset($_POST["consultarLocalizacion"])) {
// 	$consultarGarita = new AjaxGarita();
// 	$consultarGarita -> _idciudad = $_POST["consultarLocalizacion"];
// 	$consultarGarita -> ajaxConsultaLocalizacion();
// }
// /*==========================================================
// =            CONSULTAR GARITA Y CONFIRMAR CLAVE            =
// ==========================================================*/
// if (isset($_POST['ConfirmarGaritaclave'])) {
// 	$confirmGarita = new AjaxGarita();
// 	$confirmGarita -> _idciudad = $_POST['idciudad'];
// 	$confirmGarita -> _idlocalizacion = $_POST['idlocalizacion'];
// 	$confirmGarita -> _clave = $_POST['ConfirmarGaritaclave'];
// 	$confirmGarita -> ajaxConsultarGarita();
// }

// /*==============================================================
// =            REPORTAR QUE EL VEHICULO YA HA LLEGADO            =
// ==============================================================*/
// // if (isset($_POST["AnunciarLlegada"])) {
// // 	$anunciTransporte = new AjaxGarita();
// // 	$anunciTransporte -> _idmovimiento = $_POST["AnunciarLlegada"];
// // 	$anunciTransporte -> ajaxAnuncioTransporte();
// // }
// /*=======================================================
// =            ANNUNCIO DEL VEHICULO EN GARITA            =
// =======================================================*/
// if (isset($_POST['anuncioplacagarita'])) {
// 	$anunciTransporte = new AjaxGarita();
// 	$anunciTransporte -> _placa = $_POST['anuncioplacagarita'];
// 	$anunciTransporte -> _idmovimiento = $_POST['idmov'];
// 	$anunciTransporte -> _conductor = $_POST['conductorgarita'];
// 	$anunciTransporte -> _cedula = $_POST['cedulagarita'];
// 	$anunciTransporte -> _ctaR = $_POST['ctaRgarita'];
// 	$anunciTransporte -> _sello = $_POST['sellogarita'];
// 	$anunciTransporte -> _tipovehiculo = $_POST['tipovehiculogarita'];
// 	$anunciTransporte -> _comp_transp = $_POST['comp_transpgarita'];
// 	$anunciTransporte -> _personaAutoriza = $_POST['personaAutoriza'];
// 	$anunciTransporte -> _ayudante = $_POST['ayudante'];
// 	$anunciTransporte -> _ciayudante = $_POST['ciayudante'];
// 	$anunciTransporte -> _observIngreso = $_POST['observIngreso'];
// 	$anunciTransporte -> _guiaentrada = $_POST['guiaentrada'];
// 	$anunciTransporte -> _numPuerta = $puerta = isset($_POST['numPuerta']) ? $_POST['numPuerta'] : null;
	
	
// 	$anunciTransporte -> ajaxAnuncioTransporte();	
// }

// /*========================================================
// =            REGISTRO DE VEHICULOS POR GARITA            =
// ========================================================*/
// if (isset($_POST['registrovehiculoplaca'])) {
// 	$registVehiculo = new AjaxGarita();
// 	$registVehiculo -> _placa = $_POST['registrovehiculoplaca'];
// 	$registVehiculo -> _conductor = $_POST['conductorgarita'];
// 	$registVehiculo -> _idcliente = $_POST['idcliente'];
// 	$registVehiculo -> _cedula = $_POST['cedulagarita'];
// 	$registVehiculo -> _ctaR = $_POST['ctaRgarita'];
// 	$registVehiculo -> _sello = $_POST['sellogarita'];
// 	$registVehiculo -> _tipovehiculo = $_POST['tipovehiculogarita'];
// 	$registVehiculo -> _comp_transp = $_POST['comp_transpgarita'];
// 	$registVehiculo -> _personaAutoriza = $_POST['personaAutoriza'];
// 	$registVehiculo -> _ayudante = $_POST['ayudante'];
// 	$registVehiculo -> _ciayudante =  $_POST['ciayudante'];
// 	$registVehiculo -> _observIngreso = $_POST['observIngreso'];
// 	$registVehiculo -> _guiaentrada = $_POST['guiaentrada'];
// 	$registVehiculo -> _numPuerta = $puerta = isset($_POST['numPuerta']) ? $_POST['numPuerta'] : null;
// 	$registVehiculo -> ajaxNuevoTransporte();
// }
// /*==================================================================================
// =            EDITA EL CLIENTE EN CASO QUE GARITA INGRESE EL CLIENTE MAL            =
// ==================================================================================*/
// if (isset($_POST['editClientAnunGarit'])) {
// 	$editCliente = new AjaxGarita();
// 	$editCliente -> _idmovimiento = $_POST['idmov'];
// 	$editCliente -> _idcliente = $_POST['editClientAnunGarit'];
// 	$editCliente -> ajaxEditCliente();
// }
// /*====================================================================================
// =            COMPLETAR LOS DATOS DE LA SOLICITUD POR PARTE DEL SUPERVISOR            =
// ====================================================================================*/
// if (isset($_POST["idactividadDatosComplet"])) {
// 	$datosComplete = new AjaxGarita();
// 	$datosComplete -> _idmovimiento = $_POST['idmovimiento'];
// 	$datosComplete -> _idactividad = $_POST['idactividadDatosComplet'];
// 	$datosComplete -> _tipo_carga = $_POST['idtipoCarga'];
// 	$datosComplete -> _cuadrilla = $_POST['soliCuadrilla'];
// 	$datosComplete -> _comentSup = $_POST['comentariosSup'];
// 	// $datosComplete -> _numPuerta = $_POST['numpuerta'];

// 	$datosComplete -> ajaxCompletarDatosSup();
// }
// # ==============================================================
// # =           ASIGNACION DE PUERTA UNA VEZ ANUNCIADO           =
// # ==============================================================
// if (isset($_POST['idgaritapuerta'])) {
// 	$anunpuerta = new AjaxGarita();
// 	$anunpuerta -> _idgarita = $_POST['idgaritapuerta'];
// 	$anunpuerta -> _numPuerta = $_POST['numPuerta'];
// 	$anunpuerta -> ajaxAsignarPuertaGarita();
// }
// /*================================================================
// =            SALIDA DEL VEHICULO DE LAS INSTALACIONES            =
// ================================================================*/
// if (isset($_POST['guiasalida'])) {
// 	$salida = new AjaxGarita();
// 	$salida -> _idgarita = $_POST['idmov'];
// 	$salida -> _sello = $_POST['sellosalida'];
// 	$salida -> _observIngreso = $_POST['obssalida'];
// 	$salida -> _guiaentrada = $_POST['guiasalida'];
// 	$salida -> ajaxSalidaVehiculo();
// }










