<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
    <h3>Productos</h3>
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
            <label  for="from-label">Hora de actualización: <?php  $Hora_actual = mktime(date("h")-5, date("i"), date("s"));
            $fecha_actual = mktime(date("d")-5, date("m"), date("Y"));
             echo date("h:i:s", $Hora_actual).' - '.date("d/m/Y", $fecha_actual) ?></label>
            </div>                 
            </div>   
            
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                   <form method="POST" class="form-horizontal form-label-left input_mask">  
                      <div id="datosProduct" class="table-responsive">
                         <table id="datatableUserClienteS" class="TablaCliente table table-striped table-bordered dt-responsive nowrap">
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
                
                      
<!-- $url = 'https://dplwebapi2.azurewebsites.net/api/lotxlocxid/holcim';
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, [
  'X-API-Key: 41852176-1698-4410-975b-c824775ffc11',
]);
$response = curl_exec($curl);
curl_close($curl);

echo $response; -->


            </div>
            <!-- <script>
              console.log($response);
            </script> -->
        </div>