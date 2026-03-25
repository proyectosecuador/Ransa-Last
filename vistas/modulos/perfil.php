  <?php

  ?>
  <div class="page-title">
              <div class="title_left">
                <h3>Información Personal</h3>
              </div>
            </div>
            
            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Perfil</h2>
                   <!-- <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>-->
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-3 col-sm-3 col-xs-12 profile_left">
                      <div class="profile_img">
                        <div id="crop-avatar">

                          <!-- Current avatar -->
                          <?php 
                            if (isset($_SESSION["foto"]) && !empty($_SESSION["foto"])) {
                              echo '<img class="img-responsive avatar-view view_Logo_User" width="140" style="height: 130px;" src="'.$_SESSION["foto"].'" alt="Avatar" title="Change the avatar">';
                              echo '<input type="hidden" id="ImgUserAntiguo" name="" value="'.$_SESSION["foto"].'">';
                            }else{
                              echo '<img class="img-responsive avatar-view view_Logo_User" width="140" style="height: 130px;" src="vistas/img/usuarios/default/user_default.png" alt="Avatar" title="Change the avatar">';
                              echo '<input type="hidden" id="ImgUserAntiguo" name="" value="">';
                            }

                          ?>
                          
                        </div>
                      </div>
                      <h3><?php echo $_SESSION["nombre"]; ?></h3>
                      <input type="hidden" id="idUsuario"value="<?php echo $_SESSION["id"]; ?>">

                      <ul class="list-unstyled user_data">

                        <li>
                          <i class="fa fa-briefcase user-profile-icon"></i> <?php echo $_SESSION["cargo"]; ?>
                        </li>

                        <li class="m-top-xs">
                          <i class="fas fa-external-link-square-alt"></i>
                          <a ><?php echo $_SESSION["email"]; ?></a>
                        </li>
                      </ul>

                      <label><input type="file" name="ImgLogoUser"><a class="btn btn-success"><i class="fa fa-edit m-right-xs"></i>&nbsp;Editar Imágen</a></label>
                      <br />


                    </div>
                    <div class="col-md-9 col-sm-9 col-xs-12" id="formEditar">
                      <div class="x_panel form-horizontal">
                        <div class="form-group">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Nombres: <span class="required"></span>
                          </label>
                          <div class="col-md-9 col-sm-9">
                            <label class="col-md-12 col-sm-12 nombreusuario"><?php echo $_SESSION["nombre"]; ?><span data-toggle="tooltip" title="Ponte en contacto con el administrador para actualizar esta información."  class="fa fa-lock"></span></label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Apellidos: <span class="required"></span>
                          </label>
                          <div class="col-md-9 col-sm-9">
                            <label class="col-md-12 col-sm-12 nombreusuario"><?php echo $_SESSION["apellido"]; ?><span data-toggle="tooltip" title="Ponte en contacto con el administrador para actualizar esta información."  class="fa fa-lock"></span></label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Cargo: <span class="required"></span>
                          </label>
                          <div class="col-md-9 col-sm-9">
                            <label class="col-md-12 col-sm-12 nombreusuario"><?php echo $_SESSION["cargo"]; ?><span data-toggle="tooltip" title="Ponte en contacto con el administrador para actualizar esta información."  class="fa fa-lock"></span></label>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="col-form-label col-md-3 col-sm-3 label-align" for="first-name">Seguridad: <span class="required"></span>
                          </label>
                          <div class="col-md-9 col-sm-9">
                            <button class="btn-xs btn btn-info" data-toggle='modal' data-target='.modalEditarClave'>Cambio de Contraseña</button>
                          </div>
                        </div>
                    <!--============================================
                    =            MODAL EDITAR CONTRASEÑA            =
                    =============================================-->
                  <div class="modal fade modalEditarClave" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">
                          <!--=======================================
                          =            CABECERA DE MODAL            =
                          ========================================-->
                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Cambiar Contraseña</h4>
                        </div>
                          <!--=====================================
                          =            CUERPO DE MODAL            =
                          ======================================-->                        
                        <div class="modal-body">
                            <div class="x-content" style="padding: 15px 15px 0px 0px;">
                              <div id="inputEditarClave" class="form-group row">
                                <div class="form-group">
                                  <label class="col-form-label col-md-12 col-sm-12 label-align" for="first-name">Contraseña Actual: <span class="required"></span>
                                  </label>
                                  <div class="col-md-12 col-sm-12 input_ContraActual">
                                    <input class="col-md-12 col-sm-12 form-control input-sm contraActual"placeholder="Contraseña Actual" type="text" name="">
                                  </div>
                                </div>
                                <div class="form-group">
                                  <label class="col-form-label col-md-12 col-sm-12 label-align" for="first-name">Nueva Contraseña: <span class="required"></span>
                                  </label>
                                  <div class="col-md-12 col-sm-12">
                                    <input class="col-md-12 col-sm-12 form-control input-sm contraNueva" placeholder="Nueva Contraseña" type="text" name="">
                                  </div>
                                </div>
                              </div>
                          </div>                          
                          
                        </div>
                        <!--======================================================
                        =            FOOTER DEL MODAL EDITAR PRODUCTO            =
                        =======================================================-->                        
                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
                          <button type="button" class="btn btn-primary btnCambiarClave">Guardar Cambios</button>
                        </div>

                      </div>
                    </div>
                  </div>                      
                      </div>
                    </div>
                        <div class="form-group">
                          <div class="text-center">
                            <button class="btn btn-group-sm btn-success btn_Guar_User">Guardar Cambios</button>
                          </div>
                        </div>                    
                  </div>
                </div>
              </div>
            </div>