<?php
session_start();
require_once "../controladores/solqr.controlador.php";
require_once "../modelos/solqr.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/areas.controlador.php";
require_once "../modelos/areas.modelo.php";

require_once "../controladores/detalle_clasificacion_qr.controlador.php";
require_once "../modelos/detalle_clasificacion_qr.modelo.php";

require_once "../controladores/detalle_investigacion_qr.controlador.php";
require_once "../modelos/detalle_investigacion_qr.modelo.php";

require_once "../controladores/detalle_respcliente_qr.controlador.php";
require_once "../modelos/detalle_respcliente_qr.modelo.php";

require_once "../controladores/detalle_seguimiento_qr.controlador.php";
require_once "../modelos/detalle_seguimiento_qr.modelo.php";

require_once "../controladores/detalle_negociacion_qr.controlador.php";
require_once "../modelos/detalle_negociacion_qr.modelo.php";

require_once "../controladores/detalle_analisisqr.controlador.php";
require_once "../modelos/detalle_analisisqr.modelo.php";

use  PHPMailer\PHPMailer\PHPMailer ; 
use  PHPMailer\PHPMailer\Exception ;

require_once '../extensiones/PHPMailer/PHPMailer/src/Exception.php';
require_once '../extensiones/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once '../extensiones/PHPMailer/PHPMailer/src/SMTP.php';

require_once  "../extensiones/PHPMailer/vendor/autoload.php";

class AjaxSolQR{

	public $_idusuarios;
	public $__idsolicitudes_qr;
	public $_archCR;
	public $_comentariocr;
	public $_codigo;
	public $_estado_analisi;
	public $_motivo_causar;
	public $_correoNoti;
	public $_textoCorreo;
	public $_password;
	public $_asunto;
	public $_NegocioAsignado;
	public $_observaciones;
	// public $_idDetalleInvesti;

	public function ajaxNotificarNegocioResponsable(){
		/*===========================================================================
		=            ACTUALIZAMOS A LOS USUARIOS RESPONSABLE EN LA TABLA            =
		===========================================================================*/
		$datos = array("idusuarios_responsables" => $this->_idusuarios,
						"idsolicitudes_qr" => $this->_idsolicitudes_qr,
						"idusuario_asignador" => $_SESSION['id'],
						"idusuario_negocio" => $this->_NegocioAsignado,
						"estado" => 1);
		$rpta = ControladorDClasificacionQR::ctrInsertarDClasificacionQR($datos); // INGRESAMOS LA CLASIFICACION
		
		if ($rpta) {
			$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
							"estado" => 2);
			$rpta = ControladorSolQR::ctrActualizarSolQR("idsolicitudes_qr",$datos);

			if ($rpta) {
				/*===========================================================
				=            CONSULTAMOS LOS DATOS DE LA NOVEDAD            =
				===========================================================*/
				$rptaNovedad = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
				$mail = new PHPMailer();
				$mail->IsSMTP();
				$mail->CharSet = 'UTF-8';
				$mail->SMTPSecure = 'tls';
				$mail->SMTPAuth = true;
				$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
				$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
				$mail->Password = "Didacta_123"; // Contraseña
				$mail->Port = 587; // Puerto a utilizar
				$mail->FromName = "NOVEDADES RANSA";
				$mail->isHTML(true);	
				$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
				$body = 'Hola,<br><br>
Has sido asignado como responsable de atender la queja/reclamo registrado por nuestro cliente. El ticket generado es:<br>
<strong style="font-size:20pt;">'.$rptaNovedad["codigoSolicitud"].'</strong><br>
Recuerda que:<br>
<ol>
  <li>Si atiendes una queja debes generar acciones correctivas (utiliza el formato FCME-XXXX).</li>
  <li>Si atiendes un reclamo debes generar un análisis de causa y planes de acción (utiliza el formato FCME-0053).</li>
</ol>
Tienes 48 horas como máximo para registrar tu respuesta en el portal. Tu atención oportuna mejorará la experiencia de servicio de nuestros clientes.<br><br>
							<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
				<span style="color:#009B3A;font-family:Verdana,sans-serif;">Ecuador | Km 22, vía Daule –Guayaquil </span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
				<span lang="ES" style="font-size:10.0pt; font-family:Ebrima; color:#009B3A">Pbx: (593) 0997410389 | Cel: (593) 0996047252</span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#F29104;font-family:UniviaPro-Bold;"><a href="http://www.ransa.net/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="0"><span style="color:#F29104;">www.ransa.net</span></a></span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">A continuación el enlace en el que puedes registrar las oportunidades de mejora detectadas en nuestros procesos.</span><span style="color:#009A3F;font-size:10.5pt;font-family:Verdana,sans-serif;">
				</span><b><span style="color:#00B050;font-family:Verdana,sans-serif;"><a href="https://nam02.safelinks.protection.outlook.com/?url=https%3A%2F%2Fforms.office.com%2FPages%2FResponsePage.aspx%3Fid%3DQvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u&amp;data=04%7C01%7CDBorborP%40ransa.net%7C433c12c9c3b941e1da0f08d8ada0b382%7C5726fb42842645779964f13a62ad5eb9%7C0%7C0%7C637450253002340063%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&amp;sdata=x7bsp0cvihFHT1o1BUzMCD8p90XDJhHQYPJnkA1%2FhO4%3D&amp;reserved=0" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="1">Ingresa
				Aquí</a></span></b><b><span style="color:#002060;font-size:10.5pt;font-family:Verdana,sans-serif;"></span></b></p>';
				$usuariosNoti = json_decode($this->_idusuarios);
				for ($i=0; $i < count($usuariosNoti) ; $i++) { 
					$rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$usuariosNoti[$i]);
					$mail->addAddress($rptaUsuario["email"]);	
				}

				$mail->setFrom('proyectosecuador@ransa.net', 'SGQR');
				$mail->Subject = 'NOTIFICACIÓN [RESPONSABLE ATENDER SOLICITUD]';
				$mail->Body    = $body;
				$envios = $mail->send();
				$mail->ClearAddresses(); // ELIMINAMOS LOS USUARIOS QUE SE ASIGNO ANTERIORMENTE
				$body = 'Hola,<br><br>
Has sido asignado como responsable de medir la satisfacción del cliente ante la atención de su queja/reclamo.  El ticket generado es:<br>
<strong style="font-size:20pt;">'.$rptaNovedad["codigoSolicitud"].'</strong><br>
Podrás realizar la medición cuando hayamos cerrados los planes de acción propuestos. Te notificaremos oportunamente para que puedas ejecutarlo. Mientras tanto puedes visualizar el avance en el portal de atención.<br>
Recuerda que tu atención oportuna mejorará la experiencia de servicio de nuestros clientes.<br><br>
							<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
				<span style="color:#009B3A;font-family:Verdana,sans-serif;">Ecuador | Km 22, vía Daule –Guayaquil </span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
				<span lang="ES" style="font-size:10.0pt; font-family:Ebrima; color:#009B3A">Pbx: (593) 0997410389 | Cel: (593) 0996047252</span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#F29104;font-family:UniviaPro-Bold;"><a href="http://www.ransa.net/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="0"><span style="color:#F29104;">www.ransa.net</span></a></span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
				<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">A continuación el enlace en el que puedes registrar las oportunidades de mejora detectadas en nuestros procesos.</span><span style="color:#009A3F;font-size:10.5pt;font-family:Verdana,sans-serif;">
				</span><b><span style="color:#00B050;font-family:Verdana,sans-serif;"><a href="https://nam02.safelinks.protection.outlook.com/?url=https%3A%2F%2Fforms.office.com%2FPages%2FResponsePage.aspx%3Fid%3DQvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u&amp;data=04%7C01%7CDBorborP%40ransa.net%7C433c12c9c3b941e1da0f08d8ada0b382%7C5726fb42842645779964f13a62ad5eb9%7C0%7C0%7C637450253002340063%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&amp;sdata=x7bsp0cvihFHT1o1BUzMCD8p90XDJhHQYPJnkA1%2FhO4%3D&amp;reserved=0" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="1">Ingresa
				Aquí</a></span></b><b><span style="color:#002060;font-size:10.5pt;font-family:Verdana,sans-serif;"></span></b></p>';
				$rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$this->_NegocioAsignado);
				$mail->addAddress($rptaUsuario["email"]);
				$mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
				$mail->Subject = 'NOTIFICACIÓN [ASIGNACIÓN DE MEDIR SATISFACCIÓN]';
				$mail->Body    = $body;
				$envios2 = $mail->send();

