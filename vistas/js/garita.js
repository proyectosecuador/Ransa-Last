/*===========================================
=            DATATABLE DE GARITA            =
===========================================*/
var tablaProgramacionGarita = $("#TablaGarita").DataTable({
  "paging":   false,
  "pageLength": 10,
  "language": {

    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst": "Primero",
      "sLast": "Último",
      "sNext": "Siguiente",
      "sPrevious": "Anterior"
    },
    "oAria": {
      "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

  }
});
if (getCookie("ciudadGarita") != ""){
  $("#CiudadGarita").hide();
  $("#DatosTablaGarita").show();
  ConsultarVehiculos(getCookie("ciudadGarita"),getCookie("idlocalizacion"));
}else{
  $("#CiudadGarita").show();
  $("#DatosTablaGarita").hide();
}
/*==============================================
=            SELECCION DE LA CIUDAD            =
==============================================*/
$(".botonCiudad").click(function(){
  var idciudad = $(this).attr("idciudad");

var datos = new FormData();
  datos.append("consultarLocalizacion",idciudad);
  $.ajax({
    data: datos,
    url: rutaOculta + "ajax/garita.ajax.php",
    type: "POST",
    contentType: false,
    processData: false,
    dataType: 'json',
    success: function(respuesta) {
var select = '<div class="text-center">Selecciona el Centro de Distribución<div><select placeholder="Selecciona el CD" id="selectCD" class="swal2-input"><option>Selecciona el CD</option>';
for (var i = 0; i < respuesta.length; i++) {
 select += ' <option value="'+respuesta[i]["idlocalizacion"]+'">'+respuesta[i]["nom_localizacion"]+'</option>';
}
 select += '</select>';

(async () => {

const { value: formValues } = await Swal.fire({
  title: 'Clasificación',
  html:
    select+
    '<div style="padding-top:15px; " class="text-center">Ingresar Contraseña</div><input placeholder="Contraseña" type="password" id="clave" class="swal2-input">',
  focusConfirm: false,
  preConfirm: () => {
    return [
      document.getElementById('selectCD').value,
      document.getElementById('clave').value
    ]
  }
})

if (formValues) {
  setCookie("idlocalizacion",formValues[0],1);
  var datos = new FormData();
    datos.append("ConfirmarGaritaclave",formValues[1]);
    datos.append("idlocalizacion",formValues[0]);
    datos.append("idciudad",idciudad);
    
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/garita.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      dataType: 'json',
      success: function(respuesta) {
        if (respuesta == 2) {
          Swal.fire('Contraseña Incorrecta', '', 'error');
        }else if (respuesta == 3){
          Swal.fire('No existe Usuario registrado en la ciudad', '', 'warning');
        }else {
          setCookie("ciudadGarita",idciudad,1);
          setCookie("usuarioGarita",respuesta["idusuarios_garita"],1);
          $("#idciudad").val(idciudad);
          $("#DatosTablaGarita").show();
          $("#CiudadGarita").hide();
          ConsultarVehiculos(idciudad,formValues[0]);
        }
      }
    });
}

})()



    }
  }); 


})

