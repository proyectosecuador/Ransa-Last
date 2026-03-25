<?php
session_start();
require_once '../extensiones/PhpSpreadSheet/autoload.php';

require_once "../controladores/estibas.controlador.php";
require_once "../modelos/estibas.modelo.php";

require_once "../controladores/movi_R_D.controlador.php";
require_once "../modelos/movi_R_D.modelo.php";

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";

require_once "../controladores/checklisttrans.controlador.php";
require_once "../modelos/checklisttrans.modelo.php";

require_once "../controladores/t_transporte.controlador.php";
require_once "../modelos/t_transporte.modelo.php";

require_once "../controladores/actividadE.controlador.php";
require_once "../modelos/actividadE.modelo.php";

require_once "../controladores/tipo_carga.controlador.php";
require_once "../modelos/tipo_carga.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/pers_autoriza.controlador.php";
require_once "../modelos/pers_autoriza.modelo.php";

require_once "../controladores/personal.controlador.php";
require_once "../modelos/personal.modelo.php";

require_once "../controladores/garita.controlador.php";
require_once "../modelos/garita.modelo.php";

use  PHPMailer\PHPMailer\PHPMailer;
use  PHPMailer\PHPMailer\Exception;

use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Shuchkin\SimpleXLSX;

require_once "../extensiones/TCPDF/tcpdf.php";

require_once '../extensiones/PHPMailer/PHPMailer/src/Exception.php';
require_once '../extensiones/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once '../extensiones/PHPMailer/PHPMailer/src/SMTP.php';

require_once  "../extensiones/PHPMailer/vendor/autoload.php";
class MYPDF extends TCPDF
{



	//Page header

	public function Header()
	{

		// get the current page break margin

		$this->SetAlpha(0.4);

		$bMargin = $this->getBreakMargin();

		// get current auto-page-break mode

		$auto_page_break = $this->AutoPageBreak;

		// disable auto-page-break

		$this->SetAutoPageBreak(false, 0);

		// set bacground image

		$img_file = dirname(__FILE__) . '/../vistas/img/plantilla/FONDO-SOLIDO-1.jpg';

		$this->Image($img_file, 0, 0, 150, 600, '', '', '', false, 200, '', false, false, 0);

		// restore full opacity

		$this->SetAlpha(1);

		// restore auto-page-break status

		$this->SetAutoPageBreak($auto_page_break, $bMargin);

		// set the starting point for the page content

		$this->setPageMark();

		// Logo

		$image_file = '../vistas/img/plantilla/logotipo.png';

		$this->Image($image_file, 10, 5, 35, '', 'PNG', 'https://ransa.ranecu.com', 'M', false, 300, '', false, false, 0, false, false, false);

		// Set font

		$this->SetFont('helvetica', 'B', 15);

		// Title

		$this->Cell(0, 0, 'Orden de Trabajo Estibas', 0, false, 'C', 0, '', 0, false, 'M', 'M');
		$this->SetFont('helvetica', 'B', 9);

		// $this->writeHTMLCell(31, 0, 175, 4, "Código : FCME-0032" , '', 0, 0, true, '', true);
		// $this->writeHTMLCell(20, 0, 180, 8, "Revisión : 01" , '', 0, 0, true, '', true);        

	}

	/*=============================================
=            PIE DE PAGINA DEL PDF            =
=============================================*/
	public function Footer()
	{

		// Position at 15 mm from bottom

		$this->SetY(-15);

		// Set font

		$this->SetFont('helvetica', 'I', 8);

		// Page number

		$this->Cell(0, 10, 'Página ' . $this->getAliasNumPage() . ' de ' . $this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	}
}

class AjaxEstibas extends MYPDF
{

	public $idprovEstiba;
	public $nombreProveedor;
	public $RucEstibas;
	public $ContraEstibas;
	public $CorreoEstibas;

	/*Variables para fecha Programación */
	public $fecha_prog;
	public $idcliente;
	public $idactividad;
	public $idtipo_carga;
	// public $pronguias;
	public $comentarios;
	public $idmovimiento;
	public $valorEstado;
	public $cuadrilla;
	public $nombreresponsable;

	public $_file;


	public $_responsablechecktrans;
	public $_transportista;
	public $_placa;
	public $_obstransporte;
	public $_pptl;
	public $_pa;
	public $_mincom;
	public $_plaga;
	public $_oextranios;
	public $_oquimicos;
	public $_sellos;
	public $imagenes;
	public $_comentItem;
	public $_guias;

	/*===================================================================
	=            DATOS QUE SON INGRESADOS POR LAS CUADRILLAS            =
	===================================================================*/
	public $ttransporte;
	public $ncontenedor;
	public $nguias;
	public $hgarita;
	public $hinicio;
	public $hfin;
	public $nom_estibas;
	public $cant_film;
	public $cant_cod;
	public $cant_fecha;
	public $cant_pallets;
	public $cant_bulto;
	public $observa_estibas;
	public $observa_superv;
	public $conductor;
	public $placa;
	public $origen;
	public $cant_persona;
	public $idlocalizacion;
	public $razonsocial;


	public $motivoelimina;
	public $estado;

