/*=====================================================
=            PASAR LOS USUARIOS A LA TABLA           =
=====================================================*/
/*----------  VARIABLES GLOBALES  ----------*/
var cont=0;
var finaldataUser = [];
var datosbase = [];

$(".btnAnadir").click(function(){
	var nombre = $("#nomLink").val();
	var user = $("#userLink").val();
	var clave = $("#claveLink").val();

	if (nombre != "" && user != "" && clave != ""){
		cont = cont+1;
		var dataUser = [cont,nombre,user,clave];
		finaldataUser.push(dataUser);

		$("#datatableUserRansa").DataTable({
			data: finaldataUser,
			 destroy: true,
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

			}
		})

		if (cont>0){
			$("#nomLink").val("");
			$("#userLink").val("");
			$("#claveLink").val("");
		}

	}else{
    Swal.fire({
      title: 'Error!',
      text: 'Por favor debes llenar toda la información.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });

	}
})
/*==========================================================
=            FUNCION PARA VALIDAR SI ES UNA URL            =
==========================================================*/
function isUrl(s) {   
    var regexp = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/
    return regexp.test(s);
}


/*=======================================================================
=            GUARDAR DATOS DE LINK DE DESCARGA DE DOCUMENTOS            =
=======================================================================*/
$("#btnGuardarDoc").click(function(){
	var nompagina = $("#nompaginas").val();
	var urlpagina = $("#urlpaginas").val();
	var countuser = finaldataUser.length;
	var datousuarios = "";
	if (countuser == 0){
		Swal.fire({
    		title: 'Error!',
      		text: 'Debe Añadir al menos 1 Usuario.',
      		type: 'info',
      		confirmButtonText: 'Aceptar'
    	});
	}else{
		var datosUser = [];
		for (var i = 0; i < countuser; i++) {
			datosUser.push({"id":finaldataUser[i][0],"nombre":finaldataUser[i][1],"usuario":finaldataUser[i][2],"clave":finaldataUser[i][3]});
		}
		datousuarios = JSON.stringify(datosUser);
	}

	if (nompagina == "" || urlpagina == "" ){
		Swal.fire({
    		title: 'Error!',
      		text: 'Debe llenar todos los datos para continuar.',
      		type: 'info',
      		confirmButtonText: 'Aceptar'
    	});
	}else{
		var validurl = isUrl(urlpagina);
		if (!validurl){
			Swal.fire({
	    		title: 'Error!',
	      		text: 'La URL insertada no es válida, verifique la dirección de la página..',
	      		type: 'info',
	      		confirmButtonText: 'Aceptar'
	    	});
		}else{

			var datosLink = new FormData();

			datosLink.append("nombre", nompagina);
			datosLink.append("urlnueva", urlpagina);
			datosLink.append("usuarios", datousuarios);

	    	  $.ajax({
			      url: rutaOculta + "ajax/urlplataformas.ajax.php",
			      method: "POST",
			      data: datosLink,
			      cache: false,
			      contentType: false,
			      processData: false,
			      success: function(respuesta){
			      	if (respuesta == 1){
							Swal.fire({
								  title: "¡OK!",
								  text: "¡Se ha ingresado con Exito!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								}).then((result)=>{
									if(result.value){
										history.back();
										window.location = "linkDesc";
									}
							})			      		
			      	}
			      }

			  })
		}


	}


})

/*===================================================================
=            BTN DE INFORMACION PARA DAR CLICK AL ENLACE            =
===================================================================*/
$(".contenurl").click(function(){
	var url = $(this).attr("ruta");
	var idplataforma = $(this).attr("id");
	var ventana = window.open(url);
    var tiempo= 0;
    var interval = setInterval(function(){
         //Comprobamos que la ventana no este cerrada
         
        if(ventana.closed !== false) {
          //Si la ventana ha sido cerrada, limpiamos el contador
          window.clearInterval(interval);

          	var estadoBtn = new FormData();

			estadoBtn.append("estadobtn", idplataforma);

          $("#"+idplataforma).attr("disabled","true");

          $.ajax({
          		url: rutaOculta + "ajax/urlplataformas.ajax.php",
			    method: "POST",
			    data: estadoBtn,
			    cache: false,
			    contentType: false,
			    processData: false,
			    success: function (respuesta){

			    	//console.log(respuesta);

			    }

          })
            

        } else {
          //Mientras no se cierra la ventana sumamos los segundos
          tiempo +=1;
        }


    },1000)

})
/*==================================================================
=            FUNCION PARA VALIDAR SI UNA FECHA ES MAYOR            =
==================================================================*/
function ValidarFechaMayor(fechainicial,fechafinal){
	var inicial = fechainicial.split("/");
	var final = fechafinal.split("/");

	var dateStart = new Date(inicial[2],(inicial[1]-1),inicial[0]);
	var dateEnd = new Date(final[2],(final[1]-1),final[0]);

	if (dateStart >= dateEnd){
		return false;
	}else{
		return true;
	}
}
/*==============================================================
=            ACTUALIZACION DE BOTONES DE PLATAFORMA            =
==============================================================*/
var Internal = setInterval(function(){
$(document).ready(function(){
  $('[data-toggle="tooltip"]').tooltip();
});
	var now = new Date(Date.now());
	var formatted = now.getHours() + ":" + now.getMinutes() + ":" + now.getSeconds();
	var fecha = $('.fecha').val();
	var count = $('.fecha').length;
	var fechas = $('.fecha');
	
	var botonestado = $('.botonestado');
	var btnestado = $('.btnestado');
	
	for (var i = 0; i < count; i++) {
		var fechades = new Date(fechas[i].value);
		var fechaFinal = now.getDate()+"/"+(now.getMonth()+1)+"/"+now.getFullYear();
		var fechaInicial = fechades.getDate()+"/"+(fechades.getMonth()+1)+"/"+fechades.getFullYear();
		/*===========================================================================================================
		=            VALIDAR SI LA FECHA DE DESCARGA ANTERIOR ES MAYOR A LA ACTUAL Y VERIFICAR EL ESTADO            =
		===========================================================================================================*/
		if (ValidarFechaMayor(fechaInicial,fechaFinal) && botonestado[i].value == 1){
			$('.btnestado').removeAttr("disabled");
		/*===============================================================
		=            CAMBIAMOS EL ESTADO EN LA BASE DE DATOS            =
		===============================================================*/			
		var estadobtngral = new FormData();

		estadobtngral.append("estadobtngral", 0);


          $.ajax({
          		url: rutaOculta + "ajax/urlplataformas.ajax.php",
			    method: "POST",
			    data: estadobtngral,
			    cache: false,
			    contentType: false,
			    processData: false,
			    success: function (respuesta){

			    	//console.log(respuesta);

			    }

          })			
		}
		
	}	
		window.clearInterval(Internal);
		
},1000)
/*=======================================================
=            DATAPICKER PARA FECHA DOCUMENTO            =
=======================================================*/
$(function () {
    $('#myDatepicker2').datetimepicker({
    	format: 'dd-mm-yyyy',
		startView: 2,
		autoclose: true,
		minView: 2,
		maxView: 2,
		language: 'es'
	    // linkField: 'mesconsultServe',
	    // linkFormat: 'mm'
    });
});


/*============================================================
=            PASAR DATOS DE DOCUMENTOS A LA TABLA            =
============================================================*/
$(".btnEnviarDoc").click(function(){
	var tdocumento = $("#tdocumento").val();
	var areaselected = document.getElementById("area");
	var area = areaselected.options[areaselected.selectedIndex].text;
	var fechadoc = $("#fechadoc").val();
	var proveedor = $("#proveedor").val();
	var numdocumento = $("#numdocumento").val();
	var centroc = document.getElementById("cc");
	var centrocosto = centroc.options[areaselected.selectedIndex].text;
	var enviodoc = $("#enviodoc").tagsinput('items');
	if (tdocumento != "Seleccionar una opción" && area != "Seleccionar una opción" && fechadoc != "" && proveedor != "" && numdocumento != "" && centrocosto != "Seleccionar una opción"){
		cont = cont+1;
		var dataUser = [tdocumento,area,centrocosto,fechadoc,proveedor,numdocumento];
		finaldataUser.push(dataUser);
		/* INFORMACION QUE SERA ENVIADA PARA GUARDAR A LA BASE */
		var basedato = [tdocumento,areaselected.options[areaselected.selectedIndex].value,centroc.options[centroc.selectedIndex].value,fechadoc,proveedor,numdocumento];
		datosbase.push(basedato);

		$("#datatableUserRansa").DataTable({
			data: finaldataUser,
			 destroy: true,
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

			}
		})

		if (cont>0){
			$("#tdocumento").val("Seleccionar una opción");
			$("#area").val("Seleccionar una opción");
			$("#cc").val("Seleccionar una opción");
			$("#fechadoc").val("");
			$("#proveedor").val("");
			$("#numdocumento").val("");
			$("#enviodoc").tagsinput('refresh');
			$("#tdocumento").focus();
		}

	}else{
    Swal.fire({
      title: 'Error!',
      text: 'Por favor debes llenar toda la información.',
      type: 'info',
      confirmButtonText: 'Aceptar'
    });

	}
})

