<?php
/*============================================
=            CONSULTA DE CIUDADES            =
============================================*/
$rptaciudad = ControladorCiudad::ctrConsultarCiudad("","");
/*===========================================
=            CONSULTA DE EQUIPOS            =
===========================================*/
$rptaEqui = ControladorEquipos::ctrConsultarEquipos($_SESSION["ciudad"],"idciudad");;


 ?>
<div class="page-title">
  <div class="title_left">
    <h3>Indicadores de Equipos</h3>
  </div>
</div>
<div class="clearfix"></div>
<div class="row">
  <div class="col-md-12">
    <div class="">
      <div class="x_content">
<div class="row">
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
  <div class="tile-stats">
  <div class="icon" style="top: 15px"><svg xmlns="http://www.w3.org/2000/svg" width="80" height="50" viewBox="0 3 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" style="width: 71px;height: 71px;margin: 0;padding: 0;">
    <path stroke="none" d="M0 0h24v24H0z"></path>
    <circle cx="5" cy="17" r="2"></circle>
    <circle cx="14" cy="17" r="2"></circle>
    <line x1="7" y1="17" x2="12" y2="17"></line>
    <path d="M3 17v-6h13v6"></path>
    <path d="M5 11v-4h4"></path>
    <path d="M9 11v-6h4l3 6"></path>
    <path d="M22 15h-3v-10"></path>
    <line x1="16" y1="13" x2="19" y2="13"></line>
  </svg>
  </div>
  <div class="count">
    <?php 
    /*=====================================================
    =            PRESENTAR EL TOTAL DE EQUIPOS            =
    =====================================================*/
    $contador = 0;
    if ($_SESSION["perfil"] == "ROOT" || $_SESSION["perfil"] == "COODINADOR" ) {
      for ($i=0; $i < count($rptaEqui) ; $i++) { 
        if (strpos($rptaEqui[$i]["codigo"], "MC") !== false && $rptaEqui[$i]["estado"] != 0 ){
          $contador += 1;
        }
      }
      echo $contador;      
    }else if ($_SESSION["perfil"] == "OPERARIO" || $_SESSION["perfil"] == "ADMINISTRADOR" ) {
      for ($i=0; $i < count($rptaEqui) ; $i++) { 
        if (strpos($rptaEqui[$i]["codigo"], "MC") !== false && $_SESSION["ciudad"] == $rptaEqui[$i]["idciudad"] && $rptaEqui[$i]["estado"] != 0 ){
          $contador += 1;
        }
      }      
      echo $contador;
    }
    ?>  
  </div>
  <h3>Equipos JUNH</h3>
  <p>Equipos en la ciudad de <?php for ($i=0; $i <count($rptaciudad) ; $i++) { 
    echo $rptaciudad[$i]["desc_ciudad"]." ";
  } ?></p>
  </div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
<div class="tile-stats">
<div class="icon"><i class="fa fa-comments-o"></i>
</div>
<div class="count">179</div>
<h3>Novedades</h3>
<p>Novedades Reportadas </p>
</div>
</div>
<div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
<div class="tile-stats">
<div class="icon"><i class="fa fa-sort-amount-desc"></i>
</div>
<div class="count">100%</div>
<h3>Check List</h3>
<p>% de Puntualidad</p>
</div>
</div>
<?php
if ($_SESSION["perfil"] == "ROOT" || $_SESSION["perfil"] == "COORDINADOR") {
  echo '<div class="animated flipInY col-lg-3 col-md-3 col-sm-6  ">
<div class="tile-stats">
<div class="x_title">
<h2>Filtrar<small>x Ciudad</small></h2>
<div class="clearfix"></div>
</div>
<div class="x_content">';
/*============================================================================
=            SECCION DONDE CONSULTA LAS CIUDADES PARA EL FILTRADO            =
============================================================================*/

  for ($i=0; $i < count($rptaciudad) ; $i++) { 
    echo '  <div class="col-sm-6">
    <button id="'.$rptaciudad[$i]["idciudad"].'" class="btn btn-sm btn-default">'.$rptaciudad[$i]["desc_ciudad"].'</button>
  </div>';
  }
echo '</div>
</div>
</div>';
}
?>
</div>
  <div class="x_panel">
    <div class="col-md-4">
      <div id="container"></div> 
    </div>
  <div class="col-md-8">
    <div class="text-center" style="padding-bottom: 15px;">
      <label ><input onclick="chart.categorizedBySeries(true)" class="localizacion" id="gye" type="radio" name="mode" checked>Guayaquil</label>
      <label style="padding-left: 20px;"><input id="uio" class="localizacion" type="radio" name="mode">Quito</label>      
    </div>

<div id="container2"></div>
  </div>     
  </div>
  </div>
 
</div>
</div>
</div>