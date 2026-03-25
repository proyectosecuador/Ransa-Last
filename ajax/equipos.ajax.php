<?php
session_start();
require_once "../controladores/equipos.controlador.php";
require_once "../modelos/equipos.modelo.php";

require_once "../controladores/usuarios.controlador.php";
require_once "../modelos/usuarios.modelo.php";

require_once "../controladores/ciudad.controlador.php";
require_once "../modelos/ciudad.modelo.php";

require_once "../controladores/tip_equipo.controlador.php";
require_once "../modelos/tip_equipo.modelo.php";

require_once "../controladores/localizacion.controlador.php";
require_once "../modelos/localizacion.modelo.php";

require_once "../controladores/centrocosto.controlador.php";
require_once "../modelos/centrocosto.modelo.php";

require_once "../controladores/checklist.controlador.php";
require_once "../modelos/checklist.modelo.php";

require_once "../controladores/novedadequipo.controlador.php";
require_once "../modelos/novedadequipo.modelo.php";

require_once "../controladores/personal.controlador.php";
require_once "../modelos/personal.modelo.php";

require_once "../controladores/manejoeq.controlador.php";
require_once "../modelos/manejoeq.modelo.php";

use  PHPMailer\PHPMailer\PHPMailer ; 
use  PHPMailer\PHPMailer\Exception ;


require_once '../extensiones/PHPMailer/PHPMailer/src/Exception.php';
require_once '../extensiones/PHPMailer/PHPMailer/src/PHPMailer.php';
require_once '../extensiones/PHPMailer/PHPMailer/src/SMTP.php';

require_once  "../extensiones/PHPMailer/vendor/autoload.php";

