<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="">
    <div class="title_left">
    <h3>Proveedores de Estibas</h3>
  </div>
  </div>
  </div>
</div>

<div class="clearfix"></div>

            <div class="">
              <div class="">
                <div class="x_panel">
                 
                  <div class="x_titulo">
                    <h2>Listado de Proveedores</h2>                    
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div class="col-md-1">
                      <button class="btn btn-success" data-toggle="modal" data-target=".modalRegistroProvEstibas">Registar</button>
                    </div>
      <div class="table-responsive col-md-12">

       <table id="TablaProvEstibas" class="table table-striped table-bordered dt-responsive">

          <thead>

            <tr>

              <th>Proveedor</th>

              <th>Accion</th>              

            </tr>

          </thead>

          <tbody>

          </tbody>

      </table>                      

        

      </div>
                </div>
            </div>
     <div id="conte_loading" class="conte_loading">
        <div id="cont_gif" >
          <img src="<?php echo $url.'vistas/img/plantilla/Ripple-1s-200px.gif'?>">
        </div>
      </div>              
        </div>
<!--====================================================================
=            SECCION PARA REGISTRAR EL PROVEEDOR DE ESTIBAS            =
=====================================================================-->
    <div class="modal fade modalRegistroProvEstibas" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registro de Proveedor Estibas</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
              <div class="row">
                <div class="col-xs-12 col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">RUC: </span> 
                    <input type="text" class="form-control input-lg uppercase RucEstibas">
                  </div>
                </div>
                <div class="col-xs-12 col-md-6">
                  <div class="input-group">
                    <span class="input-group-addon">Contraseña (default): </span> 
                    <input type="text" class="form-control input-lg  ContraEstibas">
                  </div>
                </div>                 
                <div class="col-xs-12 col-md-12">
                  <div class="input-group">
                    <span class="input-group-addon">Correo Electrónico: </span> 
                    <input type="text" class="form-control input-lg  CorreoEstibas">
                  </div>
                </div>               
                <div class="col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon">Nombre Proveedor: </span> 
                    <input type="text" class="form-control input-lg uppercase ProvEstibas">
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
          <button type="button" class="btn btn-primary SaveProvEstibas">Guardar</button>
        </div>
      </div>
    </div>
</div>
</div>
<!--====================================================================
=            SECCION PARA MODIFICAR EL PROVEEDOR DE ESTIBAS            =
=====================================================================-->
<!--====================================================================
=            SECCION PARA MODFICAR EL PROVEEDOR DE ESTIBAS            =
=====================================================================-->
    <div class="modal fade modalEditarProvEstibas" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar de Proveedor Estibas</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
              <div class="row">
                <div class="col-xs-12">
                  <div class="input-group">
                    <span class="input-group-addon">Nombre Proveedor: </span> 
                    <input type="text" class="form-control input-lg uppercase EProvEstibas">
                    <input type="hidden" class="form-control input-lg uppercase EIdProvEstibas">
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
          <button type="button" class="btn btn-primary EditProvEstibas">Guardar</button>
        </div>
      </div>
    </div>
</div>
</div>