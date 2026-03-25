<div class="page-title">

  <div class="row">

    <div class="title_left">

      <div class="titlePage">

        <h3>Listado de Novedades Reportadas</h3>

      </div>

    </div>

  </div>

  </div>
<div id="cuadroItem" class="cuadroItem">
<div class="x_panel" >
	<div class="x_content">
		<div id="ItemProceso" class="view-horizontal">
			<ul class="view-steps anchor">
				<li>
					<a class="selview-horizontalectedd" href="javascript:Registro()">
						<span class="itemno">1</span>
						<span>Registro</span>
					</a>
				</li>
				<li>
					<a href="javascript:Clasificacion()">
						<span class="itemno">2</span>
						<span>Clasificación</span>
					</a>
				</li>				
				<li>
					<a href="javascript:Investigacion()">
						<span class="itemno">3</span>
						<span>Investigación</span>
					</a>
				</li>
				<li>
					<a href="javascript:Respuesta()">
						<span class="itemno">4</span>
						<span>Respuesta al Cliente</span>
					</a>
				</li>
				<li>
					<a href="javascript:Seguimiento()">
						<span class="itemno">5</span>
						<span>Seguimiento</span>
					</a>
				</li>
			</ul>			
			
		</div>
		
	</div>
	
</div>
</div>

<div class="x_panel contenidoCuadro">
	<div class="x_content">
	    <div class="table-responsive">
      <div>
        <button class="btn-sm btn-info btnElimFilQR">Eliminar Filtros</button>
      </div>
      
	     <table id="SolQR" class="table table-striped table-bordered nowrap">

	        <thead>

	          <tr>

	          	<th># Solicitud</th>

	            <th>Fecha Registro</th>

	            <th>Tipo Novedad</th>

	            <th>Fecha Novedad</th>

	            <th>Reportado por</th>

	            <th>Teléfono - Celular</th>

	            <th>Organzación</th>

             	<th>Detalle Novedad</th>

             	<th>Servicio(s)</th>

             	<th>Documento adjunto</th>

             	<!-- <th>Negocio Responsable</th> -->

             	<th>acciones</th>

             	<th>estado</th>

	          </tr>

	        </thead>

	        <tbody>





	        </tbody>

	    </table>                      

	      </div>		
		
	</div>
</div>



