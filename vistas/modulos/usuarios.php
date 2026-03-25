<!--===================================================
=            BLOQUE PARA REGISTRAR USUARIOS            =
====================================================-->

<div class="page-title">
  <div class="row">
    <div class="title_left">
    <h3>Registro de Usuarios</h3>
  </div>
  <div class="title_right col-xs-12">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
      <div class="pull-right">
          <button type="button" class="btn btn-info btn-sm" data-toggle="modal" data-target="#baseUsuarios">Base de Usuarios</button>
      </div>
      <!-- Modal -->
      <div id="baseUsuarios" class="modal fade" role="dialog">
        <div class="modal-dialog">

          <!-- Modal content-->
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Base de Usuarios</h4>
            </div>
            <div class="modal-body">
                  <div class="x_content">

                    <div class="" role="tabpanel" data-example-id="togglable-tabs">
                      <ul id="myTab1" class="nav nav-tabs bar_tabs right" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content11" id="home-tabb" role="tab" data-toggle="tab" aria-controls="home" aria-expanded="true">Usuarios Clientes</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content22" role="tab" id="profile-tabb" data-toggle="tab" aria-controls="profile" aria-expanded="false">Usuarios Ransa</a>
                        </li>
                      </ul>
                      <div id="myTabContent2" class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="tab_content11" aria-labelledby="home-tab">
                          <table id="datatableUserCliente" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Cliente</th>
                                <th>Acción</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                              $tabla = "usuariosclientes";
                              $item = "";
                              $valor = "";
                              $userclient = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$item,$valor);
                              for ($i=0; $i < count($userclient) ; $i++) { 
                               echo '<tr>
                                      <td scope="row">'.$userclient[$i]["id"].'</td>
                                      <td>'.$userclient[$i]["primernombre"].'</td>
                                      <td>'.$userclient[$i]["primerapellido"].'</td>
                                      <td>'.$userclient[$i]["email"].'</td>
                                      <td>'.$userclient[$i]["razonsocial"].'</td>
                                      <td><a data-toggle="tooltip" title="Editar" href="#" class="fa-hovers"><i class="material-icons">edit</i></a> 
                                      <a data-toggle="tooltip" title="Eliminar" href="#" class="fa-hovers"><i class="material-icons">delete</i></a></td>
                                    </tr>';
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="tab_content22" aria-labelledby="profile-tab">
                          <table id="datatableUserRansa" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Nombres</th>
                                <th>Apellidos</th>
                                <th>Email</th>
                                <th>Perfil</th>
                                <th>Cuentas</th>
                                <th>Acción</th>
                              </tr>
                            </thead>
                            <tbody>
                             <?php
                              $tabla = "usuariosransa";
                              $item = "";
                              $valor = "";
                              $userransa = ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,$item,$valor);
                              for ($i=0; $i < count($userransa) ; $i++) { 
                                $cuentas = json_decode($userransa[$i]["cuentas"],true);
                               echo '<tr>
                                      <td scope="row">'.$userransa[$i]["id"].'</td>
                                      <td>'.$userransa[$i]["primernombre"].'</td>
                                      <td>'.$userransa[$i]["primerapellido"].'</td>
                                      <td>'.$userransa[$i]["email"].'</td>
                                      <td>'.$userransa[$i]["perfil"].'</td>
                                      <td>
                                        <div class="dropdown">
                                          <label class="dropdown-toggle fa-hovers" data-toggle="dropdown"><span class="fa fa-eye"></span></label> <ul class="dropdown-menu"  style="padding:5px;">';
                                            for ($l=0; $l < count($cuentas) ; $l++) { 
                                              echo '<li class="btn-default ">'.$cuentas[$l]["nombre"].'</li>';
                                            } 
                                           echo'</ul></div>   
                                      </td>
                                      <td><a data-toggle="tooltip" title="Editar" href="#" class="fa-hovers"><i class="material-icons">edit</i></a> &nbsp;
                                      <a data-toggle="tooltip" title="Eliminar" href="#" class="fa-hovers"><i class="material-icons">delete</i></a></td>
                                    </tr>';
                              }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer modal-borde ">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>
  </div>
