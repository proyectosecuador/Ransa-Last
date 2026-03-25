<?php
//use Dropbox as dbx; // Uso para Dropbox
class ControladorProductosDisensa{

	/*=============================================
	INGRESAR PRODUCTOS
	=============================================*/
	// public function ctrIngresoProductos(){
		
	// 	if ($_SERVER['REQUEST_METHOD'] == "POST"){
	// 		$cliente = 		$_POST['cliente'];
	// 		$idcliente = 		$_POST['idcliente'];
	// 		$codigo_cliente = 		$_POST['codigo'];
	// 		$codigo = 		$_POST['npcodigo'];
	// 		$tipoubic =  	$_POST['nptipoubicacion'];
	// 		$familia = 		$_POST['npfamilia'];
	// 		$grupo =  		$_POST['npgrupo'];
	// 		$descripcion =  $_POST['npdescripcion'];
	// 		if (isset($_POST["desctecnica"])) {
	// 			$descripciontecnica = $_POST["desctecnica"];
	// 		}else{
	// 			$descripciontecnica = null;
	// 		}
	// 		//$namefilePrincipal = str_replace(' ','',$_FILES['archiImg']['name']);
	// 		$tmpfilePrincipal =$_FILES['archiImg']['tmp_name'];
	// 		$countfileReferenci = count($_FILES['archiImgRef']['name']);

	// 		$ruta = "archivos/Catalogo/";

	// 		if (!file_exists($ruta.$codigo_cliente."/")) {
	// 			mkdir($ruta.$codigo_cliente."/",0777);
	// 		}
	// 		$rutadestino = $ruta.$codigo_cliente."/";
	// 		$namefilePrincipal = str_replace(' ','',$_FILES['archiImg']['name']);
	// 		$nombre = uniqid();
	// 		$multimedia= array();
	// 		if (is_file($_FILES['archiImgRef']['tmp_name'][0])) {
	// 			for ($i=0; $i < $countfileReferenci ; $i++) { 
	// 				$namefileReferen = str_replace(' ','',$_FILES['archiImgRef']['name'][$i]);
	// 				$tmpfileReferenci =$_FILES['archiImgRef']['tmp_name'][$i];
	// 				$destino = $rutadestino.$nombre."_".$i.".jpg";
	// 				array_push($multimedia, array("multimedia" => $destino));	
	// 				move_uploaded_file($tmpfileReferenci,$destino);
	// 			}
	// 			$jsonmultimedia = json_encode($multimedia);
	// 		}else{
	// 			$jsonmultimedia = "";
	// 		}
	// 		$nombreprincipal = $rutadestino.$nombre.".png";

	// 		move_uploaded_file($tmpfilePrincipal,$nombreprincipal);

	// 		$datos = array("codigo" => $codigo,
	// 						"tipoubicacion" => $tipoubic,
	// 		   				"familia" => $familia,
	// 						"grupo" => $grupo,
	// 						"descripcion" => $descripcion,
	// 						"idcliente" => $idcliente,
	// 						"idusuario" => $_SESSION['id'],
	// 						"descTecnica" => $descripciontecnica,
	// 						"fotoprincipal" => $nombreprincipal,
	// 						"multimedia" => $jsonmultimedia);
	// 		$tabla = "productos";
	// 		$rpta = ModeloProductos::mdlIngresarProductos($tabla,$datos);

	// 		if ($rpta == "ok") {
	// 			echo '<script>
	// 						Swal.fire({
	// 							  title: "¡OK!",
	// 							  text: "¡El producto se ha ingresado con Exito!",
	// 							  type:"success",
	// 							  confirmButtonText: "Cerrar",
	// 							  closeOnConfirm: false
	// 							}).then((result)=>{
	// 								if(result.value){
	// 									history.back();
	// 									window.location = "ingresoproducto";
	// 								}
	// 								})
	// 				</script>';
	// 		}

