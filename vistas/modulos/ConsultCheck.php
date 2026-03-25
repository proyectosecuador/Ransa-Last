<!-- page content -->

<div class="page-title">

  <div class="row">

    <div class="title_left">

      <div class="titlePage">

        <h3>Consulta de Check List Realizados</h3>

      </div>

    </div>

  </div>

  </div>

</div>

<div class="clearfix"></div>
<?php
	if ($_SESSION["perfil"] == "ADMINISTRADOR") {
		echo '<div class="col-xs-12 col-md-6">

				<div align="left">

				    <div class="input-group">

				      <span class="input-group-addon" style="width: 0px;">Fecha: </span>

			            <div class="input-group" style="margin-bottom: 0px;">

			            	<input type="text" name="Fecha_Check" id="myDatepicker2" autocomplete="off" class="form-control input-lg  valorFechaBuscarCheck">		

			                <span data-toggle="modal" data-target=".insert-CCosto" class="input-group-addon btnanadir btnbuscarCheckList" >

			                  <div data-toggle="tooltip" title="Buscar Check List" >

			                 <i class="fas fa-search"></i>

			                 </div>

			                </span>

			            </div>

				    </div>		

				</div>	

			</div>';
	}

?>
<div class="col-xs-12 col-md-6">
	<div align="right">
		<button class="btn btn-success btnCalendarioCheck" data-toggle='modal' data-target='#modalCalendarioCheck'> <i class="fas fa-calendar-check"></i> Check List</button>
	</div>
</div>

<div class="x_panel">

	<div class="x_content">

	    <div class="table-responsive">

	     <table id="ListCheckListE" class="table table-striped table-bordered dt-responsive nowrap">

	        <thead>

	          <tr>

	            <th>Equipo</th>

	            <th>Turno</th>

	            <th>Responsable</th>

	            <th># Novedades</th>

	            <th>Horometro</th>

	            <th>Observaciones</th>

	            <th>Motivo Atraso</th>

	            <th>Estado</th>
	            <?php
	            if ($_SESSION["perfil"] == "ADMINISTRADOR") {
	            	echo '<th>Acciones</th>';
	            }
	            ?>
	            

	          </tr>

	        </thead>

	        <tbody>





	        </tbody>

	    </table>                      

	      

	    </div>	

		

	</div>	

</div>

<!--======================================================================================================
=            SECCION DEL MODAL DEL CALENDARIO DE EQUIPOS QUE NO SE HA REALIZADO EL CHECK LIST            =
=======================================================================================================-->
    <div class="modal fade" id="modalCalendarioCheck" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Calendario de Check List</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
            <div class="col-xs-12 col-md-4">
			    <div class="input-group">
			      <span class="input-group-addon" style="width: 0px;">MES: </span>
		            <div class="input-group" style="margin-bottom: 0px;">
		            	<input type="text" readonly autocomplete="off" name="consultarmesCheck" id="consultarmesCheck" class="form-control input-lg">
		            	<input type="hidden" name="mesconsultServe" value="" id="mesconsultServe" readonly>
		            </div>
			    </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="input-group">
                <label class="input-group-addon">Equipo: </label>
                  <select id="idequipoConsultCheck" data-column="1" class="form-control filterColumn input-lg">
                      <option>Seleccionar una opción</option>
                      <?php
                      /*=====  CONSULTA DE TODOS LOS EQUIPOS  ======*/
                      
						$itemeq = array("codigo" =>  "codigo",

										"idciudad" => "idciudad",

										"estado"  => "estado") ;

						$valoreq = array("codigov" => "%MC%",

										"idciudadv" => $_SESSION["ciudad"],

										"estadov" => 0);                      
                      	$rptaEquipo = ControladorEquipos::ctrConsultarEquipos($valoreq,$itemeq);
                      	for ($i=0; $i < count($rptaEquipo) ; $i++) { 
                      		echo '<option value="'.$rptaEquipo[$i]["idequipomc"].'">'.$rptaEquipo[$i]["codigo"].'</option>';
                      	}
                      ?>

                  </select>
	                <span class="input-group-addon btnConsultaCheckEquipo" >

		                <div data-toggle="tooltip" title="Consultar" >

		                <i class="fas fa-search"></i>

	                 </div>

	                </span>                  
              </div>
            </div>
                        	<div class="clearfix"></div>
            <div class="col-xs-12">

				<div class="x_panel">

					<div class="x_content">

					    <div class="table-responsive">

					     <table id="ConsultaCheckEquipo" class="table table-striped table-bordered dt-responsive nowrap">

					        <thead>

					          <tr>

					          	<th>#</th>

					          	<th>Equipo</th>

					            <th>Fecha</th>

					            <th>Responsable</th>

					            <th>Horometro</th>

					            <th>Justificación</th>

				             	<th>Estado</th>

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
	      </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <!-- <button type="button" class="btn btn-primary btnAnadirIMG">Añadir Imagen</button> -->
        </div>
      </div>
    </div>
</div>
</div>
