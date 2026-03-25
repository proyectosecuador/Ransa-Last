<!--=========================================
BLOQUE DE RECEPCION A RANSA	        =
==========================================-->
<div class="container text-center" id="titulo">
	<!--=========================================
	TITULO DEL FORMULARIO	        =
	==========================================-->
	<div class="tituloMenu">Enviar a Ransa</div>
</div>
<div class="container">
	<div id="tipoEnvio" >
		<div class="subtitulo">
			<label>Tipo de Movimiento:</label>
		</div>
		<div class="forms">
			<label for="rdo1">
			    <input type="radio" id="rdo1" name="radio">
			    <span class="rdo"></span>
			    <span title="Colocar Comentarios">Importación</span>
			</label>
			<label for="rdo2">
				<input type="radio" id="rdo2" name="radio" checked>
				<span class="rdo"></span>
				<span title="Colocar Comentarios">Recepción</span>
			</label>
			<label for="rdo3">
			    <input type="radio" id="rdo3" name="radio">
			    <span class="rdo"></span>
			    <span title="Colocar Comentarios">Despacho</span>
			</label>
		</div>
	</div>
		<!--====================================================
		=            BLOQUE DONDE LLENAN LA INFORMACIÓN            =
		=====================================================-->					
	<div class="row pt-4">
		<div class="col-lg-6 col-md-6 col-sm-6 col-12" >
			<div class=" col-lg-12 col-12 subtitulo">
				<!--====================================================
				=            BLOQUE DE DATOS DE MERCADERIAS            =
				=====================================================-->				
				<label>Datos de la Mercaderia</label>
				<div class="row">
					<div class="col-lg-6">
						<h5 class="">Código</h5>
						<input class="form-control form-control-sm" type="text"name="">
					</div>
					<div class="col-lg-6">
						<h5 class="">Fecha Vencimiento</h5>
						<input id="fechaVencimiento" class="form-control form-control-sm" type="text"name="">
					</div>
					<div class="col-lg-12 pt-lg-2">
						<h5 class="">Descripción</h5>
						<textarea class="form-control"></textarea>
					</div>
					<div class="col-lg-6 pt-lg-2">
						<h5 class="">Lote</h5>
						<input class="form-control form-control-sm" type="text"name="">
					</div>
					<div class="col-lg-6 pt-lg-2">
						<h5 class="">Contenedor</h5>
						<input class="form-control form-control-sm" type="text"name="">
					</div>
					<div class="col-lg-6 pt-lg-2">
						<h5 class="">Cantidad en: <b style="background-color: yellow;">Unidades</b> </h5>
						<input class="form-control form-control-sm" type="text"name="">
					</div>
					<div class="col-lg-6 pt-lg-4 text-center">
						<button class="btn btn-primary">Añadir Código</button>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6">
			<div class="subtitulo">
				<!--====================================================
				=            BLOQUE DE DATOS DEL MOVIMIENTO            =
				=====================================================-->	
				<label>Datos del Movimiento</label>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<h5 class="">Fecha</h5>
					<input class="form-control form-control-sm" type="date"name="">
				</div>
				<div class="col-lg-6">
					<h5 class="">Hora</h5>
					<input id="horaMovimiento" class="form-control form-control-sm" type="text"name="">
				</div>
				<div class="col-lg-6 pt-2">
					<div class="custom-control custom-checkbox pt-2">
						<input type="checkbox" class="custom-control-input" id="cuadrilla" name="example1">
      					<label class="custom-control-label" for="cuadrilla"><h5>Necesito Estibas</h5></label>
    				</div>
					
				</div>
			<div class="subtitulo col-lg-12 pt-3">
				<label>Datos del Transportista</label>
			</div>
				<div class="col-lg-12">
					<h5 class="">Nombre Transportista</h5>
					<input class="form-control form-control-sm" type="text"name="">
				</div>
				<div class="col-lg-6 pt-lg-2">
					<h5 class="">Cédula</h5>
					<input class="form-control form-control-sm" type="text"name="">
				</div>
				<div class="col-lg-6 pt-lg-2">
					<h5 class="">Placa</h5>
					<input class="form-control form-control-sm" type="text"name="">
				</div>
			</div>
		</div>
	</div>
</div>
	<!--====================================================
	=            	TABLA DE MERCADERIAS AÑADIDAS            =
	=====================================================-->
<div class="pt-5">
	<table id="customers">
	  <thead>
	  	<tr>
	  		<th>Código</th>
	  		<th>Fecha Ven.</th>
	  		<th>Descripción</th>
	  		<th>Lote</th>
	  		<th>Contenedor</th>
	  		<th>Cantidad</th>
	  	</tr>
	  </thead>
	  <tbody>
	  	<tr>
	  		<td>Island Trading</td>
		    <td>Helen Bennett</td>
		    <td>UK</td>
		    <td>Ernst Handel</td>
			<td>Roland Mendel</td>
	   		<td>Austria</td>
	  	</tr>
	  </tbody>
	</table>

	</div>
	



