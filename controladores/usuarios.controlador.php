<?php


class ControladorUsuarios{



/*====================================================================

=            VALIDACION DE USUARIO AL INGRESAR AL SISTEMA            =

====================================================================*/

	public function ctrinicioUsuarios($tabla,$item,$valor){

		if ($item != null) {
			

			if (isset($_POST['email'])) {

			/*----------  VALIDAR SI ES UN CORREO Y CONTRASEÑA  ----------*/

			if (preg_match('/^[^0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST['email']) && 

				preg_match('/^[a-zA-Z0-9]+$/', $_POST['password'])){

				
					
				/*----------  VALIDAR SI EN EL CORREO TIENE EL DOMINIO "RANSA"  ----------*/

				
					if (isset($_POST["tipo_user"]) && $_POST["tipo_user"] == "Cliente") {
						$tabla = "usuariosclientes";

						$item = "email";

						$valor = $_POST['email'];
					}else if (isset($_POST["tipo_user"]) && $_POST["tipo_user"] == "Proveedor") {
						$tabla = "proveedor_estibas";

						$item = "email";

						$valor = $_POST['email'];
					}else{
						$tabla = "usuariosransa";

						$item = "email";

						$valor = $_POST['email'];

					}





				

				// var_dump( password_hash($_POST['password'], PASSWORD_BCRYPT) );
				// exit();
				// echo $tabla;

				$rpta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);

					if ($rpta != false && $rpta['email'] == $_POST['email'] && password_verify($_POST['password'],$rpta['clave']) ) {



						if ($rpta['estado'] == 1) {

							/*======================================
							=            USUARIOS RANSA            =
							======================================*/
							
							
							

							if ($tabla == "usuariosransa" && $_POST["tipo_user"] == "Seleccionar tipo de Usuario") {

								$_SESSION["validarSession"] = "ok";		

								$_SESSION["id"] = $rpta["id"];

								$_SESSION["nombre"] = $rpta["primernombre"];

								$_SESSION["apellido"] = $rpta["primerapellido"];

								$_SESSION["perfil"] = $rpta["perfil"];

								$_SESSION["email"] = $rpta["email"];

								$_SESSION["password"] = $rpta["clave"];

								$_SESSION["foto"] = $rpta["foto"];

								$_SESSION["cargo"] = $rpta["cargo"];

								$_SESSION["modulos"] = $rpta["idmodulos"];

								if (isset($rpta['razonsocial'])) {

									$_SESSION["cliente"] = $rpta['razonsocial'];

									$_SESSION["idcliente"] = $rpta['idcliente'];

								}

								if (isset($rpta['cuentas'])) {

									$_SESSION["cuentas"] = $rpta['cuentas']; 

									$_SESSION["area"] = $rpta["idareas"];

									$_SESSION["ciudad"] = $rpta["idciudad"];
									$_SESSION["idlocalizacion"] = $rpta["idlocalizacion"];

								}
							//$_SESSION["perfil"] = $rpta["perfil"];
							// ini_set("session.gc_maxlifetime", 7200);
								echo '<script>



									window.location = "inicio";



								</script>';														
								/*============================================
								=            USUARIOS DE CLIENTES            =
								============================================*/
								
								
								
							}else if ($tabla == "usuariosclientes" && $_POST["tipo_user"] == "Cliente") {

								$_SESSION["validarSession"] = "ok";

								$_SESSION["id"] = $rpta["id"];

								$_SESSION["nombre"] = $rpta["primernombre"];

								$_SESSION["apellido"] = $rpta["primerapellido"];

								$_SESSION["perfil"] = $rpta["perfil"];

								$_SESSION["email"] = $rpta["email"];

								$_SESSION["password"] = $rpta["clave"];

								$_SESSION["foto"] = $rpta["foto"];

								$_SESSION["cargo"] = $rpta["cargo"];

								$_SESSION["modulos"] = $rpta["idmodulos"];

								$_SESSION["ciudad"] = $rpta["idciudad"];

								if (isset($rpta['razonsocial'])) {

									$_SESSION["cliente"] = $rpta['razonsocial'];

									$_SESSION["idcliente"] = $rpta['idcliente'];

								}

								if (isset($rpta['cuentas'])) {

									$_SESSION["cuentas"] = $rpta['cuentas']; 

									$_SESSION["area"] = $rpta["idareas"];

									

								}
							//$_SESSION["perfil"] = $rpta["perfil"];
							// ini_set("session.gc_maxlifetime", 7200);
								echo '<script>



									window.location = "inicio";



								</script>';								
								/*============================================
								=            USUARIOS PROVEEDORES            =
								============================================*/
								
								
								
							}else if ($tabla == "proveedor_estibas" && $_POST["tipo_user"] == "Proveedor") {

								$_SESSION["validarSession"] = "ok";		

								$_SESSION["id"] = $rpta["idproveedor_estiba"];

								$_SESSION["apellido"] = $rpta["ruc"];

								$_SESSION["email"] = $rpta["correo"];

								// $_SESSION["nombre"] = $rpta["nombre_proveedor"];

								$_SESSION["password"] = $rpta["clave"];

								$_SESSION["nombre_Proveedor"] = $rpta["nombre_proveedor"];

								$_SESSION["perfil"] = "Proveedor";

							// ini_set("session.gc_maxlifetime", 7200);
								echo '<script>



									window.location = "OT-Realizadas";



								</script>';
							}else{
										echo '<br>

					<div class="alert alert-danger">Error al ingresar vuelva a intentarlo</div>';

							}



						}else{

							echo '<br>

						<div class="alert alert-warning">Este usuario aún no está activado</div>';



						}

					}else{

										echo '<br>

					<div class="alert alert-danger">Error al ingresar vuelva a intentarlo</div>';

					}

			}

			

		}

			

		}

	}

/*======================================================================

=            RESGISTRO DE USUARIOS DE LA EMPRESA Y CLIENTES            =

======================================================================*/



	static public function ctrregistroUsuarios($tabla,$datos){



		$rpta = ModeloUsuarios::mdlIngresarUsuarios($tabla,$datos);

		

		return $rpta;



	}

/*==============================================

=            MOSTRAR USUARIOS DE LA EMPRESA            =

==============================================*/



	public static function ctrMostrarUsuariosRansa($tabla,$item,$valor){





		$respuesta = ModeloUsuarios::mdlMostrarUsuarios($tabla,$item,$valor);



		return $respuesta;

	}



	/*===================================================

	=            ACTUALIZAR DATOS AL USUARIO            =

	===================================================*/

	public function ctrActualizarUsuario($tabla,$item1,$item2,$valor1,$valor2){



		$respuesta = ModeloUsuarios::mdlActualizarUsuario($tabla,$item1,$item2,$valor1,$valor2);



		return $respuesta;

	}

	

	



	}