	/*==================================================================
	=            FUNCION PARA BOTON CARGAR EXCEL EN PROG. TRANSPORTE            =
	==================================================================*/
	public function ajaxGuardarPlantillaNuevo()
	{
		require_once __DIR__ . '/../extensiones/simplex/SimpleXLSX.php';

		$datosinconrrectos = array();
		$datoscorrectos = array();

		// Validar que el archivo temporal existe antes de moverlo
		if (!isset($this->_file["tmp_name"]) || !is_uploaded_file($this->_file["tmp_name"])) {
			array_push($datosinconrrectos, array("Error" => "Archivo temporal no encontrado o inválido."));
			echo json_encode(array("Correctos" => $datoscorrectos, "Incorrectos" => $datosinconrrectos), true);
			return;
		}

		// Guardar el archivo en una ruta temporal para SimpleXLSX
		$carpetaDestino = __DIR__ . "/../archivos/temp/";
		if (!file_exists($carpetaDestino)) {
			mkdir($carpetaDestino, 0777, true);
		}
		$destino = $carpetaDestino . "cop_" . uniqid() . ".xlsx";
		if (!move_uploaded_file($this->_file["tmp_name"], $destino)) {
			array_push($datosinconrrectos, array("Error" => "No se pudo mover el archivo al destino temporal."));
			echo json_encode(array("Correctos" => $datoscorrectos, "Incorrectos" => $datosinconrrectos), true);
			return;
		}

		// Leer el archivo con SimpleXLSX
		if ($xlsx = SimpleXLSX::parse($destino)) {
			$rows = $xlsx->rows();
			// Encabezado en A3:G3, data desde A4 (índice 3 en array)
			for ($i = 4; $i <= count($rows); $i++) {
				$fila = isset($rows[$i - 1]) ? $rows[$i - 1] : [];
				// A: Responsable, B: Fecha, C: Hora, D: Cliente, E: Guia, F: Placa, G: Transportista, H: Respuesta
				$responsable = isset($fila[0]) ? trim($fila[0]) : "";
				$fecha = isset($fila[1]) ? trim($fila[1]) : "";
				$hora = isset($fila[2]) ? trim($fila[2]) : "";
				$cliente = isset($fila[3]) ? trim($fila[3]) : "";
				$guia = isset($fila[4]) ? trim($fila[4]) : "";
				$placa = isset($fila[5]) ? trim($fila[5]) : "";
				$transportista = isset($fila[6]) ? trim($fila[6]) : "";
				$respuesta = isset($fila[7]) ? strtoupper(trim($fila[7])) : "";

				// Validaciones mínimas
				if ($fecha == "" || $hora == "" || $cliente == "" || $respuesta == "") {
					array_push($datosinconrrectos, array("Fila" => $i, "Error" => "Campos obligatorios vacíos"));
					continue;
				}

				// Unificar fecha y hora usando explode
				$var1 = explode(" ", $fecha);
				$var2 = explode(" ", $hora);
				$fechaParte = isset($var1[0]) ? $var1[0] : "";
				$horaParte = isset($var2[1]) ? $var2[1] : (isset($var2[0]) ? $var2[0] : "");

				// Validar que ambos existan
				if ($fechaParte == "" || $horaParte == "") {
					array_push($datosinconrrectos, array("Fila" => $i, "Error" => "Fecha y/o hora inválida: '$fecha $hora'"));
					continue;
				}

				$fechaunificada = $fechaParte . " " . $horaParte;

				// Buscar cliente por razonsocial y obtener idcliente
				$rptaidcliente = ControladorClientes::ctrmostrarClientes("razonsocial", $cliente);
				$idcliente = $rptaidcliente ? $rptaidcliente["idcliente"] : null;
				if (!$idcliente) {
					array_push($datosinconrrectos, array("D" . $i => $cliente, "Error" => "Cliente no encontrado"));
					continue;
				}

				$estadoMov = ($respuesta == "SI") ? 8 : 1;

				// Insertar movimiento con estado personalizado
				$datos = array(
					"fecha_prog" => $fechaunificada,
					"idcliente" => $idcliente,
					"idactividad" => 2,
					"nguias" => $guia,
					"idtipo_carga" => null,
					"comentarios" => "",
					"idlocalizacion" => $this->idlocalizacion,
					"idciudad" => $_SESSION["ciudad"],
					"cuadrilla" => "NO",
					"idusuario" => $_SESSION["id"],
					"modo" => "operacion",
					"estado" => $estadoMov
				);
				$rpta = ControladorMovRD::ctrRegistrarMovRDConEstado($datos);

				if ($rpta) {
					$okChecklist = false;
					if ($respuesta == "SI") {
						$datoscheck = array(
							"idmov_recep_desp"  => $rpta,
							"realizadopor"      => strtoupper($responsable),
							"transportista"     => strtoupper($transportista),
							"placa"             => strtoupper($placa),
							"observaciones"     => "",
							"ppt"               => "SI",
							"obsppt"            => "",
							"pa"                => "SI",
							"obspa"             => "",
							"mi"                => "SI",
							"obsmi"             => "",
							"plaga"             => "SI",
							"obsplaga"          => "",
							"oe"                => "SI",
							"obsoe"             => "",
							"oquimicos"         => "SI",
							"obsoquimicos"      => "",
							"sellos"            => "SI",
							"obssellos"         => "",
							"imagenes"          => null
						);
						$rptacheck = ControladorCheckTransporte::ctrInsertarCheckCompleto($datoscheck);
						$okChecklist = ($rptacheck === "ok");
					} else {
						$datoscheck = array(
							"idmovimiento" => $rpta,
							"transportista" => strtoupper($transportista),
							"placa" => strtoupper($placa)
						);
						$rptacheck = ControladorCheckTransporte::ctrInsertarCheckTransporte($datoscheck);
						$okChecklist = ($rptacheck === "ok");
					}

					if ($okChecklist) {
						array_push($datoscorrectos, array("Fila" => $i, "Cliente" => $cliente, "Respuesta" => $respuesta));
					} else {
						array_push($datosinconrrectos, array("Fila" => $i, "Error" => "No se pudo registrar checklist"));
					}
				} else {
					array_push($datosinconrrectos, array("Fila" => $i, "Error" => "No se pudo registrar movimiento"));
				}
			}
		} else {
			array_push($datosinconrrectos, array("Error" => "Error al leer el archivo Excel: " . SimpleXLSX::parseError()));
		}

		if (file_exists($destino)) unlink($destino);
		echo json_encode(array("Correctos" => $datoscorrectos, "Incorrectos" => $datosinconrrectos), true);
	}
	/*==================================================================
	=            FUNCION PARA REGISTRAR PROVEEDOR DE ESTIBA            =
	==================================================================*/
	public function ajaxRegistrarEstibas()
	{
		/*=========================================================
		=            ENCRIPTAMOS LA CONTRASEÑA DEFAULT            =
		=========================================================*/
		$passworEncrip = password_hash($this->ContraEstibas, PASSWORD_BCRYPT);



		$datos = array(
			"nombre_proveedor" => strtoupper($this->nombreProveedor),
			"RucEstibas" => $this->RucEstibas,
			"ContraEstibas" => $passworEncrip,
			"CorreoEstibas" => $this->CorreoEstibas
		);

		$rpta = ControladorEstibas::ctrRegistrarEstibas($datos);
		if ($rpta == "ok") {
			/*======================================================================================
			=            AL REGISTRAR UN NUEVO USUARIO SE PROCEDE A NOTIFICAR VIA EMAIL            =
			======================================================================================*/
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->CharSet = 'UTF-8';
			$mail->SMTPSecure = 'STARTTLS';
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.office365.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
			$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
			$mail->Password = "Didacta_123"; // Contraseña
			$mail->Port = 587; // Puerto a utilizar
			$mail->From = "proyectosecuador@ransa.net"; // Desde donde enviamos (Para mostrar)
			$mail->FromName = "NOVEDADES RANSA";
			// $mail->addEmbeddedImage("../vistas/img/iconos/Mesa-de-trabajo-53.png","montacarga","Mesa-de-trabajo-53.png");	
			$mail->isHTML(true);
			$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png", "logo_ransa", "logotipo.png");
			$body = 'Estimad@s ' . strtoupper($this->nombreProveedor) . ',<br><br>Se notifica la creación del usuario, se comparte los datos para ingresar al sistema.<br><br><strong>Usuario: </strong>' . $this->CorreoEstibas . '<br><strong>Contraseña: </strong>' . $this->ContraEstibas . '<br><strong>Dirección URL (ingreso portal): </strong> https://ransa.ranecu.com<br><strong>Dirección URL (registro trabajo nuevo): </strong>https://ransa.ranecu.com/estibas<br><br>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
<span style="color:#009B3A;font-family:Verdana,sans-serif;">Ecuador | Km 22, vía Daule –Guayaquil </span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
<span lang="ES" style="font-size:10.0pt; font-family:Ebrima; color:#009B3A">Pbx: (593) 0997410389 | Cel: (593) 0996047252</span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#F29104;font-family:UniviaPro-Bold;"><a href="http://www.ransa.net/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="0"><span style="color:#F29104;">www.ransa.net</span></a></span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">A continuación el enlace en el que puedes registrar las oportunidades de mejora detectadas en nuestros procesos.</span><span style="color:#009A3F;font-size:10.5pt;font-family:Verdana,sans-serif;">
</span><b><span style="color:#00B050;font-family:Verdana,sans-serif;"><a href="https://nam02.safelinks.protection.outlook.com/?url=https%3A%2F%2Fforms.office.com%2FPages%2FResponsePage.aspx%3Fid%3DQvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u&amp;data=04%7C01%7CDBorborP%40ransa.net%7C433c12c9c3b941e1da0f08d8ada0b382%7C5726fb42842645779964f13a62ad5eb9%7C0%7C0%7C637450253002340063%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&amp;sdata=x7bsp0cvihFHT1o1BUzMCD8p90XDJhHQYPJnkA1%2FhO4%3D&amp;reserved=0" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="1">Ingresa
Aquí</a></span></b><b><span style="color:#002060;font-size:10.5pt;font-family:Verdana,sans-serif;"></span></b></p>
';
			$mail->setFrom("proyectosecuador@ransa.net", 'NOVEDAD RANSA');
			$mail->addAddress($this->CorreoEstibas);
			$mail->Subject = 'CREACIÓN DE USUARIO';
			$mail->Body    = $body;
			$envios = $mail->send();
			if (isset($envios)) {
				echo 1;
			} else {
				echo 2;
			}
		} else {
			echo 2;
		}
	}
	/*=============================================================
	=            PARA CONSULTAR EL PROVEEDOR DE ESTIBA            =
	=============================================================*/
	public function ajaxConsultEstibas()
	{
		$idprovEstiba = $this->idprovEstiba;

		$rpta = ControladorEstibas::ctrConsultarEstibas($idprovEstiba, "idproveedor_estiba");

		echo json_encode($rpta, true);
	}
	/*===========================================================
	=            PARA EDITAR EL PROVEEDOR DE ESTIBAS            =
	===========================================================*/
	public function ajaxEditarEstibas()
	{
		$datos = array(
			"nombre_prov" => strtoupper($this->nombreProveedor),
			"idprovestiba" => $this->idprovEstiba
		);

		$rpta = ControladorEstibas::ctrEditarEstibas($datos, "idproveedor_estiba");

		echo $rpta;
	}

	/*========================================================
	=            ELIMINAR EL PROVEEDOR DE ESTIBAS            =
	========================================================*/
	public function ajaxEliminarEstibas()
	{
		$datos = array(
			"idproveedor_estiba" => $this->idprovEstiba,
			"estado" => 0
		);
		$rpta = ControladorEstibas::ctrEliminarEstibas($datos, "idproveedor_estiba");

		echo $rpta;
	}