<!--==========================================================================
=            SECCION MODAL PARA ASIGNAR LOS USUARIOS RESPONSABLES            =
===========================================================================-->
    <div class="modal fade" id="modalNegocioResponsable" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Clasificación</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
            <div class="col-md-12 " align="center">
            		<input type="hidden" id="idsoliciudes" name="">
                <div class="col-md-12 msjestadoresponsable">
                  
                </div>
                <h2>Selecciona el Usuario Responsable para respuesta Cliente</h2>
            		<select class="form-control" multiple="multiple" id="UsuaiosxNegocio">
                <?php
            	           /*======================================================
            			=            CONSULTAMOS LOS SERVICOS RANSA            =
            			======================================================*/
            			$rptaServicios = ControladorServiciosRansa::ctrConsultarServiciosRansa("","");
            			for ($i=0; $i <count($rptaServicios) ; $i++) {
            				echo '<optgroup label="'.$rptaServicios[$i]["nombre"].'">';
            				$rptaResponsables = ControladorUserResponsable::ctrConsultarUserResponsable("idservicioransa",$rptaServicios[$i]["idservicioransa"]);
            					for ($j=0; $j < count($rptaResponsables) ; $j++) {
            						$rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaResponsables[$j]["idusuario"]);
            						$rptaCiudad = ControladorCiudad::ctrConsultarCiudad("idciudad",$rptaUsuarios["idciudad"]);
		                    $nombre = explode(" ", $rptaUsuarios["primernombre"]);
		                    $apellido = explode(" ", $rptaUsuarios["primerapellido"]);            						
            						echo '<option value="'.$rptaUsuarios["id"].'" data-toggle="tooltip" title="'.$rptaCiudad["desc_ciudad"]." - ".$rptaResponsables[$j]["title"].'" data-placement="left">'.$nombre[0]." ".$apellido[0].'</option>';
            					}
            				echo '</optgroup>';
            			}
            			?>   	
            		</select>
            	</div>  
              <div class="col-md-12" align="center" style="margin-bottom: 10px;">
                <h2>Ejecutivo de Negocio quién conversará con el Cliente</h2>
                <div class="col-md-6">
                <select class="form-control" id="ejecutivoNegocio">
                  <option value="">Selecciona una opción</option>
                  <?php
                    /*============================================================================
                    =            CONSULTAMOS LOS USUARIOS QUE SON DEL AREA DE CALIDAD          =
                    ============================================================================*/
                    $rptaUsuariosNego = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","","");
                    for ($i=0; $i < count($rptaUsuariosNego) ; $i++) { // Recorremos todos los usuarios 
                      $modulos = json_decode($rptaUsuariosNego[$i]["idmodulos"],true);
                      for ($j=0; $j < count($modulos) ; $j++) {
                        $rptaArea = ControladorAreas::ctrConsultarAreas("idarea",$rptaUsuariosNego[$i]["idareas"]);
                        $rptaPortal = ControladorModulosPortal::ctrConsultarModulosPortal($modulos[$j]["idmodulos_portal"],"idmodulos_portal");
                        if ($rptaPortal["nombremodulo"] == "GESTION_Q-R" && $rptaUsuariosNego[$i]["estado"] == 1 && $rptaArea["nombre"] == "NEGOCIO" ) {
                          $nombre = explode(" ", $rptaUsuariosNego[$i]["primernombre"]);
                          $apellido = explode(" ", $rptaUsuariosNego[$i]["primerapellido"]);
                          echo '<option value="'.$rptaUsuariosNego[$i]["id"].'">'.$nombre[0]." ".$apellido[0].'</option>';
                          // $mail->addAddress($rptaUsuariosNego[$i]["email"]);
                        }
                      }
                    }

                  ?>
                </select>
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
          <button type="button" class="btn btn-primary ClasifiRespon">Notificar</button>
        </div>
      </div>
    </div>
</div>
</div>
<!--==========================================================================
=            SECCION MODAL PARA ENVIAR EL DOC DE ANALISIS DE CAUSA            =
===========================================================================-->
    <div class="modal fade" id="modalDocACausas" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Analisis de Causa Raiz</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible fade in">
                  <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                  <strong>NOTA:</strong> Si la novedad reportada no corresponde a su area / proceso por favor hacer click <span class="badge">No me pertenece</span> y envie la repuesta.
                </div>
              </div>
              <div class="col-md-12 msjestado">
                
              </div>
              <div class="col-md-12" align="center">
                <label>
                  <input type="checkbox" name="" id="NPertenece" class="NPertenece"> No me pertenece
                </label>
              </div>              
            	<input type="hidden" id="idsoliciudesDoc" name="">
            	<div class="col-md-12 " align="center">
              	<div class="col-md-12">
              	<div class="input-group" id="btnCargarCausa">
              		<span class="input-group-addon">
              			Selecciona Archivo :
              		</span>
              		<label class="form-control"> </label>
              		<div class="input-group-btn">
              			<label class="btn btn-default">
              				<span class="fa fa-upload icoCargar"></span><span id="textSubir">Cargar Archivo</span><input type="file" id="arcCausaR" name="arcCausaR">
              			</label>	
              		</div>
              	</div>
              </div>
              <div class="col-md-12" style="padding-bottom: 15px;">
              	<label class="control-labels">Comentarios: (opcional)</label>
              	<textarea class="form-control comentCR" placeholder="Comentarios Adicionales"></textarea>
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
          <button type="button" class="btn btn-primary EnviarCr">Enviar</button>
        </div>
      </div>
    </div>
