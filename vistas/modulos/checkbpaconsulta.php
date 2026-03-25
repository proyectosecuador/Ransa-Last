<!--=========================================
LISTADO DE CHECK LIST DE BPA       =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>LISTADO DE CHECK LIST DE ALMACÉN </h3>
      </div>
    </div>
    <div class="title_right col-xs-6">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="pull-right">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".modalValorizacion" >Tabla de Valorización</button>
        </div>
      </div>
    </div>
    <div class="col-xs-6">
      <div class="col-md-5 col-sm-5 col-xs-12 pull-left">
        <div class="pull-left">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".modalData">Descargar Data</button>            
            
        </div>
      </div>
    </div>            
  </div>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="x_panel">
  <div class="x_content">
      <div class="table-responsive">
       <table id="Tablacheckbpa" class="table table-striped table-bordered dt-responsive nowrap">
          <thead>
            <tr>
              <th>#</th>
              <th>Fecha</th>
              <th>Cliente</th>
              <th>Evaluador</th>
              <th>Observaciones</th>
              <th>Porc. Global</th>
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
=            MODAL DE TABLA DE VALORIZACIÓN            =
=====================================================-->
    <div class="modal fade modalValorizacion" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tabla de Valorización Check List</h4>
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
                    <div class="col-sm-12 col-xs-12 text-center">
                      <div class="cabeceratabla">
                        <p align="center" class="text-center"><b><span> CRITERIOS DE CALIFICACIÓN</span> </b></p>
                      </div>
                    </div>
                    <div class="col-sm-4 col-xs-12 text-center numerosvalorizacion izquierdo">
                      <div class="dentroizquierdo">
                        CUMPLE (2)
                      </div>
                    </div>
                    <div class="col-xs-12 text-center tvalorizacionpeque">
                      <div class="dentroizquierdo">
                       El items evaluado se cumple en su totalidad. No se evidencia incumplimiento alguno (0 hallazgos)
                      </div>
                    </div>
                    <div class="col-sm-4 col-xs-12 text-center numerosvalorizacion medio">
                      <div class="dentromedio">
                        CUMPLE PARCIALMENTE (1)
                      </div>
                    </div>
                    <div class="col-xs-12 text-center tvalorizacionpeque">
                      <div class="dentromedio">
                       El items evaluado se cumple de forma parcial y se evidencia un bajo número de incumplimientos (1-3 hallazgos)
                      </div>
                    </div> 
                    <div class="col-sm-4 col-xs-12 text-center numerosvalorizacion derecho">
                      <div class="dentroderecho">
                        NO CUMPLE (0)
                      </div>
                    </div>
                    <div class="col-xs-12 text-center tvalorizacionpeque">
                      <div class="dentroderecho">
                        El items evaluado se cumple de forma parcial y se evidencia un número significativo de incumplimientos (más de 4 hallazgos)
                      </div>
                    </div>                    
                    <div class="col-sm-4 text-center izquierdo tvalorizaciongrande">
                      <div class="dentroizquierdo">
                       El items evaluado se cumple en su totalidad. No se evidencia incumplimiento alguno (0 hallazgos)
                      </div>
                    </div>
                    <div class="col-sm-4 text-center medio tvalorizaciongrande">
                      <div class="dentromedio">
                       El items evaluado se cumple de forma parcial y se evidencia un bajo número de incumplimientos (1-3 hallazgos)
                      </div>
                    </div>                    
                    <div class="col-sm-4 text-center derecho tvalorizaciongrande" >
                      <div class="dentroderecho">
                        El items evaluado se cumple de forma parcial y se evidencia un número significativo de incumplimientos (más de 4 hallazgos)
                      </div>
                    </div>
                    <div class="col-xs-12" style="height: 35pt;">
                      
                    </div>
                    <div class="col-sm-12 col-xs-12 text-center">
                      <div class="cabeceratabla">
                        <p align="center" class="text-center"><b><span> CALIFICACIÓN</span> </b></p>
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 text-center izquierdo">
                      <div class="dentroizquierdo">
                        Requiere mejora <= 74 %
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 text-center medio">
                      <div class="dentromedio">
                        Regular 75 - 84 %
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 text-center medio" >
                      <div class="dentromedio "style="border-left: solid black 1.0pt;">
                       Bueno 85 - 90 %
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 text-center derecho">
                      <div class="dentroderecho">
                       Excelente >= 91 %
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
          <!--<button type="button" class="btn btn-primary guardarEquipoNuevo">Registrar</button>-->
        </div>
      </div>
    </div>
