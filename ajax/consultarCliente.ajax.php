<?php

require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
session_start();

class AjaxClientes{
	
	public function ajaxmostrarClienes($valor){

		$item = "codigoransa";
		$rpta = ControladorClientes::ctrmostrarClientes($item,$valor);
		$valid = true;
		
		if ($rpta) {
			$cuentasUser = json_decode($_SESSION["cuentas"]);
			for ($i=0; $i < count($cuentasUser) ; $i++) {
				if ($cuentasUser[$i]->idcliente == $rpta['idcliente']) {
					if ($rpta['estado'] != 0) {
						echo json_encode($cuentasUser[$i]);
						//var_dump(json_encode($cuentasUser[$i]));
						$valid = true;	
					}else{
						$valid = 2;
						echo $valid;

					}
					
				}
				else{
					$valid = false;
				}
			}
		}
		else{
			$valid = 1;
			echo $valid;
		}
		
	}
}

$objeto = new AjaxClientes();

$objeto ->ajaxmostrarClienes($_POST['codigo']);