function ConsultarVehiculos(ciudad,localizacion) {
  tablaProgramacionGarita = $("#TablaGarita").DataTable({
    "dom": 'ip<lf<t>>',
    paging: true,
    stateSave: true,
    searching: true,
    "pageLength": 10,
    "lengthChange": false,
    destroy: true,
    "deferRender": true,
    "processing": true,
    "language": {

      "sProcessing": "Procesando...",
      "sLengthMenu": "Mostrar _MENU_ registros",
      "sZeroRecords": "No se encontraron resultados",
      "sEmptyTable": "Ningún dato disponible en esta tabla",
      "sInfo": "Registros del _START_ al _END_ de un total de _TOTAL_",
      "sInfoEmpty": "Registros del 0 al 0 de un total de 0",
      "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
      "sInfoPostFix": "",
      "sSearch": "Buscar:",
      "sUrl": "",
      "sInfoThousands": ",",
      "sLoadingRecords": "Cargando...",
      "oPaginate": {
        "sFirst": "Primero",
        "sLast": "Último",
        "sNext": "Siguiente",
        "sPrevious": "Anterior"
      },
      "oAria": {
        "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
        "sSortDescending": ": Activar para ordenar la columna de manera descendente"
      }

    },
    "ajax": {
      "method": "POST",
      "url": rutaOculta + "ajax/TablaMovVehiculos.ajax.php",
      "data": {"ciudad": ciudad,
          "localizacion":localizacion
      }
    }
  })
}
/*=====================================================================================
=            BOTON PARA REPORTAR QUE SE HA ANUNCIADO EL VEHICULO EN GARITA            =
=====================================================================================*/
$('#TablaGarita tbody').on("click", ".btnAnunciadoGarita", function() {
  var idmov = $(this).attr("idmov");
  var datos = new FormData();
  datos.append("ConsultConfirmSup", idmov);
  $.ajax({
      url:  rutaOculta+"ajax/estibas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta) {
        console.log(respuesta);
        if (respuesta["estadoAnuncio"] == "ANUNCIADO"){
          tablaProgramacionGarita.ajax.reload(null,false);
          if (respuesta["datosgarita"]["puerta_asignada"]){
            Swal.fire('A la espera de asignación de puerta', '', 'info');  
          }else{
            Swal.fire('Vehiculo ya ha sido Anunciado', '', 'warning');  
          }
          
        }else{
        var textHtml = '';
        if (respuesta["placa"] != ""){
          textHtml += '<div class="col-xs-12 col-md-4">'+
          '<div class="input-group">'+
            '<label class="input-group-addon">Placa: *</label>'+
            '<input type="text" class="form-control uppercase" id="placagarita" name="" value="'+respuesta["placa"]+'">'+
          '</div>'+
        '</div>';  
        }else{
        textHtml += '<div class="col-xs-12 col-md-4">'+
          '<div class="input-group">'+
            '<label class="input-group-addon">Placa: *</label>'+
            '<input type="text" class="form-control uppercase" id="placagarita" name="" value="">'+
          '</div>'+
        '</div>';
        }
        if (respuesta["conductor"] != "") {
          textHtml += '<div class="col-xs-12 col-md-8">'+
            '<div class="input-group">'+
              '<label class="input-group-addon">Chofer: *</label>'+
              '<input type="text" class="form-control uppercase" id="conductorgarita" name="" value="'+respuesta["conductor"]+'">'+
            '</div>'+
          '</div>';
        }else{
          textHtml += '<div class="col-xs-12 col-md-8">'+
            '<div class="input-group">'+
              '<label class="input-group-addon">Chofer: *</label>'+
              '<input type="text" class="form-control uppercase" id="conductorgarita" name="" value="">'+
            '</div>'+
          '</div>';                

        }        
        textHtml += '<input type="hidden" name="" id="idmov_recep_desp" value="'+idmov+'"><div class="">'+
              '<div class="col-xs-12 col-md-4">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Cédula: *</label>'+
                  '<input type="number" class="form-control uppercase" id="cedulagarita" name="" value="">'+
                '</div>'+
              '</div>'+
              '<div class="col-xs-12 col-md-4">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Cta. RANSA: *</label>'+
                  '<input type="text" class="form-control uppercase" id="ctaRgarita" name="" value="">'+
                '</div>'+
              '</div>'+
              '<div class="col-xs-12 col-md-4">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Sellos Entrada: </label>'+
                  '<input type="text" class="form-control uppercase" id="sellogarita" name="" value="">'+
                '</div>'+
              '</div>'+
              '<div class="col-xs-12 col-md-6">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Tipo Vehiculo: *</label>'+
                  '<input type="text" class="form-control uppercase" id="tipovehiculogarita" name="" value="">'+
                '</div>'+
              '</div>'+
              '<div class="col-xs-12 col-md-6">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Cía/Transporte: </label>'+
                  '<input type="text" class="form-control uppercase" id="comp_transpgarita" name="" value="">'+
                '</div>'+
              '</div>'+
              '<div class="col-xs-12 col-md-12">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Autorizado: *</label>'+
                  '<select class="form-control uppercase" id="personaAutoriza">'+
                  '<option value="Escoger">Escoger quién autoriza</option>';
                  for (var i = 0; i < respuesta["Pers_autoriza"].length; i++) {
                    textHtml +=  '<option value="'+respuesta["Pers_autoriza"][i]["idpersonal"]+'">'+respuesta["Pers_autoriza"][i]["nombre"]+'</option>';
                  }
                    
                  textHtml += '</select>'+
                  // '<input type="text"  id="tipovehiculogarita" name="" value="">'+
                '</div>'+
              '</div>'+
              '<div class="col-xs-12 col-md-8">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Guias: </label>'+
                  '<input type="text" class="form-control uppercase" id="guiaentrada" name="" value="">'+
                '</div>'+
              '</div>'+              
           '<div class="col-xs-12 col-md-6">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Ayudante: </label>'+
                  '<input type="text" class="form-control uppercase" id="ayudante" name="" value="">'+
                '</div>'+
              '</div>'+
           '<div class="col-xs-12 col-md-6">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">C.I. Ayudante: </label>'+
                  '<input type="text" class="form-control uppercase" id="ciayudante" name="" value="">'+
                '</div>'+
              '</div>'+ 
           '<div class="col-xs-12 col-md-12">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Observaciones: </label>'+
                  '<textarea class="form-control uppercase" id="observIngreso"></textarea>'+
                '</div>'+
              '</div>'+ 
           '<div class="col-xs-12 col-md-2">'+
                '<button id="btnAsigPuerta" class="btn btn-primary">Asignar Puerta</button>'+
              '</div>'+
           '<div id="contPuerta" class="col-xs-12 col-md-10">'+
              '</div>'+
                        '</div>';
            Swal.fire({
              title: '<strong>Registro de Vehiculos Anunciado</strong>',
              // icon: 'info',
              html: textHtml,
              width: 900,
              showCloseButton: false,
              showCancelButton: true,
              focusConfirm: true,
              confirmButtonText:
                'Guardar',
              cancelButtonText:
                'Cancelar',
              preConfirm: () => {
                  let placagarita = document.getElementById('placagarita').value
                  let conductorgarita = document.getElementById('conductorgarita').value
                  let cedulagarita = document.getElementById('cedulagarita').value
                  let ctaRgarita = document.getElementById('ctaRgarita').value
                  let tipovehiculogarita = document.getElementById('tipovehiculogarita').value
                  let personaAutoriza = document.getElementById('personaAutoriza').value
                  let numPuerta = document.getElementById('NumPuerta')

                  if (placagarita == "" || conductorgarita == "" || cedulagarita == "" || ctaRgarita == "" || tipovehiculogarita == "" || personaAutoriza == "Escoger"){
                    Swal.showValidationMessage(`Completar los campos Obligatorios (*)`)
                  }
                  if (numPuerta != null && numPuerta.value == "") {
                    Swal.showValidationMessage(`Completar los campos Obligatorios (*)`);
                  }
              },
              didOpen: () => {
                const content = Swal.getHtmlContainer()
                const $ = content.querySelector.bind(content)
                const btnAsignar = $('#btnAsigPuerta')
                let contAsigPuerta = document.getElementById('contPuerta');
                let inputPuerta = document.createElement("input");
                // contAsigPuerta.innerHTML = "";
                btnAsignar.addEventListener('click', () => {

                  inputPuerta.className = "form-control";
                  inputPuerta.placeholder = "Colocar la número de puerta (obligatorio)";
                  inputPuerta.id = "NumPuerta";
                  // console.log(contAsigPuerta.innerHTML);
                  if (contAsigPuerta.innerHTML != ""){
                    inputPuerta.remove();
                  }else{
                    contAsigPuerta.appendChild(inputPuerta);  
                  }
                  

                })          


              }
            }).then((result) => {
              if (result.isConfirmed) {
                debugger;
                var idmov_recep_desp = $("#idmov_recep_desp").val();
                var placagarita = $("#placagarita").val();
                var conductorgarita = $("#conductorgarita").val();
                var cedulagarita = $("#cedulagarita").val();
                var ctaRgarita = $("#ctaRgarita").val();
                var sellogarita = $("#sellogarita").val();
                var tipovehiculogarita = $("#tipovehiculogarita").val();
                var comp_transpgarita = $("#comp_transpgarita").val();
                var personaAutoriza = $("#personaAutoriza").val();
                var ayudante = $("#ayudante").val();
                var ciayudante = $("#ciayudante").val();
                var observIngreso = $("#observIngreso").val();
                var guiaentrada = $("#guiaentrada").val();
                let numPuerta = document.getElementById('NumPuerta')
                
                  var datos = new FormData();
                    datos.append("anuncioplacagarita",placagarita);
                    datos.append("idmov",idmov_recep_desp);
                    datos.append("conductorgarita",conductorgarita);
                    datos.append("cedulagarita",cedulagarita);
                    datos.append("ctaRgarita",ctaRgarita);
                    datos.append("sellogarita",sellogarita);
                    datos.append("tipovehiculogarita",tipovehiculogarita);
                    datos.append("comp_transpgarita",comp_transpgarita);
                    datos.append("personaAutoriza",personaAutoriza);
                    datos.append("ayudante",ayudante);
                    datos.append("ciayudante",ciayudante);
                    datos.append("observIngreso",observIngreso);
                    datos.append("guiaentrada",guiaentrada);
                    if (numPuerta != null && numPuerta.value != "") {
                      datos.append("numPuerta",numPuerta.value);
                    }
                    
                    
                    $.ajax({
                      data: datos,
                      url: rutaOculta + "ajax/garita.ajax.php",
                      type: "POST",
                      contentType: false,
                      processData: false,
                      success: function(respuesta) {
                        if (respuesta == 1) {
                          tablaProgramacionGarita.ajax.reload(null,false);
                          Swal.fire('Vehiculo Anunciado Correctamente', '', 'success');
                        }
                      }
                    });
              }
            })
        }
      }
  });
})
/*===============================================
=            ASIGNAR PUERTA REGISTRO            =
===============================================*/
$("#btnAsigPuertaR").click(function(){
let contAsigPuerta = document.getElementById('contPuertaR');
let inputPuerta = document.createElement("input");
    inputPuerta.className = "form-control";
    inputPuerta.placeholder = "Colocar la número de puerta (obligatorio)";
    inputPuerta.id = "NumPuertaR";
    console.log(contAsigPuerta.innerHTML);
    if (contAsigPuerta.innerHTML != ""){
      var remo = document.getElementById("contPuertaR").firstChild;
      remo.remove();
    }else{
      contAsigPuerta.appendChild(inputPuerta);  
    } 

})
/*=========================================================
=            BOTON DE REGISTRAR NUEVO VEHICULO            =
=========================================================*/
$(".RegVehiculo").click(function(){
    let placagarita = document.getElementById('placagaritaR').value
    let conductorgarita = document.getElementById('conductorgaritaR').value
    let cedulagarita = document.getElementById('cedulagaritaR').value
    let ctaRgarita = document.getElementById('ctaRgaritaR').value
    let tipovehiculogarita = document.getElementById('tipovehiculogaritaR').value
    let personaAutoriza = document.getElementById('personaAutorizaR').value
    let sellogarita = document.getElementById('sellogaritaR').value
    let comp_transpgarita = document.getElementById('comp_transpgaritaR').value
    let ayudante = document.getElementById('ayudanteR').value
    let clientevehiculoR = document.getElementById('clientevehiculoR').value
    let ciayudante = document.getElementById('ciayudanteR').value
    let observIngreso = document.getElementById('observIngresoR').value
    let guiaentrada = document.getElementById('guiaentradaR').value
    let numPuerta = document.getElementById('NumPuertaR')

    var resulta = true;
    if (placagarita == "" || conductorgarita == "" || cedulagarita == "" || ctaRgarita == "" || tipovehiculogarita == "" || personaAutoriza == "Escoger" ||clientevehiculoR == "Selecciona"){
      $(".msjError").html('<div class="alert alert-danger alert-dismissible">'+
                          '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                          '<strong>Error!</strong> Completar los campos obligatorios (*).'+
                        '</div>')
      resulta = false;
    }
    if (numPuerta != null && numPuerta.value == "") {
      $(".msjError").html('<div class="alert alert-danger alert-dismissible">'+
                          '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                          '<strong>Error!</strong> Completar los campos obligatorios (*).'+
                          '</div>')
      resulta = false;
    }

    if (resulta){
      var datos = new FormData();
      datos.append("registrovehiculoplaca",placagarita);
      datos.append("idcliente",clientevehiculoR);
      datos.append("conductorgarita",conductorgarita);
      datos.append("cedulagarita",cedulagarita);
      datos.append("ctaRgarita",ctaRgarita);
      datos.append("sellogarita",sellogarita);
      datos.append("tipovehiculogarita",tipovehiculogarita);
      datos.append("comp_transpgarita",comp_transpgarita);
      datos.append("personaAutoriza",personaAutoriza);
      datos.append("ayudante",ayudante);
      datos.append("ciayudante",ciayudante);
      datos.append("observIngreso",observIngreso);
      datos.append("guiaentrada",guiaentrada);
      if (numPuerta != null && numPuerta.value != "") {
        datos.append("numPuerta",numPuerta.value);
      }

      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/garita.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function(respuesta) {
          if (respuesta == 1) {
            tablaProgramacionGarita.ajax.reload(null,false);
            Swal.fire('Vehiculo Registrado Correctamente', '', 'success');
            $("#placagaritaR").val("");
            $("#conductorgaritaR").val("");
            $("#cedulagaritaR").val("");
            $("#ctaRgaritaR").val("");
            $("#tipovehiculogaritaR").val("");
            $("#personaAutorizaR").val("Escoger");
            $("#sellogaritaR").val("");
            $("#comp_transpgaritaR").val("");
            $("#ayudanteR").val("");
            $("#clientevehiculoR").val("Selecciona");
            $("#ciayudanteR").val("");
            $("#observIngresoR").val("");
            $("#guiaentradaR").val("");
            $('#modalVehiculoNoProg').modal('hide');
          }          

        }
      });



    }
})
/*================================================================================
=            TABLA DE VEHICULOS POR CONFIRMAR Y ANUNCIADOS POR GARITA            =
================================================================================*/
var tablaVehiculoPend = $("#TablaVehiculoNoProg").DataTable({
  initComplete: function(){
    $("#cantNOProg").html(this.api().data().length);
  },
  stateSave: true,
  "ajax": "ajax/TablaVehiculoNoProg.ajax.php",
  "paging":   false,
  "pageLength": 10,
  "language": {

    "sProcessing": "Procesando...",
    "sLengthMenu": "Mostrar _MENU_ registros",
    "sZeroRecords": "No se encontraron resultados",
    "sEmptyTable": "Ningún dato disponible en esta tabla",
    "sInfo": "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    "sInfoEmpty": "Mostrando registros del 0 al 0 de un total de 0",
    "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
    "sInfoPostFix": "",
    "sSearch": "Buscar:",
    "sUrl": "",
    "sInfoThousands": ",",
    "sLoadingRecords": "Cargando...",
    "oPaginate": {
      "sFirst": "Primero",
      "sLast": "Último",
      "sNext": "Siguiente",
      "sPrevious": "Anterior"
    },
    "oAria": {
      "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
    }

  }
});
/*====================================================================================
=            COMPLETAR LA INFORMACION DEL VEHICULO QUE A REPORTADO GARITA            =
====================================================================================*/
$('#TablaVehiculoNoProg tbody').on("click", ".btnCompleteDatos", function() {
  var idMov = $(this).attr("idmov_recep_desp");
  var datos = new FormData();
  datos.append("ConsultConfirmSup", idMov);
  $.ajax({
      url:  rutaOculta+"ajax/estibas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta) {
        if (respuesta["idactividad"] != null){
          Swal.fire('Los Datos ya han sido completados', '', 'success');
          tablaVehiculoPend.ajax.reload(null,false);
        }else{
          $("#modalDatosComplete").modal();
          $("#idmovimiento").val(idMov);
          if (respuesta["datosgarita"]["puerta_asignada"] == "" || respuesta["datosgarita"]["puerta_asignada"] == null) {
            $("#numpuerta").val(respuesta["datosgarita"]["puerta_asignada"]);
            $("#numpuerta").removeAttr("readonly");
          }else{
            $("#numpuerta").val(respuesta["datosgarita"]["puerta_asignada"]);
            $("#numpuerta").attr("readonly","true")            
          }

          // console.log(respuesta);

        }

      }
  });



})
/*=========================================
=            EDITAR EL CLIENTE            =
=========================================*/
$('#TablaVehiculoNoProg tbody').on("click", ".btnEditClient", function() {
  var idMov = $(this).attr("idmov_recep_desp");

  var datos = new FormData();
  datos.append("ConsultConfirmSup", idMov);
  $.ajax({
      url:  rutaOculta+"ajax/estibas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta) {
        html =  '<div class="col-xs-12 col-md-12">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Cliente: *</label>'+
                  '<select class="form-control uppercase" id="editCliente">'+
                  '<option value="Escoger">Escoger el Cliente</option>';
                  for (var i = 0; i < respuesta["listClientes"].length; i++) {
                    if (respuesta["listClientes"][i]["estado"] == 1) {
                      var estado = "";
                        if (respuesta["listClientes"][i]["idcliente"] == respuesta["idcliente"]) {
                          estado = "selected";
                        }
                      html +=  '<option '+estado+' value="'+respuesta["listClientes"][i]["idcliente"]+'">'+respuesta["listClientes"][i]["razonsocial"]+'</option>';  
                    }
                  }
                  html += '</select>'+
                '</div>'+
              '</div>';
            Swal.fire({
              title: '<strong>Modificación del Cliente</strong>',
              // icon: 'info',
              html: html,
              width: 500,
              showCloseButton: false,
              showCancelButton: true,
              focusConfirm: true,
              confirmButtonText:
                'Guardar',
              cancelButtonText:
                'Cancelar',
              preConfirm: () => {
                  let selectCliente = document.getElementById('editCliente').value

                  if (selectCliente == "Escoger"){
                    Swal.showValidationMessage(`Selecciona un cliente para guardar`)
                  }
              },
            }).then((result) => {
              if (result.isConfirmed) {
                var idmov_recep_desp = idMov;
                var idcliente = $("#editCliente").val();                
                  var datos = new FormData();
                    datos.append("editClientAnunGarit",idcliente);
                    datos.append("idmov",idmov_recep_desp);

                    $.ajax({
                      data: datos,
                      url: rutaOculta + "ajax/garita.ajax.php",
                      type: "POST",
                      contentType: false,
                      processData: false,
                      success: function(respuesta) {
                        if (respuesta == "ok") {
                          tablaVehiculoPend.ajax.reload(null,false);
                          Swal.fire('Cliente Modificado Correctamente', '', 'success');
                        }
                      }
                    });
              }
            })
      }
  });


})