/*=================================================================================
=            PRESENTAR SUGERENCIAS EN EL PROVEEDOR AL ENVIAR DOCUMENTO            =
=================================================================================*/
var substringMatcher = function(strs) {
  return function findMatches(q, cb) {
    var matches, substringRegex;

    // an array that will be populated with substring matches
    matches = [];

    // regex used to determine if a string contains the substring `q`
    substrRegex = new RegExp(q, 'i');

    // iterate through the pool of strings and for any string that
    // contains the substring `q`, add it to the `matches` array
    $.each(strs, function(i, str) {
      if (substrRegex.test(str)) {
        matches.push(str);
      }
    });

    cb(matches);
  };
};
$.ajax({
		url: rutaOculta + "ajax/Sugerencias.json.php",
		dataType: 'json',
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function (respuesta){
			$('input[name="proveedor"]').typeahead({
			  hint: true,
			  highlight: true,
			  minLength: 1
			},
			{
			  name: 'states',
			  source: substringMatcher(respuesta)
			});			    	
	    }

})
/*============================================================
=            LIMPIAR LOS INPUT QUE CONTIENE ERROR            =
============================================================*/
/*$("input").focus(function(){
	$(".alert").remove();
})*/
/*=============================================
=            INGRESO DE AREA NUEVA            =
=============================================*/
$(".btnGArea").click(function(){
	var nombre = $("#nombreArea").val().toUpperCase();
	if (nombre == ""){
		$("#nombreArea").after('<div style="padding-top:10px;" class="contError"><div class="alert alert-danger ">'+
								'<strong>Ingrese Nombre del Área</strong>'+
								'</div></div>');
	}else{

		var areanueva = new FormData();
		areanueva.append("nuevaArea", nombre);
          $.ajax({
          		url: rutaOculta + "ajax/area.ajax.php",
			    method: "POST",
			    data: areanueva,
			    cache: false,
			    contentType: false,
			    processData: false,
			    success: function (respuesta){

			    	if (respuesta == 1){
								Swal.fire({
								  title: "¡OK!",
								  text: "¡Nueva Área Ingresada con Exito!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								}).then((result)=>{
									if(result.value){
										history.back();
										window.location = "registroDoc";
									}
									})			    		
			    	}

			    }

          })		

	}

})
/*==================================================
=            INGRESO DE PROVEEDOR NUEVO            =
==================================================*/
$(".btnGProveedor").click(function(){
	var ruc = $("#ruc").val();
	var nombre = $("#nombrepro").val().toUpperCase();
	var correo = $("#correopro").val().toLowerCase();
	if (ruc == ""){
		$("#ruc").parent().after('<div class="alert alert-danger "><strong>Ingrese el RUC</strong></div>');

	}else if (ruc.length != 13){
		$("#ruc").parent().after('<div style="padding-top:10px;" class="contError"><div class="alert alert-danger ">'+
								'<strong>El RUC debe contener 13 Digitos.</strong>'+
								'</div></div>');
	} else if (nombre == ""){
		$("#nombrepro").parent().after('<div style="padding-top:10px;" class="contError"><div class="alert alert-danger ">'+
								'<strong>Ingrese Nombre del Proveedor</strong>'+
								'</div></div>');
	}else{
		var proveedornuevo = new FormData();
		proveedornuevo.append("insertruc", ruc);
		proveedornuevo.append("nombre", nombre);
		proveedornuevo.append("correo", correo);
          $.ajax({
          		url: rutaOculta + "ajax/proveedores.ajax.php",
			    method: "POST",
			    data: proveedornuevo,
			    cache: false,
			    contentType: false,
			    processData: false,			    
			    success: function (respuesta){

			    	if (respuesta == 1){
								Swal.fire({
								  title: "¡OK!",
								  text: "¡Nuevo Proveedor Ingresado con Exito!",
								  type:"success",
								  confirmButtonText: "Cerrar",
								  closeOnConfirm: false
								}).then((result)=>{
									if(result.value){
										$("#gif").html("").hide();
										history.back();
										window.location = "registroDoc";
									}
								})			    		
			    	}
			    }
          })
	}
})
/*=========================================================
=            VALIDAR SI EL PROVEEDOR YA EXISTE            =
=========================================================*/
$("#ruc").change(function(){
	$(".alert").remove();

	var rucproveedor = $(this).val();

	var datos = new FormData();
	datos.append("validadrucproveedor", rucproveedor);

	$.ajax({
    url:"ajax/proveedores.ajax.php",
    method:"POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    dataType: "json",
    success:function(respuesta){
    	
    	// console.log("respuesta", respuesta);

    	if(respuesta){

    		$("#ruc").parent().after('<div class="alert alert-warning">Este proveedor ya existe en la base de datos</div>')
    		$("#ruc").val("");
    	}   

    }

  })

})



