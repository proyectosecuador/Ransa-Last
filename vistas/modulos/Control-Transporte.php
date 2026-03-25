<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>Control de Guías de Transporte</h3>
      </div>
    </div>
  </div>
  </div>
</div>
<div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <?php
                    if ($_SESSION["perfil"] != "OPERATIVO") {
                      echo '<h2><button data-toggle="modal" data-target="#modalRegistrarEquipo" class=" btn btn-group-sm btn-success">Registrar</button></h2>';
                    }
                    ?>

                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="table-responsive">
                     <table id="ListGuia" class="table table-striped table-bordered dt-responsive nowrap table_Equipos">
                        <thead>
                          <tr>
                            <th>#</th>
                            <th>Fecha Emisión</th>
                            <th>Punto de Partida</th>                            
                          </tr>
                        </thead>
                        <tbody>


                        </tbody>
                    </table>                      
                      
                    </div>
</div>
</div>
</div>

<!--===========================================
=            REGISTRO DE UN EQUIPO            =
============================================-->
    <div class="modal fade" id="modalRegistrarEquipo" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registro</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div id="" class="form-group row">
              <div class="col-xs-12">
                <!--=============================
                =            INGRESADO POR            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Ingresado por: </span> 
                  <input type="text" class="form-control input-lg" readonly value="<?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?>">
                  <input type="hidden" class="idUser" value="<?php echo $_SESSION["id"] ?>">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            EQUIPO O ACTIVO NOMBRE            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Equipo: </span> 
                  <input type="text" class="form-control input-lg uppercase EquipooAcivo">
                </div>
              </div>              
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            CIUDAD            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Ciudad: </span>                 
                              <select id="ciudad" name="ciudad" class="form-control input-lg">
                                <option value="Seleccionar una opción">Seleccionar una opción</option>
                                <?php
                                $rptaCiudad = ControladorCiudad::ctrConsultarCiudad("","");

                                for ($i=0; $i < count($rptaCiudad) ; $i++) { 
                                  if ($rptaCiudad[$i]["estado"] == 1) {
                                    echo '<option value="'.$rptaCiudad[$i]["idciudad"].'">'.$rptaCiudad[$i]["desc_ciudad"].'</option>';
                                  }
                                }


                                ?>
                              </select>
                                <span data-toggle="modal" data-target=".insert-Ciudad" class="input-group-addon btnanadir" >
                                  <div data-toggle="tooltip" title="Añadir Ciudad" >
                                 <span  class="glyphicon glyphicon-plus btnanadirarea"></span>
                                 </div>
                                </span>
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            MODELO DEL EQUIPO            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Modelo: </span> 
                  <input type="text" class="form-control input-lg uppercase modeloE">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            TIPO DE EQUIPO            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Tipo Eq. : </span>                 
                            <div class='input-group' style="margin-bottom: 0px;">
                              <select id="t_equipo" name="t_equipo" class="form-control input-lg">
                                <option value="Seleccionar una opción">Seleccionar una opción</option>
                                <?php
                                $rptaTequipo = ControladorTEquipo::ctrConsultarTEquipo("","");

                                for ($i=0; $i < count($rptaTequipo) ; $i++) { 
                                  if ($rptaTequipo[$i]["estado"] == 1) {
                                    echo '<option title="'.$rptaTequipo[$i]["descrip_breve"].'" value="'.$rptaTequipo[$i]["idtipo_equipo"].'">'.$rptaTequipo[$i]["nom_eq"].'</option>';
                                  }
                                }
                                ?>
                              </select>
                                <span data-toggle="modal" data-target=".insert-TEquipo" class="input-group-addon btnanadir " >
                                  <div data-toggle="tooltip" title="Añadir Ciudad" >
                                 <span  class="glyphicon glyphicon-plus btnanadirarea"></span>
                                 </div>
                                </span>
                              
                            </div>
                </div>
              </div>             
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            CODIGO UNICO            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Código: </span> 
                  <input type="text" class="form-control input-lg uppercase codigoE">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            HOROMETRO INICIAL            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">H. Inicial: </span>                 
                  <input type="number" class="form-control input-lg horoinit" name="">
                </div>
              </div>             
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            SERIE            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Serie: </span> 
                  <input type="text" class="form-control input-lg uppercase serieE">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            CENTRO DE COSTO            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">C. Costo : </span>                 
                            <div class='input-group' style="margin-bottom: 0px;">
                              <select id="c_costo" name="c_costo" class="form-control input-lg">
                                <option value="Seleccionar una opción">Seleccionar una opción</option>
                                <?php
                                $rptaCcosto = ControladorCentroCosto::ctrConsultarCentroCosto("","");

                                for ($i=0; $i < count($rptaCcosto) ; $i++) { 
                                  if ($rptaCcosto[$i]["estado"] == 1) {
                                    echo '<option title="'.$rptaCcosto[$i]["descripcion"].'" value="'.$rptaCcosto[$i]["idcentro_costo"].'">'.$rptaCcosto[$i]["nombre_cc"].'</option>';
                                  }
                                }
                                ?>
                              </select>
                                <span data-toggle="modal" data-target=".insert-CCosto" class="input-group-addon btnanadir" >
                                  <div data-toggle="tooltip" title="Añadir Centro de Costo" >
                                 <span  class="glyphicon glyphicon-plus "></span>
                                 </div>
                                </span>
                              
                            </div>
                </div>
              </div>               
              <div class="col-xs-12 col-md-12">
                <!--=============================
                =            LOCALIZACION            =
                ==============================-->
                  <fieldset>
                    <legend>Localización</legend>
                    <div>
                      <p class="text-center">
                        Especificar localización:
                        <input type="radio" class="localizacion" name="gender" id="local" value="local" checked="" required /> Especificar equipo padre:
                        <input type="radio" class="localizacion" id="Epadre" name="gender" value="Epadre" />
                      </p>
                      <!--==================================================
                      =            LOCALIZACION DE EQUIPO LOCAL            =
                      ===================================================-->
                      <div class="msj_localizacion ">
                          <div class="input-group col-md-12">
                            <span class="input-group-addon">Localización. : </span>                 
                                  <div class='' style="margin-bottom: 0px;">
                                      <div class='input-group' style="margin-bottom: 0px;">
                                        <select id="localnormal" class="form-control input-lg">
                                          <option value="Seleccionar una opción">Seleccionar una opción</option>
                                          <?php
                                          $rptaLocalizacion = ControladorLocalizacion::ctrConsultarLocalizacion("","");

                                          for ($i=0; $i < count($rptaLocalizacion) ; $i++) { 
                                            if ($rptaLocalizacion[$i]["estado"] == 1) {
                                              echo '<option value="'.$rptaLocalizacion[$i]["idlocalizacion"].'">'.$rptaLocalizacion[$i]["nom_localizacion"].'</option>';
                                            }
                                          }
                                          ?>
                                        </select>
                                          <span data-toggle="modal" data-target=".insert-Localizacion" class="input-group-addon btnanadir" >
                                            <div data-toggle="tooltip" title="Añadir localización" >
                                           <span  class="glyphicon glyphicon-plus btnanadirlocal"></span>
                                           </div>
                                          </span>
                                        
                                      </div>
                                  </div>
                          </div>
                      </div>
                      <!--===============================================================
                      =            SECCION PARA LOCALIZACION DE EQUIPO PADRE            =
                      ================================================================-->
                      <div class="msj_localizacion1">
                        <div class="col-xs-12">
                          <div class="input-group">
                            <span class="input-group-addon">Equipo padre: </span> 
                              <select id="localEq-padre" class="form-control input-lg chosen-select" tabindex="2">
                                <option value="Seleccionar una opción">Seleccionar una opción</option>
                                <?php
                                $rptaEpadre = ControladorEquipos::ctrConsultarEquipos($_SESSION["ciudad"],"idciudad");;

                                for ($i=0; $i < count($rptaEpadre) ; $i++) { 
                                  if ($rptaEpadre[$i]["estado"] == 1) {
                                    echo '<option idlocalizacion= "'.$rptaEpadre[$i]["idlocalizacion"].'"  value="'.$rptaEpadre[$i]["idequipomc"].'">'.$rptaEpadre[$i]["valor_concatenado"].'</option>';
                                  }
                                }
                                ?>
                              </select>
                          </div>
                        </div>
                        <p class="col-xs-12">Localización: <label><strong id="text_ubicacion"> </strong></label></p>   
                      </div>
                    </div>

                  </fieldset>
              </div>

            </div>
          </div>
        </div>
        <!--======================================================
        =            FOOTER DEL MODAL REGISTRO EQUIPO            =
        =======================================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary guardarEquipoNuevo">Registrar</button>
        </div>
      </div>
    </div>
