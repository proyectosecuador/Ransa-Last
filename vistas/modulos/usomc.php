<!--=========================================
ENVIAR DOCUMENTOS A USUARIO POR AREA       =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>Manejo de Equipos MC</h3>
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
        <div class="pull-left">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target=".modalRegistrarUso">Registrar Uso</button>
        </div>
        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<!--=============================================================
=            PRESENTACION DE TABLA DE USO DE EQUIPOS            =
==============================================================-->
  <div class="table-responsive">
   <table id="dataUsoEqui" class=" table table-striped table-bordered dt-responsive nowrap">
      <thead>
        <tr>
          <th>#</th>
          <th>Equipo</th>
          <th>Personal</th>          
          <th>Fecha-Hora Inicio</th>
          <?php
          if ($_SESSION["perfil"] == "ADMINISTRADOR") {
            echo "<th>Solicitado por</th>" ;
          }
          ?>
          <th>Bateria I.</th>
          <th>Bateria en uso</th>
          <th>Baterias Asignadas</th>
          <th>Porcentaje I.</th>
          <th>Horometro I.</th>
          <?php
          if ($_SESSION["perfil"] == "ADMINISTRADOR") {
            echo "<th>Items R.</th>" ;
          }
          ?>          
          
          <th>Observaciones</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>


      </tbody>
  </table>                      
    
  </div>




