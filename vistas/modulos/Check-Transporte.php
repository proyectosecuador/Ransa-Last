<?php
  $rutas = explode("/", $_GET["ruta"]);
  // var_dump($rutas);
  $rptacheck = ControladorCheckTransporte::ctrConsultarCheckTransporte("idmov_recep_desp",$rutas[1]);
  $rptaguia = ControladorMovRD::ctrConsultarMovRD( $rutas[1],"idmov_recep_desp");
?>
<div class="page-title">

  <div class="row">

    <div class="title_left">

      <div class="titlePage">

        <h3>Check List del Transporte</h3>
        <?php
          if ($rutas[2] == "RECEPCION" || $rutas[2] == "DESPACHO" || $rutas[2] == "REPALETIZADO") {
            if (isset($_COOKIE["btnAvanza".$rutas[1]]) && $_COOKIE["btnAvanza".$rutas[1]] == 1) {
              echo '<span class="btn btn-info btnCheckRecep" onclick="btnFinalizarRecep()" >Finalizar</span>';
            }else{
             echo '<span class="btn btn-info btn_Avanzar">Avanzar</span>'; 
            }
            
          }
          $cuentas = json_decode($_SESSION["cuentas"],true);
          if(in_array("LIRIS S.A.", array_column($cuentas, 'nombre'))){
            echo '<span class="btn btn-warning SaltarCheckTrans">Saltar Check List</span>';

          }
        ?>
        

      </div>

    </div>

  </div>

  </div>

  <div class="clearfix"></div>


                  


  <?php


  if ($rutas[2] == "DESPACHO") {
    $form = '<div class="x_panel">
  <div class="x_content">
            <div class="row"><div class="col-xs-12 col-md-12"><input type="hidden" id="idrecepcion" value="'.$rutas[1].'" name="">
            <!--=============================
               =            RESPONSABLE DE INSPECCION            =
              ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Actividad:</span>
                      <input type="text" class="form-control input-lg uppercase actividad" readonly value="'.$rutas[2].'" name="">
                    </div>
                    <div class="input-group">
                      <span class="input-group-addon">Inspección realizada por: </span>';
                      /*============================================================
                      =            VERIFICAOS SI EXISTE COOKIE GUARDADA            =
                      ============================================================*/
                  if (isset($_COOKIE["responsablecheck".$rutas[1]])) {
                    $valorResponsable = $_COOKIE["responsablecheck".$rutas[1]];
                    $estado = "disabled readonly";
                  }else{
                    $valorResponsable = "";
                    $estado ="";
                  }
      $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase responsablechecktrans" value="'.$valorResponsable.'" name="">
                    </div></div>                  <div class="col-xs-12 col-md-6">
                    <!--=============================
                    =            TRANSPORTISTA            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Transportista: </span> ';
                  if ($rptacheck["transportista"] != null) {
                    $valortransportista = $rptacheck["transportista"];
                    $estado = "disabled readonly";
                  }else if (isset($_COOKIE["transportista".$rutas[1]])) {
                    $valortransportista = $_COOKIE["transportista".$rutas[1]];
                    $estado = "";
                  }else{
                    $valortransportista = "";
                    $estado = "";
                  }
      $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase transportista" value="'.$valortransportista.'">
                    </div>
                  </div>                  <div class="col-xs-12 col-md-3">
                    <!--=============================
                    =            PLACA            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Placa: </span>';
                  if ($rptacheck["placa"] != null) {
                    $valorplaca = $rptacheck["placa"];
                    $estado = "disabled readonly";
                  }else if (isset($_COOKIE["placa".$rutas[1]])) {
                    $valorplaca = $_COOKIE["placa".$rutas[1]];
                    $estado = "";
                  }else{
                    $valorplaca = "";
                    $estado = "";
                  }
      $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase placa" value="'.$valorplaca.'">                    </div>
                  </div>

                  <div class="col-xs-12 col-md-3">
                  <!--=============================
                  =            nguia           =
                  ==============================-->
                  <div class="input-group">
                    <span class="input-group-addon">N° Guias: </span>';
                if ($rptaguia["nguias"] != null) {
                  $valornguia = $rptaguia["nguias"];
                  $estado = "disabled readonly";
                }else if (isset($_COOKIE["nguias".$rutas[1]])) {
                  $valornguia = $_COOKIE["nguias".$rutas[1]];
                  $estado = "";
                }else{
                  $valornguia = "";
                  $estado = "";
                }
        $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase guias" value="'.$valornguia.'">                    </div>
                </div>

                  <div class="col-md-9 col-xs-12">
                    <!--===============================================
                    =            VERIFICACION DEL INTERIOR            =
                    ================================================-->
                    <fieldset>
                      <legend>Verificación del Interior:</legend>
                      <div class="col-xs-12">
                        <label>1. El vehículo se encuentra en buen estado <i data-toggle="tooltip" title="El techo y las paredes en buen estado, sin ranuras, orificios o pasos de luz que permitan el ingreso de agua lluvia" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="pptl" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="pptl" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>2. El vehículo se encuentre en buenas condiciones de limpieza <i data-toggle="tooltip" title="Sin papeles, cartones, plástico film, tierra acumulada, humedad u óxido que pueda generar suciedad en el producto. Todos los residuos generados en la carga del producto no debe quedar en el interior del vehículo" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline"  style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="pa" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="pa" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>3. El vehículo está libre de residuos de cargas anteriores <i data-toggle="tooltip" title="Como cereales (arroz, avena, maíz, trigo, cebada, etc.),  leguminosas (lenteja, garbanzo, soja, etc.), o restos de otros productos que representen un riesgo de presencia de plaga" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline"  style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="mincom" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="mincom" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>4. El vehículo está libre de plagas <i data-toggle="tooltip" title="Insectos o resto de ellos como grillos, arañas o tela arañas, cucarachas, gorgojos, hormigas, moscas, etc. que pueda generar una contaminación cruzada al producto a cargar o sugiera la presencia de plaga en el producto recibido" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="plaga" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="plaga" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>5. El vehículo está libre de olores fuera de lo normal <i data-toggle="tooltip" title="Como olores de fermentación, descomposición, humedad, pintura, etc" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="oextranios" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="oextranios" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>6. El vehículo está libre de químicos, sustancias o artículos contaminantes <i data-toggle="tooltip" title="Químicos como combustibles, aceites, solventes entre otros y artículos como llanta de emergencia, canecas para combustibles, utensilios de limpieza en uso (escoba, recogedor, etc.)" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="oquimicos" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="oquimicos" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>7. Los sellos de seguridad coinciden con los detallados en la guía o packing list (cuando aplique) <i data-toggle="tooltip" title="Los sellos de seguridad coinciden con los detallados en la guía o packing list (cuando aplique)" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="sellos" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="sellos" id="NO" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No Aplica
                            <input type="radio" name="sellos" id="NO APLICA" class="flat">
                          </label>                          
                        </div>
                      </div>                     
                    </fieldset>
                  </div>                  <!--===============================================
                  =            OBSERVACIONES ADICIONALES            =
                  ================================================-->
                  <div class="col-xs-12 col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon">Observaciones: </span>
                      <textarea class="form-control input-lg uppercase obstransporte"></textarea>
                    </div>
                  </div>
                  
          <!--================================================================
          =            SECCION PARA COLOCAR LAS IMAGENES AÑADIDAS            =
          =================================================================-->
          <div class="x_panel contentvpimg">
            <div class="x_content">
              <div class="col-xs-12">               
                <div class=" dropzones ImgRecepcion needsclick dz-clickable">
                  <input type="file" name="file[]">
                  <div class="dz-message needsclick">
                  
                    Arrastrar o dar click para subir imagenes.

                  </div>
                </div>
                </div> 
            </div>
          </div>                  <button type="button" class="btn btn-primary guardarCheckTransporte">Registrar Check List</button>
                   <div id="conte_loading" class="conte_loading">
                      <div id="cont_gif" >
                        <img src="'.$url.'vistas/img/plantilla/Ripple-1s-200px.gif">
                      </div>
                    </div>                    


               
            </div>    
  </div>
</div>';
    echo $form;
    
  }else if ($rutas[2] == "RECEPCION") {
    $form = '<div class="x_panel">
  <div class="x_content">
            <div class="row"><div class="col-xs-12 col-md-12"><input type="hidden" id="idrecepcion" value="'.$rutas[1].'" name=""><!--=============================
               =            RESPONSABLE DE INSPECCION            =
              ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Actividad:</span>
                      <input type="text" class="form-control input-lg uppercase actividad" readonly value="'.$rutas[2].'" name="">
                    </div>
                        <div class="col-md-12">
                        <div class="input-group" id="btnCargar">
                          <label class="form-control">';
                          if (isset($_COOKIE["cantImg".$rutas[1]])) {
                            $form .= 'Se ha cargado '.$_COOKIE["cantImg".$rutas[1]].' imagen(es)';
                          }else{
                            if (!isset($_COOKIE["cantImg".$rutas[1]]) && isset($_COOKIE["btnAvanza".$rutas[1]])) {
                             $form .= 'No se han cargado Imagenes'; 
                            }else{
                              $form .= ''; 
                            }
                          }
                          $form .= '</label>
                          <div class="input-group-btn">';
                            if (isset($_COOKIE["btnAvanza".$rutas[1]]) && $_COOKIE["btnAvanza".$rutas[1]] == 1) {
                             $form .= '<label class="btn btn-default" style="display:none;">'; 
                            }else{
                             $form .= '<label class="btn btn-default">';
                            }                          
                            $form .= '
                              <span class="fa fa-upload icoCargar"></span><span id="textSubir">Subir Imagenes</span><input type="file" id="imgCheckTrans" name="imgCheckTrans[]" capture="camera">
                            </label>  
                          </div>
                        </div>
                      </div> 
                    </div></div></div></div>
      <div id="C_Img_CheckTra" class="x_panel"';
      if (isset($_COOKIE["btnAvanza".$rutas[1]]) && $_COOKIE["btnAvanza".$rutas[1]] == 1 ) {
        $form .= 'style="display:none;"';
      }else{
        $form .= 'style="display:inline-block;"';
      }
      $form .= '>';
      if (isset($_COOKIE["Img".$rutas[1]])) {
        $datosjson = json_decode($_COOKIE["Img".$rutas[1]],true);

        for ($i=0; $i < count($datosjson) ; $i++) {
          $form .= '<div class="col-md-3 text-center"><img class="img-thumbnail" src="'.$url.$datosjson[$i]["ImgRecepcion"].'" style="width: 200px; height: 200px;"><span idmov="'.$rutas[1].'" data_Img="'.$datosjson[$i]["ImgRecepcion"].'" style="cursor: pointer;" onclick="EliminarImgCheckTrans(this)"><div class="text-center">Eliminar</div></span><div>'.$datosjson[$i]["comentario"].'</div></div>';
        }
      }
      $form .= '</div>
      <div class="x_panel" id="ContDatosCheckRecep"';
      if (isset($_COOKIE["btnAvanza".$rutas[1]]) && $_COOKIE["btnAvanza".$rutas[1]] == 1 ) {
        $form .= 'style="display:inline-block;"';
      }else{
        $form .= 'style="display:none;"';
      }
      $form .='>
      <div class="x_content">
        <div class="row">
        <div class="col-xs-12 col-md-12">
          <div class="input-group">
            <span class="input-group-addon">Inspección realizada por: </span>';
            /*============================================================
            =            VERIFICAOS SI EXISTE COOKIE GUARDADA            =
            ============================================================*/
        if (isset($_COOKIE["responsablecheck".$rutas[1]])) {
          $valorResponsable = $_COOKIE["responsablecheck".$rutas[1]];
          $estado = "disabled readonly";
        }else{
          $valorResponsable = "";
          $estado = "";
        }
$form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase responsablechecktrans" value="'.$valorResponsable.'" name="">
          </div>        
        </div>
        <div class="col-xs-12 col-md-9">
                    <!--=============================
                    =            TRANSPORTISTA            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Transportista: </span> ';
                  if (isset($rptacheck["transportista"]) && $rptacheck["transportista"] != null) {
                    $valortransportista = $rptacheck["transportista"];
                    $estado = "disabled readonly";
                  }else if (isset($_COOKIE["transportista".$rutas[1]])) {
                    $valortransportista = $_COOKIE["transportista".$rutas[1]];
                    $estado = "";
                  }else{
                    $valortransportista = "";
                    $estado = "";
                  }
      $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase transportista" value="'.$valortransportista.'">
                    </div>
                  </div>                  <div class="col-xs-12 col-md-3">
                    <!--=============================
                    =            PLACA            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Placa: </span>';
                  if (isset($rptacheck["placa"]) && $rptacheck["placa"] != null) {
                    $valorplaca = $rptacheck["placa"];
                    $estado = "disabled readonly";
                  }else if (isset($_COOKIE["placa".$rutas[1]])) {
                    $valorplaca = $_COOKIE["placa".$rutas[1]];
                    $estado = "";
                  }else{
                    $valorplaca = "";
                    $estado = "";
                  }
      $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase placa" value="'.$valorplaca.'">                    </div>
                  </div>

                  <div class="col-xs-12 col-md-6">
                  <!--=============================
                  =            nguia           =
                  ==============================-->
                  <div class="input-group">
                    <span class="input-group-addon">N° Guias: </span>';
                if ($rptaguia["nguias"] != null) {
                  $valornguia = $rptaguia["nguias"];
                  $estado = "disabled readonly";
                }else if (isset($_COOKIE["nguias".$rutas[1]])) {
                  $valornguia = $_COOKIE["nguias".$rutas[1]];
                  $estado = "";
                }else{
                  $valornguia = "";
                  $estado = "";
                }
        $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase guias" value="'.$valornguia.'">                    </div>
                </div>

                  <div class="col-md-9 col-xs-12">
                    <!--===============================================
                    =            VERIFICACION DEL INTERIOR            =
                    ================================================-->
                    <fieldset>
                      <legend>Verificación del Interior:</legend>
                      <div class="col-xs-12">
                        <label>1. El vehículo se encuentra en buen estado <i data-toggle="tooltip" title="El techo y las paredes en buen estado, sin ranuras, orificios o pasos de luz que permitan el ingreso de agua lluvia" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="pptl" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="pptl" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>2. El vehículo se encuentre en buenas condiciones de limpieza <i data-toggle="tooltip" title="Sin papeles, cartones, plástico film, tierra acumulada, humedad u óxido que pueda generar suciedad en el producto. Todos los residuos generados en la carga del producto no debe quedar en el interior del vehículo" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline"  style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="pa" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="pa" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>3. El vehículo está libre de residuos de cargas anteriores <i data-toggle="tooltip" title="Como cereales (arroz, avena, maíz, trigo, cebada, etc.),  leguminosas (lenteja, garbanzo, soja, etc.), o restos de otros productos que representen un riesgo de presencia de plaga" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline"  style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="mincom" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="mincom" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>4. El vehículo está libre de plagas <i data-toggle="tooltip" title="Insectos o resto de ellos como grillos, arañas o tela arañas, cucarachas, gorgojos, hormigas, moscas, etc. que pueda generar una contaminación cruzada al producto a cargar o sugiera la presencia de plaga en el producto recibido" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="plaga" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="plaga" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>5. El vehículo está libre de olores fuera de lo normal <i data-toggle="tooltip" title="Como olores de fermentación, descomposición, humedad, pintura, etc" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="oextranios" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="oextranios" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>6. El vehículo está libre de químicos, sustancias o artículos contaminantes <i data-toggle="tooltip" title="Químicos como combustibles, aceites, solventes entre otros y artículos como llanta de emergencia, canecas para combustibles, utensilios de limpieza en uso (escoba, recogedor, etc.)" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="oquimicos" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="oquimicos" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>7. Los sellos de seguridad coinciden con los detallados en la guía o packing list (cuando aplique) <i data-toggle="tooltip" title="Los sellos de seguridad coinciden con los detallados en la guía o packing list (cuando aplique)" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="sellos" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="sellos" id="NO" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No Aplica
                            <input type="radio" name="sellos" id="NO APLICA" class="flat">
                          </label>                          
                        </div>
                      </div>                    
                    </fieldset>
                  </div> 
                  <!--===============================================
                  =            OBSERVACIONES ADICIONALES            =
                  ================================================-->
                  <div class="col-xs-12 col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon">Observaciones: </span>';
                  if (isset($_COOKIE["obstransporte".$rutas[1]])) {
                    $valorobservacionesA = $_COOKIE["obstransporte".$rutas[1]];
                  }else{
                    $valorobservacionesA = "";
                  }
                      $form .= '<textarea class="form-control input-lg uppercase obstransporte">'.$valorobservacionesA.'</textarea>
                    </div>
                  </div>

        </div>
              
      </div>
      </div>';

      echo $form; 

  }else if ($rutas[2] == "REPALETIZADO") {
    $form = '<div class="x_panel">
  <div class="x_content">
            <div class="row"><div class="col-xs-12 col-md-12"><input type="hidden" id="idrecepcion" value="'.$rutas[1].'" name=""><!--=============================
               =            RESPONSABLE DE INSPECCION            =
              ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Actividad:</span>
                      <input type="text" class="form-control input-lg uppercase actividad" readonly value="'.$rutas[2].'" name="">
                    </div>
                        <div class="col-md-12">
                        <div class="input-group" id="btnCargar">
                          <label class="form-control">';
                          if (isset($_COOKIE["cantImg".$rutas[1]])) {
                            $form .= 'Se ha cargado '.$_COOKIE["cantImg".$rutas[1]].' imagen(es)';
                          }else{
                            if (!isset($_COOKIE["cantImg".$rutas[1]]) && isset($_COOKIE["btnAvanza".$rutas[1]])) {
                             $form .= 'No se han cargado Imagenes'; 
                            }else{
                              $form .= ''; 
                            }
                          }
                          $form .= '</label>
                          <div class="input-group-btn">';
                            if (isset($_COOKIE["btnAvanza".$rutas[1]]) && $_COOKIE["btnAvanza".$rutas[1]] == 1) {
                             $form .= '<label class="btn btn-default" style="display:none;">'; 
                            }else{
                             $form .= '<label class="btn btn-default">';
                            }                          
                            $form .= '
                              <span class="fa fa-upload icoCargar"></span><span id="textSubir">Subir Imagenes</span><input type="file" id="imgCheckTrans" name="imgCheckTrans[]" capture="camera">
                            </label>  
                          </div>
                        </div>
                      </div> 
                    </div></div></div></div>
      <div id="C_Img_CheckTra" class="x_panel"';
      if (isset($_COOKIE["btnAvanza".$rutas[1]]) && $_COOKIE["btnAvanza".$rutas[1]] == 1 ) {
        $form .= 'style="display:none;"';
      }else{
        $form .= 'style="display:inline-block;"';
      }
      $form .= '>';
      if (isset($_COOKIE["Img".$rutas[1]])) {
        $datosjson = json_decode($_COOKIE["Img".$rutas[1]],true);

        for ($i=0; $i < count($datosjson) ; $i++) {
          $form .= '<div class="col-md-3 text-center"><img class="img-thumbnail" src="'.$url.$datosjson[$i]["ImgRecepcion"].'" style="width: 200px; height: 200px;"><span idmov="'.$rutas[1].'" data_Img="'.$datosjson[$i]["ImgRecepcion"].'" style="cursor: pointer;" onclick="EliminarImgCheckTrans(this)"><div class="text-center">Eliminar</div></span><div>'.$datosjson[$i]["comentario"].'</div></div>';
        }
      }
      $form .= '</div>
      <div class="x_panel" id="ContDatosCheckRecep"';
      if (isset($_COOKIE["btnAvanza".$rutas[1]]) && $_COOKIE["btnAvanza".$rutas[1]] == 1 ) {
        $form .= 'style="display:inline-block;"';
      }else{
        $form .= 'style="display:none;"';
      }
      $form .='>
      <div class="x_content">
        <div class="row">
        <div class="col-xs-12 col-md-12">
          <div class="input-group">
            <span class="input-group-addon">Inspección realizada por: </span>';
            /*============================================================
            =            VERIFICAOS SI EXISTE COOKIE GUARDADA            =
            ============================================================*/
        if (isset($_COOKIE["responsablecheck".$rutas[1]])) {
          $valorResponsable = $_COOKIE["responsablecheck".$rutas[1]];
          $estado = "disabled readonly";
        }else{
          $valorResponsable = "";
          $estado = "";
        }
$form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase responsablechecktrans" value="'.$valorResponsable.'" name="">
          </div>        
        </div>
        <div class="col-xs-12 col-md-9">
                    <!--=============================
                    =            TRANSPORTISTA            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Transportista: </span> ';
                  if (isset($rptacheck["transportista"]) && $rptacheck["transportista"] != null) {
                    $valortransportista = $rptacheck["transportista"];
                    $estado = "disabled readonly";
                  }else if (isset($_COOKIE["transportista".$rutas[1]])) {
                    $valortransportista = $_COOKIE["transportista".$rutas[1]];
                    $estado = "";
                  }else{
                    $valortransportista = "";
                    $estado = "";
                  }
      $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase transportista" value="'.$valortransportista.'">
                    </div>
                  </div>                  <div class="col-xs-12 col-md-3">
                    <!--=============================
                    =            PLACA            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Placa: </span>';
                  if (isset($rptacheck["placa"]) && $rptacheck["placa"] != null) {
                    $valorplaca = $rptacheck["placa"];
                    $estado = "disabled readonly";
                  }else if (isset($_COOKIE["placa".$rutas[1]])) {
                    $valorplaca = $_COOKIE["placa".$rutas[1]];
                    $estado = "";
                  }else{
                    $valorplaca = "";
                    $estado = "";
                  }
      $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase placa" value="'.$valorplaca.'">                    </div>
                  </div> 

                  <div class="col-xs-12 col-md-3">
                  <!--=============================
                  =            nguia           =
                  ==============================-->
                  <div class="input-group">
                    <span class="input-group-addon">N° Guias: </span>';
                if ($rptaguia["nguias"] != null) {
                  $valornguia = $rptaguia["nguias"];
                  $estado = "disabled readonly";
                }else if (isset($_COOKIE["nguias".$rutas[1]])) {
                  $valornguia = $_COOKIE["nguias".$rutas[1]];
                  $estado = "";
                }else{
                  $valornguia = "";
                  $estado = "";
                }
        $form .= '<input type="text" '.$estado.' class="form-control input-lg uppercase guias" value="'.$valornguia.'">                    </div>
                </div>
                  <div class="col-xs-12 col-md-6">
                    <div class="input-group">
                      <span class="input-group-addon">Nguias: </span>
                      <input type="text" width="350px" class="form-control input-lg uppercase chguias disabled">
                    </div>
                  </div>

                  <div class="col-md-9 col-xs-12">
                    <!--===============================================
                    =            VERIFICACION DEL INTERIOR            =
                    ================================================-->
                    <fieldset>
                      <legend>Verificación del Interior:</legend>
                      <div class="col-xs-12">
                        <label>1. El vehículo se encuentra en buen estado <i data-toggle="tooltip" title="El techo y las paredes en buen estado, sin ranuras, orificios o pasos de luz que permitan el ingreso de agua lluvia" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="pptl" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="pptl" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>2. El vehículo se encuentre en buenas condiciones de limpieza <i data-toggle="tooltip" title="Sin papeles, cartones, plástico film, tierra acumulada, humedad u óxido que pueda generar suciedad en el producto. Todos los residuos generados en la carga del producto no debe quedar en el interior del vehículo" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline"  style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="pa" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="pa" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>3. El vehículo está libre de residuos de cargas anteriores <i data-toggle="tooltip" title="Como cereales (arroz, avena, maíz, trigo, cebada, etc.),  leguminosas (lenteja, garbanzo, soja, etc.), o restos de otros productos que representen un riesgo de presencia de plaga" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline"  style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="mincom" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="mincom" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>4. El vehículo está libre de plagas <i data-toggle="tooltip" title="Insectos o resto de ellos como grillos, arañas o tela arañas, cucarachas, gorgojos, hormigas, moscas, etc. que pueda generar una contaminación cruzada al producto a cargar o sugiera la presencia de plaga en el producto recibido" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="plaga" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="plaga" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>5. El vehículo está libre de olores fuera de lo normal <i data-toggle="tooltip" title="Como olores de fermentación, descomposición, humedad, pintura, etc" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="oextranios" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="oextranios" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>6. El vehículo está libre de químicos, sustancias o artículos contaminantes <i data-toggle="tooltip" title="Químicos como combustibles, aceites, solventes entre otros y artículos como llanta de emergencia, canecas para combustibles, utensilios de limpieza en uso (escoba, recogedor, etc.)" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="oquimicos" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="oquimicos" id="NO" class="flat">
                          </label>                          
                        </div>
                      </div>
                      <div class="col-xs-12">
                        <label>7. Los sellos de seguridad coinciden con los detallados en la guía o packing list (cuando aplique) <i data-toggle="tooltip" title="Los sellos de seguridad coinciden con los detallados en la guía o packing list (cuando aplique)" class="fas fa-info-circle"></i></label>
                        <div class="checkbox-inline" style="float: right;">
                          <label>
                            Si
                            <input type="radio" name="sellos" id="SI" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No
                            <input type="radio" name="sellos" id="NO" class="flat">
                          </label>
                          <label style="margin-left: 20px;">
                            No Aplica
                            <input type="radio" name="sellos" id="NO APLICA" class="flat">
                          </label>                          
                        </div>
                      </div>                      
                    </fieldset>
                  </div> 
                  <!--===============================================
                  =            OBSERVACIONES ADICIONALES            =
                  ================================================-->
                  <div class="col-xs-12 col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon">Observaciones: </span>';
                  if (isset($_COOKIE["obstransporte".$rutas[1]])) {
                    $valorobservacionesA = $_COOKIE["obstransporte".$rutas[1]];
                  }else{
                    $valorobservacionesA = "";
                  }
                      $form .= '<textarea class="form-control input-lg uppercase obstransporte">'.$valorobservacionesA.'</textarea>
                    </div>
                  </div>

        </div>
              
      </div>
      </div>';

      echo $form; 
      
    }
  ?>


                                  



                      




