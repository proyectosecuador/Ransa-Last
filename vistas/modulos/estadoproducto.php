<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
    <h3>Estado de Productos</h3>
  </div>
      <div class="title_right col-xs-12">
    <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
    <div class="pull-right">
          <button id="selecCliente" type="button" class="btn btn-success btn-sm">Selecciona Cliente</button>
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
                 
                  <div class="x_titulo">
                    <h2 id="cliente">Listado de Productos</h2>
                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   <form method="POST" class="form-horizontal form-label-left input_mask">
                    <input type="hidden" id="codigo" name="codigo">
                      <input type="hidden" name="consultidcliente" id="idcliente">
                      <div id="datosProduct" class="table-responsive">
                         <table id="datatableUserClienteS" width="100%" class="datatableUserCliente table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                              <tr>
                                <th>#</th>
                                <th>Código</th>
                                <th>Estado Image</th>
                                <th>Tipo Ubicación</th>
                                <th>Familia</th>
                                <th>Grupo</th>
                                <th>Descripción</th>
                                <th>Usuario</th>
                                <th>Estado</th>
                                <th>Visualizar</th>
                                <th>Acciones</th>
                              </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                        
                      </div>
                    </form>
<!--============================================
=            MODAL EDITAR PRODUCTOS            =
=============================================-->
    <div class="modal fade" id="modalEditarProducto" role="dialog">
      <div class="modal-dialog">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Productos</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div id="inputEditar" class="form-group row">
              <div class="col-xs-12">
                <!--=============================
                =            USUARIO            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Ingresado: </span> 
                  <input type="text" class="form-control input-lg validarProducto usuarioIngreso" readonly>
                  <input type="hidden" class="idUsuarioIngreso">
                </div>
              </div>
              <div class="col-xs-12">
                <!--=============================
                =            USUARIO            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Modificado: </span> 
                  <input type="text" class="form-control input-lg validarProducto usuarioModificado" readonly value="<?php echo $_SESSION['nombre']." ".$_SESSION['apellido'] ?>">
                  <input type="hidden" class="idUsuariomodificador" value="<?php echo $_SESSION["id"] ?>">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
              <!--============================
              =            CODIGO            =
              =============================-->
                <div class="input-group">
                  <span class="input-group-addon">Código: </span> 
                  <input type="text" class="form-control input-lg validarProducto codigoProducto" >
                  <input type="hidden" class="idProducto">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--====================================
                =            TIPO UBICACION            =
                =====================================-->
                <div class="input-group">
                  <span class="input-group-addon">Tipo Ubicación: </span> 
                  <input type="text" class="form-control input-lg validarProducto tubicacionProducto" >
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            FAMILIA            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Familia: </span> 
                  <input type="text" class="form-control input-lg validarProducto familiaProducto" >
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <!--=============================
                =            GRUPO            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Grupo: </span> 
                  <input type="text" class="form-control input-lg validarProducto grupoProducto" >
                </div>
              </div>
              <div class="col-xs-12">
                <!--=============================
                =            DESCRIPCION            =
                ==============================-->
                <div class="input-group">
                  <span class="input-group-addon">Descripción: </span> 
                  <textarea type="text" maxlength="320" rows="3" class="form-control input-lg descripcionProducto" placeholder="Ingresar descripción producto"></textarea>
                </div>
              </div>
              <?php
              /*===========================================
              =            DESCRIPCION TECNICA            =
              ===========================================*/
                $cuentas = json_decode($_SESSION["cuentas"],true);
                // var_dump($cuentas);
                for ($i=0; $i < count($cuentas) ; $i++) {
                  if (in_array("NETAFIN ECUADOR S.A.", $cuentas[$i])) {
                    echo '<div class="col-xs-12">
                            <div class="input-group">
                              <span class="input-group-addon">Descripción Técnica: </span> 
                              <textarea type="text" maxlength="320" rows="3" class="form-control input-lg descripcionTecnica" placeholder="Ingresar descripción técnica del producto"></textarea>
                            </div>
                          </div>';
                  }
                }
              ?>
              <!--===================================================
              =            IMAGEN PRINCIPAL DEL PRODUCTO            =
              ====================================================-->
              <div class="col-xs-12" style="border-bottom: 2px solid #BDBDBD">
                  <div class="input-group" id="btnCargar">
                    <span class="input-group-addon">
                      Selecciona Imagen Principal:
                    </span>
                    <label class="form-control"> </label>
                    <div class="input-group-btn">
                      <label class="btn btn-default">
                        <span class="fa fa-upload icoCargar"></span><span id="textSubir">Subir Imágen</span><input type="file" id="archiImg" name="archiImg">
                      </label>  
                    </div>
                  </div>
                  <input type="hidden" class="antiguaFotoPortada">
                  <p class="help-block">Peso máximo de la foto 2MB</p>
                  <div class="ImgPrincipal">
                    <!--<div class="col-md-5 text-center">
                      <div class="thumbnail text-center">
                        <img class="imagenesRestantes" src="archivos/Catalogo/1510/5dcb22f8e645a.jpg" style="width:100%;">
                      </div>
                    </div>-->
                  </div>
              </div>
              <!--====================================================
              =            IMAGEN MULTIMEDIA DEL PRODUCTO            =
              =====================================================-->
              <div class="col-md-12">
                <p class="help-blocks">Se puede subir máximo hasta 3 Imagenes </p>
                <div class="ImgMultimedia ">


              </div>
              <div class="col-xs-12">
                <div class=" dropzones multimediaFisica needsclick dz-clickable">

                  <div class="dz-message needsclick">
                  
                    Arrastrar o dar click para subir imagenes.

                  </div>
                </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!--======================================================
        =            FOOTER DEL MODAL EDITAR PRODUCTO            =
        =======================================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary guardarCambiosProducto">Guardar cambios</button>
        </div>
      </div>
    </div>



                  </div>
                </div>
            </div>
        </div>