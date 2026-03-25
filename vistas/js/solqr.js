 //$("body").on("contextmenu",function(e){
   //return false;
  //});

/*===================================================
=            TABLA DE QUEJAS Y RECLAMMOS            =
===================================================*/
var tblSQR =  $("#SolQR").DataTable({
  "columnDefs": [
      {
          "targets": [ 11 ],
          "visible": false,
         "searchable": false
      }    
  ],
  "scrollY":        '60vh',
  "scrollX": true,
  "select": {
            style: 'single'
        },
  "ajax": "ajax/TablaSolQR.ajax.php",
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "language": {
    "select":{
      "rows":{
          _: "Seleccionado %d fila",
      }

    },

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
/*===============================================
=            CUADRO DE ITEMS INMOVIL            =
===============================================*/

var scroll = $("#cuadroItem").hasClass("cuadroItem");
if (scroll) {
  window.onscroll = function(){InmovilizarCuadro()};
    var header = document.getElementById("cuadroItem");
    var sticky =  header.offsetTop;
    function InmovilizarCuadro() {
      if (window.pageYOffset > sticky) {
        header.classList.add("sticky");
      } else {
        header.classList.remove("sticky");
      }
    }
}
/*======================================================
=            EVENTO AL SELECCIONAR UNA FILA            =
======================================================*/
tblSQR.on('user-select',function(e,dt,type,cell,originalEvent){
    if ( $(originalEvent.target).index() === 9 || originalEvent.target.nodeName.toLowerCase() === "div" || originalEvent.target.nodeName.toLowerCase() === "button" || originalEvent.target.nodeName.toLowerCase() === "i" || originalEvent.target.nodeName.toLowerCase() === "form") {
        e.preventDefault();
    }
}).on('select',function(e,dt,type,indexes){
  var rowData = tblSQR.rows(indexes).data().toArray();
  var arrayQueja = ["Registro","Clasificación","Investigación","Respuesta al Cliente","Seguimiento"];
  var filtroQ = ["javascript:Registro()","javascript:Clasificacion()","javascript:Investigacion()","javascript:Respuesta()","javascript:Seguimiento()"];
  var filtroR = ["javascript:Registro()","javascript:Clasificacion()","javascript:Investigacion()","javascript:Respuesta()","javascript:Negociacion()","javascript:Seguimiento()"];
  var arrayReclamo =   ["Registro","Clasificación","Investigación","Respuesta al Cliente","Negociación Cliente","Seguimiento"];
  var html = '<ul class="view-steps anchor">';
  var classe = "";
  if (rowData[0][2] == "Queja"){
    for (var i = 0; i < arrayQueja.length; i++) {
      var valor = parseInt(rowData[0][11]); 
      if ((i+1) <= valor){
        classe = "selectedd";
      }else{
        classe = "";
      }
      html += '<li>'+
          '<a  class="'+classe+' valoritem" href="'+filtroQ[i]+'">'+
            '<span data-placement="bottom" id="'+(i+1)+'popover" class="itemno">'+(i+1)+'</span>'+
            '<span>'+arrayQueja[i]+'</span>'+
          '</a>'+
        '</li>';      
         
    }
  }else{
    for (var i = 0; i < arrayReclamo.length; i++) {
      var valor = parseInt(rowData[0][11]); 
      if ((i+1) <= valor){
        classe = "selectedd";
      }else{
        classe = "";
      }
      html += '<li>'+
          '<a class="'+classe+' valoritem" href="'+filtroR[i]+'">'+
            '<span data-placement="bottom" id="'+(i+1)+'popover" class="itemno">'+(i+1)+'</span>'+
            '<span>'+arrayReclamo[i]+'</span>'+
          '</a>'+
        '</li>';      

    }    

  }
html += '</ul>';

  $("#ItemProceso").html(html);
  /*==============================================
  =            PRESENTAMOS EL POPOVER Y REALIZAMOS LA CONSULTA AL SERVIDOR SEGUN EL CODIGO            =
  ==============================================*/
    var datos = new FormData();
    datos.append("popovercodigo",rowData[0][0]);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
    // beforeSend: function(){
    //    document.getElementById("conte_loading").style.display = "block";
    // },
    dataType: "json",
    success: function(respuesta) {
        if (rowData[0][2] == "Queja"){
          for (var i = 0; i < arrayQueja.length; i++) {
              if ((i+1) == 1) {

                
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Creado:</strong> "+respuesta["fecha_registro"]+"</span><br>"+
                                                          "<span><strong>Tipo:</strong> "+respuesta["tipo_novedad"]+"</span><br>"+
                                                          "<span><strong>F. Novedad:</strong> "+respuesta["fecha_novedad"]+"</span><br>"+
                                                          "<span><strong>Organización:</strong> "+respuesta["organizacion"]+"</span><br>"+
                                                          "<span><strong>Reportado por:</strong> "+respuesta["nombre_regist"]+"</span>", 
                                                trigger: "hover",html:true}); 
              }else if ((i+1) == 2) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha Clasif:</strong> "+respuesta["fecha_clasificacion"]+"</span><br>"+
                                                "<span><strong>Asignado Por:</strong> "+respuesta["userAsignador"]+"</span><br>"+
                                                "<span class='text-break'><strong>Responsable(s): </strong> "+respuesta["usuariosrespon"]+"</span><br>"+
                                                "<span class='text-break'><strong>Seguimiento Cliente: </strong> "+respuesta["userNegocio"]+"</span>", 
                                                trigger: "hover",html:true});

              }else if ((i+1) == 3) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha:</strong> "+respuesta["fecha_doc_cargado"]+"</span><br>"+
                                                "<span><strong>Doc. Análisis:</strong> "+respuesta["doc_cargado"]+"</span><br>"+
                                                "<span><strong>Cargado por:</strong> "+respuesta["userCargaAnalisis"]+"</span><br>"+
                                                "<span><strong>Fecha Aprob.:</strong> "+respuesta["fecha_doc_aprobado"]+"</span><br>"+
                                                "<span><strong>Aprobado por:</strong> "+respuesta["userAprobadorAnali"]+"</span>",
                                                trigger: "hover",html:true});

              }else if ((i+1) == 4) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha:</strong> "+respuesta["fecha_Resp_Cliente"]+"</span><br>"+
                                                "<span><strong>Enviado por:</strong> "+respuesta["userRespuestaEnv"]+"</span><br>"+
                                                "<span class='text-break'><strong>Notificado a:</strong>"+respuesta["notificadoa"]+"</span><br>",
                                                trigger: "hover",html:true});                


              }else if ((i+1) == 5) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha:</strong> "+respuesta["fecha_obs_calidad"]+"</span><br>"+
                                                "<span><strong>Usuario Calidad:</strong> "+respuesta["usuario_seguimiento_calidad"]+"</span><br>"+
                                                "<span><strong>Fecha Negocio:</strong> "+respuesta["fecha_obs_negocio"]+"</span><br>"+
                                                "<span><strong>Usuario Negocio:</strong> "+respuesta["usuario_seguimiento_negocio"]+"</span>",
                                                trigger: "hover",html:true});                

              }
              
            // }
          }
        }else{
          for (var i = 0; i < arrayReclamo.length; i++) {
              if ((i+1) == 1) {

                
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Creado:</strong> "+respuesta["fecha_registro"]+"</span><br>"+
                                                          "<span><strong>Tipo:</strong> "+respuesta["tipo_novedad"]+"</span><br>"+
                                                          "<span><strong>F. Novedad:</strong> "+respuesta["fecha_novedad"]+"</span><br>"+
                                                          "<span><strong>Organización:</strong> "+respuesta["organizacion"]+"</span><br>"+
                                                          "<span><strong>Reportado por:</strong> "+respuesta["nombre_regist"]+"</span>", 
                                                trigger: "hover",html:true}); 
              }else if ((i+1) == 2) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha Clasif:</strong> "+respuesta["fecha_clasificacion"]+"</span><br>"+
                                                "<span><strong>Asignado Por:</strong> "+respuesta["userAsignador"]+"</span><br>"+
                                                "<span class='text-break'><strong>Responsable(s): </strong> "+respuesta["usuariosrespon"]+"</span><br>"+
                                                "<span class='text-break'><strong>Seguimiento Cliente: </strong> "+respuesta["userNegocio"]+"</span>", 
                                                trigger: "hover",html:true});

              }else if ((i+1) == 3) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha:</strong> "+respuesta["fecha_doc_cargado"]+"</span><br>"+
                                                "<span><strong>Doc. Análisis:</strong> "+respuesta["doc_cargado"]+"</span><br>"+
                                                "<span><strong>Cargado por:</strong> "+respuesta["userCargaAnalisis"]+"</span><br>"+
                                                "<span><strong>Fecha Aprob.:</strong> "+respuesta["fecha_doc_aprobado"]+"</span><br>"+
                                                "<span><strong>Aprobado por:</strong> "+respuesta["userAprobadorAnali"]+"</span>",
                                                trigger: "hover",html:true});

              }else if ((i+1) == 4) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha:</strong> "+respuesta["fecha_Resp_Cliente"]+"</span><br>"+
                                                "<span><strong>Enviado por:</strong> "+respuesta["userRespuestaEnv"]+"</span><br>"+
                                                "<span class='text-break'><strong>Notificado a:</strong>"+respuesta["notificadoa"]+"</span><br>",
                                                trigger: "hover",html:true});                


              }else if ((i+1) == 5) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha:</strong> "+respuesta["fecha_negociacion"]+"</span><br>"+
                                                "<span><strong>Usuario Negociación:</strong> "+respuesta["usuario_Negociacion"]+"</span><br>",
                                                trigger: "hover",html:true});                

              }else if ((i+1) == 6) {
                $('#'+(i+1)+'popover').popover({title: "<strong>Solicitud "+respuesta["codigoSolicitud"]+"</strong>", 
                                                content: "<span><strong>Fecha:</strong> "+respuesta["fecha_obs_calidad"]+"</span><br>"+
                                                "<span><strong>Usuario Calidad:</strong> "+respuesta["usuario_seguimiento_calidad"]+"</span><br>"+
                                                "<span><strong>Fecha Negocio:</strong> "+respuesta["fecha_obs_negocio"]+"</span><br>"+
                                                "<span><strong>Usuario Negocio:</strong> "+respuesta["usuario_seguimiento_negocio"]+"</span>",
                                                trigger: "hover",html:true});  

              }
          }    

        }
    }
    });

}).on( 'deselect', function ( e, dt, type, indexes ) {
    var rowData = tblSQR.rows( indexes ).data().toArray();
  var html = '<ul class="view-steps anchor">'+
        '<li>'+
          '<a href="javascript:Registro()">'+
            '<span class="itemno">1</span>'+
            '<span>Registro</span>'+
          '</a>'+
        '</li>'+
        '<li>'+
          '<a href="javascript:Clasificacion()">'+
            '<span class="itemno">2</span>'+
            '<span>Clasificación</span>'+
          '</a>'+
        '</li>       '+
        '<li>'+
          '<a href="javascript:Investigacion()">'+
            '<span class="itemno">3</span>'+
            '<span>Investigación</span>'+
          '</a>'+
        '</li>'+
        '<li>'+
          '<a href="javascript:Respuesta()">'+
            '<span class="itemno">4</span>'+
            '<span>Respuesta al Cliente</span>'+
          '</a>'+
        '</li>'+
        '<li>'+
          '<a href="">'+
            '<span class="itemno">5</span>'+
            '<span>Seguimiento</span>'+
          '</a>'+
        '</li>'+
      '</ul>';    

    $("#ItemProceso").html(html);
} );