		/*=================================================================
		=            SECCION PARA AUTENTIFICAR USUARIO DROPBOX            =
		=================================================================*/
			/*				$plantilla = ControladorPlantilla::ctrEstiloPlantilla();
		$dropboxapi =  json_decode($plantilla['apidropbox']);

		$dropboxkey = $dropboxapi[0]->key;
		$dropboxsecret = $dropboxapi[0]->secret;
		$dropboxtoken = $dropboxapi[0]->token;
		$appName = "RansaEcuador";
		
	        		# Include the Dropbox SDK libraries
			$appInfo = new dbx\AppInfo($dropboxkey,$dropboxsecret);

			//Store CSRF token
			$csrfTokenStore = new dbx\ArrayEntryStore($_SESSION,'dropbox-auth-csrf-token');

			//define auth details
			//$webAuth = new dbx\webAuth($appInfo,$appName,"http://localhost/ransa/vistas/modulos/ingresoproducto.php",$csrfTokenStore);
			$webAuth = new dbx\WebAuthNoRedirect($appInfo,$appName);
			$authUrl = $webAuth->start();

			echo "1. Go to: " . $authUrl . "\n";
			echo "2. Click \"Allow\" (you might have to log in first).\n";
			echo "3. Copy the authorization code.\n";
			$authCode = "fpMS47NNCbAAAAAAAAAAOWMYKZju1T96tIpA0n_lqLc";

			list($accessToken, $dropboxUserId) = $webAuth->finish($authCode);
			print "Access Token: " . $accessToken . "\n";*/
			


				/*echo '<script>
					window.open("'.$authUrl.'","_blank","width=500,height=500,top=0,left=0");
				 </script>';*/

		/*=====  End of SECCION PARA AUTENTIFICAR USUARIO DROPBOX  ======*/
	// 	}
	// }
/*===========================================
=            CONSULTAR PRODUCTOS            =
===========================================*/

	 static public function ctrConsultarProductosDisensa($idcliente){

			$tabla = "productos";
			// $item = "idcliente";

			$rpta = ModeloProductosDisensa::mdlConsultarProductosDisensa($tabla,$idcliente);
			return $rpta;
	}

	/*===================================================================
	=            GUARDAR EN DIRECTORIO LAS IMAGENES EDITADAS            =
	===================================================================*/

