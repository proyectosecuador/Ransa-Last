var rutaOculta = $("#rutaOculta").val();

/*=============================================
=            VALIDACION DE ARCHIVO TXT            =
=============================================*/

$('input[name="archiInvent"]').change(function(e){
  // Options will go here
  let fileInvent = $(this);
  let filePath = fileInvent.val();
  var allowedExtensions = /(.txt|.xls|.xlsx)$/i;
  if (!allowedExtensions.exec(filePath)) {
    Swal.fire({
      title: 'Error!',
      text: 'Solamente se aceptan archivo de extensión .txt',
      type: 'error',
      confirmButtonText: 'Aceptar'
    });
    filePath = '';
    return false;
  } else {
    $("#btnCargar .form-control").html(function() {
      return "<div>" + fileInvent.prop('files')[0].name + "</div>";
    });
  }

});

/*===================================================
=           BTN ESCOGER CLIENTE                     =
===================================================*/
$("#selecCliente").click(function() {
  (async () => {

    const {
      value: cod
    } = await Swal.fire({
      title: 'Ingresar el código del Cliente',
      input: 'number',
      inputPlaceholder: 'Ingresa Código'
    })
    var datos = {
      'codigo': cod
    }
    if (cod) {
      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/consultarCliente.ajax.php",
        type: "POST",
        success: function(response) {
          if (response == 1) {
            Swal.fire('El código ' + cod + ' no se encuentra Registrado o es Incorrecto');
          } else if (response == 2) {
            Swal.fire('El código ' + cod + ' se encuentra deshabilitado..');
          } else if (response == false) {
            Swal.fire('No se encuentra Autorizado para usar el Código: ' + cod);
          } else {
            
            var obj = jQuery.parseJSON(response);
            
            $('#codigo').val(cod);
            $('#cliente').val(obj.nombre);
            $('#idcliente').val(obj.idcliente);
            if (window.matchMedia("(max-width:767px)").matches){
              $('#cliente').html("<div class='col-xs-12'>Productos del Cliente: </div><div class='col-xs-12'style='padding-top:10px;'>"+obj.nombre+"</div>");
              $("#Invcliente").html("<div class='col-xs-12'>Productos del Cliente: </div><div class='col-xs-12'style='padding-top:10px;'>"+obj.nombre+"</div>");
              if ($('#cliente').html() != "") {
              $('#cliente').append("&nbsp;<a class='btn btn-default btn-sm col-xs-12' href='javascript:ConsultarProducto()'>Buscar</a>");
              $("#Invcliente").append("&nbsp;<a class='btn btn-default btn-sm col-xs-12' href='javascript:ConsultarInventario()'>Buscar</a>");
              
            }
            }else{
              $('#cliente').parent().removeClass("x_titulo");
              //$('#cliente').parent().addClass("x_title");
              $('#cliente').html("Productos del Cliente:"+obj.nombre);
              $("#Invcliente").html("Inventarios del Cliente: "+obj.nombre);
              if ($('#cliente').html() != "") {
              $('#cliente').append("&nbsp;<a class='btn btn-default btn-sm' href='javascript:ConsultarProducto()'>Buscar</a>");
              $("#Invcliente").append("&nbsp;<a class='btn btn-default btn-sm' href='javascript:ConsultarInventario()'>Buscar</a>");
            }

            }
          }

        }

      });

    }
  })()

});
/*===================================================
=           BTN SUBMIT -ESTRUCTURAR INVENTARIO                     =
===================================================*/

