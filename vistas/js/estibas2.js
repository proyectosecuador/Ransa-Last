var myWindow; //variable creada para la nueva ventana y hacer el check list de transporte

var tablaProgramacion = $("#Programacion").DataTable({
  // "deferRender": true,
  // "retrieve": true,
  // "processing": true,
  scrollX: true,
  paging: false,
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});
/*=======================================================
=            ESTILO DE FECHA DE PROGRAMACION            =
=======================================================*/
function FechaProg() {
  $(".fechaprog").datetimepicker({
    startView: 2,
    autoclose: true,
    format: "yyyy-mm-dd HH:ii:ss",
    language: "es",
  });
  var fecha = new Date(Date.now());
  // $('.fechaprog').datetimepicker('setDaysOfWeekDisabled', [0,6]);
  // $('.fechaprog').datetimepicker('setStartDate', '2012-01-01');
  // console.log();
  $(".fechaprog").datetimepicker(
    "setStartDate",
    fecha.getFullYear() + "-" + (fecha.getMonth() + 1) + "-" + fecha.getDate()
  );
  // $('.fechaprog').datetimepicker('setEndDate', null);
}

FechaProg(); // ejecuta la funcion para que al programar pueda seleccionar fecha y Hora
/*================================================================
=            AÑADIR OTRA FILA EN SOLICITUD DE ESTIBAS            =
================================================================*/
$("#Programacion tbody").on("click", ".anadir", function () {
  $(this).removeClass("anadir");
  $(this).parent().parent().addClass("remove"); //añadimos a la fila la clase remove para despues eliminarla
  $(this).addClass("btnremove");
  $(this).html('<i style="color: #f14141;" class="fas fa-minus-circle"></i>');
  tablaProgramacion.row
    .add([
      '<td><input readonly type="text" name="" style="width: 175px;" class="form-control fechaprog"></td>',
      '<select class="form-control clienteprog" id="clienteprog" style="width: 250px;">' +
        $(".clienteprog").html() +
        "</select>",
      '<select class="form-control rmovimiento" id="rmovimiento" style="width: 200px;">' +
        $(".rmovimiento").html() +
        "</select>",
      '<input type="text" name="" class="form-control pronguias" id="pronguias" style="width: 125x;">',
      '<input type="text" name="" class="form-control conductor" id="conductor" style="width: 200px;">',
      '<input type="text" name="" class="form-control placa" id="placa" style="width: 125px;">',
      '<select class="form-control tcarga" id="tcarga" style="width: 150px;">' +
        $(".tcarga").html() +
        "</select>",
      '<textarea class="form-control comentarioprog" id="comentarioprog" style="width: 200px;"></textarea>',
      '<div align="center"><input type="checkbox" class="icheckSolicEstiba" name=""> </div>',
      '<span class="btn anadir btn-default" style="font-size: 22px;"><i class="fas fa-plus-circle"></i></span>',
    ])
    .draw(false);
  FechaProg();
});
/*===================================================================
=            BOTON PARA ELIMINAR EL REGISTRO DE LA TABLA            =
===================================================================*/
$("#Programacion tbody").on("click", ".btnremove", function () {
  tablaProgramacion.row(".remove").remove().draw(false);
});
/*==============================================
=            GUARDAR LA PRGRAMACIÓN            =
==============================================*/
$(".btnGuardarProg").click(function () {
  var array = tablaProgramacion.data().toArray();
  var fechaprog = $(".fechaprog");
  var idcliente = $(".clienteprog");
  var rmovimiento = $(".rmovimiento");
  var pronguias = $(".pronguias");
  var conductor = $(".conductor");
  var placa = $(".placa");
  var idlocalizacion = $("#idlocalizacion").val();
  var tcarga = $(".tcarga");
  var comentarioprog = $(".comentarioprog");
  var neceCuadrilla = $(".icheckSolicEstiba");
  var FinalFor = 0;

  if (
    array.length == 1 &&
    $(fechaprog[0]).val() == "" &&
    $(idcliente[0]).val() == "Seleccionar una opción" &&
    $(tcarga[0]).val() == "Seleccionar una opción"
  ) {
    Swal.fire({
      type: "warning",
      text: "Al menos debe tener un registro para continuar...",
    });
    return false;
  } else {
    /*========================================================================================
      =            REVISAMOS QUE TODOS LOS CAMPOS OBLIGATORIOS SE ENCUENTREN LLENOS            =
      ========================================================================================*/
    for (var i = 0; i < array.length; i++) {
      if (
        $(fechaprog[i]).val() == "" ||
        $(idcliente[i]).val() == "Seleccionar una opción"
      ) {
        Swal.fire({
          type: "warning",
          text: "Debe completar los campos que son obligatorios para continuar...",
        });
        return false;
      }
    }
    var datos = new FormData();
    for (var i = 0; i < array.length; i++) {
      datos.append("prog_fech_operacion", $(fechaprog[i]).val());
      datos.append("cliente_prog", $(idcliente[i]).val());
      datos.append("rmovimiento", $(rmovimiento[i]).val());
      datos.append("pro_nguias", $(pronguias[i]).val());
      datos.append("conductor", $(conductor[i]).val());
      datos.append("placa", $(placa[i]).val());
      datos.append("t_carga_prog", $(tcarga[i]).val());
      datos.append("idlocalizacion", idlocalizacion);
      datos.append("comentario_prog", $(comentarioprog[i]).val());
      datos.append("cuadrilla", $(neceCuadrilla[i]).is(":checked"));
      $.ajax({
        url: rutaOculta + "ajax/estibas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == 1) {
            window.location = "Programar";
          }
        },
      });
    }
  }
});
/*==================================================================================================
=                              SECCION DE PROVEEDOR DE estibas                                     =
==================================================================================================*/
/*======================================================
=            REGISTRAR PROVEEDOR DE ESTIBAS            =
======================================================*/
$(".SaveProvEstibas").click(function () {
  var nombreProv = $(".ProvEstibas").val();
  var RucEstibas = $(".RucEstibas").val();
  var ContraEstibas = $(".ContraEstibas").val();
  var CorreoEstibas = $(".CorreoEstibas").val();
  var datos = new FormData();
  datos.append("SaveNomProvEstibas", nombreProv);
  datos.append("RucEstibas", RucEstibas);
  datos.append("ContraEstibas", ContraEstibas);
  datos.append("CorreoEstibas", CorreoEstibas);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    beforeSend: function () {
      document.getElementById("conte_loading").style.display = "block";
    },
    success: function (respuesta) {
      if (respuesta == 1) {
        window.location = "Proveedor-Estibas";
      }
    },
  });
});
/*=======================================================
=            TABLA DE PROVEEDORES DE ESTIBAS            =
=======================================================*/
var TablaProvEstibas = $("#TablaProvEstibas").DataTable({
  ajax: "ajax/TablaProvEstibas.ajax.php",
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});
/*======================================================
=            BOTON PARA EDITAR EL PROVEEDOR            =
======================================================*/
$("#TablaProvEstibas tbody").on("click", ".btnEditarProvEstibas", function () {
  var idprovEstiba = $(this).attr("idestibas");
  var datos = new FormData();
  datos.append("ConsultNomProvEstibas", idprovEstiba);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      $(".EProvEstibas").val(respuesta["nombre_proveedor"]);
      $(".EIdProvEstibas").val(respuesta["idproveedor_estiba"]);
    },
  });
});

/*==============================================================
=            BOTON PARA MODIFICAR PROVEEDOR ESTIBAS            =
==============================================================*/
$(".EditProvEstibas").click(function () {
  var nombreProv = $(".EProvEstibas").val();
  var idProvEstiba = $(".EIdProvEstibas").val();
  var datos = new FormData();
  datos.append("EditNomProvEstibas", nombreProv);
  datos.append("EditIdProvEstibas", idProvEstiba);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta == "ok") {
        window.location = "Proveedor-Estibas";
      }
    },
  });
});
/*========================================================
=           BOTON PARA ELIMINAR EL PROVEEDOR            =
========================================================*/
$("#TablaProvEstibas tbody").on(
  "click",
  ".btnEliminarProvEstibas",
  function () {
    var idestibas = $(this).attr("idestibas");
    Swal.fire({
      type: "warning",
      title: "¿Está seguro de borrar el Proveedor?",
      text: "¡Si no lo está puede cancelar la accíón!",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, borrar Proveedor!",
    }).then(function (result) {
      if (result.value) {
        var datosEliminar = new FormData();
        datosEliminar.append("idEliminarProvEs", idestibas);
        $.ajax({
          data: datosEliminar,
          url: rutaOculta + "ajax/estibas.ajax.php",
          type: "POST",
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta.trim() == "ok") {
              Swal.fire({
                type: "success",
                text: "Proveedor Eliminado Correctamente",
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                allowOutsideClick: false,
              }).then(function (result) {
                if (result.value) {
                  window.location = "Proveedor-Estibas";
                }
              });
            }
          },
        });
      }
    });
  }
);

/*======================================================================================
=            TABLA PARA ASIGNACIÓN DE ESTIBAS SEGUN MOVIMIENTOS PROGRAMADOS            =
======================================================================================*/
var tablaMovAsigEst = $("#TablaMovAsigEst").DataTable({
  dom: "Blfrtip",
  buttons: [
    {
      extend: "excel",
      className: "btn-sm",
      filename: "Programación",
      sheetName: "Listado",
      exportOptions: {
        format: {
          body: function (data, row, column, node) {
            //Convierte datos del texto en html y solo obtiene de la tabla la seleccion del select
            return column === 9
              ? $($.parseHTML(data)[0])
                  .children()
                  .find("option:selected")
                  .text()
              : data;
          },
        },
      },
    },
  ],
  ajax: "ajax/TablaProgMovEstibas.ajax.php",
  deferRender: true,
  retrieve: true,
  processing: true,
  paging: false,
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});
/*===========================================================
=            ACTUALIZAR LA TABLA DE PROGRAMACIÓN            =
===========================================================*/
$(".btnActualizarProg").click(function () {
  var d = new Date();
  $(".fechaActualizada").html(
    "<h3>Hora Actualizado: " +
      d.getHours() +
      ":" +
      d.getMinutes() +
      ":" +
      d.getSeconds() +
      "</h3>"
  );
  tablaMovAsigEst.ajax.reload();
});
/*===========================================================
=            ASIGNAR CUADRILLA A LA PROGRAMACION            =
===========================================================*/

$("#TablaMovAsigEst tbody").on("change", ".selectEstibaProg", function () {
  var idmovimiento = $(this).attr("idmovimiento");
  var idestiba = $(this).val();
  var inputselect = $(this);
  var datos = new FormData();
  datos.append("asignarCuadrillaMov", idestiba);
  datos.append("idmov", idmovimiento);
  $.ajax({
    data: datos,
    url: rutaOculta + "ajax/estibas.ajax.php",
    type: "POST",
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta.trim() == "ok") {
        $(inputselect).attr("disabled", true);
        $(inputselect).after(
          "<button data-toggle='tooltip' title='Cambiar Cuadrilla' class='btnEditarAsigCuadrilla btn-sm btn btn-warning'><i class='fas fa-pencil-alt'></i></button>"
        );
        $(document).ready(function () {
          $('[data-toggle="tooltip"]').tooltip();
        });
      }
    },
  });
});
/*===============================================================
=            BOTON PARA EDITAR LA CUADRILLA ASIGNADA            =
===============================================================*/
$("#TablaMovAsigEst tbody").on("click", ".btnEditarAsigCuadrilla", function () {
  $(this).prev().attr("disabled", false); //quitamos el atributo disabled
  $(this).remove(); // removemos el button
  $('[role="tooltip"]').remove();
});
/*===================================================================================
=            TABLA DE MOVIMIENTOS QUE YA SE ENCUENTRA CUADRILLA ASIGNADA            =
===================================================================================*/
var tablaMov_Cuadri_Asig = $("#Mov-CuadrillaAsignada").DataTable({
  // "deferRender": true,
  // "retrieve": true,
  // "processing": true,
  ajax: "ajax/TablaMovCuaAsig.ajax.php",
  paging: true,
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});
/*=============================================================================
=            ACTUALIZAR LA TABLA DE MOV ASIGNADOS CUADRILLA EN 30 seg            =
=============================================================================*/

// setInterval( function () {
//     tablaMov_Cuadri_Asig.ajax.reload();
//     // if (myWindow.closed){
//     //   alert("dfgjdfkg");
//     //   myWindow = null;
//     // }
// }, 30000 );

/*==================================================
=            FUNCIONES PARA LAS COOKIES            =
==================================================*/
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + exdays * 24 * 60 * 60 * 1000);
  var expires = "expires=" + d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}

function getCookie(cname) {
  var name = cname + "=";
  var ca = document.cookie.split(";");
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}

function checkCookie() {
  var user = getCookie("username");
  if (user != "") {
    alert("Welcome again " + user);
  } else {
    user = prompt("Please enter your name:", "");
    if (user != "" && user != null) {
      setCookie("username", user, 365);
    }
  }
}

/*=====  End of FUNCIONES PARA LAS COOKIES  ======*/

/*=            DROPZONE PARA AÑADIR IMAGENES            =
=====================================================*/
var arrayFiles = [];
var coment = [];
var clasifoto = [];
$(".ImgRecepcion").dropzone({
  url: "/",
  addRemoveLinks: true,
  acceptedFiles: "image/jpeg, image/png",
  maxFilesize: 5,
  capture: "image/jpeg, image/png",
  dictRemoveFile: "Eliminar Imagen",
  dictInvalidFileType: "No se puede Cargar archivos de este Tipo",
  dictMaxFilesExceeded: "Solo se permiten 10 Imagenes",
  init: function () {
    this.on("addedfile", function (file) {
      /*==============================================
      =            AÑADIMOS EL COMENTARIO            =
      ==============================================*/
      (async () => {
        const { value: formValues } = await Swal.fire({
          title: "Comentarios de la Imagen",
          allowOutsideClick: false,
          html:
            '<label>Clasificación Fotográfica</label><select id="swal-input1" class="swal2-input">' +
            '<option value="Sellos">Sellos de Transporte</option>' +
            '<option value="Higiene">Condiciones Sanitarias</option>' +
            '<option value="Averia">Producto Averiado</option>' +
            "</select>" +
            '<label>Comentario</label><textarea rows="5" id="swal-input2" class="swal2-input"></textarea>',
          focusConfirm: false,
          preConfirm: () => {
            return [
              document.getElementById("swal-input1").value,
              document.getElementById("swal-input2").value,
            ];
          },
        });

        if (formValues) {
          coment.push(formValues[1]);
          clasifoto.push(formValues[0]);
          var remove = $(".dz-remove");
          // =============================================================================
          // =            PARA QUE SEA VISIBLE EL COMENTARIO AÑADIDO AL CLIENTE            =
          // =============================================================================
          var contador = remove.length - 1;
          var ddd;
          $(remove[contador]).after(
            '<div class="text-center" style="width: 120px;"><span>' +
              formValues[1] +
              "</span> </div>"
          );
        } else {
          coment.push(null);
          clasifoto.push(formValues[0]);
          // console.log(clasifoto);
        }
      })();

      arrayFiles.push(file);
      // console.log(arrayFiles);
    });

    this.on("removedfile", function (file) {
      var index = arrayFiles.indexOf(file);

      arrayFiles.splice(index, 1);
      coment.splice(index, 1);
      clasifoto.splice(index, 1);
    });
  },
});