<!--===========================================
=            REGISTRO DE USO DE EQUIPOS            =
============================================-->
    <div class="modal fade modalRegistrarUso" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registro de Uso de Equipos</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                        <div class="title_right col-xs-12">
                          <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                            <div class="pull-right">
                                <button id="selecEquipo" type="button" class="btn btn-success btn-sm">Selecciona Equipo</button>
                                <input id="sessionciudad" type="hidden" value="<?php echo $_SESSION["ciudad"]; ?>">
                            </div>
                          </div>
                        </div>
                    <h2 id="descripEquiSeleccionado">Selecciona el código del equipo</h2>
                    <div class="clearfix"></div>
                  </div>                  
                  <div class="x_content">
                      <div class="col-xs-12 seleccionPersonal">
                        <div><span>Personal que hará uso del Equipo:</span></div>
                        <input type="hidden" id="idequipo" name="idequipo">
                        <input type="hidden" id="codigoEquipo" name="codigoEquipo">
                        <div class="input-group"><span class=" labelPersonal input-group-addon">Personal: </span> <input type="text" name="personal" class="form-control input-lg uppercase personal" autocomplete="off"></div>
                      </div>
                    </div>
                    <div class="x_content">
                      <div id="usosmartwizard">
                      <p style="padding-bottom: 10px;">
                        Marca (&#10004;) si no existe novedad, caso contrario registrala.

                      </p>
                      
                        <ul>
                            <li><a href="#CheckRapido">Check Inicio de Operacion<br /><small>Inspección</small></a></li>
                            <div align="right" class="checkallitem"><label style="padding-right: 10px;">Todo Correctamente</label><input id="allitemuso" class="allitemuso" type="checkbox"></div>
                        </ul>
                     
                        <div id="contenido_items">
                            <div id="CheckRapido" class="col-lg-12">
                                  <ul class="list-group">
                                    <li class="list-group-item">RUEDAS Y PERNOS 
                                      <div class="btn-group pull-right optionchecklist">
                                        <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok0 "> <span class="glyphicon glyphicon-ok-sign"></span></button>
                                        <button data-toggle="tooltip" title="Registrar Observación" class="btn btn-info btnobservacion btnobservacion0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>
                                    </li>
                                    <li class="list-group-item">MANGUERAS HIDRÁULICAS
                                      <div class="btn-group pull-right optionchecklist">
                                        <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok1"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                                        <button data-toggle="tooltip" title="Registrar Observación" class="btn btn-info btnobservacion btnobservacion1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item">CABINA / ASIENTO
                                      <div class=" btn-group pull-right optionchecklist">
                                        <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok2"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                                        <button data-toggle="tooltip" title="Registrar Observación" class="btn btn-info btnobservacion btnobservacion2"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item">BATERIA Y CONECTORES
                                      <div class="btn-group pull-right optionchecklist">
                                        <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok3"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                                        <button data-toggle="tooltip" title="Registrar Observación" class="btn btn-info btnobservacion btnobservacion3"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item">FUNCIONES HIDRÁULICAS MÁSTIL
                                      <div class="btn-group pull-right optionchecklist">
                                        <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok4"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                                        <button data-toggle="tooltip" title="Registrar Observación" class="btn btn-info btnobservacion btnobservacion4"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item">TIMÓN Y CLAXON
                                      <div class="btn-group pull-right optionchecklist">
                                        <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok5"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                                        <button data-toggle="tooltip" title="Registrar Observación" class="btn btn-info btnobservacion btnobservacion5"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item">LIMPIEZA DEL EQUIPO
                                      <div class="btn-group pull-right optionchecklist">
                                        <button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok6"> <span class="glyphicon glyphicon-ok-sign"></span></button>
                                        <button data-toggle="tooltip" title="Registrar Observación" class="btn btn-info btnobservacion btnobservacion6"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                       
                                    </li>
                                  </ul>
                            <div>
                              <div class="input-group">
                                <span class="input-group-addon" id="textidenbat"></span>                 
                                <input type="text" maxlength="1" class="form-control input-lg numbateria" name="" >
                              </div>
                                <div class="input-group">
                                
                                <script>
                                  function v1(){
                                 let valor1 = document.getElementById("vista_bateria").value;
                                 let valor2 = document.getElementById("validar_bateria").value;
                                  
                                 const existe = valor1.includes(valor2); 
                                  if ( existe != false) {
                                    
                                  }else{
                                    swal.fire({
                                      icon: "error",
                                      title: 'No coincide con la bateria asignada por favor Buscar la bateria correspondiente',
                                    });
                                  } 
                                  }
                                </script>
                               <input type="hidden" id="vista_bateria">
                                <span class="input-group-addon" id="textcodigo_ba">Bateria:</span>                 
                                <input onblur="v1()" type="text" id="validar_bateria" class="form-control uppercase input-lg codigo_ba" name="">
                              </div>
                              <div class="input-group textmovil">
                                <span class="input-group-addon" id="definetext"></span>                 
                                <input type="text" maxlength="1" max="8" min="4" class="form-control uppercase input-lg porcarga" name="">
                              </div>
                              <div class="input-group">
                                <span class="input-group-addon">H. Inicial: </span>                 
                                <input type="number" class="form-control uppercase input-lg horoinicio" name="" required>
                              </div>
                              <div class="input-group">
                                <span class="input-group-addon">Observación: </span>                 
                                <input type="text" class="form-control uppercase input-lg observa" name="">
                              </div> 
                              </div>
                            </div>
                        </div>

                    </div>                      
                    </div>

                         <div id="conte_loading" class="conte_loading">
                            <div id="cont_gif" >
                              <img src="<?php echo $url.'vistas/img/plantilla/Ripple-1s-200px.gif'?>">
                            </div>
                          </div>                    
                  </div>
                </div>
               
            </div>

        </div>
      </div>
        <!--======================================================
        =            FOOTER DEL MODAL DE USO DE EQUIPO            =
        =======================================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <!--<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary guardarEquipoNuevo">Registrar</button>-->
        </div>
      </div>
    </div>
</div>

<!--===========================================
=            REGISTRO TERMINO DE USO DE EQUIPOS            =
============================================-->
    <div class="modal fade modalTerminoUso" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registro de Uso de Equipos</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <div class="col-md-12 col-xs-12"> 
              <input type="hidden" name="" id="idmanejoeq">
              <input type="hidden" name="" id="horoinicial">
                  <div class="x_content">
                    <!--<div class="col-xs-12 col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon">EQUIPO: </span>                 
                        <input type="text" class="form-control input-lg" readonly name="">
                      </div>
                    </div>-->  
                    <div class="col-xs-12 col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">HOROMETRO INICIAL: </span>                 
                        <input type="number" class="form-control input-lg horoinicial" id="Inicial" name="" value="<?php echo $horometroinicial;?>" disabled>
                      </div>
                    </div>               
                    <div class="col-xs-12 col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">HOROMETRO FINAL: </span>                 
                        <input type="number" class="form-control input-lg horofinal" id="terminal" name="" required>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-6">
                      <div class="input-group">
                    <span class="input-group-addon">HORAS USADO: </span>
                    <input type="number" class="form-control input-lg " id="total" name="" disabled> 
                    </div>
                    </div>
                    <script>
                        let precio1 = document.getElementById("Inicial")
                        let precio2 = document.getElementById("terminal")
                        let precio3 = document.getElementById("total")
                        precio2.addEventListener("change", () => {
                          precio3.value = parseFloat(precio2.value) - parseFloat(precio1.value)
                        
                          if (precio3.value > 20) {
                            alert("Has sobrepasado los limites recorido, Revisar si el Horometro esta bien digitado.");
                            document.getElementById("terminal").value = "";
                          } 
                        });
                    </script>
                    <div class="col-xs-12 col-md-6">
                      <div class="input-group">
                        <span class="input-group-addon">IDENTIFICADOR DE BATERIA: </span>                 
                        <input type="text" maxlength="1" class="form-control input-lg uppercase numbateriafinal" name="">
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon">CANTIDAD DE CARGA: </span>                 
                        <input type="text" maxlength="1" class="form-control input-lg rayascarga" name="">
                      </div>                      
                    </div>
                    <div class="col-xs-12 col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon">UBICACIÓN: </span>                 
                        <input type="text" class="form-control input-lg uppercase ubicacionfinal" name="">
                      </div>                      
                    </div>
                    <div class="col-xs-12 col-md-12">
                      <div class="input-group">
                        <span class="input-group-addon">OBSERVACIONES: </span>                 
                        <input type="text" class="form-control input-lg uppercase observacionesfinal" name="">
                      </div>                      
                    </div>                    
                  </div>
                </div>
            </div>
        </div>
      </div>
        <!--======================================================
        =            FOOTER DEL MODAL DE USO DE EQUIPO            =
        =======================================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary TerminarUsoEquipo">Uso de Equipo Terminado</button>
        </div>
      </div>
    </div>
</div>