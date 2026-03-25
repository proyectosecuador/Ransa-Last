<?php
require_once "../controladores/gestiondocumentos.controlador.php";
require_once "../modelos/gestiondocumentos.modelo.php";

require_once "../controladores/proveedores.controlador.php";
require_once "../modelos/proveedores.modelo.php";
session_start();

class AjaxTablaDocumentos{

	/*=============================================================
	=            CONSULTA DE DOCUMENTOS SEGUN USUARIOS            =
	=============================================================*/
	 public $id;
	public function ajaxConsultarDocumentos(){
		$iduser = $this->id;
		$item = "movmimiento_doc";

		$rpta = ControladorDocumentos::ctrMostrarDocumentos(null,null);
		if ($rpta) {
			$datosJson = '{ 
							"data": [';
			for ($i=0; $i < count($rpta) ; $i++) { 
				
				/*============================================================
				=            CONSULTAR EL PROVEEDOR DEL DOCUMENTO            =
				============================================================*/
				$item = "idproveedor";
				$valor = $rpta[$i]["idproveedor"];

				$proveedor = ControladorProveedores::ctrConsultarProveedores($item,$valor);
				/*============================================
				=            ESTADO DEL DOCUMENTO            =
				============================================*/
				if ($rpta[$i]['estado_documento'] == 1) {
					$textoEstado = "EN PROCESO";
				}else if ($rpta[$i]['estado_documento'] == 2) {
					$textoEstado = "INGRESADA";
				}else{
					$textoEstado = "ANULADA";
				}
				/*=============================================================================
				=            ACCIONES QUE SE REALIZA EN LA RECEPCIÓN DEL DOCUMENTO            =
				=============================================================================*/
				/* CONFIRMAR RECEPCIÓN */
				$movimiento = json_decode($rpta[$i]["movimiento_doc"],true);

				$ultimo = end($movimiento);
				
				
				
				if ($rpta[$i]["nombreencriptado"] == null && isset($ultimo["idrecibe"] )) {
					if ($ultimo["idrecibe"] == $_SESSION["id"] && $ultimo["estado"] == "RECIBIDO") {
						$accion = "<div class='btn-group'><button type='button' disabled class='btn btn-warning btnConfirmDocumento' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-check'></i></button><button type='button' class='btn btn-danger btnEliminarProducto' idProducto=''><i class='fa fa-pencil'></i></button></button><button type='button' class='btn btn-warning btnEliminarProducto' idProducto=''><i class='fa fa-exchange'></i></button></div>";
					}
				}else{
					$accion = "<div class='btn-group'><button type='button' class='btn btn-warning btnConfirmDocumento' iddocumento='".$rpta[$i]["idgestiondoc"]."' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-check'></i></button><button type='button' class='btn btn-danger btnEliminarProducto' idProducto=''><i class='fa fa-pencil'></i></button></button><button type='button' class='btn btn-warning btnEliminarProducto' idProducto=''><i class='fa fa-exchange'></i></button></div>";

				}
				$datosJson .= '[';
				$datosJson .= '"'.$rpta[$i]['tipo_documento'].'",
						      "'.$rpta[$i]['fech_documento'].'",
						      "'.$proveedor['nombre'].'",
						      "'.$rpta[$i]['num_documento'].'",
						      "'.$textoEstado.'",
						      "'.$accion.'"';
				$datosJson .= '],';
				
				
			}
			$datosJson = substr($datosJson,0,-1);

        	$datosJson .= ']
        	}';

        	echo $datosJson;
			
		}else{
			echo $datosJson = '{
  						"data": []}';
		}




	}
	
	
	
}
/*=========================================================
=            CONSULTAR RECEPCIÓN DE DOCUMENTOS            =
=========================================================*/
if (isset($_SESSION["area"])) {

	$consulDocumentosEnviados = new AjaxTablaDocumentos();

	$consulDocumentosEnviados -> id = $_SESSION["id"];

	$consulDocumentosEnviados -> ajaxConsultarDocumentos();
}