</div>
 <div class="clearfix"></div>
 <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos del Usuario</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-6">
                        <p>Al momento de registrar un usuario considerar los siguientes puntos:<li>El correo debe ser Empresarial.</li><li>Ingresar un nombre y dos apellidos.</li><li>Identificar si el usuario es cliente o personal de la Compañia.</li> </p>    
                      </div>
                    </div>
                    <form method="POST" enctype="multipart/form-data" id="formusuario">
                      <div class="form-horizontal">
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" class="form-control has-feedback-left" id="nombre" name="nombre" placeholder="Nombre">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" name="apellido" class="form-control has-feedback-left" id="apellido" placeholder="Apellidos">
                            <span class="fa fa-user form-control-feedback left" aria-hidden="true"></span>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="email" name="correo" class="form-control has-feedback-left" id="correo" placeholder="Correo Empresarial">
                            <i class="material-icons form-control-feedback left" aria-hidden="true">email</i>
                        </div>  
                        <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="password" name="password" class="form-control has-feedback-left" id="password" placeholder="Contraseña">
                            <i class="material-icons form-control-feedback left" aria-hidden="true">lock</i>
                        </div>
                        <!--=======================================================
                        =            CONSULTAR LOS MODULOS DISPONIBLES            =
                        ========================================================-->
                        <?php
                        $modulos = ControladorModulosPortal::ctrConsultarModulosPortal("","");
                        ?>
                        
                        <!--<div id="selectModulo" class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">-->
                            <select id="seModulo" data-placeholder="Selecciona una opción" name="seModulo[]"  class="form-control has-feedback-left" multiple>
                              <?php
                                for ($i=0; $i < count($modulos) ; $i++) { 
                                  echo'<option value="'.$modulos[$i]['idmodulos_portal'].'">'.$modulos[$i]['nombremodulo'].'</option>';                                  
                                }
                              ?>
                            </select>

                            
                          <!--</div> -->
                          <?php
                          $ciudad = ControladorCiudad::ctrConsultarCiudad("","");
                          ?>            
                        <div id="selecCiudad" class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <select id="seCiudad" name="seCiudad" class="form-control has-feedback-left">
                              <option selected>Seleccionar una opción</option>
                              <?php
                                for ($i=0; $i < count($ciudad) ; $i++) { 
                                  echo '<option value="'.$ciudad[$i]["idciudad"].'">'.$ciudad[$i]["desc_ciudad"].'</option>';
                                }
                              ?>
                            </select>
                            <i class="material-icons form-control-feedback left" aria-hidden="true">assignment</i>
                        </div>                          
                        <div id="selectPerfil" class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                            <select id="sePerfil" name="sePerfil" class="form-control has-feedback-left">
                              <option selected>Seleccionar una opción</option>
                              <option value="ROOT">ROOT</option>
                              <option value="ADMINISTRADOR">ADMINISTRADOR</option>
                              <option value="COORDINADOR">COORDINADOR</option>
                              <option value="OPERATIVO">OPERATIVO</option>
                            </select>
                            <i class="material-icons form-control-feedback left" aria-hidden="true">assignment</i>
                        </div>
                        <div id="inputcargo" class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                            <input type="text" name="cargopersonal" class="form-control has-feedback-left" id="cargopersonal" placeholder="Cargo del Personal">
                            <i class="material-icons form-control-feedback left" aria-hidden="true">work</i>
                        </div>
                        </div>
                        <!--===========================================
                        =            CONSULTA DE LAS AREAS            =
                        ============================================-->
                        <?php
                          $areas = ControladorAreas::ctrConsultarAreas("","");
                        ?>
                        <div id="selectArea" class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                            <select id="seArea" name="seArea" class="form-control has-feedback-left">
                              <option selected>Seleccionar una opción</option>
                              <?php
                                for ($i=0; $i < count($areas) ; $i++) { 
                                  echo'<option value="'.$areas[$i]['idarea'].'">'.$areas[$i]['nombre'].'</option>';                                  
                                }
                              ?>
                            </select>
                            <i class="material-icons form-control-feedback left" aria-hidden="true">assignment</i>
                        </div>                             
                        
                                <?php
                                  $clientes = ControladorClientes::ctrmostrarClientes("","");
                                  
                                ?>
                        <div id="selectCuentaRan" class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
                            <select id="seCuentaRan" name="seCuentaRan[]" multiple="multiple">
                                <?php
                                for ($i=0; $i <count($clientes) ; $i++) { 
                                  echo'<option value="'.$clientes[$i]['idcliente'].'|'.$clientes[$i]['razonsocial'].'">'.$clientes[$i]['razonsocial'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div id="textCuentaRan" class="col-md-2 col-sm-2 col-xs-12 form-group">
                          <label>Seleccionar las cuentas que maneja el personal</label>
                        </div>
                        <div id="userClient">
                          <div  class="col-md-4 col-sm-6 col-xs-12 form-group has-feedback">
                              <select id="seClient" name="seClient" class="form-control has-feedback-left">
                                <option selected>Seleccionar una opción</option>
                                <?php
                                for ($i=0; $i <count($clientes) ; $i++) { 
                                  echo'<option value="'.$clientes[$i]['idcliente'].'">'.$clientes[$i]['razonsocial'].'</option>';
                                }
                              
                                ?>
                              </select>
                              <i class="material-icons form-control-feedback left" aria-hidden="true">supervisor_account</i>
                          </div>
                        <p class="col-md-4 col-sm-6 col-xs-12">*Seleccionar si el Usuario es un cliente. </p>                       
                        </div>
                      <div class="col-md-12 text-center">
                        <button type="button" id="btnGUsuario" class=" btn btn-round btn-success">Guardar Usuario</button>
                      </div>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
              <div id="msj"></div>
