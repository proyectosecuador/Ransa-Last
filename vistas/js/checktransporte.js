/*=====================================================================
=            TABLA DE LISTADO DE CHECK DE TRANSPPORTE            =
=====================================================================*/
$("#TablaRecepcionC").DataTable({
  "ajax": "ajax/TablaCheckTransporte.ajax.php",
  paging: true,
  searching: true,
  "deferRender": true,
  "retrieve": true,
  "processing": true,
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
/*==============================================================================================
=            BOTON SALTAR CHECK LIST CUENTA DEL PORTAL POR LA CANTIDAD DE VEHICULOS            =
==============================================================================================*/
$(".SaltarCheckTrans").click(function(){
  debugger;
  var idmov = $("#idrecepcion").val();
  var responsablechecktrans = $(".responsablechecktrans").val();
  var actividad = $(".actividad").val();
  if (actividad == "RECEPCION"){
    rutaactividad = "RECEPCION";
    valorEstado = 3;
  }else if (actividad == "REPALETIZADO" || actividad == "X_Hora"){
    valorEstado = 48;
    // if (soliCuadrilla == "SI"){
    //   valorEstado = 4;
    // }else{
    //   valorEstado = 8;
    // }
  }else{
    rutaactividad = "DESPACHO";
    valorEstado = 3;
  }  
  if (responsablechecktrans != ""){
      var datos = new FormData();
      datos.append("SaltarCheck", idmov );
      datos.append("responsablecheck", responsablechecktrans );

      $.ajax({ 
      url: rutaOculta+"ajax/estibas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta) {
        if (respuesta == 1) {
          // Swal.fire({
          //   title: 'Check List Transporte',
          //   text: "Se ha realizado la acción de omitir check list de Transporte",
          //   type: 'success',
          //   confirmButtonText: 'Aceptar'
          // });
          setCookie("Img"+idmov,"Finalizar Cookie",-24);
          setCookie("obstransporte"+idmov,"Finalizar Cookie",-24);
          setCookie("transportista"+idmov,"Finalizar Cookie",-24);
          setCookie("responsablecheck"+idmov,"Finalizar Cookie",-24);
          setCookie("placa"+idmov,"Finalizar Cookie",-24);
          setCookie("Img"+idmov,"Finalizar Cookie",-24);
          setCookie("cantImg"+idmov,"Finalizar Cookie",-24);
          setCookie("btnAvanza"+idmov,"Finalizar Cookie",-24);

          localStorage.removeItem("Img"+idmov);
          localStorage.removeItem("window"+idmov);
          window.opener.location.reload();
          window.close();
        }

      }
  })
  }else{
        Swal.fire({
          title: 'Datos por Completar',
          text: "Por favor colocar el responsable de realizar la actividad..",
          type: 'info',
          confirmButtonText: 'Aceptar'
        });  
  }

})