/*=======================================================================
=            MULTI SELECT PARA ASIGNAR USUARIOS RESPONSABLES            =
=======================================================================*/
$('#UsuaiosxNegocio').multiSelect({
  selectableHeader: "<div class='custom-header bg-primary'>Usuarios Disponiles</div>",
  selectionHeader: "<div class='custom-header bg-primary'>Usuarios a Notificar</div>",
  // selectableFooter: "<div class='custom-header'>Selectable footer</div>",
  // selectionFooter: "<div class='custom-header'>Selection footer</div>"
});
$('#UsuaiosxNegocioEdit').multiSelect({
  selectableHeader: "<div class='custom-header bg-primary'>Usuarios Disponiles</div>",
  selectionHeader: "<div class='custom-header bg-primary'>Notificado a:</div>",
  // selectableFooter: "<div class='custom-header'>Selectable footer</div>",
  // selectionFooter: "<div class='custom-header'>Selection footer</div>"
});
$(".chosenmultiple").chosen({width: "100%"});
/*=================================================================================
=            BOTON PARA ABRIR EL MODAL Y ASIGNAR USUARIOS RESPONSABLES            =
=================================================================================*/
$('#SolQR tbody').on("click", ".btnAsignarResponsable", function() {
  var idSolQR = $(this).attr("idsolicitudes_qr");
  // var userresponsable = $(this).attr("userresponsable");
  $("#idsoliciudes").val(idSolQR);
  $('#UsuaiosxNegocio').multiSelect('deselect_all');
  // if (userresponsable != "") { 
  //   $(".msjestadoresponsable").html('<div class="alert alert-warning alert-dismissible fade in">'+
  //                 '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
  //                 '<strong>NOTA:</strong> Se ha solicitado una Re-Clasificación.'+
  //               '</div>');
  // }
  

})