require '../extensiones/PhpSpreadSheet/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class AjaxEquipos{
	/*==========================================
	=            REGISTRO DE EQUIPO            =
	==========================================*/
	public $idequipo;
	public $Equipo;
	public $modelo;
	public $ciudad;
	public $tipoEquipo;
	public $serie;
	public $baterias;
	public $codigo;
	public $iduser;
	public $idlocalizacion;
	public $epadre;
	public $horometro;
	public $centrocosto;
	public $motivoatraso;
	/*=====  VARIABLES PARA ASIGNACION DE EQUIPOS  ======*/
	public $idasignacion;
	public $idusuarioransa;
	public $llave;
	public $responsable;
	public $turno;
	/*=====  VARIABLES CIUDAD  ======*/
	public $desc_ciudad;
	/* VARIABLES PARA TIPOS DE EQUIPOS */
	public $tipo_equipo;
	public $descripcion_equipo;
	/* VARIABLES PARA LOCALIZACION */
	public $localizacion;
	/* VARIABLES DE CENTRO DE COSTO */
	public $nombre_cc;
	public $desripcion;
	/* VARIABLES PARA CHECK LIST */
	public $equipo;
	public $bateria;
	public $carrobateria;
	public $cargador;
	public $operacional;
	public $horochecklist;
	public $obserchecklist;
	public $forma;
	/*=====  VARIABLES PARA NOVEDADES EQUIPOS  ======*/
	public $fecha_propuesta;
	public $idnovequipos;
	public $clasnovedad;
	public $ot;
	public $observacionesot;
	public $correonoti;
	public $datanovedad;
	/*=====  VARIABLES DE MANEJO DE EQUIPOS  ======*/
	public $idmanejoeq;
	public $opciones;
	public $personal;
	public $identbinicio;
	public $porcbinicio;
	public $horoinicio;
	public $fecha_fin;
	public $observacion;
	public $horotermino;
	public $porcbtermino;
	public $identbtermino;
	public $ubicacion;
	public $personalnuevo;
    public $codigo_baterias;
	public $motivobloq;
	public $OTpdf;
	public $rutaotRealizada;

	
	

	public function ajaxRegistrarEquipo(){
		$valorconcatenado = $this->Equipo." ".$this->modelo." ".$this->serie." {".$this->codigo."}";

		if ($this->epadre == "") {
			$this->epadre = null;
		}else if ($this->horometro == "") {
				$this->horometro = null;
		}

		$datos = array("Equipo" => $this->Equipo,
						"modelo" => $this->modelo,
						"ciudad" => $this->ciudad,
						"tipoEquipo" => $this->tipoEquipo,
						"serie" => $this->serie,
						"baterias" => $this->baterias,
						"codigo" => $this->codigo,
						"iduser" => $this->iduser,
						"localizacion" => $this->idlocalizacion,
						"epadre"	 => $this->epadre,
						"horometro"	 => $this->horometro,
						"concatenar" => $valorconcatenado,
						"centrocosto" => $this->centrocosto);
				
		$rpta = ControladorEquipos::ctrRegistrarEquipo($datos);

		echo $rpta;

	}
	/*==========================================
	=            CONSULTA DE EQUIPO            =
	==========================================*/
	public function ajaxConsultarEquipos(){
		$dato = $this->idequipo;
		$item = "idequipomc";

		$rpta = ControladorEquipos::ctrConsultarEquipos($dato,$item);

		echo json_encode($rpta,true);

	}
	/*=======================================================
	=            EDITAR LOS DATOS DE LOS EQUIPOS            =
	=======================================================*/
	public function ajaxEditarEquipo(){

		$valorconcatenado = $this->Equipo." ".$this->modelo." ".$this->serie." {".$this->codigo."}";

		if ($this->epadre == "") {
			$this->epadre = null;
		}else if ($this->horometro == "") {
				$this->horometro = null;
		}

		$datos = array("Equipo" => $this->Equipo,
						"ciudad" => $this->ciudad,
						"modelo" => $this->modelo,
						"tipoEquipo" => $this->tipoEquipo,
						"codigo" => $this->codigo,
						"horometro" => $this->horometro,
						"serie" => $this->serie,
						"baterias" => $this->baterias,
						"idequipo" => $this->idequipo,
						"idlocalizacion" => $this->idlocalizacion,
						"epadre" => $this->epadre,
						"iduser" => $this->iduser,
						"concatenar" => $valorconcatenado,
						"idcentro_costo" => $this->centrocosto);
		$item = "idequipomc";

		$rpta = ControladorEquipos::ctrEditarEquipos($datos,$item);
		echo $rpta;
	}
        //  public function idbateria(){
		// 	$dato = $this->idequipo;
		// 	$item = "idequipomc";
	
		// 	$rpta = ControladorEquipos::ctrConsultarEquipos($dato,$item);
	
		// 	echo json_encode($rpta,true);
	    //  }

	/*=======================================================
	=            ASIGNAR RESPONSABLES DE EQUIPOS            =
	=======================================================*/
	public function ajaxAsignarResponsable(){
		$datos = array("idequipomc" => $this->idequipo,
						"idusuarioransa" => $this->idusuarioransa,
						"llave" => $this->llave,
						"responsable" => strtoupper($this->responsable),
						"turno" => $this->turno,
						"iduser" => $this->iduser);
		$rpta = ControladorEquipos::ctrAsignarEquipos($datos);
		echo $rpta;
	}
	/*=======================================================
	=            CONSULTAR ASIGNACION DE EQUIPOS            =
	=======================================================*/
	public function ajaxConsultarAsignacionEquipos(){
		$datos = $this->idequipo;
		$item = "idequipomc";

		$rpta = ControladorEquipos::ctrConsultarAsignacionEquipos($datos,$item);

		echo '<div class="table-responsive">
                     <table class=" TablaAsignacion table table-striped table-bordered dt-responsive nowrap">
                        <thead>
                          <tr>
                            <th>Turno</th>
                            <th>Supervisor</th>
                            <th>Equipo</th>
                            <th>Responsable</th>
                            <th># Llave</th>
                            <th>Acciones</th>
                          </tr>
                        </thead>
                        <tbody>';
                        for ($i=0; $i < count($rpta) ; $i++) {
                        	/*===============================================
                        	=            CONSULTAR EL SUPERVISOR            =
                        	===============================================*/
                        	$tabla = "usuariosransa";
                        	$item = "id";
                        	$valor = $rpta[$i]["idusuariosransa"];
                        	$usuasupervisor = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$item,$valor);

                        	$nombres = explode(" ", $usuasupervisor["primernombre"]);
                        	$apellidos = explode(" ", $usuasupervisor["primerapellido"]);
							/*======================================================
							=            CONSULTAR EL CODIGO DEL EQUIPO            =
							======================================================*/
							$dato = $rpta[$i]["idequipomc"];
							$item2 = "idequipomc";
							$equipomc = ControladorEquipos::ctrConsultarEquipos($dato,$item2);

							$acciones = "<button type='button' turno='".$rpta[$i]["turno"]."' idasignacion='".$rpta[$i]["ideasignacion"]."' class=' btn btn-xs btn-danger btnEliminarAsignacion'><i class='fa fa-times'></i></button>";

							if ($rpta[$i]["estado"] == 1) {

								echo '<tr><td> TURNO'.$rpta[$i]["turno"].'</td>
								<td>'.strtoupper($nombres[0].' '.$apellidos[0]).'</td>
								<td>'.$equipomc[0]["codigo"].'</td>
								<td>'. strtoupper($rpta[$i]["responsable"]).'</td>
								<td>'.$rpta[$i]["llave"].'</td>
								<td>'.$acciones.'</td></tr>';
								
							}
                        }

                        echo'</tbody>
                    </table>                      
                      
                    </div>';
	}
	/*==============================================================================================
	=            CONSULTA DE ASIGNACION DE EQUIPO PARA BLOQUEAR EL QUE YA ESTA ASIGNADO            =
	==============================================================================================*/
	public function ajaxConsultadeAsignacion(){
		$datos = $this->idequipo;
		$item = "idequipomc";

		$rpta = ControladorEquipos::ctrConsultarAsignacionEquipos($datos,$item);

		echo json_encode($rpta,true);

	}
	/*===========================================================================
	=            ELIMINAR ASIGNACION DE EQUIPO PARA NUEVA ASIGNACION            =
	===========================================================================*/
	public function ajaxEliminarAsignacion(){
		$dato = $this->idasignacion;
		$item = "ideasignacion";

		$rpta = ControladorEquipos::ctrEliminarAsignacion($dato,$item);

		echo $rpta;
	}
	/*=======================================
	=            ELIMINAR EQUIPO            =
	=======================================*/
	public function ajaxEliminarEquipo(){
		$valor1 = $this->idequipo;
		$item1 = "idequipomc";
		$item2 = "estado";
		$valor2 = 0;

		$rpta = ControladorEquipos::ctrEliminarEquipo($item1,$valor1,$item2,$valor2);

		echo $rpta;

	}

	/*================================================
	=            REGISTRO DE NUEVA CIUDAD            =
	================================================*/
	public function ajaxRegistrarCiudad(){
		$nombre = $this->desc_ciudad;

		$rpta = ControladorCiudad::ctrRegistroCiudad($nombre);

		echo $rpta;
	}
	/*========================================================
	=            REGISTRO DE NUEVO TIPO DE EQUIPO            =
	========================================================*/
	public function ajaxRegistroTipoEquipo(){
		$tip_equipo = $this->tipo_equipo;
		$descrip = 	$this->descripcion_equipo;

		$datos = array("tip_Equipo" => $tip_equipo,
						"descrip_EQuipo" => $descrip);

		$rpta = ControladorTEquipo::ctrRegistroTequipo($datos);

		echo $rpta;
	}
	/*======================================================
	=            REGISTRO DE NUEVA LOCALIZACION            =
	======================================================*/
	public function ajaxRegistroLocalizacion(){
		$dato = $this->localizacion;

		$rpta = ControladorLocalizacion::ctrRegistroLocalizacion($dato);

		echo $rpta;

	}
	/*================================================================
	=            CONSULTAR LOCALIZACION DEL EQUIPO PADRES            =
	================================================================*/
	public function ajaxConsultarLocalizacionEP(){
		$dato = $this->idlocalizacion;
		$item = "idlocalizacion";

		$rpta = ControladorLocalizacion::ctrConsultarLocalizacion($dato,$item);

		echo json_encode($rpta);
	}
	public function consultaSelectE(){
		$dato = $this->idequipo;

		$rpta = ControladorEquipos::ctrConsultarEquipos($_SESSION["ciudad"],"idciudad");;

		echo json_encode($rpta,true);
		
	}
	/*===================================================
	=            REGISTRO DE CENTRO DE COSTO            =
	===================================================*/
	public function ajaxRegistroCC(){
		$dato = array("nombre" => $this->nombre_cc,
						"descripcion" => $this->descripcion);

		$rpta = ControladorCentroCosto::ctrRegistroCentroCosto($dato);

		echo $rpta;
	}
	/*==================================================
	=            SELECCION DE EQUIPO POR MC            =
	==================================================*/
	public function ajaxSeleccionEquipoMC(){

		$dato = $this->codigo;
		$item = "codigo";

		$rpta = ControladorEquipos::ctrConsultarEquipos($dato,$item);
		/**
		 *
		 * estado de los equipos
		 0 => equipo eliminado
		 1 => equipo activo
		 2 => equipo inoperativo
		 *
		 */
		$resultvarios = array();
		if ($rpta) {
			if (count($rpta) > 1 ) {
				for ($i=0; $i < count($rpta) ; $i++) { 
					if ($rpta[$i]["estado"] == 1) {
					    array_push($resultvarios,$rpta[$i]);
						echo json_encode($resultvarios,true);
						
					}
				}
			}else{
				if ($rpta[0]["estado"] == 2) {
					echo 2;
				}else if ($rpta[0]["estado"] == 0) {
					echo 0;
				}else{
					echo json_encode($rpta,true);	
				}
			}
		}else{
			echo 1;
		}
	}
	/*==============================================================
	=            BUSCAR RESPONSABLE ASIGNADO CHECK LIST            =
	==============================================================*/
	public function ajaxBuscarAsignador(){
		$datos = $this->idequipo;
		$item = "idequipomc";

		$rpta = ControladorEquipos::ctrConsultarAsignacionEquipos($datos,$item);
			echo json_encode($rpta,true);	
	}
	
	/*==============================================
	=            REGISTRO DE CHECK LIST            =
	==============================================*/
	public function ajaxRegistroCheckList(){

		$this->forma;
		/*=====  RECORREMOS EL ARREGLO DE LOS ITEMS DE EQUIPO  ======*/
		$check_equipo = json_decode($this->equipo,true);
		foreach($check_equipo as $keyequipo => $valueequipo){	
			foreach ($valueequipo as $datosequipo => $valuedatosequipo) {
				switch ($datosequipo) {
					case 0:
						if (is_string($valuedatosequipo)) {
							$eqp1 = 1;
							$eqpnovedad1 = $valuedatosequipo;
						}else{
							$eqp1 = $valuedatosequipo;
							$eqpnovedad1 = null;
							
						}
						break;
					case 1:
						if (is_string($valuedatosequipo)) {
							$eqp2 = 1;
							$eqpnovedad2 = $valuedatosequipo;
						}else{
							$eqp2 = $valuedatosequipo;
							$eqpnovedad2 = null;
						}
						break;
					case 2:
						if (is_string($valuedatosequipo)) {
							$eqp3 = 1;
							$eqpnovedad3 = $valuedatosequipo;
						}else{
							$eqp3 = $valuedatosequipo;
							$eqpnovedad3 = null;
						}
						break;
					case 3:
						if (is_string($valuedatosequipo)) {
							$eqp4 = 1;
							$eqpnovedad4 = $valuedatosequipo;
						}else{
							$eqp4 = $valuedatosequipo;
							$eqpnovedad4 = null;
						}
						break;
					case 4:
						if (is_string($valuedatosequipo)) {
							$eqp5 = 1;
							$eqpnovedad5 = $valuedatosequipo;
						}else{
							$eqp5 = $valuedatosequipo;
							$eqpnovedad5 = null;
						}
						break;
					case 5:
						if (is_string($valuedatosequipo)) {
							$eqp6 = 1;
							$eqpnovedad6 = $valuedatosequipo;
						}else{
							$eqp6 = $valuedatosequipo;
							$eqpnovedad6 = null;
						}
						break;
					case 6:
						if (is_string($valuedatosequipo)) {
							$eqp7 = 1;
							$eqpnovedad7 = $valuedatosequipo;
						}else{
							$eqp7 = $valuedatosequipo;
							$eqpnovedad7 = null;
						}
						break;
				}

			}	

		}				
		/*=====  RECORREMOS EL ARREGLO DE LOS ITEMS DE BATERIA  ======*/
		$check_bateria = json_decode($this->bateria,true);

		foreach($check_bateria as $keybateria => $valuebateria){	
			foreach ($valuebateria as $datosbateria => $valuedatosbateria) {
				switch ($datosbateria) {
					case 0:
						if (is_string($valuedatosbateria)) {
							$btr1 = 1;
							$btrnovedad1 = $valuedatosbateria;
						}else{
							$btr1 = $valuedatosbateria;
							$btrnovedad1 = null;
							
						}
						break;
					case 1:
						if (is_string($valuedatosbateria)) {
							$btr2 = 1;
							$btrnovedad2 = $valuedatosbateria;
						}else{
							$btr2 = $valuedatosbateria;
							$btrnovedad2 = null;
						}
						break;
				}

			}	

		}

		//var_dump($check_bateria)."<br>";
		/*=====  RECORREMOS EL ARREGLO DE LOS ITEMS DE CARRO DE BATERIA  ======*/
		$check_carro_bateria = json_decode($this->carrobateria,true);

		foreach($check_carro_bateria as $keycarro_bateria => $valuecarro_bateria){	
			foreach ($valuecarro_bateria as $datoscarro_bateria => $valuedatoscarro_bateria) {
				switch ($datoscarro_bateria) {
					case 0:
						if (is_string($valuedatoscarro_bateria)) {
							$cbtr1 = 1;
							$cbtrnovedad1 = $valuedatoscarro_bateria;
						}else{
							$cbtr1 = $valuedatoscarro_bateria;
							$cbtrnovedad1 = null;
							
						}
						break;
					case 1:
						if (is_string($valuedatoscarro_bateria)) {
							$cbtr2 = 1;
							$cbtrnovedad2 = $valuedatoscarro_bateria;
						}else{
							$cbtr2 = $valuedatoscarro_bateria;
							$cbtrnovedad2 = null;
						}
						break;
				}

			}	

		}			


		//var_dump($check_carro_bateria)."<br>";
		/*=====  RECORREMOS EL ARREGLO DE LOS ITEMS DE CARGADOR  ======*/
		$check_cargador = json_decode($this->cargador,true);

		foreach($check_cargador as $keycargador => $valuecargador){	
			foreach ($valuecargador as $datoscargador => $valuedatoscargador) {
				switch ($datoscargador) {
					case 0:
						if (is_string($valuedatoscargador)) {
							$crgd1 = 1;
							$crgdnovedad1 = $valuedatoscargador;
						}else{
							$crgd1 = $valuedatoscargador;
							$crgdnovedad1 = null;
							
						}
						break;
					case 1:
						if (is_string($valuedatoscargador)) {
							$crgd2 = 1;
							$crgdnovedad2 = $valuedatoscargador;
						}else{
							$crgd2 = $valuedatoscargador;
							$crgdnovedad2 = null;
						}
						break;
					case 2:
						if (is_string($valuedatoscargador)) {
							$crgd3 = 1;
							$crgdnovedad3 = $valuedatoscargador;
						}else{
							$crgd3 = $valuedatoscargador;
							$crgdnovedad3 = null;
						}
						break;						
				}

			}	

		}
		/*=====  RECORREMOS EL ARREGLO DE LOS ITEMS DE OPERACIONAL  ======*/
		$check_operacional = json_decode($this->operacional,true);
		foreach($check_operacional as $keyoperacional => $valueoperacional){	
			foreach ($valueoperacional as $datosoperacional => $valuedatosoperacional) {
				switch ($datosoperacional) {
					case 0:
						if (is_string($valuedatosoperacional)) {
							$oprc1 = 1;
							$oprcnovedad1 = $valuedatosoperacional;
						}else{
							$oprc1 = $valuedatosoperacional;
							$oprcnovedad1 = null;
							
						}
						break;
					case 1:
						if (is_string($valuedatosoperacional)) {
							$oprc2 = 1;
							$oprcnovedad2 = $valuedatosoperacional;
						}else{
							$oprc2 = $valuedatosoperacional;
							$oprcnovedad2 = null;
						}
						break;
					case 2:
						if (is_string($valuedatosoperacional)) {
							$oprc3 = 1;
							$oprcnovedad3 = $valuedatosoperacional;
						}else{
							$oprc3 = $valuedatosoperacional;
							$oprcnovedad3 = null;
						}
						break;
					case 3:
						if (is_string($valuedatosoperacional)) {
							$oprc4 = 1;
							$oprcnovedad4 = $valuedatosoperacional;
						}else{
							$oprc4 = $valuedatosoperacional;
							$oprcnovedad4 = null;
						}
						break;
					case 4:
						if (is_string($valuedatosoperacional)) {
							$oprc5 = 1;
							$oprcnovedad5 = $valuedatosoperacional;
						}else{
							$oprc5 = $valuedatosoperacional;
							$oprcnovedad5 = null;
						}
						break;
					case 5:
						if (is_string($valuedatosoperacional)) {
							$oprc6 = 1;
							$oprcnovedad6 = $valuedatosoperacional;
						}else{
							$oprc6 = $valuedatosoperacional;
							$oprcnovedad6 = null;
						}
						break;
					case 6:
						if (is_string($valuedatosoperacional)) {
							$oprc7 = 1;
							$oprcnovedad7 = $valuedatosoperacional;
						}else{
							$oprc7 = $valuedatosoperacional;
							$oprcnovedad7 = null;
						}
						break;
					case 7:
						if (is_string($valuedatosoperacional)) {
							$oprc8 = 1;
							$oprcnovedad8 = $valuedatosoperacional;
						}else{
							$oprc8 = $valuedatosoperacional;
							$oprcnovedad8 = null;
						}
						break;
					case 8:
						if (is_string($valuedatosoperacional)) {
							$oprc9 = 1;
							$oprcnovedad9 = $valuedatosoperacional;
						}else{
							$oprc9 = $valuedatosoperacional;
							$oprcnovedad9 = null;
						}
						break;
				}

			}	

		}
		/*================================================================
			=            OBTENER EL DATO DE CANTIDAD DE NOVEDADES            =
		================================================================*/
		$datosnovedades = array();
		array_push($datosnovedades,array("obseqp1" =>$eqpnovedad1,
										 "obseqp2" =>$eqpnovedad2,
										"obseqp3" =>$eqpnovedad3,
										"obseqp4" =>$eqpnovedad4,
										"obseqp5" =>$eqpnovedad5,
										"obseqp6" =>$eqpnovedad6,
										"obseqp7" =>$eqpnovedad7,
										"obsbtr1" =>$btrnovedad1,
										"obsbtr2" =>$btrnovedad2,
										"obscbtr1" =>$cbtrnovedad1,
										"obscbtr2" =>$cbtrnovedad2,
										"obscrgd1" => $crgdnovedad1,
										"obscrgd2" => $crgdnovedad2,
										"obscrgd1" =>  $crgdnovedad3,
										"obsoprc1" => $oprcnovedad1,
										"obsoprc2" => $oprcnovedad2,
										"obsoprc3" => $oprcnovedad3,
										"obsoprc4" => $oprcnovedad4,
										"obsoprc5" => $oprcnovedad5,
										"obsoprc6" => $oprcnovedad6,
										"obsoprc7" => $oprcnovedad7,
										"obsoprc8" => $oprcnovedad8,
										"obsoprc9" => $oprcnovedad9));
		$cantnovedades = 0;	
		$chackobs = array();
		/*=================================================================================================
		=            CONVERTIR EL ARRAY MULTIDIMENSIONAL EN UNO SIMPLE DE OBSERVACIONES DE CHECK LIST EQUIPO            =
		=================================================================================================*/
		foreach ($datosnovedades as $keyob => $valueob) {
			foreach ($valueob as $keysobs => $valuesobs) {
				if (!empty($valuesobs)) {
					$chackobs[$keysobs] = strtoupper($valuesobs);
					$cantnovedades += 1;
				}
				
			}
		}
		if ($this->motivoatraso != "" || $this->motivoatraso != NULL) {
			$motivo = strtoupper($this->motivoatraso);
			$estadocheck = 2;
		}else{
			$motivo = NULL;
			$estadocheck = 1;
		}
		/*=====  DATOS PARA ENVIAR A LA BASE TABLA CHECKLIST  ======*/
		$datos = array("idequipomc" =>  $this->idequipo,
						"eqp1" =>  $eqp1,
						"eqp2" =>  $eqp2,
						"eqp3" =>  $eqp3,
						"eqp4" =>  $eqp4,
						"eqp5" =>  $eqp5,
						"eqp6" => $eqp6,
						"eqp7" => $eqp7,
						"btr1" => $btr1,
						"btr2" => $btr2,
						"cbtr1" => $cbtr1 ,
						"cbtr2" => $cbtr2 ,
						"crgd1" => $crgd1 ,
						"crgd2" => $crgd2 ,
						"crgd3" => $crgd3  ,
						"oprc1" =>  $oprc1 ,
						"oprc2" =>  $oprc2 ,
						"oprc3" =>  $oprc3 ,
						"oprc4" =>  $oprc4 ,
						"oprc5" =>  $oprc5 ,
						"oprc6" =>  $oprc6 ,
						"oprc7" =>  $oprc7 ,
						"oprc8" =>  $oprc8 ,
						"oprc9" =>  $oprc9 ,
						"cantinovedad" => $cantnovedades,
						"horometro" => $this->horochecklist,
						"ideasignacion" => $this->idasignacion,
						"motivoatraso" => $motivo,
						"observacion" => strtoupper($this->obserchecklist),
						"motivobloq" => NULL,
						"estado" => $estadocheck);
		/*========================================================
		=            INGRESAMOS VALORES DE CHECK LIST            =
		========================================================*/
		$rpta = ControladorCheckList::ctrRegistroCheckList($datos);
		/*============================================================================
		=            LLENAR UN ARREGLO CON TODAS LAS NOVEDADES DE EQUIPOS            =
		============================================================================*/

		$respuesta = "";
		if ($rpta != 0) {
			$respuesta = "ok";
			$contnovedad = 0;
			$descripcioncheck = "";
			$modalidad = "CHECKLIST";
			$text_paraliza = "NO APLICA";
			$estadoEquipo = "OPERATIVO";
			/*===========================================================================
			=            INGRESAMOS LAS OBSERVACIONES EN LA TABLA EN GENERAL            =
			===========================================================================*/
			foreach ($datosnovedades as $key => $value) {
				foreach ($value as $keys => $valuess) {
					if ($valuess != null) {
						$descripcioncheck = $valuess;
						$datos_novedad_base = array("idequipo" => $this->idequipo,
													"ideasignacion" => $this->idasignacion,
													"idchcklstq" => $rpta,
													"descripcion" => strtoupper($valuess),
													"modo" => $modalidad);
						/*=====  DATOS PARA ENVIAR A LA BASE TABLA NOVEDADES  ======*/					
						$rptanovedad = ControladorNovedades::ctrRegistroNovedadeschl($datos_novedad_base);
						$contnovedad += 1;
						
					}
				}
			}
			/*==========================================================================================
			=            INGRESAMOS LAS NOVEDADES EN CADA UNO DE LOS ITEMS CORRESPONDIENTES            =
			==========================================================================================*/
			$itemtotal = array_slice($datos,1,23);
			if (!empty($chackobs)) {
				$rptaObserChecKEquipo = ControladorNovedades::ctrRegistroItemsNovedades($chackobs,$itemtotal,$rpta);
				if ($rptaObserChecKEquipo == "ok") {
					$respuesta .= ";".$contnovedad;
				}			
			}else{
					$respuesta .= ";"."0";
			}


		}
		
		$cantidadnovedad = explode(";", $respuesta);
		/*===========================================================
		=            CONFIGURACIÓN DE CORREO ELECTRONICO            =
		===========================================================*/		
				/*****ubicacion de Zona Horaria*****/
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");
		$fecha_actual_correo = utf8_encode(strftime("%A, %d de %B de %Y"));

		/*=====================================================
		=            CONSULTA DE EQUIPO MONTACARGA            =
		=====================================================*/
		$itemmontacarga = "idequipomc";
		$rptamontacarga = ControladorEquipos::ctrConsultarEquipos($this->idequipo,$itemmontacarga);		
		/*========================================================
		=            CONSULTA DE ASIGNACION DE EQUIPO            =
		========================================================*/
		$itemasignacion = "ideasignacion";
		$rptaasignacion = ControladorEquipos::ctrConsultarAsignacionEquipos($this->idasignacion,$itemasignacion);

		/*===========================================================================
		=            CONSULTAMOS LOS USUARIOS QUE DE DEBEN ENVIAR CORREO            =
		===========================================================================*/
		$tablausuario = "usuariosransa";
		$itemusuarios = "perfil";
		$valor = array("valor1" => "COORDINADOR",
						"valor2" => "ADMINISTRADOR");
		$rptausuarios = ControladorUsuarios::ctrMostrarUsuariosRansa($tablausuario,$itemusuarios,$valor);
		

		if ($cantidadnovedad[1] != 0) {
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'STARTTLS';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
		$mail->Password = "Didacta_123"; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		$mail->From = ""; // Desde donde enviamos (Para mostrar)
		$mail->FromName = "NOVEDADES RANSA";
		$mail->addEmbeddedImage("../vistas/img/iconos/Mesa-de-trabajo-53.png","montacarga","Mesa-de-trabajo-53.png");	
		$mail->isHTML(true);	
		$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
		/*========================================================================
		=            	ENVIO DE CORREO EN CASO DE SER SOLO UNA NOVEDAD            =
		========================================================================*/
		if ($cantidadnovedad[1] == 1) {
		$body = '<!DOCTYPE html>
		<html lang="en">
		<head>
			<meta charset="UTF-8">
			<title>Document</title>
		</head>
		<body>
			<div align="center">
				<table border="0" cellspacing="0" width="100%" style="width: 100.0%; background:#F2F2F2; border-collapse: collapse; ">
					<tbody>
						<tr>
							<td valign="top" width="100%" style="padding: 15.0pt 15.0pt 15.0pt 15.0pt">
								<div align="center">
									<table width="600" border="0" cellspacing="0" cellpadding="0" style=" background: white; width: 450pt; border-collapse: collapse;">
										<tbody>
											<tr>
												<td valign="top" style="padding: 0cm 0cm 0cm 0cm;">
													<div align="center">
														<table border="0" cellspacing="0" cellpadding="0" width="600" style="width: 450.0pt; background: white; border-collapse: collapse;">
															<tbody>
																<tr>
																	<td valign="top" style="padding: 6.75pt 0cm 0cm 0cm">
																		<table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100.0%; border-collapse: collapse;">
																			<tbody>
																				<tr>
																					<td valign="top" style="padding:6.75pt 0cm 0cm 0cm">
																						<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																							<tbody>
																								<tr>
																									<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																										<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																											<tbody>
																												<tr>
																													<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt"><p>
																														<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060"></span>
																														</p>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																									<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																										<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:300px">
																											<tbody>
																												<tr>
																													<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt; max-width:300px">
																														<p align="right" style="text-align:right">
																															<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060">'.$fecha_actual_correo.'</span>
																														</p>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</td>
																								</tr>
																							</tbody>
																						</table>
																					</td>
																				</tr>
																			</tbody>
																			
																		</table>																
																	</td>
																</tr>
																<tr>
																	<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																		<div align="center">
																			<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																				<tbody>
																					<tr>
																						<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																							<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																								<tbody>
																									<tr>
																										<td style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																											<div align="center">
																												<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																													<tbody>
																														<tr>
																															<td valign="top" style="padding:0cm 0cm 0cm 0cm"></td>
																															<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																																<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%">
																																	<tbody>
																																		<tr>
																																			<td style="padding:6.75pt 13.5pt 6.75pt 13.5pt">
																																				<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; background:#009A3F; border-collapse:collapse; min-width:100%">
																																					<tbody>
																																						<tr>
																																							<td valign="top" style="padding:13.5pt 13.5pt 13.5pt 13.5pt">
																																								<p align="center" style="text-align:center; line-height:150%">
																																									<strong>
																																										<span style="font-size:25.5pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:white">REGISTRO DE NOVEDADES&nbsp;</span>
																																									</strong>
																																								
																																								</p>
																																							</td>
																																						</tr>
																																					</tbody>
																																				</table>
																																			</td>
																																		</tr>
																																	</tbody>
																																</table>
																															</td>
																														</tr>
																													</tbody>
																												</table>
																											</div>
																										</td>
																									</tr>
																								</tbody>
																							</table>
																						</td>
																					</tr>
																				</tbody>
																			</table>
																		</div>
																	</td>
																</tr>														
																<tr>
																	<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																		<div align="center">
																			<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																				<tbody>
																					<tr>
																						<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																							<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table  border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:100%; min-width:100%"><tbody><tr><td width="600" valign="top" style="width:450.0pt; padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:13.5pt 13.5pt 6.75pt 13.5pt"><span style="line-height:150%;"><strong><span style="font-size:20.0pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:rgb(243, 146, 0);">'.$rptamontacarga[0]["nom_equipo"]." ".$rptamontacarga[0]["codigo"].'</span></strong><span style="font-size:11.5pt; line-height:150%; font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;; color:#606060"> </span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>
																							
																						</td>
																					</tr>
																				</tbody>
																				
																			</table>
																			
																		</div>
																		
																	</td>
																</tr>														
															</tbody>
															
														</table>
														<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><p align="center" style="text-align:center"><span style="text-decoration:none"><img src="cid:montacarga" border="0" width="254" style="margin-top: -30px"></span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:52%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:15.5pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Descripción:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.strtoupper($descripcioncheck).'</span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Responsable:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$rptaasignacion["responsable"].'</span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:50%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Modalidad:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$modalidad.'</span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Paralización:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$text_paraliza.'</span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:50%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Horario:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">TURNO '.$rptaasignacion["turno"].'</span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>


		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><div align="center"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:0cm 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Estado Equipo:</span></b></span><p><span style="color: #009a3f;font-size: 18px; font-family: Verdana, sans-serif, serif, EmojiFont;"><b>'.$estadoEquipo.'</b> </span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:52%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:0cm 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Estado Novedad:</span></b></span><p><span style="color: #009a3f;font-size: 18px;font-family: Verdana, sans-serif, serif, EmojiFont;"><b>PENDIENTE</b></span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div> </td></tr></tbody></table>									

		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr style="height:25.55pt;">
<td valign="top" style="background-color:white;width:18.3pt;height:25.55pt;padding:0 5.4pt;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;">&nbsp;</span></p>
</td>
<td valign="top" colspan="2" style="background-color:white;width:229.3pt;height:25.55pt;padding:0;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#333333;"></span><span style="color:#333333;"></span></p>
</td>
<td style="background-color:white;width:141.95pt;height:25.55pt;padding:0;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;"><img src="cid:logo_ransa" width="145" height="40" border="0" id="x_Imagen_x0020_2" crossorigin="use-credentials" style="cursor: pointer;"></span><span style="color:#333333;"></span></p>
</td>
<td valign="top" style="background-color:white;width:20.55pt;height:25.55pt;padding:0 5.4pt;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;">&nbsp;</span></p>
</td>
<td style="width:3.2pt;height:25.55pt;padding:0;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;">&nbsp;</p>
</td>
</tr></tbody></table>	
														
													</div>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
							</td>
						</tr>			
					</tbody>
					
				</table>		
			</div>
			


		</body>
		</html>';					
		}else if ($cantidadnovedad[1] > 1) {
			$body = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div align="center">
		<table border="0" cellspacing="0" width="100%" style="width: 100.0%; background:#F2F2F2; border-collapse: collapse; ">
			<tbody>
				<tr>
					<td valign="top" width="100%" style="padding: 15.0pt 15.0pt 15.0pt 15.0pt">
						<div align="center">
							<table width="600" border="0" cellspacing="0" cellpadding="0" style=" background: white; width: 450pt; border-collapse: collapse;">
								<tbody>
									<tr>
										<td valign="top" style="padding: 0cm 0cm 0cm 0cm;">
											<div align="center">
												<table border="0" cellspacing="0" cellpadding="0" width="600" style="width: 450.0pt; background: white; border-collapse: collapse;">
													<tbody>
														<tr>
															<td valign="top" style="padding: 6.75pt 0cm 0cm 0cm">
																<table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100.0%; border-collapse: collapse;">
																	<tbody>
																		<tr>
																			<td valign="top" style="padding:6.75pt 0cm 0cm 0cm">
																				<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																								<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																									<tbody>
																										<tr>
																											<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt"><p>
																												<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060"></span>
																												</p>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																							<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																								<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:300px">
																									<tbody>
																										<tr>
																											<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt; max-width:300px">
																												<p align="right" style="text-align:right">
																													<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060">'.$fecha_actual_correo.'</span>
																												</p>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																	
																</table>																
															</td>
														</tr>
														<tr>
															<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																<div align="center">
																	<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																		<tbody>
																			<tr>
																				<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																						<tbody>
																							<tr>
																								<td style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																									<div align="center">
																										<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																											<tbody>
																												<tr>
																													<td valign="top" style="padding:0cm 0cm 0cm 0cm"></td>
																													<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																														<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%">
																															<tbody>
																																<tr>
																																	<td style="padding:6.75pt 13.5pt 6.75pt 13.5pt">
																																		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; background:#009A3F; border-collapse:collapse; min-width:100%">
																																			<tbody>
																																				<tr>
																																					<td valign="top" style="padding:13.5pt 13.5pt 13.5pt 13.5pt">
																																						<p align="center" style="text-align:center; line-height:150%">
																																							<strong>
																																								<span style="font-size:25.5pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:white">REGISTRO DE NOVEDADES&nbsp;</span>
																																							</strong>
																																						
																																						</p>
																																					</td>
																																				</tr>
																																			</tbody>
																																		</table>
																																	</td>
																																</tr>
																															</tbody>
																														</table>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</div>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</td>
														</tr>														
														<tr>
															<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																<div align="center">
																	<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																		<tbody>
																			<tr>
																				<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table  border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:100%; min-width:100%"><tbody><tr><td width="600" valign="top" style="width:450.0pt; padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:13.5pt 13.5pt 6.75pt 13.5pt"><span style="line-height:150%;"><strong><span style="font-size:20.0pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:rgb(243, 146, 0);">'.$rptamontacarga[0]["nom_equipo"]." ".$rptamontacarga[0]["codigo"].'</span></strong><span style="font-size:11.5pt; line-height:150%; font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;; color:#606060"> </span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>
																					
																				</td>
																			</tr>
																		</tbody>
																		
																	</table>
																	
																</div>
																
															</td>
														</tr>														
													</tbody>
													
												</table>
												<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><p align="center" style="text-align:center"><span style="text-decoration:none"><img src="cid:montacarga" border="0" width="254" style="margin-top: -70px"></span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:52%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Responsable:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$rptaasignacion["responsable"].'</span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:50%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Modalidad:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$modalidad.'</span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Paralización:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$text_paraliza.'</span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:50%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:10pt 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Horario:</span></b></span><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">'.$rptaasignacion["turno"].'</span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>

<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse; margin-top: -50pt;"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><div align="center"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 40.75pt"><h3 style="color: #009a3f;"><b>Listado Novedades</b></h3><div><ul style="color: #58595B;">';

			foreach ($datosnovedades as $key => $value) {
				foreach ($value as $keys => $valuess) {
					if ($valuess != null) {
						$textonovedades = wordwrap($valuess,60,"\n",true);
						$body .= '<li style ="text-decoration: underline; text-decoration-color: #009a3f;" >'.$textonovedades.'</li>';
						
					}
				}

			}

$body .= '</ul></div> </td></tr></tbody></table></div> </td></tr></tbody></table>	

<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><div align="center"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" style="width:45%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:0cm 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Estado Equipo:</span></b></span><p><span style="color: #009a3f;font-size: 18px; font-family: Verdana, sans-serif, serif, EmojiFont;"><b>'.$estadoEquipo.'</b> </span></p></td></tr></tbody></table><table border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:52%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:0cm 0cm 0cm 0cm"><span><b><span style="font-family: Verdana, sans-serif, serif, EmojiFont; color: #767171; font-size: 13px">Estado Novedad:</span></b></span><p><span style="color: #009a3f;font-size: 18px;font-family: Verdana, sans-serif, serif, EmojiFont;"><b>PENDIENTE</b></span></p></td></tr><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div> </td></tr></tbody></table>

<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr style="height:25.55pt;">
<td valign="top" style="background-color:white;width:18.3pt;height:25.55pt;padding:0 5.4pt;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;">&nbsp;</span></p>
</td>
<td valign="top" colspan="2" style="background-color:white;width:229.3pt;height:25.55pt;padding:0;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="color:#333333;"></span><span style="color:#333333;"></span></p>
</td>
<td style="background-color:white;width:141.95pt;height:25.55pt;padding:0;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;"><img src="cid:logo_ransa" width="145" height="40" border="0" id="x_Imagen_x0020_2" crossorigin="use-credentials" style="cursor: pointer;"></span><span style="color:#333333;"></span></p>
</td>
<td valign="top" style="background-color:white;width:20.55pt;height:25.55pt;padding:0 5.4pt;">
<p align="right" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:right;margin:0;line-height:150%;">
<span style="color:#333333;">&nbsp;</span></p>
</td>
<td style="width:3.2pt;height:25.55pt;padding:0;">
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;">&nbsp;</p>
</td>
</tr></tbody></table>							
												
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>			
			</tbody>
			
		</table>		
	</div>
	


</body>
</html>';
			
			
		}

	    //Recipients
	    $mail->setFrom('proyectosecuador@ransa.net', 'NOVEDADES RANSA');

		$mail->addAddress($_SESSION["email"]);     // Add a recipient	
	    for ($i=0; $i < count($rptausuarios) ; $i++) {
	    	if ($rptausuarios[$i]["idciudad"] == $_SESSION["ciudad"]) { //validamos la ciudad
	    		$modulos = json_decode($rptausuarios[$i]["idmodulos"], true);
	    		for ($j=0; $j < count($modulos) ; $j++) { 
	    			if ($modulos[$j]["idmodulos_portal"] == "1") {
	    				$mail->addAddress($rptausuarios[$i]["email"], $rptausuarios[$i]["primerapellido"]);
	    			}
	    			
	    		}

	    		
	    	}
	    	
	    }

	    // Content
	    $mail->Subject = 'NOVEDAD '.$rptamontacarga[0]["codigo"];
	    $mail->Body    = $body;
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $envios = $mail->send();
		if (isset($envios)) {
			echo $respuesta;	
		}else{
			echo 2;
		}	    
			
		}else{
			echo $respuesta;
		}

	}

	public function ajaxRegistroFechaPropuesta(){

		$fecha = new DateTime($this->fecha_propuesta);
		$dato1 = $fecha->format('Y-m-d');

		$items = array("fecha_propuesta" => "fecha_propuesta",
						"idnovequipos" => "idnovequipos",
						"estado" => "estado");

		$valor = array("fecha_propuesta" => $dato1,
						"idnovequipos" => $this->idnovequipos,
						"estado" => 2);


		$rpta = ControladorNovedades::ctrRegistroFechaPropuesta($valor,$items);
		echo $rpta;

	}

	public function ajaxNovedadConcluida(){
				/*****ubicacion de Zona Horaria*****/
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");

		$fecha = getdate();
		$dato1 = $fecha["year"]."-".$fecha["mon"]."-".$fecha["mday"]." ".$fecha["hours"].":".$fecha["minutes"].":".$fecha["seconds"];
		/*======================================================================================
		=            PRIMERO CONSULTAMOS SI LA NOVEDAD TIENE PARALIZACIÓN DE EQUIPO            =
		======================================================================================*/
		$rptanovedad = ControladorNovedades::ctrConsultarNovedadesEquipos($this->idnovequipos,"idnovequipos");

		if ($rptanovedad["paralizacion"] == 1) {
			/*======================================================
			=            CAMBIAMOS EL ESTADO DEL EQUIPO            =
			======================================================*/
			$datosactualizarequipo = array("idequipo" => $this->idequipo,
						"estado" => 1);
			$itemequipo = "idequipomc";
			$estado_de_equipo = ControladorEquipos::ctrActualizarEquiposEstado($datosactualizarequipo,$itemequipo);			
		}

		$items = array("fecha_concluida" => "fecha_concluida",
						"idnovequipos" => "idnovequipos",
						"estado" => "estado",
						"otnum" => "otnum",
						"observacionesot" => "observacionesot",
						"rutaot" => "rutaot");
		$datos = array("fecha_concluida" => $dato1,
						"idnovequipos" => $this->idnovequipos,
						"estado" => 1,
						"otnum" => $this->ot,
						"observacionesot" => preg_replace('[\n|\r|\n\r]','',nl2br(strtoupper($this->observacionesot))),
						"rutaot" => $this->rutaotRealizada);
		/*=======================================================================================
		=            SE USA ESTA FUNCION PARA ACTUALIZAR EL ESTADO - FECHA CONCLUIDO            =
		=======================================================================================*/
		$rpta = ControladorNovedades::ctrRegistroFechaPropuesta($datos,$items);
		$resultado = false;
		// if ($rpta == "ok") {
		// 	$resultado = true;

		// 	if ($estado_de_equipo == "ok") {

		// 		$resultado = true;
		// 	}else{
		// 		$resultado = false;
		// 	}
		// }
		if ($rpta) {
			$resultado = true;

			/*=============================================
			=            CONSULTAMOS EL EQUIPO            =
			=============================================*/
			$rptaequipo = ControladorEquipos::ctrConsultarEquipos($this->idequipo,"idequipomc");
			/*=============================================================================
			=            OBTENER ID DEL SUPERVISOR DEL USUARIO RESPONSABLE            =
			=============================================================================*/
			$rptaidsupervisor = ControladorEquipos::ctrConsultarAsignacionEquipos($rptanovedad["ideasignacion"],"ideasignacion");
			/*==========================================================
			=            OBTENEMOS EL CORREO DEL SUPERVISOR            =
			==========================================================*/
			$rptasupervisor = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaidsupervisor["idusuariosransa"]);

			/*==================================================================
			=            SE NOTIFICA POR CORREO LA NOVEDAD RESUELTA            =
			==================================================================*/
			$mail = new PHPMailer();
			$mail->IsSMTP();
			$mail->CharSet = 'UTF-8';
			$mail->SMTPSecure = 'STARTTLS';
			$mail->SMTPAuth = true;
			$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
			$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
			$mail->Password = "Didacta_123"; // Contraseña
			$mail->Port = 587; // Puerto a utilizar
			$mail->From = "proyectosecuador@ransa.net"; // Desde donde enviamos (Para mostrar)
			$mail->FromName = "NOVEDADES RANSA";
			//$mail->addEmbeddedImage("../vistas/img/iconos/Mesa-de-trabajo-53.png","montacarga","Mesa-de-trabajo-53.png");	
			$mail->isHTML(true);	
			//$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");
			$fecha_actual_correo = utf8_encode(strftime("%A, %d de %B de %Y"));
			$body = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div align="center">
		<table border="0" cellspacing="0" width="100%" style="width: 100.0%; background:#F2F2F2; border-collapse: collapse;">
			<tbody>
				<tr>
					<td valign="top" width="100%" style="padding: 15.0pt 15.0pt 15.0pt 15.0pt">
						<div align="center">
							<table width="600" border="0" cellspacing="0" cellpadding="0" style=" background: white; width: 450pt; border-collapse: collapse;">
								<tbody>
									<tr>
										<td valign="top" style="padding: 0cm 0cm 0cm 0cm;">
											<div align="center">
												<table border="0" cellspacing="0" cellpadding="0" width="600" style="width: 450.0pt; background: white; border-collapse: collapse;">
													<tbody>
														<tr>
															<td valign="top" style="padding: 6.75pt 0cm 0cm 0cm">
																<table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100.0%; border-collapse: collapse;">
																	<tbody>
																		<tr>
																			<td valign="top" style="padding:6.75pt 0cm 0cm 0cm">
																				<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																								<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																									<tbody>
																										<tr>
																											<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt"><p>
																												<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060">'.$fecha_actual_correo.' </span>
																												</p>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																							<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																								<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:300px">
																									<tbody>
																										<tr>
																											<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt; max-width:300px">
																												<p align="right" style="text-align:right">
																													<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060"></span>
																												</p>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																	
																</table>																
															</td>
														</tr>
														<tr>
															<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																<div align="center">
																	<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																		<tbody>
																			<tr>
																				<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																						<tbody>
																							<tr>
																								<td style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																									<div align="center">
																										<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																											<tbody>
																												<tr>
																													<td valign="top" style="padding:0cm 0cm 0cm 0cm"></td>
																													<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																														<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%">
																															<tbody>
																																<tr>
																																	<td style="padding:6.75pt 13.5pt 6.75pt 13.5pt">
																																		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; background:#009A3F; border-collapse:collapse; min-width:100%">
																																			<tbody>
																																				<tr>
																																					<td valign="top" style="padding:13.5pt 13.5pt 13.5pt 13.5pt">
																																						<p align="center" style="text-align:center; line-height:150%">
																																							<strong>
																														<span style="font-size:25.5pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:white">NOVEDAD RESUELTA&nbsp;</span>
																													</strong>
																												
																												</p>
																											</td>
																										</tr>
																									</tbody>
																																		</table>
																																	</td>
																																</tr>
																															</tbody>
																														</table>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</div>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</td>
														</tr>														
														<tr>
															<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																<div align="center">
																	<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																		<tbody>
																			<tr>
																				<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:100%; min-width:100%"><tbody><tr><td width="600" valign="top" style="width:450.0pt; padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:13.5pt 13.5pt 6.75pt 13.5pt"><span style="line-height:150%;"><strong><span style="font-size:20.0pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:rgb(243, 146, 0);">'.$rptaequipo[0]["nom_equipo"].' '.$rptaequipo[0]["codigo"].'</span></strong><span style="font-size:11.5pt; line-height:150%; font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;; color:#606060"> </span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>
																					
																				</td>
																			</tr>
																		</tbody>
																		
																	</table>
																	
																</div>
																
															</td>
														</tr>														
													</tbody>
													
												</table>
												<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table border="0" cellspacing="0" cellpadding="0" align="right" width="100" style="width:100%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:15.5pt 0cm 0cm 0cm"><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">Se informa que la novedad reportada ya se encuentra resuelta, detallo #OT y las observaciones reportadas por el técnico.</span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>		

<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table border="0" cellspacing="0" cellpadding="0" align="right" width="100" style="width:100%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0pt 0cm 0cm 0cm"><table class="x_MsoNormalTable" border="0" cellspacing="0" cellpadding="0" style="width:100%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><p class="x_MsoNormal" style="line-height:125%"><span style="font-size:7.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"><strong><span style="font-size:10.0pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:orange; text-decoration:none">NOVEDAD REPORTADA&nbsp;</span></strong><br><br></span><span style="font-size:8.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666">'.$rptanovedad["descripcion_novedad"].'</span><span style="font-size:7.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"><br><br></span><span style="font-size:8.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"></span><span style="font-size:7.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"></span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>

<table class="x_MsoNormalTable" border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table class="x_MsoNormalTable" border="0" cellspacing="0" cellpadding="0" align="left" width="176" style="width:132.0pt; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><p class="x_MsoNormal" align="center" style="text-align:center"> <span style="font-size:7.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"><strong><span style="font-size:10.0pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:orange; text-decoration:none"># ORDEN TRABAJO&nbsp;</span></strong><br><br></span> <p align="center" style="margin:0cm; margin-bottom:.0001pt"><b><span style=" font-size:30.0pt; font-family:&quot;Verdana&quot;,sans-serif; color:#009A3F">'.$this->ot.'</span></b></p>  </p></td></tr></tbody></table><table class="x_MsoNormalTable" border="0" cellspacing="0" cellpadding="0" align="right" width="352" style="width:264.0pt; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><p class="x_MsoNormal" style="line-height:125%"><span style="font-size:7.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"><strong><span style="font-size:10.0pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:orange; text-decoration:none">Observaciones Reportadas por Técnico&nbsp;</span></strong><br><br></span><span style="font-size:8.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666">'.$this->observacionesot.'</span><span style="font-size:7.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"><br><br></span><span style="font-size:8.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"></span><span style="font-size:7.5pt; line-height:125%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#666666"></span></p></td></tr></tbody></table></td></tr></tbody></table>

											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>			
			</tbody>
			
		</table>		
	</div>
	



</body>
</html>';

		    $mail->setFrom('proyectosecuador@ransa.net', 'NOVEDADES RANSA');
		    /*=========================================================================================
		    =            CORREO ELECTRONICO DE QUIEN CONFIRMA RESUELTA LA NOVEDAD            =
		    =========================================================================================*/
		    $mail->addAddress($_SESSION["email"]);
		    /*=========================================================
		    =            CORREO ELECTRONICO DEL SUPERVISOR            =
		    =========================================================*/
		    $mail->addAddress($rptasupervisor["email"]);
		    // Content
		    $mail->Subject = 'NOVEDAD '.$rptaequipo[0]["codigo"].' RESUELTA';
		    $mail->Body    = $body;
		    $envios = $mail->send();
		    if ($envios) {
				echo $resultado;
		    }
		}
		
	}

	public function ajaxEliminarNovedad(){
		$dato1 = 0;
		$dato2 = $this->idnovequipos;
		$item1 = "estado";
		$item2 = "idnovequipos";

		/*==============================================================================
		=            VERIFICAMOS SI EL EQUIPO TIENE NOVEDAD DE PARALIZACION            =
		==============================================================================*/

		$rptanovedad = ControladorNovedades::ctrConsultarNovedadesEquipos($dato2,$item2);

		if ($rptanovedad["paralizacion"] == 1) {
			$datosactualizarequipo = array("idequipo" => $rptanovedad["idequipo"],
						"estado" => 1);
			$itemequipo = "idequipomc";
			$rptaequipo = ControladorEquipos::ctrActualizarEquiposEstado($datosactualizarequipo,$itemequipo);

			if ($rptaequipo == "ok") {

				$rpta = ControladorNovedades::ctrEliminarNovedad($dato1,$dato2,$item1,$item2);

				echo $rpta;
				
			}
			
		}else{
			$rpta = ControladorNovedades::ctrEliminarNovedad($dato1,$dato2,$item1,$item2);

			echo $rpta;


		}

		
	}
	/*====================================================================================
	=            VERIFICAR SI SE HA REALIZARDO EL CHECK LIST DENTRO DEL TURNO            =
	====================================================================================*/
	public function ajaxVerificarCheckList(){
		$valor1 = $this->idequipo;
		$valor2 = $this->idasignacion;
		$item1 = "idequipomc";
		$item2 = "ideasignacion";

		$rptanovedades = ControladorCheckList::ctrConsultarCheckList($valor1,$valor2,$item1,$item2);
		if ($rptanovedades) {
			for ($i=0; $i < count($rptanovedades) ; $i++) { 
				/*========================================================
				=            CONVETIR DATETIME A FORMATO DATE            =
				========================================================*/
				$fecha_nueva = date('Y-m-d', strtotime($rptanovedades[$i]["fecha"]));				
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");
				$fechaactual = date("Y-m-d");
				if ($fecha_nueva == $fechaactual) {
					$resultado = $rptanovedades[$i]["estado"];
					break;

				}
			}
			if (isset($resultado)) {
				echo $resultado;
			}else{
				echo 4;
			}
		}

	}
	/*=================================================================
	=            CONSULTA PARA GRÁFICO DE EQUIPOS X CIUDAD            =
	=================================================================*/
	public function ajaxConsultEqxciudadgra(){
		/*=====  CONSULTA DE EQUIPOS  ======*/
		
		$rpta = ControladorEquipos::ctrConsultarEquipos($_SESSION["ciudad"],"idciudad");;
		echo json_encode($rpta,true);

	}

	/*====================================================
	=            REGISTRO DE MANEJO DE EQUIPO            =
	====================================================*/
	public function ajaxManejoEquipo(){
		
		
		$this->opciones;
		
		
		$idusuario = $_SESSION["id"];
		$itemscheck = json_decode($this->opciones,true);
		/*=================================================
		=            OBTENEMOS ID DEL PERSONAL            =
		=================================================*/
		$itempersonal = "nombres_apellidos";
		$valorpersonal = $this->personal;
		$rptapersonal = ControladorPersonal::ctrConsultarPersonal($itempersonal, $valorpersonal);
		/*=============================================================================
		=            ITEMS DE MANEJO DE EQUIPOS GUARDARLOS EN UNA VARIABLE            =
		=============================================================================*/
		foreach ($itemscheck as $key => $value) {
			foreach ($value as $key => $valuereal) {
				switch ($key) {
					case 0:
						if (is_string($valuereal)) {
							$opcmane1 = strtoupper($valuereal);
						}else{
							$opcmane1 = $valuereal;
						}
						break;
					case 1:
						if (is_string($valuereal)) {
							$opcmane2 = strtoupper($valuereal);
						}else{
							$opcmane2 = $valuereal;
						}
						break;
					case 2:
						if (is_string($valuereal)) {
							$opcmane3 = strtoupper($valuereal);
						}else{
							$opcmane3 = $valuereal;
						}
						break;
					case 3:
						if (is_string($valuereal)) {
							$opcmane4 = strtoupper($valuereal);
						}else{
							$opcmane4 = $valuereal;
						}
						break;
					case 4:
						if (is_string($valuereal)) {
							$opcmane5 = strtoupper($valuereal);
						}else{
							$opcmane5 = $valuereal;
						}
						break;
					case 5:
						if (is_string($valuereal)) {
							$opcmane6 = strtoupper($valuereal);
						}else{
							$opcmane6 = $valuereal;
						}
						break;
					case 6:
						if (is_string($valuereal)) {
							$opcmane7 = strtoupper($valuereal);
						}else{
							$opcmane7 = $valuereal;
						}
						break;
				}				
			}
		}
		$rayabateria = $this->porcbinicio;
		$porcentaje = ((float)$rayabateria*100)/8;
		$porcentaje = round($porcentaje,0);
		/*==================================================================
		=            ENVIA LOS DATOS A LA BASE PARA EL REGISTRO            =
		==================================================================*/
		$datosmanejo = array("idpersonal" => $rptapersonal["idpersonal"],
							"idequipo" => $this->idequipo,
							"idusuario" => $_SESSION["id"],
							"opc1" => $opcmane1,
							"opc2" => $opcmane2,
							"opc3" => $opcmane3,
							"opc4" => $opcmane4,
							"opc5" => $opcmane5,
							"opc6" => $opcmane6,
							"opc7" => $opcmane7,
							"identbateriainicio" => strtoupper($this->identbinicio),
							"rayacargaini" => $this->porcbinicio,
							"codigo_bateria" => $this->codigo_baterias,
							"porcentcargainicio" => $porcentaje,
							"horometroinicial" => $this->horoinicio,
							"observaciones" => strtoupper($this->observacion));
		/*=====================================================
		=            GUARDAMOS EN LA BASE DE DATOS            =
		=====================================================*/
		$rpta = ControladorManejoeq::ctrInsertarManejoeq($datosmanejo);

		if ($rpta == "ok") {
			echo $rpta;
		}else{
			echo 2;
		}
		
	}
	/*=============================================================
	=            INGRESAR EL TERMINO DE USO DEL EQUIPO            =
	=============================================================*/
	public function ajaxtManejoTermino(){

		$rayabateria = $this->porcbinicio;
		$porcentaje = ((float)$rayabateria*100)/8;
		$porcentaje = round($porcentaje,0);
		/*========================================================
		=            INGRESAMOS EL TERMINO DEL USO DEL EQUIPO            =
		========================================================*/
		$item = "idmanejoeq";
		$datos = array("idmanejoeq" => $this->idmanejoeq,
						"horometrotermino" => $this->horoinicio,
						"rayacargafinal" => $this->porcbinicio,
						"porcencargatermino" => $porcentaje,
						"identbateriatermino" => $this->identbinicio,
						"observacionesfinales" => $this->observacion,
						"ubicacionfinal" => $this->ubicacion);
		$rpta = ControladorManejoeq::ctrActualizarManejoeq($item,$datos);
		if ($rpta == "ok") {
			echo $rpta;
		}else{
			echo 2;
		}

	}
	/*=======================================================
	=            NOTIFICAR NO ENTREGA DE EQUIPOS            =
	=======================================================*/
	public function NotificarNoEntrega(){

		/*==============================================================================================================================
		=            ENVIAR CORREO NOTIFICACIÓN AL ADMINISTRADOR QUE NO SE HA HECHO LA ENTREGA DEL EQUIPO Y QUE VA ESTAR EN USO            =
		==============================================================================================================================*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'STARTTLS';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
		$mail->Password = "Didacta_123"; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		$mail->From = "proyectosecuador@ransa.net"; // Desde donde enviamos (Para mostrar)
		$mail->FromName = "NOVEDADES RANSA";
		$mail->addEmbeddedImage("../vistas/img/iconos/Mesa-de-trabajo-53.png","montacarga","Mesa-de-trabajo-53.png");	
		$mail->isHTML(true);	
		$mail->addEmbeddedImage("../vistas/img/plantilla/logotipo.png","logo_ransa","logotipo.png");
		/*===========================================================
		=            CONFIGURACIÓN DE CORREO ELECTRONICO            =
		===========================================================*/		
				/*****ubicacion de Zona Horaria*****/
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");
		$fecha_actual_correo = utf8_encode(strftime("%A, %d de %B de %Y"));
		/*=====================================================
		=            CONSULTAMOS LOS DATOS DEL USO            =
		=====================================================*/
		
		$rptamanejo = ControladorManejoeq::ctrConsultarManejoeq("idmanejoeq",$this->idmanejoeq);
		/*========================================================
		=            CONSULTAMOS LOS DATOS DEL EQUIPO            =
		========================================================*/
		$rptaequipomanejo = ControladorEquipos::ctrConsultarEquipos($rptamanejo["idequipo"],"idequipomc");
		/*==================================================
		=            CONSULTAR DATOS DE USUARIO            =
		==================================================*/
		$tablausuario = "usuariosransa";
		$itemusuarios = "perfil";
		$valor = array("valor1" => "COORDINADOR",
						"valor2" => "ADMINISTRADOR");
		$rptausuarios = ControladorUsuarios::ctrMostrarUsuariosRansa($tablausuario,$itemusuarios,$valor);
		/*====================================================================================
		=            CONSULTAMOS PERSONAL NUEVO QUE SE VA HACER EL USO DEL EQUIPO            =
		====================================================================================*/
		$itempersonal = "nombres_apellidos";
		$valorpersonal = $this->personalnuevo;
		$rptapersonal = ControladorPersonal::ctrConsultarPersonal($itempersonal, $valorpersonal);		
		
		
		

		/*========================================================================
		=            	ENVIO DE CORREO EN CASO DE SER SOLO UNA NOVEDAD            =
		========================================================================*/
		$body = '<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
</head>
<body>
	<div align="center">
		<table border="0" cellspacing="0" width="100%" style="width: 100.0%; background:#F2F2F2; border-collapse: collapse;">
			<tbody>
				<tr>
					<td valign="top" width="100%" style="padding: 15.0pt 15.0pt 15.0pt 15.0pt">
						<div align="center">
							<table width="600" border="0" cellspacing="0" cellpadding="0" style=" background: white; width: 450pt; border-collapse: collapse;">
								<tbody>
									<tr>
										<td valign="top" style="padding: 0cm 0cm 0cm 0cm;">
											<div align="center">
												<table border="0" cellspacing="0" cellpadding="0" width="600" style="width: 450.0pt; background: white; border-collapse: collapse;">
													<tbody>
														<tr>
															<td valign="top" style="padding: 6.75pt 0cm 0cm 0cm">
																<table border="0" cellpadding="0" cellspacing="0" width="100%" style="width: 100.0%; border-collapse: collapse;">
																	<tbody>
																		<tr>
																			<td valign="top" style="padding:6.75pt 0cm 0cm 0cm">
																				<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																					<tbody>
																						<tr>
																							<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																								<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse">
																									<tbody>
																										<tr>
																											<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt"><p>
																												<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060">'.$fecha_actual_correo.'</span>
																												</p>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																							<td width="300" valign="top" style="width:225.0pt; padding:0cm 0cm 0cm 0cm">
																								<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:300px">
																									<tbody>
																										<tr>
																											<td valign="top" style="padding:0cm 13.5pt 6.75pt 13.5pt; max-width:300px">
																												<p align="right" style="text-align:right">
																													<span style="font-size:7.5pt; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:#606060"></span>
																												</p>
																											</td>
																										</tr>
																									</tbody>
																								</table>
																							</td>
																						</tr>
																					</tbody>
																				</table>
																			</td>
																		</tr>
																	</tbody>
																	
																</table>																
															</td>
														</tr>
														<tr>
															<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																<div align="center">
																	<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																		<tbody>
																			<tr>
																				<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																						<tbody>
																							<tr>
																								<td style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																									<div align="center">
																										<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse">
																											<tbody>
																												<tr>
																													<td valign="top" style="padding:0cm 0cm 0cm 0cm"></td>
																													<td valign="top" style="padding:0cm 0cm 0cm 0cm; min-width:100%">
																														<table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%">
																															<tbody>
																																<tr>
																																	<td style="padding:6.75pt 13.5pt 6.75pt 13.5pt">
																																		<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; background:#009A3F; border-collapse:collapse; min-width:100%">
																																			<tbody>
																																				<tr>
																																					<td valign="top" style="padding:13.5pt 13.5pt 13.5pt 13.5pt">
																																						<p align="center" style="text-align:center; line-height:150%">
																																							<strong>
																														<span style="font-size:25.5pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:white">NO ENTREGA DE EQUIPO&nbsp;</span>
																													</strong>
																												
																												</p>
																											</td>
																										</tr>
																									</tbody>
																																		</table>
																																	</td>
																																</tr>
																															</tbody>
																														</table>
																													</td>
																												</tr>
																											</tbody>
																										</table>
																									</div>
																								</td>
																							</tr>
																						</tbody>
																					</table>
																				</td>
																			</tr>
																		</tbody>
																	</table>
																</div>
															</td>
														</tr>														
														<tr>
															<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																<div align="center">
																	<table border="0" cellspacing="0" cellpadding="0" width="600" style="width:450.0pt; background:white; border-collapse:collapse; min-width:100%">
																		<tbody>
																			<tr>
																				<td valign="top" style="padding:0cm 0cm 0cm 0cm">
																					<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse; min-width:100%"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse; max-width:100%; min-width:100%"><tbody><tr><td width="600" valign="top" style="width:450.0pt; padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" align="left" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td align="center" valign="top" style="padding:13.5pt 13.5pt 6.75pt 13.5pt"><span style="line-height:150%;"><strong><span style="font-size:20.0pt; line-height:150%; font-family:&quot;Verdana&quot;,&quot;sans-serif&quot;; color:rgb(243, 146, 0);">'.$rptaequipomanejo[0]["nom_equipo"]." ".$rptaequipomanejo[0]["codigo"].'</span></strong><span style="font-size:11.5pt; line-height:150%; font-family:&quot;Helvetica&quot;,&quot;sans-serif&quot;; color:#606060"> </span></span></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>
																					
																				</td>
																			</tr>
																		</tbody>
																		
																	</table>
																	
																</div>
																
															</td>
														</tr>														
													</tbody>
													
												</table>
												<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 0cm 6.75pt"><table border="0" cellspacing="0" cellpadding="0" align="right" width="100" style="width:100%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:15.5pt 0cm 0cm 0cm"><p><span style="font-size: 9pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(118, 113, 113);">Se informa la <strong>NO ENTREGA</strong>  del siguiente equipo,se detalla personal de su Inicio.</span></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table>


<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><div align="center"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td align="center" style="padding:0cm 0cm 0cm 0cm"><p class="x_MsoNormal"><b><span style="font-size: 18pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(0, 154, 63);">'.$this->personal.'</span></b><b><span style="font-size: 16pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(0, 154, 63);"></span></b></p><p style="margin:0cm; margin-bottom:.0001pt"><b><span style="font-size:20.0pt; font-family:&quot;Verdana&quot;,sans-serif; color:#009A3F">Id : '.$this->idmanejoeq.'</span></b></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div> </td></tr></tbody></table><div align="center">
<table border="0" cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;">
<tbody><tr>
<td valign="top" style="padding:0 6.75pt 6.75pt 6.75pt;">
<table border="0" cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;">
<tbody><tr>
<td valign="top" style="padding:0 6.75pt;">
<table align="right" border="0" cellspacing="0" cellpadding="0" style="width:100%;border-collapse:collapse;">
<tbody><tr>
<td valign="top" style="padding:15.5pt 0 0 0;">
<p style="font-size:12pt;font-family:Times New Roman,serif;margin-right:0;margin-left:0;">
<span style="color:#767171;font-size:9pt;font-family:Verdana,sans-serif;"><strong><span style="font-family:Verdana,sans-serif;">Actualmente está en uso por: </span></strong></span></p>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</td>
</tr>
</tbody></table>
</div>
<table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 6.75pt 6.75pt 6.75pt"><div align="center"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td valign="top" style="padding:0cm 0cm 0cm 0cm"><table border="0" cellspacing="0" cellpadding="0" width="100%" style="width:100.0%; border-collapse:collapse"><tbody><tr><td align="center" style="padding:0cm 0cm 0cm 0cm"><p class="x_MsoNormal"><b><span style="font-size: 18pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(0, 154, 63);">'.$rptapersonal["nombres_apellidos"].'</span></b><b><span style="font-size: 16pt; font-family: Verdana, sans-serif, serif, EmojiFont; color: rgb(0, 154, 63);"></span></b></p><p style="margin:0cm; margin-bottom:.0001pt"><b><span style="font-size:20.0pt; font-family:&quot;Verdana&quot;,sans-serif; color:#009A3F"></span></b></p></td></tr></tbody></table></td></tr></tbody></table></td></tr></tbody></table></div> </td></tr></tbody></table>								
												
											</div>
										</td>
									</tr>
								</tbody>
							</table>
						</div>
					</td>
				</tr>			
			</tbody>
			
		</table>		
	</div>
	



</body>
</html>';		
		$mail->setFrom('proyectosecuador@ransa.net', 'NOVEDADES RANSA');
		/*=============================================================================
		=            SE ENVIA CORREO AL USUARIO QUIEN HACE LA NOTIFICACIÓN            =
		=============================================================================*/
		
	    $mail->addAddress($_SESSION["email"], "NOVEDADES RANSA");    // Add a recipient
	    /*========================================================================
	    =            ENVIAMOS EL CORREO SOLO AL USUARIO ADMINISTRADOR            =
	    ========================================================================*/
	    for ($i=0; $i < count($rptausuarios) ; $i++) { 
	    	if ($rptausuarios[$i]["idciudad"] == $_SESSION["ciudad"] && $rptausuarios[$i]["perfil"] == "ADMINISTRADOR") {
	    		$mail->addAddress($rptausuarios[$i]["email"], $rptausuarios[$i]["primerapellido"]);     // Add a recipient	
	    	}
	    	
	    }

	    // Content
	    $mail->Subject = 'NO ENTREGA DE EQUIPO '.$rptaequipomanejo[0]["codigo"];
	    $mail->Body    = $body;
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $envios = $mail->send();
	    if ($envios) {
			$item = "idmanejoeq";
			$valor = array("idmanejoeq" => $this->idmanejoeq,
							"idsolicitante" => $_SESSION["id"],
							"idpersonalusaeqxnoti" => $rptapersonal["idpersonal"],
							"horometrodelotroInicio" => $this->horoinicio) ;
	    	$rpta = ControladorManejoeq::ctrNotificarNoEntrega($item,$valor);

			echo $rpta;
	    		
	    }
	}
	/*======================================================================
	=            VISUALIACION DE DATOS DE NO ENTREGA DE EQUIPOS            =
	======================================================================*/
	public function ajaxNoEntregaNotificacion(){
		
		$item = "idmanejoeq";

		$rpta = ControladorManejoeq::ctrConsultarManejoeq($item,$this->idmanejoeq);
		if ($rpta) {
			/*==========================================================================
			=            OBTENER DATOS DEL USUARIO QUIEN PERMITE EL INGRESO            =
			==========================================================================*/
			$itemuser = "id";
			$valoruser = $rpta["usuarionotificador"];
			$tablauser = "usuariosransa";
			$rptausuarios = ControladorUsuarios::ctrMostrarUsuariosRansa($tablauser,$itemuser,$valoruser);
			$nombres = $rptausuarios["primernombre"]." ".$rptausuarios["primerapellido"];
			/*======================================================================
			=            OBTENER DATOS DEL PERSONAL QUIEN USO EL EQUIPO            =
			======================================================================*/
			$itempersonal = "idpersonal";
			$valorpersonal = $rpta["idpersonalusaeqxnoti"];
			$rptapersonal = ControladorPersonal::ctrConsultarPersonal($itempersonal, $valorpersonal);
			
			/*============================================
			=            SEPARAR FECHA - HORA            =
			============================================*/
			date_default_timezone_set('America/Guayaquil');
			setlocale(LC_ALL, "spanish");
			$tfecha = date('Y-m-d',strtotime($rpta["fechanoentrega"]));
			$hora = date('H:i:s',strtotime($rpta["fechanoentrega"]));

			$datajson = '{
							"fecha":"'.$tfecha.'",
							"hora":"'.$hora.'",
							"personal":"'.$rptapersonal["nombres_apellidos"].'",
							"usuarionotificador":"'.$nombres.'"
			}';
			
			echo $datajson;
		}else{
			echo 2;
		}
	}
	/*=======================================================================
	=            NOTIFICAR LISTADO TOTAL DE NOVEDADES PENDIENTES            =
	=======================================================================*/
	public function ajaxNotificarNovedadesProveedor(){
		$listnovedades = json_decode($this->datanovedad);
		
		/*===============================================================================================
		=            ENVIO DE CORREO CON LAS NOVEDADES QUE SE ENCUENTREN EN ESTAOD PENDIENTE            =
		===============================================================================================*/
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->CharSet = 'UTF-8';
		$mail->SMTPSecure = 'STARTTLS';
		$mail->SMTPAuth = true;
		$mail->Host = "smtp.office365.com";// SMTP a utilizar. Por ej. smtp.elserver.com
		$mail->Username = "proyectosecuador@ransa.net"; // Correo completo a utilizar
		$mail->Password = "Didacta_123"; // Contraseña
		$mail->Port = 587; // Puerto a utilizar
		$mail->From = "proyectosecuador@ransa.net"; // Desde donde enviamos (Para mostrar)
		$mail->FromName = "NOVEDADES RANSA";
		$mail->isHTML(true);
		$body = '<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title></title>
</head>
<body>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="font-family:Verdana,sans-serif;">Estimados,</span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="font-family:Verdana,sans-serif;">&nbsp;</span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="font-family:Verdana,sans-serif;">Detallo status de novedades actualizada, por favor su ayuda con la fecha tentativa de reparación de las mismas.</span></p>';
if ($_SESSION["ciudad"] == 1) {
	$body .= ' <p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="font-family:Verdana,sans-serif;">&nbsp;</span></p>
<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="font-family:Verdana,sans-serif;">Adicional se detalla el reporte de Repuestos Solicitados en el archivo adjunto.</span></p>';	
}
$body .= '<p style="font-size:11pt;font-family:Calibri,sans-serif;margin:0;"><span style="font-family:Verdana,sans-serif;">&nbsp;</span></p>
<div class="_2Ypz6DjF0cnPXsnj_7roel" style="height: 695px;" has-hovered="true"><div class="_1nC-FSfxis9BCt3z-FF2DU"></div><table border="0" cellspacing="0" cellpadding="0" style="width: 831pt; border-collapse: collapse; margin-left: 0.15pt; transform: scale(0.632671, 0.632671); transform-origin: left top;" min-scale="0.6326714801444043">
<tbody><tr style="height:47.25pt;">
<td style="background-color:#92D050;width:89pt;height:47.25pt;padding:0 3.5pt;border:1pt solid windowtext;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:white;font-size:12pt;">FECHA DE ACTUALIZADO</span></b></p>
</td>
<td nowrap="" style="background-color:#92D050;width:101pt;height:47.25pt;padding:0 3.5pt;border-width:1pt;border-style:solid solid solid none;border-color:windowtext;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:white;font-size:12pt;">EQUIPO MC</span></b></p>
</td>
<td nowrap="" style="background-color:#92D050;width:54pt;height:47.25pt;padding:0 3.5pt;border-width:1pt;border-style:solid solid solid none;border-color:windowtext;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:white;font-size:12pt;">NOVEDADES PENDIENTES</span></b></p>
</td>
<td nowrap="" style="background-color:#92D050;width:98pt;height:47.25pt;padding:0 3.5pt;border-width:1pt;border-style:solid solid solid none;border-color:windowtext;">
<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
<b><span style="color:white;font-size:12pt;">PARALIZACIÓN</span></b></p>
</td>
</tr>';
/*================================================================
=            OBTENER LOS EQUIPOS QUE TIENEN NOVEDADES Y OBTENER EL VALOR UNICO            =
================================================================*/
$listEquiposP = array();
for ($i=0; $i < count($listnovedades) ; $i++) { 
	if ($listnovedades[$i][10] == "PENDIENTE" || $listnovedades[$i][10] == "EN PROCESO") {
		if (strpos($listnovedades[$i][5], 'REPUESTO')  === false) {
			array_push($listEquiposP,[$listnovedades[$i][1],$listnovedades[$i][6]]);
		}
	}
}
$uniEquiposP = array_values(array_unique(array_column($listEquiposP,0)));
$fecha = date('Y-m-d');
/*===================================================================
=            OBTENEMOS EL TOTAL DE NOVEDADES POR EQUIPOS            =
===================================================================*/
$columna0 = array_column($listEquiposP, 0);
$totalporequipos = array_count_values($columna0);


function contarValoresArray($array){
	$contar=array();
	for ($i=0; $i < count($array) ; $i++) {
		if (!isset($contar[$array[$i][0]."-".$array[$i][1]])) {
			$contar[$array[$i][0]."-".$array[$i][1]] = 1;
		}else{
			$contar[$array[$i][0]."-".$array[$i][1]]++;
		}
	}
	return $contar;
}
/*===============================================
=            PARALIZACION DE EQUIPOS            =
===============================================*/
$uniqparalizacion = array_values(array_unique(array_column($listEquiposP, 1)));
$paralizar = contarValoresArray($listEquiposP);


$fila = 0;
	foreach ($uniEquiposP as $key => $value) {
		$fila += 1;
		if ($fila%2 == 0) {
				$body .= '<tr style="height:17.25pt;">
	<td nowrap="" style="background-color:#D9E1F2;width:89pt;height:17.25pt;padding:0 3.5pt;border-width:1pt;border-style:none solid solid solid;border-color:windowtext;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<span style="color:black;font-size:12pt;">'.$fecha.'</span></p>
	</td>
	<td nowrap="" style="background-color:#D9E1F2;width:101pt;height:17.25pt;padding:0 3.5pt;border-style:none solid solid none;border-right-width:1pt;border-bottom-width:1pt;border-right-color:windowtext;border-bottom-color:windowtext;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<span style="color:black;font-size:12pt;">'.$value.'</span></p>
	</td>
	<td nowrap="" style="background-color:#D9E1F2;width:54pt;height:17.25pt;padding:0 3.5pt;border-style:none solid solid none;border-right-width:1pt;border-bottom-width:1pt;border-right-color:windowtext;border-bottom-color:windowtext;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<span style="color:black;font-size:12pt;">'.$totalporequipos[$value].'</span></p>
	</td>';
		$body .= '<td nowrap="" style="background-color:#D9E1F2;width:98pt;height:17.25pt;padding:0 3.5pt;border-style:none solid solid none;border-right-width:1pt;border-bottom-width:1pt;border-right-color:windowtext;border-bottom-color:windowtext;">
		<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
		<span style="color:black;font-size:12pt;">';	
	for ($i=0; $i < count($uniqparalizacion) ; $i++) {

		if (isset($paralizar[$value."-".$uniqparalizacion[$i]])) {
			if ($uniqparalizacion[$i] == "SI APLICA" ) {
				$body .= "SI APLICA";	
				break;
			}else{
				$body .= "NO APLICA";	
			}
		}

	}
	$body .= '</span></p>
		</td>';
	$body .= '</tr>';
		/*===============================================================================
		=            EN CASO DE QUE SEA IMPAR SE COLOCA OTRO ESTILO DE TABLA            =
		===============================================================================*/				
		}else{
				$body .= '<tr style="height:17.25pt;">
	<td nowrap="" style="width:89pt;height:17.25pt;padding:0 3.5pt;border-width:1pt;border-style:none solid solid solid;border-color:windowtext;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<span style="color:black;font-size:12pt;">'.$fecha.'</span></p>
	</td>
	<td nowrap="" style="width:101pt;height:17.25pt;padding:0 3.5pt;border-style:none solid solid none;border-right-width:1pt;border-bottom-width:1pt;border-right-color:windowtext;border-bottom-color:windowtext;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<span style="color:black;font-size:12pt;">'.$value.'</span></p>
	</td>
	<td nowrap="" style="width:54pt;height:17.25pt;padding:0 3.5pt;border-style:none solid solid none;border-right-width:1pt;border-bottom-width:1pt;border-right-color:windowtext;border-bottom-color:windowtext;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<span style="color:black;font-size:12pt;">'.$totalporequipos[$value].'</span></p>
	</td>';
	$body .= '	<td nowrap="" style="width:98pt;height:17.25pt;padding:0 3.5pt;border-style:none solid solid none;border-right-width:1pt;border-bottom-width:1pt;border-right-color:windowtext;border-bottom-color:windowtext;">
	<p align="center" style="font-size:11pt;font-family:Calibri,sans-serif;text-align:center;margin:0;">
	<span style="color:black;font-size:12pt;">';	
	for ($i=0; $i < count($uniqparalizacion) ; $i++) { 

		if (isset($paralizar[$value."-".$uniqparalizacion[$i]])) {
			if ($uniqparalizacion[$i] == "SI APLICA" ) {
				$body .= "SI APLICA";	
				break;
			}else{
				$body .= "NO APLICA";	
			}
			
		}	

	}
	$body .= '</span></p>
	</td>';
	$body .= '</tr>';			


		}

	}

$body .= '	<tr style="height:15pt;">
<td colspan="2" rowspan="2" style="color:windowtext;font-size:16pt;font-family:Calibri,sans-serif;font-weight:700;text-align:center;vertical-align:middle;background-color:#FFC000;width:172pt;height:30.75pt;padding-top:1px;padding-right:1px;padding-left:1px;border-width:1pt;border-style:solid;border-color:windowtext black black windowtext;">
TOTAL NOVEDADES</td>
<td rowspan="2" style="color:windowtext;font-size:22pt;font-family:Calibri,sans-serif;font-weight:700;text-align:center;vertical-align:bottom;background-color:#FFC000;width:137pt;padding-top:1px;padding-right:1px;padding-left:1px;border-style:solid solid solid none;border-top-width:1pt;border-right-width:1pt;border-bottom-width:1pt;border-top-color:windowtext;border-right-color:windowtext;border-bottom-color:black;">
'.array_sum($totalporequipos) .'</td>
</tr></tbody></table></div>
</body>
</html>';
		$mail->setFrom('proyectosecuador@ransa.net','NOVEDADES RANSA');
		/*=============================================================================
		=            SE ENVIA CORREO AL USUARIO ADMINISTRADOR            =
		=============================================================================*/
		$itemuser = array("idciudad" => "idciudad",
						"perfil" => "perfil");
		$valoruser = array("idciudad" => $_SESSION["ciudad"],
							"perfil" => "COORDINADOR");
		$tablauser = "usuariosransa";
		$rptausuarios = ControladorUsuarios::ctrMostrarUsuariosRansa($tablauser,$itemuser,$valoruser);
		/*====================================================================
		=            SE ENVIA CORREO AL COORDINADOR DE LA CIUDAD             =
		====================================================================*/		
		for ($i=0; $i < count($rptausuarios) ; $i++) { 
			//$mail->addCC($rptausuarios[$i]["email"]);
		}
	    /*========================================================================
	    =            ENVIAMOS EL CORREO AL COORDINADOR DE JUNGHEINRICH CON COPIA A LA JEFA DEL COORDINADOR            =
	    ========================================================================*/
	   	$correosproveedores = json_decode($this->correonoti);

	    for ($i=0; $i < count($correosproveedores) ; $i++) {
	    	$mail->addAddress($correosproveedores[$i]);
	    }	    

		/*======================================================================
		=            CONSTRUIMOS EL ARREGLO PARA LLENAR EN EL EXCEL            =
		======================================================================*/
			//$arregloexcel = '[ ';
			$arregloexcel = array();
			$repuesto = array();
			for ($i=0; $i < count($listnovedades) ; $i++) { 
				$rptaEquipomc = ControladorEquipos::ctrConsultarEquipos($listnovedades[$i][1],"codigo");
				if ($listnovedades[$i][10] == "PENDIENTE" || $listnovedades[$i][10] == "EN PROCESO") {
					if (strpos($listnovedades[$i][5], 'REPUESTO')  !== false) {
						array_push($repuesto,[$listnovedades[$i][8],$rptaEquipomc[0]["modelo"],$listnovedades[$i][1],$listnovedades[$i][3],$listnovedades[$i][5],$listnovedades[$i][6],$listnovedades[$i][9],$listnovedades[$i][10]]);
					}else{
						array_push($arregloexcel,[$listnovedades[$i][8],$rptaEquipomc[0]["modelo"],$listnovedades[$i][1],$listnovedades[$i][3],$listnovedades[$i][5],$listnovedades[$i][6],$listnovedades[$i][9],$listnovedades[$i][10]]);						
					}
					
				}
			}

	    /*=============================================================
	    =            CREANMOS EL ARCHIVO EXCEL DESDE HTML             =
	    =============================================================*/
			$documento = new Spreadsheet();
			/*===============================================================================
			=            PROPIEDADES DEL ARCHIVO EXCEL QUE SE ENVIARÁ POR CORREO            =
			===============================================================================*/
			$documento
			->getProperties()
			->setCreator("RANSA")
			->setLastModifiedBy('Parzibyte') // última vez modificado por
			->setTitle('Listado de Novedades Actualizadas'.$fecha)
			->setSubject('Novedades de Equipos por solucionar')
			->setDescription('Listado completo de novedades pendientes y en proceso por reparar en RANSA')
			->setKeywords('Novedades, Equipos, Montacargas, Pendientes')
			->setCategory('Equipos MC');
			/*======================================================
			=            CONTENIDO DEL ARCHIVO DE EXCEL            =
			======================================================*/
			$documento->setActiveSheetIndex(0) //escogemos la primera pestaña para llenar información
			->setCellValue('A3', 'FECHA DE REPORTE DE NOVEDAD')
		    ->setCellValue('B3', 'MODELO')
		    ->setCellValue('C3', 'MC')
		    ->setCellValue('D3', 'RESPONSABLE')
		    ->setCellValue('E3', 'NOVEDADES')
		    ->setCellValue('F3', 'PARALIZACIÓN')
		    ->setCellValue('G3', 'FECHA TENTATIVA')
		    ->setCellValue('H3', 'STATUS');

		    /*========================================================
		    =            ASIGNAMOS TAMAÑO DE LAS COLUMNAS            =
		    ========================================================*/
		   	$documento->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);
		    /*==============================================================
		    =            LLENAR INFORMACION PARA CREAR LA TABLA            =
		    ==============================================================*/
		    $documento->getActiveSheet()
		    ->fromArray(
		        $arregloexcel,  // The data to set
		        NULL,        // Array values with this value will not be set
		        'A4'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );

		    /*==============================================================================================
		    =            CREAMOS LA SIGUIENTE PESTAÑA DONDE SE GURADARÁ EL LISTAOD DE NOVEDADES            =
		    ==============================================================================================*/
		    $hoja2 = $documento->createSheet();
		    $hoja2->setTitle('Listado de Repuestos');
		    $documento->setActiveSheetIndexByName('Listado de Repuestos');

			$documento->setActiveSheetIndex(1) //escogemos la primera pestaña para llenar información
			->setCellValue('A3', 'FECHA DE REPORTE DE NOVEDAD')
		    ->setCellValue('B3', 'MODELO')
		    ->setCellValue('C3', 'MC')
		    ->setCellValue('D3', 'RESPONSABLE')
		    ->setCellValue('E3', 'NOVEDADES')
		    ->setCellValue('F3', 'PARALIZACIÓN')
		    ->setCellValue('G3', 'FECHA TENTATIVA')
		    ->setCellValue('H3', 'STATUS');

		    /*========================================================
		    =            ASIGNAMOS TAMAÑO DE LAS COLUMNAS            =
		    ========================================================*/
		   	$documento->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('G')->setAutoSize(true);
		    $documento->getActiveSheet()->getColumnDimension('H')->setAutoSize(true);




		    $documento->getActiveSheet()
		    ->fromArray(
		        $repuesto,  // The data to set
		        NULL,        // Array values with this value will not be set
		        'A4'         // Top left coordinate of the worksheet range where
		                     //    we want to set these values (default is A1)
		    );






		    
		    






			$writer = new Xlsx($documento);
			# Le pasamos la ruta de guardado
			$writer->save('Novedades_Actualizadas.xlsx');


	    /*$mail->addCC("carlos.sanchez@jungheinrich.ec");
	    $mail->addCC("luis.perez@jungheinrich.ec");
	    $mail->addCC('maria.cordero@jungheinrich.ec');*/

	    $mail->AddAttachment('Novedades_Actualizadas.xlsx');


	    

	    $mail->Subject = 'REPORTE DE NOVEDADES ACTUALIZADAS'.$fecha;
	    $mail->Body    = $body;
	    //$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

	    $envios = $mail->send();
	    if ($envios) {
	    	/*================================================================================
	    	=            ELIMINAMOS EL ARCHIVO QUE SE CREO PARA ENVIAR POR CORREO            =
	    	================================================================================*/
	    	$documento->disconnectWorksheets();
			unset($documento);
	    	unlink('Novedades_Actualizadas.xlsx');
			echo 1;
		}else{
			echo 2;
		}


	}
	/*=================================================================
	=            CERRAR TIEMPO PARA REALIZAR EL CHECK LIST            =
	=================================================================*/
	public function CerrarTimeCheck(){

		$datos = array("idequipomc" =>  $this->idequipo,
						"eqp1" =>  0,
						"eqp2" =>  0,
						"eqp3" =>  0,
						"eqp4" =>  0,
						"eqp5" =>  0,
						"eqp6" => 0,
						"eqp7" => 0,
						"btr1" => 0,
						"btr2" => 0,
						"cbtr1" => 0 ,
						"cbtr2" => 0 ,
						"crgd1" => 0 ,
						"crgd2" => 0 ,
						"crgd3" => 0  ,
						"oprc1" =>  0 ,
						"oprc2" =>  0 ,
						"oprc3" =>  0 ,
						"oprc4" =>  0 ,
						"oprc5" =>  0 ,
						"oprc6" =>  0 ,
						"oprc7" =>  0 ,
						"oprc8" =>  0 ,
						"oprc9" =>  0 ,
						"cantinovedad" => 0,
						"horometro" => 0,
						"ideasignacion" => $this->idasignacion,
						"motivoatraso" => NULL,
						"observacion" => NULL,
						"motivobloq" => $this->motivobloq,
						"estado" => 3); //estado 3 no cumple check list
		$rpta = ControladorCheckList::ctrRegistroCheckList($datos);

		echo $rpta;

	}
	/*===============================================================================
	=            REPORTAR EL EQUIPO SE ENCUENTRA NO OPERATIVO CHECK LIST            =
	===============================================================================*/
	public function ReportNoOperativo(){
		$datos = array("idequipomc" =>  $this->idequipo,
						"eqp1" =>  0,
						"eqp2" =>  0,
						"eqp3" =>  0,
						"eqp4" =>  0,
						"eqp5" =>  0,
						"eqp6" => 0,
						"eqp7" => 0,
						"btr1" => 0,
						"btr2" => 0,
						"cbtr1" => 0 ,
						"cbtr2" => 0 ,
						"crgd1" => 0 ,
						"crgd2" => 0 ,
						"crgd3" => 0  ,
						"oprc1" =>  0 ,
						"oprc2" =>  0 ,
						"oprc3" =>  0 ,
						"oprc4" =>  0 ,
						"oprc5" =>  0 ,
						"oprc6" =>  0 ,
						"oprc7" =>  0 ,
						"oprc8" =>  0 ,
						"oprc9" =>  0 ,
						"cantinovedad" => 0,
						"horometro" => 0,
						"ideasignacion" => $this->idasignacion,
						"motivoatraso" => NULL,
						"observacion" => NULL,
						"motivobloq" => $this->motivobloq,
						"estado" => 4); // estado 4 NO OPERATIVO dentro check list
		$rpta = ControladorCheckList::ctrRegistroCheckList($datos);

		echo $rpta;		

	}
	
	/*======================================================
	=            GUARDAR PDF DE LA OT REALIZADA            =
	======================================================*/
	public function ajaxGuardarOTPdf(){
		$file = $this->OTpdf;
		$directorio = $this->idequipo;
		$ciudad = $_SESSION["ciudad"];

		$respuesta = ControladorEquipos::ctrSubirPdfOT($file,$directorio,$ciudad);

		echo $respuesta;		

	}
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
	
}