/*==============================================================
=            BOTON DE GUARDAR DATOS COMPLEMENTARIOS            =
==============================================================*/
$(".btGDatoComplete").click(function(){
  var idactividad = $("#DCmovimiento").val();
  var idmovimiento = $("#idmovimiento").val();
  var idtipoCarga = $("#DCtipo_carga").val();
  var soliCuadrilla = $("#DCsolicitudCuadrilla").val();
  var comentariosSup = $("#DCcomentarios").val();
  // var numpuerta = $("#numpuerta").val();

  var datos = new FormData();
    datos.append("idactividadDatosComplet",idactividad);
    datos.append("idmovimiento",idmovimiento);
    datos.append("idtipoCarga",idtipoCarga);
    datos.append("soliCuadrilla",soliCuadrilla);
    datos.append("comentariosSup",comentariosSup);
    // datos.append("numpuerta",numpuerta);

    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/garita.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
        if (respuesta == "ok") {
          tablaVehiculoPend.ajax.reload(null,false);
          $("#modalDatosComplete").modal('hide');
          $("#DCmovimiento").val("");
          $("#idmovimiento").val("");
          $("#DCtipo_carga").val("");
          $("#DCsolicitudCuadrilla").val("");
          $("#DCcomentarios").val("");
          Swal.fire('Datos Registrados Correctamente', '', 'success');
        }
      }
    });  

})
/*=============================================
=            ASIGNAR PUERTA GARITA            =
=============================================*/
$('#TablaGarita tbody').on("click", ".AsignarPuerta", function() {
  var idgarita = $(this).attr("idgarita");
  (async () => {
const { value: numPuerta } = await Swal.fire({
    title: 'Asignación de Puerta',
    input: 'text',
    width: 300,
    focusConfirm: true,
    inputPlaceholder: 'Número de Puerta',
    confirmButtonText:
      'Guardar',
    inputValidator: (value) => {
      if (!value) {
        return 'Ingrese a Puerta asignada!'
      }
    }
  })

if (numPuerta){
  var datos = new FormData();
    datos.append("idgaritapuerta",idgarita);
    datos.append("numPuerta",numPuerta);

    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/garita.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
        if (respuesta == "ok") {
          tablaProgramacionGarita.ajax.reload(null,false);
          Swal.fire('Puerta asignada correctamente', '', 'success');
        }
      }
    });   

}
})()
})