</div>
</div>






<!--====================================================
=            MODAL DE FILTRO DE DESCARGA            =
=====================================================-->
    <div class="modal fade modalData" role="dialog">
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
                    <form action="bpa/download_data.php" method="POST">
                    <div class="col-xs-12 form-group has-feedback">
                      <select selected name="anioDesc" class="form-control has-feedback-left">
                        <option value="">Ninguno</option>
                        <?php
                        /*=====================================================================================
                        =            CONSULTAMOS LOS AÑOS DISPONIBLES DE CHECK LIST BPA REALIZADOS            =
                        =====================================================================================*/
                          $rptacheck = ControladorCheckListBpa::ctrConsultarCheckListBpa("","anio");
                          if ($rptacheck) {
                            for ($i=0; $i <count($rptacheck) ; $i++) { 
                              // $anio = date('Y', strtotime($rptacheck[$i]["fecha_reg"]));
                              // if (!isset($arrayanio[$anio])) {
                                // $arrayanio[$anio] = 1;
                               echo '<option value="'.$rptacheck[$i]["anio"].'">'.$rptacheck[$i]["anio"].'</option>'; 
                              // }    
                            }
                          }
                        ?>
                        
                      </select>
                      <!-- <input type="text" class="" id="" name="anyo" placeholder="Año"> -->
                      <span class="fas fa-calendar-alt form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-12 form-group has-feedback">
                      <select name="mesesIng" class="form-control has-feedback-left">
                        <option selected value="">Ninguno</option>
                        <?php
                        /*=====================================================================================
                        =            CONSULTAMOS LOS MESES DISPONIBLES DE CHECK LIST BPA REALIZADOS            =
                        =====================================================================================*/
                        /*****ubicacion de Zona Horaria*****/
      date_default_timezone_set('America/Guayaquil');
      setlocale(LC_ALL, "spanish");
                          $rptacheck = ControladorCheckListBpa::ctrConsultarCheckListBpa("","mes");
                          if ($rptacheck) {
                            for ($i=0; $i <count($rptacheck) ; $i++) { 
                              // $mesletra = strtoupper(strftime("%B",strtotime($rptacheck[$i]["fecha_reg"])));
                              // $mesnum = date('m', strtotime($rptacheck[$i]["fecha_reg"]));
                              // if (!isset($arrayanio[$mesletra])) {
                                // $arrayanio[$mesletra] =1;
                               echo '<option value="'.$rptacheck[$i]["mes_num"].'">'.$rptacheck[$i]["mes"].'</option>'; 
                              // }                         
                            }
                          }
                        ?>
                        
                      </select>
                      <!-- <input type="text" class="" id="" name="anyo" placeholder="Año"> -->
                      <span class="fas fa-calendar-alt form-control-feedback left" aria-hidden="true"></span>
                    </div>
                    <div class="col-xs-12 form-group has-feedback">
                      <select name="clientesIng" class="form-control has-feedback-left">
                        <option selected value="">Ninguno</option>
                        <?php
                        /*=====================================================================================
                        =            CONSULTAMOS LOS CLIENTES DISPONIBLES DE CHECK LIST BPA REALIZADOS            =
                        =====================================================================================*/
                          $rptacheck = ControladorCheckListBpa::ctrConsultarCheckListBpa("","clientes");
                          if ($rptacheck) {
                            for ($i=0; $i <count($rptacheck) ; $i++) {
                              // if ($rptacheck[$i]["idcliente"] != null) {
                                // $rptacliente = ControladorClientes::ctrmostrarClientes("idcliente",$rptacheck[$i]["idcliente"]);
                                // if ($rptacliente) {
                                  // if (!isset($arrayanio[$rptacliente["idcliente"]])) {
                                    // $arrayanio[$rptacliente["idcliente"]] = 1;
                                   echo '<option value="'.$rptacheck[$i]["idcliente"].'">'.$rptacheck[$i]["razonsocial"].'</option>'; 
                                  // }
                                  
                                // }
                              // }
                            }
                          }
                        ?>
                        
                      </select>
                      <span class="fa fa-group form-control-feedback left" aria-hidden="true"></span>
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
          <input type="submit" class="btn btn-primary DescargarData" name="" value="Descargar">
        </form>
        </div>
      </div>
    </div>
</div>
</div>