	public function ctrSubirMultimedia($datos,$ruta){

		if ( isset($datos['tmp_name']) && !empty($datos['tmp_name'])) {
			/*================================================================
			=            CREAMOS LA RUTA PARA ALMACENAR LA IMAGEN MULTIMEDIA            =
			================================================================*/
			$directorio =  "../archivos/Catalogo/".$ruta."/";
			/*============================================================
			=            PREGUNTAMOS SI EXISTE EL DIRECTORIO             =
			============================================================*/
			if (!file_exists($directorio)) {
				mkdir($directorio,0777);
			}
			/*=========================================================
			=            MOVEMOS LA IMAGEN CON SUS NOMBRES            =
			=========================================================*/
			$nombre = uniqid();
			$rutamultimedia = $directorio.$nombre.".png";
			move_uploaded_file($datos['tmp_name'],$rutamultimedia);

			return $rutamultimedia;
			
		}
	}
	/*========================================
	=            EDITAR PRODUCTOS            =
	========================================*/
	static public function ctrEditarProductos($datos){
		if (isset($datos["idproductos"])) {
			/*===================================================================
			=            ELIMINAR LAS FOTOS MULTIMEDIA DE LA CARPETA            =
			===================================================================*/
			$item = "idproducto";
			$valor = $datos["idproductos"];
			$traerProductos = ModeloProductos::mdlConsultarProductos("productos",$item,$valor);

			for ($i=0; $i < count($traerProductos) ; $i++) { 
				$multimediaBD = json_decode($traerProductos[$i]["multimedia"],true);

				$multimediaEditar = json_decode($datos["multimedia"],true);

				$objmultimediaBD = array();
				$objmultimediaEditar = array();
				

				if ($multimediaBD != null || !empty($multimediaBD)) {

					for ($i=0; $i < count($multimediaBD) ; $i++) { 

						array_push($objmultimediaBD, $multimediaBD[$i]["multimedia"]);
					}					
					
				}

				if ($multimediaEditar != null || !empty($multimediaEditar)) {
					for ($i=0; $i < count($multimediaEditar) ; $i++) { 
						
						array_push($objmultimediaEditar, $multimediaEditar[$i]["multimedia"]);

					}					
				}

				/* EXTRAE EL ARRAY QUE ES DIFERENTE DEL OTRO */
				
				$borrarimagenes = array_diff($objmultimediaBD, $objmultimediaEditar);
				
				/* EXTRAE LOS INDICES DEL ARREGLO Y LO INGRESA EN UN ARRAY */
				$indice = array_keys($borrarimagenes);

				
				for ($i=0; $i < count($indice) ; $i++) {

					unlink("../".$borrarimagenes[$indice[$i]]);
					
				}
				
			}

			/*======================================================
			=            VALIDAMOS LAS IMAGEN PRINCIPAL            =
			======================================================*/
			$rutaImagenPrincipal = "../".$datos["foto_antigua"];

			if (isset($datos["imagenprincipal"]["tmp_name"]) && !empty($datos["imagenprincipal"]["tmp_name"])) {
				/*==================================================
				=            ELIMINAMOS LA FOTO ANTIGUA            =
				==================================================*/
				if (is_null($datos["foto_antigua"]) || $datos["foto_antigua"] == "") {
					
				}else{
					unlink($rutaImagenPrincipal);	
				}
				/*===================================================
				=            ALMACENAMOS LA IMAGEN NUEVA            =
				===================================================*/
				$ruta = "../archivos/Catalogo/".$datos["codigocliente"]."/";
				$nombre = uniqid();
				$rutaImagenPrincipal = $ruta.$nombre.".png";
				
				move_uploaded_file($datos["imagenprincipal"]["tmp_name"],$rutaImagenPrincipal);
			}

			$datosProducto = array(
								"id"=>$datos["idproductos"],
								"codigo"=>$datos["codigo"],
								"tipubicacion"=> $datos["tipoubicacion"],
								"familia"=>$datos["familia"],
								"grupo"=>$datos["grupo"],
								"descripcion"=>$datos["descripcion"],
								"descripciontecnica"=>$datos["desctecnica"],
								"idusuario"=>$datos["idusuario"],
								"foto_portada"=>substr($rutaImagenPrincipal,3),
								"multimedia"=>$multimedia = $datos["multimedia"] == 'null' ? NULL : $datos["multimedia"]);
			

			$rpta = ModeloProductos::mdlEditarProductos("productos",$datosProducto);

			return $rpta;
		}
	}

	/*==========================================
	=            ELIMINAR PRODUCTOS            =
	==========================================*/
	static public function ctrEliminarProductos($idproductos){

		if (isset($idproductos)) {
			$item = "idproducto";
			$valor = $idproductos;
			$traerProducto = ModeloProductos::mdlConsultarProductos("productos",$item,$valor);
			/*======================================================
			=            VALIDAMOS SI EXISTE LA IMAGEN PRINCIPAL            =
			======================================================*/
			$rutaImagenPrincipal = "../".$traerProducto[0]["foto_portada"];
			if (file_exists($rutaImagenPrincipal)) {
				unlink($rutaImagenPrincipal);
			}
			/*==============================================================
			=            VALIDAR SI EXISTEN ARCHIVOS MULTIMEDIA            =
			==============================================================*/
			$multimedia = json_decode($traerProducto[0]["multimedia"],true);

			foreach ($multimedia as $key => $value) {

				$imgMultimedia = "../".$value["multimedia"];

				if (file_exists($imgMultimedia)) {

					unlink($imgMultimedia);
				}
			}

			$rpta = ModeloProductos::mdlEliminarProductos("productos",$item,$valor);

			return $rpta;


		}
	}
	
	
	

}
