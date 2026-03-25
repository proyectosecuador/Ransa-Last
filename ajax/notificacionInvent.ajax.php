<?php
use  PHPMailer \ PHPMailer \ PHPMailer ; 
use  PHPMailer \ PHPMailer \ Exception ;
session_start();

require_once '../extensiones/PHPMailer/PHPMailer/src/Exception.php';
require_once '../extensiones/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once '../extensiones/PHPMailer/PHPMailer/src/SMTP.php';
require_once '../controladores/clientes.controlador.php';
require_once '../modelos/clientes.modelo.php';
require_once '../controladores/archivos.controlador.php';
require_once '../modelos/archivos.modelo.php';
require_once "../modelos/rutas.php";

require_once  "../extensiones/PHPMailer/vendor/autoload.php";
class AjaxNotficacionInvent{
	/*=====  VARIABLES GLOBALES  ======*/
	public $correos;
	public $tabla;
	public $grupo;
	public $totalGeneral;
	public $codigo_inv;
	public $nombre_archivo;
	public $id;
	public $estado;
	public $nombreencriptado;
	

	/*=====  NOTIFICAR AL CLIENTE   ======*/
	function ajaxNotficarCliente(){
		$url = Ruta::ctrRuta();//ruta de pagina para enviar boton de confirmación por correo
		$nombreencript = md5($this->codigo_inv);

		/*=====  CONSULTA DEL CLIENTE SEGUN EL CODIGO PARA COLOCAR EN ASUNTO DEL CORREO  ======*/
	    $itemcliente = "codigoransa";
	    $valorcliente = $this->codigo_inv;
	    $rptaCuenta =  ControladorClientes::ctrmostrarClientes($itemcliente,$valorcliente);
	    date_default_timezone_set('America/Bogota');

	    $tabla_info = json_decode($this->tabla,true);
	    $column4 = array_column($tabla_info,4);//columna Grupo
	    $column2 = array_column($tabla_info,2);//columna Tipo_ubicacion
	   	/*=====  OBTENER LOS TIPO DE UBICACION  ======*/
	    $tipo_ubicacion = array_values(array_unique(array_column($tabla_info, 2)));
	    /*====================================================================
	    =            FUNCION PARA OBTENER LAS VECES QUE SE REPITE            =
	    ====================================================================*/
	    function contarValoresArray($array){
			$contar=array();
			for ($i=0; $i < count($array) ; $i++) {
				if (!isset($contar[$array[$i][4]."-".$array[$i][2]])) {
					$contar[$array[$i][4]."-".$array[$i][2]] = 1;
				}else{
					$contar[$array[$i][4]."-".$array[$i][2]]++;
				}
			}
			return $contar;
		}
		/*==========================================================================================
		=            FUNCION PARA CALCULAR LOS VALORES DE SALDOS X FACTOR DE CONVERSION            =
		==========================================================================================*/
	    function calculoValoresArray($array){
			$contar=array();
			for ($i=0; $i < count($array) ; $i++) {
				if (!isset($contar[$array[$i][4]])) {
					/*=====  PRIMERO ELIMINAMOS LA COMA Y LUEGO CAMBIAMOS EL PUNTO POR COMA  ======*/
					$sincomaSaldo = str_replace(",", "", $array[$i][10]);//eliminamos las comas saldo
					$sincomaFC = str_replace(",", "", $array[$i][9]);
					$rppunt_comaSaldo = str_replace(".", ",", $sincomaSaldo);//saldo
					$rppunt_comaFC = str_replace(".", ",", $sincomaFC);//FC
					/*=====  CONVERTIMOS VALOR A FLOAT  ======*/
					
					$valorfloat = floatval($rppunt_comaSaldo);
					$conversion = floatval($rppunt_comaFC);
					if ($conversion == 0 || $conversion < 0) {
						$total = $valorfloat/1;
					}else{
						$total = $valorfloat/$conversion;
					}
					

					$contar[$array[$i][4]] = $total;
				}else{
					/*=====  PRIMERO ELIMINAMOS LA COMA Y LUEGO CAMBIAMOS EL PUNTO POR COMA  ======*/
					$sincomaSaldo = str_replace(",", "", $array[$i][10]);//eliminamos las comas saldo
					$sincomaFC = str_replace(",", "", $array[$i][9]);
					$rppunt_comaSaldo = str_replace(".", ",", $sincomaSaldo);//saldo
					$rppunt_comaFC = str_replace(".", ",", $sincomaFC);//FC
					/*=====  CONVERTIMOS VALOR A FLOAT  ======*/
					$valorfloat = floatval($rppunt_comaSaldo);
					$conversion = floatval($rppunt_comaFC);
					if ($conversion == 0 || $conversion < 0) {
						$total = $valorfloat/1;
					}else{
						$total = $valorfloat/$conversion;
					}
					$contar[$array[$i][4]] += $total;
				}
			}
			return $contar;
		}
		
		$tbulto = calculoValoresArray($tabla_info);
	    /*=======================================================
	    =            RECORRER LOS GRUPOS DE LA TABLA            =
	    =======================================================*/
	    $grupos = json_decode($this->grupo);
	    /*=====  ORDENAR EL ARRAY DE MENOR A MAYOR (ASORT())  ======*/
	    asort($grupos);
	    $total_general = array_count_values($column4);
	    $total_tipoubi = array_count_values($column2);
	    //print_r($tabla_info);
	    /*=====  VALORES DE INMOVILIZADO Y PICKING BULTO  ======*/
	    $inm_pick = contarValoresArray($tabla_info);
		/*========================================================================
		=            CREAMOS INSTANCIA PARA ENVIAR CORREO ELECTRONICO            =
		========================================================================*/
		
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'STARTTLS';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = "smontenegrot@bposgromero.onmicrosoft.com"; // Correo completo a utilizar
		$mail->Password = "Sm0951353267"; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		$mail->From = "smontenegrot@bposgromero.onmicrosoft.com"; // Desde donde enviamos (Para mostrar)
		$mail->FromName = "NOVEDADES RANSA";
		//$mail->addEmbeddedImage("../vistas/img/iconos/Mesa-de-trabajo-53.png","montacarga","Mesa-de-trabajo-53.png");	
		$mail->isHTML(true);	
		//$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
		$body = '<!DOCTYPE html>
<html >
<head>
		<meta charset="UTF-8">
	<title></title>
</head>
<body>
<div><div>
<div lang="es-EC" link="blue" vlink="purple" style="word-wrap:break-word;">
<div>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span>Estimados,</span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span>&nbsp;</span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span> Se detalla reporte de inventario actualizado.</span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span>&nbsp;</span></p>
<table border="0" cellspacing="0" cellpadding="0" style="width:649.6pt;border-collapse:collapse;">
<tbody><tr style="height:15.75pt;">
<td valign="bottom" nowrap="" style="background-color:#C0504D;width:107.8pt;height:15.75pt;padding:0 3.5pt;border-style:solid none none none;border-top-width:1pt;border-top-color:#963634;">
</td>
<td nowrap="" style="background-color:#C0504D;width:95.8pt;height:15.75pt;padding:0 3.5pt;border-style:solid none none none;border-top-width:1pt;border-top-color:#963634;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:white;">Valores</span></b></p>
</td>
<td nowrap="" style="background-color:#C0504D;width:91.8pt;height:15.75pt;padding:0 3.5pt;border-style:solid none none none;border-top-width:1pt;border-top-color:#963634;">
</td>';
switch ($this->codigo_inv) {
	case 740:
		$body .='<td nowrap="" style="background-color:#C0504D;width:91.8pt;height:15.75pt;padding:0 3.5pt;border-style:solid none none none;border-top-width:1pt;border-top-color:#963634;">
			</td>';
		break;
	case 857:

		break;	
	
	default:
		# code...
		break;
}

$body .= '<td nowrap="" style="background-color:#C0504D;width:91.8pt;height:15.75pt;padding:0 3.5pt;border-style:solid none none none;border-top-width:1pt;border-top-color:#963634;">
</td>
<td nowrap="" style="background-color:#C0504D;width:91.8pt;height:15.75pt;padding:0 3.5pt;border-style:solid none none none;border-top-width:1pt;border-top-color:#963634;">
</td>
</tr>
<tr style="height:15pt;">
<td valign="bottom" nowrap="" style="background-color:#C0504D;width:107.8pt;height:15pt;padding:0 3.5pt;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><b><span style="color:white;">Grupo</span></b></p>
</td>';
for ($i=0; $i < count($tipo_ubicacion) ; $i++) { 
	$body .= '<td nowrap="" style="background-color:#C0504D;width:95.8pt;height:15pt;padding:0 3.5pt;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:white;">'.$tipo_ubicacion[$i].'</span></b></p>
</td>';
}
$body .= '
<td nowrap="" style="background-color:#C0504D;width:91.8pt;height:15pt;padding:0 3.5pt;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:white;">Total general.</span></b></p>
</td>';
switch ($this->codigo_inv) {
	case 740:
		$body .='<td nowrap="" style="background-color:#C0504D;width:91.8pt;height:15pt;padding:0 3.5pt;">
				<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
				<b><span style="color:white;">T. BULTOS.</span></b></p>
				</td>';
		break;
	case 857:

		break;	
	
	default:
		# code...
		break;
}

$body .= '<td valign="bottom" nowrap="" style="background-color:#C0504D;width:78.8pt;height:15pt;padding:0 3.5pt;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><b><span style="color:white;">FECHA</span></b></p>
</td>
</tr>';
/*=============================================
=            RECORREMOS LOS GRUPOS            =
=============================================*/
foreach ($grupos as $key => $value) {
$body .='
<tr style="height:15pt;">
<td valign="bottom" nowrap="" style="width:107.8pt;height:15pt;padding:0 3.5pt;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:black;">'.$value.'</span></p>
</td>';

for ($i=0; $i < count($tipo_ubicacion) ; $i++) { 
	$body .='<td nowrap="" style="width:95.8pt;height:15pt;padding:0 3.5pt;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<span style="color:black;">';
	if (isset($inm_pick[$value."-".$tipo_ubicacion[$i]])) {
		$body .= $inm_pick[$value."-".$tipo_ubicacion[$i]];
	}else{

	}
	$body .= '</span></p>
	</td>';
}
$body .= '<td nowrap="" style="width:91.8pt;height:15pt;padding:0 3.5pt;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<span style="color:black;">'.$total_general[$value].'</span></p>
</td>';
switch ($this->codigo_inv) {
	case 740:
		$body.='<td nowrap="" style="width:91.8pt;height:15pt;padding:0 3.5pt;">
		<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
		<span style="color:black;">'.number_format($tbulto[$value],2,",",".").'</span></p>
		</td>';
		break;
	case 857:

		break;	
	
	default:
		# code...
		break;
}

$body .= '<td valign="bottom" nowrap="" style="width:78.8pt;height:15pt;padding:0 3.5pt;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;">
<span style="color:black;">'.date("Y-m-d").'</span></p>
</td>
</tr>';	    	
}
$body .='
<tr style="height:15pt;">
<td valign="bottom" nowrap="" style="width:107.8pt;height:15pt;padding:0 3.5pt;border-style:solid none;border-top-width:1pt;border-bottom-width:1pt;border-top-color:#963634;border-bottom-color:#963634;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:black;">Total general</span></b></p>
</td>';
for ($i=0; $i < count($tipo_ubicacion) ; $i++) { 
	$body .= '<td nowrap="" style="width:95.8pt;height:15pt;padding:0 3.5pt;border-style:solid none;border-top-width:1pt;border-bottom-width:1pt;border-top-color:#963634;border-bottom-color:#963634;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<b><span style="color:black;">'.number_format($total_tipoubi[$tipo_ubicacion[$i]],0,",",".").'</span></b></p>
	</td>';
}
$body .= '<td nowrap="" style="width:91.8pt;height:15pt;padding:0 3.5pt;border-style:solid none;border-top-width:1pt;border-bottom-width:1pt;border-top-color:#963634;border-bottom-color:#963634;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:black;">'.number_format(array_sum($total_general),0,",",".").'</span></b></p>
</td>';
switch ($this->codigo_inv) {
	case 740:
		$body.='<td nowrap="" style="width:91.8pt;height:15pt;padding:0 3.5pt;border-style:solid none;border-top-width:1pt;border-bottom-width:1pt;border-top-color:#963634;border-bottom-color:#963634;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:black;">'.number_format(array_sum($tbulto),2,",",".").'</span></b></p>
</td>';
		break;
	case 857:

		break;	
	
	default:
		# code...
		break;
}
$body .= '<td nowrap="" style="width:91.8pt;height:15pt;padding:0 3.5pt;border-style:solid none;border-top-width:1pt;border-bottom-width:1pt;border-top-color:#963634;border-bottom-color:#963634;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:black;"></span></b></p>
</td>
</tr>
</tbody></table>
<div>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span>&nbsp;</span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span>Una vez revisada la información es necesario su aprobación a través de la plataforma, para ingresar haga clic sobre el boton</p>	
</div>
<table border="0" width="100%" cellspacing="0" cellpadding="0" style="border-collapse:collapse"><tbody><tr><td style="border-collapse:collapse; border-radius:4px; text-align:center; display:block; background:#1479FB; padding:14px 16px 14px 16px"><a href="'.$url."confirmarInvent/".$nombreencript.'" target="_blank" rel="noopener noreferrer" data-auth="NotApplicable" style="color:#3b5998; text-decoration:none; display:block"><center><font size="3"><span style="white-space:nowrap; font-weight:bold; vertical-align:middle; font-weight:bold; font-size:16px; color:#FFFFFF">Ingresar&nbsp;al&nbsp;Sistema</span></font></center></a></td></tr></tbody></table>
</div>
</div>
</div>
</div>	

</body>
</html>';
		 //Recipients
	    $mail->setFrom('smontenegrot@bposgromero.onmicrosoft.com', 'NOVEDADES RANSA');

		$mail->addAddress($_SESSION["email"]);     // Add a recipient
		/*=====  CORREOS DE LOS CLIENTES QUE SE ENVIARÁ NOTIFICACIÓN  ======*/
		$correosClientes = json_decode($this->correos);

	    for ($i=0; $i < count($correosClientes) ; $i++) {
	    	$mail->addAddress($correosClientes[$i]);     // Add a recipient	
	    }

	    $mail->Subject = 'RANSA INV'.$rptaCuenta["razonsocial"]." ".date("Y-m-d");
	    $mail->Body    = $body;
	    $envios = $mail->send();
	    if ($envios) {
	    	/*=====  ACTUALIZAMOS EN LA BASE Y SE REGISTRA EL VALOR ENCRIPTADO   ======*/
	    	$valor = array("nombre_encriptado" => $nombreencript,
							"estado_confirmacion" => 0,//el valor es 0 cuando aun no se confirma los valores por el cliente
							"nomarchivo" => $this->nombre_archivo,
							"cantidad" => intval(array_sum($total_general)));
	    	$itemactualizar = "nomarchivo";
	    	$rptaValorEncriptado = ControladorArchivos::ctrActualizarArchivo($valor,$itemactualizar);
	    	if ($rptaValorEncriptado == "ok") {
	    		echo 1;	
	    	}else{
	    		echo "No se pudo ingresar en la base de datos";
	    	}
	    	
	    }else{
	    	echo 2;
	    }
		
		
		

	}
/*================================================================
=            CONFIRMAR DESDE INGRESANDO LA PLATAFORMA            =
================================================================*/
	function ajaxConfirmarInvent(){
		$valorupdate = array("nombre_encriptado" => null,
								"estado_confirmacion" => 1,
								"nomarchivo" => $this->id);		
		$itemupdate = "id";
			
		$rpta = ControladorArchivos::ctrActualizarArchivo($valorupdate,$itemupdate);
		if ($rpta == "ok") {
			echo "ok";
		}		


	}
	
}

if (isset($_POST["noticorreos"])) {
	$notificar = new AjaxNotficacionInvent();
	$notificar -> correos = $_POST["noticorreos"];
	$notificar -> tabla = $_POST["tabla_data"];
	$notificar -> grupo = $_POST["grupo"];
	$notificar -> totalGeneral = $_POST["totalGeneral"];
	$notificar -> codigo_inv = $_POST["cod_Inv"];
	$notificar -> nombre_archivo = $_POST["nombre_archivo"];
	$notificar -> ajaxNotficarCliente();
	
}
if (isset($_POST["idConfirmar"])) {
	$confirmar = new AjaxNotficacionInvent();
	$confirmar-> id = $_POST["idConfirmar"];
	$confirmar-> estado  = $_POST["estadoConfirm"];
	$confirmar-> nombreencriptado = $_POST["nombreencriptado"];
	$confirmar-> ajaxConfirmarInvent();
}