/*===========================================
=            REGISTRO DE EQUIPOS            =
===========================================*/
if (isset($_POST["codig"])) {
	$registroEquipo = new AjaxEquipos();

	$registroEquipo -> Equipo = $_POST["equipo"];
	$registroEquipo -> modelo = $_POST["model"];
	$registroEquipo -> ciudad = $_POST["ciudad"];
	$registroEquipo -> tipoEquipo = $_POST["t_equipo"];
	$registroEquipo -> serie = $_POST["seri"];
	$registroEquipo -> baterias = $_POST["bateriax"];	
	$registroEquipo -> codigo = $_POST["codig"];
	$registroEquipo -> iduser = $_POST["idUse"];
	$registroEquipo -> idlocalizacion = $_POST["localizacion"];
	$registroEquipo -> epadre	 = $_POST["epadre"];
	$registroEquipo -> horometro = $_POST["horometro"];
	$registroEquipo -> centrocosto = $_POST["centrocosto"];

	
	$registroEquipo -> ajaxRegistrarEquipo();
}
/*===========================================
=            CONSULTA DE EQUIPOS            =
===========================================*/
if (isset($_POST["idequipo"])) {
	$editarequipo = new AjaxEquipos();
	$editarequipo -> idequipo = $_POST["idequipo"];
	$editarequipo -> ajaxConsultarEquipos();
}
/*===============================================
=            EDITAR DATOS DEL EQUIPO            =
===============================================*/
if (isset($_POST["ideditador"])) {
	$editarEquipo = new AjaxEquipos();
	$editarEquipo -> Equipo = $_POST["equipo"];
	$editarEquipo -> ciudad = $_POST["ciudad"];
	$editarEquipo -> modelo = $_POST["modelo"];
	$editarEquipo -> tipoEquipo = $_POST["tipo_equipo"];
	$editarEquipo -> codigo = $_POST["codigo"];
	$editarEquipo -> horometro = $_POST["horometro_inicial"];
	$editarEquipo -> serie = $_POST["serie"];
	$editarEquipo -> baterias = $_POST["baterias"];
	$editarEquipo -> idequipo = $_POST["idequipomc"];
	$editarEquipo -> idlocalizacion= $_POST["localizacion"];
	$editarEquipo -> epadre= $_POST["equipopadre"];
	$editarEquipo -> iduser= $_POST["ideditador"];
	$editarEquipo -> centrocosto= $_POST["idcentro_costo"];


	$editarEquipo -> ajaxEditarEquipo();
	
}