</div>
</div>
<!--==============================================================================
=            MODAL PARA CONFIRMAR EL ANALISIS DE CAUSA RAIZ REALIZADO            =
===============================================================================-->
    <div class="modal fade" id="modalAprobarCR" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Analisis de Causa Raiz</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
            	<input type="hidden" id="idaprobar" name="">
              <input type="hidden" id="detalle_investigacion" name="">
            	<div class="col-md-4 text-center">
            		<button class="btn btn-sm btn-success btnAprobarAnalisis">Aprobar Analisis </button>
            	</div>
              <div class="col-md-4 text-center"> 
                <button class="btn btn-sm btn-success btnReclasificarAnalisis">Re-Clasificar</button>
              </div>
            	<div class="col-md-4 text-center">
            		<button class="btn btn-sm btn-success btnRechazarAnalisis">Revisar</button>
            	</div>
            	<div id="visualizacion_Analisis">
            		
            	</div>
	        </div>
	      </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary EnviarCr">Enviar</button>
        </div>
      </div>
    </div>
</div>
</div>
<!--==================================================================
=            MODAL PARA EDITAR DATOS DE NOVEDAD REPORTADA            =
===================================================================-->
    <div class="modal fade" id="modalDocEdit" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Editar Datos</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <input type="hidden" id="idsoliciudesEdit" name="">
              <div class="col-xs-12 col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">Fecha Registro: </span> 
                  <input type="text" readonly class="form-control input-lg uppercase FechaRegistro">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">N° Solicitud: </span> 
                  <input type="text" readonly  class="form-control input-lg uppercase NSolicitudQR">
                </div>
              </div>              
              <div class="col-xs-12 col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">Fecha Novedad: </span> 
                  <input type="text"  class="form-control input-lg uppercase FechaNovedad">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">Tipo Novedad: </span> 
                  <input type="text"  class="form-control input-lg uppercase TipoNovedad">
                </div>
              </div>
              <div class="col-xs-12 col-md-12">
                <div class="input-group">
                  <span class="input-group-addon">Reportado por: </span> 
                  <input type="text"  class="form-control input-lg uppercase Reportadopor">
                </div>
              </div>
              <div class="col-xs-12 col-md-6">
                <div class="input-group">
                  <span class="input-group-addon">Teléfono: </span> 
                  <input type="text"  class="form-control input-lg uppercase TelefonoQR">
                </div>
              </div>
              <div class="col-xs-12 col-md-12">
                <div class="input-group">
                  <span class="input-group-addon">Organización: </span> 
                  <input type="text"  class="form-control input-lg uppercase OrganizacionQR">
                </div>
              </div>
              <div class="col-xs-12 col-md-12">
                <div class="input-group">
                  <span class="input-group-addon">Detalle Novedad: </span> 
                  <textarea class="form-control input-lg uppercase DetalleNovedadQR"></textarea>
                </div>
              </div>
              <div class="col-md-12 col-xs-12">
              <select class="form-select form-control chosenmultiple" data-placeholder="Escoge una o varias opciones" multiple="multiple" name="selservicio" id="selservicio">
              <?php 
              $servicosRansa = ControladorServiciosRansa::ctrConsultarServiciosRansa("","");
              for ($i=0; $i < count($servicosRansa) ; $i++) { 
                echo '<option value="'.$servicosRansa[$i]["idservicioransa"].'">'.$servicosRansa[$i]["nombre"].'</option>';
              }

              ?>
            </select>
              </div>
              <div class="col-xs-12 col-md-12">
              <fieldset>
                <legend>Seleccion de Negocio</legend>
                <div align="center">
                  <select class="form-control" multiple="multiple" id="UsuaiosxNegocioEdit">
                  <?php
                    /*======================================================
                    =            CONSULTAMOS LOS SERVICOS RANSA            =
                    ======================================================*/
                    $rptaServicios = ControladorServiciosRansa::ctrConsultarServiciosRansa("","");
                    for ($i=0; $i <count($rptaServicios) ; $i++) {
                      echo '<optgroup label="'.$rptaServicios[$i]["nombre"].'">';
                      $rptaResponsables = ControladorUserResponsable::ctrConsultarUserResponsable("idservicioransa",$rptaServicios[$i]["idservicioransa"]);
                        for ($j=0; $j < count($rptaResponsables) ; $j++) {
                          $rptaUsuarios = ControladorUsuarios::ctrMostrarUsuariosRansa("usuariosransa","id",$rptaResponsables[$j]["idusuario"]);
                          $rptaCiudad = ControladorCiudad::ctrConsultarCiudad("idciudad",$rptaUsuarios["idciudad"]);
                          $nombre = explode(" ", $rptaUsuarios["primernombre"]);
                          $apellido = explode(" ", $rptaUsuarios["primerapellido"]);                        
                          echo '<option value="'.$rptaUsuarios["id"].'" data-toggle="tooltip" title="'.$rptaCiudad["desc_ciudad"]." - ".$rptaResponsables[$j]["title"].'" data-placement="left">'.$nombre[0]." ".$apellido[0].'</option>';
                        }
                      echo '</optgroup>';
                    }
                    ?>     
                  </select>
                </div>
              </fieldset>
              </div>
          </div>
        </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary EnviarCr">Enviar</button>
        </div>
      </div>
    </div>
