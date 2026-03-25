<?php
require_once "../controladores/gestiondocumentos.controlador.php";
require_once "../modelos/gestiondocumentos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../extensiones/PHPMailer_master/vendor/autoload.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";

require_once "../modelos/rutas.php";

session_start();

use  PHPMailer \ PHPMailer \ PHPMailer ; 
use  PHPMailer \ PHPMailer \ Exception ;


class AjaxDocumentos{
	/* VARIABLES */
	public $envio;
	public $datoss;
	
	/*================================================================
	=            INGRESO AL MOMENTO DE ENVIO DE DOCUMENTO            =
	===============================================================*/
	public function ajaxEnviarDocumentos(){
		$iduserenvio = $this->envio;
		$datosdocumento = $this->datoss;
		
		/* CONSULTA DEL CORREO DEL USUARIO QUE SE ENVIA DOCUMENTOS */
		$tablauser = "usuariosransa";
		$item = "id";
		$datosuserenvio = ControladorUsuarios::ctrMostrarUsuariosRansa($tablauser,$item,$iduserenvio);

		$datodoc = json_decode($datosdocumento,true);
		$contdocu = count($datodoc);
		$datostabla = array();
		$nombres = $_SESSION["nombre"]." ".$_SESSION["apellido"];

		$nombreencriptadoxvalidar = password_hash($nombres, PASSWORD_BCRYPT);

		for ($i=0; $i < $contdocu ; $i++) { 
			/* CONSULTAR EL ID DEL PROVEEDOR */
			$item = "nombre";
			$idproveedor = ControladorProveedores::ctrConsultarProveedores($item,$datodoc[$i]["idproveedor"]);
			/* DATOS DEL MOVIMIENTO DEL DOCUMENTO */
			date_default_timezone_set('America/Bogota');
			$fechaactual = date("Y-m-d");

			$movimiento = array("fecha" 	=> $fechaactual,
								"idenviado"	=> $_SESSION["id"],
								"nombreenviado" 	=> $nombres,
								"estado" 	=> "ENVIADO",
								"idrecibe" 	=> $iduserenvio,
								"nombrerecibe" 	=> $datosuserenvio["primernombre"]." ".$datosuserenvio["primerapellido"]);

			
			/* ELIMINAMOS LOS / Y . PARA EL LINK DE CONFIRMACIÓN */
			
			$nombre1 =  str_replace("/", "", $nombreencriptadoxvalidar);
			$nombre2 = str_replace(".", "", $nombre1);
			$nombreencriptado = str_replace("$", "", $nombre2);
			/* DATOS PARA ENVIAR A LA BASE */
			$fechadoc = date("Y-m-d",strtotime($datodoc[$i]["fech_documento"]));

			$datos = array("tipo_documento" => $datodoc[$i]["tipo_documento"],
						"idproveedor" 		=> $idproveedor["idproveedor"],
						"centrocosto" 		=> $datodoc[$i]["centrocosto"],
						"idarea" 			=> $datodoc[$i]["idarea"],
						"num_documento" 	=> $datodoc[$i]["numero"],
						"nombreencriptado" 	=> $nombreencriptado,
						"fech_documento" 	=> $fechadoc,
						"idusuario" 		=> $iduserenvio,
						"movimiento_doc" 	=> json_encode($movimiento));

			/* DATOS QUE SE ENVIARAN POR CORREO */
			switch ($datodoc[$i]["tipo_documento"]) {
			    case "NV":
			        $nom_doc = "NOTA DE VENTA";
			        break;
			    case "ND":
			        $nom_doc = "NOTA DE DÉBITO";
			        break;
			    case "NC":
			        $nom_doc = "NOTA DE CRÉDITO";
			        break;
			    case "FACTURA":
			    	$nom_doc = "FACTURAS";
			}
			array_push($datostabla, array("tipo_doc" => $nom_doc,
										"proveedor"  => $datodoc[$i]["idproveedor"],
										"fecha" => $datodoc[$i]["fech_documento"],
										"numero" => $datodoc[$i]["numero"]));

			/*=====================================================
			=            REGISTRAR EN LA BASE DE DATOS            =
			=====================================================*/			

			$rpta = ControladorDocumentos::ctrInsertarDocumentos($datos);

			}
			/*=================================================================
			=            ENVIO DE LISTADO DE DOCUMENTOS POR CORREO            =
			=================================================================*/
			if ($rpta == "ok") {
			$url = Ruta::ctrRuta();

			$mail = new PHPMailer();

			$mail->CharSet = 'UTF-8';

			//$mail->isMail();
			$mail->isSMTP ();

			$mail->SMTPSecure = 'STARTTLS';

			$mail->SMTPAuth = true;

			$mail->Host = "smtp.office365.com"; // SMTP a utilizar. Por ej. smtp.elserver.com

			$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar

			$mail->Password = "Didacta_123"; // Contraseña

			$mail->Port = 587; // Puerto a utilizar

			$mail->From = "proyectosecuador@ransa.net"; // Desde donde enviamos (Para mostrar)

			$mail->FromName = "Douglas Borbor";			

			//$mail->setFrom('cursos@tutorialesatualcance.com', 'Tutoriales a tu Alcance');

			//$mail->addReplyTo('cursos@tutorialesatualcance.com', 'Tutoriales a tu Alcance');

			$mail->Subject = "Por favor confirme la entrega de documentos";

			$mail->addAddress($datosuserenvio["email"]);

			

				$body = '<div style="width:100%; background:#eee; position:relative; font-family:sans-serif; padding-bottom:40px">
	<style type="text/css">
		#customers {
		  border-collapse: collapse;
		  width: 100%;
		}

		#customers td, #customers th {
		  border: 1px solid #ddd;
		  text-align: center;
		}
		#customers th {
		  text-align: center;
		  background-color: #4CAF50;
		  color: white;
		}
		</style>
	</style>
	
	<center>
		
		<img style="padding:20px; width:30%" src="'.$url.'vistas/img/login/logotipo.png">

	</center>

	<div style="position:relative; margin:auto; width:600px; background:white; padding:20px">
	
		<center>
		<h3 style="font-weight:100; color:#999">ENTREGA DE DOCUMENTOS</h3>

		<hr style="border:1px solid #ccc; width:80%">

		<h4 style="font-weight:100; color:#999; padding:0 20px">Estimados(as). <br><br> Por medio del presente detallo que el Usuario '.$nombres.' va hacer la entrega de los documentos que se encuentra en el listado adjunto, su ayuda confirmando la entrega de los Documentos. </h4>
		<table id="customers">
			<thead>
				<tr style="background-color: #6bb11e; text-align: center; font-size: 20px; color: white;">
					<td colspan="4">Listado de Facturas a Entregar</td>
				</tr>
				<th>T.Documento</th>
				<th>Fecha</th>
				<th>Número</th>
				<th>Proveedor</th>
			</thead>
			<tbody>';
			$contdocume = count($datostabla);
			for ($i=0; $i < $contdocume ; $i++) { 
				
				$body .= '<tr>
									<td>'.$datostabla[$i]["tipo_doc"] .'</td>
									<td>'.$datostabla[$i]["fecha"] .'</td>
									<td>'.$datostabla[$i]["numero"] .'</td>
									<td>'.$datostabla[$i]["proveedor"] .'</td>					
								</tr>';
			}

			$body .= '</tbody>
		</table>

		<a href="'.$url.'confirmar/'.$nombreencriptado.'" target="_blank" style="text-decoration:none">

		<div style="line-height:60px; background:#0aa; width:60%; color:white">Confirmar Documentos entregados</div>

		</a>

		<br>

		<hr style="border:1px solid #ccc; width:80%">

		<h5 style="font-weight:100; color:#999">En caso de confirmar todos los Documentos hacer Click en el Enlace, caso contrario ingresar a la plataforma.</h5>

		</center>

	</div>

