<!--=========================================
ENVIAR DOCUMENTOS A USUARIO POR AREA       =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>CHECK LIST DE ALMACÉN </h3>
      </div>
    </div>
    <div class="title_right col-xs-12">
      <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
        <div class="pull-right">
            <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target=".modalValorizacion" >Tabla de Valorización</button>
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
                    <div class="col-xs-12 col-md-4">
                      <div class="input-group">
                        <label class="input-group-addon">Fecha: </label>
                        <input type="text" name="fechabpa" id="fechabpa" readonly class="form-control filterColumn input-lg">
                      </div>
                    </div>
                    <!--=====================================================
                    =            ENCABEZADO DE CHECK LIST DE BPA            =
                    ======================================================-->
                    <div class="col-xs-12 col-md-4">
                      <div class="input-group">
                        <label class="input-group-addon">Evaluador: </label>
                          <select data-column="8" class="form-control filterColumn input-lg auditor">
                            <option selected value="Seleccionar una opción">Seleccionar una opción</option>
                            <?php
                              $tabla = "usuariosransa";
                              $rptausercalidad =  ControladorUsuarios::ctrMostrarUsuariosRansa($tabla,"","");
                              for ($i=0; $i < count($rptausercalidad) ; $i++) { 
                                $modulos = json_decode($rptausercalidad[$i]["idmodulos"],true);
                                for ($j=0; $j < count($modulos) ; $j++) { 
                                  if ($modulos[$j]["idmodulos_portal"] == 4 && $rptausercalidad[$i]["idciudad"] == $_SESSION["ciudad"] && $rptausercalidad[$i]["estado"] == 1) {
                                    echo '<option value="'.$rptausercalidad[$i]["id"].'">'.$rptausercalidad[$i]["primernombre"]." ".$rptausercalidad[$i]["primerapellido"]  .'</option>';
                                  }
                                }
                              }
                            ?>
                          </select>
                      </div>
                    </div>
                    <div class="col-xs-12 col-md-4">
                      <div class="input-group">
                        <label class="input-group-addon">ALMACÉN: </label>
                          <select data-column="8" class="form-control filterColumn input-lg localizacion">
                            <option selected value="Seleccionar una opción">Seleccionar una opción</option>
                            <?php
                            $localizacion = ControladorLocalizacion::ctrConsultarLocalizacion("","");
                            for ($i=0; $i < count($localizacion) ; $i++) { 
                              if ($localizacion[$i]['estado'] != 0) {
                                echo'<option value="'.$localizacion[$i]['idlocalizacion'].'">'.$localizacion[$i]['nom_localizacion'].'</option>';                                
                              }

                            }

                            ?>

                          </select>
                      </div>
                    </div>  
                    <div class="col-xs-12 col-md-4">
                      <div class="input-group">
                        <label class="input-group-addon">Cliente: </label>
                          <select data-column="8" class="form-control filterColumn input-lg cliente">
                            <option selected value="Seleccionar una opción">Seleccionar una opción</option>
                            <option value="Global">GENERAL</option>
                            <?php
                            $clientes = ControladorClientes::ctrmostrarClientes("","");
                            for ($i=0; $i < count($clientes) ; $i++) { 
                              if ($clientes[$i]['razonsocial'] != "varios") {
                                echo'<option value="'.$clientes[$i]['idcliente'].'">'.$clientes[$i]['razonsocial'].'</option>';                                
                              }

                            }

                            ?>

                          </select>
                      </div>
                    </div> 
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <div id="checkListbpasmartwizard">
                      <p style="padding-bottom: 10px;"> 
                        Selecciona cumplimiento realizado, caso de haber novedad registrar.

                      </p>
                        <ul>
                            <li><a href="#documentos">Documentos de Calidad<br /><small>Inspección visual</small></a></li>
                            <li><a href="#ol">Orden y Limpieza<br /><small>Inspección visual</small></a></li>
                            <li><a href="#aproductos">Almacén de Productos<br /><small>Inspección visual</small></a></li>
                            <div align="right" class=""><label style="padding-right: 10px;">Todo Cumple</label><input id="checkbpa" class="checkbpa" type="checkbox"></div>
                        </ul>
                     
                        <div id="contenido_items">
                            <div id="documentos" class="col-lg-12">
                                  <ul class="list-group">
                                    <li class="list-group-item"><div class="anchotextoitem"> Se archivan de forma correcta los documentos referentes a la recepción de los productos (Guía de remisión, packing-list, check-list de transporte físico o virtual, guía de recepción del WMS, etc.)</div>                                    
                                      <div  class="btn-group pull-right optioncheckcalidad">
                                        <select class="btn selectcheckbpa btnestado0">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>
                                    </li>
                                    <li class="list-group-item"> <div class="anchotextoitem"> Se archivan de forma correcta los documentos referentes al despacho de los productos (Guía de remisión, orden de despacho o pedido, Check-list de transporte físico o virtual, guía de despacho, etc.)</div>
                                      <div class="btn-group pull-right optioncheckcalidad">
                                        <select class="btn selectcheckbpa btnestado1">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item"><div class="anchotextoitem"> Se cumple con la frecuencia de inventario para el control interno de existencias (ver cotización, contrato o ANS aprobado por el cliente o lo establecido en el