/*===============================================================================================================
=            AÑADIR OBSERVACIONES AL COLOCAR QUE NO CUMPLE UNA CONDICION DEL CHECK LIST VERIFICACION            =
===============================================================================================================*/
var obstransp = [];
/*=====  PPTL  ======*/
$('input[name="pptl"]').on("ifChecked", function (event) {
  if ($("#idrecepcion").val() != "") {
    if ($(this).attr("id") == "NO") {
      (async () => {
        const { value: text } = await Swal.fire({
          input: "textarea",
          inputPlaceholder: "Escribe las observaciones aquí...",
          showCancelButton: true,
          allowOutsideClick: false,
        });

        if (text) {
          obstransp.push({ obspptl: text });
        } else {
          var pptl = $('input[name="pptl"]');
          for (var i = 0; i < pptl.length; i++) {
            if ($(pptl[i]).attr("id") != "NO") {
              $(pptl[i]).iCheck("check");
              var index = -1;
              for (var i = 0; i < obstransp.length; i++) {
                if (obstransp[i]["obspptl"]) {
                  index = obstransp.indexOf(obstransp[i]);
                  break;
                }
              }

              if (index != -1) {
                obstransp.splice(index, 1);
              }
            } else {
              $(pptl[i]).iCheck("uncheck");
            }
          }
        }
      })();
    } else {
      var index = -1;
      for (var i = 0; i < obstransp.length; i++) {
        if (obstransp[i]["obspptl"]) {
          index = obstransp.indexOf(obstransp[i]);
          break;
        }
      }

      if (index != -1) {
        obstransp.splice(index, 1);
      }
    }
  }
});
/*=====  PA  ======*/
$('input[name="pa"]').on("ifChecked", function (event) {
  if ($("#idrecepcion").val() != "") {
    if ($(this).attr("id") == "NO") {
      (async () => {
        const { value: text } = await Swal.fire({
          input: "textarea",
          inputPlaceholder: "Escribe las observaciones aquí...",
          showCancelButton: true,
          allowOutsideClick: false,
        });

        if (text) {
          obstransp.push({ obspa: text });
        } else {
          var pptl = $('input[name="pa"]');
          for (var i = 0; i < pptl.length; i++) {
            if ($(pptl[i]).attr("id") != "NO") {
              $(pptl[i]).iCheck("check");
              var index = -1;
              for (var i = 0; i < obstransp.length; i++) {
                if (obstransp[i]["obspa"]) {
                  index = obstransp.indexOf(obstransp[i]);
                  break;
                }
              }

              if (index != -1) {
                obstransp.splice(index, 1);
              }
            } else {
              $(pptl[i]).iCheck("uncheck");
            }
          }
        }
      })();
    } else {
      var index = -1;
      for (var i = 0; i < obstransp.length; i++) {
        if (obstransp[i]["obspa"]) {
          index = obstransp.indexOf(obstransp[i]);
          break;
        }
      }

      if (index != -1) {
        obstransp.splice(index, 1);
      }
    }
  }
});
/*=====  MINCOM  ======*/
$('input[name="mincom"]').on("ifChecked", function (event) {
  if ($("#idrecepcion").val() != "") {
    if ($(this).attr("id") == "NO") {
      (async () => {
        const { value: text } = await Swal.fire({
          input: "textarea",
          inputPlaceholder: "Escribe las observaciones aquí...",
          showCancelButton: true,
          allowOutsideClick: false,
        });

        if (text) {
          obstransp.push({ obsmincom: text });
        } else {
          var pptl = $('input[name="mincom"]');
          for (var i = 0; i < pptl.length; i++) {
            if ($(pptl[i]).attr("id") != "NO") {
              $(pptl[i]).iCheck("check");
              var index = -1;
              for (var i = 0; i < obstransp.length; i++) {
                if (obstransp[i]["obsmincom"]) {
                  index = obstransp.indexOf(obstransp[i]);
                  break;
                }
              }

              if (index != -1) {
                obstransp.splice(index, 1);
              }
            } else {
              $(pptl[i]).iCheck("uncheck");
            }
          }
        }
      })();
    } else {
      var index = -1;
      for (var i = 0; i < obstransp.length; i++) {
        if (obstransp[i]["obsmincom"]) {
          index = obstransp.indexOf(obstransp[i]);
          break;
        }
      }

      if (index != -1) {
        obstransp.splice(index, 1);
      }
    }
  }
});
/*=====  PLAGA  ======*/
$('input[name="plaga"]').on("ifChecked", function (event) {
  if ($("#idrecepcion").val() != "") {
    if ($(this).attr("id") == "NO") {
      (async () => {
        const { value: text } = await Swal.fire({
          input: "textarea",
          inputPlaceholder: "Escribe las observaciones aquí...",
          showCancelButton: true,
          allowOutsideClick: false,
        });

        if (text) {
          obstransp.push({ obsplaga: text });
        } else {
          var pptl = $('input[name="plaga"]');
          for (var i = 0; i < pptl.length; i++) {
            if ($(pptl[i]).attr("id") != "NO") {
              $(pptl[i]).iCheck("check");
              var index = -1;
              for (var i = 0; i < obstransp.length; i++) {
                if (obstransp[i]["obsplaga"]) {
                  index = obstransp.indexOf(obstransp[i]);
                  break;
                }
              }

              if (index != -1) {
                obstransp.splice(index, 1);
              }
            } else {
              $(pptl[i]).iCheck("uncheck");
            }
          }
        }
      })();
    } else {
      var index = -1;
      for (var i = 0; i < obstransp.length; i++) {
        if (obstransp[i]["obsplaga"]) {
          index = obstransp.indexOf(obstransp[i]);
          break;
        }
      }

      if (index != -1) {
        obstransp.splice(index, 1);
      }
    }
  }
});
/*=====  OEXTRANIOS  ======*/
$('input[name="oextranios"]').on("ifChecked", function (event) {
  if ($("#idrecepcion").val() != "") {
    if ($(this).attr("id") == "NO") {
      (async () => {
        const { value: text } = await Swal.fire({
          input: "textarea",
          inputPlaceholder: "Escribe las observaciones aquí...",
          showCancelButton: true,
          allowOutsideClick: false,
        });

        if (text) {
          obstransp.push({ obsoextranios: text });
        } else {
          var pptl = $('input[name="oextranios"]');
          for (var i = 0; i < pptl.length; i++) {
            if ($(pptl[i]).attr("id") != "NO") {
              $(pptl[i]).iCheck("check");
              var index = -1;
              for (var i = 0; i < obstransp.length; i++) {
                if (obstransp[i]["obsoextranios"]) {
                  index = obstransp.indexOf(obstransp[i]);
                  break;
                }
              }

              if (index != -1) {
                obstransp.splice(index, 1);
              }
            } else {
              $(pptl[i]).iCheck("uncheck");
            }
          }
        }
      })();
    } else {
      var index = -1;
      for (var i = 0; i < obstransp.length; i++) {
        if (obstransp[i]["obsoextranios"]) {
          index = obstransp.indexOf(obstransp[i]);
          break;
        }
      }

      if (index != -1) {
        obstransp.splice(index, 1);
      }
    }
  }
});

/*=====  OQUIMICOS  ======*/
$('input[name="oquimicos"]').on("ifChecked", function (event) {
  if ($("#idrecepcion").val() != "") {
    if ($(this).attr("id") == "NO") {
      (async () => {
        const { value: text } = await Swal.fire({
          input: "textarea",
          inputPlaceholder: "Escribe las observaciones aquí...",
          showCancelButton: true,
          allowOutsideClick: false,
        });

        if (text) {
          obstransp.push({ obsoquimicos: text });
        } else {
          var pptl = $('input[name="oquimicos"]');
          for (var i = 0; i < pptl.length; i++) {
            if ($(pptl[i]).attr("id") != "NO") {
              $(pptl[i]).iCheck("check");
              var index = -1;
              for (var i = 0; i < obstransp.length; i++) {
                if (obstransp[i]["obsoquimicos"]) {
                  index = obstransp.indexOf(obstransp[i]);
                  break;
                }
              }

              if (index != -1) {
                obstransp.splice(index, 1);
              }
            } else {
              $(pptl[i]).iCheck("uncheck");
            }
          }
        }
      })();
    } else {
      var index = -1;
      for (var i = 0; i < obstransp.length; i++) {
        if (obstransp[i]["obsoquimicos"]) {
          index = obstransp.indexOf(obstransp[i]);
          break;
        }
      }

      if (index != -1) {
        obstransp.splice(index, 1);
      }
    }
  }
});

/*=====  SELLOS  ======*/
$('input[name="sellos"]').on("ifChecked", function (event) {
  if ($("#idrecepcion").val() != "") {
    if ($(this).attr("id") == "NO") {
      (async () => {
        const { value: text } = await Swal.fire({
          input: "textarea",
          inputPlaceholder: "Escribe las observaciones aquí...",
          showCancelButton: true,
          allowOutsideClick: false,
        });

        if (text) {
          obstransp.push({ obssellos: text });
        } else {
          var pptl = $('input[name="sellos"]');
          for (var i = 0; i < pptl.length; i++) {
            if ($(pptl[i]).attr("id") != "NO") {
              $(pptl[i]).iCheck("check");
              var index = -1;
              for (var i = 0; i < obstransp.length; i++) {
                if (obstransp[i]["obssellos"]) {
                  index = obstransp.indexOf(obstransp[i]);
                  break;
                }
              }

              if (index != -1) {
                obstransp.splice(index, 1);
              }
            } else {
              $(pptl[i]).iCheck("uncheck");
            }
          }
        }
      })();
    } else {
      var index = -1;
      for (var i = 0; i < obstransp.length; i++) {
        if (obstransp[i]["obssellos"]) {
          index = obstransp.indexOf(obstransp[i]);
          break;
        }
      }

      if (index != -1) {
        obstransp.splice(index, 1);
      }
    }
  }
});

function GuardarCheckList(imagenes) {
  var idmov = $("#idrecepcion").val();
  var responsablechecktrans = $(".responsablechecktrans").val();
  var transportista = $(".transportista").val();
  var placa = $(".placa").val();
  var guias = $(".guias").val();
  var obstransporte = $(".obstransporte").val();
  // var chguias = $(".chguias").val();

  var pptl = $('input[name="pptl"]:checked').attr("id");
  var pa = $('input[name="pa"]:checked').attr("id");
  var mincom = $('input[name="mincom"]:checked').attr("id");
  var plaga = $('input[name="plaga"]:checked').attr("id");
  var oextranios = $('input[name="oextranios"]:checked').attr("id");
  var oquimicos = $('input[name="oquimicos"]:checked').attr("id");
  var sellos = $('input[name="sellos"]:checked').attr("id");

  var datos = new FormData();
  datos.append("Rcheckresponsablechecktrans", responsablechecktrans);
  datos.append("transportista", transportista);
  datos.append("placa", placa);
  datos.append("guias", guias);
  datos.append("obstransporte", obstransporte);
  datos.append("pptl", pptl);
  datos.append("pa", pa);
  datos.append("mincom", mincom);
  datos.append("plaga", plaga);
  // datos.append("chguias", chguias);
  datos.append("oextranios", oextranios);
  datos.append("oquimicos", oquimicos);
  datos.append("sellos", sellos);
  datos.append("idmov", idmov);
  datos.append("imagen", imagenes);
  datos.append("comentItem", JSON.stringify(obstransp));

  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    // dataType: "json",
    success: function (respuesta) {
      Swal.fire({
        type: "success",
        title: "El Check List ha sido registrado Exitosamente.",
        showConfirmButton: true,
        allowOutsideClick: false,
        confirmButtonText: "Cerrar",
      }).then(function (result) {
        if (result.value) {
          /*==============================================
              =            ELIMINAMOS LAS COOKIES            =
              ==============================================*/
          setCookie("Img" + idmov, "Finalizar Cookie", -24);
          setCookie("obstransporte" + idmov, "Finalizar Cookie", -24);
          setCookie("transportista" + idmov, "Finalizar Cookie", -24);
          setCookie("responsablecheck" + idmov, "Finalizar Cookie", -24);
          // setCookie("chguias"+idmov, "chguias Cookie",-24);
          setCookie("guias" + idmov, "Finalizar Cookie", -24);
          setCookie("placa" + idmov, "Finalizar Cookie", -24);
          setCookie("Img" + idmov, "Finalizar Cookie", -24);
          setCookie("cantImg" + idmov, "Finalizar Cookie", -24);
          setCookie("btnAvanza" + idmov, "Finalizar Cookie", -24);

          localStorage.removeItem("Img" + idmov);
          localStorage.removeItem("window" + idmov);
          window.opener.location.reload();
          window.close();
          // window.location = "List-Programacion";

          // tablaMov_Cuadri_Asig.ajax.reload();
        }
      });
    },
  });
}

/*==============================================================
=            BOTON DE GUARDAR CHECK LIST TRANSPORTE            =
==============================================================*/
$(".guardarCheckTransporte").click(function () {
  var listImgRecep = [];
  var ImgTotal = null;
  var cont = -1;
  var finalfor = 0;
  var idmov = $("#idrecepcion").val();
  var responsablechecktrans = $(".responsablechecktrans").val();
  var pptl = $('input[name="pptl"]:checked').attr("id");
  var pa = $('input[name="pa"]:checked').attr("id");
  var mincom = $('input[name="mincom"]:checked').attr("id");
  var plaga = $('input[name="plaga"]:checked').attr("id");
  var oextranios = $('input[name="oextranios"]:checked').attr("id");
  var oquimicos = $('input[name="oquimicos"]:checked').attr("id");
  var sellos = $('input[name="sellos"]:checked').attr("id");
  var transportista = $(".transportista").val();
  var guias = $(".guias").val();
  var placa = $(".placa").val();
  // var idcliente = $("#clienterecep").val();
  // if (arrayFiles.length != 0 && responsablechecktrans != ""){
  if (
    pptl != undefined &&
    pa != undefined &&
    mincom != undefined &&
    plaga != undefined &&
    oextranios != undefined &&
    oquimicos != undefined &&
    sellos != undefined
  ) {
    if (
      transportista != "" &&
      placa != "" &&
      responsablechecktrans != "" &&
      guias != ""
    ) {
      /*==============================================================
        =            RECORREMOS LAS IMAGENES SE HAN AÑADIDO            =
        ==============================================================*/
      if (arrayFiles.length != 0) {
        for (var i = 0; i < arrayFiles.length; i++) {
          var datos = new FormData();
          datos.append("fileRecep", arrayFiles[i]);
          datos.append("idmov", idmov);
          $.ajax({
            url: rutaOculta + "ajax/estibas.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
              cont++;
              if (coment[cont] == undefined) {
                if (clasifoto[cont] == undefined) {
                  listImgRecep.push({
                    ImgRecepcion: respuesta.substr(3),
                    comentario: null,
                    clasificacion: null,
                  });
                } else {
                  listImgRecep.push({
                    ImgRecepcion: respuesta.substr(3),
                    comentario: null,
                    clasificacion: clasifoto[cont],
                  });
                }
              } else {
                listImgRecep.push({
                  ImgRecepcion: respuesta.substr(3),
                  comentario: coment[cont],
                  clasificacion: clasifoto[cont],
                });
              }
              ImgTotal = JSON.stringify(listImgRecep);
              if (finalfor + 1 == arrayFiles.length) {
                GuardarCheckList(ImgTotal);
              }
              finalfor++;
            },
          });
        }
      } else {
        GuardarCheckList(ImgTotal);
      }
    } else {
      Swal.fire({
        title: "Es necesario completar toda la información para Continua...",
        type: "info",
        confirmButtonText: "Aceptar",
      });
    }
  } else {
    Swal.fire({
      title: "Debe todos los items de Check List para Continua...",
      type: "info",
      confirmButtonText: "Aceptar",
    });
  }
  // }else{
  //     Swal.fire({
  //       title: 'Es necesario colocar al menos una imagen',
  //       type: 'info',
  //       confirmButtonText: 'Aceptar'
  //     });
  // }
});
/*=========================================================================================================
=            CLICK EN EL BOTON A ESPERA PARA ACTUALIZAR CUANDO AUN NO SE HA ASIGNADO CUADRILLA            =
=========================================================================================================*/
$("#Mov-CuadrillaAsignada tbody").on("click", ".aespera", function () {
  tablaMov_Cuadri_Asig.ajax.reload();
});