				if ($envios && $envios2) {
					echo 1;
				}else{
					echo 2;
				}

			}			
						
		}


	}

	/*============================================================
	=            NOTIFICACION DEL ENVIO DE CAUSA RAIZ            =
	============================================================*/
	public function ajaxNotificarCausaRaiz(){
		if ($this->_estado_analisi == "DOC-CARGADO") {
			/*=============================================================
			=            ALMACENAMOS EL ARCHIVO EN EL SERVIDOR            =
			=============================================================*/
			$extension = pathinfo($this->_archCR["name"],PATHINFO_EXTENSION); // obtenemos la extension del archivo
			$directorio = "archivos/docCausaRaiz/";//RUTA DEL DIRECTORIO PRINCIPAL
			$nombre = uniqid();
			$rutaarchivo = $directorio.$nombre.".".$extension;
			move_uploaded_file($this->_archCR["tmp_name"],"../".$rutaarchivo);
		}else{
			$rutaarchivo = null;
		}
		$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
						"estado" => 3);
		$rpta = ControladorSolQR::ctrActualizarSolQR("idsolicitudes_qr",$datos);


		/*==============================================================
		=            REGISTRAMOS LA INVESTIGACION REALIZADA            =
		==============================================================*/
		$datosdetalle = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
						"tipo_analisis" => $this->_estado_analisi,
						"idusuario" => $_SESSION['id'],
						"observaciones" => $this->_motivo_causar,
						"achivo" => $rutaarchivo);

		$rptaDetalle = ControladorDInvestigacionQR::ctrInsertarDInvestigacionQR($datosdetalle);
		// $rptaDetalle = ControladorDetalleCRQR::ctrIgresarDetalle($datosdetalle);
		$rptaNovedad = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
		if ($rpta && $rptaDetalle) {
		/*=======================================================================================
		=            NOTIFICACIÓN POR CORREO QUE SE HA CARGADO EL ARCHIVO CAUSA RAIZ            =
		=======================================================================================*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
		$mail->Password = "Didacta_123"; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		$mail->FromName = "NOVEDADES RANSA";
		$mail->isHTML(true);	
		$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
		$body = 'Hola, <br><br>
La queja/reclamo ha sido atendida por el responsable asignado, revisa el análisis y/o planes de acción en el portal de atención. El ticket atendido es:<br>
<strong style="font-size:20pt;">'.$rptaNovedad["codigoSolicitud"].'</strong><br>
Recuerda que tienes 24 horas como máximo para la revisión. Tu atención oportuna mejorará la experiencia de servicio de nuestros clientes.<br><br>
					<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
		<span style="color:#009B3A;font-family:Verdana,sans-serif;">Ecuador | Km 22, vía Daule –Guayaquil </span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
		<span lang="ES" style="font-size:10.0pt; font-family:Ebrima; color:#009B3A">Pbx: (593) 0997410389 | Cel: (593) 0996047252</span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#F29104;font-family:UniviaPro-Bold;"><a href="http://www.ransa.net/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="0"><span style="color:#F29104;">www.ransa.net</span></a></span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">A continuación el enlace en el que puedes registrar las oportunidades de mejora detectadas en nuestros procesos.</span><span style="color:#009A3F;font-size:10.5pt;font-family:Verdana,sans-serif;">
		</span><b><span style="color:#00B050;font-family:Verdana,sans-serif;"><a href="https://nam02.safelinks.protection.outlook.com/?url=https%3A%2F%2Fforms.office.com%2FPages%2FResponsePage.aspx%3Fid%3DQvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u&amp;data=04%7C01%7CDBorborP%40ransa.net%7C433c12c9c3b941e1da0f08d8ada0b382%7C5726fb42842645779964f13a62ad5eb9%7C0%7C0%7C637450253002340063%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&amp;sdata=x7bsp0cvihFHT1o1BUzMCD8p90XDJhHQYPJnkA1%2FhO4%3D&amp;reserved=0" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="1">Ingresa
		Aquí</a></span></b><b><span style="color:#002060;font-size:10.5pt;font-family:Verdana,sans-serif;"></span></b></p>';
		/*============================================================================
		=            CONSULTAMOS LOS USUARIOS QUE SON DEL AREA DE CALIDAD            =
		============================================================================*/
		$rptaArea = ControladorAreas::ctrConsultarAreas("nombre","CALIDAD");
		$rptaUsuario = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","idareas",$rptaArea["idarea"]);		
		for ($i=0; $i < count($rptaUsuario) ; $i++) {
			$mail->addAddress($rptaUsuario[$i]["email"]);	
		}
		$mail->AddAttachment($rutaarchivo); //adjunto de correo
		$mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
		$mail->Subject = 'NOTIFICACIÓN [ANÁLISIS DE CAUDA RAIZ]';
		$mail->Body    = $body;
		$envios = $mail->send();
			if ($envios) {
				echo 1;
			}
		}

		
		
		


	}

	/*==============================================================
	=            APROBAR ANALISIS CARGADO EN EL SISTEMA            =
	==============================================================*/
	public function ajaxAprobarAnalisis(){
		/* MODIFICAMOS EL ESTADO EN LA BASE DE DATOS */
		$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
						"estado" => 4);
		$rpta = ControladorSolQR::ctrActualizarSolQR("idsolicitudes_qr",$datos);
		/*===========================================================
		=            REGISTRAMOS LA APROBACION REALIZADA            =
		===========================================================*/
		$datosdetalle = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
						"tipo_analisis" => "APROBADO",
						"idusuario" => $_SESSION['id'],
						"observaciones" => null,
						"achivo" => null);

		$rptaDetalle = ControladorDInvestigacionQR::ctrInsertarDInvestigacionQR($datosdetalle);
		$rptaNovedad = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
		if ($rpta && $datosdetalle) {
			/*=======================================================================================
			=            NOTIFICACIÓN POR CORREO QUE SE APROBADO EL ARCHIVO CAUSA RAIZ            =
			=======================================================================================*/
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->CharSet = 'UTF-8';
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
			$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
			$mail->Password = "Didacta_123"; // Contraseña
			$mail->Port = 587; // Puerto a utilizar
			$mail->FromName = "NOVEDADES RANSA";
			$mail->isHTML(true);	
			$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
			$body = 'Hola,<br><br>
El análisis y/o planes de acción propuestos para atender la queja/reclamo es satisfactorio, por favor genera la respuesta al cliente en un plazo máximo de 24 horas. El ticket atendido es:<br>
<strong style="font-size:20pt;">'.$rptaNovedad["codigoSolicitud"].'</strong><br>
Recuerda que el equipo de calidad verificará el cumplimiento de las acciones propuestas en las fechas que has definido.<br>
Agradecemos tu compromiso de mejorar la experiencia de servicio de nuestros clientes.<br><br>
						<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
			<span style="color:#009B3A;font-family:Verdana,sans-serif;">Ecuador | Km 22, vía Daule –Guayaquil </span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
			<span lang="ES" style="font-size:10.0pt; font-family:Ebrima; color:#009B3A">Pbx: (593) 0997410389 | Cel: (593) 0996047252</span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#F29104;font-family:UniviaPro-Bold;"><a href="http://www.ransa.net/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="0"><span style="color:#F29104;">www.ransa.net</span></a></span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">A continuación el enlace en el que puedes registrar las oportunidades de mejora detectadas en nuestros procesos.</span><span style="color:#009A3F;font-size:10.5pt;font-family:Verdana,sans-serif;">
			</span><b><span style="color:#00B050;font-family:Verdana,sans-serif;"><a href="https://nam02.safelinks.protection.outlook.com/?url=https%3A%2F%2Fforms.office.com%2FPages%2FResponsePage.aspx%3Fid%3DQvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u&amp;data=04%7C01%7CDBorborP%40ransa.net%7C433c12c9c3b941e1da0f08d8ada0b382%7C5726fb42842645779964f13a62ad5eb9%7C0%7C0%7C637450253002340063%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&amp;sdata=x7bsp0cvihFHT1o1BUzMCD8p90XDJhHQYPJnkA1%2FhO4%3D&amp;reserved=0" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="1">Ingresa
			Aquí</a></span></b><b><span style="color:#002060;font-size:10.5pt;font-family:Verdana,sans-serif;"></span></b></p>';
			/*============================================================================
			=            CONSULTAMOS LOS USUARIOS QUE SON DEL NEGOCIO RESPONSABLE          =
			============================================================================*/

			$rptaClasi = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
			//$rpta = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
			$responsables = json_decode($rptaClasi[0]["idusuarios_responsables"]);

			for ($i=0; $i < count($responsables) ; $i++) {
				$rptauser = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$responsables[$i]);
				$mail->addAddress($rptauser["email"]);	
			}
			$mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
			$mail->Subject = 'NOTIFICACIÓN [ANÁLISIS APROBADO]';
			$mail->Body    = $body;
			$envios = $mail->send();
				if ($envios) {
					echo 1;
				}			
			
		}


	}

	/*========================================
	=            CONSULTA POPOVER            =
	========================================*/
	public function ajaxPopover(){
		if (isset($this->_idsolicitudes_qr) != "") {
			$rpta = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$this->_idsolicitudes_qr);	
		}else{
			$rpta = ControladorSolQR::ctrConsultarSolQR("codigoSolicitud",$this->_codigo);	
		}
		/*============================================
		=            GUARDAR RESPONSABLES            =
		============================================*/
		$rptaClasi = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idsolicitudes_qr",$rpta["idsolicitudes_qr"]);
		$rpta["fecha_clasificacion"] = isset($rptaClasi[0]["fecha_registro"]) ? $rptaClasi[0]["fecha_registro"] : "PENDIENTE";
		/* CONSULTA REGISTROD DE DOCUMENTOS CARGADOS DEL ULTIMO SOLICITUD */
		
		$datosInvest = array("idsolicitudes_qr" => $rpta["idsolicitudes_qr"],
							"tipo_analisis" => "DOC-CARGADO");
		$rptaInvest = ControladorDInvestigacionQR::ctrConsultarDInvestigacionQR("tipo_analisis",$datosInvest);
		$rptaInvestigacion = end($rptaInvest); // escoge el ultimo array
		/* CONSULTA REGISTRO DE APROBADOR DE ULTIMO MOVIMIENTO */

		$datosInvestaprob = array("idsolicitudes_qr" => $rpta["idsolicitudes_qr"],
							"tipo_analisis" => "APROBADO");
		$rptaInvestaprob = ControladorDInvestigacionQR::ctrConsultarDInvestigacionQR("tipo_analisis",$datosInvestaprob);
		$rptaInvestigacionApro = end($rptaInvestaprob); // escoge el ultimo array

		$rptaRespCliente = ControladorDRespuestaClienteQR::ctrConsultarDRespuestaClienteQR("idsolicitudes_qr",$rpta["idsolicitudes_qr"]);
		$rptaRespuestaCliente = end($rptaRespCliente); // escoge el ultimo array

		if (isset($rptaClasi[0]["idusuarios_responsables"])) {
			$userRespon = json_decode($rptaClasi[0]["idusuarios_responsables"],true);
			$saveUserRespon = "";
			for ($i=0; $i < count($userRespon) ; $i++) {
				$rptaResponsables = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$userRespon[$i]);
				$nombre = explode(" ", $rptaResponsables["primernombre"]);
				$apellido = explode(" ", $rptaResponsables["primerapellido"]);
				$saveUserRespon .= $nombre[0]." ".$apellido[0]." - "; 
			}
			$enviarResponsables = substr($saveUserRespon, 0,-3); 
			$rpta["usuariosrespon"] = $enviarResponsables;
		}else{
			$rpta["usuariosrespon"] = "PENDIENTE";
		}
		/*=========================================================
		=            USUARIO QUE REALIZA LA ASIGNACIÓN            =
		=========================================================*/
		if (isset($rptaClasi[0]["idusuario_asignador"])) {
			$rptaUserAsignador = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaClasi[0]["idusuario_asignador"]);
			$nombre = explode(" ", $rptaUserAsignador["primernombre"]);
			$apellido = explode(" ", $rptaUserAsignador["primerapellido"]);
			$rpta["userAsignador"] = $nombre[0]." ".$apellido[0];
		}else{
			$rpta["userAsignador"] = "Pendiente";
		}
		/*==============================================
		=            NEGOCIO DE SEGUIMIENTO AL CLIENTE            =
		==============================================*/
		if (isset($rptaClasi[0]["idusuario_negocio"])) {
			$rptaUserAsignador = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaClasi[0]["idusuario_negocio"]);
			$nombre = explode(" ", $rptaUserAsignador["primernombre"]);
			$apellido = explode(" ", $rptaUserAsignador["primerapellido"]);
			$rpta["userNegocio"] = $nombre[0]." ".$apellido[0];
		}else{
			$rpta["userNegocio"] = "Pendiente";
		}

		/*==============================================================
		=            USUARIO QUE CARGA EL ANALISIS DE CAUSA            =
		==============================================================*/

		if (isset($rptaInvestigacion["idusuario"])) {
			$rptaUserCargaAnalisis = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaInvestigacion["idusuario"]);
			$nombre = explode(" ", $rptaUserCargaAnalisis["primernombre"]);
			$apellido = explode(" ", $rptaUserCargaAnalisis["primerapellido"]);
			$rpta["userCargaAnalisis"] = $nombre[0]." ".$apellido[0];
			$rpta["fecha_doc_cargado"] = $rptaInvestigacion["fecha_regist"];
		}else{
			$rpta["userCargaAnalisis"] = "Pendiente";
		}
		/*================================================================
		=            COMPROBAR QUE EXISTE EL ANALISIS CARGADO            =
		================================================================*/
		if (isset($rptaInvestigacion["archivo"])) {

			$rpta["doc_cargado"] = "Documento Cargado.";
		}else{
			$rpta["doc_cargado"] = "Pendiente";
		}

		if (isset($rptaInvestigacionApro["idusuario"])) {
			$rptaUserCargaAnalisis = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaInvestigacionApro["idusuario"]);
			$nombre = explode(" ", $rptaUserCargaAnalisis["primernombre"]);
			$apellido = explode(" ", $rptaUserCargaAnalisis["primerapellido"]);
			$rpta["userAprobadorAnali"] = $nombre[0]." ".$apellido[0];
			$rpta["fecha_doc_aprobado"] = $rptaInvestigacionApro["fecha_regist"];
			
		}else{
			$rpta["userAprobadorAnali"] = "Pendiente";
		}



		if (isset($rptaRespuestaCliente["text_respuesta"])) {
			$rptaUserCargaAnalisis = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaRespuestaCliente["idusuario"]);
			// $rptaUserEnviadoA = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaRespuestaCliente["notificadoa"]);
			$nombre = explode(" ", $rptaUserCargaAnalisis["primernombre"]);
			$apellido = explode(" ", $rptaUserCargaAnalisis["primerapellido"]);
			/* USUARIO QUE SE LE NOTIFICO */
			$rpta["userRespuestaEnv"] = $nombre[0]." ".$apellido[0];		
			$rpta["fecha_Resp_Cliente"] = $rptaRespuestaCliente["fecha_regist"];
			$rpta["notificadoa"] = $rptaRespuestaCliente["notificadoa"];

		}else{
			$rpta["userRespuestaEnv"] = "Pendiente";
		}

		/*=====================================================
		=            EN EL CASO QUE SEA UN RECLAMO            =
		=====================================================*/
		if ($rpta["tipo_novedad"] == "Reclamo") {
			$rptaNegociacion = ControladorDNegociacionQR::ctrConsultarDNegociacionQR("idsolicitudes_qr",$rpta["idsolicitudes_qr"]);
			// $rptaNegociacion = end($rptaNegociacion);
			if ($rptaNegociacion) {
				$rptaUserCargaAnalisis = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaNegociacion[0]["idusuario"]);
				// $rptaUserEnviadoA = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaRespuestaCliente["notificadoa"]);
				$nombre = explode(" ", $rptaUserCargaAnalisis["primernombre"]);
				$apellido = explode(" ", $rptaUserCargaAnalisis["primerapellido"]);			
				$rpta["usuario_Negociacion"] = $nombre[0]." ".$apellido[0];
				$rpta["fecha_negociacion"] = $rptaNegociacion[0]["fecha_regist"];
			}else{
				$rpta["usuario_Negociacion"] = "Por Definir";
				$rpta["fecha_negociacion"] = "Por Definir";
			}
		}
		/*==============================================
		=            DATOS PARA SEGUIMIENTO            =
		==============================================*/
		$rptaSeguimiento = ControladorDSeguimientoQR::ctrConsultarDSeguimientoQR("idsolicitudes_qr",$rpta["idsolicitudes_qr"]);

		for ($i=0; $i <count($rptaSeguimiento) ; $i++) { 
			$rptaUserCargaAnalisis = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaSeguimiento[$i]["idusuario"]);
			// $rptaUserEnviadoA = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaRespuestaCliente["notificadoa"]);
			$nombre = explode(" ", $rptaUserCargaAnalisis["primernombre"]);
			$apellido = explode(" ", $rptaUserCargaAnalisis["primerapellido"]);
			/* AREA */
			$rptaArea = ControladorAreas::ctrConsultarAreas("idarea",$rptaUserCargaAnalisis["idareas"]);

			if ($rptaArea["nombre"] == "CALIDAD") {
				$rpta["fecha_obs_calidad"] = $rptaSeguimiento[$i]["fecha_regist"];
				$rpta["usuario_seguimiento_calidad"] = $nombre[0]." ".$apellido[0];
				$rpta["usuario_seguimiento_calidad_observaciones"] = $rptaSeguimiento[$i]["observaciones"];
				$rpta["usuario_seguimiento_negocio"] = "PENDIENTE";
			}else if ($rptaArea["nombre"] == "NEGOCIO") {
				$rpta["usuario_seguimiento_negocio"] = $nombre[0]." ".$apellido[0];
				$rpta["fecha_obs_negocio"] = $rptaSeguimiento[$i]["fecha_regist"];
				$rpta["usuario_seguimiento_negocio_observaciones"] = $rptaSeguimiento[$i]["observaciones"];
			}
			else{
				$rpta["usuario_seguimiento_calidad"] = "PENDIENTE";
				$rpta["usuario_seguimiento_negocio"] = "PENDIENTE";
			}
		}
		

		
		
		
		

		echo json_encode($rpta,true);

	}
	/*========================================================
	=            NOTIFICACION DE VOLVER A REVISAR            =
	========================================================*/
	public function ajaxNotificarRevisar(){
		/*==============================================================
		=            REGISTRAMOS LA INVESTIGACION REALIZADA            =
		==============================================================*/
		$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
						"tipo_analisis" => $this->_estado_analisi,
						"idusuario" => $_SESSION['id'],
						"observaciones" => $this->_motivo_causar,
						"achivo" => null);

		$rpta = ControladorDInvestigacionQR::ctrInsertarDInvestigacionQR($datos);

		if ($this->_estado_analisi == "RE-CLASIFICAR") {
			/*===============================================================================================
			=            PRIMERO CONSULTAMOS SI EXISTE UNA CLASIFICACION REALIZADA ANTERIORMENTE            =
			===============================================================================================*/
			$rptaClasi = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idsolicitudes_qr",$this->_idsolicitudes_qr);

			$datosUpdateClasi = array("iddetalle_clasificacion_qr" => $rptaClasi[0]["iddetalle_clasificacion_qr"],
									"estado" => 0);
			$rptaClasiUpdate = ControladorDClasificacionQR::ctrActualizarDClasificacionQR("iddetalle_clasificacion_qr",$datosUpdateClasi);
		}
		
		if ($rpta) {

			/*=======================================================================================
			=            NOTIFICACIÓN POR CORREO QUE SE APROBADO EL ARCHIVO CAUSA RAIZ            =
			=======================================================================================*/
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->CharSet = 'UTF-8';
			$mail->SMTPSecure = 'tls';
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
			$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
			$mail->Password = "Didacta_123"; // Contraseña
			$mail->Port = 587; // Puerto a utilizar
			$mail->FromName = "Douglas Borbor";
			$mail->isHTML(true);
			// if ($this->_estado_analisi == "REVISAR") {
			// 	$textoEmail = "ha solicitado revisar nuevamente";
			// }else{
			// 	$textoEmail = "ha generado la re-clasificación8";
			// }
			$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
$rpta = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$this->_idsolicitudes_qr);			
			$body = 'Hola,<br><br>