$('#btnConvertir').click(function() {
  fileinvent = $('input[name="archiInvent"]');
  codcliente = $('#cliente');
  if (fileinvent.val() == "") {
    Swal.fire({
      title: 'Selecciona el archivo.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });
  } else if (codcliente.val() == "") {
    Swal.fire({
      title: 'Escoge el Cliente.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });
  } else {
    var formSpool = new FormData(document.getElementById("formspool"));
    var allowedExtensions = /(.xls|.xlsx)$/i;
    if (!allowedExtensions.exec($('input[name="archiInvent"]').val())) {
      $.ajax({
        data: formSpool,
        url: rutaOculta + "ajax/structspool.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('#gif').html('<div id="conte_loading" class="conte_loading">' +
            '<div id="cont_gif" >' +
            '<img src="' + rutaOculta + 'vistas/img/Spin-1s-200px.gif">' +
            '</div>' +
            '</div>').show();
        },
        success: function(response) {
          if (response == 1) {
            $("#gif").html("").hide();
            Swal.fire({
              title: 'El inventario no corresponde al cliente Seleccionado.',
              type: 'info',
              confirmButtonText: 'Aceptar'
            });
          } else {

            $("#gif").html("").hide();
            $("#tText").html(response);
            init_DataTables();
          }

        }

      });      
    }else{
      $.ajax({
        data: formSpool,
        url: rutaOculta + "ajax/inventExcel.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        beforeSend: function() {
          $('#gif').html('<div id="conte_loading" class="conte_loading">' +
            '<div id="cont_gif" >' +
            '<img src="' + rutaOculta + 'vistas/img/Spin-1s-200px.gif">' +
            '</div>' +
            '</div>').show();
        },
        success: function(response) {
          if (response == 1) {
            $("#gif").html("").hide();
            Swal.fire({
              title: 'El inventario no corresponde al cliente Seleccionado.',
              type: 'info',
              confirmButtonText: 'Aceptar'
            });
          } else {
            $("#gif").html("").hide();
            $("#tText").html(response);
            init_DataTables();
          }

        }

      });       



    }



  }
})
/*===============================================================
=            FUNCION PARA VALIDAD CORREO ELECTRONICO            =
===============================================================*/
function validateEmail(email) {
       var regixExp = /^([\w-]+(?:\.[\w-]+)*)@((?:[\w-]+\.)*\w[\w-]{0,66})\.([a-z]{2,6}(?:\.[a-z]{2})?)$/i;
      // $(".reqEmail").css("border","solid 1px red");
       $("#ReceAppEmail").html("Invalid Email!!");
       return regixExp.test(email);
}
/* DATA TABLES */

function init_DataTables() {
  if (typeof($.fn.DataTable) === 'undefined') {
    return;
  }
  console.log('init_DataTables');
  var d = new Date();
  var handleDataTableButtons = function() {
    if ($("#datatableUserRansa").length) {
      $("#datatableUserRansa").DataTable({
        "language": {
          "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
        },
      });
    }

    if ($("#datatable-buttons").length) {
      $("#datatable-buttons").DataTable({
        fixedHeader: true,
        responsive: true,
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
        dom: "Blfrtip",
        buttons: [{
            extend: "csv",
            className: "btn-sm",
            filename: "Inventario" + d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate(),
            exportOptions: {
              columns: ':visible'
            },
            sheetName: "RanInvent" + d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate()
          },
          /*{
              extend: "excel",
              className: "btn-sm",
              filename: "Inventario"+d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate(),
              exportOptions: {
                  columns: ':visible'
              },
              sheetName: "RanInvent"+d.getFullYear()+'-'+(d.getMonth()+1)+'-'+d.getDate()
          },*/
          {
            extend: 'colvis',
            columnText: function(dt, idx, title) {
              return (idx + 1) + ': ' + title;
            },
            className: "btn-sm"
          }, {
            text: "Excel",
            className: "btn-sm",
            action: function(e, dt, node, conf) {
              var file = document.getElementById("archiInvent");
              var formSpool = new FormData(document.getElementById("formspool"));
              formSpool.append("filess", file.files[0]);
              $.ajax({
                data: formSpool,
                type: 'POST',
                contentType: false,
                processData: false,
                url: rutaOculta + "ajax/desInvenStyle.ajax.php",
                success: function(response) {
                  //document.write(response);
                  document.getElementById("formdatoExcel").submit();
                  //window.location.href = "ajax/desInvenStyle.ajax.php";
                }
              });

            }
          },
          {
            text: 'Notificar',
            className: "btn-sm",
            action: function(e,dt,node,conf){
              var btn = $("#noti").html('<label>Correos a notificar, presionar la tecla <span class="badge ">ENTER</span> si son más de uno: </label>'+
                                                  '<input type="text" id="CorreosNoti"name="" data-role="tagsinput">');
              $('#CorreosNoti').tagsinput('destroy');
              $('#CorreosNoti').tagsinput();
              $(".bootstrap-tagsinput").append('<span style="cursor:pointer;" class="pull-right badge btnEnviarNotificacion">Enviar <i class="fas fa-mail-bulk"></i></span>');           
              /*=================================================================================
              =            VERIFICAR QUE LOS ITEM AGREGADOS SON CORREOS ELECTRONICOS            =
              =================================================================================*/
              $('#CorreosNoti').on('beforeItemAdd', function(event) {
                /*=====  VALIDAMOS SI ES CORREO EN CASO DE NO SER CORREO NO SE AGREGA  ======*/
                
                if (!validateEmail(event.item)){
                  event.cancel =true;
                  Swal.fire(
                    'Advertencia',
                    'El formato registrado no corresponde a un correo electrónico',
                    'warning'
                  )                  
                }
              });
              $(".btnEnviarNotificacion").click(function(){
                var sinRepetidos
                dt.columns(4).data().unique().sort().each(function(d){
                  sinRepetidos = d.filter((valor, indiceActual, arreglo) => arreglo.indexOf(valor) === indiceActual);
                })
                var correos = $("#CorreosNoti").tagsinput('items');
                var datosCorrNoti = new FormData();
                datosCorrNoti.append("noticorreos", JSON.stringify(correos));
                datosCorrNoti.append("totalGeneral", dt.columns(0).data().toArray().length);
                datosCorrNoti.append("grupo", JSON.stringify(sinRepetidos));
                datosCorrNoti.append("tabla_data",JSON.stringify(dt.rows().data().toArray()));
                datosCorrNoti.append("cod_Inv",$("[name=codigoarch]").val());
                datosCorrNoti.append("nombre_archivo",$("[name=nombre_archi]").val());
                $.ajax({
                  data: datosCorrNoti,
                  url: rutaOculta + "ajax/notificacionInvent.ajax.php",
                  type: "POST",
                  contentType: false,
                  processData: false,
                  beforeSend: function(){
                     document.getElementById("conte_loading").style.display = "block";
                  },                  
                  success: function(response) {
                    if (response == 1 ){
                      //Swal.fire('Se ha enviado Correctamente la Notficación vía Email');
                      document.getElementById("conte_loading").style.display = "none";
                      window.location = "spool";
                    }else{
                      Swal.fire({
                    icon: 'error',
                    title: 'No fue posible notificar al cliente'
                    })
                    }
                  }

                });                

              })
              
            }
          }

        ]
      });
    }
  };

  TableManageButtons = function() {
    "use strict";
    return {
      init: function() {
        handleDataTableButtons();
      }
    };
  }();
  TableManageButtons.init();
}
/*===============================================================================
=            TABLA DE LISTADO DE INVENTARIOS ENVIADOS A NOTIFICACION            =
===============================================================================*/
$("#TablaListInvent").DataTable({
  "ajax": "ajax/TablaListInventario.ajax.php",
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
function ConsultarInventario() {
  var id = $("#idcliente").val();

  $("#datatableUserRansa").DataTable({
    paging: true,
    searching: true,
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
      "url": rutaOculta + "ajax/TablaListInventario.ajax.php",
      "data": function(d) {
        return $.extend({}, d, {
          "idcliente": $("#idcliente").val()
        });
      }
    }
  })


}

/*==========================================================
=            CONFIRMAR RECEPCION DEL INVENTARIO            =
==========================================================*/
$('#TablaListInvent tbody').on("click", ".btnConfirmInventario", function() {
  var id = $(this).attr("id");

  Swal.fire({
  type: "warning",
  title: "¿Está seguro de Confirmar las ubicaciones reportadas?",
  text: "¡Si no lo está puede cancelar la accíón!",
  showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, Confirmar Inventario!'
  }).then(function(result){
  if (result.value) {

    var datosInvent = new FormData();
    datosInvent.append("idConfirmar", id);
    datosInvent.append("estadoConfirm", 1);
    datosInvent.append("nombreencriptado", null);

    $.ajax({
      url: rutaOculta + "ajax/notificacionInvent.ajax.php",
      method: "POST",
      data: datosInvent,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      if(respuesta == "ok"){

        Swal.fire({
            type: "success",
            title: "EL reporte del Inventario ha sido reportado Correctamente..",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {

                window.location = "vistaInventarios";

                }
              })
        }


      }

    })

  }
})  

})


/*==================================================
=            FUNCIONES PARA LAS COOKIES            =
==================================================*/
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
  var expires = "expires="+d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(';');
  for(var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}



/*===========================================================
=            FUNCIONES PARA REINICIAR EL USUARIO            =
===========================================================*/

  function e(q) {

Swal.fire({
  title: q,
  // text: "You won't be able to revert this!",
  // icon: 'warning',
  showCancelButton: false,
  confirmButtonColor: '#3085d6',
  // cancelButtonColor: '#d33',
  allowOutsideClick: false,
  confirmButtonText: 'Ir a Inicio'
}).then((result) => {
  if (result.isConfirmed) {
    setCookie("Sessions","",-1);
    window.location.href = rutaOculta+"salir";
  }
})
}
// function inactividad() {
//   // alert("Inactivo");
//     e("Su sesión ha caducado, por favor vuelva a iniciarla");
//     setCookie("Sessions","caducada",1);
// }
// var t=null;
// function contadorInactividad() {
//     t=setTimeout("inactividad()",3000);
//     // console.log(t);
//     // 1200000
// }
// window.onblur=window.onmousemove=function() {
//     var varsession =  $("#perfiluser").val();
//     // console.log(varsession);
//     if (varsession!= ""){
//       contadorInactividad();
//     }
    
// }
// if(t){
//   console.log(t);
//   clearTimeout(t);
// }
// if (getCookie("Sessions") == "caducada" && getCookie("Sessions") != undefined){
//   Swal.fire({
//     title: 'Su sesión ha caducado, por favor vuelva a iniciarla',
//     // text: "You won't be able to revert this!",
//     // icon: 'warning',
//     showCancelButton: false,
//     confirmButtonColor: '#3085d6',
//     // cancelButtonColor: '#d33',
//     allowOutsideClick: false,
//     confirmButtonText: 'Ir a Inicio'
//   }).then((result) => {
//     if (result.isConfirmed) {
//       setCookie("Sessions","",-1);
//       window.location.href = rutaOculta+"salir";
//     }
//   })
// }