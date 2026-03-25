<?php
session_start();
require_once "../controladores/novedadequipo.controlador.php";

require_once "../modelos/novedadequipo.modelo.php";



require_once "../controladores/equipos.controlador.php";

require_once "../modelos/equipos.modelo.php";

require_once "../modelos/rutas.php";


class AjaxTablaNovedadesEquipos
{

	public $perfil;

	public $idciudad;


	public function ajaxConsultarNovedades()
	{

		/*=================================================================

		=            CONSULTAMOS LAS NOVEDADES SEGUN LA CIUDAD del USUARIO            =

		=================================================================*/

		$rpta = ControladorNovedades::ctrConsultarNovedadesEquipos($_SESSION["ciudad"], "idciudad");

		if ($rpta) {

			/*================================================

			=            CONVERTIMOS A DATOS JSON            =

			================================================*/

			$datosJson = '{

	  						"data": [';



			for ($i = 0; $i < count($rpta); $i++) {

				/*=============================================

			=            ESTADO DE LOS EQUIPOS            =

			=============================================*/

				if ($rpta[$i]["estado"] == "PENDIENTE") {

					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {

						$acciones = "<div class='btn-group'><button data-toggle='modal' data-target='#modalFechaPropuesta' type='button' idequipo='" . $rpta[$i]["idequipomc"] . "' idnovedad='" . $rpta[$i]['idnovequipos'] . "' class='btn btn-sm btn-warning btnFechaPropuesta'><i class='far fa-calendar-alt'></i></button>";

						$acciones .= "<button type='button' class=' btn btn-sm btn-success btnConcluidaNovedad' idequipo='" . $rpta[$i]["idequipomc"] . "' idnovedad='" . $rpta[$i]['idnovequipos'] . "' ><i class='fas fa-check-circle'></i></button>";

						$acciones .= "<button type='button' idnovedad='" . $rpta[$i]['idnovequipos'] . "' class=' btn btn-sm btn-danger btnEliminarNovedad'><i class='fa fa-times'></i></button></div>";
					}
				} else if ($rpta[$i]["estado"] == "EN PROCESO") {

					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {

						$acciones = "<div class='btn-group'><button data-toggle='modal' disabled data-target='#modalClasifNovedad' type='button' class='btn btn-sm btn-warning btnFechaPropuesta'><i class='far fa-calendar-alt'></i></button>";

						$acciones .= "<button type='button' class=' btn btn-sm btn-success btnConcluidaNovedad' idequipo='" . $rpta[$i]["idequipomc"] . "' idnovedad='" . $rpta[$i]['idnovequipos'] . "' ><i class='fas fa-check-circle'></i></button>";

						$acciones .= "<button type='button' idnovedad='" . $rpta[$i]['idnovequipos'] . "' class=' btn btn-sm btn-danger btnEliminarNovedad'><i class='fa fa-times'></i></button></div>";
					}
				} else if ($rpta[$i]["estado"] == "CONCLUIDO") {


					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {
						/*=========================================================================
						=            UNA VEZ QUE SE HA CONCLUIDO SE PERMITE VER EL PDF            =
						=========================================================================*/
						$url = Ruta::ctrRuta();

						$acciones = "<div class='btn-group'><form target=_blank' method='POST' action='" . $url .="bpa/EquiposMC/downloadpdf.php' class='btn-group'> <input type='hidden' value='" . $rpta[$i]["idnovequipos"] . "' name='idnovedad'> <button type='submit' class='btn btn-default '><i class='fas fa-file-pdf'></i></button></form></div>";



						// $acciones = "<div class='btn-group'><button data-toggle='modal' disabled data-target='#modalClasifNovedad' type='button' class='btn btn-sm btn-warning btnFechaPropuesta'><i class='far fa-calendar-alt'></i></button>";

						// $acciones .= "<button type='button' class=' btn btn-sm btn-success btnConcluidaNovedad' disabled><i class='fas fa-check-circle'></i></button>";

						// $acciones .= "<button type='button' disabled class=' btn btn-sm btn-danger btnEliminarNovedad'><i class='fa fa-times'></i></button></div>";						

					}
				}
				// }

				/*===========================================================

			=            VERIFICAR SI EXISTE FECHA PROPUESTA            =

			===========================================================*/

				// if ($rpta[$i]["fecha_propuesta"] != "") {

				// 	$fechatentativa = $rpta[$i]["fecha_propuesta"];
				// } else {

				// 	$fechatentativa = "POR ASIGNAR";
				// }

				/*===============================================

			=            PARALIZACION DE EQUIPOS            =

			===============================================*/

				if ($rpta[$i]["paralizacion"] == "NO APLICA") {

					// $estadoparalizacion = "NO APLICA";

					$presentdiaspara = '0 Dias';
				} else if ($rpta[$i]["paralizacion"] == "SI APLICA") {

					// $estadoparalizacion = "SI APLICA";

					/*============================================================================================================

					=            SI AUN NO HA SIDO RESUELTA SALE LA CANTIDAD SEGUN LA FECHA REPORTADA HASTA LA ACTUAL            =

					============================================================================================================*/

					if ($rpta[$i]["fecha_concluida"] == "") {

						$fechainipara = new DateTime($rpta[$i]["fecha_iniparalizacion"]);

						setlocale(LC_TIME, "spanish");

						$fechaactual = date("Y-m-d H:i:s");

						$fechaactualfinal = new DateTime($fechaactual);

						$diasparo = $fechainipara->diff($fechaactualfinal);



						$presentdiaspara = $diasparo->days . ' Dias';
					} else {

						$fechainipara = new DateTime($rpta[$i]["fecha_iniparalizacion"]);

						$fechaactualfinal = new DateTime($rpta[$i]["fecha_concluida"]);

						$diasparo = $fechainipara->diff($fechaactualfinal);

						$presentdiaspara = $diasparo->days . ' Dias';
					}
				}



				// if ($rpta[$i]["estado"] != 0 && $rptaequipo[0]["idciudad"] == $this->idciudad) {

				if ($_SESSION["perfil"] == "OPERATIVO" && $rpta[$i]["estado"] == "EN PROCESO" || $rpta[$i]["estado"] == "PENDIENTE") {

					$datosJson .= '

		        				    [';

					$datosJson .= '"' . $rpta[$i]['idnovequipos'] . '",

		  							  "' . $rpta[$i]['codigo'] . '",

		  							  "' . $rpta[$i]['turno'] . '",

		  							  "' . $rpta[$i]['responsable'] . '",';

					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {

						$datosJson .= '"' . $rpta[$i]['modo'] . '",';
					}

					$datosJson .= '"' . $rpta[$i]['descripcion_novedad'] . '",';

					$datosJson .= '"' . $rpta[$i]['paralizacion'] . '",';

					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {

						$datosJson .= '"' . $presentdiaspara . '",';

						$datosJson .= '"' . $rpta[$i]['fecha'] . '",';
					}



					$datosJson .= '"' . $rpta[$i]['fecha_propuesta'] . '",';

					if ($this->perfil == "OPERATIVO" || $this->perfil == "COORDINADOR") {

						$datosJson .= '"' . $rpta[$i]["estado"] . '"';
					}

					//$datosJson .= '"'.$estado.'"';



					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {

						$datosJson .= '"' . $rpta[$i]["estado"] . '",';

						$datosJson .= '"' . $acciones . '"';
					}



					$datosJson .= '],';

					$valorexistente = true;
				} else if ($_SESSION["perfil"] == "ADMINISTRADOR" || $_SESSION["perfil"] == "COORDINADOR") {

					$datosJson .= '

		        				    [';

					$datosJson .= '"' . $rpta[$i]['idnovequipos'] . '",

		  							  "' . $rpta[$i]['codigo'] . '",

		  							  "' . $rpta[$i]['turno'] . '",

		  							  "' . $rpta[$i]['responsable'] . '",';

					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {

						$datosJson .= '"' . $rpta[$i]['modo'] . '",';
					}

					$datosJson .= '"' . $rpta[$i]['descripcion_novedad'] . '",';

					$datosJson .= '"' . $rpta[$i]["paralizacion"] . '",';

					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {

						$datosJson .= '"' . $presentdiaspara . '",';

						$datosJson .= '"' . $rpta[$i]['fecha'] . '",';
					}



					$datosJson .= '"' . $rpta[$i]["fecha_propuesta"] . '",';

					//$datosJson .= '"'.$estado.'"';



					if ($this->perfil == "ADMINISTRADOR" || $this->perfil == "ROOT") {

						$datosJson .= '"' . $rpta[$i]["estado"] . '",';

						$datosJson .= '"' . $acciones . '"';
					}



					$datosJson .= '],';

					$valorexistente = true;
				}
				// }
			}



			$datosJson = substr($datosJson, 0, -1);

			if (!isset($valorexistente)) {

				$datosJson .= '[';
			}

			$datosJson .= ']

        	}';

			echo $datosJson;
		} else {

			echo $datosJson = '{

  					"data": []}';
		}
	}
}



if (isset($_SESSION['perfil'])) {

	$tablanovedades = new AjaxTablaNovedadesEquipos();

	$tablanovedades->perfil = $_SESSION['perfil'];

	$tablanovedades->idciudad = $_SESSION['ciudad'];

	$tablanovedades->ajaxConsultarNovedades();
}