Es necesario que revises el análisis y/o las acciones establecidas para la atención de la queja/reclamo correspondiente al ticket:<br>
<strong style="font-size:20pt;">'.$rpta["codigoSolicitud"].'</strong><br>
Recuerda que tienes 24 horas como máximo para la revisión y ajuste requerido. Tu atención oportuna mejorará la experiencia de servicio de nuestros clientes.<br><br>
						<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
			<span style="color:#009B3A;font-family:Verdana,sans-serif;">Ecuador | Km 22, vía Daule –Guayaquil </span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;text-autospace:none;">
			<span lang="ES" style="font-size:10.0pt; font-family:Ebrima; color:#009B3A">Pbx: (593) 0997410389 | Cel: (593) 0996047252</span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#F29104;font-family:UniviaPro-Bold;"><a href="http://www.ransa.net/" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="0"><span style="color:#F29104;">www.ransa.net</span></a></span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
			<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">A continuación el enlace en el que puedes registrar las oportunidades de mejora detectadas en nuestros procesos.</span><span style="color:#009A3F;font-size:10.5pt;font-family:Verdana,sans-serif;">
			</span><b><span style="color:#00B050;font-family:Verdana,sans-serif;"><a href="https://nam02.safelinks.protection.outlook.com/?url=https%3A%2F%2Fforms.office.com%2FPages%2FResponsePage.aspx%3Fid%3DQvsmVyaEd0WZZPE6Yq1euTuPErwV14pGkYOMUiCUOltUQlhKN0ExMFJLMUNXTTEwN0QzTVMxWFcwRC4u&amp;data=04%7C01%7CDBorborP%40ransa.net%7C433c12c9c3b941e1da0f08d8ada0b382%7C5726fb42842645779964f13a62ad5eb9%7C0%7C0%7C637450253002340063%7CUnknown%7CTWFpbGZsb3d8eyJWIjoiMC4wLjAwMDAiLCJQIjoiV2luMzIiLCJBTiI6Ik1haWwiLCJXVCI6Mn0%3D%7C1000&amp;sdata=x7bsp0cvihFHT1o1BUzMCD8p90XDJhHQYPJnkA1%2FhO4%3D&amp;reserved=0" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" data-linkindex="1">Ingresa
			Aquí</a></span></b><b><span style="color:#002060;font-size:10.5pt;font-family:Verdana,sans-serif;"></span></b></p>';
			/*============================================================================
			=            CONSULTAMOS LOS USUARIOS QUE SON DEL NEGOCIO RESPONSABLE          =
			============================================================================*/
			
			$responsables = json_decode($rpta["idusuarioresponsable"]);

			for ($i=0; $i < count($responsables) ; $i++) {
				$rptauser = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$responsables[$i]);
				$mail->addAddress($rptauser["email"]);	
			}
			$mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
			if ($this->_estado_analisi == "REVISAR") {
				$mail->Subject = 'NOTIFICACIÓN [ANÁLISIS REVERSADO]';
			}else{

				$mail->Subject = 'NOTIFICACIÓN [ANÁLISIS RE-CLASIFICADO]';
			}
			
			$mail->Body    = $body;
			$envios = $mail->send();
			if ($envios) {
				echo 1;
			}
		}	

	}
	/*====================================================
	=            ENVIO DE REPUESTA AL CLIENTE            =
	====================================================*/
	public function ajaxEnviarRespCliente(){
		/*=======================================================================================
		=            NOTIFICACIÓN POR CORREO AL CLIENTE            =
		=======================================================================================*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = $_SESSION['email']; // Correo completo a utilizar
		$mail->Password = $this->_password; // Contraseña
		// $mail->Username = 'proyectosecuador@ransa.net'; // Correo completo a utilizar
		// $mail->Password = 'Didacta_123'; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		// $mail->FromName = "Douglas Borbor";
		$mail->isHTML(true);
		$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
		$body = $this->_textoCorreo.'<br><br>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Reforzamos nuestro compromiso de mejorar tu experiencia de servicio y agradecemos la confianza depositada en nosotros.</span></p>';
		/*============================================================================
		=            CONSULTAMOS LOS USUARIOS QUE SON DEL AREA DE CALIDAD          =
		============================================================================*/
		$rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");
		for ($i=0; $i < count($rptaUsuarios) ; $i++) { // Recorremos todos los usuarios 
			$modulos = json_decode($rptaUsuarios[$i]["idmodulos"],true);
			for ($j=0; $j < count($modulos) ; $j++) {
				$rptaArea = ControladorAreas::ctrConsultarAreas("idarea",$rptaUsuarios[$i]["idareas"]);
				if ($modulos[$j]["idmodulos_portal"] == 8 && $rptaUsuarios[$i]["estado"] == 1 && $rptaArea["nombre"] == "CALIDAD" ) {
					$mail->addAddress($rptaUsuarios[$i]["email"]);
				}
			}
		}
		/*==================================================================================================
		=            CORREOS QUE SE REGISTRARON AL INICIO DE LA NOVEDAD REPORTADA Y ADICIONALES            =
		==================================================================================================*/
		$correosNoti = json_decode($this->_correoNoti);

		for ($i=0; $i < count($correosNoti) ; $i++) { 
			$mail->addAddress($correosNoti[$i]);
		}
		
		$mail->setFrom($_SESSION['email'], 'RANSA');
		// $mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
		$mail->Subject = $this->_asunto;
		$mail->Body    = $body;
		$envios = $mail->send();
		if ($envios) {
			/* MODIFICAMOS EL ESTADO DE LA SOLICITUD */
			$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
							"estado" => 5);
			$rptaSolicitud = ControladorSolQR::ctrActualizarSolQR("idsolicitudes_qr",$datos);
			/* ALMACENAMOS EN LA BASE DE DATOS */
				$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
								"idusuario" => $_SESSION['id'],
								"text_respuesta" => $this->_textoCorreo,
								"notificadoa" => $this->_correoNoti);
			$rptaRespuesta = ControladorDRespuestaClienteQR::ctrInsertarDRespuestaClienteQR($datos);

			if ($rptaRespuesta && $rptaSolicitud) {
				echo 1;
			}else{
				echo "No se almaceno en la base de datos";
			}
			
		}else{
			echo "Correo No Enviado";
		}

	}
	/*=========================================================================
	=            REGISTRAR EL SEGUIMIENTO QUE SE DA A LA SOLICITUD            =
	=========================================================================*/
	public function ajaxSeguimientoSol(){
		/*=======================================================================================
		=            NOTIFICACIÓN POR CORREO DEL SEGUIMIENTO            =
		=======================================================================================*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = 'proyectosecuador@ransa.net'; // Correo completo a utilizar
		$mail->Password = 'Didacta_123'; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		// $mail->FromName = "Douglas Borbor";
		$mail->isHTML(true);
		$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
		$rptaArea = ControladorAreas::ctrConsultarAreas("idarea",$_SESSION["area"]);
		if ($rptaArea["nombre"] == "CALIDAD") {
				$body = 'Estimad@s,<br>Se notifica que se ha cargado la observación del seguimiento que ha dado el area de Calidad<br><br>Observaciones:'.$this->_observaciones.'<br><br>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Reforzamos nuestro compromiso de mejorar tu experiencia de servicio y agradecemos la confianza depositada en nosotros.</span></p>';
		}else{
				$body = 'Estimad@s,<br>Se notifica que se ha cargado la observación del seguimiento realizado con el cliente en conjunto con el area de negocio.<br><br><strong>Observaciones:</strong><br><br>'.$this->_observaciones.'<br><br>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Reforzamos nuestro compromiso de mejorar tu experiencia de servicio y agradecemos la confianza depositada en nosotros.</span></p>';
		}

		/*============================================================================
		=            CONSULTAMOS LOS USUARIOS QUE SON DEL AREA DE CALIDAD          =
		============================================================================*/
		$rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");
		for ($i=0; $i < count($rptaUsuarios) ; $i++) { // Recorremos todos los usuarios 
			$modulos = json_decode($rptaUsuarios[$i]["idmodulos"],true);
			for ($j=0; $j < count($modulos) ; $j++) {
				$rptaAreas = ControladorAreas::ctrConsultarAreas("idarea",$rptaUsuarios[$i]["idareas"]);
				if ($modulos[$j]["idmodulos_portal"] == 8 && $rptaUsuarios[$i]["estado"] == 1 && $rptaAreas["nombre"] == "CALIDAD" ) {
					$mail->addAddress($rptaUsuarios[$i]["email"]);
				}
			}
		}
		/*============================================================================================
		=            CONSULTAMOS AL USUARIO DE NEGOCIO QUE SE ASIGNO PARA DAR SEGUIMIENTO            =
		============================================================================================*/
		$rptaClasi = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
		$rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaClasi[0]["idusuario_negocio"]);
		$mail->addAddress($rptaUsuarios["email"]);

		
		$mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
		$mail->Subject = "NOTIFICACIÓN [VERIFICACIÓN DE SEGUIMIENTO]";
		$mail->Body    = $body;
		$envios = $mail->send();
		if ($envios) {
			/* ALMACENAMOS EN LA BASE DE DATOS */

				$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
								"idusuario" => $_SESSION['id'],
								"observaciones" => $this->_observaciones,
								"tipo_seguimiento" => $rptaArea["nombre"]);

			$rptaSeguimiento = ControladorDSeguimientoQR::ctrInsertarDSeguimientoQR($datos);

			if ($rptaSeguimiento) {
				echo 1;
			}else{
				echo "No se almaceno en la base de datos";
			}
			
		}else{
			echo "Correo No Enviado";
		}

	}
	/*=======================================================
	=            REGISTRAR NEGOCIACION REALIZADA            =
	=======================================================*/
	public function ajaxRegistrarNegociacion(){
		/*=======================================================================================
		=            NOTIFICACIÓN POR CORREO DE LA NEGOCIACION REALIZADA            =
		=======================================================================================*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = 'proyectosecuador@ransa.net'; // Correo completo a utilizar
		$mail->Password = 'Didacta_123'; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		// $mail->FromName = "Douglas Borbor";
		$mail->isHTML(true);
		$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
		$body = 'Estimad@s,<br>Se notifica que se ha cargado la Negociacion Realizada con las siguientes observaciones<br><br>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Reforzamos nuestro compromiso de mejorar tu experiencia de servicio y agradecemos la confianza depositada en nosotros.</span></p>';
		/*============================================================================
		=            CONSULTAMOS LOS USUARIOS QUE SON DEL AREA DE CALIDAD          =
		============================================================================*/
		$rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");
		for ($i=0; $i < count($rptaUsuarios) ; $i++) { // Recorremos todos los usuarios 
			$modulos = json_decode($rptaUsuarios[$i]["idmodulos"],true);
			for ($j=0; $j < count($modulos) ; $j++) {
				$rptaArea = ControladorAreas::ctrConsultarAreas("idarea",$rptaUsuarios[$i]["idareas"]);
				if ($modulos[$j]["idmodulos_portal"] == 8 && $rptaUsuarios[$i]["estado"] == 1 && $rptaArea["nombre"] == "CALIDAD" ) {
					$mail->addAddress($rptaUsuarios[$i]["email"]);
				}
			}
		}
		/*============================================================================================
		=            CONSULTAMOS AL USUARIO DE NEGOCIO QUE SE ASIGNO PARA DAR SEGUIMIENTO            =
		============================================================================================*/
		$rptaClasi = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
		$rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaClasi[0]["idusuario_negocio"]);
		$mail->addAddress($rptaUsuarios["email"]);

		
		$mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
		$mail->Subject = "NOTIFICACIÓN [NEGOCIACIÓN]";
		$mail->Body    = $body;
		$envios = $mail->send();
		if ($envios) {
			/*============================================================================================
			=            PRIMERO CONSULTAMOS SI EXISTE UN SEGUIMIENTO REALIZADO ANTERIORMENTE            =
			============================================================================================*/
			// $rptaConsult = ControladorDSeguimientoQR::ctrConsultarDSeguimientoQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
			// if ($rptaConsult) {
			// 	for ($i=0; $i < count($rptaConsult); $i++) { 
					/*===================================================================================
					=            CAMBIAMOS EL ESTADO DEL SEGUIMIENTO YA SE ENVIARÁ UNA NUEVA            =
					===================================================================================*/
			// 		$datosUpdateSeguimiento = array("iddetalle_seguimiento_qr" => $rptaConsult[$i]["iddetalle_seguimiento_qr"],
			// 									"estado" => 0);
			// 		$rptaUpdateSeguimiento = ControladorDSeguimientoQR::ctrActualizarDSeguimientoQR("iddetalle_seguimiento_qr",$datosUpdateSeguimiento);
			// 	}
			// }
			/* MODIFICAMOS EL ESTADO DE LA SOLICITUD */
			$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
							"estado" => 6);
			$rptaSolicitud = ControladorSolQR::ctrActualizarSolQR("idsolicitudes_qr",$datos);					
			/* ALMACENAMOS EN LA BASE DE DATOS */
				$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
								"observaciones" => $this->_observaciones,
								"idusuario" => $_SESSION['id']);
			$rptaSeguimiento = ControladorDNegociacionQR::ctrInsertarDNegociacionQR($datos);

			if ($rptaSeguimiento) {
				echo 1;
			}else{
				echo "No se almaceno en la base de datos";
			}
			
		}else{
			echo "Correo No Enviado";
		}		

	}
	/*==================================================
	=            REAPERTURA DE LA SOLICITUD            =
	==================================================*/
	public function ajaxReaperturaSol(){
		/*=======================================================================================
		=            NOTIFICACIÓN POR CORREO DEL SEGUIMIENTO            =
		=======================================================================================*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = 'proyectosecuador@ransa.net'; // Correo completo a utilizar
		$mail->Password = 'Didacta_123'; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		// $mail->FromName = "Douglas Borbor";
		$mail->isHTML(true);
		$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
				$body = 'Estimad@s,<br>Se notifica que se reapertura de la solicitud por el area de Calidad<br><br>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Reforzamos nuestro compromiso de mejorar tu experiencia de servicio y agradecemos la confianza depositada en nosotros.</span></p>';

		/*============================================================================
		=            CONSULTAMOS LOS USUARIOS QUE SON DEL AREA DE CALIDAD          =
		============================================================================*/
		$rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");
		for ($i=0; $i < count($rptaUsuarios) ; $i++) { // Recorremos todos los usuarios 
			$modulos = json_decode($rptaUsuarios[$i]["idmodulos"],true);
			for ($j=0; $j < count($modulos) ; $j++) {
				$rptaAreas = ControladorAreas::ctrConsultarAreas("idarea",$rptaUsuarios[$i]["idareas"]);
				if ($modulos[$j]["idmodulos_portal"] == 8 && $rptaUsuarios[$i]["estado"] == 1 && $rptaAreas["nombre"] == "CALIDAD" ) {
					$mail->addAddress($rptaUsuarios[$i]["email"]);
					// var_dump($rptaUsuarios[$i]["email"]);
				}
			}
		}
		/*============================================================================================
		=            CONSULTAMOS AL USUARIO DE NEGOCIO QUE SE ASIGNO PARA DAR SEGUIMIENTO            =
		============================================================================================*/
		$rptaClasi = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
		$rptaUsuariosNegocio = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaClasi[0]["idusuario_negocio"]);
		$mail->addAddress($rptaUsuariosNegocio["email"]);

		/*==============================================================================================
		=            NOTIFICACION DE REAPERTURA DE LA SOLICITUD A LOS USUARIOS RESPONSABLES            =
		==============================================================================================*/
		// $rptaClasi = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
		// $rpta = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
		$responsables = json_decode($rptaClasi[0]["idusuarios_responsables"]);

		for ($i=0; $i < count($responsables) ; $i++) {
			$rptauser = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$responsables[$i]);
			$mail->addAddress($rptauser["email"]);	
		}
		
		
		$mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
		$mail->Subject = "NOTIFICACIÓN [REAPERTURA DE LA SOLICITUD]";
		$mail->Body    = $body;
		$envios = $mail->send();
		// $envios = "asdj";
		if ($envios) {
			/* CONSULTAMOS LA SOLICITUD */
			$rptaConsultaSolicitud = ControladorSolQR::ctrConsultarSolQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
				/*===============================================================
				=            ACTUALIZACION DE ESTADO DE LA SOLICITUD            =
				===============================================================*/
				/* MODIFICAMOS EL ESTADO DE LA SOLICITUD */
				$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
								"estado" => 2);
				$rptaSolicitud = ControladorSolQR::ctrActualizarSolQR("idsolicitudes_qr",$datos);
				/* ACTUALIZAMOS EL ESTADO DE LA INVESTIGACION */
				$datosUpdate = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
								"estado" => 0);
				$rptaUpdateInvestigacion = ControladorDInvestigacionQR::ctrActualizarDInvestigacionQR("idsolicitudes_qr",$datosUpdate);
				/* ACTUALIZAMOS LA RESPUESTA AL CLIENTE */
				$rptaRespuestCliente = ControladorDRespuestaClienteQR::ctrActualizarDRespuestaClienteQR("idsolicitudes_qr",$datosUpdate);
				if ($rptaConsultaSolicitud["tipo_novedad"] == "Reclamo") {
					/* ACTUALIZAMOS LA NEGOCIACION REALIZADA ANTERIORMENTE */
					$rptaNegociacion = ControladorDNegociacionQR::ctrActualizarDNegociacionQR("idsolicitudes_qr",$datosUpdate);
				}
				/* ACTUALIZAMOS LOS ULTIMOS SEGUIMIENTOS POR EL AREA DE CALIDAD Y NEGOCIO */
				$rptaSeguimiento = ControladorDSeguimientoQR::ctrActualizarDSeguimientoQR("idsolicitudes_qr",$datosUpdate);
				/*===============================================================
				=            INGRESAMOS EL SEGUIMIENTO DE REAPERTURA            =
				===============================================================*/
				$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
								"idusuario" => $_SESSION['id'],
								"observaciones" => null,
								"tipo_seguimiento" => "REAPERTURA");
			$rptaSeguimiento = ControladorDSeguimientoQR::ctrInsertarDSeguimientoQR($datos);
			if ($rptaSeguimiento) {
				echo 1;
			}else{
				echo "No se almaceno en la base de datos";
			}
			
		}else{
			echo "Correo No Enviado";
		}

	}	
	/*==========================================================
	=            CIERRE DEL PROCESO DE LA SOLICITUD            =
	==========================================================*/
	public function ajaxCerrarSol(){
		/*=======================================================================================
		=            NOTIFICACIÓN POR CORREO DEL SEGUIMIENTO            =
		=======================================================================================*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'tls';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = 'proyectosecuador@ransa.net'; // Correo completo a utilizar
		$mail->Password = 'Didacta_123'; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		// $mail->FromName = "Douglas Borbor";
		$mail->isHTML(true);
		$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
				$body = 'Estimad@s,<br>Se notifica que se cerrado la solicitud por el area de Calidad<br><br>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#1F497D;"><img src="cid:logo_ransa" id="x_Imagen_x0020_3" style="width: 137.24pt; height: 35.24pt; cursor: pointer;" crossorigin="use-credentials"></span><span style="color:#1F497D;font-family:Cambria,serif;"></span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Queremos mejorar tu experiencia al recibir nuestros servicios. </span></p>
		<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#009A3F;font-size:10pt;font-family:Verdana,sans-serif;">Reforzamos nuestro compromiso de mejorar tu experiencia de servicio y agradecemos la confianza depositada en nosotros.</span></p>';

		/*============================================================================
		=            CONSULTAMOS LOS USUARIOS QUE SON DEL AREA DE CALIDAD          =
		============================================================================*/
		$rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");
		for ($i=0; $i < count($rptaUsuarios) ; $i++) { // Recorremos todos los usuarios 
			$modulos = json_decode($rptaUsuarios[$i]["idmodulos"],true);
			for ($j=0; $j < count($modulos) ; $j++) {
				$rptaAreas = ControladorAreas::ctrConsultarAreas("idarea",$rptaUsuarios[$i]["idareas"]);
				if ($modulos[$j]["idmodulos_portal"] == 8 && $rptaUsuarios[$i]["estado"] == 1 && $rptaAreas["nombre"] == "CALIDAD" ) {
					$mail->addAddress($rptaUsuarios[$i]["email"]);
				}
			}
		}
		/*============================================================================================
		=            CONSULTAMOS AL USUARIO DE NEGOCIO QUE SE ASIGNO PARA DAR SEGUIMIENTO            =
		============================================================================================*/
		$rptaClasi = ControladorDClasificacionQR::ctrConsultarDClasificacionQR("idsolicitudes_qr",$this->_idsolicitudes_qr);
		$rptaUsuariosNegocio = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaClasi[0]["idusuario_negocio"]);
		$mail->addAddress($rptaUsuariosNegocio["email"]);
		/*==============================================================================================
		=            NOTIFICACION DE REAPERTURA DE LA SOLICITUD A LOS USUARIOS RESPONSABLES            =
		==============================================================================================*/
		$responsables = json_decode($rptaClasi[0]["idusuarios_responsables"]);

		for ($i=0; $i < count($responsables) ; $i++) {
			$rptauser = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$responsables[$i]);
			$mail->addAddress($rptauser["email"]);	
		}

		$mail->setFrom('proyectosecuador@ransa.net', 'RANSA');
		$mail->Subject = "NOTIFICACIÓN [SOLICITUD CERRADA]";
		$mail->Body    = $body;
		$envios = $mail->send();
		if ($envios) {
			/* CAMBIAMOS EL ESTADO DE LA SOLICITUD */
				$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
								"estado" => 7);
				$rptaSolicitud = ControladorSolQR::ctrActualizarSolQR("idsolicitudes_qr",$datos);
				/*===============================================================
				=            INGRESAMOS EL SEGUIMIENTO DE CERRADO            =
				===============================================================*/
				$datos = array("idsolicitudes_qr" => $this->_idsolicitudes_qr,
								"idusuario" => $_SESSION['id'],
								"observaciones" => null,
								"tipo_seguimiento" => "CIERRE");
			$rptaSeguimiento = ControladorDSeguimientoQR::ctrInsertarDSeguimientoQR($datos);
			if ($rptaSeguimiento) {
				echo 1;
			}else{
				echo "No se almaceno en la base de datos";
			}
			
		}else{
			echo "Correo No Enviado";
		}

	}	
}
/*=======================================================================
=            NOTIFICACION DE USUARIOS QUE SE VA A CLASIFICAR            =
=======================================================================*/
if (isset($_POST['idusuariosnoti'])) {
	$NotificaNegocio = new AjaxSolQR();
	$NotificaNegocio -> _idusuarios = $_POST['idusuariosnoti'];
	$NotificaNegocio -> _idsolicitudes_qr = $_POST['idsolicitudes_qr'];
	$NotificaNegocio -> _NegocioAsignado = $_POST['iduserNegocioAsig'];
	
	
	$NotificaNegocio -> ajaxNotificarNegocioResponsable();
}
if (isset($_POST['RespuestaestadoAnalisis'])) {
	$envioCR = new AjaxSolQR();
	$envioCR -> _archCR = isset($_FILES['filecr']) ? $_FILES['filecr'] : $_POST['filecr'];
	// $envioCR -> _comentariocr = isset($_POST['coment']) ? $_POST['coment'] : null;
	$envioCR -> _motivo_causar = isset($_POST['motivo']) ? $_POST['motivo'] : null;
	$envioCR -> _idsolicitudes_qr = $_POST['idSolQRCausa'];
	$envioCR -> _estado_analisi = $_POST["RespuestaestadoAnalisis"];
	
	$envioCR -> ajaxNotificarCausaRaiz();
}
/*=====================================================
=            APROBAR EL ANÁLISIS REALIZADO            =
=====================================================*/
if (isset($_POST["idSolQRCausaAprobar"])) {
	$aprobaranalisis = new AjaxSolQR();
	$aprobaranalisis -> _idsolicitudes_qr = $_POST['idSolQRCausaAprobar'];
	$aprobaranalisis -> ajaxAprobarAnalisis();
}