/*==================================================================================
=            BOTON DE INICIAR EN TABLA DE MOVIMIENTO ASIGNADA CUADRILLA            =
==================================================================================*/
function SugerenciasNombres(input) {
  var substringMatcher = function (strs) {
    return function findMatches(q, cb) {
      var matches, substringRegex;

      // an array that will be populated with substring matches
      matches = [];

      // regex used to determine if a string contains the substring `q`
      substrRegex = new RegExp(q, "i");

      // iterate through the pool of strings and for any string that
      // contains the substring `q`, add it to the `matches` array
      $.each(strs, function (i, str) {
        if (substrRegex.test(str)) {
          matches.push(str);
        }
      });

      cb(matches);
    };
  };
  $.ajax({
    url: rutaOculta + "ajax/Sugerencias_Personal.json.php",
    dataType: "json",
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      $(input).typeahead(
        {
          hint: true,
          highlight: true,
          minLength: 1,
        },
        {
          name: "states",
          source: substringMatcher(respuesta["nombres"]),
        }
      );
      $(".tt-menu").css("position", "relative");
    },
  });
}

$("#Mov-CuadrillaAsignada tbody").on("click", ".btnIniciarMovRD", function () {
  /*==============================================================
  =            PRIMERO GUARDAMOS LA COOKIE DEL ESTADO            =
  ==============================================================*/
  var idMovR_D = $(this).attr("idmov_recep_desp");
  (async () => {
    // var nombres = "";
    if (getCookie("responsablecheck" + idMovR_D)) {
      var nombres = getCookie("responsablecheck" + idMovR_D);
    } else {
      var { value: nombres } = await Swal.fire({
        title: "Persona responsable de actvidad:",
        html: '<input style="margin-b" type="text" id="textnombres" class="form-control" placeholder="Nombre de responsables"></input>',
        width: 400,
        inputLabel:
          "Escoge el nombre de la personal que estará a cargo de la actividad",
        allowOutsideClick: false,
        showCancelButton: true,
        didOpen: () => {
          const content = Swal.getHtmlContainer();
          const $ = content.querySelector.bind(content);
          // console.log(content);
          var inputtexto = $("#textnombres");
          // console.log(inputtexto);
          SugerenciasNombres(inputtexto);
        },
        preConfirm: () => {
          let nombrespersonal = document.getElementById("textnombres").value;
          console.log(nombrespersonal);
          if (nombrespersonal == "") {
            Swal.showValidationMessage(`Por favor escoge el responsable..`);
          } else {
            return fetch(rutaOculta + `ajax/Sugerencias_Personal.json.php`)
              .then((response) => {
                if (!response.ok) {
                  throw new Error(response.statusText);
                }
                return response.json();
              })
              .then((data) => {
                if (jQuery.inArray(nombrespersonal, data["nombres"]) === -1) {
                  Swal.showValidationMessage(
                    `El nombre ingresado no se encuentra registrado en la base, por favor vuelva a ingresar..`
                  );
                } else {
                  return nombrespersonal;
                }
              })
              .catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
              });
          }
        },
      });
    }
    if (nombres) {
      var actividad = $(this).attr("actividad");
      var soliCuadrilla = $(this).attr("soliCuadrilla");
      var rutaactividad = "";
      setCookie("responsablecheck" + idMovR_D, nombres, 1);
      // setCookie("btnAvanza"+idmov,"Finalizar Cookie",-24);
      var valorEstado = 0;
      if (actividad == "RECEPCIÓN" || actividad == "REPALETIZADO") {
        rutaactividad = "RECEPCION" || "REPALETIZADO";
        valorEstado = 3;
      } else if (actividad == "X_Hora") {
        if (soliCuadrilla == "SI") {
          valorEstado = 4;
        } else {
          valorEstado = 8;
        }
      } else {
        rutaactividad = "DESPACHO";
        valorEstado = 3;
      }
      /*==========================================================
    =            CAMBIAMOS EL ESTADO DEL MOVIMIENTO            =
    ==========================================================*/
      var datos = new FormData();
      datos.append("IniciarMov", idMovR_D);
      datos.append("valorEstado", valorEstado);
      datos.append("nombreresponsable", nombres);

      $.ajax({
        url: rutaOculta + "ajax/estibas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            var ventana = localStorage.getItem("window" + idMovR_D);
            /*======================================================================
            =            CODIGO PARA VALIDAR SI TIENE UNA VENTA ABIERTA            =
            ======================================================================*/
            if (ventana == null || myWindow == undefined) {
              localStorage.setItem("window" + idMovR_D, "Ventana Abierta");
              if (
                actividad == "RECEPCIÓN" ||
                actividad == "DESPACHO" ||
                actividad == "REPALETIZADO"
              ) {
                tablaMov_Cuadri_Asig.ajax.reload();
                myWindow = window.open(
                  "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                  "_blank",
                  "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                );
              } else if (actividad == "X_Hora") {
                setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                Swal.fire({
                  title: "Ha dado Inicio a la actividad de " + actividad,
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
                tablaMov_Cuadri_Asig.ajax.reload();
              }
            } else {
              if (myWindow.closed) {
                if (
                  actividad == "RECEPCIÓN" ||
                  actividad == "DESPACHO" ||
                  actividad == "REPALETIZADO"
                ) {
                  tablaMov_Cuadri_Asig.ajax.reload();
                  myWindow = window.open(
                    "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                    "_blank",
                    "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                  );
                } else if (actividad == "X_Hora") {
                  setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                  Swal.fire({
                    title: "Ha dado Inicio a la actividad de " + actividad,
                    type: "info",
                    confirmButtonText: "Aceptar",
                  });
                }
              } else {
                Swal.fire({
                  title: "Ya ha abierto una ventana.",
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
              }
            }
          } else if (respuesta == "Check List Realizado") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "La actividad ya ha sido iniciada!",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          } else if (respuesta == "Ya se ha generado el codigo") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "Ya se ha iniciado la actividad",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          }
        },
      });
    }
  })();
});

/*ESTIBAS X DESPACHO*/
$("#Mov-Despacho tbody").on("click", ".btnIniciarMovRD", function () {
  /*==============================================================
  =            PRIMERO GUARDAMOS LA COOKIE DEL ESTADO            =
  ==============================================================*/
  var idMovR_D = $(this).attr("idmov_recep_desp");
  (async () => {
    // var nombres = "";
    if (getCookie("responsablecheck" + idMovR_D)) {
      var nombres = getCookie("responsablecheck" + idMovR_D);
    } else {
      var { value: nombres } = await Swal.fire({
        title: "Persona responsable de actvidad:",
        html: '<input style="margin-b" type="text" id="textnombres" class="form-control" placeholder="Nombre de responsables"></input>',
        width: 400,
        inputLabel:
          "Escoge el nombre de la personal que estará a cargo de la actividad",
        allowOutsideClick: false,
        showCancelButton: true,
        didOpen: () => {
          const content = Swal.getHtmlContainer();
          const $ = content.querySelector.bind(content);
          // console.log(content);
          var inputtexto = $("#textnombres");
          // console.log(inputtexto);
          SugerenciasNombres(inputtexto);
        },
        preConfirm: () => {
          let nombrespersonal = document.getElementById("textnombres").value;
          console.log(nombrespersonal);
          if (nombrespersonal == "") {
            Swal.showValidationMessage(`Por favor escoge el responsable..`);
          } else {
            return fetch(rutaOculta + `ajax/Sugerencias_Personal.json.php`)
              .then((response) => {
                if (!response.ok) {
                  throw new Error(response.statusText);
                }
                return response.json();
              })
              .then((data) => {
                if (jQuery.inArray(nombrespersonal, data["nombres"]) === -1) {
                  Swal.showValidationMessage(
                    `El nombre ingresado no se encuentra registrado en la base, por favor vuelva a ingresar..`
                  );
                } else {
                  return nombrespersonal;
                }
              })
              .catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
              });
          }
        },
      });
    }
    if (nombres) {
      var actividad = $(this).attr("actividad");
      var soliCuadrilla = $(this).attr("soliCuadrilla");
      var rutaactividad = "";
      setCookie("responsablecheck" + idMovR_D, nombres, 1);
      // setCookie("btnAvanza"+idmov,"Finalizar Cookie",-24);
      var valorEstado = 0;
      if (actividad == "RECEPCIÓN" || actividad == "REPALETIZADO") {
        rutaactividad = "RECEPCION" || "REPALETIZADO";
        valorEstado = 3;
      } else if (actividad == "X_Hora") {
        if (soliCuadrilla == "SI") {
          valorEstado = 4;
        } else {
          valorEstado = 8;
        }
      } else {
        rutaactividad = "DESPACHO";
        valorEstado = 3;
      }
      /*==========================================================
    =            CAMBIAMOS EL ESTADO DEL MOVIMIENTO            =
    ==========================================================*/
      var datos = new FormData();
      datos.append("IniciarMov", idMovR_D);
      datos.append("valorEstado", valorEstado);
      datos.append("nombreresponsable", nombres);

      $.ajax({
        url: rutaOculta + "ajax/estibas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            var ventana = localStorage.getItem("window" + idMovR_D);
            /*======================================================================
            =            CODIGO PARA VALIDAR SI TIENE UNA VENTA ABIERTA            =
            ======================================================================*/
            if (ventana == null || myWindow == undefined) {
              localStorage.setItem("window" + idMovR_D, "Ventana Abierta");
              if (
                actividad == "RECEPCIÓN" ||
                actividad == "DESPACHO" ||
                actividad == "REPALETIZADO"
              ) {
                tablaMov_Cuadri_Asig.ajax.reload();
                myWindow = window.open(
                  "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                  "_blank",
                  "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                );
              } else if (actividad == "X_Hora") {
                setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                Swal.fire({
                  title: "Ha dado Inicio a la actividad de " + actividad,
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
                tablaMov_Cuadri_Asig.ajax.reload();
              }
            } else {
              if (myWindow.closed) {
                if (
                  actividad == "RECEPCIÓN" ||
                  actividad == "DESPACHO" ||
                  actividad == "REPALETIZADO"
                ) {
                  tablaMov_Cuadri_Asig.ajax.reload();
                  myWindow = window.open(
                    "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                    "_blank",
                    "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                  );
                } else if (actividad == "X_Hora") {
                  setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                  Swal.fire({
                    title: "Ha dado Inicio a la actividad de " + actividad,
                    type: "info",
                    confirmButtonText: "Aceptar",
                  });
                }
              } else {
                Swal.fire({
                  title: "Ya ha abierto una ventana.",
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
              }
            }
          } else if (respuesta == "Check List Realizado") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "La actividad ya ha sido iniciada!",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          } else if (respuesta == "Ya se ha generado el codigo") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "Ya se ha iniciado la actividad",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          }
        },
      });
    }
  })();
});

/*==================================================================================================
=            BOTON DE LA TABLA PARA REPORTAR ELIMINAR UN MOVIMIENTO INDICANDO EL MOTIVO            =
==================================================================================================*/
$("#Mov-Despacho tbody").on("click", ".btnEliminarMov", function () {
  var idMov = $(this).attr("idmov_recep_desp");

  (async () => {
    const { value: motivo } = await Swal.fire({
      type: "warning",
      title: "¿Está seguro de Eliminar el Movimiento",
      input: "textarea",
      inputPlaceholder: "MOTIVO POR EL QUE SE ELIMINA",
      text: "¡Si no lo está puede cancelar la accíón!",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Cerrar!",
      inputValidator: (value) => {
        if (!value) {
          return "Es necesario Colocar el motivo por el cual se elimina!";
        }
      },
    });

    if (motivo) {
      var datos = new FormData();
      datos.append("idMovEliminar", idMov);
      datos.append("motivoEliminar", motivo);

      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/estibas.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            window.location = "List-Programacion";
          }
        },
      });
    }
  })();
});

/*==========================================================================
=            CONSULTA DATOS PARA LA CONFIRMACIÓN DEL SUPERVISOR            =
==========================================================================*/
$("#Mov-Despacho tbody").on("click", ".btnConfirmDatos", function () {
  var idmov = $(this).attr("idmov_recep_desp");
  var datos = new FormData();
  datos.append("ConsultConfirmSup", idmov);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      // console.log(respuesta["estado"]);
      if (respuesta["estado"] > 5 && respuesta["idusuarioaprobador"] != null) {
        Swal.fire({
          title: "La actividad ya ha sido aprobada..",
          type: "warning",
          confirmButtonText: "Aceptar",
        });
        tablaMov_Cuadri_Asig.ajax.reload();
      } else {
        $(".modalConfirmSupervisor").modal();
        /*============================================
          =            SE BLOQUEA LOS INPUT            =
          ============================================*/
        $(".ConEstTransporte").attr("disabled", true);
        $(".ConEstContenedor").attr("disabled", true);
        $(".ConEstGuias").attr("disabled", true);
        $(".ConEstHGarita").attr("disabled", true);
        $(".ConEstHInicio").attr("disabled", true);
        $(".ConEstHFin").attr("disabled", true);
        $(".ConEstNomEstibas").attr("disabled", true);
        $(".ConEstCantFilm").attr("disabled", true);
        $(".ConEstCantCodigo").attr("disabled", true);
        $(".ConEstCantFecha").attr("disabled", true);
        $(".ConEstCantPallet").attr("disabled", true);
        $(".ConCantBulto").attr("disabled", true);
        $(".ConEstObservacion").attr("disabled", true);
        /*=============================================================
          =            LLENAMOS LOS INPUT CON LA INFORMACIÓN            =
          =============================================================*/
        $(".ConEstidmov").val(respuesta["idmov_recep_desp"]);
        $(".ConEstfecha_programada").val(respuesta["fecha_programada"]);
        $(".ConEstrazonsocial").val(respuesta["cliente"]);
        $(".ConEstactividad").val(respuesta["actividad"]);
        $(".ConEstTransporte").val(respuesta["idtipo_transporte"]);
        $(".ConEstContenedor").val(respuesta["ncontenedor"]);
        $(".ConEstGuias").val(respuesta["nguias"]);
        $(".ConEstHGarita").val(respuesta["h_garita"]);
        $(".ConEstHInicio").val(respuesta["h_inicio"]);
        $(".ConEstHFin").val(respuesta["h_fin"]);
        $(".ConEstNomEstibas").val(respuesta["nombre_estibas"]);
        $(".ConEstCantFilm").val(respuesta["cant_film"]);
        $(".ConEstCantCodigo").val(respuesta["cant_codigo"]);
        $(".ConEstCantFecha").val(respuesta["cant_fecha"]);
        $(".ConEstCantPallet").val(respuesta["cant_pallets"]);
        $(".ConCantBulto").val(respuesta["cant_bultos"]);
        $(".ConEstObservacion").val(respuesta["observaciones_estibas"]);
      }
    },
  });
});

/*FIN ESTIBAS DESPACHO*/

