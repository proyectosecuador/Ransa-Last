<body style="background: #ffffff;">
<form method="POST">
<div class="text-center">
  <?php 
    $url = Ruta::ctrRuta();
   ?>
  <div>
    <a href="inicio" class="site_title"><img style="width: 250px;" src="<?php echo $url?>vistas/img/plantilla/logotipo.png"></a>
  </div>
  <div class="titulos">
    <h1>Consulta de Solicitudes</h1>
    <!-- <h4>Ingresa el código notificado por correo </h4>     -->
  </div>
  <div class="input-group-addon">
    <input class="form-control-static" name="codigoSQR" type="text" name="">  
    <button type="" class="btn btn-info btn-lg">Buscar <i class="fas fa-search"></i></button>
    <!-- <button type="button" id="redireccionar">Redireccionar</button> -->
  </div>
	
</div>
</form>
<?php
if (!empty($_POST)) {
	if (isset($_POST["codigoSolicitud"]) && $_POST["codigoSolicitud"] != "") {

	}else{
		/*==================================================================
		=            MENSAJE DE QUE EL CAMPO SE ENCUENTRA VACIO            =
		==================================================================*/
		echo '<script>
			      Swal.fire({
			        title: "Es necesario ingresar el código",
			        type: "info",
			        confirmButtonText: "Aceptar"
			      });  		
			 </script>';
	}
}


?>
  </div>

<!--===============================================
=            BOTONES Hoverable Sidenav            =
================================================-->

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
<!--=====================================================
=            CUERPO DE PRESENTACION DE DATOS            =
======================================================-->
<div class="x_panel">
  <div class="x_content">
    <div class="col-md-3">
      <div class="input-group">
        <span class="input-group-addon">Fecha Registro: </span>
        <label class="form-control text-center"><?php echo '' ?> </label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="input-group">
        <span class="input-group-addon">Tipo Novedad: </span>
        <label class="form-control text-center">Queja</label>
      </div>
    </div>
    <div class="col-md-3">
      <div class="input-group">
        <span class="input-group-addon">Código: </span>
        <label class="form-control text-center">smfnsdj</label>
      </div>
  </div>
  <div class="col-md-3">
    <div class="input-group">
      <span class="input-group-addon">Fecha novedad: </span>
      <label class="form-control text-center">2021-05-20</label>
    </div>
  </div>

</div>
  <div class="pull-right">
    developed by Douglas Borbor
  </div>
  <div class="clearfix"></div>
</body>