/*=============================================
=            ASIGNACION DE EQUIPOS            =
=============================================*/
if (isset($_POST["asignador"])) {
	$asignador = new AjaxEquipos();
	$asignador -> idequipo = $_POST["idequipomc"];
	$asignador -> idusuarioransa = $_POST["idusuarioransa"];
	$asignador -> llave = $_POST["llave"];
	$asignador -> responsable = $_POST["responsable"];
	$asignador -> turno = $_POST["turno"];
	$asignador -> iduser = $_POST["asignador"];
	$asignador -> ajaxAsignarResponsable();
}
/*=========================================================
=            CONSULTAR ASIGNACIONES DE EQUIPOS            =
=========================================================*/
if (isset($_POST["idConsultAsignacion"])) {
	$consultAsig = new AjaxEquipos();
	$consultAsig -> idequipo = $_POST["idConsultAsignacion"];
	$consultAsig -> ajaxConsultarAsignacionEquipos();
		
}
/*==================================================================================
=            CONSULTAR SI HAY TURNO ASIGNADO PARA BLOQUEAR LAS OPCIONES            =
==================================================================================*/
if (isset($_POST["bloqAsigRegi"])) {
	$bloqasigRegis = new AjaxEquipos();
	$bloqasigRegis -> idequipo = $_POST["bloqAsigRegi"];
	$bloqasigRegis -> ajaxConsultadeAsignacion();
}
/*========================================================
=            CAMBIAR EL ESTADO DE ASIGNACION (ELIMINADO)            =
========================================================*/
if (isset($_POST["idAsigEliminar"])) {
	$eliminarAsig = new AjaxEquipos();
	$eliminarAsig -> idasignacion = $_POST["idAsigEliminar"];
	$eliminarAsig -> ajaxEliminarAsignacion();
}
/*==========================================
=            ELIMINAR EL EQUIPO            =
==========================================*/
if (isset($_POST["idequipoE"])) {
	$eliminarEquipo = new AjaxEquipos();
	$eliminarEquipo -> idequipo = $_POST["idequipoE"];
	$eliminarEquipo -> ajaxEliminarEquipo();
}
/*==============================================
=            REGISTRAR NUEVA CIUDAD            =
==============================================*/
if (isset($_POST["nciudad"])) {
	$regciudad = new AjaxEquipos();
	$regciudad -> desc_ciudad = $_POST["nciudad"];
	$regciudad -> ajaxRegistrarCiudad();
}
/*======================================================
=            REGISTRAR NUEVO TIPO DE EQUIPO            =
======================================================*/
if (isset($_POST["tequipon"])) {
	$tequipo = new AjaxEquipos();
	$tequipo -> tipo_equipo = $_POST["tequipon"];
	$tequipo -> descripcion_equipo = $_POST["descrip_equipo"];
	$tequipo -> ajaxRegistroTipoEquipo();
}
/*======================================================
=            REGISTRO DE NUEVA LOCALIZACIÓN            =
======================================================*/
if (isset($_POST["NLocalizacion"])) {
	$localizacion = new AjaxEquipos();
	$localizacion -> localizacion = $_POST["NLocalizacion"];
	$localizacion -> ajaxRegistroLocalizacion();
}
/*===============================================================
=            CONSULTAR LOCALIZACIÓN DEL EQUIPO PADRE            =
===============================================================*/
if (isset($_POST["idlocalizacionEp"])) {
	$localiEp = new AjaxEquipos();
	$localiEp -> idlocalizacion = $_POST["idlocalizacionEp"];
	$localiEp -> ajaxConsultarLocalizacionEP();
}
/*=====================================================================================================================
=            CONSULTAR LOS EQUIPOS PARA LLENAR SELECT PERO QUE NO SE ENCUENTRE EL EQUIPO QUE ESTA EDITANDO            =
=====================================================================================================================*/
if (isset($_POST["llenar_selectE"])) {
	$llenarselect = new AjaxEquipos();
	$llenarselect -> idequipo = $_POST["llenar_selectE"];
	$llenarselect -> consultaSelectE();
}
/*=========================================================
=            REGISTRO DE NUEVO CENTRO DE COSTO            =
=========================================================*/
if (isset($_POST["nom_cc"])) {
	$registrocc = new AjaxEquipos();
	$registrocc -> nombre_cc = $_POST["nom_cc"];
	$registrocc -> descripcion =  $_POST["descripcion"];
	$registrocc -> ajaxRegistroCC();
}
/*=========================================================
=            SELECCION DE EQUIPO POR EL CODIGO            =
=========================================================*/
if (isset($_POST["codigomcseleccion"])) {
	$consultmc = new AjaxEquipos();
	$consultmc -> codigo = $_POST["codigomcseleccion"];
	$consultmc -> ajaxSeleccionEquipoMC();
}
/*==============================================================================
=            BUSCAR RESPONSABLE ASIGNADO PARA MOSTRAR EN CHECK LIST            =
==============================================================================*/
if (isset($_POST["buscarasignado"])) {
	$checkasignador = new AjaxEquipos();
	$checkasignador -> idequipo = $_POST["buscarasignado"];
	$checkasignador -> ajaxBuscarAsignador();
}