	/*=======================================================================
	=            PROGRAMAR EL MOVIMIENTO DE RECEPCIÓN O DESPACHO            =
	=======================================================================*/
	public function ajaxProgMovimiento()
	{
		$datos = array(
			"fecha_prog" => $this->fecha_prog,
			"idcliente" => $this->idcliente,
			"idactividad" => $this->idactividad,
			"nguias" => $nguias = $this->nguias != "" ? strtoupper($this->nguias) : null,
			"idtipo_carga" => $this->idtipo_carga,
			"comentarios" => preg_replace('[\n|\r|\n\r]', '', nl2br(strtoupper($this->comentarios))),
			"idlocalizacion" => $this->idlocalizacion,
			"idciudad" => $_SESSION["ciudad"],
			"cuadrilla" =>  $valor = $this->cuadrilla == "true" ? "SI" : "NO",
			"idusuario" => $_SESSION["id"],
			"modo" => "operacion"
		);
		$rpta = ControladorMovRD::ctrRegistrarMovRD($datos);
		if ($rpta) {
			/*=====================================================================================
			=            ALMACENAMOS EL DATOS INCIALES DE CONDUCTOR Y PLACA CHECK LIST            =
			=====================================================================================*/
			$datoscheck = array(
				"transportista" => $conductor = $this->conductor != "" ? strtoupper($this->conductor) : null,
				"placa" => $placa = $this->placa != "" ? strtoupper($this->placa) : null,
				"idmovimiento" => $rpta
			);
			$rptacheck = ControladorCheckTransporte::ctrInsertarCheckTransporte($datoscheck);
			if ($rptacheck == "ok") {
				echo 1;
			}
		}
	}
	/*=======================================================
	=            ASIGNAR CUADRILLA AL MOVIMIENTO            =
	=======================================================*/
	public function ajaxAsignarCuadrilla()
	{
		$datos = array(
			"asignarcuadrillaid" => $this->idprovEstiba,
			"idmov" => $this->idmovimiento
		);


		$rpta = ControladorMovRD::ctrEditarMovRD($datos, "idmov_recep_desp");
		echo $rpta;
	}
	/*==============================================================================
	=            ALMACENAR LAS IMAGENES DEL MOVIMIENTO RECEP - DESPACHO            =
	==============================================================================*/
	public function ajaxImgMov()
	{
		/*===============================================
		=            CONSULTAMOS EL CLIENTE             =
		===============================================*/
		$rpta = ControladorMovRD::ctrConsultarMovRD($this->idmovimiento, "idmov_recep_desp");

		$rptacliente = ControladorClientes::ctrmostrarClientes("idcliente", $rpta["idcliente"]);


		$rpta = ControladorMovRD::ctrGuardarImagenesServidor($this->_file, $rptacliente["razonsocial"]);

		echo $rpta;
	}
	/*==================================================================
	=            REGISTRO DE CHECK LIST EN LA BASE DE DATOS            =
	==================================================================*/
	public function ajaxRegistoCheckTransport()
	{
		$comentarios = json_decode($this->_comentItem, true);
		/*=====  CONVERTIMOS EL ARRAY MULTIDIMENSIONAL EN UN ARRAY SIMPLE  ======*/
		$chackobs = array();
		foreach ($comentarios as $keyob => $valueob) {
			foreach ($valueob as $keysobs => $valuesobs) {
				if (!empty($valuesobs)) {
					$chackobs[$keysobs] = strtoupper($valuesobs);
				}
			}
		}
		/*==================================================================
		=            GENERAMOS EL CODIGO UNICO PARA LA CUADRLLA            =
		==================================================================*/

		$datos = array(
			"responsablechecktrans" => strtoupper($this->_responsablechecktrans),
			"transportista" => strtoupper($this->_transportista),
			"placa" => strtoupper($this->_placa),
			"obstransporte" => strtoupper($this->_obstransporte),
			"pptl" => strtoupper($this->_pptl),
			"obspptl" => isset($chackobs["obspptl"]) ? $chackobs["obspptl"] : null,
			"pa" => strtoupper($this->_pa),
			"obspa" => isset($chackobs["obspa"]) ? $chackobs["obspa"] : null,
			"mincom" => strtoupper($this->_mincom),
			"obsmincom" => isset($chackobs["obsmincom"]) ? $chackobs["obsmincom"] : null,
			"plaga" => strtoupper($this->_plaga),
			"obsplaga" => isset($chackobs["obsplaga"]) ? $chackobs["obsplaga"] : null,
			"oextranios" => strtoupper($this->_oextranios),
			"obsoextranios" => isset($chackobs["obsoextranios"]) ? $chackobs["obsoextranios"] : null,
			"oquimicos" => strtoupper($this->_oquimicos),
			"sellos" => strtoupper($this->_sellos),
			"obsoquimicos" => isset($chackobs["obsoquimicos"]) ? $chackobs["obsoquimicos"] : null,
			"obssellos" => isset($chackobs["obssellos"]) ? $chackobs["obssellos"] : null,
			"idmovimiento" => $this->idmovimiento,
			"imagenes" => $valorimgaen = $this->imagenes == "null" ? null : $this->imagenes
		);


		$rpta = ControladorCheckTransporte::ctrActualizarCheckTransporte("checklist", $datos);
		$codigo = null;

		$datos = array(
			"nguias" => $this->_guias,
			"idmovimiento" => $this->idmovimiento
		);

		//   print_r($datos);
		//   die(1);

		$rpta = ControladorMovRD::ctrEditarMovRD($datos, "idmov_recep_desp");

		if ($rpta == "ok") {
			/*=========================================================
				=            CONSULTAMOS SI NECESITA CUADRILLA            =
				=========================================================*/
			$rptaConsulta = ControladorMovRD::ctrConsultarMovRD($this->idmovimiento, "idmov_recep_desp");
			$estado = 0;
			if ($rptaConsulta["cuadrilla"] == "NO") {
				/*============================================================
					=            SI NO NECESITA SE TERMINA EL PROCESO            =
					============================================================*/
				$estado = 8;
				$codigo = null;
			} else {
				/*==================================================================================
					=            SI NECESITA CUADRILLA SE ASIGNA CODIGO PARA LAS CUADRILLAS            =
					==================================================================================*/
				function uniqidReal($lenght = 4)
				{
					// uniqid gives 13 chars, but you could adjust it to your needs.
					if (function_exists("random_bytes")) {
						$bytes = random_bytes(ceil($lenght / 2));
					} elseif (function_exists("openssl_random_pseudo_bytes")) {
						$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
					} else {
						throw new Exception("no cryptographically secure random function available");
					}
					return substr(bin2hex($bytes), 0, $lenght);
				}
				$estado = 4;
				$codigo = uniqidReal(6);
			}
			$datos = array(
				"idmov" => $this->idmovimiento,
				"valor1" => $estado,
				"codigo_generado" => $codigo
			);

			$rptaMov = ControladorMovRD::ctrEditarMovRD($datos, "idmov_recep_desp");
			if ($rptaMov == "ok") {
				echo 1;
			}
		} else {
			echo 2;
		}
	}
	/*================================================
	=            ACTUALIZAR ESTADO DE MOV            =
	================================================*/
	public function UpdateMovInicio()
	{
		// $this->nombreresponsable;
		/*===================================================================================
		=            CONSULTAMOS SI EXISTE UN CHECK LIST REALIZADO ANTERIORMENTE            =
		===================================================================================*/
		$rptaCheckTrans = ControladorCheckTransporte::ctrConsultarCheckTransporte("idmov_recep_desp", $this->idmovimiento);
		// var_dump($this->idmovimiento);
		$rptaMov = ControladorMovRD::ctrConsultarMovRD($this->idmovimiento, "idmov_recep_desp");

		function uniqidReal($lenght = 4)
		{
			// uniqid gives 13 chars, but you could adjust it to your needs.
			if (function_exists("random_bytes")) {
				$bytes = random_bytes(ceil($lenght / 2));
			} elseif (function_exists("openssl_random_pseudo_bytes")) {
				$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
			} else {
				throw new Exception("no cryptographically secure random function available");
			}
			return substr(bin2hex($bytes), 0, $lenght);
		}
		// var_dump($rptaMov);
		if ($rptaMov["codigo_generado"] != null) {
			echo "Ya se ha generado el codigo";
		} else {
			if ($rptaCheckTrans) {
				if (($this->valorEstado == 3) && ($rptaMov["responactividad"] == null || $rptaCheckTrans["ppt"] == null || $rptaCheckTrans["pa"] == null || $rptaCheckTrans["mi"] == null || $rptaCheckTrans["plaga"] == null || $rptaCheckTrans["oe"] == null || $rptaCheckTrans["oquimicos"] == null)) {

					$datos = array(
						"idmov" => $this->idmovimiento,
						"valor1" => $this->valorEstado
					);
					$rpta = ControladorMovRD::ctrEditarMovRD($datos, "idmov_recep_desp");
					echo $rpta;
					// echo "FCheckList";
				} else if ($this->valorEstado == 4 && $rptaMov["responactividad"] == null) {
					$codigo = uniqidReal(6);
					$datos = array(
						"idmov" => $this->idmovimiento,
						"valor1" => 4,
						"codigo_generado" => $codigo,
						"nombrerespon" => $this->nombreresponsable
					);
					$rpta = ControladorMovRD::ctrEditarMovRD($datos, "idmov_recep_desp");
					echo $rpta;
				} else if ($this->valorEstado == 8 && $rptaMov["responactividad"] == null) {
					$datos = array(
						"idmov" => $this->idmovimiento,
						"estado8" => $this->valorEstado,
						"nombrerespon" => $this->nombreresponsable
					);
					$rpta = ControladorMovRD::ctrEditarMovRD($datos, "idmov_recep_desp");
					echo $rpta;
				} else {
					echo "Check List Realizado";
				}
			} else {
				if ($this->valorEstado == 4) {

					$codigo = uniqidReal(6);
					$datos = array(
						"idmov" => $this->idmovimiento,
						"valor1" => 4,
						"codigo_generado" => $codigo,
						"nombrerespon" => $this->nombreresponsable
					);
				} else if ($this->valorEstado == 8) {
					$datos = array(
						"idmov" => $this->idmovimiento,
						"estado8" => $this->valorEstado,
						"nombrerespon" => $this->nombreresponsable
					);
				} else if ($this->valorEstado == 3) {
					$datos = array(
						"idmov" => $this->idmovimiento,
						"valor1" => $this->valorEstado
					);
				}


				$rpta = ControladorMovRD::ctrEditarMovRD($datos, "idmov_recep_desp");
				echo $rpta;
			}
		}






		// if ($rptaCheckTrans) {
		// 	if ($rptaCheckTrans["realizadopor"] == null || $rptaCheckTrans["ppt"] == null || $rptaCheckTrans["pa"] == null || $rptaCheckTrans["mi"] == null || $rptaCheckTrans["plaga"] == null || $rptaCheckTrans["oe"] == null || $rptaCheckTrans["oquimicos"] == null){

		// 		$datos = array("idmov" => $this->idmovimiento,
		// 						"valor1" => $this->valorEstado);
		// 		$rpta = ControladorMovRD::ctrEditarMovRD($datos,"idmov_recep_desp");
		// 		echo $rpta;
		// 		// echo "FCheckList";
		// 	}else{
		// 		echo "Check List Realizado";	
		// 	}

		// }else{
		// 	if ($this->valorEstado == 4) {

		// 		$codigo = uniqidReal(6);
		// 			$datos = array("idmov" => $this->idmovimiento,
		// 							"valor1" => 4,
		// 							"codigo_generado" => $codigo);
		// 	}else{
		// 		$datos = array("idmov" => $this->idmovimiento,
		// 						"valor1" => $this->valorEstado);			
		// 	}


		// 	$rpta = ControladorMovRD::ctrEditarMovRD($datos,"idmov_recep_desp");
		// 	echo $rpta;
		// }
	}
	/*============================================================
	=            ALMACENAMIENTO TEMPORAL DE LA IMAGEN            =
	============================================================*/
	public function ajaxAlmTemp()
	{
		if (isset($this->_file["tmp_name"])) {
			$directorio = "../archivos/temp/";
			$nombre = uniqid();
			$rutimg = $directorio . $nombre . ".png";
			move_uploaded_file($this->_file["tmp_name"], $rutimg);
			echo $rutimg;
		}
	}
	/*===================================================================
	=            ELIMINAR LA IMAGEN ALMACENADA TEMPORALMENTE            =
	===================================================================*/
	public function ajaxEliminarImgTemp()
	{
		$ruta = "../" . $this->_file;
		if (is_file($ruta)) {
			$result = unlink($ruta);

			echo $result;
		}
	}
	/*=================================================================================================
	=            ACTUALIZAR LA UBICACION DEL ARCHIVO TEMPORAL A LA CARPETA QUE CORRESPONDE            =
	=================================================================================================*/
	public function ajaxUpdateFileTemp()
	{
		/*===============================================
		=            CONSULTAMOS EL CLIENTE             =
		===============================================*/
		$rpta = ControladorMovRD::ctrConsultarMovRD($this->idmovimiento, "idmov_recep_desp");

		$rptacliente = ControladorClientes::ctrmostrarClientes("idcliente", $rpta["idcliente"]);

		$rutaTemp = "../" . $this->_file;
		$archivo = substr($this->_file, 14);
		$directorio = "../archivos/Check Transporte/" . $rptacliente["razonsocial"] . "/";

		if (!file_exists($directorio)) {
			mkdir($directorio, 0777);
		}
		$nuevaruta = $directorio . $archivo;
		$result = rename($rutaTemp, $nuevaruta); // cambia el directorio del archivo temporal
		if ($result) {
			echo $nuevaruta;
		} else {
			echo 2;
		}
	}
	/*===============================================
	=            INGRESAR DATOS ESTIBAS             =
	===============================================*/
	public function ajaxIngresarDatEstibas()
	{
		$datos = array(
			"idtipo_transporte" => $this->ttransporte,
			"ncontenedor" => strtoupper($this->ncontenedor),
			"nguias" => $this->nguias,
			"h_garita" => $this->hgarita,
			"h_inicio" => $this->hinicio,
			"h_fin" => $this->hfin,
			"nombre_estibas" => strtoupper($this->nom_estibas),
			"cant_film" => $this->cant_film,
			"cant_codigo" => $this->cant_cod,
			"cant_fecha" => $this->cant_fecha,
			"cant_pallets" => $this->cant_pallets,
			"cant_bultos" => $this->cant_bulto,
			"observaciones_estibas" => strtoupper($this->observa_estibas),
			"fecha_dat_estiba" => date("Y-m-d h:i:s")
		);

		$item = array("idmov_recep_desp" => $this->idmovimiento);

		$rpta = ControladorMovRD::ctrEditarMovRDEst($datos, $item);

		if ($rpta) {
			/*==================================================================
			=            CONSULTAMOS DATOS GENERALES DEL MOVIMIENTO            =
			===================================================================*/
			$rptamovi = ControladorMovRD::ctrConsultarMovRD($this->idmovimiento, "idmov_recep_desp");
			/*=====================================================================
			=            CREAMOS EL ARCHIVO PDF PARA ENVIAR POR CORREO            =
			=====================================================================*/
			if (isset($rptamovi)) {
				$pdf = new AjaxEstibas(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

				// set document information

				$pdf->SetCreator(PDF_CREATOR);

				$pdf->SetAuthor('Steven Montenegro');

				$pdf->SetTitle('Orden de Trabajo ' . date('d-m-Y', strtotime($rptamovi["fecha_programada"])));

				$pdf->SetSubject('Ordenes de Trabajo');

				$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
				// set default monospaced font

				$pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);



				// set margins

				$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);

				$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);

				$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);