PCME-0011). </div>
                                      <div class=" btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado2">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad2"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item"><div class="anchotextoitem"> Se archivan de forma correcta los documentos utilizados para la toma de inventario físico de los productos (ordenados, identificados y fechados). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado3">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad3"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item"><div class="anchotextoitem"> Se llenan todos los campos de los registros y cuenta con firmas de responsabilidad (no aplica para registros virtuales). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado4">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad4"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item"><div class="anchotextoitem"> Los registros utilizados corresponden a las versiones vigentes (físicos o digitales). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado5">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad5"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                      
                                    </li>
                                    <li class="list-group-item"><div class="anchotextoitem"> Se cumple con las Buenas Practicas de Documentación (carpetas/corrugados identificados y apilados de forma correcta sobre un pallets y sectorizados en un área rotulada).</div>
                                      <div class="btn-group pull-right optioncheckcalidad">
                                        <select class="btn selectcheckbpa btnestado6">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad6"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                       
                                    </li>
                                  </ul>                                  
                            </div>
                            <div id="ol" class="">
                              <ul>
                                <li class="list-group-item"><div class="anchotextoitem">Los pasillos se encuentran limpios y sin acumulación de artículos en desuso (sin papel, pedazo de cartón, stretch film, retazos de madera, producto derramado, cajas vacias y desordenadas, canutos, etc.).</div>
                                      <div class="btn-group pull-right optioncheckcalidad">
                                        <select class="btn selectcheckbpa btnestado0">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li>
                                <li class="list-group-item"><div class="anchotextoitem">Las paredes junto a pasillos y estructuras de rack se encuentran limpias (libres de insectos muertos, polvo y telarañas).</div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado1">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li>
                                <li class="list-group-item"><div class="anchotextoitem">Las estructuras de rack se encuentran identificadas con el rótulo de identificación según lo requerido por el WMS (no existen rótulos que no correspondan a los productos almacenados o zonas asignadas). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado2">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad2"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">No existe evidencia de consumo de producto almacenado en los rack o paredes del almacén (envoltura o botellas vacías). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado3">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad3"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Módulos de andenes en buen estado, limpios y ordenados (sin acumulación de documentos, basura o cajas junto a tomas de corriente). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado4">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad4"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Los tachos de basura ubicado en los andenes están limpios, rotulados, en buen estado y no contienen empaques de snack, envoltura o botellas de bebidas. </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado5">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad5"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">El área de andenes está limpia y ordenada, sin acumulación de pallets en mal estado. </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado6">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad6"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Las tulas son utilizadas para el almacenamiento de material de reciclaje (Stretch film y cartón según aplique). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado7">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad7"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Las estaciones de monitoreo de roedores ubicada en las puertas de los andenes se encuentran despejadas y en buen estado (sin obstrucciones de cualquier tipo). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado8">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad8"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <!-- <li class="list-group-item"><div class="anchotextoitem">El área de andenes está limpia y ordenada, libre de pallets en mal estado </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado9">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad9"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Las tulas son utilizadas para el almacenamiento de material de reciclaje (Strech film y cartón) </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado10">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad10"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Estaciones de monitoreo de roedores despejadas y en buen estado </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado11">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad11"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li>  -->
                              </ul>
                            </div>
                            <div id="aproductos" class="">
                              <ul>
                                <li class="list-group-item"><div class="anchotextoitem">Todos los productos se almacenan sobre pallets (no hay producto directamente en piso). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado0">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad0"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Los pallets se encuentran limpios y buen estado (productos alimenticios almacenados en pallets sin manchas de aceite, pallets sin restos de producto adherido/derramado, pallets sin daños estructurales o elementos incompletos, pallets sin clavos expuestos, sin evidencia de plaga como barrenador de madera, comejen, húmedos o con moho, ver PCME-0057). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado1">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad1"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li>                                
                                <li class="list-group-item"><div class="anchotextoitem">Los productos se mantienen en buen estado (no hay cajas golpeadas, dañadas o producto derramando por golpe de montacarga o traspaleta).</div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado2">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad2"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Los pallets están perchados correctamente (alineados en el rack sin esquinas en el aire) y las cajas están bien estibadas (orientación de la caja correcta y no existe picado en escalera). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado3">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad3"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">El producto en mal estado, averiado o caducado se encuentra ordenado, embalado, rotulado, su ubicación identificada, coincide el físico vs WMS y está bloqueado para el despacho). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado4">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad4"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Se evita la incompatibilidad de mercadería (almacenamiento de producto por clase sin generar contaminación cruzada de olores o derrames, ver requisitos del cliente en cotización, contrato o ANS aprobado y/o el anexo 1 del PCME-0011). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado5">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad5"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Se cumple con la carga máxima permitida por nivel de 1960 KG por nivel/nicho (verificar el peso de los productos en el FMCE-0033 levantado para cada cliente).</div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado6">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad6"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">La zona de picking se mantiene ordenada y no existen unidades de producto caídas debajo del pallets. </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado7">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad7"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Los productos se almacenan hasta el nivel de rack máximo solicitado por el cliente y acorde a los estándades de temperatura requeridos/ofertados (ver requisitos del cliente en cotización, contrato o ANS aprobado por el cliente vs los registros de temperatura de los datalogger). </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado8">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad8"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <!-- <li class="list-group-item"><div class="anchotextoitem">Saldo en caja y caja entrecruzada </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado9">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad9"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Todos los pallets cuentan con rótulo de identificación de pallets correspondiente (aprobado, cuarentena o rechazado) </div>
                                      <div class="btn-group pull-right optioncheckcalidad">
                                        <select class="btn selectcheckbpa btnestado10">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad10"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Se llenan todos los campos de rótulo de identificación </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado11">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad11"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li> 
                                <li class="list-group-item"><div class="anchotextoitem">Cumplimiento de estándares de conservación (T°C) </div>
                                      <div class="btn-group pull-right optioncheckcalidadpeque">
                                        <select class="btn selectcheckbpa btnestado12">
                                          <option selected value="Seleccionar">Seleccionar</option>
                                          <option value="2">CUMPLE</option>
                                          <option value="1">CUMPLE PARCIALMENTE</option>
                                          <option value="0">NO CUMPLE</option>
                                        </select>
                                        <button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad12"> <span class="glyphicon glyphicon-warning-sign"></span></button>
                                      </div>                                  
                                </li>  -->
                              </ul>
                              <div>

                            <div class="col-md-12">
                              <div class="input-group" id="btnCargarEvid">
                                <span class="input-group-addon">
                                  EVIDENCIAS FOTOGRÁFICAS:
                                </span>
                                <label class="form-control"> </label>
                                <div class="input-group-btn">
                                  <label class="btn btn-default">
                                    <span class="fa fa-upload icoCargar"></span><span id="textSubir">Varias Imagenes</span><input type="file" id="imgReferen" name="imgReferen[]" multiple>
                                  </label>  
                                </div>
                              </div>
                            </div>
                                
                              </div>                              
                            </div>
                        </div>

                    </div>
                  <div  style="margin-top: 15px; " class="col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon">OBSERVACIONES: </span>                 
                      <textarea class="form-control input-lg obscheckbpa  uppercase"> </textarea>
                    </div>                              
                  </div>
                    <!--===================================================
                    =            SECCION DE REPORTE DE NOVEDAD            =
                    ====================================================-->
                    <div id="registro_novedad">
                      <div class="x_title">
                        <h2>Registo de Novedades <small>(Colocar la información lo mas detallado posible.)</small></h2>
                        <div class="clearfix"></div>
                    </div>     
                        <div class="x_content">
                      <form method="POST" enctype="multipart/form-data" class="form-horizontal" onsubmit=" return RegistroNovedad()">
                        <input type="hidden" id="idequipo" name="idequipo">
                        <input type="hidden" id="codigoEquipo" name="codigoEquipo">
                        <input type="hidden" id="selectturn" name="selectturn">
                      <div class="form-group">
                            <label class="control-labels col-md-2">Detalle de la Novedad:</label>
                            <div class="col-xs-12 col-md-10">
                              <textarea class="form-control uppercase descripcion_novedad" name="descripcion_novedad" placeholder="Detalle la novedad que se ha presentado"></textarea>
                            </div>
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
                              <input type="text"  class="form-control uppercase ubicacionparalizacion" name="ubicacionparalizacion" placeholder="Ubicación del equipo paralizado">
                            </div>
                            <label class="control-labels col-md-1">Horometro:</label>
                            <div class="col-xs-12 col-md-4">
                              <input type="number" class="form-control horometroparalizacion" name="horometroparalizacion" placeholder="Horometro">
                            </div>
                      </div>
                      <div class="form-group">
                        <div class="text-center">
                          <input type="submit" class="btn btn-round btn-success" value="Registro de Novedad">
                        </div>
                      </div>
                      <?php

                      ?>
                    </form>
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


