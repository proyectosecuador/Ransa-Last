<?php
require_once "../controladores/archivos.controlador.php";
require_once "../modelos/archivos.modelo.php";
session_start();
class AjaxTablaListInventario{

	/*=========================================================
	=            CONSULTA DE PRODUCTOS POR CLIENTE            =
	=========================================================*/
	public $idcliente;

	public function ajaxConsultaListInventario(){
		$id = $this->idcliente;

	    $rpta = ControladorArchivos::ctrMostrarInventExcel($id,"idcliente");
    	
    	if (isset($rpta) && !empty($rpta)) {
        	$count = count($rpta);

        $datosJson = '{
  						"data": [';

        	for ($i=0; $i < $count ; $i++) {

          		/*===========================================
          		=            ESTADO DEL INVENTARIO            =
          		===========================================*/
          		
          		 if ($rpta[$i]['estado_confirmacion'] == 0) {
  	  				$colorEstado = "label-danger";
	  				$textoEstado = "POR CONFIRMAR";
	  				$estadoboton = "";
	              }else{
	  				$colorEstado = "label-primary";
	  				$textoEstado = "CONFIRMADO";
	  				$estadoboton = "disabled";
	              }
	              $estado = "<span style= 'font-size: 13px' class='label ".$colorEstado."'>".$textoEstado."</span>";
	              
	              /*===================================================
	              =            ACCIONES DEL INVENTARIO            =
	              ===================================================*/	              
  			$accionescliente = "<div class='btn-group'><button type='button' ".$estadoboton." id=".$rpta[$i]['id']." class='btn btn-primary btnConfirmInventario' data-toggle='modal' data-target='#modalEditarProducto'><i class='fa fa-check'></i></button></div>";

  			/*=====================================================
  			=            PRESENTAR SI ES USUARIO RANSA            =
  			=====================================================*/

  			if (isset($_SESSION["cuentas"])) {
  					$datosJson .= '
        				    [';
  					$datosJson .= '"'.$rpta[$i]['id'].'",
						      "'.$rpta[$i]['fechainvent'].'",
						      "'.$rpta[$i]['cantidad']." "."Ubicaciones".'",
						      "'.$estado.'"';
					$datosJson .= '],';

  				
  			}else{
  				if ($rpta[$i]['estado'] == 1) {
  					$datosJson .= '
        				    [';
  					$datosJson .= '"'.$rpta[$i]['id'].'",
						      "'.$rpta[$i]['fechainvent'].'",
						      "'.$rpta[$i]['cantidad']." "."Ubicaciones".'",
						      "'.$estado.'",
						      "'.$accionescliente.'"';
					$datosJson .= '],';
  				}
  			}

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
/*=============================================
=            CONSULTA DE PRODUCTOS            =
=============================================*/
if (isset($_POST['idcliente'])) {
	$consulta = new AjaxTablaListInventario();
	$consulta-> idcliente = $_POST['idcliente'];
	$consulta->ajaxConsultaListInventario();

}
/*=================================================
=            ACTIVAR TABLA DEL CLIENTE            =
=================================================*/
if (isset($_SESSION['cliente'])) {
	$productclientes = new AjaxTablaListInventario();
	$productclientes-> idcliente = $_SESSION['idcliente'];
	$productclientes->ajaxConsultaListInventario();
}






