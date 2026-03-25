/*===============================================
=            VISUALIZAR LAS IMÁGENES            =
===============================================*/
$('#datatableUserClienteSDisensa tbody').on("click", ".visualizar", function() {
    var idProducto = $(this).attr("idProducto");
  
    var datos = new FormData();
    datos.append("IdProducto", idProducto);
  debugger;
    $.ajax({
  
      url: "ajax/productos.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta) {
        debugger;
        var productos = jQuery.parseJSON(respuesta);
        var mostrar = '<div class="col-xs-12 col-md-12">' +
          '<div id="visualProductos" class="flexslider">' +
          '<ul class="slides">' +
          '<li data-thumb="' + productos[0]['foto_portada'] + '">' +
          '<span >'+
          '<a href="' + productos[0]['foto_portada'] + '" target="_blank"><img id="portada"  src="' + productos[0]['foto_portada'] + '" /></a>' +
          '</span>'+
          '<p class="flex-caption">' + productos[0]['descripcion'] + '</p>' +
          '<button type="button"  idimagen = "portada" class="btn btn-primary btngirarLeft"><span class="fa fa-rotate-left"></button>'+
          '<button type="button" idimagen = "portada" class="btn btn-primary btngirarRight"><span class="fa fa-rotate-right"></span></button>'+
          '</li>';
          // console.log(productos[0]['multimedia']);
          if (productos[0]['multimedia'] != null && productos[0]['multimedia'] != "NULL" ){
                  if (productos[0]['multimedia'].length > 0) {
  
                    var multimedia = jQuery.parseJSON(productos[0]['multimedia']);
                    for (var i = 0; i < multimedia.length; i++) {
                      mostrar += '<li data-thumb="' + multimedia[i]['multimedia'] + '">' +
                        '<a href= "'+multimedia[i]['multimedia']+'" target="_blank"><img id="'+i+'" src="' + multimedia[i]['multimedia'] + '" /></a>' +
                        '<p class="flex-caption">' + productos[0]['descripcion'] + '</p>' +
                        '<button type="button" idimagen='+i+' class="btn btn-primary btngirarLeft"><span class="fa fa-rotate-left"></button>'+
                        '<button type="button" idimagen='+i+' class="btn btn-primary btngirarRight"><span class="fa fa-rotate-right"></span></button>'+
                        '</li>';
                    }
                    mostrar += '</ul>' +
                      '</div>' +
                      '</div>';
                  }
  
          }
        Swal.fire({
          title: 'Visualización de Productos',
          width: 400,
          padding: '3em',
          html: mostrar,
          showCloseButton: true
        });
        Carrousel();
        RotarImagenes();
      }
  
    })
  });
  
  /*===================================================
  =            TABLA DE PRODUCTOS CLIENTES            =
  ===================================================*/
  $(".TablaClienteS").DataTable({
  
    "ajax": "ajax/TablaProductosDisensa.ajax.php",
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
  
  })
  