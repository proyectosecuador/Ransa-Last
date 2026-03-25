/*=============================================
=            VALIDACION DE ARCHIVO IMAGEN PRINCIPAL          =
=============================================*/
var imagenPrincipal = null;
$('input[name="archiImg"]').change(function(e) {
  // Options will go here
  imagenPrincipal = this.files[0];
  let fileInvent = $(this);
  let filePath = fileInvent.val();
  var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
  if (!allowedExtensions.exec(filePath)) {
    Swal.fire({
      title: 'Error!',
      text: 'Solamente se aceptan archivo de extensión .jpg | .jpeg | .png',
      type: 'error',
      confirmButtonText: 'Aceptar'
    });
    filePath = '';
    return false;
  } else {
    readURL(this, 0);
  }

});
/*=========================================================
=            FUNCION PARA VISUALIZAR LA IMAGEN            =
=========================================================*/
function readURL(input, con) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var fileLength = input.files.length;
    var filename = input.files[con].name;
    reader.onload = function(e) {
      //debugger;

      var multiple = 1;
      if (input.id == "archiImgRef") {
        var multiples = con + multiple;
        //$("#contimg").append(elemt);
        $(".ImgMultimedia").append('<div class="col-xs-12 col-sm-4 text-center ref">' +
          '<div class="thumbnail text-center">' +
          '<img id="img' + multiples + '" class="animated fadeInDown " src="' + e.target.result + '" style="    max-width: 100%; max-height: 100%">' +
          '</div>' +
          '</div>');


      } else {
        $('.blah').remove();

        $(".ImgPrincipal").append('<div class="col-xs-12 col-md-5 text-center blah">' +
          '<div class="thumbnail text-center">' +
          '<img id="img' + con + '" class="animated fadeInDown  " src="' + e.target.result + '" style="    max-width: 100%; max-height: 100%">' +
          '</div>' +
          '</div>');
        $('#btnCargar .form-control').text(filename);
      }


    }
    reader.readAsDataURL(input.files[con]);
  }
}
/*=============================================
=            VALIDACION DE ARCHIVO IMAGEN REFERENCIALES          =
=============================================*/

$('input[name="archiImgRef[]"]').change(function(e) {
  let fileInvent = $(this);
  var fileLength = this.files.length;
  let filePath = fileInvent.val();
  var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
  if (fileLength > 10) {
    Swal.fire({
      title: 'Error!',
      text: 'Solamente se aceptan 10 Archivos de referencia',
      type: 'error',
      confirmButtonText: 'Aceptar'
    });
    filePath = '';
    return false;
  } else {
    $(".ref").remove();
    $('#btnCargarRef .form-control').text("");
    for (var i = 0; i < fileLength; i++) {
      var file = this.files[i].name;
      if (!allowedExtensions.exec(file)) {
        Swal.fire({
          title: 'Error!',
          text: 'Solamente se aceptan archivo de extensión .jpg | .jpeg | .png',
          type: 'error',
          confirmButtonText: 'Aceptar'
        });
        filePath = '';
        return false;
      } else {

        readURL(this, i);
      }
    }
    $('#btnCargarRef .form-control').append("Ha seleccionado " + fileLength + " archivos");



  }
});
/*=================================================================
=            SELECCIONAR IMAGENES PARA EDITAR PRODUCTO            =
=================================================================*/
var arrayFiles = [];

$(".multimediaFisica").dropzone({

  url: "/",
  addRemoveLinks: true,
  acceptedFiles: "image/jpeg, image/png",
  maxFilesize: 5,
  maxFiles: 10,
  dictRemoveFile: "Eliminar Imagen",
  init: function() {

    this.on("addedfile", function(file) {

      arrayFiles.push(file);

      // console.log("arrayFiles", arrayFiles);

    })

    this.on("removedfile", function(file) {

      var index = arrayFiles.indexOf(file);

      arrayFiles.splice(index, 1);

      // console.log("arrayFiles", arrayFiles);

    })

  }
})