/*ESTIBAS X HORA*/
$("#Mov-X-Hora tbody").on("click", ".btnIniciarMovRD", function () {
  /*==============================================================
  =            PRIMERO GUARDAMOS LA COOKIE DEL ESTADO            =
  ==============================================================*/
  var idMovR_D = $(this).attr("idmov_recep_desp");
  (async () => {
    // var nombres = "";
    if (getCookie("responsablecheck" + idMovR_D)) {
      var nombres = getCookie("responsablecheck" + idMovR_D);
    } else {
      var { value: nombres } = await Swal.fire({
        title: "Persona responsable de actvidad:",
        html: '<input style="margin-b" type="text" id="textnombres" class="form-control" placeholder="Nombre de responsables"></input>',
        width: 400,
        inputLabel:
          "Escoge el nombre de la personal que estará a cargo de la actividad",
        allowOutsideClick: false,
        showCancelButton: true,
        didOpen: () => {
          const content = Swal.getHtmlContainer();
          const $ = content.querySelector.bind(content);
          // console.log(content);
          var inputtexto = $("#textnombres");
          // console.log(inputtexto);
          SugerenciasNombres(inputtexto);
        },
        preConfirm: () => {
          let nombrespersonal = document.getElementById("textnombres").value;
          console.log(nombrespersonal);
          if (nombrespersonal == "") {
            Swal.showValidationMessage(`Por favor escoge el responsable..`);
          } else {
            return fetch(rutaOculta + `ajax/Sugerencias_Personal.json.php`)
              .then((response) => {
                if (!response.ok) {
                  throw new Error(response.statusText);
                }
                return response.json();
              })
              .then((data) => {
                if (jQuery.inArray(nombrespersonal, data["nombres"]) === -1) {
                  Swal.showValidationMessage(
                    `El nombre ingresado no se encuentra registrado en la base, por favor vuelva a ingresar..`
                  );
                } else {
                  return nombrespersonal;
                }
              })
              .catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
              });
          }
        },
      });
    }
    if (nombres) {
      var actividad = $(this).attr("actividad");
      var soliCuadrilla = $(this).attr("soliCuadrilla");
      var rutaactividad = "";
      setCookie("responsablecheck" + idMovR_D, nombres, 1);
      // setCookie("btnAvanza"+idmov,"Finalizar Cookie",-24);
      var valorEstado = 0;
      if (actividad == "RECEPCIÓN" || actividad == "REPALETIZADO") {
        rutaactividad = "RECEPCION" || "REPALETIZADO";
        valorEstado = 3;
      } else if (actividad == "X_Hora") {
        if (soliCuadrilla == "SI") {
          valorEstado = 4;
        } else {
          valorEstado = 8;
        }
      } else {
        rutaactividad = "DESPACHO";
        valorEstado = 3;
      }
      /*==========================================================
    =            CAMBIAMOS EL ESTADO DEL MOVIMIENTO            =
    ==========================================================*/
      var datos = new FormData();
      datos.append("IniciarMov", idMovR_D);
      datos.append("valorEstado", valorEstado);
      datos.append("nombreresponsable", nombres);

      $.ajax({
        url: rutaOculta + "ajax/estibas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            var ventana = localStorage.getItem("window" + idMovR_D);
            /*======================================================================
            =            CODIGO PARA VALIDAR SI TIENE UNA VENTA ABIERTA            =
            ======================================================================*/
            if (ventana == null || myWindow == undefined) {
              localStorage.setItem("window" + idMovR_D, "Ventana Abierta");
              if (
                actividad == "RECEPCIÓN" ||
                actividad == "DESPACHO" ||
                actividad == "REPALETIZADO"
              ) {
                tablaMov_Cuadri_Asig.ajax.reload();
                myWindow = window.open(
                  "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                  "_blank",
                  "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                );
              } else if (actividad == "X_Hora") {
                setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                Swal.fire({
                  title: "Ha dado Inicio a la actividad de " + actividad,
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
                tablaMov_Cuadri_Asig.ajax.reload();
              }
            } else {
              if (myWindow.closed) {
                if (
                  actividad == "RECEPCIÓN" ||
                  actividad == "DESPACHO" ||
                  actividad == "REPALETIZADO"
                ) {
                  tablaMov_Cuadri_Asig.ajax.reload();
                  myWindow = window.open(
                    "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                    "_blank",
                    "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                  );
                } else if (actividad == "X_Hora") {
                  setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                  Swal.fire({
                    title: "Ha dado Inicio a la actividad de " + actividad,
                    type: "info",
                    confirmButtonText: "Aceptar",
                  });
                }
              } else {
                Swal.fire({
                  title: "Ya ha abierto una ventana.",
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
              }
            }
          } else if (respuesta == "Check List Realizado") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "La actividad ya ha sido iniciada!",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          } else if (respuesta == "Ya se ha generado el codigo") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "Ya se ha iniciado la actividad",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          }
        },
      });
    }
  })();
});

/*==================================================================================================
=            BOTON DE LA TABLA PARA REPORTAR ELIMINAR UN MOVIMIENTO INDICANDO EL MOTIVO            =
==================================================================================================*/
$("#Mov-X-Hora tbody").on("click", ".btnEliminarMov", function () {
  var idMov = $(this).attr("idmov_recep_desp");

  (async () => {
    const { value: motivo } = await Swal.fire({
      type: "warning",
      title: "¿Está seguro de Eliminar el Movimiento",
      input: "textarea",
      inputPlaceholder: "MOTIVO POR EL QUE SE ELIMINA",
      text: "¡Si no lo está puede cancelar la accíón!",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Cerrar!",
      inputValidator: (value) => {
        if (!value) {
          return "Es necesario Colocar el motivo por el cual se elimina!";
        }
      },
    });

    if (motivo) {
      var datos = new FormData();
      datos.append("idMovEliminar", idMov);
      datos.append("motivoEliminar", motivo);

      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/estibas.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            window.location = "List-Programacion";
          }
        },
      });
    }
  })();
});

/*==========================================================================
=            CONSULTA DATOS PARA LA CONFIRMACIÓN DEL SUPERVISOR            =
==========================================================================*/
$("#Mov-X-Hora tbody").on("click", ".btnConfirmDatos", function () {
  var idmov = $(this).attr("idmov_recep_desp");
  var datos = new FormData();
  datos.append("ConsultConfirmSup", idmov);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      // console.log(respuesta["estado"]);
      if (respuesta["estado"] > 5 && respuesta["idusuarioaprobador"] != null) {
        Swal.fire({
          title: "La actividad ya ha sido aprobada..",
          type: "warning",
          confirmButtonText: "Aceptar",
        });
        tablaMov_Cuadri_Asig.ajax.reload();
      } else {
        $(".modalConfirmSupervisor").modal();
        /*============================================
          =            SE BLOQUEA LOS INPUT            =
          ============================================*/
        $(".ConEstTransporte").attr("disabled", true);
        $(".ConEstContenedor").attr("disabled", true);
        $(".ConEstGuias").attr("disabled", true);
        $(".ConEstHGarita").attr("disabled", true);
        $(".ConEstHInicio").attr("disabled", true);
        $(".ConEstHFin").attr("disabled", true);
        $(".ConEstNomEstibas").attr("disabled", true);
        $(".ConEstCantFilm").attr("disabled", true);
        $(".ConEstCantCodigo").attr("disabled", true);
        $(".ConEstCantFecha").attr("disabled", true);
        $(".ConEstCantPallet").attr("disabled", true);
        $(".ConCantBulto").attr("disabled", true);
        $(".ConEstObservacion").attr("disabled", true);
        /*=============================================================
          =            LLENAMOS LOS INPUT CON LA INFORMACIÓN            =
          =============================================================*/
        $(".ConEstidmov").val(respuesta["idmov_recep_desp"]);
        $(".ConEstfecha_programada").val(respuesta["fecha_programada"]);
        $(".ConEstrazonsocial").val(respuesta["cliente"]);
        $(".ConEstactividad").val(respuesta["actividad"]);
        $(".ConEstTransporte").val(respuesta["idtipo_transporte"]);
        $(".ConEstContenedor").val(respuesta["ncontenedor"]);
        $(".ConEstGuias").val(respuesta["nguias"]);
        $(".ConEstHGarita").val(respuesta["h_garita"]);
        $(".ConEstHInicio").val(respuesta["h_inicio"]);
        $(".ConEstHFin").val(respuesta["h_fin"]);
        $(".ConEstNomEstibas").val(respuesta["nombre_estibas"]);
        $(".ConEstCantFilm").val(respuesta["cant_film"]);
        $(".ConEstCantCodigo").val(respuesta["cant_codigo"]);
        $(".ConEstCantFecha").val(respuesta["cant_fecha"]);
        $(".ConEstCantPallet").val(respuesta["cant_pallets"]);
        $(".ConCantBulto").val(respuesta["cant_bultos"]);
        $(".ConEstObservacion").val(respuesta["observaciones_estibas"]);
      }
    },
  });
});

/*FIN ESTIBAS X HORA*/

/*ESTIBAS X PALETIZADO*/
$("#Mov-Repaletizado tbody").on("click", ".btnIniciarMovRD", function () {
  /*==============================================================
  =            PRIMERO GUARDAMOS LA COOKIE DEL ESTADO            =
  ==============================================================*/
  var idMovR_D = $(this).attr("idmov_recep_desp");
  (async () => {
    // var nombres = "";
    if (getCookie("responsablecheck" + idMovR_D)) {
      var nombres = getCookie("responsablecheck" + idMovR_D);
    } else {
      var { value: nombres } = await Swal.fire({
        title: "Persona responsable de actvidad:",
        html: '<input style="margin-b" type="text" id="textnombres" class="form-control" placeholder="Nombre de responsables"></input>',
        width: 400,
        inputLabel:
          "Escoge el nombre de la personal que estará a cargo de la actividad",
        allowOutsideClick: false,
        showCancelButton: true,
        didOpen: () => {
          const content = Swal.getHtmlContainer();
          const $ = content.querySelector.bind(content);
          // console.log(content);
          var inputtexto = $("#textnombres");
          // console.log(inputtexto);
          SugerenciasNombres(inputtexto);
        },
        preConfirm: () => {
          let nombrespersonal = document.getElementById("textnombres").value;
          console.log(nombrespersonal);
          if (nombrespersonal == "") {
            Swal.showValidationMessage(`Por favor escoge el responsable..`);
          } else {
            return fetch(rutaOculta + `ajax/Sugerencias_Personal.json.php`)
              .then((response) => {
                if (!response.ok) {
                  throw new Error(response.statusText);
                }
                return response.json();
              })
              .then((data) => {
                if (jQuery.inArray(nombrespersonal, data["nombres"]) === -1) {
                  Swal.showValidationMessage(
                    `El nombre ingresado no se encuentra registrado en la base, por favor vuelva a ingresar..`
                  );
                } else {
                  return nombrespersonal;
                }
              })
              .catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
              });
          }
        },
      });
    }
    if (nombres) {
      var actividad = $(this).attr("actividad");
      var soliCuadrilla = $(this).attr("soliCuadrilla");
      var rutaactividad = "";
      setCookie("responsablecheck" + idMovR_D, nombres, 1);
      // setCookie("btnAvanza"+idmov,"Finalizar Cookie",-24);
      var valorEstado = 0;
      if (actividad == "RECEPCIÓN" || actividad == "REPALETIZADO") {
        rutaactividad = "RECEPCION" || "REPALETIZADO";
        valorEstado = 3;
      } else if (actividad == "X_Hora") {
        if (soliCuadrilla == "SI") {
          valorEstado = 4;
        } else {
          valorEstado = 8;
        }
      } else {
        rutaactividad = "DESPACHO";
        valorEstado = 3;
      }
      /*==========================================================
    =            CAMBIAMOS EL ESTADO DEL MOVIMIENTO            =
    ==========================================================*/
      var datos = new FormData();
      datos.append("IniciarMov", idMovR_D);
      datos.append("valorEstado", valorEstado);
      datos.append("nombreresponsable", nombres);

      $.ajax({
        url: rutaOculta + "ajax/estibas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            var ventana = localStorage.getItem("window" + idMovR_D);
            /*======================================================================
            =            CODIGO PARA VALIDAR SI TIENE UNA VENTA ABIERTA            =
            ======================================================================*/
            if (ventana == null || myWindow == undefined) {
              localStorage.setItem("window" + idMovR_D, "Ventana Abierta");
              if (
                actividad == "RECEPCIÓN" ||
                actividad == "DESPACHO" ||
                actividad == "REPALETIZADO"
              ) {
                tablaMov_Cuadri_Asig.ajax.reload();
                myWindow = window.open(
                  "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                  "_blank",
                  "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                );
              } else if (actividad == "X_Hora") {
                setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                Swal.fire({
                  title: "Ha dado Inicio a la actividad de " + actividad,
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
                tablaMov_Cuadri_Asig.ajax.reload();
              }
            } else {
              if (myWindow.closed) {
                if (
                  actividad == "RECEPCIÓN" ||
                  actividad == "DESPACHO" ||
                  actividad == "REPALETIZADO"
                ) {
                  tablaMov_Cuadri_Asig.ajax.reload();
                  myWindow = window.open(
                    "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                    "_blank",
                    "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                  );
                } else if (actividad == "X_Hora") {
                  setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                  Swal.fire({
                    title: "Ha dado Inicio a la actividad de " + actividad,
                    type: "info",
                    confirmButtonText: "Aceptar",
                  });
                }
              } else {
                Swal.fire({
                  title: "Ya ha abierto una ventana.",
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
              }
            }
          } else if (respuesta == "Check List Realizado") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "La actividad ya ha sido iniciada!",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          } else if (respuesta == "Ya se ha generado el codigo") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "Ya se ha iniciado la actividad",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          }
        },
      });
    }
  })();
});

/*==================================================================================================
=            BOTON DE LA TABLA PARA REPORTAR ELIMINAR UN MOVIMIENTO INDICANDO EL MOTIVO            =
==================================================================================================*/
$("#Mov-Repaletizado tbody").on("click", ".btnEliminarMov", function () {
  var idMov = $(this).attr("idmov_recep_desp");

  (async () => {
    const { value: motivo } = await Swal.fire({
      type: "warning",
      title: "¿Está seguro de Eliminar el Movimiento",
      input: "textarea",
      inputPlaceholder: "MOTIVO POR EL QUE SE ELIMINA",
      text: "¡Si no lo está puede cancelar la accíón!",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Cerrar!",
      inputValidator: (value) => {
        if (!value) {
          return "Es necesario Colocar el motivo por el cual se elimina!";
        }
      },
    });

    if (motivo) {
      var datos = new FormData();
      datos.append("idMovEliminar", idMov);
      datos.append("motivoEliminar", motivo);

      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/estibas.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            window.location = "List-Programacion";
          }
        },
      });
    }
  })();
});

/*==========================================================================
=            CONSULTA DATOS PARA LA CONFIRMACIÓN DEL SUPERVISOR            =
==========================================================================*/
$("#Mov-Repaletizado tbody").on("click", ".btnConfirmDatos", function () {
  var idmov = $(this).attr("idmov_recep_desp");
  var datos = new FormData();
  datos.append("ConsultConfirmSup", idmov);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      // console.log(respuesta["estado"]);
      if (respuesta["estado"] > 5 && respuesta["idusuarioaprobador"] != null) {
        Swal.fire({
          title: "La actividad ya ha sido aprobada..",
          type: "warning",
          confirmButtonText: "Aceptar",
        });
        tablaMov_Cuadri_Asig.ajax.reload();
      } else {
        $(".modalConfirmSupervisor").modal();
        /*============================================
          =            SE BLOQUEA LOS INPUT            =
          ============================================*/
        $(".ConEstTransporte").attr("disabled", true);
        $(".ConEstContenedor").attr("disabled", true);
        $(".ConEstGuias").attr("disabled", true);
        $(".ConEstHGarita").attr("disabled", true);
        $(".ConEstHInicio").attr("disabled", true);
        $(".ConEstHFin").attr("disabled", true);
        $(".ConEstNomEstibas").attr("disabled", true);
        $(".ConEstCantFilm").attr("disabled", true);
        $(".ConEstCantCodigo").attr("disabled", true);
        $(".ConEstCantFecha").attr("disabled", true);
        $(".ConEstCantPallet").attr("disabled", true);
        $(".ConCantBulto").attr("disabled", true);
        $(".ConEstObservacion").attr("disabled", true);
        /*=============================================================
          =            LLENAMOS LOS INPUT CON LA INFORMACIÓN            =
          =============================================================*/
        $(".ConEstidmov").val(respuesta["idmov_recep_desp"]);
        $(".ConEstfecha_programada").val(respuesta["fecha_programada"]);
        $(".ConEstrazonsocial").val(respuesta["cliente"]);
        $(".ConEstactividad").val(respuesta["actividad"]);
        $(".ConEstTransporte").val(respuesta["idtipo_transporte"]);
        $(".ConEstContenedor").val(respuesta["ncontenedor"]);
        $(".ConEstGuias").val(respuesta["nguias"]);
        $(".ConEstHGarita").val(respuesta["h_garita"]);
        $(".ConEstHInicio").val(respuesta["h_inicio"]);
        $(".ConEstHFin").val(respuesta["h_fin"]);
        $(".ConEstNomEstibas").val(respuesta["nombre_estibas"]);
        $(".ConEstCantFilm").val(respuesta["cant_film"]);
        $(".ConEstCantCodigo").val(respuesta["cant_codigo"]);
        $(".ConEstCantFecha").val(respuesta["cant_fecha"]);
        $(".ConEstCantPallet").val(respuesta["cant_pallets"]);
        $(".ConCantBulto").val(respuesta["cant_bultos"]);
        $(".ConEstObservacion").val(respuesta["observaciones_estibas"]);
      }
    },
  });
});