/*===========================================================
=            INSERTAR DESTINATARIO DEL DOCUMENTO            =
===========================================================*/
var cities = new Bloodhound({
  datumTokenizer: Bloodhound.tokenizers.obj.whitespace('nombres'),
  queryTokenizer: Bloodhound.tokenizers.whitespace,
  prefetch: rutaOculta + 'ajax/SugerenciaUsuarios.json.php'
});
cities.initialize();

var elt = $('#enviodoc');
elt.tagsinput({
	maxTags: 1,
  itemValue: 'idusuario',
  itemText: 'nombres',
  typeaheadjs: {
    name: 'cities',
    displayKey: 'nombres',
    source: cities.ttAdapter()
  }
});


/*=====================================================
=            ENVIAR DOCUMENTOS AL PERSONAL            =
=====================================================*/
$(".btnEnviarDocCorreo").click(function(){
	var userenvio = $("#enviodoc").val();
	var countuser = datosbase.length;
	if (countuser == 0 ){

    Swal.fire({
      title: 'Error!',
      text: 'Debe añadir al menos un documento para Ingresar.',
      type: 'error',
      confirmButtonText: 'Aceptar'
    });		
	}else if(userenvio == ""){
	    Swal.fire({
	      title: 'Error!',
	      text: 'Debe añadir al menos un Destinatario para los documentos.',
	      type: 'error',
	      confirmButtonText: 'Aceptar'
	    });		
	} else{
		var convertarreg = [];
		for (var i = 0; i < countuser; i++) {
			convertarreg.push({"tipo_documento":datosbase[i][0],"idarea":datosbase[i][1],"centrocosto":datosbase[i][2],"fech_documento":datosbase[i][3],"idproveedor":datosbase[i][4],"numero":datosbase[i][5]});
		}
	var datodocument = JSON.stringify(convertarreg);
		var gestdocu = new FormData();
		gestdocu.append("enviosrecep", userenvio);
		gestdocu.append("datos", datodocument);
	  $.ajax({
	  		url: rutaOculta + "ajax/gestiondocumentos.ajax.php",
		    method: "POST",
		    data: gestdocu,
		    cache: false,
		    contentType: false,
		    processData: false,
			beforeSend: function() {
		    	$('#gif').html('<div id="conte_loading" class="conte_loading">' +
		          '<div id="cont_gif" >' +
		          '<img src="' + rutaOculta + 'vistas/img/Spin-1s-200px.gif">' +
		          '</div>' +
		          '</div>').show();
		    },		    
		    success: function (respuesta){
		    	if (respuesta == 1){
							Swal.fire({
							  title: "¡OK!",
							  text: "¡Documento(s) enviado(s) con exito!",
							  type:"success",
							  confirmButtonText: "Cerrar",
							  closeOnConfirm: false
							}).then((result)=>{
								$("#gif").html("").hide();
								if(result.value){
									history.back();
									window.location = "registroDoc";
								}
							})			    		
		    	}
		    }
	  })
	}
})
/*==============================================================================================
=            CONSULTA DE PRODUCTOS QUE SE HA ENVIADO PARA QUE RECIBA SEGUN USUARIO             =
==============================================================================================*/
$(".datatableDocumentos").DataTable({

  "ajax": "ajax/TablaDocumentos.ajax.php",
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
/*===========================================================================
=            BOTON PARA CONFIRMAR LA RECEPCION DE LOS DOCUMENTOS            =
===========================================================================*/
$(".datatableDocumentos tbody").on("click",".btnConfirmDocumento",function(){

	var idDocumento = $(this).attr("iddocumento");

	var datos = new FormData();
	datos.append("idDocumento", idDocumento);

	  $.ajax({

	    url: "ajax/gestiondocumentos.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function(respuesta) {

	      if (respuesta == 1){
	      	$(this).attr("disabled","true");
			Swal.fire({
			  title: "¡OK!",
			  text: "¡Documento(s) confirmado(s) existosamente..!",
			  type:"success",
			  confirmButtonText: "Cerrar",
			  closeOnConfirm: false
			}).then((result)=>{
				if(result.value){
					history.back();
					window.location = "recepcionDoc";
				}
			})	      	

	      }else{
		    Swal.fire({
		      title: 'Error!',
		      text: 'No se ha podido confirmar la recepción. / Contactarse con el usuario Administrador.!',
		      type: 'info',
		      confirmButtonText: 'Aceptar'
		    });	      	
	      }

    	}
	})

})