/*========================================================================
=            BOTON PARA NOTIFICAR A LOS USUARIOS RESPONSABLES            =
========================================================================*/
$(".ClasifiRespon").click(function(){
  var responsables = $("#UsuaiosxNegocio option:selected").toArray().map(item => item.value);
  var idSolQR = $("#idsoliciudes").val();
  var ejecNegocio = $("#ejecutivoNegocio option:selected").val();

  if (responsables.length > 0 && ejecNegocio != ""){
     Array.prototype.unique=function(a){
      return function(){return this.filter(a)}}(function(a,b,c){return c.indexOf(a,b+1)<0
    });

        var datos = new FormData();
        datos.append("idusuariosnoti",JSON.stringify(responsables.unique()));
        datos.append("idsolicitudes_qr",idSolQR);
        datos.append("iduserNegocioAsig",ejecNegocio);
        
        $.ajax({
          data: datos,
          url: rutaOculta + "ajax/solqr.ajax.php",
          type: "POST",
          contentType: false,
          processData: false,
        beforeSend: function(){
           document.getElementById("conte_loading").style.display = "block";
        },
        success: function(respuesta) {
          if (respuesta == 1){
            window.location = "Q-R";
          }else{
            Swal.fire({
              type: "error",
              title: "No se podido notificar a los usuarios",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
              if (result.value) {
              window.location = "Q-R";
              }
            })
          document.getElementById("conte_loading").style.display = "none";  
          }

        }

        });
  }else{
    Swal.fire({
      title: 'Advertencia!',
      text: 'Es necesario llenar todos los campos.',
      type: 'warning',
      confirmButtonText: 'Aceptar'
    });    

  }

  
})
/*==================================================
=            FUNCION PARA FILTRAR TABLA            =
==================================================*/
function Registro(){
  tblSQR.columns(11).search(1).draw();
}
function Clasificacion(){
 tblSQR.columns(11).search(2).draw(); 
}
function Investigacion(){
 tblSQR.columns(11).search(3).draw(); 
}
function Respuesta(){
 tblSQR.columns(11).search(4).draw(); 
}
function Negociacion(){
  tblSQR.columns(2).search("Reclamo").draw(); 
  tblSQR.columns(11).search(5).draw(); 
}
function Seguimiento(){
 tblSQR.columns(11).search(6).draw(); 
 // tblSQR.columns(11).search(6).draw(); 
}
/*====================================================================
=            ADJUNTAR DOCUMENTO DE ANALISIS DE CAUSA RAIZ            =
====================================================================*/
$('input[name="arcCausaR"]').change(function(e){
  // Options will go here
  let fileInvent = $(this);
  let filePath = fileInvent.val();
  var allowedExtensions = /(.xls|.xlsx|.xlsm)$/i;
  if (!allowedExtensions.exec(filePath)) {
    Swal.fire({
      title: 'Error!',
      text: 'Solamente se aceptan archivo (Excel) de extensión .xlsx',
      type: 'error',
      confirmButtonText: 'Aceptar'
    });
    filePath = '';
    $(this).val(null);
    return false;
  } else {
    $("#btnCargarCausa .form-control").html(function() {
      return "<div>" + fileInvent.prop('files')[0].name + "</div>";
    });
  }
});
/*====================================================================
=            ABRIR MODAL PARA ADJUNTAR ARCHIVO CAUSA RAIZ            =
====================================================================*/
$('#SolQR tbody').on("click", ".btnInvestigacion", function() {
  var idSolQR = $(this).attr("idsolicitudes_qr");
  var estadoAnalisi = $(this).attr("estadoAnalisis");
  $("#idsoliciudesDoc").val(idSolQR);
  if (estadoAnalisi == "REVISAR") {
      $(".msjestado").html('<div class="alert alert-warning alert-dismissible fade in">'+
                  '<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>'+
                  '<strong>NOTA:</strong> El area de calidad a solicitado que se proceda con la revisión del análisis realizado.'+
                '</div>');
  }

})
/*====================================================
=            ENVIAR ARCHIVO DE CAUSA RAIZ            =
====================================================*/
$(".EnviarCr").click(function(){
  var idSolQR = $("#idsoliciudesDoc").val();
  var filecr = $('input[name="arcCausaR"]');
  var archivo = $('input[name="arcCausaR"]')[0].files[0];
  var coment = $(".comentCR").val();
  var stado = 0;
  if ($(".NPertenece").is(':checked')){
    stado = "NO-PERTENECE";
    archivo = null;
  }else{
    stado = "DOC-CARGADO";
  }
  // la novedad no pertence al area de almacen por errror de distribucion
  if (filecr.val() == "" && stado == "DOC-CARGADO") {
    Swal.fire({
      title: 'Selecciona el archivo.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });
  }else{
  var datos = new FormData();
  datos.append("RespuestaestadoAnalisis",stado);
  datos.append("filecr",archivo);
  datos.append("motivo",coment); 
  datos.append("idSolQRCausa",idSolQR);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
    beforeSend: function(){
       document.getElementById("conte_loading").style.display = "block";
    },
    success: function(respuesta) {
      if (respuesta == 1){
        window.location = "Q-R";
      }
    }

    });
  }

})
/*================================================================
=            BOTON PARA ARIR MENU DE APROBAR ANALISIS            =
================================================================*/
$('#SolQR tbody').on("click", ".btnAprobarCR", function() {
  var idSolQR = $(this).attr("idsolicitudes_qr");
  var rutaArchivo = $(this).attr("rutaAnalisis");
  var estadoAnalisi = $(this).attr("estadoAnali");
  var Usuariorespu = $(this).attr("userRespuesta");
  var comentarios = $(this).attr("coment-analisis");
  $("#idaprobar").val(idSolQR); 
  $("#detalle_investigacion").val($(this).attr("iddetalle_investi"));
  var contenedor = document.getElementById("visualizacion_Analisis");
  contenedor.innerHTML = "";
  var contenido = "";
  if (estadoAnalisi == "NO-PERTENECE"){
    var btnAprobar = $(".btnAprobarAnalisis").attr("disabled",true);
    $(".btnAprobarAnalisis").removeClass("btnAprobarAnalisis");
    contenido = document.createElement("div");
    contenido.className ="bs-example col-xs-12"
    div1 = document.createElement("div");
    texto = document.createTextNode("El usuario "+Usuariorespu+" notifica que no le pertenece la solicitud asignada.")
    div1.className = "jumbotron";
    div1.appendChild(texto)
    contenido.appendChild(div1);

  }else{
    $(".btnAprobarAnalisis").attr("disabled",false);
    var div = document.createElement("div");
    var label = document.createElement("label");
    var nodetextform = document.createTextNode("Solamente es visual, no se podrá editar ni eliminar contenido.");
    label.appendChild(nodetextform);
    div.appendChild(label);

    contenido = document.createElement('iframe');
    contenido.src = '//view.officeapps.live.com/op/embed.aspx?src='+rutaArchivo;
    contenido.style.width = '100%';
    contenido.height = '400px';
    contenedor.appendChild(div);
  }

  
  var div2 = document.createElement('div');
  div2.className = "text-center";
  var nodetext = document.createTextNode("Comentarios Adicionales: "+comentarios);
  div2.appendChild(nodetext)

  contenedor.appendChild(contenido);
  contenedor.appendChild(div2);
})
/*==================================================
=            BOTON DE RECHAZAR ANALISIS            =
==================================================*/
$(".btnRechazarAnalisis").click(function(){
  var idSolQR = $("#idaprobar").val();
  // var idDetalleInvesti = $("#detalle_investigacion").val();

  (async () => {
const { value: motivo } = await Swal.fire({
  type: "warning",
  title: "¿Está seguro de volver a Revisar Análisis?",
  input: "textarea",
  inputPlaceholder: "Escriba el motivo u observaciones",
  text: "¡Si no lo está puede cancelar la accíón!",
  showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, Cerrar!',
  inputValidator: (value) => {
    if (!value) {
      return 'Es necesario Colocar el motivo!'
    }
  }      
})

if (motivo) {
  var datos = new FormData();
    datos.append("idSolQRRevisar",idSolQR);
    datos.append("motivobloq", motivo);
    // datos.append("idDetalleInvesti", idDetalleInvesti);
    datos.append("estado_analisis", "REVISAR");

    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      beforeSend: function(){
         document.getElementById("conte_loading").style.display = "block";
      },      
      success: function(respuesta) {
        // debugger;
        // $(button).attr("idcheck",respuesta);
        // var input  = $('button[idcheck="'+respuesta+'"]').parent();
        window.location = "Q-R";

      }
    });
}

})()
})
/*=================================================
=            BOTON DE APROBAR ANALISIS            =
=================================================*/
$(".btnAprobarAnalisis").click(function(){
  var idSolQR = $("#idaprobar").val();
  var datos = new FormData();
  datos.append("idSolQRCausaAprobar",idSolQR);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
    beforeSend: function(){
       document.getElementById("conte_loading").style.display = "block";
    },
    success: function(respuesta) {
      if (respuesta == 1){
        window.location = "Q-R";
      }
    }
    });
})
/*================================================================
=            EDITAR LOS DATOS DE LA NOVEDAD REPORTADA            =
================================================================*/
$('#SolQR tbody').on("click", ".btnEditQR", function() {
    var idSolQR = $(this).attr("idsolicitudes_qr");
    $("#idsoliciudesEdit").val(idSolQR);

})
/*===============================================================================
=            BOTON DE ELIMINAR FILTRO DE DATATABLE QUEJAS Y RECLAMOS            =
===============================================================================*/
$(".btnElimFilQR").click(function(){
  tblSQR.columns().search("").draw();
})
/*===========================================================
=           ESTILO DE CHECK BOX NO ME PERTENECE            =
===========================================================*/
$(".NPertenece").iCheck({
  checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
})
/*=============================================
=            ACCION AL HACER CLICK NO PERTENECE            =
=============================================*/
$('.NPertenece').on('ifToggled', function(event){
  if ($(this).is(':checked')){
    $("#arcCausaR").attr("disabled",true);
    $("#arcCausaR").parent().css('cursor', 'not-allowed');
    $("#arcCausaR").val(null);
    $("#btnCargarCausa .form-control").html("");
    $(".comentCR").attr("disabled",true);
  (async () => {
const { value: motivo } = await Swal.fire({
  type: "warning",
  title: "¿Está seguro que no le pertenece el Análisis?",
  input: "textarea",
  inputPlaceholder: "Escriba el motivo u observaciones",
  allowOutsideClick: false,
  text: "¡Si no lo está puede cancelar la accíón!",
  showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, Cerrar!',
  inputValidator: (value) => {
    if (!value) {
      return 'Es necesario Colocar el motivo!'
    }
  }      
})

if (motivo) {
  var idSolQR = $("#idsoliciudesDoc").val();
  var filecr = $('input[name="arcCausaR"]');
  var archivo = $('input[name="arcCausaR"]')[0].files[0];
  var stado = 0;
  if ($(".NPertenece").is(':checked')){
    stado = "NO-PERTENECE";
    archivo = null;
  }else{
    stado = "DOC-CARGADO";
  }
  // la novedad no pertence al area de almacen por errror de distribucion
  if (filecr.val() == "" && stado == "DOC-CARGADO") {
    Swal.fire({
      title: 'Selecciona el archivo.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });
  }else{
  var datos = new FormData();
  datos.append("RespuestaestadoAnalisis",stado);
  datos.append("filecr",archivo);
  datos.append("motivo",motivo); 
  datos.append("idSolQRCausa",idSolQR);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
    beforeSend: function(){
       document.getElementById("conte_loading").style.display = "block";
    },
    success: function(respuesta) {
      if (respuesta == 1){
        window.location = "Q-R";
      }
    }

    });
  }
}

})()    

  }else{
    $("#arcCausaR").attr("disabled",false);
    $("#arcCausaR").parent().css('cursor', 'pointer');
    $(".comentCR").attr("disabled",false);
  }
});
/*=================================================
=            CLICK EN RE-CLASIFICACION            =
=================================================*/
$(".btnReclasificarAnalisis").click(function(){
  var idSolQR = $("#idaprobar").val();
  // var idDetalleInvesti = $("#detalle_investigacion").val();
  (async () => {
const { value: motivo } = await Swal.fire({
  type: "warning",
  title: "¿Está seguro que querer Re-Clasificar?",
  input: "textarea",
  inputPlaceholder: "Escriba el motivo",
  text: "¡Si no lo está puede cancelar la accíón!",
  showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, Cerrar!',
  inputValidator: (value) => {
    if (!value) {
      return 'Es necesario Colocar el motivo!'
    }
  }      
})

if (motivo) {
  var datos = new FormData();
    datos.append("idSolQRRevisar",idSolQR);
    datos.append("motivobloq", motivo);
    // datos.append("idDetalleInvesti", idDetalleInvesti);
    datos.append("estado_analisis", "RE-CLASIFICAR");
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      beforeSend: function(){
         document.getElementById("conte_loading").style.display = "block";
      },      
      success: function(respuesta) {
        window.location = "Q-R";
      }
    });
}

})() 

})