				// set auto page breaks

				$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);



				// set image scale factor

				$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);



				// set some language-dependent strings (optional)

				if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {

					require_once(dirname(__FILE__) . '/lang/eng.php');

					$pdf->setLanguageArray($l);
				}
				$pdf->SetFont('helvetica', '', 6);
				/*==============================================
				=            CONSULTAMOS EL CLIENTE            =
				==============================================*/
				$rptaCliente = ControladorClientes::ctrmostrarClientes("idcliente", $rptamovi["idcliente"]);
				/*================================================
				=            CONSULTAMOS LA ACTIVIDAD            =
				================================================*/
				$rptaActividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba", $rptamovi["idactividad"]);
				/*===================================================
				=            CONSULTA TIPO DE TRANSPORTE            =
				===================================================*/
				$rptaTTranspporte = ControladorTTransporte::ctrConsultarTTransporte("idtipo_transporte", $rptamovi["idtipo_transporte"]);
				// add a page

				$pdf->AddPage();

				$html = '
				<style>

				.cabecera{

					background-color: #dad414;

				}

				</style>
				<table cellpadding="2" cellspacing="0" border="0.3" align="center">
				   
					<tr>
					<td class="cabecera"><strong> Codigo Generado: </strong></td>
					<td colspan="7">' . $rptamovi["codigo_generado"] . '</td>
					</tr>
					<tr>
						<td class="cabecera"><strong> Fecha: </strong></td>
						<td colspan="7">' . date("d-m-Y", strtotime($rptamovi["fecha_programada"])) . '</td>
					</tr>
					<tr>
						<td class="cabecera"><strong> Cliente: </strong></td>
						<td colspan="7">' . $rptaCliente["razonsocial"] . '</td>
					</tr>
					<tr>
						<td class="cabecera"><strong>Servicio: </strong></td>
						<td colspan="7">' . $rptaActividad["descripcion"] . '</td>
					</tr>
					<tr>
						<td class="cabecera" colspan="2"><strong>Tipo de Transporte: </strong></td>
						<td colspan="6">' . $rptaTTranspporte["descripcion"] . '</td>
					</tr>
					<tr>
						<td class="cabecera"><strong>N° Contenedor: </strong></td>
						<td colspan="3">' . $rptamovi["ncontenedor"] . '</td>
						<td class="cabecera"><strong>Guias: </strong></td>
						<td colspan="3">' . $rptamovi["nguias"] . '</td>
					</tr>
					<tr>
						<td class="cabecera"><strong>Hora Garita: </strong></td>
						<td colspan="2">' . $rptamovi["h_garita"] . '</td>
						<td class="cabecera"><strong>Hora Inicio: </strong></td>
						<td colspan="2">' . $rptamovi["h_inicio"] . '</td>
						<td class="cabecera"><strong>Hora Fin: </strong></td>
						<td>' . $rptamovi["h_fin"] . '</td>
					</tr>
					<tr>
						<td class="cabecera"><strong>Nombre Estibas: </strong></td>
						<td colspan="7">' . $rptamovi["nombre_estibas"] . '</td>
					</tr>
					<tr>
						<td class="cabecera"><strong>Cant. Cod: </strong></td>
						<td>' . $rptamovi["cant_codigo"] . '</td>
						<td class="cabecera"><strong>Cant. Fecha: </strong></td>
						<td>' . $rptamovi["cant_fecha"] . '</td>
						<td class="cabecera"><strong>Cant. Pallet: </strong></td>
						<td>' . $rptamovi["cant_pallets"] . '</td>
						<td class="cabecera"><strong>Cant. Bultos</strong></td>
						<td>' . $rptamovi["cant_bultos"] . '</td>
					</tr>
					<tr>
						<td class="cabecera" colspan="2"><strong>Observaciones: </strong></td>
						<td colspan="6">' . $rptamovi["observaciones_estibas"] . '</td>
					</tr>
					
				</table>';

				$pdf->writeHTML($html, true, false, true, false, '');

				//Close and output PDF document

				$pdf->Output(__DIR__ . "/" . $rptamovi["codigo_generado"] . ".pdf");


				/*=====  End of CREAMOS EL ARCHIVO PDF PARA ENVIAR POR CORREO  ======*/

				/*================================================
			=            CONSULTAMOS EL PROVEEDOR            =
			================================================*/
				$rptaProveedor = ControladorEstibas::ctrConsultarEstibas($rptamovi["idproveedor_estiba"], "idproveedor_estiba");




				/*===========================================================
			=            NOTIFICACION POR CORREO ELECTRONICO            =
			===========================================================*/
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->CharSet = 'UTF-8';
				$mail->SMTPSecure = 'STARTTLS';
				$mail->SMTPAuth = true;
				$mail->Host = "smtp.office365.com"; // SMTP a utilizar. Por ej. smtp.elserver.com
				$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
				$mail->Password = "Didacta_123"; // Contraseña
				$mail->Port = 587; // Puerto a utilizar
				$mail->From = "proyectosecuador@ransa.net"; // Desde donde enviamos (Para mostrar)
				$mail->FromName = "SISTEMA RANSA";
				$mail->isHTML(true);
				$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png", "logo_ransa", "logotipo.png");
				$mail->addEmbeddedImage("../vistas/img/plantilla/qr_img.png", "codqr", "qr_img.png");

				$body = '<div class="_2Qk4AbDuWwkuLB005ds2jm QMubUjbS-BOly_BTHEZj7 allowTextSelection"><div><style>

 			@font-face
 				{font-family:"Cambria Math"}
 			@font-face
 				{font-family:Calibri}
 			@font-face
 				{font-family:Verdana}
 			@font-face
 				{font-family:Ebrima}
 			@font-face
 				{font-family:UniviaPro-Bold}
 			@font-face
 				{font-family:Cambria}
 			.rps_e28c p.x_MsoNormal, .rps_e28c li.x_MsoNormal, .rps_e28c div.x_MsoNormal
 				{margin:0cm;
 				font-size:11.0pt;
 				font-family:"Calibri",sans-serif}
 			.rps_e28c span.x_EstiloCorreo17
 				{font-family:"Calibri",sans-serif;
 				color:windowtext}
 			.rps_e28c .x_MsoChpDefault
 				{font-family:"Calibri",sans-serif}
 			@page WordSection1
 				{margin:70.85pt 3.0cm 70.85pt 3.0cm}
 			.rps_e28c div.x_WordSection1
 				{}
				
 			</style>
 			<div class="rps_e28c">
 			<div lang="ES-EC" link="#0563C1" vlink="#954F72" style="word-wrap:break-word">
 			<div class="x_WordSection1">
 			<p class="x_MsoNormal">Estimad@s,</p>
 			<p class="x_MsoNormal">&nbsp;</p>
 			<p class="x_MsoNormal">Se notifica que el proveedor ' . $rptaProveedor["nombre_proveedor"] . ' acaba de registrar la información (del / la) ' . $rptaActividad["descripcion"] . ' según código generado ' . $rptamovi["codigo_generado"] . ', se adjunta archivo (.pdf) de la información ingresada.</p>
 			<p class="x_MsoNormal">&nbsp;</p>
 			<p class="x_MsoNormal">Ingresar al Sistema para aprobar o modificar la información ingresada.</p>
 			<p class="x_MsoNormal" style="text-autospace:none">
 			<span style="font-family:&quot;Verdana&quot;,sans-serif; color:#009B3A">&nbsp;</span></p>
 			<p class="x_MsoNormal" style="text-autospace:none">
 			<span style="font-family:&quot;Verdana&quot;,sans-serif; color:#009B3A">Ecuador | Km 22, vía Daule-Guayaquil </span></p>
 			<p class="x_MsoNormal"><span lang="ES" style="font-size:10.0pt; font-family:Ebrima; color:#009B3A">Pbx: (593) 0997410389 | Cel: (593) 0996047252</span></p>
 			<p class="x_MsoNormal"><span style="font-family:UniviaPro-Bold; color:#F29104"><a href="https://nam02.safelinks.protection.outlook.com/?url=http%3A%2F%2Fwww.ransa.net%2F&amp;data=04%7C01%7CDBorborP%40ransa.net%7Cc9adf8cf18494fbd858708d93bd8e4c7%7C5726fb42842645779964f13a62ad5eb9%7C0%7C0%7C637606625010617897%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&amp;sdata=p5us0PlGtqQNeWail%2BT0pleVO6I4l%2BouKLKPCkBNTb4%3D&amp;reserved=0" target="_blank" rel="noopener noreferrer" data-auth="Verified" originalsrc="http://www.ransa.net/" shash="D7YGhUnU7PUQrJo8gIk/Xq3MoUT7B5fnhID7ZwovMOnF6FjTa6zsJBT7qDPMhLAjHrc2bBMMN3H1uVmytVXFeBpC2zgUuq7K15AbpVwqocFrGsS44q6uxHP0Dg6YyN6grdZ6IV2dEH7os7I4dAbG/GQZssRQK8HnsX8Qog0WCPk=" title="Dirección URL original: http://www.ransa.net/. Haga clic o pulse si confía en este vínculo." data-linkindex="0"><span style="color:#F29104">www.ransa.net</span></a></span></p><p class="x_MsoNormal"><span style="font-size:12.0pt; font-family:&quot;Times New Roman&quot;,serif; color:#1F497D">&nbsp;</span></p>
 			<p class="x_MsoNormal"><span style="color:#1F497D"><img data-imagetype="AttachmentByCid" originalsrc="cid:image001.png@01D76D96.6AB44500" data-custom="AAMkADI1ODc2Y2Y4LTQ4OWUtNDBlMC05M2QyLTE0YmE4OGE1Yjg5NQBGAAAAAAB8fxCTVfimTqU5JxILT7hJBwCggvNAEU%2FHR6ZNfvjifZYxAAAAAAEMAACggvNAEU%2FHR6ZNfvjifZYxAAHXa195AAABEgAQAClTK9nlMZBNtc4XOUQQ6OA%3D" naturalheight="0" naturalwidth="0" src="cid:logo_ransa" border="0" width="183" height="47" id="x_Imagen_x0020_1" alt="Descripción: cid:image001.png@01D408BE.6693FCD0" style="width: 1.9062in; height: 0.4895in; cursor: pointer;" crossorigin="use-credentials"></span><span style="font-family:&quot;Cambria&quot;,serif; color:#1F497D"></span></p>
 			<p class="x_MsoNormal"><span style="font-size:10.0pt; font-family:&quot;Verdana&quot;,sans-serif; color:#009A3F">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
 			<p class="x_MsoNormal"><span style="font-size:10.0pt; font-family:&quot;Verdana&quot;,sans-serif; color:#009A3F">A continuación el enlace en el que puedes registrar las oportunidades de mejora detectadas en nuestros procesos.</span><span style="font-size:10.5pt; font-family:&quot;Verdana&quot;,sans-serif; color:#009A3F"> </span><b><span style="font-family:&quot;Verdana&quot;,sans-serif; color:#00B050"><a href="https://nam02.safelinks.protection.outlook.com/?url=https%3A%2F%2Fforms.office.com%2FPages%2FResponsePage.aspx%3Fid%3DQvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u&amp;data=04%7C01%7CDBorborP%40ransa.net%7Cc9adf8cf18494fbd858708d93bd8e4c7%7C5726fb42842645779964f13a62ad5eb9%7C0%7C0%7C637606625010627894%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&amp;sdata=F3QUvSZ7KiZxYLXisXwFLf68ZVZd4xuBOumPsFtEFW8%3D&amp;reserved=0" target="_blank" rel="noopener noreferrer" data-auth="Verified" originalsrc="https://forms.office.com/Pages/ResponsePage.aspx?id=QvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u" shash="qW9/6vArHYC9JKMkUfyWd/x0dS5An8MYKvsZdE7sicaoqDEKgPrYP/cBjU+gScuvJP5RcLZesC5wPWi8ZY1LpBemuW6inogpRHG6trz3jEwanoDlNdhlQfktQBfvy7Yp2HdaXj6JH6Fk2d/tyIE4j8yO62/XlS8DklGYS9eHFn0=" title="Dirección URL original: https://forms.office.com/Pages/ResponsePage.aspx?id=QvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u. Haga clic o pulse si confía en este vínculo." data-linkindex="1"><span style="color:#0563C1">Ingresa Aquí</span></a></span></b><b><span style="font-size:10.5pt; font-family:&quot;Verdana&quot;,sans-serif; color:#002060"></span></b></p>
 			<p class="x_MsoNormal"><span style="font-size:10.0pt; font-family:&quot;Arial&quot;,sans-serif; color:#002060">&nbsp;</span></p><p class="x_MsoNormal"><span style="color:#002060"><img data-imagetype="AttachmentByCid" originalsrc="cid:image002.jpg@01D76D96.6AB44500" data-custom="AAMkADI1ODc2Y2Y4LTQ4OWUtNDBlMC05M2QyLTE0YmE4OGE1Yjg5NQBGAAAAAAB8fxCTVfimTqU5JxILT7hJBwCggvNAEU%2FHR6ZNfvjifZYxAAAAAAEMAACggvNAEU%2FHR6ZNfvjifZYxAAHXa195AAABEgAQABMiFz0X6h9Kt6%2FIzZ6A8kk%3D" naturalheight="0" naturalwidth="0" src="cid:codqr" border="0" width="126" height="127" id="x_Imagen_x0020_5" style="width: 1.3125in; height: 1.3229in; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#002060"></span></p><p class="x_MsoNormal">&nbsp;</p></div></div></div></div></div>';

				// $mail->AddAttachment(__DIR__."/".$rptamovi["codigo_generado"].".pdf"); //adjunto de correo

				$mail->setFrom("proyectosecuador@ransa.net", 'NOTIFICACION ESTIBAS');



				/*========================================================================
			=            COMPROBAMOS A QUE TABLA PERTENECE EL USUARIO            =
			========================================================================*/
				// if ($this->razonsocial == "NEGOCIOS Y LOGISTICA NEGOLOGIC SA") {
				// 	$tabla = "usuariosclientes";
				// }else{
				// 	$tabla = "usuariosransa";
				// }
				/*=============================================================
			=  CONSULTAMOS EL USUARIO QUE SE PASARÁ CORREO DE NOTIFICACIÓN =
			===============================================================*/
				if ($this->razonsocial == "RANSA") {

					$rptaUser = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla, "id", $rptamovi["idusuario"]);
					if ($rptaUser["estado"] != 0) {
						$mail->addAddress($rptaUser["email"]);     // Add a recipient    
					}
				} else {
					$datosuser = array(
						"cuentas" => "%" . $this->razonsocial . "%",
						"perfil" => "OPERATIVO",
						"idciudad" => $_SESSION["ciudad"]
					);
					$rptaUser = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla, "cuentas", $datosuser);
					for ($i = 0; $i < count($rptaUser); $i++) {
						if ($rptaUser[$i]["estado"] != 0) {
							$mail->addAddress($rptaUser[$i]["email"]);     // Add a recipient    
						}
					}
				}

				$mail->addAddress(["proyectosecuador@ransa.net", $mail]);     // Add a recipient
				$mail->Subject = 'DATOS INGRESADOS CUADRILLA [' . $rptaProveedor["nombre_proveedor"] . ']';
				$mail->Body    = $body;
				//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

				$envios = $mail->send();
				// $envios = "SDAS";
				if (isset($envios)) {
					// unset($pdf);
					// unlink(__DIR__."/".$rptamovi["codigo_generado"].".pdf");
					echo "ok";
				} else {
					echo 2;
				}
			}
		}

		// echo $rpta;

	}
	/*===========================================================================
	=            CONSULTA PARA CONFIRMAR DATOS DE ESTIBAS INGRESADOS            =
	===========================================================================*/
	public function ConsultDatEstSup()
	{
		$rpta = ControladorMovRD::ctrConsultarMovRD($this->idmovimiento, "idmov_recep_desp");

		/*==============================================
		=            CONSULTAMOS EL CLIENTE            =
		==============================================*/
		$rptaCliente = ControladorClientes::ctrmostrarClientes("idcliente", $rpta["idcliente"]);
		/*==============================================
		=            CONOCEMOS LA ACTIVIDAD            =
		==============================================*/
		$rptaActividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba", $rpta["idactividad"]);
		/*================================================
		=            CONSULTAMOS LA CUADRILLA            =
		================================================*/
		$rptaCuadrilla = ControladorEstibas::ctrConsultarEstibas($rpta["idproveedor_estiba"], "idproveedor_estiba");
		/*======================================================================
		=            CONSULTAMOS EL NOMBRE DEL SUPERVISOR APROBADOR            =
		======================================================================*/
		if ($rptaCliente["razonsocial"] == "NEGOCIOS Y LOGISTICA NEGOLOGIC SA") {
			$tabla = "usuariosclientes";
		} else {
			$tabla = "usuariosransa";
		}

		if ($rpta["idusuarioaprobador"] != null || !empty($rpta["idusuarioaprobador"])) {
			$rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla, "id", $rpta["idusuarioaprobador"]);
			$rpta["aprobadorreport"] = $rptaUsuario["primernombre"] . " " . $rptaUsuario["primerapellido"];
		}

		$rpta["cliente"] = $rptaCliente["razonsocial"];
		$rpta["actividad"] =  isset($rptaActividad["descripcion"]) ? $rptaActividad["descripcion"] : "";
		/*=====================================================
		=            OBTENEMOS DATOS DE CHECK LIST            =
		=====================================================*/
		$checktransp = ControladorCheckTransporte::ctrConsultarCheckTransporte("idmov_recep_desp", $rpta["idmov_recep_desp"]);

		$rpta["placa"] = !isset($checktransp["placa"]) ? "" : $checktransp["placa"];
		$rpta["conductor"] = !isset($checktransp["transportista"]) ? "" : $checktransp["transportista"];

		/*============================================================================
		=            OBTENER DATOS DE PERSONAS AUTORIZADAS PARA AUTORIZAR            =
		============================================================================*/
		$rptaPersAuto = ControladorPersAutoriza::ctrConsultarPersAutoriza("", "");
		$nombreAutorizador = array();
		for ($i = 0; $i < count($rptaPersAuto); $i++) {
			$rptaDatosPers = ControladorPersonal::ctrConsultarPersonal("idpersonal", $rptaPersAuto[$i]["idpersonal"]);
			if (isset($_COOKIE["ciudadGarita"])) {
				if ($_COOKIE["ciudadGarita"] == $rptaDatosPers["idciudad"] && $_COOKIE["idlocalizacion"] == $rptaDatosPers["idlocalizacion"]) {
					array_push($nombreAutorizador, array(
						"nombre" => $rptaDatosPers["nombres_apellidos"],
						"idpersonal" => $rptaDatosPers["idpersonal"]
					));
				}
			}
		}
		$rpta["Pers_autoriza"] = $nombreAutorizador;

		/*=============================================================================
		=            VALIDAR SI EL VEHICULO EN GARITA YA HA SIDO ANUNCIADO            =
		=============================================================================*/
		// 		$rptaAnun = ControladorGarita::ctrConsultarGarita("idmov_recep_desp",$rpta["idmov_recep_desp"]);

		// 		$rpta["estadoAnuncio"] = $valoestado = $rptaAnun ?  "ANUNCIADO" : "POR ANUNCIAR";
		// 		$rpta["datosgarita"] = $rptaAnun ? $rptaAnun : "";
		/*=====================================================
		=            LISTADO TOTAL DE LOS CLIENTES            =
		=====================================================*/
		$rptaCliente = ControladorClientes::ctrmostrarClientes("", "");
		$rpta["listClientes"] = $rptaCliente;










		echo json_encode($rpta, true);
	}
	/*==================================================================
	=            REGISTRAR DATOS QUE CONFIRMA EL SUPERVISOR            =
	==================================================================*/
	public function ajaxConfirmSupDat()
	{
		$datos = array(
			"ttransporte" => $this->ttransporte,
			"ncontenedor" => strtoupper($this->ncontenedor),
			"nguias" => $this->nguias,
			"hgarita" => $this->hgarita,
			"hinicio" => $this->hinicio,
			"hfin" => $this->hfin,
			"nom_estibas" => strtoupper($this->nom_estibas),
			"cant_film" => $this->cant_film,
			"cant_cod" => $this->cant_cod,
			"cant_fecha" => $this->cant_fecha,
			"cant_pallets" => $this->cant_pallets,
			"cant_bulto" => $this->cant_bulto,
			"observa_estibas" => strtoupper($this->observa_estibas),
			// "idlocalizacion" => $this->idlocalizacion,
			"idciudad" => $_SESSION["ciudad"],
			"origen" => strtoupper($this->origen),
			"cant_persona" => $this->cant_persona,
			"idusuarioaprobador" => $_SESSION["id"],
			"observaciones_sup" => strtoupper($this->observa_superv)
		);
		$item = array("Confiridmov_recep_desp" => $this->idmovimiento);

		$rpta = ControladorMovRD::ctrEditarMovRDEst($datos, $item);

		echo $rpta;
	}
	/*===========================================================================
	=            CONFIRMACIÓN DE LOS DATOS DEL SUPERVISOR DE ESTIBAS            =
	===========================================================================*/
	public function ajaxConfirmSupEstibas()
	{
		$datos = array(
			"ttransporte" => $this->ttransporte,
			"ncontenedor" => strtoupper($this->ncontenedor),
			"nguias" => $this->nguias,
			"hgarita" => $this->hgarita,
			"hinicio" => $this->hinicio,
			"hfin" => $this->hfin,
			"nom_estibas" => strtoupper($this->nom_estibas),
			"cant_film" => $this->cant_film,
			"cant_cod" => $this->cant_cod,
			"cant_fecha" => $this->cant_fecha,
			"cant_pallets" => $this->cant_pallets,
			"cant_bulto" => $this->cant_bulto,
			"cant_persona" => $this->cant_persona,
			"observa_estibas" => $this->observa_estibas
		);
		$item = array("ConfirmSuperEst" => $this->idmovimiento);

		$rpta = ControladorMovRD::ctrEditarMovRDEst($datos, $item);

		if ($rpta == "ok") {
			echo $rpta;
		}
	}

	/*============================================================================
	=            ELIMINAR Y DETALLAR EL MOTIVO POR EL CUAL SE ELIMINA            =
	============================================================================*/
	public function ajaxEliminarMov()
	{
		$item = array("EliminaMov" => $this->idmovimiento);
		$datos = array(
			"motivo_elimina" => strtoupper($this->motivoelimina),
			"iduserElimina" => $_SESSION["id"]
		);

		$rpta = ControladorMovRD::ctrEditarMovRDEst($datos, $item);

		echo $rpta;
	}
	/*==============================================================
	=            CARGAR DATOS A TRAVES DE UNA PLANTILLA            =
	==============================================================*/
	public function ajaxGuardarPlantilla()
	{
		// var_dump($this->_file);
		$destino = "cop_" . uniqid() . ".xlsx";
		move_uploaded_file($this->_file["tmp_name"], $destino); //guardamos el archivo
		$spreadsheet = IOFactory::load($destino);
		$sheetData = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
		$rptacheck = '';
		$datosinconrrectos = array();
		$datoscorrectos = array();
		for ($i = 3; $i <= count($sheetData); $i++) {
			$arrayFecha = explode('/', $sheetData[$i]["B"]);
			$fecha_valid = $arrayFecha[1] . "/" . $arrayFecha[0] . "/" . $arrayFecha[2];
			/*==============================================================
			=            VALIDAMOS LOS DATOS QUE VAN A INGRESAR            =
			==============================================================*/
			$rptaidcliente = ControladorClientes::ctrmostrarClientes("idcliente", $sheetData[$i]["D"]);
			$rptaidactividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba", $sheetData[$i]["E"]);
			$rptaidtipocarga = ControladorTCarga::ctrConsultarTCarga($sheetData[$i]["H"], "idtipo_carga");

			if ($rptaidcliente && $rptaidactividad && $rptaidtipocarga) {
				if ($sheetData[$i]["J"] == "SI" || $sheetData[$i]["J"] == "NO") {
					if (preg_match('/^(0?[1-9]|[12][0-9]|3[01])[\/\-](0?[1-9]|1[012])[\/\-]\d{4}$/', $fecha_valid) && preg_match('/^([01]?[0-9]|2[0-3]):[0-5][0-9]$/', $sheetData[$i]["C"])) {

						$fecha_actual = new DateTime(date("Y-m-d"));
						$fecha_archivo = new DateTime(date("Y-m-d", strtotime($sheetData[$i]["B"])));
						$intervalo = $fecha_actual->diff($fecha_archivo);
						// $valor = intval($intervalo->format("%R%a")) > 0 ? "Se_Ingresa" : "Fecha_Menor");
						if (intval($intervalo->format("%R%a")) >= 0) {
							$fecha = date("Y-m-d H:i:s", strtotime($sheetData[$i]["B"] . " " . $sheetData[$i]["C"]));
							/*====================================================================
							=            RECORREMOS EL ARCHIVO PARA GUARDAR LOS DATOS            =
							====================================================================*/
							$datos = array(
								"fecha_prog" => $fecha,
								"idcliente" => $sheetData[$i]["D"],
								"idactividad" => $sheetData[$i]["E"],
								"idtipo_carga" => $sheetData[$i]["H"],
								"comentarios" => preg_replace('[\n|\r|\n\r]', '', nl2br(strtoupper($sheetData[$i]["I"]))),
								"idlocalizacion" => $this->idlocalizacion,
								"idciudad" => $_SESSION["ciudad"],
								"cuadrilla" =>  $sheetData[$i]["J"],
								"idusuario" => $_SESSION["id"],
								"modo" => "operacion"
							);
							$rpta = ControladorMovRD::ctrRegistrarMovRD($datos);
							if ($rpta) {

								/*=====================================================================================
								=            ALMACENAMOS EL DATOS INCIALES DE CONDUCTOR Y PLACA CHECK LIST            =
								=====================================================================================*/
								if ($sheetData[$i]["F"] != "" || $sheetData[$i]["G"] != "") {
									$datoscheck = array(
										"transportista" => $conductor = $sheetData[$i]["F"] != "" ? strtoupper($sheetData[$i]["F"]) : null,
										"placa" => $placa = $sheetData[$i]["G"] != "" ? strtoupper($sheetData[$i]["G"]) : null,
										"idmovimiento" => $rpta
									);
									$rptacheck = ControladorCheckTransporte::ctrInsertarCheckTransporte($datoscheck);
									if ($rptacheck == "ok") {
										array_push($datoscorrectos, array("B" => $sheetData[$i]["B"], "D" => $sheetData[$i]["D"], "E" => $sheetData[$i]["E"], "H" => $sheetData[$i]["H"], "J" => $sheetData[$i]["J"]));
									}
								} else {
									array_push($datoscorrectos, array("B" => $sheetData[$i]["B"], "D" => $sheetData[$i]["D"], "E" => $sheetData[$i]["E"], "H" => $sheetData[$i]["H"], "J" => $sheetData[$i]["J"]));
								}
							}
						} else {
							array_push($datosinconrrectos, array("B" . $i => $fecha_valid, "C" . $i => $sheetData[$i]["C"]));
						}
					} else {
						array_push($datosinconrrectos, array("B" . $i => $fecha_valid, "C" . $i => $sheetData[$i]["C"]));
					}
				} else {
					array_push($datosinconrrectos, array("J" . $i => $sheetData[$i]["J"]));
				}
			} else {
				array_push($datosinconrrectos, array("D" . $i => $sheetData[$i]["D"], "E" . $i => $sheetData[$i]["E"], "H" . $i => $sheetData[$i]["H"]));
			}
		}
		$datos_finales = array(
			"Correctos" => $datoscorrectos,
			"Incorrectos" => $datosinconrrectos
		);
		unlink($destino);
		echo json_encode($datos_finales, true);
	}
	/*=======================================================
	=            CHECK LIST DE TRANSPORTE SALTAR            =
	=======================================================*/
	public function ajaxSaltarCheckListTransport()
	{
		$this->idmovimiento;
		$this->nombreresponsable;
		$rptaMov = ControladorMovRD::ctrConsultarMovRD($this->idmovimiento, "idmov_recep_desp");

		if ($rptaMov["cuadrilla"] == "NO") {
			$estado = 8;
			$codigo = null;
		} else {
			/*==================================================================================
			=            SI NECESITA CUADRILLA SE ASIGNA CODIGO PARA LAS CUADRILLAS            =
			==================================================================================*/
			function uniqidReal($lenght = 4)
			{
				// uniqid gives 13 chars, but you could adjust it to your needs.
				if (function_exists("random_bytes")) {
					$bytes = random_bytes(ceil($lenght / 2));
				} elseif (function_exists("openssl_random_pseudo_bytes")) {
					$bytes = openssl_random_pseudo_bytes(ceil($lenght / 2));
				} else {
					throw new Exception("no cryptographically secure random function available");
				}
				return substr(bin2hex($bytes), 0, $lenght);
			}
			$estado = 4;
			$codigo = uniqidReal(6);
		}
		$datos = array(
			"idmov" => $this->idmovimiento,
			"valor1" => $estado,
			"codigo_generado" => $codigo,
			"nombrerespon" => $this->nombreresponsable
		);

		$rptaMov = ControladorMovRD::ctrEditarMovRD($datos, "idmov_recep_desp");
		if ($rptaMov == "ok") {
			echo 1;
		}
	}
}
/*===========================================================
=            PARA REGISTRAR PROVEEDOR DE ESTIBAS            =
===========================================================*/
if (isset($_POST['SaveNomProvEstibas'])) {
	$insertarEstibas = new AjaxEstibas();
	$insertarEstibas->nombreProveedor = $_POST['SaveNomProvEstibas'];
	$insertarEstibas->RucEstibas = $_POST['RucEstibas'];
	$insertarEstibas->ContraEstibas = $_POST['ContraEstibas'];
	$insertarEstibas->CorreoEstibas = $_POST['CorreoEstibas'];
	$insertarEstibas->ajaxRegistrarEstibas();
}
/*====================================================================
=            CONSULTAR PARA EDITAR EL PROVEEDOR DE ESTIBA            =
====================================================================*/
if (isset($_POST['ConsultNomProvEstibas'])) {
	$ConsultarEstibas = new AjaxEstibas();
	$ConsultarEstibas->idprovEstiba = $_POST['ConsultNomProvEstibas'];
	$ConsultarEstibas->ajaxConsultEstibas();
}


