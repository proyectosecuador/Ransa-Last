<?php

use Mpdf\Tag\Select;
use Mpdf\Utils\Arrays;

require_once "../controladores/productosDisensa.controlador.php";
require_once "../modelos/productosDisensa.modelo.php";

// require_once "../controladores/usuarios.controlador.php";
// require_once "../modelos/usuarios.modelo.php";
// session_start();

class AjaxTablaProductos{

	/*=========================================================
	=            CONSULTA DE PRODUCTOS POR CLIENTE            =
	=========================================================*/
	public $idcliente;

	
	public function ajaxConsultaProductClientes(){
		$id = 71;
	    $lisproductos = new ControladorProductosDisensa();
    	$rpta = $lisproductos->ctrConsultarProductosDisensa($id);

		          $url = 'https://dplwebapi2.azurewebsites.net/api/lotxlocxid/holcim';
				 	$curl = curl_init();
				 	curl_setopt($curl, CURLOPT_URL, $url);
				 	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
				 	curl_setopt($curl, CURLOPT_HTTPHEADER, [
				 	  'X-API-Key: 41852176-1698-4410-975b-c824775ffc11',
				 	]);
				 	$response = curl_exec($curl);
				    
					// $consulta1 = json_encode($response);

				 	curl_close($curl);
		
				$json = json_decode($response, true);
				

    	if (isset($rpta) && !empty($rpta)) {
        	$count = count($rpta);

        $datosJson = '{
  						"data": [';

        	for ($i=0; $i < $count ; $i++) {

        		/*===========================================================================
        		=            MOSTRAR USUARIO QUE REALIZO EL INGRESO DEL PRODUCTO            =
        		===========================================================================*/
        		// $item = "id";
                // $valor = $rpta[$i]['idusuario'];
                // $tabla = "usuariosransa";
                // $usuarios = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$item,$valor);
                // $primernombre = explode(" ", $usuarios['primernombre']);
          		// $primerapellido = explode(" ", $usuarios['primerapellido']);

          		/*===========================================
          		=            ESTADO DEL PRODUCTO            =
          		===========================================*/
          		
          		//  if ($rpta[$i]['estado'] == 0) {
  	  			// 	$colorEstado = "btn-danger";
	  			// 	$textoEstado = "Desactivado";
	  			// 	$estadoProducto = 1;
	            //   }else{
	  			// 	$colorEstado = "btn-success";
	  			// 	$textoEstado = "Activado";
	  			// 	$estadoProducto = 0;
	            //   }
	            //   $estado = "<button  type='button' class='btn btn-xs btnActivar ".$colorEstado."' idProducto='".$rpta[$i]['idproducto']."' estadoProducto='".$estadoProducto."'>".$textoEstado."</button>";

	               $visualizar = "<button type='button' idProducto='".$rpta[$i]['idproducto']."' class='btn btn-xs visualizar'><span class='fa fa-eye'></span></button>";



				    if ($id == 64) {
					 $nuevoCampo = array_filter($json, function($k) use ($rpta, $i) {
						 return $k['sku'] == $rpta[$i]['codigo'];
					 });	
					//  var_dump($nuevoCampo);
					$nuevoCampo = count($nuevoCampo) ? current($nuevoCampo) : [];
					 $rpta[$i]['cantidad'] = count($nuevoCampo) ? $nuevoCampo['quantity'] : 0;
					
					  }
					 
				

	              /*===================================================
	              =            ACCIONES PARA LOS PRODUCTOS            =
	              ===================================================*/	              
  			// $acciones = "<div class='btn-group'><button type='button' class='btn btn-warning btnEditarProducto' idProducto='".$rpta[$i]["idproducto"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fas fa-pencil-alt'></i></button><button type='button' class='btn btn-danger btnEliminarProducto' idProducto='".$rpta[$i]["idproducto"]."'><i class='fa fa-times'></i></button></div>";

  			/*=====================================================
  			=            PRESENTAR SI ES USUARIO RANSA            =
  			=====================================================*/
				  $estadoimage =  is_file("../".$rpta[$i]["foto_portada"]) ? 'Ingresada' : 'Pendiente';
  			// if (isset($_SESSION["cuentas"])) {
  				$datosJson .= '
        		 		    [';
  				// $datosJson .= '"'.$rpta[$i]['idproducto'].'",';
				// $datosJson .= '"'.$rpta[$i]['codigo'].'",';
  				// $datosJson .= '"'.$estadoimage.'",
				// 		      "'.$rpta[$i]['tipubicacion'].'",
				// 		      "'.$rpta[$i]['familia'].'",
				// 		      "'.$rpta[$i]['grupo'].'",
				// 		      "'.$rpta[$i]['descripcion'].'",';
		    	// $datosJson .= '"'.$primernombre[0].' '.$primerapellido[0].'",
				// 				"'.$estado.'",';
				// $datosJson .= '"'.$visualizar.'",'; 
		    	// $datosJson .= '"'.$acciones.'"';
		    	// $datosJson .= '],';

  				
  			// }else{
  				if ($rpta[$i]['estado'] == 1 && is_file("../".$rpta[$i]["foto_portada"])) {
  					 $datosJson .= '
        			 	    [';
  					 $datosJson .= '"'.$rpta[$i]['codigo'].'",
					 	      "'.$rpta[$i]['tipubicacion'].'",
					 	      "'.$rpta[$i]['familia'].'",
					 	      "'.$rpta[$i]['grupo'].'",
					 	      "'.$rpta[$i]['descripcion'].'",
					          "'.$rpta[$i]['cantidad'].'",';
					 $datosJson .= '"'.$visualizar.'"';
                    //   $datosJson .= '';
					 $datosJson .= '],';
  				}
  			}
			  
        	}
        	$datosJson = substr($datosJson,0,-1);

        	$datosJson .= ']
        	}';

			
			// print_r($rpta);
        	 echo $datosJson;
		// }else{
			//  echo $datosJson = '{
  			// 			"data": []}';

		}
	// }




}
/*=============================================
=            CONSULTA DE PRODUCTOS            =
=============================================*/
if (isset($_POST['idcliente'])) {
	$consulta = new AjaxTablaProductos();
	$consulta-> idcliente = $_POST['idcliente'];
	$consulta->ajaxConsultaProductClientes();

}
/*=================================================
=            ACTIVAR TABLA DEL CLIENTE            =
=================================================*/
if (isset($_SESSION['cliente'])) {
	$productclientes = new AjaxTablaProductos();
	$productclientes-> idcliente = $_SESSION['idcliente'];
	$productclientes->ajaxConsultaProductClientes();
}






