<!-- page content -->

<div class="page-title">

  <div class="row">

    <div class="title_left">

      <div class="titlePage">

        <h3>Listado de Check List Transporte</h3>

      </div>

    </div>

  </div>

  </div>

</div>

<div class="clearfix"></div>


<div class="x_panel">

	<div class="x_content">

	    <div class="table-responsive">

	     <table id="TablaRecepcionC" class="table table-striped table-bordered dt-responsive nowrap">

	        <thead>

	          <tr>

              <th>id</th>  

              <th>Fecha Prog.</th>

	          	<th>Cliente</th>

              <th>N° Guia</th>

	          	<th>Actividad</th>

	            <th>Auditor</th>

	            <th>Acciones</th>

	          </tr>

	        </thead>

	        <tbody>





	        </tbody>

	    </table>                      

	      </div>
	  </div>

	    </div>	

		

	</div>	

</div>

<!--======================================================================
=            MODAL PARA REALIZAR EL CHECK LIST DEL CONTENEDOR            =
=======================================================================-->
    <div class="modal fade btnCheckListTransport" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Check List Transporte</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
                  <div class="col-xs-12 col-md-12">
                    <input type="hidden" id="idrecepcion" name="">
                    <!--=============================
                    =            RESPONSABLE DE INSPECCION            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Inspección realizada por: </span>
                      <input type="text" class="form-control input-lg uppercase responsablechecktrans" name="">
                    </div>
                  </div>                
                  <div class="col-xs-12 col-md-9">
                    <!--=============================
                    =            TRANSPORTISTA            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Transportista: </span> 
                      <input type="text" class="form-control input-lg uppercase transportista">
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-3">
                    <!--=============================
                    =            PLACA            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">Placa: </span> 
                      <input type="text" class="form-control input-lg uppercase placa">
                    </div>
                  </div>
                  <div class="col-xs-12 col-md-12">
                    <!--=============================
                    =            ORIGEN            =
                    ==============================-->
                    <div class="input-group">
                      <span class="input-group-addon">
                        <select id="torigenrecepcion" style="background: transparent;border: none;">
                          <option value="Origen">Origen</option>
                          <option value="Destino">Destino</option>
                        </select>
                      </span>
                      <!-- <span class="input-group-addon">Origen: </span>  -->
                      <input type="text" class="form-control input-lg uppercase detalleorirecep">
                    </div>
                  </div>
                  <div class="col-md-3 col-xs-12">
                    <!--====================================
                    =            TIPO DE UNIDAD            =
                    =====================================-->
                    
                    <fieldset>
                      <legend>Tipo Unidad</legend>
                      <!--=======================================================
                      =            CONSULTA DE LOS TIPOS DE UNIDADES            =
                      ========================================================-->
                      <?php
                        $rptaTtransporte = ControladorTTransporte::ctrConsultarTTransporte("","");

                        for ($i=0; $i < count($rptaTtransporte) ; $i++) { 
                          if ($rptaTtransporte[$i]["estado"] == 1) {
                            echo' <div class="col-xs-12">
                                    <div class="">
                                      <label>
                                        <input type="radio" name="tunidad" class="flat" id="'.$rptaTtransporte[$i]["idtipo_transporte"].'"> '.$rptaTtransporte[$i]["descripcion"].'
                                      </label>
                                    </div>
                                  </div>';
                          }
                        }
                      ?>
                    </fieldset>
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
                        <label>3. El vehículo no contiene residuos de cargas anteriores <i data-toggle="tooltip" title="Como cereales (arroz, avena, maíz, trigo, cebada, etc.),  leguminosas (lenteja, garbanzo, soja, etc.), o restos de otros productos que representen un riesgo de presencia de plaga" class="fas fa-info-circle"></i></label>
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
                        <label>4. El vehículo no contiene plagas <i data-toggle="tooltip" title="Insectos o resto de ellos como grillos, arañas o tela arañas, cucarachas, gorgojos, hormigas, moscas, etc. que pueda generar una contaminación cruzada al producto a cargar o sugiera la presencia de plaga en el producto recibido" class="fas fa-info-circle"></i></label>
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
                        <label>5. El vehículo no contiene olores fuera de lo normal <i data-toggle="tooltip" title="Como olores de fermentación, descomposición, humedad, pintura, etc" class="fas fa-info-circle"></i></label>
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
                        <label>6. El vehículo no contiene químicos, sustancias o artículos contaminantes <i data-toggle="tooltip" title="Químicos como combustibles, aceites, solventes entre otros y artículos como llanta de emergencia, canecas para combustibles, utensilios de limpieza en uso (escoba, recogedor, etc.)" class="fas fa-info-circle"></i></label>
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
                    </fieldset>
                  </div>
                  <!--===============================================
                  =            OBSERVACIONES ADICIONALES            =
                  ================================================-->
                  <div class="col-xs-12 col-md-12">
                    <div class="input-group">
                      <span class="input-group-addon">Observaciones: </span>
                      <textarea class="form-control input-lg uppercase obstransporte"></textarea>
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
        <!--======================================================
        =            FOOTER DEL MODAL DE USO DE EQUIPO            =
        =======================================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary guardarCheckTransporte">Registrar</button>
        </div>
      </div>
    </div>
</div>