<!--=========================================
ENVIAR DOCUMENTOS A USUARIO POR AREA       =
==========================================-->
<!-- page content -->
<div class="page-title">
  <div class="row">
    <div class="title_left">
      <div class="titlePage">
        <h3>Manejo de Equipos MC</h3>
      </div>
    </div>   
  </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 col-xs-12">
    <div class="x_panel">
      <div class="x_title">
          <h2>Filtro</h2>
          <div class="x_content">
            <div class="col-xs-12 col-md-6">
              <div class="input-group">
                <label class="input-group-addon">Recepción Equipo: </label>
                  <select data-column="7" class="form-control filterColumn input-lg">
                      <option value="">Seleccionar una opción</option>
                      <option value="Entregado">Entrega</option>
                      <option value="No Entregado">No Entrega</option>
                  </select>
              </div>
            </div>
            <div class="col-xs-12 col-md-6">
              <div class="input-group">
                <label class="input-group-addon">Equipo: </label>
                  <select data-column="1" class="form-control filterColumn input-lg">
                      <option>Seleccionar una opción</option>
                  </select>
              </div>
            </div> 
            <!-- <div class="col-xs-12 col-md-4">
              <div class="input-group">
                <label class="input-group-addon">Fecha: </label>
                  <select data-column="4" class="form-control filterColumn input-lg">
                      <option>Seleccionar una opción</option>
                  </select>
              </div>
            </div> -->
            <div class="col-xs-12 col-md-4">
              <div class="input-group">
                <label class="input-group-addon">Mes: </label>
                  <select data-column="13" class="form-control filterColumn input-lg">
                      <option>Seleccionar una opción</option>
                  </select>
              </div>
            </div>
            <div class="col-xs-12 col-md-4">
              <div class="input-group">
                <label class="input-group-addon">Semana: </label>
                  <select data-column="12" class="form-control filterColumn input-lg">
                      <option>Seleccionar una opción</option>
                  </select>
              </div>
            </div>
            <div class="col-xs-12 col-md-12">
              <div class="input-group">
                <label class="input-group-addon">Personal: </label>
                  <select data-column="2" class="form-control filterColumn input-lg">
                      <option>Seleccionar una opción</option>
                  </select>
              </div>
            </div>                      
          </div>

        <div class="clearfix"></div>
      </div>
    </div>
  </div>
</div>
<div class="clearfix"></div>
<!--=============================================================
=            PRESENTACION DE TABLA DE USO DE EQUIPOS            =
==============================================================-->
  <div class="table-responsive">
   <table id="TablaOperatividadEQ" class=" table table-striped table-bordered dt-responsive nowrap">
      <thead>
        <tr>
          <th>#</th>
          <th>Equipo</th>
          <th>Solicitante</th>
          <th>Personal</th>
          <th>Bateria usada</th>
          <th>Baterias Asignadas</th>
          <th>Fecha-Hora I.</th>
          <th>Fecha-Hora F.</th>
          <th>Horometro I.</th>
          <th>Horometro F.</th>          
          <th>Horometro Prox.</th>
          <th>Horas T.</th> 
          <th>Carga I.</th>
          <th>Carga F.</th>
          <th>Semana</th>
          <th>Mes</th>
          <th>Ubicación Final</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>


      </tbody>
      <tfoot>
          <tr>
              <th colspan="2" style="text-align:right">Total de Horas Trabajadas:</th>
              <th colspan="9"></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
              <th></th>
          </tr>
      </tfoot>       
  </table>                      
    
  </div>