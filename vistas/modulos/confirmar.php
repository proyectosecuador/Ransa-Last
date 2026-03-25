<!--========================================================================
=            CONFIRMAR ENTREGA DE TODOS LOS DOCUMENTOS EN LISTA            =
=========================================================================-->
<?php
$documentosconfirmados = false;
$valor = $rutas[1];
$item = "nombreencriptado";
/*====================================================================================
=            CONSULTAMOS SI EXISTE EL NOMBRE ENCRIPTADO PASADO POR CORREO            =
====================================================================================*/
$url = Ruta::ctrRuta();
$rpta = ControladorDocumentos::ctrMostrarDocumentos($item , $valor);
/*=======================================================
=            CAMBIAMOS EL ESTADO A ENTREGADO            =
=======================================================*/
for ($i=0; $i < count($rpta) ; $i++) { 
	if ($valor == $rpta[$i]["nombreencriptado"]) {
		$id = $rpta[$i]["idgestiondoc"];
		$item2 = array("item1" => "movimiento_doc",
						"item2" => "idgestiondoc",
						"item3" => "nombreencriptado");
					/*========================================================================================
					=            CONSULTAMOS LOS DATOS DEL PERSONAL A QUIEN SE ENVIA EL DOCUMENTO            =
					========================================================================================*/
					$tabla = "usuariosransa";
					$item4 = "id";
					$valorusuario = $rpta[$i]["idusuario"];
					$rpta3 = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$item4,$valorusuario);
		$nuevomovimiento = array();
		$movimiento = json_decode($rpta[$i]["movimiento_doc"],true);
		date_default_timezone_set('America/Bogota');
		$dateactual = date("Y-m-d");
		//var_dump($movimiento);
		array_push($nuevomovimiento, $movimiento);
		 array_push($nuevomovimiento, array("fecha" 	=> $dateactual,
								"idrecibe"	=> $rpta3["id"],
								"nombrerecibe" 	=> $rpta3["primernombre"]." ".$rpta3["primerapellido"],
								"estado" 	=> "RECIBIDO"));

		$valormovimientofinal = json_encode($nuevomovimiento);

		$valormovimiento = array("valor1" => $valormovimientofinal,
								"valor2" => $id,
								"nombreencriptado" => null);

		$rpta2 = ControladorDocumentos::ctrActualizarDocumentos($item2,$valormovimiento);

		if ($rpta2 == "ok") {
			$documentosconfirmados = true;
		}

	}
}



?>
<div class="x_panel">
	<div class="x_content">
		<table id="datatableUserRansa" class="table table-striped">
	      <thead>
	        <tr>
	          <th>T. Doc</th>
	          <th>Fecha</th>
	          <th>Proveedor</th>
	          <th>Número</th>
	          <th>Estado General</th>
	        </tr>
	      </thead>
	      <tbody>
	      	<?php

	      	for ($i=0; $i < count($rpta) ; $i++) {
	      		/*===========================================
	      		=            CONSULTAR PROVEEDOR            =
	      		===========================================*/
	      		$itemproveedor = "idproveedor";
	      		$Proveedor = ControladorProveedores::ctrConsultarProveedores($itemproveedor,$rpta[$i]["idproveedor"]);
	      		/*==========================================
	      		=            VER ESTADO GENERAL            =
	      		==========================================*/
	      		if ($rpta[$i]["estado_documento"] == 1) {
	      			$estado = "EN PROCESO";
	      		}else if ($rpta[$i]["estado_documento"] == 2) {
	      			$estado = "INGRESADA";
	      		}else{
	      			$estado = "ANULADA";
	      		}
	   			echo '<tr>
	              		<td>'.$rpta[$i]["tipo_documento"].'</td>
	              		<td>'.$rpta[$i]["fech_documento"].'</td>
	              		<td>'.$Proveedor["nombre"].'</td>
	              		<td>'.$rpta[$i]["num_documento"].'</td>
	              		<td>'.$estado.'</td>
	              	</tr>';	
	      	}
	      	?>

	      </tbody>
	    </table>		
		
	</div>
	
</div>

<div class="container">
	
	<div class="row">
	 
		<div class="col-xs-12 text-center verificar">

			
			<?php
				if($documentosconfirmados){

					echo '<div><h1>Gracias</h1>
						<h2><small>¡Haz click en <strong>Confirmar</strong> para terminar el proceso de Confirmación!</small></h2>

						<br></div>';
						if (isset($_SESSION["validarSession"])) {
						}else{
							echo'<a href="'.$url.'" data-toggle="modal"><button class="btn btn-default backColor btn-lg">INGRESAR</button></a>';
						}

						
				

				}else{

					echo '<h3>Error</h3>

					<h2><small>¡No se ha podido confirmar ningún Documento, posiblemente ya han confirmado el / los documento(s) !</small></h2>

					<br>';

						if (isset($_SESSION["validarSession"])) {
						}else{
							echo'<a href="'.$url.'" data-toggle="modal"><button class="btn btn-default backColor btn-lg">INGRESAR</button></a>';
						}



				}

			?>

		</div>

	</div>

</div>