/*FIN ESTIBAS X PALETIZADO*/

/*ESTIBAS X RECEPCION*/
$("#Mov-Recepcion tbody").on("click", ".btnIniciarMovRD", function () {
  /*==============================================================
  =            PRIMERO GUARDAMOS LA COOKIE DEL ESTADO            =
  ==============================================================*/
  var idMovR_D = $(this).attr("idmov_recep_desp");
  (async () => {
    // var nombres = "";
    if (getCookie("responsablecheck" + idMovR_D)) {
      var nombres = getCookie("responsablecheck" + idMovR_D);
    } else {
      var { value: nombres } = await Swal.fire({
        title: "Persona responsable de actvidad:",
        html: '<input style="margin-b" type="text" id="textnombres" class="form-control" placeholder="Nombre de responsables"></input>',
        width: 400,
        inputLabel:
          "Escoge el nombre de la personal que estará a cargo de la actividad",
        allowOutsideClick: false,
        showCancelButton: true,
        didOpen: () => {
          const content = Swal.getHtmlContainer();
          const $ = content.querySelector.bind(content);
          // console.log(content);
          var inputtexto = $("#textnombres");
          // console.log(inputtexto);
          SugerenciasNombres(inputtexto);
        },
        preConfirm: () => {
          let nombrespersonal = document.getElementById("textnombres").value;
          console.log(nombrespersonal);
          if (nombrespersonal == "") {
            Swal.showValidationMessage(`Por favor escoge el responsable..`);
          } else {
            return fetch(rutaOculta + `ajax/Sugerencias_Personal.json.php`)
              .then((response) => {
                if (!response.ok) {
                  throw new Error(response.statusText);
                }
                return response.json();
              })
              .then((data) => {
                if (jQuery.inArray(nombrespersonal, data["nombres"]) === -1) {
                  Swal.showValidationMessage(
                    `El nombre ingresado no se encuentra registrado en la base, por favor vuelva a ingresar..`
                  );
                } else {
                  return nombrespersonal;
                }
              })
              .catch((error) => {
                Swal.showValidationMessage(`Request failed: ${error}`);
              });
          }
        },
      });
    }
    if (nombres) {
      var actividad = $(this).attr("actividad");
      var soliCuadrilla = $(this).attr("soliCuadrilla");
      var rutaactividad = "";
      setCookie("responsablecheck" + idMovR_D, nombres, 1);
      // setCookie("btnAvanza"+idmov,"Finalizar Cookie",-24);
      var valorEstado = 0;
      if (actividad == "RECEPCIÓN" || actividad == "REPALETIZADO") {
        rutaactividad = "RECEPCION" || "REPALETIZADO";
        valorEstado = 3;
      } else if (actividad == "X_Hora") {
        if (soliCuadrilla == "SI") {
          valorEstado = 4;
        } else {
          valorEstado = 8;
        }
      } else {
        rutaactividad = "DESPACHO";
        valorEstado = 3;
      }
      /*==========================================================
    =            CAMBIAMOS EL ESTADO DEL MOVIMIENTO            =
    ==========================================================*/
      var datos = new FormData();
      datos.append("IniciarMov", idMovR_D);
      datos.append("valorEstado", valorEstado);
      datos.append("nombreresponsable", nombres);

      $.ajax({
        url: rutaOculta + "ajax/estibas.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            var ventana = localStorage.getItem("window" + idMovR_D);
            /*======================================================================
            =            CODIGO PARA VALIDAR SI TIENE UNA VENTA ABIERTA            =
            ======================================================================*/
            if (ventana == null || myWindow == undefined) {
              localStorage.setItem("window" + idMovR_D, "Ventana Abierta");
              if (
                actividad == "RECEPCIÓN" ||
                actividad == "DESPACHO" ||
                actividad == "REPALETIZADO"
              ) {
                tablaMov_Cuadri_Asig.ajax.reload();
                myWindow = window.open(
                  "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                  "_blank",
                  "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                );
              } else if (actividad == "X_Hora") {
                setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                Swal.fire({
                  title: "Ha dado Inicio a la actividad de " + actividad,
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
                tablaMov_Cuadri_Asig.ajax.reload();
              }
            } else {
              if (myWindow.closed) {
                if (
                  actividad == "RECEPCIÓN" ||
                  actividad == "DESPACHO" ||
                  actividad == "REPALETIZADO"
                ) {
                  tablaMov_Cuadri_Asig.ajax.reload();
                  myWindow = window.open(
                    "Check-Transporte/" + idMovR_D + "/" + rutaactividad,
                    "_blank",
                    "toolbar=yes,scrollbars=yes,resizable=yes,top=200,left=500,width=600,height=500"
                  );
                } else if (actividad == "X_Hora") {
                  setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
                  Swal.fire({
                    title: "Ha dado Inicio a la actividad de " + actividad,
                    type: "info",
                    confirmButtonText: "Aceptar",
                  });
                }
              } else {
                Swal.fire({
                  title: "Ya ha abierto una ventana.",
                  type: "info",
                  confirmButtonText: "Aceptar",
                });
              }
            }
          } else if (respuesta == "Check List Realizado") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "La actividad ya ha sido iniciada!",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          } else if (respuesta == "Ya se ha generado el codigo") {
            setCookie("responsablecheck" + idMovR_D, "Finalizar", -1);
            Swal.fire({
              title: "Ya se ha iniciado la actividad",
              allowOutsideClick: false,
              type: "info",
              confirmButtonText: "Aceptar",
            });
            tablaMov_Cuadri_Asig.ajax.reload();
          }
        },
      });
    }
  })();
});

/*==================================================================================================
=            BOTON DE LA TABLA PARA REPORTAR ELIMINAR UN MOVIMIENTO INDICANDO EL MOTIVO            =
==================================================================================================*/
$("#Mov-Recepcion tbody").on("click", ".btnEliminarMov", function () {
  var idMov = $(this).attr("idmov_recep_desp");

  (async () => {
    const { value: motivo } = await Swal.fire({
      type: "warning",
      title: "¿Está seguro de Eliminar el Movimiento",
      input: "textarea",
      inputPlaceholder: "MOTIVO POR EL QUE SE ELIMINA",
      text: "¡Si no lo está puede cancelar la accíón!",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Cerrar!",
      inputValidator: (value) => {
        if (!value) {
          return "Es necesario Colocar el motivo por el cual se elimina!";
        }
      },
    });

    if (motivo) {
      var datos = new FormData();
      datos.append("idMovEliminar", idMov);
      datos.append("motivoEliminar", motivo);

      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/estibas.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            window.location = "List-Programacion";
          }
        },
      });
    }
  })();
});

/*==========================================================================
=            CONSULTA DATOS PARA LA CONFIRMACIÓN DEL SUPERVISOR            =
==========================================================================*/
$("#Mov-Recepcion tbody").on("click", ".btnConfirmDatos", function () {
  var idmov = $(this).attr("idmov_recep_desp");
  var datos = new FormData();
  datos.append("ConsultConfirmSup", idmov);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      // console.log(respuesta["estado"]);
      if (respuesta["estado"] > 5 && respuesta["idusuarioaprobador"] != null) {
        Swal.fire({
          title: "La actividad ya ha sido aprobada..",
          type: "warning",
          confirmButtonText: "Aceptar",
        });
        tablaMov_Cuadri_Asig.ajax.reload();
      } else {
        $(".modalConfirmSupervisor").modal();
        /*============================================
          =            SE BLOQUEA LOS INPUT            =
          ============================================*/
        $(".ConEstTransporte").attr("disabled", true);
        $(".ConEstContenedor").attr("disabled", true);
        $(".ConEstGuias").attr("disabled", true);
        $(".ConEstHGarita").attr("disabled", true);
        $(".ConEstHInicio").attr("disabled", true);
        $(".ConEstHFin").attr("disabled", true);
        $(".ConEstNomEstibas").attr("disabled", true);
        $(".ConEstCantFilm").attr("disabled", true);
        $(".ConEstCantCodigo").attr("disabled", true);
        $(".ConEstCantFecha").attr("disabled", true);
        $(".ConEstCantPallet").attr("disabled", true);
        $(".ConCantBulto").attr("disabled", true);
        $(".ConEstObservacion").attr("disabled", true);
        /*=============================================================
          =            LLENAMOS LOS INPUT CON LA INFORMACIÓN            =
          =============================================================*/
        $(".ConEstidmov").val(respuesta["idmov_recep_desp"]);
        $(".ConEstfecha_programada").val(respuesta["fecha_programada"]);
        $(".ConEstrazonsocial").val(respuesta["cliente"]);
        $(".ConEstactividad").val(respuesta["actividad"]);
        $(".ConEstTransporte").val(respuesta["idtipo_transporte"]);
        $(".ConEstContenedor").val(respuesta["ncontenedor"]);
        $(".ConEstGuias").val(respuesta["nguias"]);
        $(".ConEstHGarita").val(respuesta["h_garita"]);
        $(".ConEstHInicio").val(respuesta["h_inicio"]);
        $(".ConEstHFin").val(respuesta["h_fin"]);
        $(".ConEstNomEstibas").val(respuesta["nombre_estibas"]);
        $(".ConEstCantFilm").val(respuesta["cant_film"]);
        $(".ConEstCantCodigo").val(respuesta["cant_codigo"]);
        $(".ConEstCantFecha").val(respuesta["cant_fecha"]);
        $(".ConEstCantPallet").val(respuesta["cant_pallets"]);
        $(".ConCantBulto").val(respuesta["cant_bultos"]);
        $(".ConEstObservacion").val(respuesta["observaciones_estibas"]);
      }
    },
  });
});

/*FIN ESTIBAS X RECEPCION*/

/*=============================================================
=            SELECCION DE ESTIBAS EN CASO DE QUITO            =
=============================================================*/
$("#Mov-CuadrillaAsignada tbody").on(
  "change",
  ".selectEstibaProg",
  function () {
    var idmovimiento = $(this).attr("idmovimiento");
    var idestiba = $(this).val();
    var inputselect = $(this);
    var datos = new FormData();
    datos.append("asignarCuadrillaMov", idestiba);
    datos.append("idmov", idmovimiento);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/estibas.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta.trim() == "ok") {
          $(inputselect).attr("disabled", true);
          $(inputselect).after(
            "<button data-toggle='tooltip' title='Cambiar Cuadrilla' class='btnEditarAsigCuadrilla btn-sm btn btn-warning'><i class='fas fa-pencil-alt'></i></button>"
          );
          $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
          });
          tablaMov_Cuadri_Asig.ajax.reload();
        }
      },
    });
  }
);

/*====================================================
=            EDITAR LA CUADRILLA EN QUITO            =
====================================================*/
$("#Mov-CuadrillaAsignada tbody").on(
  "click",
  ".btnEditarAsigCuadrilla",
  function () {
    $(this).prev().attr("disabled", false); //quitamos el atributo disabled
    $(this).remove(); // removemos el button
    $('[role="tooltip"]').remove();
  }
);

/*============================================================
=            ONFOCUSOUT AL HACER CHECK TRANSPORTE            =
============================================================*/
$(".responsablechecktrans").focusout(function () {
  var id = $("#idrecepcion").val();
  var nombre = "responsablecheck" + id;
  setCookie(nombre, $(this).val(), 30);
});
/*============================================================
=            ONFOCUSOUT AL HACER CHECK TRANSPORTISTA            =
============================================================*/
$(".transportista").focusout(function () {
  var id = $("#idrecepcion").val();
  var nombre = "transportista" + id;
  setCookie(nombre, $(this).val(), 30);
});
/*============================================================
=            ONFOCUSOUT AL HACER CHECK PLACA            =
============================================================*/
$(".placa").focusout(function () {
  var id = $("#idrecepcion").val();
  var nombre = "placa" + id;
  setCookie(nombre, $(this).val(), 30);
});
/*=======================================================================
=            ONFOCUS AL HACER CHECK OBSERVACONES ADICIONALES            =
=======================================================================*/
$(".obstransporte").focusout(function () {
  var id = $("#idrecepcion").val();
  var nombre = "obstransporte" + id;
  setCookie(nombre, $(this).val(), 30);
});

