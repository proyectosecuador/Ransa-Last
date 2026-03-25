<?php

require_once "../controladores/productos.controlador.php";
require_once "../modelos/productos.modelo.php";

class AjaxProductos{

	/*=========================================
	=            ACTIVAR PRODUCTOS            =
	=========================================*/

	public $EstadoProducto;
	public $IdProducto;
	public $imagenMultimedia;
	public $ruta;
	public $Codigo;
	public $Tipoubicacion;
	public $Familia;
	public $Grupo;
	public $Descripcion;
	public $CodigoCliente;
	public $Idusuario;
	public $Foto_antigua;
	public $ImagenPrincipal;
	public $Idcliente;
	public $descritecnica;

	public function ajaxActivarProducto(){


		$tabla = "productos";
		$item1 = "estado";
		$valor1 = $this->EstadoProducto;

		$item2 = "idproducto";
		$valor2 = $this->IdProducto;

		$rpta = ModeloProductos::mdlActualizarProductos($tabla,$item1,$valor1,$item2,$valor2);

		echo $rpta;

	}
	/*============================================================
	=            CONSULTA PARA VISUALIZAR EL PRODUCTO            =
	============================================================*/
	
	public function ajaxConsultarProducto(){
		$id = $this->IdProducto;

		$tabla = "productos";
		$item = "idproducto";

		$rpta = ModeloProductos::mdlConsultarProductos($tabla,$item,$id);

		echo json_encode($rpta);
	}

	/*=======================================================================
	=            RECIBIR LAS IMAGENES Y GUARDAR EN EL DIRECTORIO            =
	=======================================================================*/
	public function ajaxImagenMultimedia(){
		$datos = $this->imagenMultimedia;
		$directorio = $this->ruta;

		

		$respuesta = ControladorProductos::ctrSubirMultimedia($datos,$directorio);

		echo $respuesta;

	}
	/*========================================
	=            EDITAR PRODUCTOS            =
	========================================*/
	public function ajaxEditarProductos(){

		$datos = array(
			"idproductos" => $this->IdProducto,
			"codigo" => $this->Codigo,
			"tipoubicacion" => $this->Tipoubicacion,
			"familia" => $this->Familia,
			"grupo" => $this->Grupo,
			"descripcion" => $this->Descripcion,
			"codigocliente" => $this->CodigoCliente,
			"idusuario" => $this->Idusuario,
			"desctecnica" => $this->descritecnica,
			"foto_antigua" => $this->Foto_antigua,
			"multimedia" => $this->imagenMultimedia,
			"imagenprincipal" => $this->ImagenPrincipal

		);
		
		$respuesta = ControladorProductos::ctrEditarProductos($datos);

		echo $respuesta;




	}

	public function ajaxEliminarProducto(){
		$idproducto = $this->IdProducto;

		$respuesta = ControladorProductos::ctrEliminarProductos($idproducto);

		echo $respuesta;
	}
	
	/*=========================================================
	=            CONSULTAR PRODUCTOS SEGUN CLIENTE            =
	=========================================================*/
	public function ajaxConsultProductoIdcliente(){
		$id = $this->Idcliente;
		$rpta = ControladorProductos::ctrConsultarProductos($id);

		echo json_encode($rpta);

	}
	
	
	
	
	
	
}
/*=========================================
=            ACTIVAR PRODUCTOS            =
=========================================*/
if(isset($_POST["estadoProducto"])){

	$activarProducto = new AjaxProductos();
	$activarProducto -> EstadoProducto = $_POST["estadoProducto"];
	$activarProducto -> IdProducto = $_POST["idproducto"];
	$activarProducto -> ajaxActivarProducto();
}
/*===========================================================
=            CONSULTAR PARA VISUALIZAR PRODUCTOS            =
===========================================================*/
if (isset($_POST['IdProducto'])) {
	$visual = new AjaxProductos();
	$visual -> IdProducto = $_POST['IdProducto'];
	$visual -> ajaxConsultarProducto();
}
/*=======================================================================
=            RECIBIR LAS IMAGENES Y GUARDAR EN EL DIRECTORIO            =
=======================================================================*/
if (isset($_FILES['file'])) {
	$directoriofile = new AjaxProductos();
	$directoriofile -> imagenMultimedia = $_FILES['file'];
	$directoriofile -> ruta = $_POST['ruta'];
	$directoriofile -> ajaxImagenMultimedia();
}
/*========================================
=            EDITAR PRODUCTOS            =
========================================*/
if (isset($_POST['idproductos'])) {

	$editarproduct = new AjaxProductos();
	$editarproduct -> IdProducto 		= $_POST['idproductos'];
	$editarproduct -> Codigo 			= $_POST['codigo'];
	$editarproduct -> Tipoubicacion 	= $_POST['tubicacion'];
	$editarproduct -> Familia 			= $_POST['familia'];
	$editarproduct -> Grupo  			= $_POST['grupo'];
	$editarproduct -> Descripcion 		= $_POST['descripcion'];
	$editarproduct -> Idusuario 		= $_POST['idusuario'];
	$editarproduct -> CodigoCliente 	= $_POST['codigocliente'];
	$editarproduct -> Foto_antigua 		= $_POST['portada_antigua'];
	$editarproduct -> imagenMultimedia 	= $_POST['multimedia'];

	if (isset($_FILES["imagen_principal"])) {
		$editarproduct -> ImagenPrincipal 	= $_FILES['imagen_principal'];
	}else{
		$editarproduct -> ImagenPrincipal 	= null;
	}
	if (isset($_POST["descriptecnica"])) {
		$editarproduct -> descritecnica = $_POST["descriptecnica"];
	}else{
		$editarproduct -> descritecnica = null;
	}
	
	
	$editarproduct -> ajaxEditarProductos();
}

/*==========================================
=            ELIMINAR PRODUCTOS            =
==========================================*/
if (isset($_POST["eliminar"])) {
	$eliminarProducto = new AjaxProductos();
	$eliminarProducto -> IdProducto = $_POST["idproductoEliminar"];
	$eliminarProducto -> ajaxEliminarProducto();
}
if (isset($_POST["ConsultProductoIdCliente"])) {
	$ConsulProd = new AjaxProductos();
	$ConsulProd -> Idcliente = $_POST["ConsultProductoIdCliente"];
	$ConsulProd -> ajaxConsultProductoIdcliente();
}