/*======================================================================
=            BOTON PARA REDACTAR MSJ DE REPUESTA AL CLIENTE            =
======================================================================*/
$('#SolQR tbody').on("click", "#compose", function() {
  $("#idsoliciudesEmail").val($(this).attr("idsolicitudes_qr"));
  $('.compose').slideToggle();
  $("#emailpara").tagsinput();
  var idSolQR = $(this).attr("idsolicitudes_qr");
  var datos = new FormData();
    datos.append("idmensajeEmail",idSolQR);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,   
      dataType: 'json',
      success: function(respuesta) {
        var usuariosnotif = JSON.parse(respuesta["correo_noti"]);
        for (var i = 0; i < usuariosnotif.length; i++) {
         $('#emailpara').tagsinput('add',usuariosnotif[i]); 
        }
        $(".tituloCorreo").html("Solicitud de "+respuesta["tipo_novedad"]+" "+respuesta["codigoSolicitud"]);
      }
    });

})
/*======================================================
=            CORREOS PARA NOTIFICAR CLIENTE            =
======================================================*/
$('#emailpara').on('beforeItemAdd', function(event) {
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
/*===================================================================
=            ENVIAR CORREO ELECTRONICO RESPUESTA CLIENTE            =
===================================================================*/
$("#sendRespuestaCliente").click(function(){
var emailtext = $('#emailpara').val();
var idSolQR = $("#idsoliciudesEmail").val();
  if (emailtext == ""){
    Swal.fire(
      'Información',
      'Es necesario al menos un correo electrónico.',
      'info'
    ) 
  }else{
    (async () => {

    const { value: password } = await Swal.fire({
      title: 'Contraseña de Correo Electrónico',
      input: 'password',
      inputLabel: 'Contraseña',
      inputPlaceholder: 'Ingresa tu contraseña',
      inputAttributes: {
        maxlength: 20,
        autocapitalize: 'off',
        autocorrect: 'off'
      }
    })

    if (password) {
      var emailservidor =  $("#emailpara").tagsinput('items');
      var texto  = $("#editor").html();
      var subject = $(".tituloCorreo").text();
      var datos = new FormData();
      datos.append("idRespuestaCliente",idSolQR);
      datos.append("correosNoti",JSON.stringify(emailservidor));
      datos.append("cuerpoCorreo",texto);
      datos.append("password",`${password}`);
      datos.append("subject",subject);
      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/solqr.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,   
        // dataType: 'json',
        beforeSend: function(){
           document.getElementById("conte_loading").style.display = "block";
        },        
        success: function(respuesta) {
          if (respuesta == 1) {
            window.location = "Q-R";
          }else{
            document.getElementById("conte_loading").style.display = "none";
            Swal.fire(
              'ERROR!!',
              'No se ha enviado correctamente la respuesta, por favor verifique su contraseña o puede contactarse con el administrador.',
              'error'
            )
          }
        }
      });
    }

    })()
  }

})
/*===============================================================
=            BOTON DE TABLA PARA SEGUIMIENTO CALDIAD - NEGOCIO         =
===============================================================*/
$('#SolQR tbody').on("click", ".btnSeguimientoCalidad", function() {
  $("#idsoliciudesSeguiCalidad").val($(this).attr("idsolicitudes_qr"));
})
$('#SolQR tbody').on("click", ".btnSeguimientoNegocio", function() {
  $("#idsoliciudesSeguiNegocio").val($(this).attr("idsolicitudes_qr"));
    var datos = new FormData();
    datos.append("idmensajeEmail",$(this).attr("idsolicitudes_qr"));
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,   
      dataType: 'json',
      success: function(respuesta) {
        // var contenedor = document.getElementById("ComentCalidad");
        $("#ComentCalidad").html('<div>'+
                  '<strong>Usuario: </strong> <label>'+respuesta["usuario_seguimiento_calidad"]+'</label>'+
                '</div>'+
                '<div>'+
                  '<strong>Observaciones Calidad: </strong>'+
                  '<input class="form-control" type="text" readonly name="" value="'+respuesta["usuario_seguimiento_calidad_observaciones"]+'">'+
                '</div>');
        // console.log(respuesta["usuario_seguimiento_calidad_observaciones"]);
      }
    });

})

