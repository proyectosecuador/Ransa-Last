<body style="background: #ffffff;">
<div class="text-center">
  <?php 
    $url = Ruta::ctrRuta();
   ?>
  <div>
    <a href="inicio" class="site_title"><img style="width: 250px;" src="<?php echo $url?>vistas/img/plantilla/logotipo.png"></a>
  </div>
  <div class="titulos">
    <h1>Listado de Vehiculos</h1>
    <!-- <h4>Ingresa el código notificado por correo </h4>     -->
  </div>
</div>
  </div>
<!--===========================================================
=            TABAL DE VEHICULOS DENTRO DEL ALMACÉN            =
============================================================-->
<div id="CiudadGarita" class=" contenedor">
  <div class="row">
    <?php
    $ciudades = ControladorCiudad::ctrConsultarCiudad("","");
    for ($i=0; $i < count($ciudades) ; $i++) {
       echo '<div class=" col-md-4"> <div class="boxes">
                <a class="botonCiudad" idciudad="'.$ciudades[$i]["idciudad"].'" href="#">'.$ciudades[$i]["desc_ciudad"].'</a> 
              </div></div>';
     } 

    ?>
  </div>
</div>
<!--====================================================================
=            TABLA DE DATOS DE VEHICULOS QUE ESTAN EN RANSA            =
=====================================================================-->
<div id="DatosTablaGarita" class="col-md-12">
  <div>
    <button data-toggle="modal" data-target="#modalVehiculoNoProg" class="btn btn-success">Registrar Nuevo</button>
    <button data-toggle="modal" data-target=".modalDataGarita" class="btn btn-info">Descargar Data</button>
  </div>
  <input type="hidden" id="idciudad" name="" value="<?php echo $valor = isset($_COOKIE['ciudadGarita']) ? $_COOKIE['ciudadGarita'] : null ?>">
<div id="" class="table-responsive">
   <table id="TablaGarita" width="100%" class="table table-striped table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Fecha Programado</th>
          <th>Fecha Llegada</th>
          <th>Chofer</th>
          <th>Placa</th>
          <th>Cliente</th>
          <th>Autorizado</th>
          <th>Puerta</th>
          <th>Guías</th>
          <th>Estado</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>


      </tbody>
  </table>
  
</div>
</div>
<div class="clearfix"></div>
</body>


<!--==========================================================================
=            SECCION MODAL PARA REGISTRO DE VEHICULO NO PRGRAMADO            =
===========================================================================-->
    <div class="modal fade" id="modalVehiculoNoProg" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registro de Vehículo</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Placa: *</label>
            <input type="text" class="form-control uppercase" id="placagaritaR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Chofer: *</label>
            <input type="text" class="form-control uppercase" id="conductorgaritaR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="input-group">
            <label class="input-group-addon">Cédula: *</label>
            <input type="number" class="form-control uppercase" id="cedulagaritaR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="input-group">
            <label class="input-group-addon">Cta. RANSA: *</label>
            <input type="text" class="form-control uppercase" id="ctaRgaritaR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-4">
          <div class="input-group">
            <label class="input-group-addon">Sellos Entrada: </label>
            <input type="text" class="form-control uppercase" id="sellogaritaR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Tip. Vehículo: *</label>
            <input type="text" class="form-control uppercase" id="tipovehiculogaritaR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Cía. Transporte: </label>
            <input type="text" class="form-control uppercase" id="comp_transpgaritaR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Cliente: *</label>
            <select class="form-control uppercase" id="clientevehiculoR">
              <option value="Selecciona">Selecciona el Cliente</option>
              <?php
                $rptaClientes = ControladorClientes::ctrmostrarClientes("","");
                for ($i=0; $i <count($rptaClientes) ; $i++) { 
                  if ($rptaClientes[$i]["estado"] != 0) {
                    echo '<option value="'.$rptaClientes[$i]["idcliente"].'">'.$rptaClientes[$i]["razonsocial"].'</option>';
                  }
                }
              ?>
            </select>
            <!-- <input type="text" class="" name="" value=""> -->
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Autorizador: *</label>
            <select class="form-control uppercase" id="personaAutorizaR">
              <?php
                $rptaAutoriza = ControladorPersAutoriza::ctrConsultarPersAutoriza("","");
                for ($i=0; $i <count($rptaAutoriza) ; $i++) { 
                  if ($rptaAutoriza[$i]["estado"] != 0) {
                    $rptaPerson = ControladorPersonal::ctrConsultarPersonal("idpersonal",$rptaAutoriza[$i]["idpersonal"]);
                    if ($rptaPerson["idciudad"] == $_COOKIE["ciudadGarita"] && $rptaPerson["idlocalizacion"] == $_COOKIE["idlocalizacion"]) {
                      echo '<option value="'.$rptaPerson["idpersonal"].'">'.$rptaPerson["nombres_apellidos"].'</option>';
                    }
                    
                  }
                }
              ?>
            </select>
            <!-- <input type="text" class="" name="" value=""> -->
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Guias: </label>
            <input type="text" class="form-control uppercase" id="guiaentradaR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-6">
          <div class="input-group">
            <label class="input-group-addon">Ayudante: </label>
            <input type="text" class="form-control uppercase" id="ayudanteR" name="" value="">
          </div>
        </div>
        <div class="col-xs-12 col-md-12">
          <div class="input-group">
            <label class="input-group-addon">CI. Ayudante: </label>
            <input type="text" class="form-control uppercase" id="ciayudanteR" name="" value="">
          </div>
        </div>        
        <div class="col-xs-12 col-md-12">
          <div class="input-group">
            <label class="input-group-addon">Observaciones: </label>
            <textarea class="form-control uppercase" id="observIngresoR"></textarea>
            <!-- <input type="text" class=" uppercase" name="" value=""> -->
          </div>
        </div>
       <div class="col-xs-12 col-md-2">
            <button id="btnAsigPuertaR" class="btn btn-primary">Asignar Puerta</button>
       </div>
        <div id="contPuertaR" class="col-xs-12 col-md-10"></div>
          </div>
        </div>
        <div class="msjError">

        </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary RegVehiculo">Registrar</button>
        </div>
      </div>
    </div>
</div>
</div>

<!--=============================================================================
=            MODAL PARA DESCARGAR DATA DE LOS REGISTROS DE VEHICULOS            =
==============================================================================-->
<!--====================================================
=            MODAL DE FILTRO DE DESCARGA            =
=====================================================-->
    <div class="modal fade modalDataGarita" role="dialog">
      <div class="modal-dialog modal-sm">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">GENERAR FILTRO DE DESCARGA</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x-content">
                  <div style="height: auto;">
                    <form action="bpa/Estiba/download_dataEstibas.php" method="POST">
                    <div class="col-xs-12 form-group has-feedback">
                      <input type="text" id="downloadDataEst" name="rangeFechaGarita" class="form-control has-feedback-left" style="padding-right: 20px;">
                      <span class="fas fa-calendar-alt form-control-feedback left" aria-hidden="true"></span>
                    </div>                  
                    
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
          <input type="submit" class="btn btn-primary DescargarDataEstibas" name="" value="Descargar">
        </form>
        </div>
      </div>
    </div>
</div>
</div>
