<!--=========================================
ENVIAR DOCUMENTOS A USUARIO POR AREA       =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>Distribución de Documentos </h3>
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
                    <h2>Datos del Documento</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="row">
                      <div class="col-md-6">
                        <p>Al momento de enviar los documentos considerar los siguientes puntos:<li>Verificar que el área esta registrada.</li><li>Verificar que el proveedor está registrado.</li><li>Luego de haber ingresado todos los documentos seleccionar a quién será enviado.</li></p>    
                      </div>
                    </div>                    
                    <form method="POST" class="form-horizontal form-label-left input_mask"> 
                  <div class="col-md-12 form-group">
                        <label class="control-labels col-md-1">Tipo Doc:</label>
                        <div class=" col-xs-12 col-md-3">
                            <select id="tdocumento" name="tdocumento" class="form-control">
                              <option selected>Seleccionar una opción</option>
                              <option value="FACTURA">FACTURA</option>
                              <option value="NV">NOTA DE VENTA</option>
                              <option value="ND">NOTA DE DÉBITO</option>
                              <option value="NC">NOTA DE CRÉDITO</option>
                            </select>
                        </div>
                        <label class="control-labels col-md-1">C. Costo:</label>
                        <div class=" col-xs-12 col-md-3">
                            <select id="cc" name="cc" class="form-control">
                              <option selected>Seleccionar una opción</option>
                              <option value="GYE">GYE</option>
                              <option value="UIO">UIO</option>
                            </select>
                        </div>                        
                        <label class="control-labels col-md-1">Area:</label>
                        <div class='col-md-3'>
                            <div class='input-group date' id=''>
                              <select id="area" name="area" class="form-control">
                                <option selected>Seleccionar una opción</option>
                                <?php
                                $areas = ControladorAreas::ctrConsultarAreas("","");
                                for ($i=0; $i < count($areas) ; $i++) { 
                                  if ($areas[$i]["estado"] == 1) {
                                    echo'<option value="'.$areas[$i]["idarea"].'">'.$areas[$i]["nombre"].'</option>';  
                                  }
                                }
                                ?>
                              </select>                                    
                              <span data-toggle="modal" data-target=".insert-area"  class="input-group-addon">
                                 <span data-toggle="tooltip" title="Añadir Área" class="glyphicon glyphicon-plus btnanadirarea"></span>
                              </span>
                            </div>
                        </div>
                  </div>
                      <div class="col-md-12">
                      	<label class="control-labels col-md-1">Fecha:</label>
                        <div class='col-sm-5'>
                                <div class='input-group date' id='myDatepicker2'>
                                    <input type='text' id="fechadoc" class="form-control" />
                                    <span class="input-group-addon">
                                       <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                        </div>
                        <label class="control-labels col-md-1">Proveedor:</label>
                        <div class='col-sm-5'>
                            <div class='input-group date' >
                              <input type="text"  name="proveedor" id="proveedor" class="bootstrap-tagsinput-document form-control">
                              <span data-toggle="modal" data-target=".insert-proveedor"  class="input-group-addon">
                                 <span data-toggle="tooltip" title="Añadir Proveedor" class="glyphicon glyphicon-plus"></span>
                              </span>
                            </div>
                        </div>
                      </div>
                      <div class=" form-group">
                        <label class="control-labels col-md-2 ">Número del Documento:</label>
                        <div class="col-md-8 col-sm-8 col-xs-12">
                          <input type="text" class="form-control" id="numdocumento" name="numdocumento" placeholder="Número del Documento">
                        </div>
                        <div class="col-md-2 text-center ">
                          <button type="button" id="btnEnviarDoc" class="btn btn-default btnEnviarDoc"><span class="fa fa-plus-square"></span>  Añadir Documento</button>
                        </div>                         
                      </div>
                     
                      <div class="form-group">
                        <div class="text-center">
                          <button type="button"  class="btn btn-round btn-success btnEnviarDocCorreo">Enviar Documentos</button>
                        </div>
                      </div>
                      <div id="gif"></div>
                    </form>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                                          <div class="form-group">
                        <label class="control-labels col-md-2">Enviar Documento A:</label>
                        <div class="col-md-10 col-sm-10 col-xs-12">
                          <input type="text" class="form-control" id="enviodoc" name="enviodoc" placeholder="A quien enviar el Documento">
                        </div>
                       
                      </div> 
                    <h2>Tabla de Documentos<small>(Documentos que serán entregados a cada área)</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatableUserRansa" class="table table-striped">
                      <thead>
                        <tr>
                          <th>T. Doc</th>
                          <th>Área</th>
                          <th style="width: 99px;">Centro Costo</th>
                          <th>Fecha</th>
                          <th>Proveedor</th>
                          <th>Número</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>

                  </div>
                </div>                
            </div>
        </div>
<!--==============================================
=            MODAL PARA INGRESAR AREA            =
===============================================-->
<div class="modal fade bs-example-modal-sm insert-area" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Registrar Área</h4>
      </div>
      <div class="modal-body">
        <div class="well-sm">
          <form method="POST">
            <div class=" form-group">
              <label class="control-labels col-md-12 ">Nombre:</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="text" class="form-control uppercase" id="nombreArea" name="nombreArea" placeholder="Nueva Área">
              </div>
            </div>          
          </form>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btnGArea">Guardar</button>
      </div>

    </div>
  </div>
</div>
<!--============================================================
=            MODAL PARA INGRESAR UN NUEVO PROVEEDOR            =
=============================================================-->
<div class="modal fade bs-example-modal-sm insert-proveedor" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">

      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
        </button>
        <h4 class="modal-title" id="myModalLabel2">Registrar Proveedor</h4>
      </div>
      <div class="modal-body">
        <div class="well-sm">
          <form method="POST">
            <div class=" form-group">
              <label class="control-labels col-md-12 ">RUC:</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="text" class="form-control" id="ruc" name="ruc" placeholder="RUC">
              </div>
            </div> 
            <div class=" form-group">
              <label class="control-labels col-md-12 ">Nombre:</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="text" class="form-control uppercase" id="nombrepro" name="nombrepro" placeholder="Nombre¨Proveedor">
              </div>
            </div> 
            <div class=" form-group">
              <label class="control-labels col-md-12 ">Correo Electrónico:</label>
              <div class="col-md-12 col-sm-12 col-xs-12">
                <input type="email" class="form-control" id="correopro" name="correopro" placeholder="Correo">
              </div>
            </div>            

          </form>

        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        <button type="button" class="btn btn-primary btnGProveedor">Guardar</button>
      </div>

    </div>
  </div>
</div>