function RegistrarSeguimiento(idsolicitud,observaciones){
  var datos = new FormData();
  datos.append("idSeguimiento",idsolicitud);
  datos.append("observaciones",observaciones);
  $.ajax({
    data: datos,
    url: rutaOculta + "ajax/solqr.ajax.php",
    type: "POST",
    contentType: false,
    processData: false,
    beforeSend: function(){
       document.getElementById("conte_loading").style.display = "block";
    },        
    success: function(respuesta) {
      if (respuesta == 1) {
        window.location = "Q-R";
      }else{
        document.getElementById("conte_loading").style.display = "none";
        Swal.fire(
          'ERROR!!',
          'No se ha enviado correctamente la respuesta, por favor verifique su contraseña o puede contactarse con el administrador.',
          'error'
        )
      }
    }
  });   

}



/*====================================================================
=            BOTON DE GUARDAR SEGUIMIENTO AREA DE CALIDAD            =
====================================================================*/
$(".SeguimientoCalidad").click(function(){
  var idSolQR = $("#idsoliciudesSeguiCalidad").val();
  var Observaciones = $("#observacionesSeguiCalidad").val();
  RegistrarSeguimiento(idSolQR,Observaciones);
})
/*========================================================
=            SEGUIMIENTO PARA GUARDAR NEGOCIO            =
========================================================*/
$(".SeguimientoNegocio").click(function(){
  var idSolQR = $("#idsoliciudesSeguiNegocio").val();
  var Observaciones = $("#observacionesSeguiNegocio").val();
  RegistrarSeguimiento(idSolQR,Observaciones);
})
/*=========================================================================
=            BOTON PARA ABRIR EL MODAL Y REGISTRAR NEGOCIACION            =
=========================================================================*/
$('#SolQR tbody').on("click", ".btnNegociacion", function() {
  $("#idsoliciudesNegociacion").val($(this).attr("idsolicitudes_qr"));  
})
/*================================================================================
=            BOTON PARA REGISTRAR LA NEGOCIACION A LA QUE HAN LLEGADO            =
================================================================================*/
$(".Registnegociacion").click(function(){
  var idSolQR = $("#idsoliciudesNegociacion").val();
  var Observaciones = $("#observacionesNegociacion").val();
  var datos = new FormData();
  datos.append("idNegociacion",idSolQR);
  datos.append("observaciones",Observaciones);
  $.ajax({
    data: datos,
    url: rutaOculta + "ajax/solqr.ajax.php",
    type: "POST",
    contentType: false,
    processData: false,
    beforeSend: function(){
       document.getElementById("conte_loading").style.display = "block";
    },        
    success: function(respuesta) {
      if (respuesta == 1) {
        window.location = "Q-R";
      }else{
        document.getElementById("conte_loading").style.display = "none";
        Swal.fire(
          'ERROR!!',
          'No se ha enviado correctamente la respuesta, por favor verifique su contraseña o puede contactarse con el administrador.',
          'error'
        )
      }
    }
  });   
})
/*==========================================================
=            BOTON DE CIERRE DE QUEJA Y RECLAMO            =
==========================================================*/
$('#SolQR tbody').on("click", ".btnCierreQR", function() {
    var idSolQR =  $(this).attr("idsolicitudes_qr");
    var datos = new FormData();
    datos.append("idmensajeEmail",$(this).attr("idsolicitudes_qr"));
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/solqr.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,   
      dataType: 'json',
      success: function(respuesta) {
        Swal.fire({
          title: 'Observaciones Reportadas',
          html: '<strong><h5>Usuario Calidad: </strong>'+respuesta["usuario_seguimiento_calidad"]+'</h5>'+
                '<h6>'+respuesta["usuario_seguimiento_calidad_observaciones"]+'</h6>'+
                '<strong><h5>Usuario Negocio: </strong>'+respuesta["usuario_seguimiento_negocio"]+'</h5>'+
                '<h6>'+respuesta["usuario_seguimiento_negocio_observaciones"]+'</h6>',          
          showDenyButton: true,
          showCancelButton: true,
          confirmButtonText: `Cerrar Solicitud`,
          denyButtonText: `Reaperturar`,
        }).then((result) => {
          if (result.isConfirmed) { // EN CASO DE CERRAR O CONCLUIR LA SOLICITUD
              var datos = new FormData();
              datos.append("idCierreSolicitud",idSolQR);
              $.ajax({
                data: datos,
                url: rutaOculta + "ajax/solqr.ajax.php",
                type: "POST",
                contentType: false,
                processData: false,
                beforeSend: function(){
                   document.getElementById("conte_loading").style.display = "block";
                },                
                success: function(respuesta) {
                  if (respuesta == 1) {
                    window.location = "Q-R";
                  }
                }
              });
          } else if (result.isDenied) { //EN CASO DE REAPERTURAR LA SOLICITUD
              var datos = new FormData();
              datos.append("idReapertura",idSolQR);
              $.ajax({
                data: datos,
                url: rutaOculta + "ajax/solqr.ajax.php",
                type: "POST",
                contentType: false,
                processData: false,
                beforeSend: function(){
                   document.getElementById("conte_loading").style.display = "block";
                },                
                success: function(respuesta) {
                  if (respuesta == 1) {
                    window.location = "Q-R";
                  }
                }
              });
          }
        })

      }
    });
})




