/*=========================================================================
=            SALIDA DEL VEHICULO DE LAS INSTALACIONES DE RANSA            =
=========================================================================*/
$('#TablaGarita tbody').on("click", ".SalidaVehiculo", function() {
  var idMov = $(this).attr("idgarita");
  var html = '<div class="col-xs-12 col-md-12">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Guia Salida:</label>'+
                  '<input type="text" class="form-control" name="" id="guiasalida">'+
                '</div>'+
              '</div>'+
              '<div class="col-xs-12 col-md-12">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Sellos Salida:</label>'+
                  '<input type="text" class="form-control" name="" id="sellosalida">'+
                '</div>'+
              '</div>'+
              '<div class="col-xs-12 col-md-12">'+
                '<div class="input-group">'+
                  '<label class="input-group-addon">Observaciones:</label>'+
                  '<textarea class="form-control" id="obssalida" ></textarea>'+
                '</div>'+
              '</div>';
  Swal.fire({
    title: '<strong>Salida del vehiculo</strong>',
    // icon: 'info',
    html: html,
    width: 500,
    showCloseButton: false,
    showCancelButton: true,
    focusConfirm: true,
    confirmButtonText:
      'Guardar',
    cancelButtonText:
      'Cancelar',
  }).then((result) => {
      if (result.isConfirmed) {
        var guiasalida = $("#guiasalida").val();
        var sellosalida = $("#sellosalida").val();
        var obssalida = $("#obssalida").val();
          var datos = new FormData();
            datos.append("guiasalida",guiasalida);
            datos.append("sellosalida",sellosalida);
            datos.append("obssalida",obssalida);
            datos.append("idmov",idMov);

            $.ajax({
              data: datos,
              url: rutaOculta + "ajax/garita.ajax.php",
              type: "POST",
              contentType: false,
              processData: false,
              success: function(respuesta) {
                if (respuesta == "ok") {
                  tablaProgramacionGarita.ajax.reload(null,false);
                  Swal.fire('Se ha reportado la salida de vehiculo', '', 'success');
                }
              }
            });
      }
    })

})