<!--====================================================
=            MODAL DE TABLA DE VALORIZACIÓN            =
=====================================================-->
    <div class="modal fade modalValorizacion" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Tabla de Valorización Check List</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <div class="col-md-12 col-sm-12">
                <div class="x-content">
                  <div style="height: auto;">
                    <div class="col-sm-12 col-md-12 text-center">
                      <div class="cabeceratabla">
                        <p align="center" class="text-center"><b><span> CRITERIOS DE CALIFICACIÓN</span> </b></p>
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-12 text-center numerosvalorizacion izquierdo">
                      <div class="dentroizquierdo">
                        CUMPLE (2)
                      </div>
                    </div>
                    <div class="col-md-12 text-center tvalorizacionpeque">
                      <div class="dentroizquierdo">
                       El items evaluado se cumple en su totalidad. No se evidencia incumplimiento alguno (0 hallazgos)
                      </div>
                    </div>
                    <div class="col-sm-4 col-md-12 text-center numerosvalorizacion medio">
                      <div class="dentromedio">
                        CUMPLE PARCIALMENTE (1)
                      </div>
                    </div>
                    <div class="col-md-12 text-center tvalorizacionpeque">
                      <div class="dentromedio">
                       El items evaluado se cumple de forma parcial y se evidencia un bajo número de incumplimientos (1-3 hallazgos)
                      </div>
                    </div> 
                    <div class="col-sm-4 col-md-12 text-center numerosvalorizacion derecho">
                      <div class="dentroderecho">
                        NO CUMPLE (0)
                      </div>
                    </div>
                    <div class="col-xs-12 text-center tvalorizacionpeque">
                      <div class="dentroderecho">
                        El items evaluado se cumple de forma parcial y se evidencia un número significativo de incumplimientos (más de 4 hallazgos)
                      </div>
                    </div>                    
                    <div class="col-sm-4 text-center izquierdo tvalorizaciongrande">
                      <div class="dentroizquierdo">
                       El items evaluado se cumple en su totalidad. No se evidencia incumplimiento alguno (0 hallazgos)
                      </div>
                    </div>
                    <div class="col-sm-4 text-center medio tvalorizaciongrande">
                      <div class="dentromedio">
                       El items evaluado se cumple de forma parcial y se evidencia un bajo número de incumplimientos (1-3 hallazgos)
                      </div>
                    </div>                    
                    <div class="col-sm-4 text-center derecho tvalorizaciongrande" >
                      <div class="dentroderecho">
                        El items evaluado se cumple de forma parcial y se evidencia un número significativo de incumplimientos (más de 4 hallazgos)
                      </div>
                    </div>
                    <div class="col-xs-12" style="height: 35pt;">
                      
                    </div>
                    <div class="col-sm-12 col-xs-12 text-center">
                      <div class="cabeceratabla">
                        <p align="center" class="text-center"><b><span> CALIFICACIÓN</span> </b></p>
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 text-center izquierdo">
                      <div class="dentroizquierdo">
                        Requiere mejora =< 74 %
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 text-center medio">
                      <div class="dentromedio">
                        Regular 75 - 84 %
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 text-center medio" >
                      <div class="dentromedio "style="border-left: solid black 1.0pt;">
                       Bueno 85 - 90 %
                      </div>
                    </div>
                    <div class="col-sm-3 col-xs-12 text-center derecho">
                      <div class="dentroderecho">
                       Excelente => 91 %
                      </div>
                  </div>                 
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
          <!--<button type="button" class="btn btn-primary guardarEquipoNuevo">Registrar</button>-->
        </div>
      </div>
    </div>
</div>
