<!--===================================================
=            BLOQUE PARA CARGAR INVENTARIO            =
====================================================-->
<!-- page content -->
            <div class="page-title">
              <div class="row">
                <div class="title_left">
                <h3>Organizar Archivo Spool </h3>
              </div>
              <div class="title_right col-xs-12">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="pull-right">
                      <button id="selecCliente" type="button" class="btn btn-success btn-sm">Selecciona Cliente</button>
                  </div>
                </div>
              </div>
              </div>
            </div>

            <div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Escoge el archivo</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!--<li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>-->
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <p>Selecciona un archivo de texto ".txt" para darle una estructura al inventario y descargarlo en formato ".xls".</p>
                    <form method="POST" enctype="multipart/form-data" id="formspool">
                    	<div class="form-horizontal">
                    		<div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
		                        <input type="text" readonly class="form-control has-feedback-left" id="codigo" name="codigo" placeholder="Código">
		                   	    <span class="fa fa-code form-control-feedback left" aria-hidden="true"></span>
		                    </div>
		                    <div class="col-md-6 col-sm-6 col-xs-12 form-group has-feedback">
		                        <input type="text" name="cliente" readonly class="form-control has-feedback-left" id="cliente" placeholder="Cliente">
		                   	    <span class="fa fa-group form-control-feedback left" aria-hidden="true"></span>
		                    </div>                    		
                    	</div>
	                    <div class="col-md-12">
	                    	<div class="input-group" id="btnCargar">
	                    		<span class="input-group-addon">
	                    			Selecciona un archivo de texto:
	                    		</span>
	                    		<label class="form-control"> </label>
	                    		<div class="input-group-btn">
	                    			<label class="btn btn-default">
	                    				<span class="fa fa-upload icoCargar"></span><span id="textSubir">Subir Inventario</span><input type="file" id="archiInvent" name="archiInvent">
	                    			</label>	
	                    		</div>
	                    	</div>
	                    </div>
                    <button type="button" id="btnConvertir" class="btn btn-round btn-success">Convertir</button>
                    <div id="noti" class="col-xs-12">
                    </div>
                    </form>
                    </div>
                  </div>
                </div>
              </div>
             <div id="conte_loading" class="conte_loading">
                <div id="cont_gif" >
                  <img src="<?php echo $url.'vistas/img/plantilla/Ripple-1s-200px.gif'?>">
                </div>
              </div>              
              <div id="gif"></div>              
              <div id="tText"> </div>