/*========================================================
=            PARA EDITAR PROVEEDOR DE ESTIBAS            =
========================================================*/
if (isset($_POST['EditNomProvEstibas'])) {
	$editarEstibas = new AjaxEstibas();
	$editarEstibas->nombreProveedor = $_POST['EditNomProvEstibas'];
	$editarEstibas->idprovEstiba = $_POST['EditIdProvEstibas'];
	$editarEstibas->ajaxEditarEstibas();
}
/*========================================================
=            ELIMINAR EL PROVEEDOR DE ESTIBAS            =
========================================================*/
if (isset($_POST["idEliminarProvEs"])) {
	$eliminarEstibas = new AjaxEstibas();
	$eliminarEstibas->idprovEstiba = $_POST['idEliminarProvEs'];
	$eliminarEstibas->ajaxEliminarEstibas();
}
/*==========================================
=            SECCIION PROGRAMAR            =
==========================================*/
/*====================================================================
=            PROGRAMAR LA RECEPCION DE TRANSPORTE A RANSA            =
====================================================================*/
if (isset($_POST["prog_fech_operacion"])) {
	$ProgMov = new AjaxEstibas();
	$ProgMov->fecha_prog = $_POST['prog_fech_operacion'];
	$ProgMov->idcliente = $_POST['cliente_prog'];
	$ProgMov->idlocalizacion = $_POST['idlocalizacion'];
	$ProgMov->nguias = $_POST['pro_nguias'];
	$ProgMov->idactividad = $_POST['rmovimiento'];
	$ProgMov->conductor = $_POST['conductor'];
	$ProgMov->placa = $_POST['placa'];
	$ProgMov->idtipo_carga = $_POST['t_carga_prog'];
	$ProgMov->comentarios = $_POST['comentario_prog'];
	$ProgMov->cuadrilla = $_POST['cuadrilla'];
	$ProgMov->ajaxProgMovimiento();
}