</div>
</div>

<!--========================================================================================================
=            SECCION DONDE SE REDACTA EL CORREO ELECTRONICO PARA ENVIAR LA RESPUESTA AL CLIENTE            =
=========================================================================================================-->
    <!-- compose -->
    <div class="compose col-md-6">
      <div class="compose-header">
        <input type="hidden" id="idsoliciudesEmail" name="">
        <div class="tituloCorreo btn-group">
          Correo Nuevo  
        </div>
        <button type="button" class="close compose-close">
          <span></span>
        </button>
      </div>
      <div class="compose-body">
        <div class="col-md-12">
          <span>Para:</span>
          <input type="text" class="form-control" id="emailpara" name="">
        </div>
      </div>
      <div class="compose-body">
        <div id="alerts"></div>

        <div class="btn-toolbar editor" data-role="editor-toolbar" data-target="#editor">
<!--           <div class="btn-group">
            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font"><i class="fa fa-font"></i><b class="caret"></b></a>
            <ul class="dropdown-menu">
            </ul>
          </div> -->

          <div class="btn-group">
            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Font Size"><i class="fa fa-text-height"></i>&nbsp;<b class="caret"></b></a>
            <ul class="dropdown-menu">
              <li>
                <a data-edit="fontSize 5">
                  <p style="font-size:17px">Enorme</p>
                </a>
              </li>
              <li>
                <a data-edit="fontSize 3">
                  <p style="font-size:14px">Normal</p>
                </a>
              </li>
              <li>
                <a data-edit="fontSize 1">
                  <p style="font-size:11px">Pequeño</p>
                </a>
              </li>
            </ul>
          </div>

          <div class="btn-group">
            <a class="btn" data-edit="bold" title="Bold (Ctrl/Cmd+B)"><i class="fa fa-bold"></i></a>
            <a class="btn" data-edit="italic" title="Italic (Ctrl/Cmd+I)"><i class="fa fa-italic"></i></a>
            <a class="btn" data-edit="strikethrough" title="Strikethrough"><i class="fa fa-strikethrough"></i></a>
            <a class="btn" data-edit="underline" title="Underline (Ctrl/Cmd+U)"><i class="fa fa-underline"></i></a>
          </div>

          <div class="btn-group">
            <a class="btn" data-edit="insertunorderedlist" title="Bullet list"><i class="fa fa-list-ul"></i></a>
            <a class="btn" data-edit="insertorderedlist" title="Number list"><i class="fa fa-list-ol"></i></a>
            <a class="btn" data-edit="outdent" title="Reduce indent (Shift+Tab)"><i class="fa fa-dedent"></i></a>
            <a class="btn" data-edit="indent" title="Indent (Tab)"><i class="fa fa-indent"></i></a>
          </div>

          <div class="btn-group">
            <a class="btn" data-edit="justifyleft" title="Align Left (Ctrl/Cmd+L)"><i class="fa fa-align-left"></i></a>
            <a class="btn" data-edit="justifycenter" title="Center (Ctrl/Cmd+E)"><i class="fa fa-align-center"></i></a>
            <a class="btn" data-edit="justifyright" title="Align Right (Ctrl/Cmd+R)"><i class="fa fa-align-right"></i></a>
            <a class="btn" data-edit="justifyfull" title="Justify (Ctrl/Cmd+J)"><i class="fa fa-align-justify"></i></a>
          </div>

          <div class="btn-group">
            <a class="btn dropdown-toggle" data-toggle="dropdown" title="Hyperlink"><i class="fa fa-link"></i></a>
            <div class="dropdown-menu input-append">
              <input class="span2" placeholder="URL" type="text" data-edit="createLink" />
              <button class="btn" type="button">Agregar</button>
            </div>
            <a class="btn" data-edit="unlink" title="Remove Hyperlink"><i class="fa fa-cut"></i></a>
          </div>

          <div class="btn-group">
            <label>
            <a class="btn" title="Insert picture (or just drag & drop)" id="pictureBtn"><i class="fa fa-picture-o"></i></a>
            <input type="file" data-role="magic-overlay" data-target="#pictureBtn" data-edit="insertImage" /></label>
          </div>

          <div class="btn-group">
            <a class="btn" data-edit="undo" title="Undo (Ctrl/Cmd+Z)"><i class="fa fa-undo"></i></a>
            <a class="btn" data-edit="redo" title="Redo (Ctrl/Cmd+Y)"><i class="fa fa-repeat"></i></a>
          </div>
        </div>

        <div id="editor" class="editor-wrapper"></div>
      </div>

      <div class="compose-footer">
        <button id="sendRespuestaCliente" class="btn btn-sm btn-success" type="button">Enviar</button>
      </div>
    </div>

