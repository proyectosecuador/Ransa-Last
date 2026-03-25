<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="">
    <div class="title_left">
    <h3>Listado de Programación</h3>
  </div>
  </div>
  </div>
</div>
 
<div class="clearfix"></div>

            <div class="">
              <div class="">
                <div class="x_panel">
                 
                  <div class="x_titulo">
                    <h2>Movimientos Programados</h2>                    
                    <div class="clearfix"></div>
                    <div class="col-md-6 fechaActualizada" align="left">
                    </div>
                  </div>
                  <div class="x_content">
      <div class="table-responsive col-md-12">

       <table id="Mov-CuadrillaAsignada" class="table table-striped table-bordered">

          <thead>
 
            <tr>
              <th>#</th>

              <th>Fecha Prog.</th>

              <th>Cliente</th>

              <th>Comentarios</th>

              <th>Actividad</th>

              <!-- <th>Puerta</th> -->

              <th>Cuadrilla</th>

              <th>Cod. Estiba</th>

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
    <div class="modal fade modalConfirmSupervisor" role="dialog">
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
            <input type="text" class="form-control uppercase ConEstfecha_programada" disabled="" name="" value="">
            <input type="hidden" class="form-control uppercase ConEstidmov" name="">
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Cliente: </label>
            <input type="text" class="form-control uppercase ConEstrazonsocial" disabled="" name="" value="">
            <!-- <input type="hidden" class="form-control uppercase ConEstidrazonsocial" disabled="" name="" value=""> -->
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Actividad: </label>
            <input type="text" class="form-control uppercase ConEstactividad" disabled="" name="" value="">
            <!-- <input type="hidden" class="form-control uppercase ConEstidactividad" disabled="" name="" value=""> -->
          </div>
        </div>  
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Tipo de Transporte: *</label>
            <select class="form-control uppercase ConEstTransporte" disabled name="">
            <option>Seleccionar una opción</option>
            <?php
            /*============================================================
            =            CONSULTAMOS LOS TIPOS DE TRANSPPORTE            =
            ============================================================*/
            $rptaTTransporte = ControladorTTransporte::ctrConsultarTTransporte("","");            
            for ($i=0; $i < count($rptaTTransporte) ; $i++) { 
              if ($rptaTTransporte[$i]["estado"] == 1) {
                echo '<option value ="'.$rptaTTransporte[$i]["idtipo_transporte"].'">'.$rptaTTransporte[$i]["descripcion"].'</option>';
                
              }
            }
            ?>
            </select>
          </div>
        </div>                    
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">N° Contenedor: *</label>
            <input  type="text" class="form-control uppercase ConEstContenedor" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">N° Guías: *</label>
            <input type="text" class="form-control uppercase ConEstGuias" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="input-group">
            <label class="input-group-addon">Hora Garita: </label>
            <input type="text" class="form-control uppercase ConEstHGarita" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="input-group">
            <label class="input-group-addon">Hora Inicio: *</label>
            <input type="text" class="form-control uppercase ConEstHInicio" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="input-group">
            <label class="input-group-addon">Hora Fin: *</label>
            <input type="text" class="form-control uppercase ConEstHFin" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-8">
          <div class="input-group">
            <label class="input-group-addon">Nombres de Estibas: *</label>
            <input type="text" class="form-control uppercase ConEstNomEstibas" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-4">
          <div class="input-group">
            <label class="input-group-addon">Cant. Film (rollos): *</label>
            <input type="number" class="form-control uppercase ConEstCantFilm" name="" disabled>
          </div>
        </div>        
        <div class="col-xs-12 col-sm-6 col-md-3">
          <div class="input-group">
            <label class="input-group-addon">Cant. Código: *</label>
            <input type="number" class="form-control uppercase ConEstCantCodigo" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-3">
          <div class="input-group">
            <label class="input-group-addon">Cant. Fecha: *</label>
            <input type="number" class="form-control uppercase ConEstCantFecha" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-3">
          <div class="input-group">
            <label class="input-group-addon">Cant. Pallets: *</label>
            <input type="number" class="form-control uppercase ConEstCantPallet" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-3">
          <div class="input-group">
            <label class="input-group-addon">Cant. Bulto: *</label>
            <input type="number" class="form-control uppercase ConCantBulto" name="" disabled>
          </div>
        </div>
        <div class="col-xs-12 col-md-12">
          <div class="input-group">
            <label class="input-group-addon">Observaciones: </label>
            <textarea disabled class="form-control uppercase ConEstObservacion"></textarea>
          </div>
        </div>
        <div class="col-xs-12 col-md-12">
          <!-- <legend> -->
            <!-- <fieldset>Ingresar Datos Adicionales</fieldset> -->
            <div class="x_title">
              <h2>Ingresar Datos Adicionales</h2>
              <div class="clearfix"></div>

            <div class="x_content" style="padding-top: 20px;">
              <div class="col-xs-12 col-md-6">
                <div class="input-group">
                  <label class="input-group-addon">Origen: *</label>
                  <input type="text" class="form-control uppercase ConEstOrigen" name="">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="input-group">
                  <label class="input-group-addon">Cant. Persona(s): *</label>
                  <input type="number" class="form-control uppercase ConEstCant_Persona" name="">
                </div>
              </div>
              <!-- <div class="col-xs-12 col-md-6">
                <div class="input-group">
                  <label class="input-group-addon">Centro Distribución: *</label>
                  <select class="form-control uppercase ConEstCD"> -->
                    <?php
                    // $rptalocalizacion = ControladorLocalizacion::ctrConsultarLocalizacion("","");
                    // for ($i=0; $i < count($rptalocalizacion) ; $i++) { 
                    //   if ($rptalocalizacion[$i]["estado"] == 1) {
                    //       echo '<option value="'.$rptalocalizacion[$i]["idlocalizacion"].'">'.$rptalocalizacion[$i]["nom_localizacion"].'</option>';
                    //     }  
                    // }
                    ?>
                    
                  <!-- </select> -->
                  <!-- <input type="number" class=" ConEstCant_Persona" name=""> -->
              <!--   </div>
              </div> -->
              <div class="col-xs-12 col-md-12">
                <div class="input-group">
                  <label class="input-group-addon">Observaciones Aprobador: </label>
                  <textarea class="form-control uppercase ConEstObservacionSup"></textarea>
                </div>
              </div>              
             </div>
            </div>             
          <!-- </legend> -->
          
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
          <button type="button" class="btn btn-warning btnEditarDatEst">Editar</button>
          <button type="button" class="btn btn-primary btnConfirmarSupervisor">Confirmar</button>
        </div>
      </div>
    </div>
</div>
</div>