/*=================================================================
=            INGRESO DE DATOS DE CHECK LIST DE EQUIPOS            =
=================================================================*/
if (isset($_POST["horocheck"])) {
	$registrochecklist = new AjaxEquipos();
	$registrochecklist -> equipo  = $_POST["equipo"];
	$registrochecklist -> bateria = $_POST["bateria"];
	$registrochecklist -> carrobateria = $_POST["carro_bateria"];
	$registrochecklist -> cargador = $_POST["cargador"];
	$registrochecklist -> operacional = $_POST["operacional"];
	$registrochecklist -> horochecklist = $_POST["horocheck"];
	$registrochecklist -> obserchecklist = $_POST["observacheck"];
	$registrochecklist -> idequipo = $_POST["idequipocheck"];
	$registrochecklist -> idasignacion = $_POST["idasignacioncheck"];
	$registrochecklist -> forma = $_POST["forma"];
	$registrochecklist -> motivoatraso = $_POST["motivoatraso"];
	$registrochecklist -> ajaxRegistroCheckList();
}
/*===================================================================
=            INGRESA LA FECHA TENTATIVA PARA LA SOLUCION            =
===================================================================*/
if (isset($_POST["fecha_propuesta"])) {
	$actualizarfechapropuesta = new AjaxEquipos();
	$actualizarfechapropuesta -> fecha_propuesta = $_POST["fecha_propuesta"];
	$actualizarfechapropuesta -> idnovequipos = $_POST["idnovequipos"];
	$actualizarfechapropuesta -> ajaxRegistroFechaPropuesta();
}
/*=================================================================
=            CAMBIA EL ESTADO A LA NOVEDAD SOLUCIONADA            =
=================================================================*/
if (isset($_POST["idnovedadconcluido"])) {
	$concluidonovedad = new AjaxEquipos();
	$concluidonovedad -> idnovequipos = $_POST["idnovedadconcluido"];
	$concluidonovedad -> idequipo = $_POST["idequipoconcluido"];
	$concluidonovedad -> ot = $_POST["ot"];
	$concluidonovedad -> observacionesot = $_POST["observacionot"];
	$concluidonovedad -> rutaotRealizada = $_POST["otrealizada"] == "" ? NULL : $_POST["otrealizada"];
	$concluidonovedad -> ajaxNovedadConcluida();
}
/*====================================================
=            CAMBIA EL ESTADO A ELIMINADO            =
====================================================*/
if (isset($_POST["idnovedadeliminar"])) {
	$noveeliminar = new AjaxEquipos();
	$noveeliminar -> idnovequipos = $_POST["idnovedadeliminar"];
	$noveeliminar -> ajaxEliminarNovedad();
}
/*====================================================================
=            VERIFICA SI YA SE HA REALIZADO EL CHECK LIST            =
====================================================================*/
if (isset($_POST["idasignarverificarcheck"])) {
	$verificarchecklist = new AjaxEquipos();
	$verificarchecklist -> idasignacion = $_POST["idasignarverificarcheck"];
	$verificarchecklist -> idequipo = $_POST["idequipoverificarcheck"];
	$verificarchecklist -> ajaxVerificarCheckList();
}
if (isset($_POST["Eqxciudad"])) {
	$clasnovedad = new AjaxEquipos();
	$clasnovedad -> ajaxConsultEqxciudadgra();
}
if (isset($_POST["idequipomanejo"])) {
	$manejo = new AjaxEquipos();
	$manejo -> idequipo = $_POST["idequipomanejo"];
	$manejo -> opciones = $_POST["opciones"];
	$manejo -> personal = $_POST["nombre_personal"];
	$manejo -> identbinicio = $_POST["numbateria"];
	$manejo -> codigo_baterias = $_POST["cod_bateria"];
	$manejo -> porcbinicio = $_POST["pocentcarga"];
	$manejo -> horoinicio = $_POST["horometroInicial"];
	$manejo -> observacion = $_POST["Observaciones"];
	$manejo -> ajaxManejoEquipo();
}
if (isset($_POST["idterminomanejo"])) {
	$terminomanejo = new AjaxEquipos();
	$terminomanejo -> idmanejoeq = $_POST["idterminomanejo"];
	$terminomanejo -> horoinicio = $_POST["horofinal"];
	$terminomanejo -> identbinicio = $_POST["numbateriafinal"];
	$terminomanejo -> porcbinicio = $_POST["cantcargafinal"];
	$terminomanejo -> ubicacion= $_POST["ubicafinal"];
	$terminomanejo -> observacion = $_POST["observacionfinal"];
	$terminomanejo -> ajaxtManejoTermino();
}
if (isset($_POST["idmanejoeqnoentrega"])) {
	$notifinoentrega = new AjaxEquipos();
	$notifinoentrega -> idmanejoeq = $_POST["idmanejoeqnoentrega"];
	$notifinoentrega -> personal = $_POST["personalnoentrega"];
	$notifinoentrega -> personalnuevo = $_POST["personalnuevouso"];
	$notifinoentrega -> horoinicio = $_POST["horometronotificado"];
	
	
	$notifinoentrega -> NotificarNoEntrega();
}
if (isset($_POST["idTablaNotinoEntrega"])) {
	$notitabla = new AjaxEquipos();
	$notitabla -> idmanejoeq = $_POST["idTablaNotinoEntrega"];
	$notitabla -> ajaxNoEntregaNotificacion();
}
if (isset($_POST["noticorreosNovedades"])) {
	$notinovedad = new AjaxEquipos();
	$notinovedad -> correonoti = $_POST["noticorreosNovedades"];
	$notinovedad -> datanovedad = $_POST["tabla_data"];
	$notinovedad -> ajaxNotificarNovedadesProveedor();
}
/*============================================================
=            CERRAR TIEMPO PARA HACER CHECK LIST            =
============================================================*/