/*=============================================================
=            CARGAR IMAGENES DURANTE EL CHECK LIST            =
=============================================================*/
var datosImg = [];
var contImg = 0;
var imgTotal = "";
$('input[name="imgCheckTrans[]"]').change(function (e) {
  var idMov = $("#idrecepcion").val();
  var fileInvent = $(this);
  var fileLength = this.files.length;
  let filePath = fileInvent.val();
  var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
  /*===================================================================
  =            VALIDAOS QUE SOLO ACEPTE ARCHIVOS DE IMAGEN            =
  ===================================================================*/
  if (!allowedExtensions.exec(filePath)) {
    Swal.fire({
      title: "Error!",
      text: "Solamente se aceptan archivo de extensión .jpg | .jpeg | .png",
      type: "error",
      confirmButtonText: "Aceptar",
    });
    filePath = "";
    return false;
  } else {
    /*=================================================================
  =            VALIDANOS CANTIDAD DE IMAGENES PERMITIDAS            =
  =================================================================*/
    if (fileLength > 2) {
      Swal.fire({
        title: "Error!",
        text: "Solamente se aceptan 2 Imagenes",
        type: "error",
        confirmButtonText: "Aceptar",
      });
      filePath = "";
      return false;
    } else {
      /*===============================================================================================
    =            MENSAJE PARA QUE REGISTRE LA CLASIFICACION Y EL COMENTARIO DE LA IMAGEN            =
    ===============================================================================================*/
      (async () => {
        const { value: formValues } = await Swal.fire({
          title: "Comentarios de la Imagen",
          allowOutsideClick: false,
          html:
            '<label>Clasificación Fotográfica</label><select id="swal-input1" class="swal2-input">' +
            '<option value="Sellos">Sellos de Transporte</option>' +
            '<option value="Higiene">Condiciones Sanitarias</option>' +
            '<option value="Averia">Producto Averiado</option>' +
            "</select>" +
            '<label>Comentario</label><textarea rows="5" id="swal-input2" class="swal2-input"></textarea>',
          focusConfirm: false,
          preConfirm: () => {
            return [
              document.getElementById("swal-input1").value,
              document.getElementById("swal-input2").value,
            ];
          },
        });
        /*============================================================
=            ALMACENAMOS LA IMAGEN EN EL SERVIDOR            =
============================================================*/
        var datos = new FormData();
        datos.append("fileTemp", $(this)[0].files[0]);
        $.ajax({
          url: rutaOculta + "ajax/estibas.ajax.php",
          method: "POST",
          data: datos,
          cache: false,
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta) {
              /*============================================================
      =            AGREGAMOS LA VISIBLIDAD DE LA IMAGEN            =
      ============================================================*/
              var reader = new FileReader();
              reader.onload = function (e) {
                /*=====================================================
        =            CREAAMOS EL BOTON DE ELIMINAR            =
        =====================================================*/
                var contPrincipal = document.getElementById("C_Img_CheckTra");
                contPrincipal.className = "x_panel";
                var conttextElimina = document.createElement("div");
                conttextElimina.className = "text-center";
                var btnEliminarImg = document.createElement("span");
                btnEliminarImg.style.cursor = "pointer";
                btnEliminarImg.setAttribute(
                  "onclick",
                  "EliminarImgCheckTrans(this)"
                );
                btnEliminarImg.setAttribute("idmov", idMov);
                btnEliminarImg.setAttribute("data_Img", respuesta.substr(3));
                var textElimina = document.createTextNode("Eliminar");
                conttextElimina.appendChild(textElimina);
                btnEliminarImg.appendChild(conttextElimina);
                var img = document.createElement("img");
                img.style.width = "200px";
                img.style.height = "200px";
                img.className = "img-thumbnail";
                img.src = e.target.result;
                var div = document.createElement("div");
                div.className = "col-md-3 text-center"; // colocar clase
                div.appendChild(img);
                div.appendChild(btnEliminarImg);

                if (formValues) {
                  var contComentario = document.createElement("div");
                  var textComentario = document.createTextNode(formValues[1]);
                  contComentario.appendChild(textComentario);
                  var contPrincipal = document.getElementById("C_Img_CheckTra");
                  div.appendChild(contComentario);
                  contPrincipal.appendChild(div);
                  /*==========================================================
        =            ALMACENAMOS LA INFORMACIÓN EN UNA COOKIE            =
        ==========================================================*/
                  // if ((contImg + 1) > 1) {
                  datosImg.push({
                    ImgRecepcion: respuesta.substr(3),
                    comentario: formValues[1],
                    clasificacion: formValues[0],
                  });
                  ImgTotal = JSON.stringify(datosImg);

                  var local = localStorage.getItem("Img" + idMov);
                  if (datosImg.length == 1 && local != null) {
                    // localStorage.getItem("Img"+idMov) != "null" || localStorage.getItem("Img"+idMov) != null
                    var jsonLocalStorage = JSON.parse(
                      localStorage.getItem("Img" + idMov)
                    );
                    datosImg = datosImg.concat(jsonLocalStorage);
                    contImg = datosImg.length - 1;
                    ImgTotal = JSON.stringify(datosImg);
                  }
                  // var imgglobal = JSON.parse(ImgTotal);
                  // datosImg = datosImg.concat(imgglobal);
                  localStorage.setItem("Img" + idMov, ImgTotal);
                  // localStorage.clear();
                  setCookie("Img" + idMov, ImgTotal, 24);
                  // }
                  contImg++;
                  setCookie("cantImg" + idMov, contImg, 24);
                  $("#btnCargar .form-control").text(
                    "Se ha cargado " + contImg + " imagen(es)"
                  );

                  // coment.push(formValues[1]);
                  // clasifoto.push(formValues[0]);
                } else {
                  contPrincipal.appendChild(div);
                  // coment.push(null);
                  // clasifoto.push(formValues[0]);
                }
                // arrayFiles.push($(fileInvent)[0].files[0]);
              };
              reader.readAsDataURL($(fileInvent)[0].files[0]);
            }
          },
        });
      })();
    }
  }
});
function EliminarImgCheckTrans(span) {
  /* ELIMINAR IMAGEN DEL SERVIDOR TEMP */
  /* ELIMINAR ITEM DEL LA VARIABLE GLOBAL */
  var input = $(span).parent();
  var rutaImg = $(span).attr("data_Img");
  var idmov = $(span).attr("idmov");

  var datos = new FormData();
  datos.append("RutaImgTempDelete", rutaImg);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function (respuesta) {
      if (respuesta) {
        /*==============================================================================================
          =            ELIMINAMOS EL ITE DE LA VARIABLE SESSION Y DE LA VARIABLE LOCALSTORAGE            =
          ==============================================================================================*/
        var contenido = JSON.parse(getCookie("Img" + idmov));
        var cantiImg = getCookie("cantImg" + idmov);
        var localstorageValor = JSON.parse(localStorage.getItem("Img" + idmov));
        for (var i = 0; i < contenido.length; i++) {
          if (contenido[i]["ImgRecepcion"] == rutaImg) {
            contenido.splice(i, 1);
            localstorageValor.splice(i, 1);
            cantiImg--;
            setCookie("cantImg" + idmov, cantiImg, 24);
          }
        }
        for (var i = 0; i < datosImg.length; i++) {
          if (datosImg[i]["ImgRecepcion"] == rutaImg) {
            datosImg.splice(i, 1);
          }
        }
        /*==========================================================================
          =            ASIGNAMOS NUEVO VALOR A LA COOKIE Y A LOCALSTORAGE            =
          ==========================================================================*/
        setCookie("Img" + idmov, JSON.stringify(contenido), 24);
        localStorage.setItem("Img" + idmov, JSON.stringify(contenido));
        /*===================================================
          =            ELIMINAMOS LA IMAGEN VISUAL            =
          ===================================================*/
        $("#btnCargar .form-control").text(
          "Se ha cargado " + cantiImg + " imagen(es)"
        );
        $(input).remove();
      }
    },
  });
}
/*====================================================================
=            BOTON DE AVANZAR AL MOMENTO DE UNA RECEPCION            =
====================================================================*/
$(".btn_Avanzar").click(function () {
  var idmov = $("#idrecepcion").val();
  var imagenCargadas = JSON.parse(localStorage.getItem("Img" + idmov));
  // if (imagenCargadas != undefined) {
  // if (imagenCargadas.length > 0){
  var input = $(this);
  $(input).removeClass("btn_Avanzar");
  $(input).addClass("btnCheckRecep");
  $(input).text("Finalizar");
  $(input).attr("onclick", "btnFinalizarRecep()");
  var idMov = $("#idrecepcion").val();
  setCookie("btnAvanza" + idMov, "1", 24);
  $("#C_Img_CheckTra").fadeOut("slow");
  $("#ContDatosCheckRecep").fadeIn("5000");
  var btncargar = $("#btnCargar");
  if (
    getCookie("cantImg" + idmov) == undefined ||
    getCookie("cantImg" + idmov) == 0
  ) {
    $(btncargar).html(
      '<label class="form-control">No se han cargado Imagenes</label>'
    );
  } else {
    $(btncargar).html(
      '<label class="form-control">Se ha cargado ' +
        getCookie("cantImg" + idmov) +
        " Imagen(es)</label>"
    );
  }

  var btnCargarImg = $(".icoCargar").parent();
  $(btnCargarImg).hide();
});
/*==================================================================
=            BOTON DE FINALIZAR CHECK LIST DE RECEPCION            =
==================================================================*/
function btnFinalizarRecep() {
  var idmov = $("#idrecepcion").val();
  /*==================================================================
  =            PRIMERO NECESITAMOS ALMACENAR LAS IMAGENES            =
  ==================================================================*/
  var imagenCargadas = JSON.parse(localStorage.getItem("Img" + idmov));
  var listImgRecep = [];
  var ImgTotal = null;
  var cont = -1;
  var finalfor = 0;
  var responsablechecktrans = $(".responsablechecktrans").val();
  var pptl = $('input[name="pptl"]:checked').attr("id");
  var pa = $('input[name="pa"]:checked').attr("id");
  var mincom = $('input[name="mincom"]:checked').attr("id");
  var plaga = $('input[name="plaga"]:checked').attr("id");
  var oextranios = $('input[name="oextranios"]:checked').attr("id");
  var oquimicos = $('input[name="oquimicos"]:checked').attr("id");
  var sellos = $('input[name="sellos"]:checked').attr("id");
  var transportista = $(".transportista").val();
  var placa = $(".placa").val();
  // var chguias = $(".chguias").val();

  // if (imagenCargadas.length != 0 ){
  if (
    pptl != undefined &&
    pa != undefined &&
    mincom != undefined &&
    plaga != undefined &&
    oextranios != undefined &&
    oquimicos != undefined &&
    sellos != undefined
  ) {
    if (transportista != "" && placa != "" && responsablechecktrans != "") {
      /*==============================================================
      =            RECORREMOS LAS IMAGENES SE HAN AÑADIDO            =
      ==============================================================*/
      if (imagenCargadas != null && imagenCargadas.length != 0) {
        for (var i = 0; i < imagenCargadas.length; i++) {
          var datos = new FormData();
          datos.append("RutaFileRecep", imagenCargadas[i]["ImgRecepcion"]);
          datos.append("idmov", idmov);
          $.ajax({
            url: rutaOculta + "ajax/estibas.ajax.php",
            method: "POST",
            data: datos,
            cache: false,
            contentType: false,
            processData: false,
            success: function (respuesta) {
              cont++;
              if (respuesta) {
                // =========================================================
                // =            REEMPLAMOS LA RUTA DEL DIRECTORIO            =
                // =========================================================
                var rutafinal = respuesta.substr(3);
                // console.log(imagenCargadas);
                // console.log(imagenCargadas[cont].ImgRecepcion);
                // console.log(rutafinal);
                imagenCargadas[cont].ImgRecepcion = rutafinal;
                ImgTotal = JSON.stringify(imagenCargadas);
                if (finalfor + 1 == imagenCargadas.length) {
                  GuardarCheckList(ImgTotal);
                }
                finalfor++;
              }
            },
          });
        }
      } else {
        GuardarCheckList(imagenCargadas);
      }
    } else {
      Swal.fire({
        title: "Es necesario completar toda la información para Continuar...",
        type: "info",
        confirmButtonText: "Aceptar",
      });
    }
  } else {
    Swal.fire({
      title: "Debe llenar todos los items de Check List para Continua...",
      type: "info",
      confirmButtonText: "Aceptar",
    });
  }
}