/*===============================================================
=            ASIGNAR CUADRILLA AL MOV O PROGRAMACIÓN            =
===============================================================*/
if (isset($_POST["asignarCuadrillaMov"])) {
	$asignarCuadrilla = new AjaxEstibas();
	$asignarCuadrilla->idprovEstiba = $_POST["asignarCuadrillaMov"];
	$asignarCuadrilla->idmovimiento = $_POST["idmov"];
	$asignarCuadrilla->ajaxAsignarCuadrilla();
}
/*========================================================================================
=            PARA ALMACENAR LAS IMAGENES QUE SE TOMAN EN RECEPCIÓN O DESPACHO            =
========================================================================================*/
/*==========================================================
=            RECEPCION DE IMAGENES DE RECEPCION            =
==========================================================*/
if (isset($_FILES["fileRecep"])) {
	$ImgMov = new AjaxEstibas();
	$ImgMov->_file = $_FILES["fileRecep"];
	$ImgMov->idmovimiento = $_POST["idmov"];

	$ImgMov->ajaxImgMov();
}
/*=================================================
=            REGISTRAMOS EL CHECK LIST            =
=================================================*/
if (isset($_POST["Rcheckresponsablechecktrans"])) {
	$registroCheckTrans = new AjaxEstibas();

	$registroCheckTrans->_responsablechecktrans = $_POST["Rcheckresponsablechecktrans"];
	$registroCheckTrans->_transportista = $_POST["transportista"];
	$registroCheckTrans->_placa  = $_POST["placa"];
	$registroCheckTrans->_obstransporte = $_POST["obstransporte"];
	$registroCheckTrans->_pptl = $_POST["pptl"];
	$registroCheckTrans->_pa = $_POST["pa"];
	$registroCheckTrans->_mincom = $_POST["mincom"];
	$registroCheckTrans->_plaga = $_POST["plaga"];
	$registroCheckTrans->_oextranios = $_POST["oextranios"];
	$registroCheckTrans->_oquimicos = $_POST["oquimicos"];
	$registroCheckTrans->_sellos = $_POST["sellos"];
	$registroCheckTrans->idmovimiento = $_POST["idmov"];
	$registroCheckTrans->imagenes = $_POST["imagen"];
	$registroCheckTrans->_comentItem = $_POST["comentItem"];
	$registroCheckTrans->_guias = $_POST["guias"];

	$registroCheckTrans->ajaxRegistoCheckTransport();
}
/*=======================================================
=            CAMBIAR ESTADO PARA INICIAR MOV            =
=======================================================*/
if (isset($_POST["IniciarMov"])) {
	$InicioMov = new AjaxEstibas();
	$InicioMov->idmovimiento = $_POST["IniciarMov"];
	$InicioMov->valorEstado = $_POST["valorEstado"];
	$InicioMov->nombreresponsable = $_POST["nombreresponsable"];
	$InicioMov->UpdateMovInicio();
}
/*==========================================================
=            ALMACENAMIENTO DE ARCHIVO TEMPORAL            =
==========================================================*/
if (isset($_FILES["fileTemp"])) {
	$arch_temp = new AjaxEstibas();
	$arch_temp->_file = $_FILES["fileTemp"];
	$arch_temp->ajaxAlmTemp();
}
/*================================================================================
=            ELIMINAR LA IMAGEN TEMPORALMENTE GUARDADA EN EL SERVIDOR            =
================================================================================*/
if (isset($_POST["RutaImgTempDelete"])) {
	$deleteImgTemp = new AjaxEstibas();
	$deleteImgTemp->_file = $_POST["RutaImgTempDelete"];
	$deleteImgTemp->ajaxEliminarImgTemp();
}
/*=============================================================================
=            PASAR LA IMAGEN TEMPORAL A LA CARPETA CORRESPONDIENTE            =
=============================================================================*/
if (isset($_POST["RutaFileRecep"])) {
	$updateFile = new AjaxEstibas();
	$updateFile->_file = $_POST["RutaFileRecep"];
	$updateFile->idmovimiento = $_POST["idmov"];
	$updateFile->ajaxUpdateFileTemp();
}
/*====================================================
=            DATOS INGRESADOS POR ESTIBAS            =
====================================================*/
if (isset($_POST["DatEst_idmov_recep_desp"])) {
	$dat_estiba = new AjaxEstibas();
	$dat_estiba->idmovimiento = $_POST["DatEst_idmov_recep_desp"];
	$dat_estiba->ttransporte = $_POST["EstTransporte"];
	$dat_estiba->ncontenedor = $_POST["EstContenedor"];
	$dat_estiba->nguias = $_POST["EstGuias"];
	$dat_estiba->hgarita = $_POST["EstHGarita"];
	$dat_estiba->hinicio = $_POST["EstHInicio"];
	$dat_estiba->hfin = $_POST["EstHFin"];
	$dat_estiba->nom_estibas = $_POST["EstNomEstibas"];
	$dat_estiba->cant_film = $_POST["EstCantFilm"];
	$dat_estiba->cant_cod = $_POST["EstCantCodigo"];
	$dat_estiba->cant_fecha = $_POST["EstCantFecha"];
	$dat_estiba->cant_pallets = $_POST["EstCantPallet"];
	$dat_estiba->cant_bulto = $_POST["CantBulto"];
	$dat_estiba->observa_estibas = $_POST["EstObservacion"];
	$dat_estiba->razonsocial = $_POST["Estrazonsocial"];
	$dat_estiba->ajaxIngresarDatEstibas();
}
/*====================================================================
=            CONSULTAMOS PARA CONFIRMAR POR EL SUPERVISOR            =
====================================================================*/
if (isset($_POST["ConsultConfirmSup"])) {
	$ConfSupe = new AjaxEstibas();
	$ConfSupe->idmovimiento = $_POST["ConsultConfirmSup"];
	$ConfSupe->ConsultDatEstSup();
}
/*======================================================================
=            OBTENER OPCIONES FILTRADAS POR ID DEL CLIENTE            =
======================================================================*/
if (isset($_POST["idCliente"])) {
	$idCliente = $_POST["idCliente"];

	// Obtener las opciones filtradas desde el controlador
	$opcionesFiltradas = ControladorTTransporte::ctrObtenerOpcionesTransporte($idCliente);

	// Devolver las opciones como JSON
	echo json_encode($opcionesFiltradas);
	return;
}
/*==========================================================================
=            CONFIRMACION DEL SUPERVISOR DE LOS DATOS INGRESADOS            =
==========================================================================*/
if (isset($_POST["ConEstidmovConfSup"])) {
	$confDatSup = new AjaxEstibas();
	$confDatSup->idmovimiento = $_POST["ConEstidmovConfSup"];
	$confDatSup->ttransporte = $_POST["ConEstTransporte"];
	$confDatSup->ncontenedor = $_POST["ConEstContenedor"];
	$confDatSup->nguias = $_POST["ConEstGuias"];
	$confDatSup->hgarita = $_POST["ConEstHGarita"];
	$confDatSup->hinicio = $_POST["ConEstHInicio"];
	$confDatSup->hfin = $_POST["ConEstHFin"];
	$confDatSup->nom_estibas = $_POST["ConEstNomEstibas"];
	$confDatSup->cant_film = $_POST["ConEstCantFilm"];
	$confDatSup->cant_cod = $_POST["ConEstCantCodigo"];
	$confDatSup->cant_fecha = $_POST["ConEstCantFecha"];
	$confDatSup->cant_pallets = $_POST["ConEstCantPallet"];
	$confDatSup->cant_bulto = $_POST["ConCantBulto"];
	$confDatSup->observa_estibas = $_POST["ConEstObservacion"];
	$confDatSup->origen = $_POST["ConEstOrigen"];
	$confDatSup->cant_persona = $_POST["ConEstCant_Persona"];
	// $confDatSup -> idlocalizacion = $_POST["ConEstCD"];
	$confDatSup->observa_superv = $_POST["ConEstObservacionSup"];
	$confDatSup->ajaxConfirmSupDat();
}
/*==============================================================
=            CONFIRMACIÓN DEL SUPERVISOR DE ESTIBAS            =
==============================================================*/
if (isset($_POST["idmovCSupEstServ"])) {
	$confSupEstDat = new AjaxEstibas();
	$confSupEstDat->idmovimiento = $_POST["idmovCSupEstServ"];
	$confSupEstDat->ttransporte = $_POST["TransporteCSupEst"];
	$confSupEstDat->ncontenedor = $_POST["ContenedorCSupEst"];
	$confSupEstDat->nguias = $_POST["GuiasCSupEst"];
	$confSupEstDat->hgarita = $_POST["HGaritaCSupEst"];
	$confSupEstDat->hinicio = $_POST["HInicioCSupEst"];
	$confSupEstDat->hfin = $_POST["HFinCSupEst"];
	$confSupEstDat->nom_estibas = $_POST["NomEstibasCSupEst"];
	$confSupEstDat->cant_film = $_POST["CantFilmCSupEst"];
	$confSupEstDat->cant_cod = $_POST["CantCodigoCSupEst"];
	$confSupEstDat->cant_fecha = $_POST["CantFechaCSupEst"];
	$confSupEstDat->cant_pallets = $_POST["CantPalletCSupEst"];
	$confSupEstDat->cant_bulto = $_POST["CantBultoCSupEst"];
	$confSupEstDat->cant_persona = $_POST["Cant_PersonaCSupEst"];
	$confSupEstDat->observa_estibas = $_POST["ObservacionCSupEst"];

	$confSupEstDat->ajaxConfirmSupEstibas();
}

