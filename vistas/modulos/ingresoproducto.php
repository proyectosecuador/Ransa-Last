<!--=========================================
CONSOLIDADO INVENTARIO CON IMAGENES	        =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>Registro de Productos Nuevos </h3>
      </div>
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
</div>
<div class="clearfix"></div>

            <div class="row">
              <div class="col-md-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Datos del Producto</h2>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <form method="POST" enctype="multipart/form-data" class="form-horizontal form-label-left input_mask"onsubmit="return registroProducto()">
                        <div class="col-md-12 col-sm-12 col-xs-12 form-group has-feedback">
                            <input type="text" name="cliente" readonly class="form-control has-feedback-left" id="cliente" placeholder="Nombre del Cliente">
                            <span class="fa fa-group form-control-feedback left" aria-hidden="true"></span>
                            <input type="hidden" id="codigo" name="codigo">
                            <input type="hidden" id="idcliente" name="idcliente">
                        </div> 
                      <div class="form-group">
                        <label class="control-labels col-md-1">Código:</label>
                        <div class="col-xs-12 col-md-4">
                          <input type="text" id="npcodigo" name="npcodigo" class="form-control" placeholder="Código">
                        </div>
                        <label class="control-labels col-md-2">Tip. Ubicación:</label>
                        <div class="col-xs-12 col-md-5">
                          <input type="text" id="nptipoubicacion" name="nptipoubicacion" class="form-control" placeholder="Tipo de Ubicación">
                        </div>
                      </div>
                      <div class="form-group">
                      	<label class="control-labels col-md-1">Familia:</label>
                        <div class=" col-xs-12 col-md-5">
                          <input type="text" id="npfamilia" name="npfamilia" class="form-control" placeholder="Familia">
                        </div>
                        <label class="control-labels col-md-1">Grupo:</label>
                        <div class="col-xs-12 col-md-5">
                          <input type="text" id="npgrupo" name="npgrupo" class="form-control" placeholder="Grupo">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-labels col-md-1">Descripción:</label>
                        <div class="col-md-11 col-sm-10 col-xs-12">
                          <input type="text" class="form-control" id="npdescripcion" name="npdescripcion" placeholder="Descripción del producto">
                        </div>
                      </div>
                      <?php
                      $cuentas = json_decode($_SESSION["cuentas"],true);
                      // var_dump($cuentas);
                      for ($i=0; $i < count($cuentas) ; $i++) { 
                        if (in_array("NETAFIN ECUADOR S.A.", $cuentas[$i])) {
                          echo '                      <div class="form-group">
                        <label class="control-labels col-md-1">Descripción Técnica:</label>
                        <div class="col-md-11 col-sm-10 col-xs-12">
                          <textarea class="form-control" id="desctecnica" name="desctecnica" placeholder="Descripción Técnica del Producto"></textarea>
                        </div>
                      </div>';
                        }else{
                          
                        }
                      }
                      ?>
                      	<div class="col-md-12">
	                    	<div class="input-group" id="btnCargar">
	                    		<span class="input-group-addon">
	                    			Selecciona Imagen Principal:
	                    		</span>
	                    		<label class="form-control"> </label>
	                    		<div class="input-group-btn">
	                    			<label class="btn btn-default">
	                    				<span class="fa fa-upload icoCargar"></span><span id="textSubir">Subir Imágen</span><input type="file" id="archiImg" name="archiImg">
	                    			</label>	
	                    		</div>
	                    	</div>
	                    </div>
                      <div id="vischeck" class="col-xs-12">
                            <label>
                              <input type="checkbox" name="checkimgref" id="checkimgref"> ¿Necesita colocar Imagenes adicionales al Producto?
                          </label>
                      </div>
                      <div id="inputref" class="col-md-12">
                        <div class="input-group" id="btnCargarRef">
                          <span class="input-group-addon">
                            Imagenes Referenciales:
                          </span>
                          <label class="form-control"> </label>
                          <div class="input-group-btn">
                            <label class="btn btn-default">
                              <span class="fa fa-upload icoCargar"></span><span id="textSubir">Varias Imagenes</span><input type="file" id="archiImgRef" name="archiImgRef[]" multiple>
                            </label>  
                          </div>
                        </div>
                      </div>
                      <div class="form-group">
                        <div class="text-center">
                          <button type="submit" id="btnGuarProduct" class="btn btn-round btn-success">Guardar Producto</button>
                        </div>
                      </div>
                        <picture  class="text-center ImgPrincipal">
                            
                        </picture>
                        <picture class="ImgMultimedia">
                            
                        </picture>
                        <?php
                          $productnuevo = new ControladorProductos();
                          $productnuevo->ctrIngresoProductos();
                        ?>                      

                    </form>
                  </div>
                </div>
            </div>
        </div>