/*========================================================
=            LLENADO DE DATOS POR LOS ESTIBAS            =
========================================================*/
$(".btnDatosMovEstiba").click(function () {
  var idmov_recep_desp = $(".Estidmov").val();
  var EstTransporte = $(".EstTransporte").val();
  var EstContenedor = $(".EstContenedor").val();
  var EstGuias = $(".EstGuias").val();
  var EstHGarita = $(".EstHGarita").val();
  var EstHInicio = $(".EstHInicio").val();
  var EstHFin = $(".EstHFin").val();
  var EstNomEstibas = $(".EstNomEstibas").val();
  var EstCantFilm = $(".EstCantFilm").val();
  var EstCantCodigo = $(".EstCantCodigo").val();
  var EstCantFecha = $(".EstCantFecha").val();
  var EstCantPallet = $(".EstCantPallet").val();
  var CantBulto = $(".CantBulto").val();
  var EstObservacion = $(".EstObservacion").val();
  var Estidproveedor_estiba = $(".Estidproveedor_estiba").val();
  var Estrazonsocial = $(".Estrazonsocial").val();

  if (
    EstTransporte != "Seleccionar una opción" &&
    EstContenedor != "" &&
    EstGuias != "" &&
    EstHInicio != "" &&
    EstHFin != "" &&
    EstNomEstibas != "" &&
    EstCantFilm != "" &&
    EstCantCodigo != "" &&
    EstCantFecha != "" &&
    EstCantPallet != "" &&
    CantBulto != ""
  ) {
    $(this).attr("disabled", true);
    var datos = new FormData();
    datos.append("DatEst_idmov_recep_desp", idmov_recep_desp);
    datos.append("EstTransporte", EstTransporte);
    datos.append("EstContenedor", EstContenedor);
    datos.append("EstGuias", EstGuias);
    datos.append("EstHGarita", EstHGarita);
    datos.append("EstHInicio", EstHInicio);
    datos.append("EstHFin", EstHFin);
    datos.append("EstNomEstibas", EstNomEstibas);
    datos.append("EstCantFilm", EstCantFilm);
    datos.append("EstCantCodigo", EstCantCodigo);
    datos.append("EstCantFecha", EstCantFecha);
    datos.append("EstCantPallet", EstCantPallet);
    datos.append("CantBulto", CantBulto);
    datos.append("EstObservacion", EstObservacion);
    datos.append("Estrazonsocial", Estrazonsocial);
    $.ajax({
      url: rutaOculta + "ajax/estibas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function (respuesta) {
        if (respuesta == "ok") {
          window.location = "estibas";
        }
      },
    });
  } else {
    Swal.fire({
      title: "Debe completar todos los campos con (*).",
      type: "info",
      confirmButtonText: "Aceptar",
    });
  }
});
/*======================================================
=            FORMATO PARA COLOCAR EL TIEMPO            =
======================================================*/
$(".EstHGarita, .EstHInicio, .EstHFin").datetimepicker({
  startView: 0,
  autoclose: true,
  // minView: 2,
  // maxView: 2,
  format: "hh:ii",
  language: "es",
});
/*==========================================================================================
=            BOTON PARA EDITAR LOS CAMPOS QUE FUERON INGRESADOS POR LAS ESTIBAS            =
==========================================================================================*/
var btnEditarDatEsti = false;
$(".btnEditarDatEst").click(function () {
  if (btnEditarDatEsti) {
    /*============================================
    =            SE BLOQUEA LOS INPUT            =
    ============================================*/
    $(".ConEstTransporte").attr("disabled", true);
    $(".ConEstContenedor").attr("disabled", true);
    $(".ConEstGuias").attr("disabled", true);
    $(".ConEstHGarita").attr("disabled", true);
    $(".ConEstHInicio").attr("disabled", true);
    $(".ConEstHFin").attr("disabled", true);
    $(".ConEstNomEstibas").attr("disabled", true);
    $(".ConEstCantFilm").attr("disabled", true);
    $(".ConEstCantCodigo").attr("disabled", true);
    $(".ConEstCantFecha").attr("disabled", true);
    $(".ConEstCantPallet").attr("disabled", true);
    $(".ConCantBulto").attr("disabled", true);
    // $(".ConEstObservacion").attr("disabled",true);
    $(this).text("Editar");
    btnEditarDatEsti = false;
  } else {
    $(".ConEstTransporte").removeAttr("disabled");
    $(".ConEstContenedor").removeAttr("disabled");
    $(".ConEstGuias").removeAttr("disabled");
    $(".ConEstHGarita").removeAttr("disabled");
    $(".ConEstHInicio").removeAttr("disabled");
    $(".ConEstHFin").removeAttr("disabled");
    $(".ConEstNomEstibas").removeAttr("disabled");
    $(".ConEstCantFilm").removeAttr("disabled");
    $(".ConEstCantCodigo").removeAttr("disabled");
    $(".ConEstCantFecha").removeAttr("disabled");
    $(".ConEstCantPallet").removeAttr("disabled");
    $(".ConCantBulto").removeAttr("disabled");
    // $(".ConEstObservacion").removeAttr("disabled");
    $(this).text("Bloquear");
    btnEditarDatEsti = true;
  }
});
/*==========================================================================
=            CONSULTA DATOS PARA LA CONFIRMACIÓN DEL SUPERVISOR            =
==========================================================================*/
$("#Mov-CuadrillaAsignada tbody").on("click", ".btnConfirmDatos", function () {
  var idmov = $(this).attr("idmov_recep_desp");
  var datos = new FormData();
  datos.append("ConsultConfirmSup", idmov);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      // console.log(respuesta["estado"]);
      if (respuesta["estado"] > 5 && respuesta["idusuarioaprobador"] != null) {
        Swal.fire({
          title: "La actividad ya ha sido aprobada..",
          type: "warning",
          confirmButtonText: "Aceptar",
        });
        tablaMov_Cuadri_Asig.ajax.reload();
      } else {
        $(".modalConfirmSupervisor").modal();
        /*============================================
          =            SE BLOQUEA LOS INPUT            =
          ============================================*/
        $(".ConEstTransporte").attr("disabled", true);
        $(".ConEstContenedor").attr("disabled", true);
        $(".ConEstGuias").attr("disabled", true);
        $(".ConEstHGarita").attr("disabled", true);
        $(".ConEstHInicio").attr("disabled", true);
        $(".ConEstHFin").attr("disabled", true);
        $(".ConEstNomEstibas").attr("disabled", true);
        $(".ConEstCantFilm").attr("disabled", true);
        $(".ConEstCantCodigo").attr("disabled", true);
        $(".ConEstCantFecha").attr("disabled", true);
        $(".ConEstCantPallet").attr("disabled", true);
        $(".ConCantBulto").attr("disabled", true);
        $(".ConEstObservacion").attr("disabled", true);
        /*=============================================================
          =            LLENAMOS LOS INPUT CON LA INFORMACIÓN            =
          =============================================================*/
        $(".ConEstidmov").val(respuesta["idmov_recep_desp"]);
        $(".ConEstfecha_programada").val(respuesta["fecha_programada"]);
        $(".ConEstrazonsocial").val(respuesta["cliente"]);
        $(".ConEstactividad").val(respuesta["actividad"]);
        $(".ConEstTransporte").val(respuesta["idtipo_transporte"]);
        $(".ConEstContenedor").val(respuesta["ncontenedor"]);
        $(".ConEstGuias").val(respuesta["nguias"]);
        $(".ConEstHGarita").val(respuesta["h_garita"]);
        $(".ConEstHInicio").val(respuesta["h_inicio"]);
        $(".ConEstHFin").val(respuesta["h_fin"]);
        $(".ConEstNomEstibas").val(respuesta["nombre_estibas"]);
        $(".ConEstCantFilm").val(respuesta["cant_film"]);
        $(".ConEstCantCodigo").val(respuesta["cant_codigo"]);
        $(".ConEstCantFecha").val(respuesta["cant_fecha"]);
        $(".ConEstCantPallet").val(respuesta["cant_pallets"]);
        $(".ConCantBulto").val(respuesta["cant_bultos"]);
        $(".ConEstObservacion").val(respuesta["observaciones_estibas"]);
      }
    },
  });
});
/*====================================================================
=            BOTON PARA CONFIRMAR DATOS POR EL SUPERVISOR            =
====================================================================*/
$(".btnConfirmarSupervisor").click(function () {
  var ConEstidmov = $(".ConEstidmov").val();
  var ConEstTransporte = $(".ConEstTransporte").val();
  var ConEstContenedor = $(".ConEstContenedor").val();
  var ConEstGuias = $(".ConEstGuias").val();
  var ConEstHGarita = $(".ConEstHGarita").val();
  var ConEstHInicio = $(".ConEstHInicio").val();
  var ConEstHFin = $(".ConEstHFin").val();
  var ConEstNomEstibas = $(".ConEstNomEstibas").val();
  var ConEstCantFilm = $(".ConEstCantFilm").val();
  var ConEstCantCodigo = $(".ConEstCantCodigo").val();
  var ConEstCantFecha = $(".ConEstCantFecha").val();
  var ConEstCantPallet = $(".ConEstCantPallet").val();
  var ConCantBulto = $(".ConCantBulto").val();
  var ConEstObservacion = $(".ConEstObservacion").val();
  var ConEstOrigen = $(".ConEstOrigen").val();
  var ConEstCant_Persona = $(".ConEstCant_Persona").val();
  // var ConEstCD = $(".ConEstCD").val();
  var ConEstObservacionSup = $(".ConEstObservacionSup").val();

  if (
    ConEstOrigen != "" &&
    ConEstTransporte != "Seleccionar una opción" &&
    ConEstContenedor != "" &&
    ConEstGuias != "" &&
    ConEstHGarita != "" &&
    ConEstHInicio != "" &&
    ConEstHFin != "" &&
    ConEstNomEstibas != "" &&
    ConEstCantFilm != "" &&
    ConEstCantCodigo != "" &&
    ConEstCantFecha != "" &&
    ConEstCantPallet != "" &&
    ConCantBulto != "" &&
    ConEstCant_Persona != ""
  ) {
    (async () => {
      const { value: confir } = await Swal.fire({
        type: "warning",
        title: "¿Está seguro de Confrmar la informacióm?",
        text: "¡Si no lo está puede cancelar la accíón!",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Cerrar!",
      });

      if (confir) {
        var datos = new FormData();
        datos.append("ConEstidmovConfSup", ConEstidmov);
        datos.append("ConEstTransporte", ConEstTransporte);
        datos.append("ConEstContenedor", ConEstContenedor);
        datos.append("ConEstGuias", ConEstGuias);
        datos.append("ConEstHGarita", ConEstHGarita);
        datos.append("ConEstHInicio", ConEstHInicio);
        datos.append("ConEstHFin", ConEstHFin);
        datos.append("ConEstNomEstibas", ConEstNomEstibas);
        datos.append("ConEstCantFilm", ConEstCantFilm);
        datos.append("ConEstCantCodigo", ConEstCantCodigo);
        datos.append("ConEstCantFecha", ConEstCantFecha);
        datos.append("ConEstCantPallet", ConEstCantPallet);
        datos.append("ConCantBulto", ConCantBulto);
        datos.append("ConEstObservacion", ConEstObservacion);
        datos.append("ConEstOrigen", ConEstOrigen);
        datos.append("ConEstCant_Persona", ConEstCant_Persona);
        // datos.append("ConEstCD",ConEstCD);
        datos.append("ConEstObservacionSup", ConEstObservacionSup);
        $.ajax({
          data: datos,
          url: rutaOculta + "ajax/estibas.ajax.php",
          type: "POST",
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta == "ok") {
              window.location = "List-Programacion";
            }
          },
        });
      }
    })();
  } else {
    Swal.fire({
      title: "Debe completar todos los campos con (*).",
      type: "info",
      confirmButtonText: "Aceptar",
    });
  }
});
/*=======================================================================
=            MOVIMIENTOS POR CONFIRMAR SUPERVISOR DE MAQUILA            =
=======================================================================*/
$("#TablaMovXConfirmar").DataTable({
  ordering: false,
  ajax: "ajax/TablaConfMovSEstiba.ajax.php",
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});
/*=======================================================================
=            CONFIRMAR DATOS POR PARTE DE SUPERVISOR ESTIBAS            =
=======================================================================*/
$("#TablaMovXConfirmar tbody").on(
  "click",
  ".btnConfirmDatosSupEst",
  function () {
    var idmov = $(this).attr("idmov_recep_desp");
    var datos = new FormData();
    datos.append("ConsultConfirmSup", idmov);
    $.ajax({
      url: rutaOculta + "ajax/estibas.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function (respuesta) {
        /*============================================
        =            SE BLOQUEA LOS INPUT            =
        ============================================*/
        $(".TransporteCSupEst").attr("disabled", true);
        $(".ContenedorCSupEst").attr("disabled", true);
        $(".GuiasCSupEst").attr("disabled", true);
        $(".HGaritaCSupEst").attr("disabled", true);
        $(".HInicioCSupEst").attr("disabled", true);
        $(".HFinCSupEst").attr("disabled", true);
        $(".NomEstibasCSupEst").attr("disabled", true);
        $(".CantFilmCSupEst").attr("disabled", true);
        $(".CantCodigoCSupEst").attr("disabled", true);
        $(".CantFechaCSupEst").attr("disabled", true);
        $(".CantPalletCSupEst").attr("disabled", true);
        $(".CantBultoCSupEst").attr("disabled", true);
        $(".ConEstObservacion").attr("disabled", true);
        $(".ConductoCSupEst").attr("disabled", true);
        $(".PlacaCSupEst").attr("disabled", true);
        $(".OrigenCSupEst").attr("disabled", true);
        $(".Cant_PersonaCSupEst").attr("disabled", true);
        $(".CDCSupEst").attr("disabled", true);
        $(".AprobadonCSupEst").attr("disabled", true);
        /*=============================================================
        =            LLENAMOS LOS INPUT CON LA INFORMACIÓN            =
        =============================================================*/
        $(".idmovCSupEst").val(respuesta["idmov_recep_desp"]);
        $(".fecha_programadaCSupEst").val(respuesta["fecha_programada"]);
        $(".razonsocialCSupEst").val(respuesta["cliente"]);
        $(".actividadCSupEst").val(respuesta["actividad"]);
        $(".TransporteCSupEst").val(respuesta["idtipo_transporte"]);
        $(".ContenedorCSupEst").val(respuesta["ncontenedor"]);
        $(".GuiasCSupEst").val(respuesta["nguias"]);
        $(".HGaritaCSupEst").val(respuesta["h_garita"]);
        $(".HInicioCSupEst").val(respuesta["h_inicio"]);
        $(".HFinCSupEst").val(respuesta["h_fin"]);
        $(".NomEstibasCSupEst").val(respuesta["nombre_estibas"]);
        $(".CantFilmCSupEst").val(respuesta["cant_film"]);
        $(".CantCodigoCSupEst").val(respuesta["cant_codigo"]);
        $(".CantFechaCSupEst").val(respuesta["cant_fecha"]);
        $(".CantPalletCSupEst").val(respuesta["cant_pallets"]);
        $(".CantBultoCSupEst").val(respuesta["cant_bultos"]);
        $(".ObservacionCSupEst").val(respuesta["observaciones_estibas"]);
        $(".ObservacionCSup").val(respuesta["observaciones_sup"]);
        // $(".PlacaCSupEst").val(respuesta["placa"]);
        $(".OrigenCSupEst").val(respuesta["origen"]);
        $(".Cant_PersonaCSupEst").val(respuesta["cant_personas"]);
        $(".CDCSupEst").val(respuesta["idlocalizacion"]);
        $(".AprobadonCSupEst").val(respuesta["aprobadorreport"]);

        // Obtener el idCliente del movimiento
        var idCliente = respuesta["idcliente"];

        // Realizar una solicitud AJAX para obtener las opciones filtradas
        $.ajax({
          url: rutaOculta + "ajax/estibas.ajax.php",
          method: "POST",
          data: { idCliente: idCliente },
          dataType: "json",
          success: function (opciones) {
            var select = $(".TransporteCSupEst");
            select.empty(); // Limpia las opciones existentes
            select.append("<option>Seleccionar una opción</option>");

            // Generar las opciones del select
            opciones.forEach(function (opcion) {
              select.append(
                `<option value="${opcion.idtipo_transporte}">${opcion.descripcion}</option>`
              );
            });

            // Seleccionar la opción correspondiente
            select.val(respuesta["idtipo_transporte"]);
          },
        });

        if (respuesta["estado"] == 7) {
          $(".btnEditarConfSupEst").hide();
          $(".btnConfirmarSupervisorEst").hide();
        } else {
          $(".btnEditarConfSupEst").show();
          $(".btnConfirmarSupervisorEst").show();
        }
      },
      complete: function () {
        button.prop("disabled", false); // Habilita el botón después de completar la solicitud
      },
    });
  }
);
/*======================================================================
=            BOTON DE EDITAR CONFIRMACIÓN SUPERVISOR ESTIBA            =
======================================================================*/
var btnEditarConfSupEst = false;
$(".btnEditarConfSupEst").click(function () {
  if (btnEditarConfSupEst) {
    /*============================================
    =            SE BLOQUEA LOS INPUT            =
    ============================================*/
    $(".TransporteCSupEst").attr("disabled", true);
    $(".ContenedorCSupEst").attr("disabled", true);
    $(".GuiasCSupEst").attr("disabled", true);
    $(".HGaritaCSupEst").attr("disabled", true);
    $(".HInicioCSupEst").attr("disabled", true);
    $(".HFinCSupEst").attr("disabled", true);
    $(".NomEstibasCSupEst").attr("disabled", true);
    $(".CantFilmCSupEst").attr("disabled", true);
    $(".CantCodigoCSupEst").attr("disabled", true);
    $(".CantFechaCSupEst").attr("disabled", true);
    $(".CantPalletCSupEst").attr("disabled", true);
    $(".CantBultoCSupEst").attr("disabled", true);
    $(".Cant_PersonaCSupEst").attr("disabled", true);
    $(".ObservacionCSupEst").attr("disabled", true);
    // $(".ConEstObservacion").attr("disabled",true);
    $(this).text("Editar");
    btnEditarConfSupEst = false;
  } else {
    $(".TransporteCSupEst").removeAttr("disabled");
    $(".ContenedorCSupEst").removeAttr("disabled");
    $(".GuiasCSupEst").removeAttr("disabled");
    $(".HGaritaCSupEst").removeAttr("disabled");
    $(".HInicioCSupEst").removeAttr("disabled");
    $(".HFinCSupEst").removeAttr("disabled");
    $(".NomEstibasCSupEst").removeAttr("disabled");
    $(".CantFilmCSupEst").removeAttr("disabled");
    $(".CantCodigoCSupEst").removeAttr("disabled");
    $(".CantFechaCSupEst").removeAttr("disabled");
    $(".CantPalletCSupEst").removeAttr("disabled");
    $(".CantBultoCSupEst").removeAttr("disabled");
    $(".Cant_PersonaCSupEst").removeAttr("disabled");
    $(".ObservacionCSupEst").removeAttr("disabled");

    // $(".ConEstObservacion").removeAttr("disabled");
    $(this).text("Bloquear");
    btnEditarConfSupEst = true;
  }
});
/*================================================================
=            BOTON DE CONFIRMAR SUPERVISOR DE ESTIBAS            =
================================================================*/
$(".btnConfirmarSupervisorEst").click(function () {
  var idmovCSupEst = $(".idmovCSupEst").val();
  var TransporteCSupEst = $(".TransporteCSupEst").val();
  var ContenedorCSupEst = $(".ContenedorCSupEst").val();
  var GuiasCSupEst = $(".GuiasCSupEst").val();
  var HGaritaCSupEst = $(".HGaritaCSupEst").val();
  var HInicioCSupEst = $(".HInicioCSupEst").val();
  var HFinCSupEst = $(".HFinCSupEst").val();
  var NomEstibasCSupEst = $(".NomEstibasCSupEst").val();
  var CantFilmCSupEst = $(".CantFilmCSupEst").val();
  var CantCodigoCSupEst = $(".CantCodigoCSupEst").val();
  var CantFechaCSupEst = $(".CantFechaCSupEst").val();
  var CantPalletCSupEst = $(".CantPalletCSupEst").val();
  var CantBultoCSupEst = $(".CantBultoCSupEst").val();
  var Cant_PersonaCSupEst = $(".Cant_PersonaCSupEst").val();
  var ObservacionCSupEst = $(".ObservacionCSupEst").val();

  if (
    TransporteCSupEst != "Seleccionar una opción" &&
    ContenedorCSupEst != "" &&
    GuiasCSupEst != "" &&
    HGaritaCSupEst != "" &&
    HInicioCSupEst != "" &&
    HFinCSupEst != "" &&
    NomEstibasCSupEst != "" &&
    CantFilmCSupEst != "" &&
    CantCodigoCSupEst != "" &&
    CantFechaCSupEst != "" &&
    CantPalletCSupEst != "" &&
    CantBultoCSupEst != "" &&
    Cant_PersonaCSupEst != ""
  ) {
    (async () => {
      const { value: confir } = await Swal.fire({
        type: "warning",
        title: "¿Está seguro de Confrmar la informacióm?",
        text: "¡Si no lo está puede cancelar la accíón!",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        confirmButtonText: "Si, Cerrar!",
      });

      if (confir) {
        var datos = new FormData();
        datos.append("idmovCSupEstServ", idmovCSupEst);
        datos.append("TransporteCSupEst", TransporteCSupEst);
        datos.append("ContenedorCSupEst", ContenedorCSupEst);
        datos.append("GuiasCSupEst", GuiasCSupEst);
        datos.append("HGaritaCSupEst", HGaritaCSupEst);
        datos.append("HInicioCSupEst", HInicioCSupEst);
        datos.append("HFinCSupEst", HFinCSupEst);
        datos.append("NomEstibasCSupEst", NomEstibasCSupEst);
        datos.append("CantFilmCSupEst", CantFilmCSupEst);
        datos.append("CantCodigoCSupEst", CantCodigoCSupEst);
        datos.append("CantFechaCSupEst", CantFechaCSupEst);
        datos.append("CantPalletCSupEst", CantPalletCSupEst);
        datos.append("CantBultoCSupEst", CantBultoCSupEst);
        datos.append("Cant_PersonaCSupEst", Cant_PersonaCSupEst);
        datos.append("ObservacionCSupEst", ObservacionCSupEst);
        $.ajax({
          data: datos,
          url: rutaOculta + "ajax/estibas.ajax.php",
          type: "POST",
          contentType: false,
          processData: false,
          success: function (respuesta) {
            if (respuesta == "ok") {
              var contform = document.getElementById("Form_pdf");
              var form = document.createElement("form");
              form.setAttribute("method", "POST");
              form.setAttribute("action", "bpa/Estiba/pdfReportEstiba.php");
              form.setAttribute("target", "_blank");
              /*===============================================
                =            INPUT PARA ENVIAR VALOR            =
                ===============================================*/
              var input = document.createElement("input");
              input.setAttribute("name", "idmov");
              input.setAttribute("value", idmovCSupEst);
              form.appendChild(input);
              contform.appendChild(form);
              window.location = "Mov-XConfirmar";
              form.submit();
            }
          },
        });
      }
    })();
  } else {
    Swal.fire({
      title: "Debe completar todos los campos con (*).",
      type: "info",
      confirmButtonText: "Aceptar",
    });
  }
});

