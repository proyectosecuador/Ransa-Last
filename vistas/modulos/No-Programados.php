<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="">
    <div class="title_left">
    <h3>Vehiculos Anunciados</h3>
  </div>
  </div>
  </div>
</div>

<div class="clearfix"></div>

            <div class="">
              <div class="">
                <div class="x_panel">
                 
                  <div class="x_titulo">
                    <h2>Listado de Programación</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
      <div class="table-responsive col-md-12">

   <table id="TablaVehiculoNoProg" width="100%" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Fecha Llegada</th>
          <th>Cliente</th>
          <th>Placa</th>
          <th>Chofer</th>
          <th>Puerta</th>
          <th>Guías</th>
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

<!--====================================================
=            MODAL LLENAR DATOS FALTANTES POR PARTE DEL SUPERVISOR            =
=====================================================-->
    <div class="modal fade" id="modalDatosComplete" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Información Complementaria</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
              <div class="row">
                <?php
                /*=========================================================================================================================
                =            EL COORDINADOR O EL ADMINISTRADOR SOLO PUEDEN MODIFCAR EL CLIENTE UNA VEZ SELECCIONADO POR GARITA            =
                =========================================================================================================================*/                
                if ($_SESSION["perfil"] == "COORDINADOR" || $_SESSION['perfil'] == "ADMINISTRADOR") {
                  echo '              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            LISTADO DE CLIENTES            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Cliente: </span> 
                  <select class="form-control" id="">
                      <option value="Seleccionar una opción">Seleccionar una opción</option>';
                      $rptaCliente = ControladorClientes::ctrmostrarClientes("","");
                      for ($i=0; $i < count($rptaCliente) ; $i++) { 
                        if ($rptaCliente[$i]["estado"] == 1) {
                          echo '<option value="'.$rptaCliente[$i]["idcliente"].'">'.$rptaCliente[$i]["idcliente"].".- ".$rptaCliente[$i]["razonsocial"].'</option>';
                        }                    
                      }
                      echo '                    </select>
                </div>
              </div>';                      

                }

                ?> 
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            LISTADO DE ACTIVIDAD            =
                ==============================-->
                <input type="hidden" name="" id="idmovimiento" value="">
                <div class="input-group">
                  <span class="input-group-addon">Movimiento: </span> 
                  <select class="form-control" id="DCmovimiento">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <?php
                    $rptaactividad = ControladorActividadE::ctrConsultarActividadE("","");
                    for ($i=0; $i < count($rptaactividad) ; $i++) { 
                      if ($rptaactividad[$i]["estado"] == 1 && $rptaactividad[$i]["descripcion"] != "X_Hora" && $rptaactividad[$i]["descripcion"] != "REPALETIZADO") {
                        echo '<option value="'.$rptaactividad[$i]["idactividad_estiba"].'">'.$rptaactividad[$i]["idactividad_estiba"].".- ".$rptaactividad[$i]["descripcion"].'</option>';
                      }                    
                    }
                    ?>
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            LISTADO DE TIPO DE CARGA            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Tipo Carga: </span> 
                  <select class="form-control" id="DCtipo_carga">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <?php
                      $rptaTCarga = ControladorTCarga::ctrConsultarTCarga("","");
                      for ($i=0; $i < count($rptaTCarga) ; $i++) { 
                        if ($rptaTCarga[$i]["estado"] == 1) {
                          echo '<option value="'.$rptaTCarga[$i]["idtipo_carga"].'">'.$rptaTCarga[$i]["idtipo_carga"].".- ".$rptaTCarga[$i]["descripcion"].'</option>';
                        }
                      }
                    ?> 
                  </select>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            LISTADO DE TIPO DE CARGA            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Cuadrilla: </span> 
                  <select class="form-control" id="DCsolicitudCuadrilla">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <option value="SI">SI</option>
                    <option value="NO">NO</option>
                  </select>
                </div>
              </div>
              <!-- <div class="col-xs-12 col-md-6"> -->
                <!--=============================
                =            LISTADO DE TIPO DE CARGA            =
                ==============================-->
<!--                 <div class="input-group">
                  <span class="input-group-addon">N° Puerta: </span> 
                  <input type="text" class="form-control" id="numpuerta" name="">
                </div>
              </div>  --> 
              <div class="col-xs-12 col-md-12">
                <!--=============================
                =            COMENTARIOS ADICIONALES SUPERVISOR            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Comentarios: </span> 
                  <textarea id="DCcomentarios" class="form-control"></textarea>
                </div>
              </div>
              </div>

            </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary btGDatoComplete">Guardar</button>
        </div>
      </div>
    </div>
</div>
</div>