/*=========================================
=            CONSULTA POPOVER             =
=========================================*/
if (isset($_POST['popovercodigo'])) {
	$popover = new AjaxSolQR();
	$popover -> _codigo = $_POST['popovercodigo'];
	$popover -> ajaxPopover();
}
/*============================================================
=            DATOS PARA ENVIAR CORREO ELECTRONICO            =
============================================================*/
if (isset($_POST["idmensajeEmail"])) {
	$popover = new AjaxSolQR();
	$popover -> _idsolicitudes_qr = $_POST['idmensajeEmail'];
	$popover -> ajaxPopover();
}
/*=================================================================
=            NOTIFICAR NUEVAMENTE REVISAR LA SOLICITUD            =
=================================================================*/
if (isset($_POST["idSolQRRevisar"])) {
	$notifRevisar = new AjaxSolQR();
	$notifRevisar -> _idsolicitudes_qr = $_POST['idSolQRRevisar'];
	$notifRevisar -> _motivo_causar = $_POST['motivobloq'];
	$notifRevisar -> _estado_analisi = $_POST['estado_analisis'];
	// $notifRevisar -> _idDetalleInvesti = $_POST['idDetalleInvesti'];


	$notifRevisar -> ajaxNotificarRevisar();
}
/*===================================================
=            ENVIAR RESPUESTA AL CLIENTE            =
===================================================*/
if (isset($_POST['idRespuestaCliente'])) {
	$repuestaCli = new AjaxSolQR();
	$repuestaCli -> _idsolicitudes_qr = $_POST["idRespuestaCliente"];
	$repuestaCli -> _textoCorreo = $_POST["cuerpoCorreo"];
	$repuestaCli -> _correoNoti = $_POST["correosNoti"];
	$repuestaCli -> _password = $_POST["password"];
	$repuestaCli -> _asunto = $_POST["subject"];
	$repuestaCli -> ajaxEnviarRespCliente();
}
/*===================================================
=            GUARDAR EL SEGUIMIENTO DADO            =
===================================================*/
if (isset($_POST['idSeguimiento'])) {
	$seguimiento = new AjaxSolQR();
	$seguimiento -> _idsolicitudes_qr = $_POST['idSeguimiento'];
	$seguimiento -> _observaciones = $_POST['observaciones'];
	$seguimiento -> ajaxSeguimientoSol();

}
/*=======================================================
=            REGISTRAR NEGOCIACION REALIZADA            =
=======================================================*/
if (isset($_POST["idNegociacion"])) {
	$negociacion = new AjaxSolQR();
	$negociacion -> _idsolicitudes_qr = $_POST['idNegociacion'];
	$negociacion -> _observaciones = $_POST['observaciones'];
	$negociacion -> ajaxRegistrarNegociacion();
}
/*==================================================
=            REAPERTURA DE LA SOLICITUD            =
==================================================*/
if (isset($_POST['idReapertura'])) {
	$reaperturaSol = new AjaxSolQR();
	$reaperturaSol -> _idsolicitudes_qr = $_POST['idReapertura'];
	// $reaperturaSol -> _observaciones = $_POST['observaciones'];
	$reaperturaSol -> ajaxReaperturaSol();
}
/*===========================================
=            CERRAR LA SOLICITUD            =
===========================================*/
if (isset($_POST['idCierreSolicitud'])) {
	$cerrarSol = new AjaxSolQR();
	$cerrarSol -> _idsolicitudes_qr = $_POST['idCierreSolicitud'];
	$cerrarSol -> ajaxCerrarSol();
}


















