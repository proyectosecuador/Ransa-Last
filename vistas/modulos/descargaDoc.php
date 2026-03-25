<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>Descarga de Documentos </h3>
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
                    <h2>Links de Descargas</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form method="POST" class="form-horizontal form-label-left input_mask">
                    <?php
                      $rpta = ControladorUrlPlataformas::ctrConsultarUrl();
                      //var_dump($rpta);

                      for ($i=0; $i < count($rpta) ; $i++) {
                        $user = json_decode($rpta[$i]["usuarios"]);

                        if ($rpta[$i]["botonestado"] == 1) {
                          /*----------  INICIA EL BOTON DESABILITADO  ----------*/
                          echo '<button type="button" disabled="true" id="'.$rpta[$i]["idurlplataforma"].'" class="btn btn-primary btnestado" data-toggle="modal" data-target=".'.$rpta[$i]["idurlplataforma"].'">'.$rpta[$i]["nombre"].'</button>';
                          echo '<input type="hidden" class="fecha" name="" value="'.$rpta[$i]["fecha"].'">';
                          echo '<input type="hidden" class="botonestado" name="" value="'.$rpta[$i]["botonestado"].'">';
                        }else{
                          /*----------  INICIA EL BOTON HABILITADO  ----------*/
                          echo '<button type="button" id="'.$rpta[$i]["idurlplataforma"].'" class="btn btn-primary btnestado" data-toggle="modal" data-target=".'.$rpta[$i]["idurlplataforma"].'">'.$rpta[$i]["nombre"].'</button>';
                          echo '<input type="hidden" class="fecha" name="" value="'.$rpta[$i]["fecha"].'">';
                          echo '<input type="hidden" class="botonestado" name="" value="'.$rpta[$i]["botonestado"].'">';

                        }
                        /*----------  INICIO MODAL  ----------*/
                        echo '<div class="modal fade '.$rpta[$i]["idurlplataforma"].'" tabindex="-1" role="dialog" aria-hidden="true">
                                <div class="modal-dialog modal-sm">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                                      </button>
                                      <h4 class="modal-title" id="myModalLabel2">Información de Plataforma</h4>
                                    </div>
                                    <div class="modal-body">
                                      <h2>'.$rpta[$i]["nombre"].'</h2>';
                                      $counuser = count($user);
                                      for ($j=0; $j < $counuser ; $j++) { 
                                        echo '<h5>Usuario '.$user[$j]->nombre.'</h5>
                                              <table class="data table table-striped no-margin">
                                                <thead>
                                                <tr>
                                                <th>Usuario</th>
                                                <th>Contraseña</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                <td>'.$user[$j]->usuario.'</td>
                                                <td>'.$user[$j]->clave.'</td>
                                                </tr>
                                                </tbody>
                                                </table>';
                                      }
                                      echo'<h5>Enlace</h5>
                                      <label>URL:</label> <a  class="contenurl" id="'.$rpta[$i]["idurlplataforma"].'" ruta="'.$rpta[$i]["url"].'" href="#">Enlace Aqui</a>
                                      
                                    </div>
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                      
                                    </div>

                                  </div>
                                </div>
                              </div>  ';

                        
                        
                      }
                    ?>

                    </form>
                  </div>
                </div>
            </div>
        </div>