if (isset($_POST["equipoCerrarCheck"])) {
	$cerrarTime = new AjaxEquipos();
	$cerrarTime -> idequipo = $_POST["equipoCerrarCheck"];
	$cerrarTime -> idasignacion = $_POST["ideasignacion"];
	$cerrarTime -> motivobloq = $_POST["motivobloq"];

	$cerrarTime -> CerrarTimeCheck();
}
/*===============================================================================
=            REPORTAR QUE ESE DÍA EL EQUIPO SE ENCUENTRA INOPERATIVO            =
===============================================================================*/
if (isset($_POST["equipoReportNoOperativo"])) {
	$reportNoOperativa = new AjaxEquipos();
	$reportNoOperativa -> idequipo = $_POST["equipoReportNoOperativo"];
	$reportNoOperativa -> idasignacion = $_POST["ideasignacion"];
	$reportNoOperativa -> motivobloq = $_POST["motivobloq"];

	$reportNoOperativa -> ReportNoOperativo();
}
/*====================================================
=            GUARDAR LA OT EN EL SERVIDOR            =
====================================================*/
if (isset($_FILES["fileOT"])) {
	$guardarpdf = new AjaxEquipos();
	$guardarpdf -> idequipo = $_POST["equipomc"];
	$guardarpdf -> OTpdf = $_FILES["fileOT"];
	$guardarpdf -> ajaxGuardarOTPdf();
}


