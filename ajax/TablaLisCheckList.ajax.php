<?php
session_start();
require_once "../controladores/equipos.controlador.php";

require_once "../modelos/equipos.modelo.php";



require_once "../controladores/checklist.controlador.php";

require_once "../modelos/checklist.modelo.php";

require_once "../modelos/rutas.php";


class AjaxTablaListCheckList{

		public $fecha;

	/*=================================================

	=            CONSULTA DE CHECK LIST REALIZADOS            =

	=================================================*/

	public function ajaxConsultarCheckList(){

		$url = Ruta::ctrRuta();

		date_default_timezone_set('America/Bogota');

		/*=====  OBTENER FECHA ACTUAL O LA CONSULTADA ======*/

		if (isset($this->fecha) && !empty($this->fecha)) {

			$fecha_consultada = date('Y-m-d', strtotime($this->fecha));

			$fechaConsult = $fecha_consultada;

		}else{

			setlocale(LC_TIME, "spanish");

			$fechaactual = date("Y-m-d");

			$fechaConsult = $fechaactual;

		}		

		/*=====  CONSULTAMOS LOS EQUIPOS QUE DIGAN MC - ciudad - estado  ======*/

		$itemeq = array("codigo" =>  "codigo",

						"idciudad" => "idciudad",

						"estado"  => "estado") ;

		$valoreq = array("codigov" => "%MC%",

						"idciudadv" => $_SESSION["ciudad"],

						"estadov" => 0);



		$rptaEqui = ControladorEquipos::ctrConsultarEquipos($valoreq,$itemeq); 



		if (isset($rptaEqui) && !empty($rptaEqui)) {



			$datosJson = '{

	  					"data": [';

	  		/*=====  RECORREMOS LA CONSULTA DE LOS EQUIPOS  ======*/

	  		

			for ($i=0; $i < count($rptaEqui) ; $i++) {

				/*=====  CONSULTAMOS EL CHECK LIST REALIZADOS EN LA FECHA CONSULTADA O ACTUAL  ======*/

				$chvalor1 = $rptaEqui[$i]["idequipomc"];

				$chvalor2 = $fechaConsult;

				$chitem1 = "idequipomc";

				$chitem2 = "fecha";


				/*==================================================================
				=            CONSULTAMOS SI EXISTE CHECK LIST DEL EQUIPO            =
				==================================================================*/
				
				$rptacheck = ControladorCheckList::ctrConsultarCheckList($chvalor1,$chvalor2,$chitem1,$chitem2);					

				$time = localtime(time(), true);

				if ($rptacheck) {

				

					if (count($rptacheck) > 1) {



						for ($j=0; $j < count($rptacheck) ; $j++) { 
							

						$datosJson .= '

							        [';					

						$itemasignacion = "ideasignacion";

						$rptaresponsable = ControladorEquipos::ctrConsultarAsignacionEquipos($rptacheck[$j]["ideasignacion"],$itemasignacion);

							# ============================================================
							# =           VERIFICAMOS EL ESTADO DEL CHECK LIST           =
							# ============================================================
							/**
							 *
							 * 1 ==> cuMPLIDO //////  2 ==> ATRASO  /////  3==> No Cumple
							 *
							 */
							
							if ($rptacheck[$j]["estado"] == 1) {
								$estado = "<span style= 'font-size: 13px' class='label label-primary'>REALIZADO</span>";
	  							$acciones = "<div class='btn-group'><form method='POST' action='".$url."bpa/generarpdfEqcheck.php' class='btn-group'> <input type='hidden' value='".$rptacheck[$j]["idchcklstq"] ."' name='idchcklstq'> <button type='submit' class='btn btn-default '><i class='fas fa-file-pdf'></i></button></form></div>";								
							}else if ($rptacheck[$j]["estado"] == 2) {
								$estado = "<span style= 'font-size: 13px' class='label label-warning'>ATRASO</span>";
	  							$acciones = "<div class='btn-group'><form method='POST' action='".$url."bpa/generarpdfEqcheck.php' class='btn-group'> <input type='hidden' value='".$rptacheck[$j]["idchcklstq"] ."' name='idchcklstq'> <button type='submit' class='btn btn-default '><i class='fas fa-file-pdf'></i></button></form></div>";
							}else if ($rptacheck[$j]["estado"] == 3) {
								$estado = "<span style= 'font-size: 13px' class='label label-danger'>NO CUMPLIO</span>";
	  							$acciones = "NO FUE REALIZADO";								
							}else if ($rptacheck[0]["estado"] == 4) {
								$estado = "<span style= 'font-size: 13px' class='label label-info'>NO OPERATIVO</span>";
								$acciones = "SE ENCUENTRA NO OPERATIVO";
							}

			  				$datosJson .= '"'.$rptaEqui[$i]['codigo'].'",

			  							  "TURNO '.$rptaresponsable['turno'].'",

			  							  "'.$rptaresponsable['responsable'].'",';

			  				$datosJson .= '"'.$rptacheck[$j]['cantinovedad'].'",

									      "'.$rptacheck[$j]['horometro'].'",

									      "'.$rptacheck[$j]['observacion'].'",

									      "'.$rptacheck[$j]['motivoatraso'].'",';

									      if ($_SESSION["perfil"] == "ADMINISTRADOR") {
									      	$datosJson .= '"'.$estado.'",
									      				"'.$acciones.'"';
									      }else{
									      	$datosJson .= '"'.$estado.'"';
									      }

							$datosJson .= '],';									

						}

						

					}else{

						/*=====  SI EXISTE CHECK CONSULTAMOS RESPONSABLES  ======*/

						$datosJson .= '

							        [';					

						$itemasignacion = "ideasignacion";

						$rptaresponsable = ControladorEquipos::ctrConsultarAsignacionEquipos($rptacheck[0]["ideasignacion"],$itemasignacion);

						if ($rptacheck[0]["estado"] == 1) {
							$acciones = "<div class='btn-group'><form method='POST' action='".$url."bpa/generarpdfEqcheck.php' class='btn-group'> <input type='hidden' value='".$rptacheck[0]["idchcklstq"] ."' name='idchcklstq'> <button type='submit' class='btn btn-default '><i class='fas fa-file-pdf'></i></button></form></div>";	
							$estado = "<span style= 'font-size: 13px' class='label label-primary'>REALIZADO</span>";
						}else if ($rptacheck[0]["estado"] == 2) {
							$acciones = "<div class='btn-group'><form method='POST' action='".$url."bpa/generarpdfEqcheck.php' class='btn-group'> <input type='hidden' value='".$rptacheck[0]["idchcklstq"] ."' name='idchcklstq'> <button type='submit' class='btn btn-default '><i class='fas fa-file-pdf'></i></button></form></div>";	
							$estado = "<span style= 'font-size: 13px' class='label label-warning'>ATRASO</span>";
						}else if ($rptacheck[0]["estado"] == 3) {
							$estado = "<span style= 'font-size: 13px' class='label label-danger'>NO CUMPLE</span>";
							$acciones = "NO FUE REALIZADO";
						}else if ($rptacheck[0]["estado"] == 4) {
							$estado = "<span style= 'font-size: 13px' class='label label-info'>NO OPERATIVO</span>";
							$acciones = "SE ENCUENTRA NO OPERATIVO";
						}

			  				$datosJson .= '"'.$rptaEqui[$i]['codigo'].'",

			  							  "TURNO '.$rptaresponsable['turno'].'",

			  							  "'.$rptaresponsable['responsable'].'",';

			  				$datosJson .= '"'.$rptacheck[0]['cantinovedad'].'",

									      "'.$rptacheck[0]['horometro'].'",

									      "'.$rptacheck[0]['observacion'].'",

									      "'.$rptacheck[0]['motivoatraso'].'",';

									      if ($_SESSION["perfil"] == "ADMINISTRADOR") {
									      	$datosJson .= '"'.$estado.'",
									      				"'.$acciones.'"';
									      }else{
									      	$datosJson .= '"'.$estado.'"';
									      }

							$datosJson .= '],';						



					}

				}else{



					

					$datosJson .= '

					        [';	



					$datosJson .= '"'.$rptaEqui[$i]['codigo'].'",';

					/*=====  HACEMOS LA CONSULTA SEGUN EL HORARIO  ======*/

					/**

					 *

					 * DE 8 - 17 => TURNO 1 =====  DE 18 - 2:00 => TURNO 2 ====== DE 24:00 - 7:00 => TURNO 3

					 *

					 */

					

					if ($time["tm_hour"]>=0 && $time["tm_hour"]<=24 ) {

					/*=====  CONSULTAMOS EL TURNO Y EL IDEQUIPO  ======*/

					$valorasig = array("idequipo" => $rptaEqui[$i]["idequipomc"],

										"turno" => 1);

					$itemasig = array("idequipo" => "idequipomc",

										"turno" => "turno");

					$rptarespon = ControladorEquipos::ctrConsultarAsignacionEquipos($valorasig,$itemasig);

					if ($rptaEqui[$i]["estado"] == 2) {
						$estado = "<span style= 'font-size: 13px' class='label label-danger'>NO OPERATIVO</span>";
						$acciones = "<div class='btn-group'><button ideasignacion='".$rptarespon["ideasignacion"]."' idequipo='".$rptaEqui[$i]["idequipomc"]."' type='button' class='btn btn-default btn-sm ReportNoOperativo'><i class='fas fa-times'></i></button></div>";						
					}else{
						$estado = "<span style= 'font-size: 13px' class='label label-danger'>PENDIENTE</span>";	
						$acciones = "<div class='btn-group'><button ideasignacion='".$rptarespon["ideasignacion"]."' idequipo='".$rptaEqui[$i]["idequipomc"]."' type='button' class='btn btn-default btn-sm CerrarTiempoCheck'><i class='fas fa-user-times'></i></button></div>";						
					}



					




	  				$datosJson .= '"TURNO '.$rptarespon["turno"].'",

	  							  "'.$rptarespon["responsable"].'",';

					}	  				

	  				$datosJson .= '"'."".'",

							      "'."".'",

							      "'."".'",
							      
							      "'."".'",';

						      if ($_SESSION["perfil"] == "ADMINISTRADOR") {
						      	$datosJson .= '"'.$estado.'",
						      				"'.$acciones.'"';
						      }else{
						      	$datosJson .= '"'.$estado.'"';
						      }

					$datosJson .= '],';

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

/*===========================================

=            CONSULTA DE LISTADO DE CHECK LIST REALIZADOS            =

===========================================*/

if (isset($_SESSION['id'])) {

	$consultaCheckList = new AjaxTablaListCheckList();

	if (isset($_POST["fecha"])) {

		$consultaCheckList -> fecha = $_POST["fecha"];

	}else{

		$consultaCheckList -> fecha = "";

	}

	$consultaCheckList -> ajaxConsultarCheckList();

}







