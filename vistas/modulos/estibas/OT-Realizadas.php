<!-- page content -->

<div class="page-title">

  <div class="row">

    <div class="title_left">

      <div class="titlePage">

        <h3>Listado Trabajos Realizados</h3>

      </div>

    </div>

  </div>

</div>

</div>

<div class="clearfix"></div>


<div class="x_panel">

  <div class="x_content">

    <div class="table-responsive">

      <table id="TablaOTEstibas" class="table table-striped table-bordered dt-responsive nowrap">

        <thead>

          <tr>

            <th>Fecha Prog.</th>

            <th>Cliente</th>

            <th>Actividad</th>

            <th>Comentario</th>

            <th>Codigo</th>

            <th>N° Guia</th>

            <th>Acciones</th>


          </tr>

        </thead>

        <tbody>





        </tbody>

      </table>

    </div>
  </div>

</div>



</div>

</div>

<!--====================================================
=            MODAL PRESENTAR DATOS A LA CUADRILLA            =
=====================================================-->
<div class="modal fade modalVisualEstiba" role="dialog">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->

      <div class="modal-header" style="background-color: #4d6a88; color: white;">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Información Ingresada</h4>
      </div>
      <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
      <div class="modal-body">
        <div class="x-content" style="padding: 15px 15px 0px 0px;">
          <div class="row">
            <div class="col-md-12 col-xs-12">
              <div class="x-content">
                <div style="height: auto;">
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">Fecha / Hora Prog.: </label>
                      <input type="text" class="form-control uppercase fecha_programadaCSupEst" disabled="" name="" value="">
                      <input type="hidden" class="form-control uppercase idmovCSupEst" name="">
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">Cliente: </label>
                      <input type="text" class="form-control uppercase razonsocialCSupEst" disabled="" name="" value="">
                      <!-- <input type="hidden" class="form-control uppercase idrazonsocialCSupEst" disabled="" name="" value=""> -->
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">Actividad: </label>
                      <input type="text" class="form-control uppercase actividadCSupEst" disabled="" name="" value="">
                      <!-- <input type="hidden" class="form-control uppercase idactividadCSupEst" disabled="" name="" value=""> -->
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">Tipo de Transporte: *</label>
                      <select class="form-control uppercase TransporteCSupEst" disabled name="">
                        <option>Seleccionar una opción</option>
                        <?php
                        /*============================================================
            =            CONSULTAMOS LOS TIPOS DE TRANSPORTE            =
            ============================================================*/
                        $rptaTTransporte = ControladorTTransporte::ctrConsultarTTransporte("", "");

                        // Definir las opciones permitidas por cliente
                        $opcionesPermitidas = [
                          14 => [42,43, 45, 47, 49, 51, 53, 60, 83, 93, 94, 44, 46, 48, 50, 52, 54, 56, 95],
                          88 => [71, 73, 74, 67, 68, 93],
                          70 => [71, 73, 74, 67, 68, 93],
                          65 => [71, 73, 74, 67, 68, 93],
                          74 => [71, 73, 74, 67, 68, 93],
                          89 => [93],
                          58 => [71, 73, 74, 67, 68, 93],
                          86 => [71, 73, 74, 67, 68, 93],
                          50 => [71, 73, 74, 67, 68, 93],
                          43 => [71, 73, 74, 67, 68, 93],
                          2  => [43,44, 58,61, 69, 93],
                          3  => [73, 74, 67, 68, 93, 110],
                          93 => [93],
                          94 => [71, 73, 74, 67, 68, 93],
                          27 => [71, 73, 74, 67, 68],
                          64 => [71, 73, 74, 67, 68, 93],
                          38 => [91, 90, 66, 63, 64, 65, 83, 93],
                          25 => [73, 74, 67, 68, 93],
                          44 => [71, 73, 74, 67, 68, 96, 97, 98, 99, 100, 101, 102, 103, 104, 105, 93],
                          73 => [106, 73, 107, 67, 68, 93],
                          22 => [71, 73, 74, 67, 68, 93],
                          78 => [71, 73, 74, 67, 68, 83, 93],
                          8  => [69, 70, 83, 93],
                          11 => [91, 90, 66, 63, 64, 65, 83],
                          53 => [71, 73, 74, 67, 68],
                          6  => [69, 70, 83, 93],
                          20 => [93, 108, 109],
                          13 => [83, 88],
                          31 => [71, 72, 73, 74, 67, 68, 94],
                          10 => [69, 70],
                          9  => [71, 73, 74, 67, 68, 93],
                          67 => [71, 73, 74, 67, 68, 93],
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
                              echo '<option value ="' . $rptaTTransporte[$i]["idtipo_transporte"] . '">' . $rptaTTransporte[$i]["descripcion"] . '</option>';
                            }
                          }
                        }
                        ?>
                      </select>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">N° Contenedor: *</label>
                      <input type="text" class="form-control uppercase ContenedorCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">N° Guías: *</label>
                      <input type="text" class="form-control uppercase GuiasCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-4">
                    <div class="input-group">
                      <label class="input-group-addon">Hora Garita: </label>
                      <input type="text" class="form-control uppercase HGaritaCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-4">
                    <div class="input-group">
                      <label class="input-group-addon">Hora Inicio: *</label>
                      <input type="text" class="form-control uppercase HInicioCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-4">
                    <div class="input-group">
                      <label class="input-group-addon">Hora Fin: *</label>
                      <input type="text" class="form-control uppercase HFinCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-8">
                    <div class="input-group">
                      <label class="input-group-addon">Nombres de Estibas: *</label>
                      <input type="text" class="form-control uppercase NomEstibasCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-4">
                    <div class="input-group">
                      <label class="input-group-addon">Cant. Film (rollos): *</label>
                      <input type="number" class="form-control uppercase CantFilmCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="input-group">
                      <label class="input-group-addon">Cant. Código: *</label>
                      <input type="number" class="form-control uppercase CantCodigoCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-3">
                    <div class="input-group">
                      <label class="input-group-addon">Cant. Fecha: *</label>
                      <input type="number" class="form-control uppercase CantFechaCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-3">
                    <div class="input-group">
                      <label class="input-group-addon">Cant. Pallets: *</label>
                      <input type="number" class="form-control uppercase CantPalletCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-3">
                    <div class="input-group">
                      <label class="input-group-addon">Cant. Bulto: *</label>
                      <input type="number" class="form-control uppercase CantBultoCSupEst" name="" disabled>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-12">
                    <div class="input-group">
                      <label class="input-group-addon">Observaciones: </label>
                      <textarea disabled class="form-control uppercase ObservacionCSupEst"></textarea>
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">Origen: *</label>
                      <input type="text" class="form-control uppercase OrigenCSupEst" name="" disabled="">
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">Cant. Personas: *</label>
                      <input type="number" class="form-control uppercase Cant_PersonaCSupEst" name="" disabled="">
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <label class="input-group-addon">Centro Distribución: *</label>
                      <select class="form-control uppercase CDCSupEst" disabled="">
                        <?php
                        $rptalocalizacion = ControladorLocalizacion::ctrConsultarLocalizacion("", "");
                        for ($i = 0; $i < count($rptalocalizacion); $i++) {
                          if ($rptalocalizacion[$i]["estado"] == 1) {
                            echo '<option value="' . $rptalocalizacion[$i]["idlocalizacion"] . '">' . $rptalocalizacion[$i]["nom_localizacion"] . '</option>';
                          }
                        }
                        ?>

                      </select>
                      <!-- <input type="number" class=" ConEstCant_Persona" name=""> -->
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <!-- <button type="button" class="btn btn-warning btnEditarConfSupEst">Editar</button> -->
          <!-- <button type="button" class="btn btn-primary btnConfirmarSupervisorEst">Confirmar</button> -->
        </div>
      </div>
    </div>
  </div>
</div>