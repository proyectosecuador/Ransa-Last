<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>Registro de Urls</h3>
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
                    <h2>Datos de Nueva Url <small>(Colocar dirección de la página donde descargará documentos)</small></h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form method="POST" class="form-horizontal form-label-left input_mask">
                      <div class="form-group">
                            <label class="control-labels col-md-3">Nombre de Cliente/Proveedor:</label>
                            <div class="col-xs-12 col-md-9">
                              <input type="text" id="nompaginas" name="nompaginas" class="form-control" placeholder="Nombre para identificar la plataforma">
                            </div>
                      </div>
                      <div class="form-group">
                            <label class="control-labels col-md-3">Url de Plataforma:</label>
                            <div class="col-xs-12 col-md-9">
                              <input type="text" id="urlpaginas" name="urlpaginas" class="form-control" placeholder="Link de Descarga de Documentos">
                            </div>
                      </div>
                      <div class="x_title">
                        <h2>Datos de Usuarios <small>(Registro de Usuarios en la plataforma)</small></h2>
                        <div class="clearfix"></div>
                      </div>
                      <div class="form-group">
                            <label class="control-labels col-md-3">Nombre del Usuario:</label>
                            <div class="col-xs-12 col-md-9">
                              <input type="text" id="nomLink" name="nomLink" class="form-control" placeholder="Identificación del Tipo de Usuario">
                            </div>
                      </div>
                      <div class="form-group">
                            <label class="control-labels col-md-1">Usuario:</label>
                            <div class="col-xs-12 col-md-4">
                              <input type="text" id="userLink" name="userLink" class="form-control" placeholder="Usuario de Plataforma">
                            </div>
                            <label class="control-labels col-md-1">Contraseña:</label>
                            <div class="col-xs-12 col-md-4">
                              <input type="text" id="claveLink" name="claveLink" class="form-control" placeholder="Contraseña de Plataforma">
                            </div>
                            <div class="col-md-2 text-center ">
                              <button type="button" class="btn btn-default btnAnadir"><span class="fa fa-plus-square"></span>  Añadir</button>
                            </div>
                      </div>
                      <div class="form-group">
                        <div class="text-center">
                          <button type="button" id="btnGuardarDoc" class="btn btn-round btn-success">Guardar</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Tabla de Usuarios</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <table id="datatableUserRansa" class="table table-striped">
                      <thead>
                        <tr>
                          <th>#</th>
                          <th>Nombre</th>
                          <th>Usuario</th>
                          <th>Contraseña</th>
                        </tr>
                      </thead>
                      <tbody>
                      </tbody>
                    </table>

                  </div>
                </div>
            </div>
        </div>