<!--==========================================================================
=            MODAL PARA OBSERVACIONES DE SEGUIMIENTO AREA DE CALIDAD            =
===========================================================================-->
    <div class="modal fade" id="modalSeguimiento" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registro de Seguimiento</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" id="idsoliciudesSeguiCalidad" name="">
                <h5 class="">Verificación de cumplimiento Corrección y/o planes de acción:</h5>
                <textarea id="observacionesSeguiCalidad" class="form-control" placeholder="Comentarios"></textarea>
              </div>
          </div>
        </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary SeguimientoCalidad">Notificar</button>
        </div>
      </div>
    </div>
</div>
</div>

<!--==========================================================================
=            SECCION MODAL PARA OBSERVACIONES DEL CLIENTE POR PARTE DE NEGOCIO            =
===========================================================================-->
    <div class="modal fade" id="modalSeguimientoNegocio" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registrar Seguimiento</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <div id="ComentCalidad" class="col-md-12">
              </div>
              <div class="col-md-12">
                <input type="hidden" id="idsoliciudesSeguiNegocio" name="">
                <h4 class="">Detalle del seguimiento que se ha realizado en conjunto con el cliente:</h4>
                <textarea id="observacionesSeguiNegocio" class="form-control" placeholder="Comentarios"></textarea>
              </div>
          </div>
        </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary SeguimientoNegocio">Notificar</button>
        </div>
      </div>
    </div>
</div>
</div>
<!--==========================================
=            MODAL DE NEGOCIACION            =
===========================================-->
    <div class="modal fade" id="modalNegociacion" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <!--=======================================
          =            CABECERA DE MODAL            =
          ========================================-->
          
          <div class="modal-header" style="background-color: #4d6a88; color: white;">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Registrar Negociación</h4>
          </div>
          <!--=====================================
          =            CUERPO DE MODAL            =
          ======================================-->
          <div class="modal-body">
            <div class="x-content" style="padding: 15px 15px 0px 0px;">
            <div class="row">
              <div class="col-md-12">
                <input type="hidden" id="idsoliciudesNegociacion" name="">
                <h4 class="">Detalle la reposición económica que se negocia con el cliente:</h4>
                <textarea id="observacionesNegociacion" class="form-control" placeholder="Comentarios"></textarea>
              </div>
          </div>
        </div>
        <!--=========================================
        =            FOOTER DEL MODAL             =
        =============================================-->
        <div class="modal-footer">
          <div class="gif"></div>
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
          <button type="button" class="btn btn-primary Registnegociacion">Notificar</button>
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
<div>
</div>


