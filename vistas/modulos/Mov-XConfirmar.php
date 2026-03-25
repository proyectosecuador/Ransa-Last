<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="">
    <div class="title_left">
      <h3>Listado de Confirmación</h3>
    </div>
  </div>
</div>
</div>

<div class="clearfix"></div>

<div class="">
  <div class="">
    <div class="col-md-6" align="left">
      <button data-toggle="modal" data-target=".modalDataEstibas" class="btn btn-info">Descargar Data</button>
    </div>
    <div class="x_panel">

      <div class="x_titulo">
        <h2>Movimientos pendiente de Confirmar</h2>
        <div class="clearfix"></div>
        <div class="col-md-6 fechaActualizada" align="left">

        </div>

      </div>
      <div class="x_content">
        <div class="table-responsive col-md-12">

          <table id="TablaMovXConfirmar" class=" table table-striped table-bordered">

            <thead>

              <tr>
                <th>Id.</th>
                <th>Fecha Prog.</th>

                <th>Solicitado por.</th>

                <th>Cliente</th>

                <th>Código</th>

                <th>Actividad</th>

                <th>Estibas</th>

                <th>Comentarios</th>

                <th>Acción</th>

              </tr>

            </thead>

            <tbody>

            </tbody>

          </table>



        </div>
      </div>
    </div>
  </div>



  <!--====================================================
=            MODAL PRESENTAR DATOS INGRESADOS POR LA CUADRILLA            =
=====================================================-->
  <div class="modal fade modalConfirmSupervisorEst" role="dialog">
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
                        <label class="input-group-addon">Observaciones Estibas: </label>
                        <textarea disabled class="form-control uppercase ObservacionCSupEst"></textarea>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <div class="input-group">
                        <label class="input-group-addon">Origen: *</label>
                        <input type="text" class="form-control uppercase OrigenCSupEst" name="">
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <div class="input-group">
                        <label class="input-group-addon">Cant. Personas: *</label>
                        <input type="number" class="form-control uppercase Cant_PersonaCSupEst" name="">
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <div class="input-group">
                        <label class="input-group-addon">Centro Distribución: *</label>
                        <select class="form-control uppercase CDCSupEst">
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
                    <div class="col-xs-12 col-md-6">
                      <div class="input-group">
                        <label class="input-group-addon">Observaciones Sup: </label>
                        <textarea disabled class="form-control uppercase ObservacionCSup"></textarea>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                      <div class="input-group">
                        <label class="input-group-addon">Aprobado Por: *</label>
                        <input type="text" class="form-control uppercase AprobadonCSupEst" name="">
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
            <button type="button" class="btn btn-warning btnEditarConfSupEst">Editar</button>
            <button type="button" class="btn btn-primary btnConfirmarSupervisorEst">Confirmar</button>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!--====================================================
=            MODAL DE FILTRO DE DESCARGA            =
=====================================================-->
  <div class="modal fade modalDataEstibas" role="dialog">
    <div class="modal-dialog modal-sm">
      <div class="modal-content">
        <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->

        <div class="modal-header" style="background-color: #4d6a88; color: white;">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">GENERAR FILTRO DE DESCARGA</h4>
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
                    <form action="bpa/Estiba/download_dataEstibas.php" method="POST">
                      <div class="col-xs-12 form-group has-feedback">
                        <input type="text" id="downloadDataEst" name="rangeFecha" class="form-control has-feedback-left" style="padding-right: 20px;">
                        <span class="fas fa-calendar-alt form-control-feedback left" aria-hidden="true"></span>
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
              <input type="submit" class="btn btn-primary DescargarDataEstibas" name="" value="Descargar">
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div id="Form_pdf" style="display: none;">

    </div>