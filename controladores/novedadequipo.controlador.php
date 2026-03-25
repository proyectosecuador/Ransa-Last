<?php
use  PHPMailer\PHPMailer\PHPMailer ; 
use  PHPMailer\PHPMailer\Exception ;

class ControladorNovedades{



/*===========================================
=            REGISTRO DE NUEVA LOCALIZACION            =
===========================================*/
public function ctrRegistroNovedades(){
	require_once "controladores/equipos.controlador.php";
	 require_once "modelos/equipos.modelo.php";

	if ($_SERVER['REQUEST_METHOD'] == "POST") {
		$idequipo = $_POST["idequipo"] ;
		$codigo = $_POST["codigoEquipo"] ;
		$descrinovedad = $_POST["descripcion_novedad"]; 
		$obsercheck = $_POST["observacionesot"];
		$horometronovedad = $_POST["horometroparalizacion"];
		$ubicacionnovedad = $_POST["ubicacionparalizacion"];
		$ideasignacion = $_POST["selectturn"];
		$ruta = "archivos/NovedadesEquipos/";
		$fechainicio = "";
					/*=====  CREAMOS LA DIRECCION EN CASO DE QUE NO EXISTA  ======*/
			if (!is_file($ruta.$codigo."/")) {
				mkdir($ruta.$codigo."/",0777);			
			}
		/*=====  VALIDAMOS SI EXISTE EL ARCHIVO  ======*/
		$imagen = false;
		if (isset($_FILES["imgnovedadequipo"]["tmp_name"]) && is_file($_FILES["imgnovedadequipo"]["tmp_name"] )) {

			$nombre = uniqid();
			$ruta_nombreimg = $ruta.$codigo."/".$nombre.".png";
			move_uploaded_file($_FILES["imgnovedadequipo"]["tmp_name"],$ruta_nombreimg);
			$imagen = true;
		}else{
			$ruta_nombreimg = null;
		}
				/*****ubicacion de Zona Horaria*****/
		date_default_timezone_set('America/Guayaquil');
		/******para presentar la fecha en español******/
		//setlocale(LC_ALL, "esp");
		setlocale(LC_TIME, "spanish");
		$fecha_actual_correo = utf8_encode(strftime("%A, %d de %B de %Y"));
		/*=====  VALIDAMOS SI NO APLICA PARALIZACION  ======*/

		if ($ubicacionnovedad == "" && $horometronovedad == "") {
			$ubicacionnovedad = null;
			$horometronovedad = null;
			$paraliza = 0;
			$text_paraliza = "NO APLICA";
			$fechainicio = null;
			$estadoEquipo = "OPERATIVO";
		}else{
			$paraliza = 1;
			$estadoequipos = 2;
			$text_paraliza = "SI APLICA";
			$fechainicio = date("Y-m-d H:i:s");
			$estadoEquipo = "INOPERATIVO";
			$datosactualizarequipo = array("idequipo" => $idequipo,
											"estado" => 2);
			$itemequipo = "idequipomc";
			$rptaactualizarestado = ControladorEquipos::ctrActualizarEquiposEstado($datosactualizarequipo,$itemequipo);
		}
		$modalidad = "NORMAL";
		$datos = array("idequipo" => $idequipo,
			"ideasignacion" => $ideasignacion,
			"descripcion" => preg_replace('[\n|\r|\n\r]','',nl2br(strtoupper($descrinovedad))),
			"observacionesot" => $obsercheck,
		        "img" => $ruta_nombreimg,
		        "paralizacion" => $paraliza,
		        "fechainicio" => $fechainicio,
		        "ubicacion_para" => strtoupper($ubicacionnovedad),
		        "modo" => $modalidad,
		        "horometro_para" => $horometronovedad);

		$tabla = "novequipos";
		$rpta = ModeloNovedades::mdlRegistroNovedad($tabla,$datos);

		/*=======================================================
		=            ACTUALIZAR EL ESTADO DEL EQUIPO            =
		=======================================================*/
		if (isset($estadoequipos)) {
		$datosactualizarequipo = array("idequipo" => $idequipo,
					"estado" =>$estadoequipos);
		$itemequipo = "idequipomc";
		$estado_de_equipo = ControladorEquipos::ctrActualizarEquiposEstado($datosactualizarequipo,$itemequipo);
			
		}
		/*=====================================================
		=            LIBRERIAS PARA ENVIAR CORREOS            =
		=====================================================*/
		require_once 'extensiones/PHPMailer/PHPMailer/src/Exception.php';
		require_once 'extensiones/PHPMailer/PHPMailer/src/PHPMailer.php';
		require_once 'extensiones/PHPMailer/PHPMailer/src/SMTP.php';

		require_once  "extensiones/PHPMailer/vendor/autoload.php";
		/*=====================================================
		=            CONSULTA DE EQUIPO MONTACARGA            =
		=====================================================*/
		$itemmontacarga = "idequipomc";
		$rptamontacarga = ControladorEquipos::ctrConsultarEquipos($idequipo,$itemmontacarga);
		/*========================================================
		=            CONSULTA DE ASIGNACION DE EQUIPO            =
		========================================================*/
		$itemasignacion = "ideasignacion";
		$rptaasignacion = ControladorEquipos::ctrConsultarAsignacionEquipos($ideasignacion,$itemasignacion);
		
		/*===========================================================================
		=            CONSULTAMOS LOS USUARIOS QUE DE DEBEN ENVIAR CORREO            =
		===========================================================================*/
		$tablausuario = "usuariosransa";
		$itemusuarios = "perfil";
		$valor = array("valor1" => "COORDINADOR",
						"valor2" => "ADMINISTRADOR");
		$rptausuarios = ControladorUsuarios::ctrMostrarUsuariosRansa($tablausuario,$itemusuarios,$valor);			
		
		
		
		
		/*================================================
		=            CONFIGURACIÓN DE CORREOS            =
		================================================*/

		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'STARTTLS';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = "smontenegrot@bposgromero.onmicrosoft.com"; // Correo completo a utilizar
		$mail->Password = "Sm0951353267"; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		//$mail->From = "douglasborbor8@gmail.com"; // Desde donde enviamos (Para mostrar)
		//$mail->FromName = "Douglas Borbor";
		$mail->isHTML(true); 
		if ($imagen) {
			$mail->addEmbeddedImage($ruta_nombreimg,"montacarga",$nombre.".png");	
		}else{
			$mail->addEmbeddedImage("vistas/img/iconos/Mesa-de-trabajo-53.png","montacarga","Mesa-de-trabajo-53.png");	
		}



		$mail->addEmbeddedImage("vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
		//$mail->addEmbeddedImage($ruta_nombreimg,"montacarga",$nombre.".png");
		
		$body = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div align="center">
		<table border="0" cellspacing="0" width="100%" style="width: 100.0%; background:#F2F2F2; border-collapse: collapse; ">
			<tbody>
				<tr>
					<td valign="top" width="100%" style="padding: 15.0pt 15.0pt 15.0pt 15.0pt">
						<div align="center">
							<table width="600" border="0" cellspacing="0" cellpadding="0" style=" background: white; width: 450pt; border-collapse: collapse;">
								<tbody>
									<tr>
										<td valign="top" style="padding: 0cm 0cm 0cm 0cm;">
											<div align="center">
												<table border="0" cellspacing="0" cellpadding="0" width="600" style="width: 450.0pt; background: white; border-collapse: collapse;">
													<tbody>
														<tr>
															<td valign="top" style="padding: 6.75pt 0cm 0cm 0cm">
																<table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100.0%; border-collapse: collapse;">
																	<tbody>
																		<tr>
																			<td valign="top" style="padding:6.75pt 0cm 0cm 0cm">
																				<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																								<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																									<tbody>
																										<tr>
																											<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt"><p>
																												<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060"></span>
																												</p>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																							<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																								<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:300px">
																									<tbody>
																										<tr>
																											<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt; max-width:300px">
																												<p align="right" style="text-align:right">
																													<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060">'.$fecha_actual_correo.'</span>
																												</p>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																	
																</table>																
															</td>
														</tr>
														<tr>
															<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																<div align="center">
																	<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																		<tbody>
																			<tr>
																				<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																						<tbody>
																							<tr>
																								<td style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																									<div align="center">
																										<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																											<tbody>
																												<tr>
																													<td valign="top" style="padding:0cm 0cm 0cm 0cm"></td>
																													<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																														<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%">
																															<tbody>
																																<tr>
																																	<td style="padding:6.75pt 13.5pt 6.75pt 13.5pt">
																																		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; background:#009A3F; border-collapse:collapse; min-width:100%">
																																			<tbody>
																																				<tr>
																																					<td valign="top" style="padding:13.5pt 13.5pt 13.5pt 13.5pt">
																																						<p align="center" style="text-align:center; line-height:150%">
																																							<strong>
																																								<span style="font-size:25.5pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:white">REGISTRO DE NOVEDADES&nbsp;</span>
																																							</strong>
																																						
																																						</p>
																																					</td>
																																				</tr>
																																			</tbody>
																																		</table>
																																	</td>
																																</tr>
																															</tbody>
																														</table>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</div>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</td>
														</tr>														
														<tr>
															<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																<div align="center">
																	<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																		<tbody>
																			<tr>
																				<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table  border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:100%; min-width:100%"><tbody><tr><td width="600" valign="top" style="width:450.0pt; padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:13.5pt 13.5pt 6.75pt 13.5pt"><span style="line-height:150%;"><strong><span style="font-size:20.0pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:rgb(243, 146, 0);">'.$rptamontacarga[0]["nom_equipo"]." ".$rptamontacarga[0]["codigo"].'</span></strong><span style="font-size:11.5pt; line-height:150%; font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;; color:#606060"> </span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>
																					
																				</td>
																			</tr>
																		</tbody>
																		
																	</table>
																	
																</div>
																
															</td>
														</tr>														
													</tbody>
													
												</table>
												<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><p align="center" style="text-align:center"><span style="text-decoration:none"><img src="cid:montacarga" border="0" width="254" style="margin-top: -30px"></span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:52%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:15.5pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Descripción:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.strtoupper($descrinovedad).'</span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Responsable:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$rptaasignacion["responsable"].'</span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:50%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Modalidad:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$modalidad.'</span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Paralización:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$text_paraliza.'</span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:50%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Horario:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">TURNO '.$rptaasignacion["turno"].'</span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>


<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><div align="center"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:0cm 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Estado Equipo:</span></b></span><p><span style="color: #009a3f;font-size: 18px; font-family: Verdana, sans-serif, serif, EmojiFont;"><b>'.$estadoEquipo.'</b> </span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:52%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:0cm 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Estado Novedad:</span></b></span><p><span style="color: #009a3f;font-size: 18px;font-family: Verdana, sans-serif, serif, EmojiFont;"><b>PENDIENTE</b></span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div> </td></tr></tbody></table>		

<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr style="height:25.55pt;">
<td valign="top" style="background-color:white;width:18.3pt;height:25.55pt;padding:0 5.4pt;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;">&nbsp;</span></p>
</td>
<td valign="top" colspan="2" style="background-color:white;width:229.3pt;height:25.55pt;padding:0;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#333333;"></span><span style="color:#333333;"></span></p>
</td>
<td style="background-color:white;width:141.95pt;height:25.55pt;padding:0;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;"><img src="cid:logo_ransa" width="145" height="40" border="0" id="x_Imagen_x0020_2" crossorigin="use-credentials" style="cursor: pointer;"></span><span style="color:#333333;"></span></p>
</td>
<td valign="top" style="background-color:white;width:20.55pt;height:25.55pt;padding:0 5.4pt;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;">&nbsp;</span></p>
</td>
<td style="width:3.2pt;height:25.55pt;padding:0;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;">&nbsp;</p>
</td>
</tr></tbody></table>	

											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>			
			</tbody>
			
		</table>		
	</div>
	


</body>
</html>';

	    //Recipients
	    $mail->setFrom('smontenegrot@bposgromero.onmicrosoft.com', 'NOVEDADES RANSA');

		$mail->addAddress($_SESSION["email"]);     // Add a recipient	
	    for ($i=0; $i < count($rptausuarios) ; $i++) {
	    	if ($rptausuarios[$i]["idciudad"] == $_SESSION["ciudad"]) { //validamos la ciudad
	    		$modulos = json_decode($rptausuarios[$i]["idmodulos"], true);
	    		for ($j=0; $j < count($modulos) ; $j++) { 
	    			if ($modulos[$j]["idmodulos_portal"] == "1") {
	    				$mail->addAddress($rptausuarios[$i]["email"], $rptausuarios[$i]["primerapellido"]);
	    			}
	    			
	    		}

	    		
	    	}
	    	
	    }
	    
	    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    // Optional name

	    // Content
	    $mail->Subject = 'NOVEDAD '.$rptamontacarga[0]["codigo"];
	    $mail->Body    = $body;
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $envios = $mail->send();	

		if ($rpta == "ok" && $envios) {
			echo '<script>
						Swal.fire({
							  title: "¡OK!",
							  text: "¡Novedad del equipo '.$codigo.' registrada con exito!",
							  type:"success",
							  allowOutsideClick: false,
							  allowEscapeKey: false,
							  backdrop: true,
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							}).then((result)=>{
								if(result.value){
									history.back();
									window.location = "checklist";
								}
								})
				</script>';		
		}

	}
}

	public function ctrRegistroNovedadeschl($datos){
		$tabla = "novequipos";

		$rpta = ModeloNovedades::mdlRegistroNovedad($tabla,$datos);

		return $rpta;
	}

	/*=======================================
	=            CONSULTAR NOVEDADES            =
	=======================================*/

	static public function ctrConsultarNovedadesEquipos($dato,$item){
		$tabla = "novequipos";

		$rpta = ModeloNovedades::mdlConsultarNovedadesEquipos($tabla,$dato,$item);

		return $rpta;
	}

	/*===========================================================================
	=            REGISTRAR LA FECHA TENTATIVA DE RESOLVER LA NOVEDAD            =
	===========================================================================*/
	 public function ctrRegistroFechaPropuesta($datos,$items){
		$tabla = "novequipos";

		$rpta = ModeloNovedades::mdlRegistroFechaPropuesta($tabla,$datos,$items);

		return $rpta;
	}
	public function ctrEliminarNovedad($dato1,$dato2,$item1,$item2){

		$tabla = "novequipos";

		$rpta = ModeloNovedades::mdlEliminarNovedad($tabla,$dato1,$dato2,$item1,$item2);

		return $rpta;
	}
	/*=========================================================================
	=            REGISTRAR LAS NOVEDADES POR CADA UNO DE LOS ITEMS            =
	=========================================================================*/
	static public function ctrRegistroItemsNovedades($datos,$lista,$idchecklist){
		$tabla = "obschcklstq";
		$rpta = ModeloNovedades::mdlRegistroItemsNovedades($tabla,$datos,$lista,$idchecklist);

		return $rpta;		

	}
	
	
	
	
	
	
}