// $('#downloadDataEst').daterangepicker(null, function (start, end, label) {

//   console.log(start.toISOString(), end.toISOString(), label);
// });
// $('#downloadDataEst').daterangepicker(null, function(start, end, label) {
//   console.log('New date range selected: ' + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD') + ' (predefined range: ' + label + ')');
// });

$("#downloadDataEst").daterangepicker(
  {
    minDate: moment().subtract(2, "years"),
  },
  function (startDate, endDate, period) {
    $(this).val(startDate.format("L") + " – " + endDate.format("L"));
  }
);
/*============================================================
=            TABLA DE TRABAJOS REALIZADOS ESTIBAS            =
============================================================*/
$("#TablaOTEstibas").DataTable({
  order: [[4, "desc"]],
  deferRender: true,
  retrieve: true,
  processing: true,
  ajax: "ajax/TablaOTEstibas.ajax.php",
  // "paging":   false,
  language: {
    sProcessing: "Procesando...",
    sLengthMenu: "Mostrar _MENU_ registros",
    sZeroRecords: "No se encontraron resultados",
    sEmptyTable: "Ningún dato disponible en esta tabla",
    sInfo: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_",
    sInfoEmpty: "Mostrando registros del 0 al 0 de un total de 0",
    sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
    sInfoPostFix: "",
    sSearch: "Buscar:",
    sUrl: "",
    sInfoThousands: ",",
    sLoadingRecords: "Cargando...",
    oPaginate: {
      sFirst: "Primero",
      sLast: "Último",
      sNext: "Siguiente",
      sPrevious: "Anterior",
    },
    oAria: {
      sSortAscending: ": Activar para ordenar la columna de manera ascendente",
      sSortDescending:
        ": Activar para ordenar la columna de manera descendente",
    },
  },
});
/*==========================================================
=            VISUALIZAR LA CUADRILLA EL REPORTE            =
==========================================================*/
$("#TablaOTEstibas tbody").on("click", ".btnVisualizarEstiba", function () {
  var idmov = $(this).attr("idmov_recep_desp");
  var datos = new FormData();
  datos.append("ConsultConfirmSup", idmov);
  $.ajax({
    url: rutaOculta + "ajax/estibas.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function (respuesta) {
      /*=============================================================
        =            LLENAMOS LOS INPUT CON LA INFORMACIÓN            =
        =============================================================*/
      $(".idmovCSupEst").val(respuesta["idmov_recep_desp"]);
      $(".fecha_programadaCSupEst").val(respuesta["fecha_programada"]);
      $(".razonsocialCSupEst").val(respuesta["cliente"]);
      $(".actividadCSupEst").val(respuesta["actividad"]);
      $(".TransporteCSupEst").val(respuesta["idtipo_transporte"]);
      $(".ContenedorCSupEst").val(respuesta["ncontenedor"]);
      $(".GuiasCSupEst").val(respuesta["nguias"]);
      $(".HGaritaCSupEst").val(respuesta["h_garita"]);
      $(".HInicioCSupEst").val(respuesta["h_inicio"]);
      $(".HFinCSupEst").val(respuesta["h_fin"]);
      $(".NomEstibasCSupEst").val(respuesta["nombre_estibas"]);
      $(".CantFilmCSupEst").val(respuesta["cant_film"]);
      $(".CantCodigoCSupEst").val(respuesta["cant_codigo"]);
      $(".CantFechaCSupEst").val(respuesta["cant_fecha"]);
      $(".CantPalletCSupEst").val(respuesta["cant_pallets"]);
      $(".CantBultoCSupEst").val(respuesta["cant_bultos"]);
      $(".ObservacionCSupEst").val(respuesta["observaciones_estibas"]);
      $(".OrigenCSupEst").val(respuesta["origen"]);
      $(".Cant_PersonaCSupEst").val(respuesta["cant_personas"]);
      $(".CDCSupEst").val(respuesta["idlocalizacion"]);
    },
  });
});
/*==================================================================================================
=            BOTON DE LA TABLA PARA REPORTAR ELIMINAR UN MOVIMIENTO INDICANDO EL MOTIVO            =
==================================================================================================*/
$("#Mov-CuadrillaAsignada tbody").on("click", ".btnEliminarMov", function () {
  var idMov = $(this).attr("idmov_recep_desp");

  (async () => {
    const { value: motivo } = await Swal.fire({
      type: "warning",
      title: "¿Está seguro de Eliminar el Movimiento",
      input: "textarea",
      inputPlaceholder: "MOTIVO POR EL QUE SE ELIMINA",
      text: "¡Si no lo está puede cancelar la accíón!",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Cerrar!",
      inputValidator: (value) => {
        if (!value) {
          return "Es necesario Colocar el motivo por el cual se elimina!";
        }
      },
    });

    if (motivo) {
      var datos = new FormData();
      datos.append("idMovEliminar", idMov);
      datos.append("motivoEliminar", motivo);

      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/estibas.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            window.location = "List-Programacion";
          }
        },
      });
    }
  })();
});
/*==============================================================
=            CARGAR LOS REGISTROS BAJO LA PLANTILLA            =
==============================================================*/
$('input[name="cargarPlantilla"]').change(function (e) {
  archivo = this.files[0];
  let fileRegistros = $(this);
  let filePath = fileRegistros.val();
  var allowedExtensions = /(.xls|.xlsx|.xlsm)$/i;
  if (!allowedExtensions.exec(filePath)) {
    Swal.fire({
      title: "Error!",
      text: "Solamente se aceptan archivo de extensión .xls | .xlsx | .xlsm",
      type: "error",
      confirmButtonText: "Aceptar",
      icon: "error",
    });
    filePath = "";
    return false;
  } else {
    var texthtml =
      '<div class="col-xs-12 col-md-12">' +
      '<div class="input-group">' +
      '<label class="input-group-addon">Nombre Archivo: *</label>' +
      '<span class="form-control">' +
      archivo.name +
      "</span>" +
      // '<input type="number" class=" uppercase" readonly name="" value="'++'">'+
      "</div>" +
      "</div>";

    Swal.fire({
      title: "<strong>Archivo Cargado</strong>",
      icon: "info",
      html: texthtml,
      width: 500,
      showCloseButton: false,
      showCancelButton: true,
      focusConfirm: true,
      confirmButtonText: "Cargar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        var localizacion = $("#idlocalizacion").val();
        var datos = new FormData();
        datos.append("Cargarplantilla", archivo);
        datos.append("localizacion", localizacion);

        $.ajax({
          data: datos,
          url: rutaOculta + "ajax/estibas.ajax.php",
          type: "POST",
          contentType: false,
          processData: false,
          beforeSend: function () {
            document.getElementById("conte_loading").style.display = "block";
          },
          dataType: "json",
          success: function (respuesta) {
            document.getElementById("conte_loading").style.display = "none";
            $('input[name="cargarPlantilla"]').val("");
            // console.log(respuesta);
            if (respuesta["Incorrectos"].length == 0) {
              Swal.fire(
                "Se ha registrado " +
                  respuesta["Correctos"].length +
                  " Programacion(es) correctamente.",
                "",
                "success"
              );
            } else {
              textohtml =
                '<div class="col-md-12">' +
                "<h4><strong>" +
                respuesta["Correctos"].length +
                "</strong> Importacion(es) Correcta</h4>" +
                // '<div>'+respuesta["Incorrectos"].length+' Registros</div>'+
                "<h4><strong>" +
                respuesta["Incorrectos"].length +
                "</strong> Importacion(es) Incorrecta</h4>" +
                "<div>Revisar las siguientes celdas:</div><br>" +
                "<ol>";
              for (var i = respuesta["Incorrectos"].length - 1; i >= 0; i--) {
                $.each(respuesta["Incorrectos"][i], function (key, value) {
                  textohtml +=
                    "<li> celda: <strong>" +
                    key +
                    "</strong> ===> valor: <strong>" +
                    value +
                    "</strong></li>";
                });
              }

              textohtml += "</ol>" + "</div>";

              Swal.fire({
                type: "warning",
                title: "Datos Importados",
                html: textohtml,
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                allowOutsideClick: false,
              });
            }
          },
        });
      } else {
        $('input[name="cargarPlantilla"]').val("");
      }
    });

    // GuardarDatosPlantilla(archivo); // FUNCION PARA ALMACENAR LOS DATOS DEL ARCHIVO DE EXCEL
  }
});

/*===============================================================================
=            LOGICA PARA NUEVO BOTON            =
===============================================================================*/
// Mostrar el input file al hacer click en el label
$("#btnCargarExcelNuevo").on("click", function () {
  $("#cargarExcelNuevo").click();
});

// Lógica para el nuevo formato de Excel
$('input[name="cargarExcelNuevo"]').change(function (e) {
  var archivo = this.files[0];
  var filePath = $(this).val();
  var allowedExtensions = /(.xls|.xlsx|.xlsm)$/i;
  if (!allowedExtensions.exec(filePath)) {
    Swal.fire({
      title: "Error!",
      text: "Solamente se aceptan archivo de extensión .xls | .xlsx | .xlsm",
      type: "error",
      confirmButtonText: "Aceptar",
      icon: "error",
    });
    $(this).val("");
    return false;
  } else {
    var texthtml =
      '<div class="col-xs-12 col-md-12">' +
      '<div class="input-group">' +
      '<label class="input-group-addon">Nombre Archivo: *</label>' +
      '<span class="form-control">' +
      archivo.name +
      "</span>" +
      "</div>" +
      "</div>";

    Swal.fire({
      title: "<strong>Archivo Cargado</strong>",
      icon: "info",
      html: texthtml,
      width: 500,
      showCloseButton: false,
      showCancelButton: true,
      focusConfirm: true,
      confirmButtonText: "Cargar",
      cancelButtonText: "Cancelar",
    }).then((result) => {
      if (result.isConfirmed) {
        var localizacion = $("#idlocalizacion").val();
        var datos = new FormData();
        datos.append("CargarExcelNuevo", archivo);
        datos.append("localizacion", localizacion);

        $.ajax({
          data: datos,
          url: rutaOculta + "ajax/estibas.ajax.php",
          type: "POST",
          contentType: false,
          processData: false,
          beforeSend: function () {
            document.getElementById("conte_loading").style.display = "block";
          },
          dataType: "json",
          success: function (respuesta) {
            document.getElementById("conte_loading").style.display = "none";
            $('input[name="cargarExcelNuevo"]').val("");
            if (respuesta["Incorrectos"].length == 0) {
              Swal.fire(
                "Se ha registrado " +
                  respuesta["Correctos"].length +
                  " Programacion(es) correctamente.",
                "",
                "success"
              );
            } else {
              var textohtml =
                '<div class="col-md-12">' +
                "<h4><strong>" +
                respuesta["Correctos"].length +
                "</strong> Importacion(es) Correcta</h4>" +
                "<div>" +
                respuesta["Incorrectos"].length +
                " Registros</div>" +
                "<h4><strong>" +
                respuesta["Incorrectos"].length +
                "</strong> Importacion(es) Incorrecta</h4>" +
                "<div>Revisar las siguientes celdas:</div><br>" +
                "<ol>";
              for (var i = respuesta["Incorrectos"].length - 1; i >= 0; i--) {
                $.each(respuesta["Incorrectos"][i], function (key, value) {
                  textohtml +=
                    "<li> celda: <strong>" +
                    key +
                    "</strong> ===> valor: <strong>" +
                    value +
                    "</strong></li>";
                });
              }
              textohtml += "</ol>" + "</div>";
              Swal.fire({
                type: "warning",
                title: "Datos Importados",
                html: textohtml,
                showConfirmButton: true,
                confirmButtonText: "Cerrar",
                allowOutsideClick: false,
              });
            }
          },
        });
      } else {
        $('input[name="cargarExcelNuevo"]').val("");
      }
    });
  }
});

/*===============================================================================
=            EL SUPERVISOR DE ESTIBAS PROCEDE A ANULAR EL TRANSPORTE            =
===============================================================================*/
$("#TablaMovAsigEst tbody").on("click", ".btnEliminarMov", function () {
  var idMov = $(this).attr("idmov_recep_desp");

  (async () => {
    const { value: motivo } = await Swal.fire({
      type: "warning",
      title: "¿Está seguro de Eliminar el Movimiento",
      input: "textarea",
      inputPlaceholder: "MOTIVO POR EL QUE SE ELIMINA",
      text: "¡Si no lo está puede cancelar la accíón!",
      showCancelButton: true,
      confirmButtonColor: "#3085d6",
      cancelButtonColor: "#d33",
      cancelButtonText: "Cancelar",
      confirmButtonText: "Si, Cerrar!",
      inputValidator: (value) => {
        if (!value) {
          return "Es necesario Colocar el motivo por el cual se elimina!";
        }
      },
    });

    if (motivo) {
      var datos = new FormData();
      datos.append("idMovEliminar", idMov);
      datos.append("motivoEliminar", motivo);

      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/estibas.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function (respuesta) {
          if (respuesta == "ok") {
            window.location = "Mov-Programados";
          }
        },
      });
    }
  })();
});

/*==============================================================
=            FILTRO DE PROGRAMADOS Y NO PROGRAMADOS            =
==============================================================*/
$(".filterNP").on("change", function () {
  var columna = $(this).attr("data-column");
  var valor = $(this).val();
  if (valor == "Seleccionar una opción") {
    valor = "";
  }
  tablaMovAsigEst.column(columna).search(valor).draw();
});
