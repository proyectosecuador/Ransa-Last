<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="">
    <div class="title_left">
      <h3>Programación de Transporte</h3>
    </div>
  </div>
</div>
</div>

<div class="clearfix"></div>

<div class="">
  <div class="">
    <div class="x_panel">

      <div class="x_titulo">
        <h2 id="cliente">Datos de Programación</h2><span>La siguiente programación que se realice, pasará por el proceso de asignación de cuadrilla en caso de solicitarlo<br>Las columnas con <strong>(*)</strong> son campos obligatorios.</span>
        <!-- <div class="archPlantilla"></div> -->
        <div class="clearfix"></div>
      </div>
      <div class="x_content">
        <div class="float left">
          <button class="btn btn-success btnGuardarProg">Enviar</button>
        </div>
        <div class="float pull-right">
          <label class="btn btn-group-sm ">
            <form action="<?php echo $url; ?>archivos/plantillas/PlantillaIngresoVehiculos.xlsx">
              <input type="submit" name="" class="bg-primary btn-sm " value="Descargar Plantilla">
            </form>
            <!-- <span class="fa fa-download"></span><span> Descargar Plantilla</span> -->
          </label>
          <label class="btn btn-default">
            <span class="fa fa-upload"></span><span> Importar Datos</span>
            <input type="file" id="cargarPlantilla" name="cargarPlantilla">
          </label>
          <button type="button" class="btn btn-info" id="btnCargarExcelNuevo">
            <span class="fa-solid fa-file-excel"></span><span> Cargar Excel</span>
          </button>
          <input type="file" id="cargarExcelNuevo" name="cargarExcelNuevo" style="display:none;">

        </div>
        <div class="col-xs-12" align="center">
          <div class="col-md-4 input-group">
            <label class="input-group-addon">Escoger el Almacén:</label>
            <select id="idlocalizacion" class="form-control">
              <?php
              $rptaLocalizacion = ControladorLocalizacion::ctrConsultarLocalizacion($_SESSION['ciudad'], "idciudad");
              for ($i = 0; $i < count($rptaLocalizacion); $i++) {
                if ($rptaLocalizacion[$i]["estado"] == 1) {
                  echo '<option value="' . $rptaLocalizacion[$i]["idlocalizacion"] . '">' . $rptaLocalizacion[$i]["nom_localizacion"] . '</option>';
                }
              }


              ?>
            </select>
          </div>
        </div>
        <div class="table-responsive col-md-12">

          <table id="Programacion" class="table table-striped table-bordered nowrap">

            <thead>

              <tr>

                <th>Fecha / Hora *</th>

                <th>Cliente *</th>

                <th>Movimiento * </th>

                <th>N° Guías</th>

                <th>Conductor </th>

                <th>Placa </th>

                <th>Tipo de Carga </th>

                <th>Comentarios</th>

                <th>Cuadrilla</th>

                <th>Accion</th>

              </tr>

            </thead>

            <tbody>
              <tr>

                <td><input readonly type="text" name="" style="width: 175px;" class="form-control fechaprog"></td>

                <td>
                  <select class="form-control clienteprog" id="clienteprog" style="width: 250px;">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <?php
                    $rptaCliente = ControladorClientes::ctrmostrarClientes("", "");
                    $listclientes = array_column($rptaCliente, 'razonsocial', 'idcliente');
                    asort($listclientes);
                    foreach ($listclientes as $key => $value) {
                      echo '<option value="' . $key . '">' . $key . ".- " . $value . '</option>';
                    }
                    ?>

                  </select>
                </td>
                <td>
                  <select class="form-control rmovimiento" id="rmovimiento" style="width: 200px;">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <?php
                    $rptaactividad = ControladorActividadE::ctrConsultarActividadE("", "");
                    for ($i = 0; $i < count($rptaactividad); $i++) {
                      if ($rptaactividad[$i]["estado"] == 1) {
                        echo '<option value="' . $rptaactividad[$i]["idactividad_estiba"] . '">' . $rptaactividad[$i]["idactividad_estiba"] . ".- " . $rptaactividad[$i]["descripcion"] . '</option>';
                      }
                    }

                    ?>
                  </select>
                </td>
                <td>
                  <input type="text" name="" class="form-control pronguias" id="pronguias" style="width: 125px;">
                </td>
                <td>
                  <input type="text" name="" class="form-control conductor" id="conductor" style="width: 200px;">
                </td>
                <td>
                  <input type="text" name="" class="form-control placa" id="placa" style="width: 125px;">
                </td>

                <td>
                  <select class="form-control tcarga" id="tcarga" style="width: 150px;">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <?php
                    $rptaTCarga = ControladorTCarga::ctrConsultarTCarga("", "");
                    for ($i = 0; $i < count($rptaTCarga); $i++) {
                      if ($rptaTCarga[$i]["estado"] == 1) {
                        echo '<option value="' . $rptaTCarga[$i]["idtipo_carga"] . '">' . $rptaTCarga[$i]["idtipo_carga"] . ".- " . $rptaTCarga[$i]["descripcion"] . '</option>';
                      }
                    }
                    ?>
                  </select>
                </td>

                <td><textarea class="form-control comentarioprog" id="comentarioprog" style="width: 200px;"></textarea></td>

                <td>
                  <div align="center"><input type="checkbox" class="icheckSolicEstiba" name=""> </div>
                </td>

                <td><span class="btn anadir btn-default" style="font-size: 22px;"><i class="fas fa-plus-circle"></i></span></td>

              </tr>




            </tbody>

          </table>



        </div>
      </div>
    </div>
  </div>
  <div id="conte_loading" class="conte_loading">
    <div id="cont_gif">
      <img width="150" src="<?php echo $url . 'vistas/img/plantilla/loading.gif' ?>">
    </div>
  </div>