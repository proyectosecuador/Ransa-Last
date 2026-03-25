<?php
require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";
session_start();
class AjaxUsuarios{

	/*==========================================
	=            INGRESO DE USUARIO            =
	==========================================*/
	public $nombres;
	public $apellidos;
	public $correo;
	public $password;
	public $cuentas;
	public $modulos;
	public $area;
	public $cargo;
	public $perfil;
	public $cliente;
	public $ciudad;
	public $claveantigua;
	public $clavenueva;
	public $idUsuario;
	public $fotonueva;
	public $fotoantigua;



	public function ajaxingresarUsuarios(){
		
		$nom = $this->nombres;
		$ape = $this->apellidos;
		$email = $this->correo;
		$clave = $this->password;
		$cuent = $this->cuentas;
		$perf = $this->perfil;
		$cargos = $this->cargo;
		$clie = $this->cliente;
		$mod = $this->modulos;
		$area = $this->area;

		$clavenueva = password_hash($clave, PASSWORD_BCRYPT);
			if (substr_count($email, 'ransa')) {
				$tabla = "usuariosransa";
				$perf;
				$clie = "";
			}else{
				$tabla = "usuariosclientes";
				$perf = 'cliente';
				$clie;
			}

			if ($cuent != null) {
				$cuenta = $cuent;

				
				//$vars = explode("|", $cuenta[0][1]);
				//var_dump($var);
				//var_dump($vars);
				$datosbase = array();
				$d = 0;
				for ($i=0; $i < count($cuenta); $i++) {
					$var = explode("|", $cuenta[$i]);
					array_push($datosbase,array("idcliente" => $var[0],
												"nombre" => $var[1]));
				}
				$cuentas = json_encode($datosbase);		
				/*===============================
				=            MODULOS            =
				===============================*/
				$moduloss = array();
				for ($i=0; $i <count($mod) ; $i++) { 
					array_push($moduloss,array("idmodulos_portal" => $mod[$i]));
				}

				
				$modulostratados = json_encode($moduloss);
				
				$datos = array("nombre" =>$nom,
							  "apellidos" => $ape,
							  "correo" => $email,
							  "password" => $clavenueva,
							  "cuentas" => $cuentas,
							  "cargo" => $cargos,
							  "perfil" => $perf,
							  "area" => $area,
							  "ciudad" => $this->ciudad,
							  "modulos" => $modulostratados,
							  "cliente" => $clie);
			}
			else{
				$datos = array("nombre" =>$nom,
							  "apellidos" => $ape,
							  "correo" => $email,
							  "password" => $clavenueva,
							  "perfil" => $perf,
							  "cliente" => $clie);

			}
			
		$rpta = ControladorUsuarios::ctrregistroUsuarios($tabla,$datos);

			if ($rpta == "ok") {
				echo $rpta;
			}else{
				echo 2;
			}
	}
	/*=====================================
	=            VALIDAR EMAIL            =
	=====================================*/
	public $validarEmail;

	public function ajaxValidarEmail(){

		$datos = $this->validarEmail;

		$respuesta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","email",$datos);
		
		if (!$respuesta) {

			$respuesta2 = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosclientes","email",$datos);

			if (!$respuesta2) {
				
				echo "false";
			}
			else{
				echo "true";
			}
		}else{
			echo "true";
		}
	}

	/*=================================================
	=            CONSULTAR USUARIOS POR ID            =
	=================================================*/


	public function ajaxConsultUsuario(){
		$id = $this->idUsuario;

		$rpta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$id);

