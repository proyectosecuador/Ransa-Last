<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES         =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
    <h3>Listado de Inventarios</h3>
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
                    <h2 id="Invcliente">Inventarios del Cliente</h2>
                    <div class="clearfix"></div>
                  </div>

                  <div class="x_content">
                   <form method="POST" class="form-horizontal form-label-left input_mask">
                    <input type="hidden" id="codigo" name="codigo">
                      <input type="hidden" name="consultidcliente" id="idcliente">
                     <div class="table-responsive">
                         <table id="datatableUserRansa" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                              <tr>
                                <th>Id</th>
                                <th>Fecha Inventario</th>
                                <th>Cantidad</th>
                                <th>Estado</th>
                              </tr>
                            </thead>
                            <tbody>


                            </tbody>
                        </table>
                        
                      </div>
                    </form>
                  </div>
                </div>
            </div>
        </div>