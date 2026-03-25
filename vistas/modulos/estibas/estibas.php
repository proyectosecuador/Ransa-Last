<body style="background: #f1f1f1;">
  <form method="POST">
    <div class="text-center">
      <h1>Completar la información</h1>
      <h4>Ingresa el código </h4>
      <div class="input-group-addon">
        <input class="form-control-static" name="codigoMov" type="text" name="">
        <button type="" class="btn btn-info btn-lg">Buscar <i class="fas fa-search"></i></button>
        <!-- <button type="button" id="redireccionar">Redireccionar</button> -->
      </div>

    </div>
  </form>
  <?php
  if (!empty($_POST)) {
    if (isset($_POST["codigoMov"]) && $_POST["codigoMov"] != "") {
      /*========================================================
	=            SE CONSULTA EL CODIGO DEL ESTIBA            =
	========================================================*/
      $mov = ControladorMovRD::ctrConsultarMovRD($_POST["codigoMov"], "codigo_generado");
      if ($mov) {

        /*==============================================
	=            CONOCEMOS LA ACTIVIDAD            =
	==============================================*/
        $rptaActividad = ControladorActividadE::ctrConsultarActividadE("idactividad_estiba", $mov["idactividad"]);
        /*==============================================
	=            CONSULTAMOS EL CLIENTE            =
	==============================================*/
        $rptaCliente = ControladorClientes::ctrmostrarClientes("idcliente", $mov["idcliente"]);
        /*================================================
	=            CONSULTAMOS LA CUADRILLA            =
	================================================*/
        $rptaCuadrilla = ControladorEstibas::ctrConsultarEstibas($mov["idproveedor_estiba"], "idproveedor_estiba");
        /*============================================================
	=            CONSULTAMOS LOS TIPOS DE TRANSPPORTE            =
	============================================================*/
        $rptaTTransporte = ControladorTTransporte::ctrConsultarTTransporte("", "");

        /*=====================================================================
  =            VALIDAMOS SI HA SIDO INGRESADO LA INFORMACIÓN            =
  =====================================================================*/
        if (!$rptaCuadrilla) {
          /*==============================================================================
    =            MENSAJE SI NO SE SOLICITTADO CUADRILLA PARA ESE CODIGO            =
    ==============================================================================*/
          echo '<script>
            Swal.fire({
              title: "Código Invalido.",
              text: "El código ingresado no ha solicitado una Cuadrilla de Estiba..",
              type: "info",
              confirmButtonText: "Aceptar"
            });     
       </script>';
        } else {
          if ($mov["estado"] < 5) {
            $form = '<div class="x_panel">
            <div class="x_title">
             <h2>Cuadrilla ' . $rptaCuadrilla["nombre_proveedor"] . '</h2>
             <input type="hidden" class="form-control uppercase Estidproveedor_estiba" disabled="" name="" value="' . $rptaCuadrilla["idproveedor_estiba"] . '">
              <div class="clearfix"></div>
          <div class="x_content" style="padding-top: 20px;">
            <div class="row">
                <div class="col-xs-12 col-md-4">
                  <div class="input-group">
                    <label class="input-group-addon">Fecha / Hora Prog.: </label>
                    <input type="text" class="form-control uppercase Estfecha_programada" disabled="" name="" value="' . $mov["fecha_programada"] . '">
                    <input type="hidden" class="form-control uppercase Estidmov" disabled="" name="" value="' . $mov["idmov_recep_desp"] . '">
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                  <div class="input-group">
                    <label class="input-group-addon">Cliente: </label>
                    <input type="text" class="form-control uppercase Estrazonsocial" disabled="" name="" value="' . $rptaCliente["razonsocial"] . '">
                    <input type="hidden" class="form-control uppercase Estidrazonsocial" disabled="" name="" value="' . $rptaCliente["idcliente"] . '">
                  </div>
                </div>
                <div class="col-xs-12 col-md-4">
                  <div class="input-group">
                    <label class="input-group-addon">Actividad: </label>
                    <input type="text" class="form-control uppercase Estactividad" disabled="" name="" value="' . $rptaActividad["descripcion"] . '">
                    <input type="hidden" class="form-control uppercase Estidactividad" disabled="" name="" value="' . $rptaActividad["idactividad_estiba"] . '">
                  </div>
                </div>        
                <div class="col-xs-12 col-md-4">
                  <div class="input-group">
                    <label class="input-group-addon">Tipo de Transporte: *</label>
                    <select class="form-control uppercase EstTransporte" name="">
                    <option>Seleccionar una opción</option>';
      
      $opcionesPermitidas = [
            14 => [42, 43, 45, 47, 49, 51, 53, 60, 61, 83, 93, 94, 44, 46, 48, 50, 52, 54, 56, 95],
            88 => [71, 73, 74,61, 67, 68, 93],
            70 => [71, 73, 74,61, 67, 68, 93],
            65 => [71, 73, 74,61, 67, 68, 93],
            74 => [71, 73, 74,61, 67, 68, 93],
            89 => [61,93],
            58 => [71, 73, 74,61, 67, 68, 93],
            86 => [71, 73, 74,61, 67, 68, 93],
            50 => [71, 73, 74,61, 67, 68, 93],
            43 => [71, 73, 74,61, 67, 68, 93],
            2  => [43,44, 58,61, 69, 93],
            3  => [73, 74,61, 67, 68, 93, 110],
            93 => [61,93],
            94 => [61,71, 73, 74, 67, 68, 93],
            27 => [61,71, 73, 74, 67, 68],
            64 => [61,71, 73, 74, 67, 68, 93],
            38 => [61,91, 90, 66, 63, 64, 65, 83, 93],
            25 => [61,73, 74, 67, 68, 93],
            44 => [71, 73, 74,61, 67, 68, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 93],
            73 => [61,106, 73, 107, 67, 68, 93],
            22 => [61,71, 73, 74, 67, 68, 93],
            78 => [61,71, 73, 74, 67, 68, 83, 93],
            8  => [61,69, 70, 83, 93],
            11 => [91, 90,61,  66, 63, 64, 65, 83],
            53 => [61,71, 73, 74, 67, 68],
            6  => [61,69, 70, 83, 93],
            20 => [61,93, 108, 109],
            13 => [61,83, 88],
            31 => [61,71, 72, 73, 74, 67, 68, 94],
            10 => [61,69, 70],
            9  => [61,71, 73, 74, 67, 68, 93],
            67 => [61,71, 73, 74, 67, 68, 93],
        ];
      
      // Obtener el idCliente actual
      $idCliente = $rptaCliente["idcliente"];
      
      // Verificar si el cliente tiene opciones permitidas
      if (isset($opcionesPermitidas[$idCliente])) {
          $permitidos = $opcionesPermitidas[$idCliente];
      } else {
          $permitidos = null; // Si no hay restricciones, mostrar todas las opciones
      }
      
      // Generar las opciones del select
      for ($i = 0; $i < count($rptaTTransporte); $i++) {
          if ($rptaTTransporte[$i]["estado"] == 1) {
              // Mostrar solo las opciones permitidas si hay restricciones
              if ($permitidos === null || in_array($rptaTTransporte[$i]["idtipo_transporte"], $permitidos)) {
                  $form .= '<option value ="' . $rptaTTransporte[$i]["idtipo_transporte"] . '">' . $rptaTTransporte[$i]["descripcion"] . '</option>';
              }
          }
      }
            $form .= '</select>
            </div>
          </div>
          <div class="col-xs-12 col-md-4">
            <div class="input-group">
              <label class="input-group-addon">N° Contenedor: *</label>
              <input type="text" class="form-control uppercase EstContenedor" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-4">
            <div class="input-group">
              <label class="input-group-addon">N° Guías: *</label>
              <input type="text" class="form-control uppercase EstGuias" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-4">
            <div class="input-group">
              <label class="input-group-addon">Hora Garita: </label>
              <input type="text" class="form-control uppercase EstHGarita" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-4">
            <div class="input-group">
              <label class="input-group-addon">Hora Inicio: *</label>
              <input type="text" class="form-control uppercase EstHInicio" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-4">
            <div class="input-group">
              <label class="input-group-addon">Hora Fin: *</label>
              <input type="text" class="form-control uppercase EstHFin" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-9">
            <div class="input-group">
              <label class="input-group-addon">Nombres de Estibas: *</label>
              <input type="text" class="form-control uppercase EstNomEstibas" name="">
            </div>
          </div>
          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="input-group">
              <label class="input-group-addon">Cant. Film (rollos): *</label>
              <input type="number" class="form-control uppercase EstCantFilm" name="">
            </div>
          </div>        
          <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="input-group">
              <label class="input-group-addon">Cant. Código: *</label>
              <input type="number" class="form-control uppercase EstCantCodigo" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-3">
            <div class="input-group">
              <label class="input-group-addon">Cant. Fecha: *</label>
              <input type="number" class="form-control uppercase EstCantFecha" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-3">
            <div class="input-group">
              <label class="input-group-addon">Cant. Pallets: *</label>
              <input type="number" class="form-control uppercase EstCantPallet" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-3">
            <div class="input-group">
              <label class="input-group-addon">Cant. Bulto: *</label>
              <input type="number" class="form-control uppercase CantBulto" name="">
            </div>
          </div>
          <div class="col-xs-12 col-md-12">
            <div class="input-group">
              <label class="input-group-addon">Observaciones: </label>
              <textarea class="form-control uppercase EstObservacion"></textarea>
            </div>
          </div> 
          <div class="text-center">
            <button class="btn btn-primary btnDatosMovEstiba">Ingresar</button>
            
          </div>      
      </div>
      
    </div>
        </div>  
    
  </div>';
          } else {
            echo '<script>
          Swal.fire({
            title: "Código ' . $_POST["codigoMov"] . '",
            text: "El código ingresado ya ha sido registrado.",
            type: "info",
            confirmButtonText: "Aceptar"
          });     
     </script>';
          }

          echo $form;
        }
      } else {
        /*==================================================================================
		=            MENSAJE DE QUE EL CODIGO NO SE ENCUENTRA O ESTA INCORRECTO            =
		==================================================================================*/
        echo '<script>
			      Swal.fire({
			        title: "Código No Encontrado",
			        text: "El código ingresado no se encuentra o ha sido mal digitado, por favor revisar..",
			        type: "info",
			        confirmButtonText: "Aceptar"
			      });  		
			 </script>';
      }
    } else {
      /*==================================================================
		=            MENSAJE DE QUE EL CAMPO SE ENCUENTRA VACIO            =
		==================================================================*/
      echo '<script>
			      Swal.fire({
			        title: "Es necesario ingresar el código",
			        type: "info",
			        confirmButtonText: "Aceptar"
			      });  		
			 </script>';
    }
  }


  ?>

  <div class="pull-right">
    developed by Douglas Borbor
  </div>
  <div class="clearfix"></div>
</body>