/*===============================================================
=            MOSTRAR INPUT DE IMAGENES REFERENCIALES            =
===============================================================*/
var checkrefer = false;
$("#vischeck label").click(function() {
  var checkkk = $("#checkimgref:checked").length;
  if (checkkk) {
    $("#inputref").show();
    checkrefer = true;
  } else {
    $("#inputref").hide();
    checkrefer = false;
  }
})
/*============================================
=            BTN GUARDAR PRODUCTO            =
============================================*/
function registroProducto() {
  var cliente = $("#cliente").val();
  var codigo = $("#npcodigo").val();
  var tipoubicacion = $("#nptipoubicacion").val();
  var familia = $("#npfamilia").val();
  var grupo = $("#npgrupo").val();
  var descripcion = $("#npdescripcion").val();
  var fileimg = $('input[name="archiImg"]');
  var fileimgref = $('input[name="archiImgRef[]"]');
  if (cliente == "") {
    Swal.fire({
      title: 'Escoge el Cliente.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });
    return false;
  } else if (codigo == "" && tipoubicacion == "" && familia == "" && grupo == "" && descripcion == "") {
    Swal.fire({
      title: 'Error!',
      text: 'Por favor debes llenar toda la información.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });
    return false;
  } else if (fileimg.val() == "") {
    Swal.fire({
      title: 'Selecciona la Imagen Principal.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });
    return false;
  } else if (checkrefer && fileimgref.val() == "") {
    Swal.fire({
      title: 'Selecciona la Imagenes Adicionales.',
      text: "Debe seleccionar de 1 hasta 3 imágenes.. En caso de no necesitar desactive la Casilla",
      type: 'info',
      confirmButtonText: 'Aceptar'
    });
    return false;
  } else {
    return true;
  }

}
/*===============================================
=            BTN CONSULTAR PRODUCTOS            =
===============================================*/
function ConsultarProducto() {
  var id = $("#idcliente").val();

  $("#datatableUserClienteS").DataTable({
    paging: true,
    searching: true,
    destroy: true,
    dom: 'Blfrtip',
    buttons: [
      {
        extend: "excel",
      }
    ],    
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
      "url": rutaOculta + "ajax/TablaProductos.ajax.php",
      "data": function(d) {
        return $.extend({}, d, {
          "idcliente": $("#idcliente").val()
        });
      }
    }
  })
    var datosProducto = new FormData();
  datosProducto.append("ConsultProductoIdCliente", id);
  $.ajax({
      url: rutaOculta + "ajax/productos.ajax.php",
      method: "POST",
      data: datosProducto,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        if (respuesta != ""){
          var rpta = jQuery.parseJSON(respuesta);
          for (var i = 0; i < rpta.length; i++) {
            if (rpta[i]["foto_portada"] == "" || rpta[i]["foto_portada"] == null){
              // console.log(rpta[i]["foto_portada"]);
              
            }
          }
        }

      


      }

  })


}

/*========================================
=            CAMBIO DE ESTADO            =
========================================*/
$('.datatableUserCliente tbody').on("click", ".btnActivar", function() {

  var idProducto = $(this).attr("idProducto");
  var estadoProducto = $(this).attr("estadoProducto");

  var datos = new FormData();
  datos.append("idproducto", idProducto);
  datos.append("estadoProducto", estadoProducto);

  $.ajax({

    url: "ajax/productos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success: function(respuesta) {

      //console.log(respuesta);

    }

  })

  if (estadoProducto == 0) {
    $(this).removeClass('btn-success');
    $(this).addClass('btn-danger');
    $(this).html('Desactivado');
    $(this).attr('estadoProducto', 1);

  } else {
    $(this).addClass('btn-success');
    $(this).removeClass('btn-danger');
    $(this).html('Activado');
    $(this).attr('estadoProducto', 0);

  }

})

function Carrousel() {

  // Can also be used with $(document).ready()
  $('.flexslider').flexslider({
    animation: "slide",
  });
}

function RotarImagenes(){
  var anterior = "";
  var giro = 0;
  $(".btngirarLeft").click(function(){
    var id = $(this).attr("idimagen");
    if (anterior == ""){
      giro -= 90;
      $("#"+id).rotate({animateTo: giro});
      anterior = id;
    }else if (anterior != id){
      giro = 0;
      giro -=90;
      $("#"+id).rotate({animateTo: giro});
      anterior = id;
    }else{
      giro -=90;
      $("#"+id).rotate({animateTo: giro});
      anterior = id;
    }


  })
  $(".btngirarRight").click(function(){
    
    var id = $(this).attr("idimagen");
    if (anterior == ""){
      giro += 90;
      $("#"+id).rotate({animateTo: giro});
      anterior = id;
    }else if (anterior != id){
      giro = 0;
      giro +=90;
      $("#"+id).rotate({animateTo: giro});
      anterior = id;
    }else{
      giro +=90;
      $("#"+id).rotate({animateTo: giro});
      anterior = id;
    }
  })

}

/*===============================================
=            VISUALIZAR LAS IMÁGENES            =
===============================================*/
$('#datatableUserClienteS tbody').on("click", ".visualizar", function() {
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
$(".TablaCliente").DataTable({

  "ajax": "ajax/TablaProductos.ajax.php",
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
/*=====================================================
=            BOTON EDITAR PRODUCTOS                  =
=====================================================*/
$('#datatableUserClienteS tbody').on("click", ".btnEditarProducto", function() {
  var idProducto = $(this).attr("idProducto");

  var datos = new FormData();
  datos.append("IdProducto", idProducto);

  if (window.matchMedia("(max-width:767px)").matches){
    $(".dz-message").html("Haz click para Seleccionar la Imagen");
    //var num = $("#inputEditar .input-lg").length;
    //for (var i = 0; i < num; i++) {
      $("#inputEditar .input-lg").addClass ("input-sm");
      $("#inputEditar .input-lg").removeClass("input-lg");
      
      
    //}
  }
debugger;

  $.ajax({

    url: "ajax/productos.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success: function(respuesta) {
      debugger;
      $("#modalEditarProducto .idProducto").val(respuesta[0]["idproducto"]);
      $("#modalEditarProducto .codigoProducto").val(respuesta[0]["codigo"]);
      $("#modalEditarProducto .tubicacionProducto").val(respuesta[0]["tipubicacion"]);
      $("#modalEditarProducto .familiaProducto").val(respuesta[0]["familia"]);
      $("#modalEditarProducto .grupoProducto").val(respuesta[0]["grupo"]);
      $("#modalEditarProducto .descripcionProducto").val(respuesta[0]["descripcion"]);
      $("#modalEditarProducto .ImgPrincipal").html('<div class="col-xs-12 col-sm-5 text-center blah">' +
        '<div class="thumbnail text-center">' +
        '<img class="" src="' + respuesta[0]['foto_portada'] + '" style=" max-width: 100%; max-height: 100%;">' +
        '</div>' +
        '</div>');
      $("#modalEditarProducto .antiguaFotoPortada").val(respuesta[0]['foto_portada']);
      $("#modalEditarProducto .descripcionTecnica").val(respuesta[0]['desctecnica']);
      $("#modalEditarProducto .ImgMultimedia").html("");
      console.log(respuesta[0]['multimedia']);
      if (respuesta[0]['multimedia'] === null || respuesta[0]['multimedia'] == "null"){
          $("#modalEditarProducto .help-blocks").html("Por el momento no tiene imágenes adicionales");
          $("#modalEditarProducto .ImgMultimedia").html("");
          var vacio = null;
          localStorage.setItem("multimediaFisica", JSON.stringify(vacio));
          //console.log(localStorage.getItem("multimediaFisica"));

      }else {


        if (respuesta[0]['multimedia'].length) {
          var multimedia = JSON.parse(respuesta[0]['multimedia']);
          for (var i = 0; i < multimedia.length; i++) {
            $("#modalEditarProducto .ImgMultimedia").append('<div class=" col-xs-12 col-sm-4 text-center">' +
              '<div class="thumbnail text-center">' +
              '<img class="imagenesRestantes" src="' + multimedia[i]['multimedia'] + '" style="width:100%; height: 165px;">' +
              '<div class="removerImagen" style="cursor:pointer;">Eliminar Imagen</div>' +
              '</div>' +
              '</div>');
            localStorage.setItem("multimediaFisica", JSON.stringify(multimedia));
            //console.log(localStorage.getItem("multimediaFisica"));
          }
        }           
        }


      /*=====  TRAER EL USUARIO QUE INGRESO EL PRODUCTO  ======*/
      var datosUsuario = new FormData();
      datosUsuario.append("idUsuario", respuesta[0]["idusuario"]);

      $.ajax({
        url: "ajax/Usuarios.ajax.php",
        method: "POST",
        data: datosUsuario,
        cache: false,
        contentType: false,
        processData: false,
        dataType: "json",
        success: function(respuesta) {
          debugger;
          $("#modalEditarProducto .usuarioIngreso").val(respuesta["primernombre"] + ' ' + respuesta["primerapellido"]);
          $("#modalEditarProducto .idUsuarioIngreso").val(respuesta["id"]);
        }

      })

      /*=======================================================
      =            REMOVER LAS IMAGENES MULTIMEDIA            =
      =======================================================*/


      $('.removerImagen').click(function() {

        $(this).parent().parent().remove();


        var arrayImgRestantes = [];
        var imagenesRestantes = $(".imagenesRestantes");

        for (var i = 0; i < imagenesRestantes.length; i++) {

          arrayImgRestantes.push({"multimedia": $(imagenesRestantes[i]).attr("src")});

        }
        localStorage.setItem("multimediaFisica", JSON.stringify(arrayImgRestantes));


      })

    }



  })
});

/*===================================================
=            BOTON PARA GUARDAR CAMBIOS            =
===================================================*/

$(".guardarCambiosProducto").click(function() {
  var multimediaFisica = null;
  debugger;
  /*=======================================================
  =            VALIDAR LOS CAMPOS OBLIGATORIOS            =
  =======================================================*/
  if ($("#modalEditarProducto .idProducto").val() != "" &&
    $("#modalEditarProducto .codigoProducto").val() != "" &&
    $("#modalEditarProducto .tubicacionProducto").val() != "" &&
    $("#modalEditarProducto .familiaProducto").val() != "" &&
    $("#modalEditarProducto .grupoProducto").val() != "" &&
    $("#modalEditarProducto .descripcionProducto").val() != "" &&
    $("#modalEditarProducto .usuarioIngreso").val() != "" &&
    $("#modalEditarProducto .idUsuarioIngreso").val() != "" &&
    $("#modalEditarProducto .usuarioModificado").val() != "" &&
    $("#modalEditarProducto .idUsuariomodificador").val() != ""
  ) {

    /*=================================================================
    =            PREGUNTAMOS SI VIENEN IMAGENES MULTIMEDIA            =
    =================================================================*/
    if (arrayFiles.length > 0) {
      var listaMultimedia = [];
      var finalFor = 0;
      var rutaarchi = $("#codigo").val();


      var totalImagen;
      var cantimag = jQuery.parseJSON(localStorage.getItem("multimediaFisica"));

      if (cantimag == null){
         totalImagen =  arrayFiles.length;
      }else{

        totalImagen = cantimag.length + arrayFiles.length;  

      }
      if (totalImagen > 5) {
        Swal.fire({
          title: "Solo se puede subir 5 Imagenes por Producto!!!",
          type: "error",
          confirmButtonText: "¡Cerrar!"
        });
      } else {

        for (var i = 0; i < arrayFiles.length; i++) {
          
          var datosMultimedia = new FormData();
          datosMultimedia.append("file", arrayFiles[i]);
          datosMultimedia.append("ruta", rutaarchi);

          $.ajax({
              url: rutaOculta + "ajax/productos.ajax.php",
              method: "POST",
              data: datosMultimedia,
              cache: false,
              contentType: false,
              processData: false,
              beforeSend: function(){
                $('.gif').html('<div id="conte_loading" class="conte_loading">' +
                                '<div id="cont_gif" >' +
                                '<img src="' + rutaOculta + 'vistas/img/Spin-1s-200px.gif">' +
                                '</div>' +
                                '</div>').show();
              },
              success: function(respuesta){
                
                $(".gif").html("").hide();
                listaMultimedia.push({"multimedia": respuesta.substr(3)});
                multimediaFisica = JSON.stringify(listaMultimedia);

              
                if (localStorage.getItem("multimediaFisica") != "null") {

                  var jsonLocalStorage = JSON.parse(localStorage.getItem("multimediaFisica"));

                  var jsonMultimediaFisica = listaMultimedia.concat(jsonLocalStorage);

                  multimediaFisica = JSON.stringify(jsonMultimediaFisica);
                }
                

                if ((finalFor + 1) <= arrayFiles.length){


                  editarProductos(multimediaFisica);

                }

                finalFor++;

              }
          })
          
        }
        
      }



    } else {
      var jsonLocalStorage = JSON.parse(localStorage.getItem("multimediaFisica"));

      multimediaFisica = JSON.stringify(jsonLocalStorage);

      editarProductos(multimediaFisica);

    }

  } else {
    Swal.fire({
      title: "Llenar todos los campos obligatorios",
      type: "error",
      confirmButtonText: "¡Cerrar!"
    });

    return;

  }
})

function editarProductos(imagen){

  var idproducto =      $("#modalEditarProducto .idProducto").val();
  var codigoproducto =  $("#modalEditarProducto .codigoProducto").val();
  var tipoubicacion =  $("#modalEditarProducto .tubicacionProducto").val();
  var familia =  $("#modalEditarProducto .familiaProducto").val();
  var grupo =  $("#modalEditarProducto .grupoProducto").val();
  var descripcion =  $("#modalEditarProducto .descripcionProducto").val();
  var idcliente =  $("#idcliente").val();
  var codigocliente =  $("#codigo").val();
  var idusuario =  $("#modalEditarProducto .idUsuariomodificador").val();
  var foto_portada_antigua =  $("#modalEditarProducto .antiguaFotoPortada").val();
  var descriptecnica =  $("#modalEditarProducto .descripcionTecnica").val();

  var datosProducto = new FormData();
  datosProducto.append("idproductos", idproducto);
  datosProducto.append("codigo", codigoproducto);
  datosProducto.append("tubicacion", tipoubicacion);
  datosProducto.append("familia", familia);
  datosProducto.append("grupo", grupo);
  datosProducto.append("descripcion", descripcion);
  datosProducto.append("codigocliente", codigocliente);
  datosProducto.append("idusuario", idusuario );
  datosProducto.append("descriptecnica", descriptecnica );
  datosProducto.append("portada_antigua", foto_portada_antigua );
  datosProducto.append("imagen_principal", imagenPrincipal );
  datosProducto.append("multimedia", imagen);

  $.ajax({
      url: rutaOculta + "ajax/productos.ajax.php",
      method: "POST",
      data: datosProducto,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){
        debugger;
        if(respuesta == "ok"){

          Swal.fire({
            type: "success",
            title: "El producto ha sido cambiado correctamente",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
            localStorage.removeItem("multimediaFisica");
            localStorage.clear();
            window.location = "estadoproducto";

            }
          })
        }

      }

  })


}

$('#datatableUserClienteS tbody').on("click", ".btnEliminarProducto", function() {
  var idproducto = $(this).attr("idProducto");

  Swal.fire({
  type: "warning",
  title: "¿Está seguro de borrar el producto?",
  text: "¡Si no lo está puede cancelar la accíón!",
  showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, borrar producto!'
  }).then(function(result){
  if (result.value) {

    var datosProducto = new FormData();
    datosProducto.append("idproductoEliminar", idproducto);
    datosProducto.append("eliminar", 2);

    $.ajax({
      url: rutaOculta + "ajax/productos.ajax.php",
      method: "POST",
      data: datosProducto,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta){

      if(respuesta == "ok"){

        Swal.fire({
            type: "success",
            title: "El producto ha sido borrado correctamente",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {

                window.location = "estadoproducto";

                }
              })
        }


      }

    })

  }
})



})