		echo json_encode($rpta);

	}

	/*====================================================
	=            CAMBIAR LA CLAVE DEL USUARIO            =
	====================================================*/
	public function ajaxCambiarClave(){
		$id = $this->idUsuario;
		/*==============================================
		=            CONSULTAMOS SI EXISTE             =
		==============================================*/
		$rpta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$id);
		if ($rpta) {
			/*==============================================================
			=            COMPROBAMOS SI ES LA CONTRASEÑA ACTUAL            =
			==============================================================*/
			if (password_verify($this->claveantigua, $rpta["clave"])) {
				$item1 = "id";
				$item2 = "clave";

				$datos1 = $id;
				/* ENCRIPTAR NUEVA CLAVE */
				$clavenueva = password_hash($this->clavenueva, PASSWORD_BCRYPT);
				$datos2 = $clavenueva;

				$rpta = ControladorUsuarios::ctrActualizarUsuario("usuariosransa",$item1,$item2,$datos1,$datos2);
				if ($rpta) {
					echo "La Contraseña ha sido Actualizada!!";
				}

			}else{
				echo 1;
			}

		}else{
			$rpta2 = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosclientes","id",$id);
			if ($rpta2) {
				/*==============================================================
				=            COMPROBAMOS SI ES LA CONTRASEÑA ACTUAL            =
				==============================================================*/
				if (password_verify($this->claveantigua, $rpta2["clave"])) {
					$item1 = "id";
					$item2 = "clave";
					$datos1 = $id;
					/* ENCRIPTAR NUEVA CLAVE */
					$clavenueva = password_hash($this->clavenueva, PASSWORD_BCRYPT);
					$datos2 = $clavenueva;

					$rpta = ControladorUsuarios::ctrActualizarUsuario("usuariosclientes",$item1,$item2,$datos1,$datos2);
					if ($rpta) {
						echo "La Contraseña ha sido Actualizada!!";
					}					
				}else{
					echo 1;
				}
			}
		}
	}
	/*=================================================
	=            CAMBIO DE FOTO DE USUARIO            =
	=================================================*/
	public function ajaxCambiarFoto(){
		$fotnueva = $this->fotonueva;
		$fotantigua = $this->fotoantigua;
		$id = $this->idUsuario;

		/*==================================================
		=            ELIMINAMOS LA FOTO ANTIGUA            =
		==================================================*/
		if (isset($fotantigua) && !empty($fotantigua)) {
			unlink("../".$fotantigua);
		}
		/*=================================================
		=            ALMACENAMOS LA FOTO NUEVA            =
		=================================================*/		
		$nuevonombre = uniqid();
		$ruta = "../vistas/img/usuarios/";

		move_uploaded_file($fotnueva["tmp_name"], $ruta.$nuevonombre.".png");

		/*=================================================================
		=            COMPROBAMOS SI EXISTE EL USUARIO EN USUARIO RANSA            =
		=================================================================*/
		$rpta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$id);
		if ($rpta) {

			$item1 = "id";
			$item2 = "foto";
			$datos1 = $id;
			$datos2 = substr($ruta.$nuevonombre.".png",3);
			$_SESSION["foto"] = substr($ruta.$nuevonombre.".png",3);

			$rpta = ControladorUsuarios::ctrActualizarUsuario("usuariosransa",$item1,$item2,$datos1,$datos2);
			if ($rpta) {
				echo "Se ha actualizado la foto de su perfil correctamente!!";				
			}else{
				echo 1;
			}

			
		}else{
			$rpta2 = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosclientes","id",$id);
			if ($rpta2) {

				$item1 = "id";
				$item2 = "foto";
				$datos1 = $id;
				$datos2 = substr($ruta.$nuevonombre.".png",3);
				$_SESSION["foto"] = substr($ruta.$nuevonombre.".png",3);

				$rpta = ControladorUsuarios::ctrActualizarUsuario("usuariosclientes",$item1,$item2,$datos1,$datos2);
				if ($rpta) {
					echo "Se ha actualizado la foto de su perfil correctamente!!";				
				}else{
					echo 1;
				}				

			}

		}
		
		
		

		















		

		/*if ($rpta == "ok") {
			
		}*/
	}
	
}
/*============================================
=            REGISTRO DE USUARIOS            =
============================================*/

if (isset($_POST['nombre']) && isset($_POST['correo'])) {
	$registro = new AjaxUsuarios();
	$registro -> nombres = $_POST['nombre'];
	$registro -> apellidos = $_POST['apellido'];
	$registro -> correo = $_POST['correo'];
	$registro -> password = $_POST['password'];
	$registro -> cargo = $_POST['cargopersonal'];
	if (isset($_POST['seCuentaRan'])) {
		$registro -> cuentas = $_POST['seCuentaRan'];	
	}else{
		$registro -> cuentas = isset($_POST['seCuentaRan']);	
	}
	$registro -> perfil =  $_POST['sePerfil'];
	$registro -> cliente = $_POST['seClient'];
	$registro -> modulos = $_POST['seModulo'];
	$registro -> area = $_POST['seArea'];
	$registro -> ciudad = $_POST['seCiudad'];
	$registro -> ajaxingresarUsuarios();
}
/*=============================================
VALIDAR EMAIL EXISTENTE
=============================================*/	
if (isset($_POST['validarEmail'])){
	$validar = new AjaxUsuarios();

	$validar -> validarEmail = $_POST['validarEmail'];

	$validar -> ajaxValidarEmail();
}
/*=============================================
CONSULTAR USUARIOS
=============================================*/	
if (isset($_POST['idUsuario'])) {
	$consulUsuario = new AjaxUsuarios();

	$consulUsuario -> idUsuario = $_POST['idUsuario'];

	$consulUsuario -> ajaxConsultUsuario();

}
/*============================================
=            Cambio de Contraseña            =
============================================*/
if (isset($_POST["claveantigua"])) {
	$cambioClave = new AjaxUsuarios();

	$cambioClave -> claveantigua = $_POST["claveantigua"];
	$cambioClave -> clavenueva = $_POST["clavenueva"];
	$cambioClave -> idUsuario = $_POST["idusuario"];
	$cambioClave -> ajaxCambiarClave();
}
/*=============================================
=            CAMBIO DE IMAGEN USER            =
=============================================*/
if (isset($_FILES['nuevaImagen']['tmp_name'])) {
	$cambioFoto = new AjaxUsuarios();

	$cambioFoto -> fotonueva =  $_FILES['nuevaImagen'];
	$cambioFoto -> fotoantigua = $_POST["imguserAntigua"];
	$cambioFoto -> idUsuario = $_POST["iduser"];
	$cambioFoto -> ajaxCambiarFoto();
}




