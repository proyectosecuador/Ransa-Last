<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
    <h3>Productos Disensa</h3>
  </div>
  </div>
  </div>
</div>

<div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                 
                  <div class="x_title">
                    <h2>Listado de Productos &nbsp; </h2>
            <div class="col-xs-12 col-md-12">
              <form action="bpa/catalogo/download-catalogo.php" method="POST" target="_blank">
                <button class="btn btn-success btn-sm"><i class="fas fa-file-pdf"></i> Descargar Catálogo General</button>
              </form>
              <div>
            <label  for="from-label">Hora de actualización: <?php  $fecha_actual = mktime(date("H")-5, date("i"), date("s"), date("d"), date("m"), date("Y")); echo date("d/m/Y - H:i:s", $fecha_actual)?></label>
            </div>                 
            </div>   
            
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   <form method="POST" class="form-horizontal form-label-left input_mask">  
                      <div id="datosProduct" class="table-responsive">
                         <table id="datatableUserClienteSDisensa" class="TablaClienteS table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                              <tr>
                                <th>Código</th>
                                <th>Tipo Ubicación</th>
                                <th>Familia</th>
                                <th>Grupo</th>
                                <th>Descripción</th>
                                <th>Total Inventario</th> 
                                <th>Visualizar</th>
                                
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
            <!-- <script>
              console.log($response);
            </script> -->
        </div>