</div>


<!--==================================================================
=            SECCION PARA ASIGNAR RESPONSABLES DE EQUIPOS            =
===================================================================-->
    <div class="modal fade" id="modalRegistrarEquipo" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Asignación de Equipo</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div id="inputAsignarEquipo" class="form-group row">
                    <!-- Smart Wizard -->
                    <p>Selecciona el turno que deseas asignar y llene la información solicitada.<button class="pull-right btn btn-default btn_tablaAsignacion">Tabla</button></p>
                    <div id="wizardTurnos" class="form_wizard wizard_horizontal" style="margin-top: 20px;">
                      <ul class="wizard_steps">
                        <li><a href="#turno-1">Turno 1<br /><small>8:30 - 17:30</small></a></li>
                        <li><a href="#turno-2">Turno 2<br /><small>19:00 - 2:00</small></a></li>
                        <li><a href="#turno-3">Turno 3<br /><small>12:00 - 7:00</small></a></li>
                      </ul>
                      <input type="hidden" class="form-control input-lg AidequipoE">
              <div>
              <div id="turno-1">
              <div class="conteregistro1">
                <div class="col-xs-12 col-md-12">
                <!--=============================
                =            INGRESADO POR            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Asignado por: </span> 
                  <input type="text" class="form-control input-lg" readonly value="<?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?>">
                  <input type="hidden" class="EidUser1" value="<?php echo $_SESSION["id"] ?>">
                </div>
              </div>
              <div class="col-xs-12">
              <!--============================
              =            SUPERVISOR RESPONSABLE        =
              =============================-->
                <div class="input-group">
                  <span class="input-group-addon">Supervisor: </span> 
                  <select id="Asupervisor1" class="form-control input-lg">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <?php
                      $rpta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");

                      if (isset($rpta)) {
                        for ($i=0; $i < count($rpta) ; $i++) { 
                          if (!strpos($rpta[$i]["cargo"], 'Supervisor') && $_SESSION["ciudad"] == $rpta[$i]["idciudad"]) {
                            echo '<option value="'.$rpta[$i]["id"].'">'. $rpta[$i]["primernombre"]." ".$rpta[$i]["primerapellido"].'</option>';
                          }
                          
                        }
                      }

                    ?>
                  </select>
                </div>
              </div>            
              <div class="col-xs-12 col-sm-12 col-md-8">
                <!--====================================
                =            RESPONSABLES             =
                =====================================-->
                <div class="input-group">
                  <span class="input-group-addon">Responsable: </span> 
                  <input type="text" class="form-control input-lg Aresponsable1" placeholder="Operario Responsable">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4">
                <!--====================================
                =            LLAVE             =
                =====================================-->
                <div class="input-group">
                  <span class="input-group-addon">Llave: </span> 
                  <input type="number" class="form-control input-lg Allave1">
                </div>
              </div>
              </div>   

            </div>
              <div id="turno-2">
              <div class="conteregistro2">
              <div class="col-xs-12 col-md-12">
                <!--=============================
                =            INGRESADO POR            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Asignado por: </span> 
                  <input type="text" class="form-control input-lg" readonly value="<?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?>">
                  <input type="hidden" class="EidUser2" value="<?php echo $_SESSION["id"] ?>">
                </div>
              </div>
              <div class="col-xs-12">
              <!--============================
              =            SUPERVISOR RESPONSABLE        =
              =============================-->
                <div class="input-group">
                  <span class="input-group-addon">Supervisor: </span> 
                  <select id="Asupervisor2" class="form-control input-lg">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <?php
                      $rpta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");
                      if (isset($rpta)) {
                        for ($i=0; $i < count($rpta) ; $i++) { 
                          if (!strpos($rpta[$i]["cargo"], 'Supervisor') && $_SESSION["ciudad"] == $rpta[$i]["idciudad"] && $_SESSION["email"] != $rpta[$i]["email"]) {
                            echo '<option value="'.$rpta[$i]["id"].'">'. $rpta[$i]["primernombre"]." ".$rpta[$i]["primerapellido"].'</option>';
                          }
                          
                        }
                      }

                    ?>
                  </select>
                </div>
              </div>            
              <div class="col-xs-12 col-sm-12 col-md-8">
                <!--====================================
                =            RESPONSABLES             =
                =====================================-->
                <div class="input-group">
                  <span class="input-group-addon">Responsable: </span> 
                  <input type="text" class="form-control input-lg Aresponsable2 " placeholder="Operario Responsable">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4">
                <!--====================================
                =            LLAVE             =
                =====================================-->
                <div class="input-group">
                  <span class="input-group-addon">Llave: </span> 
                  <input type="number" class="form-control input-lg Allave2">
                </div>
              </div>
              </div>                

                      </div>
              <div id="turno-3">
              <div class="conteregistro3">
              <div class="col-xs-12 col-md-12">
                <!--=============================
                =            INGRESADO POR            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Asignado por: </span> 
                  <input type="text" class="form-control input-lg" readonly value="<?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?>">
                  <input type="hidden" class="EidUser3" value="<?php echo $_SESSION["id"] ?>">
                </div>
              </div>
              <div class="col-xs-12">
              <!--============================
              =            SUPERVISOR RESPONSABLE        =
              =============================-->
                <div class="input-group">
                  <span class="input-group-addon">Supervisor: </span> 
                  <select id="Asupervisor3" class="form-control input-lg">
                    <option value="Seleccionar una opción">Seleccionar una opción</option>
                    <?php
                      $rpta = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");
                      if (isset($rpta)) {
                        for ($i=0; $i < count($rpta) ; $i++) { 
                          if (!strpos($rpta[$i]["cargo"], 'Supervisor') && $_SESSION["ciudad"] == $rpta[$i]["idciudad"] && $_SESSION["email"] != $rpta[$i]["email"]) {
                            echo '<option value="'.$rpta[$i]["id"].'">'. $rpta[$i]["primernombre"]." ".$rpta[$i]["primerapellido"].'</option>';
                          }
                          
                        }
                      }

                    ?>
                  </select>
                </div>
              </div>            
              <div class="col-xs-12 col-sm-12 col-md-8">
                <!--====================================
                =            RESPONSABLES             =
                =====================================-->
                <div class="input-group">
                  <span class="input-group-addon">Responsable: </span> 
                  <input type="text" class="form-control input-lg Aresponsable3" placeholder="Operario Responsable">
                </div>
              </div>
              <div class="col-xs-12 col-sm-12 col-md-4">
                <!--====================================
                =            LLAVE             =
                =====================================-->
                <div class="input-group">
                  <span class="input-group-addon">Llave: </span> 
                  <input type="number" class="form-control input-lg Allave3">
                </div>
              </div>
              </div>                

                      </div>
                    </div>
                    </div>
                    <!-- End SmartWizard Content -->

            </div>
          </div>
        </div>
        <!--======================================================
        =            FOOTER DEL MODAL EDITAR PRODUCTO            =
        =======================================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary AAsignarEquipo">Guardar Asignación</button>
        </div>
      </div>
    </div>
</div>











