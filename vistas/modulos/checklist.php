<!--=========================================
ENVIAR DOCUMENTOS A USUARIO POR AREA       =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>Novedades de Equipos </h3>
      </div>
    </div>
    <div class="title_right col-xs-12">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="pull-right">
          <button id="selecEquipo" type="button" class="btn btn-success btn-sm">Selecciona Equipo</button>
          <input id="sessionciudad" type="hidden" value="<?php echo $_SESSION["ciudad"]; ?>">
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
      <div class="x_title">
        <h2 id="descripEquiSeleccionado">Selecciona el código del equipo</h2>
        <div class="clearfix"></div>
      </div>
      <div class="col-xs-12 col-md-6 asignado">
        <!--=============================
                    =            RESPONSABLE ASIGNADO            =
                    ==============================-->

      </div>
      <div class="col-xs-12 col-md-6 turnocheck">
        <!--=============================
                    =            RESPONSABLE ASIGNADO            =
                    ==============================-->

      </div>
      <div class="x_content">
        <div class="alert alert-info alert-dismissible fade in">
          <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
          <strong>NOTA:</strong> Si el equipo es encontrado en alguna condición insegura o si durante la operación presenta algún daño o error este debe ser registrado, reportado de inmediato al supervisor encargado y comunicado al Coordinador Clientes de Jungheinrich.
        </div>
        <div id="botonesacciones" class="pull-right ">
          <button class="btn btn-default btnNovedad">Reportar Novedad</button>
          <button class="btn btn-default btnCheck">Realizar Check List</button>
        </div>
        <div id="checkListsmartwizard">
          <p style="padding-bottom: 10px;">
            Marca (&#10004;) si no existe novedad, caso contrario registrala.

          </p>

          <ul>
            <li><a href="#equipo">Equipo<br /><small>Inspección visual</small></a></li>
            <li><a href="#bateria">Bateria<br /><small>Inspección visual</small></a></li>
            <li><a href="#carro_bateria">Carro de Baterias<br /><small>Inspección visual</small></a></li>
            <li><a href="#cargador">Cargador<br /><small>Inspección visual</small></a></li>
            <li><a href="#operacional">Operacional<br /><small>Inspección</small></a></li>
            <div align="right" class="checkallitem"><label style="padding-right: 10px;">Todo Correctamente</label><input id="allitem" class="allitem" type="checkbox"></div>
          </ul>

          <div id="contenido_items">
            <div id="equipo" class="col-lg-12">
              <ul class="list-group">
                <li class="list-group-item">COMPROBAR DAÑOS EN CHASIS Y ESTRUCTURA DEL EQUIPO
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok0 "> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR SI LA TRANSMISION PRESENTA FUGAS DE ACEITE
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok1"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR SI LAS RUEDAS PRESENTA DAÑOS O DESGASTE EXCESIVO
                  <div class=" btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok2"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad2"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR SI EXISTE FUGA DE ACEITE HIDRAULICO
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok3"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad3"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR ESTADO DE MANGUERAS Y CAÑERIAS
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok4"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad4"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">REVISAR CILINDROS HIDRAULICOS Y SI EXISTE FUGAS DE ACEITE
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok5"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad5"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR DAÑOS EN TABLERO DE INSTRUMENTOS, SWITCH, PALANCA DE MANDOS
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok6"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad6"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
              </ul>
            </div>
            <div id="bateria" class="">
              <ul>
                <li class="list-group-item">COMPROBAR DAÑOS EN BATERIA, CABLES Y CONECTORES
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok0"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">REVISAR EL NIVEL ADECUADO DE ELECTROLITO (AGUA DE BATERIA)
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok1"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
              </ul>
            </div>
            <div id="carro_bateria" class="">
              <ul>
                <li class="list-group-item">REVISAR ESTADO DE CARRO PORTABATERIAS
                  <div class="btn-group pull-right optionchecklist ">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok0"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">REVISAR SEGURO DE CARRO PORTABATERIAS (FUNCIONA CORRECTAMENTE)
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok1"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
              </ul>
            </div>
            <div id="cargador" class="">
              <ul>
                <li class="list-group-item">REVISION DE ESTRUCTURA
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok0"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR DAÑOS EN CABLES Y CONECTOR
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok1"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">REVISAR FUNCIONAMIENTO (LUCES ENCIENDE AL CARGAR)
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok2"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad2"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
              </ul>
            </div>
            <div id="operacional" class="">
              <ul>
                <li class="list-group-item">COMPROBAR BUEN ENCENDIDO DEL EQUIPO
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok0"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">PROBAR FUNCIONAMIENTO DE BOCINA
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok1"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">REVISAR FUNCIONAMIENTO DE LUCES Y BALIZA
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok2"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad2"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR EL BUEN FUNCIONAMIENTO DE LA DIRECCION
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok3"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad3"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR BUEN FUNCIONAMIENTO DE MARCHA ADELANTE, ATRÁS
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok4"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad4"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR FUNCIONES HIDRAULICAS OPERATIVAS
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok5"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad5"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR FUNCIONAMIENTO DEL SIST. DE FRENOS (PEDAL Y PARQUEO)
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok6"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad6"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR SI EMITE RUIDOS DURANTE LA MARCHA
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok7"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad7"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
                <li class="list-group-item">COMPROBAR DESLIZAMIENTO DEL CARRO PORTABATERIA Y SI ESTE ENCLAVA
                  <div class="btn-group pull-right optionchecklist">
                    <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok8"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                    <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad8"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                  </div>
                </li>
              </ul>
              <!-- COLOCAR EL HOROMETRO -->
              <div>
                <div class="input-group">
                  <span class="input-group-addon">Horometro: </span>
                  <input type="number" class="form-control input-lg horocheck" name="">
                </div>
                
              </div>


            </div>
          </div>

        </div>
        <!--===================================================
                    =            SECCION DE REPORTE DE NOVEDAD            =
                    ====================================================-->
        <div id="registro_novedad">
          <div class="x_title">
            <h2>Registro de Novedades <small>(Colocar la información lo mas detallado posible.)</small></h2>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <form method="POST" enctype="multipart/form-data" class="form-horizontal" onsubmit="return RegistroNovedad()">
              <input type="hidden" id="idequipo" name="idequipo">
              <input type="hidden" id="codigoEquipo" name="codigoEquipo">
              <input type="hidden" id="selectturn" name="selectturn">
              
                <div class="col-xs-10 col-md-12">
                <div class="input-group">
              <span class="input-group-addon">
                      Detalle de la Novedad:
                  </span>
                <select class="form-select form-control uppercase descripcion_novedad" name="descripcion_novedad" required>
                      <option selected disabled value="">Seleccionar la novedad del equipo</option>
                      <option value="BOCINA SIN FUNCIONAMIENTO">BOCINA SIN FUNCIONAMIENTO</option>
                      <option value="RUEDAS DE CARGA EN MAL ESTADO">RUEDAS DE CARGA EN MAL ESTADO</option>
                      <option value="RUEDAS DE APOYO DE MAL ESTADO">RUEDAS DE APOYO DE MAL ESTADO</option>
                      <option value="RUEDA MOTRIZ EN MAL ESTADO">RUEDA MOTRIZ EN MAL ESTADO</option>
                      <option value="FUGA DE ACEITE">FUGA DE ACEITE</option>
                      <option value="EQUIPO DETENIDO">EQUIPO DETENIDO</option>
                      <option value="ASIENTO EN MAL ESTADO">ASIENTO EN MAL ESTADO</option>
                      <option value="ACOLCHADO DE LOS BRAZOS EN MAL ESTADO">ACOLCHADO DE LOS BRAZOS EN MAL ESTADO</option>
                      <option value="SWICTH DAÑADO">SWICTH DAÑADO</option>
                      <option value="LUCES SIN FUNCIONAMIENTO">LUCES SIN FUNCIONAMIENTO</option>
                      <option value="MANTENIMIENTO PREVENTIVO 500 HRS">MANTENIMIENTO PREVENTIVO 500 HRS</option>
                      <option value="MANTENIMIENTO PREVENTIVO 2000 HRS">MANTENIMIENTO PREVENTIVO 2000 HRS</option>
                      <option value="EQUIPO PRESENTA UN ERROR">EQUIPO PRESENTA UN ERROR</option>
                      <option value="EQUIPO GOLPEADO">EQUIPO GOLPEADO</option>
                      <option value="FALLO EN LA DIRECCIÓN">FALLO EN LA DIRECCIÓN</option>
                      <option value="BRAZOS EN MAL ESTADO">BRAZOS EN MAL ESTADO</option>
                      <option value="FALLO EN EL CONECTOR DE LA BATERIA">FALLO EN EL CONECTOR DE LA BATERIA</option>
                      <option value="MONITOR DE CAMARA NO FUNCIONA">MONITOR DE CAMARA NO FUNCIONA</option>
                      <option value="CABLE DE BATERIA DESCUBIERTO">CABLE DE BATERIA DESCUBIERTO</option>
                      <option value="ENTREGA DE EQUIPO">ENTREGA DE EQUIPO</option>
                      <option value="ENTREGA DE BATERIA">ENTREGA DE BATERIA</option>
                      <option value="RAPIDA DESCARGA DE BATERIA">RAPIDA DESCARGA DE BATERIA</option>
                      <option value="SALIDA DE EQUIPO">SALIDA DE EQUIPO</option>
                      <option value="HORQUILLAS DESNIVELADAS">HORQUILLAS DESNIVELADAS</option>
                      <option value="MANTENIMIENTO CARGADOR">MANTENIMIENTO CARGADOR</option>
                      <option value="MANTENIMIENTO BATERIA">MANTENIMIENTO BATERIA</option>
                      <option value="DESPERFECTO EN MANGUERAS">DESPERFECTO EN MANGUERAS</option>
                      <option value="FALLA EN VENTILADOR">FALLA EN VENTILADOR</option>
                      <option value="INSTALCIÓN/CAMBIO DEL EXTINTOR">INSTALCIÓN/CAMBIO DEL EXTINTOR</option>
                      <option value="AMORTIGUADOR DE LANZA EN MAL ESTADO">AMORTIGUADOR DE LANZA EN MAL ESTADO</option>
                      <option value="AMORTIGUADOR DE BASE MAL ESTADO">AMORTIGUADOR DE BASE MAL ESTADO</option>
                      <option value="BATERIA SULFATADA">BATERIA SULFATADA</option>
                      <option value="EQUIPO DESCARGADO">EQUIPO DESCARGADO</option>
                      <option value="FALLA EN MÁSTIL">FALLA EN MÁSTIL</option>
               </select>
                </div>
              </div>
              <div class="input-group">
                  <span class="input-group-addon">Observaciones Adicionales: </span>
                  <input type="text" class="form-control uppercase input-lg observacionesot" name="observacionesot">
              </div>
              <div class="col-md-12">
                <div class="input-group" id="cargarimgnovedadEquipo">
                  <span class="input-group-addon">
                    Selecciona una imagen (opcional):
                  </span>
                  <label class="form-control"> </label>
                  <div class="input-group-btn">
                    <label class="btn btn-default">
                      <span class="fa fa-upload "></span><span>Subir imagen</span><input type="file" id="imgnovedadequipo" name="imgnovedadequipo">
                    </label>
                  </div>
                </div>
              </div>
              <div class="form-group">
                <label>Da (&#10004;) si aplica paralización del Equipo</label>
                <input type="checkbox" id="checkparalizacion" class="paralizacion">
              </div>
              <div id="datosparalizacion" class="form-group">
                <label class="control-labels col-md-1">Ubicación:</label>
                <div class="col-xs-12 col-md-4">
                  <input type="text" class="form-control uppercase ubicacionparalizacion" name="ubicacionparalizacion" placeholder="Ubicación del equipo paralizado">
                </div>
                <label class="control-labels col-md-1">Horometro:</label>
                <div class="col-xs-12 col-md-4">
                  <input type="number" class="form-control horometroparalizacion" name="horometroparalizacion" placeholder="Horometro" >
                </div>
              </div>
              <div class="form-group">
                <div class="text-center">
                  <input type="submit" class="btn btn-round btn-success" value="Registro de Novedad">
                </div>
              </div>
              <?php
              $registronovedad = new ControladorNovedades();
              $registronovedad->ctrRegistroNovedades();
              ?>
            </form>
          </div>


        </div>
        <div id="conte_loading" class="conte_loading">
          <div id="cont_gif">
            <img src="<?php echo $url . 'vistas/img/plantilla/Ripple-1s-200px.gif' ?>">
          </div>
        </div>

      </div>
    </div>

  </div>
</div>