/*=========================================================================
=            ELIMINACION DEL MOVIMIENTO EN CONJUNTO DEL MOTIVO            =
=========================================================================*/
if (isset($_POST["idMovEliminar"])) {
	$eliminaMov = new AjaxEstibas();
	$eliminaMov->idmovimiento = $_POST["idMovEliminar"];
	$eliminaMov->motivoelimina = $_POST["motivoEliminar"];
	$eliminaMov->ajaxEliminarMov();
}
/*==========================================================================
=            CARGAR PLANTILLA EXCEL PARA REGISTROS DE VEHICULOS            =
==========================================================================*/
if (isset($_FILES["Cargarplantilla"])) {
	$archivoplantilla = new AjaxEstibas();
	$archivoplantilla->_file = $_FILES["Cargarplantilla"];
	$archivoplantilla->idlocalizacion = $_POST['localizacion'];
	$archivoplantilla->ajaxGuardarPlantilla();
}

/*==============================================================
=   NUEVO: CARGAR PLANTILLA EXCEL FORMATO PERSONALIZADO        =
==============================================================*/
if (isset($_FILES["CargarExcelNuevo"])) {
	$archivoplantilla = new AjaxEstibas();
	$archivoplantilla->_file = $_FILES["CargarExcelNuevo"];
	$archivoplantilla->idlocalizacion = $_POST['localizacion'];
	$archivoplantilla->ajaxGuardarPlantillaNuevo();
}


/*==========================================================
=            SALTAR EL CHECK LIST DE TRANSPORTE            =
==========================================================*/
if (isset($_POST['SaltarCheck'])) {
	$saltCheckTrans = new AjaxEstibas();
	$saltCheckTrans->idmovimiento = $_POST['SaltarCheck'];
	$saltCheckTrans->nombreresponsable = $_POST['responsablecheck'];
	$saltCheckTrans->ajaxSaltarCheckListTransport();
}