</div>';
	$mail->msgHTML($body);		
				
			}

			

			$envio = $mail->Send();
			if (!$envio) {

				echo $mail->ErrorInfo;
				

			}else{

				echo 1;


			}
				
	}
	/*=============================================================
	=            CONFIRMAR RECEPCION DE LOS DOCUMENTOS            =
	=============================================================*/
	public $id;

	public function ajaxConfirmarRecepcion(){
		$iddocumento = $this->id;
		$item = "idgestiondoc";
		/*================================================
		=            CONSULTAMOS EL DOCUMENTO            =
		================================================*/
		$consultDocumento = ControladorDocumentos::ctrMostrarDocumentos($item,$iddocumento);

		if ($consultDocumento) {
			$nuevomovimiento = array();
			$movimiento = json_decode($consultDocumento[0]["movimiento_doc"],true);

			array_push($nuevomovimiento, $movimiento);
			date_default_timezone_set('America/Bogota');
			$dateactual = date("Y-m-d");

			array_push($nuevomovimiento, array("fecha" 	=> $dateactual,
								"idrecibe"	=> $_SESSION["id"],
								"nombrerecibe" 	=> $_SESSION["nombre"]." ".$_SESSION["apellido"],
								"estado" 	=> "RECIBIDO"));

			$valormovimientofinal = json_encode($nuevomovimiento);

			$item = array("item1" => "movimiento_doc",
						"item2" => "idgestiondoc",
						"item3" => "nombreencriptado");
			$valor = array("valor1" => $valormovimientofinal,
						"valor2" => $iddocumento,
						"nombreencriptado" => null);


			$rpta = ControladorDocumentos::ctrActualizarDocumentos($item,$valor);

			if ($rpta == "ok") {
				echo 1;
			}else{
				echo 2;
			}

		}




	}
	
	
	
	
	
	
}

/*================================================================
=            INGRESO AL MOMENTO DE ENVIO DE DOCUMENTO            =
================================================================*/
if (isset($_POST["enviosrecep"])) {

	$enviodoc = new AjaxDocumentos();
	$enviodoc -> envio = $_POST["enviosrecep"];
	$enviodoc -> datoss = $_POST["datos"];
	$enviodoc -> ajaxEnviarDocumentos();

}
if (isset($_POST["idDocumento"])) {
	$confirmar = new AjaxDocumentos();
	$confirmar -> id = $_POST["idDocumento"];
	$confirmar -> ajaxConfirmarRecepcion();
}

