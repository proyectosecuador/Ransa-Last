
<div class="page-title">
  <div class="row">
    <div class="title_left">
    <h3>Control de Novedades</h3>
    </div>
  </div>
</div>
<div class="clearfix"></div>

<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="x_panel">
     
      <div class="x_titulo">
        <div class="col-md-12">
          <h2 id="cliente">Listado de Novedades Pendientes</h2>  
        </div>
        <?php
        if ($_SESSION["perfil"] == "ADMINISTRADOR" || $_SESSION["perfil"] == "COORDINADOR" || $_SESSION["perfil"] == "ROOT") {
          /*echo '<div class="col-md-6">
          <button data-toggle="tooltip" title="Descargar Reporte" class="btn btn-success pull-right DescargarNovedades"><i style="font-size: 20px" class="fas fa-file-excel"></i></button>  
        </div>';*/
        }

        ?>
            <div class="col-xs-12 col-md-6">
              <div class="input-group">
                <label class="input-group-addon">Estado Novedad: </label>
                  <select data-column="10" class="form-control filterColumnNovedad input-lg">
                      <option value="">Seleccionar una opción</option>
                  </select>
              </div>
            </div>           


             <div id="noti" class="col-xs-12">
      </div>
        <div class="clearfix"></div>

      </div>
      <div class="x_content">
       <form method="POST" class="form-horizontal form-label-left input_mask">
          <div id="" class="table-responsive">
             <table id="Novedades" width="100%" class="datatableUserCliente table table-striped table-bordered dt-responsive nowrap">
                <thead>
                  <tr>
                    <th>#</th>
                    <th>Equipo</th>
                    <th>Turno</th>
                    <th>Responsable</th>
                    <?php
                      if ($_SESSION["perfil"] == "ADMINISTRADOR" || $_SESSION["perfil"] == "ROOT") {
                        echo "<th>Modo</th>";
                      }
                    ?>
                    <th>Descripción</th>
                  
                    <th>Paralización</th>

                    <?php
                      if ($_SESSION["perfil"] == "ADMINISTRADOR" || $_SESSION["perfil"] == "ROOT") {
                        echo "<th>Dias Paralizado</th>
                        <th>Fecha</th>";
                      }
                      /*if ($_SESSION["perfil"] == "OPERATIVO" || $_SESSION["perfil"] == "COORDINADOR" || $_SESSION["perfil"] == "ROOT" ) {
                        echo "<th>Fecha Tentativa</th>";
                      }*/
                    ?> 
                    <th>Fecha Tentativa</th>
                    <th>Estado</th>
                    <?php
                      if ($_SESSION["perfil"] == "ADMINISTRADOR" || $_SESSION["perfil"] == "ROOT") {
                        echo "<th>Acciones</th>";
                      }
                    ?>                                        
                   
                  </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
            
          </div>
         <div id="conte_loading" class="conte_loading">
            <div id="cont_gif" >
              <img src="<?php echo $url.'vistas/img/plantilla/Ripple-1s-200px.gif'?>">
            </div>
          </div>       
        </form>
      </div>
    </div>
  </div>
</div>
</div>
<!--===========================================
=            REGISTRAR FECHA PROPUESTA DE ARREGLO DE EQUIPO            =
============================================-->
    <div class="modal fade" id="modalFechaPropuesta" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Posible Solución</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div id="inputFechaPropuesta" class="form-group row">
              <div class="col-xs-12" style="height:130px;">
                    <div class="col-xs-12">
                      <div class='input-group date' id='datetimepicker8'>
                          <input type='text' class="form-control date_propuesta" />
                          <span class="input-group-addon">
                              <span class="fa fa-calendar-alt">
                              </span>
                          </span>
                      </div>
                    </div>  
                    <div  class ="col-xs-12">
                      <span>Nota: Fecha donde posiblemente se de solución a la novedad reportada</span>
                    </div> 
                    <input type="hidden" id="idnovedad_fecha"  >       

            </div>
          </div>
        </div>
        <!--======================================================
        =            FOOTER DEL MODAL FECHA PROPUESTA DE TERMINO            =
        =======================================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary guardarFechaPropuesta">Registrar</button>
        </div>
      </div>
    </div>
</div>
</div>