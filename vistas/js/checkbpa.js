/*=====  VARIABLES GLOBALES  ======*/
var estados = [];

/*=====================================
=            CHECK CALIDAD            =
=====================================*/
$(".checkbpa").iCheck({
	checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
})
/*============================================
=            NOVEDAD DE CHECK BPA            =
============================================*/
$(".btnovedadbpa").click(function(){
	botonNovedad($(this));

})
/*=============================================
=            FUNCION BOTON NOVEDAD            =
=============================================*/
function botonNovedad(input){
	var select = $(input).prev();
	var text = $(select).find("option:selected").text();
	if (text != "Seleccionar"){	
	(async () => {

	const { value: novedad } = await Swal.fire({
	  title: 'Registro de novedad',
	  input: 'textarea',
	  inputPlaceholder: 'Detallar la novedad presentada',
	  customClass: {
	  	input: 'uppercase',
	  }
	})
	if (novedad){
		var clase = $(input).parent().parent();
		//$(clase).addClass("list-group-item-danger");
		// $(input).remove();
		// $("body .tooltip").remove();
		//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
		var li = $("#checkListbpasmartwizard .nav-tabs li");
		var idli = "";
		var contearreglo = [];
		 for (var i = 0; i < li.length; i++) {
		 	var clas = $(li[i]).hasClass("active"); //validar si esta activo
		 	if (clas){
		 		var aid = $(li[i]).children();
		 		idli = $(aid).attr("href");
		 	}
		 }
		 var numoption = $(idli+" ul li");
		 var numitem = "";
		 for (var i = 0; i < numoption.length; i++) {
		 	var classes = $(input).hasClass("btnovedad"+i)
		 	if (classes){
		 		numitem = "btnovedad"+i;
		 	}
		 }
		/*=========================================================================
		=            VERIFICAMOS QUE LA VARIABLE ESTADOS ES UN ARREGLO            =
		=========================================================================*/
		
		if (Array.isArray(estados)){
			/* ELIMINAMOS EL ARRAY QUE TIENE EL INDICE QUE FUE INGRESADO ANTERIORMENTE */
			var mod = false;
			for (var i = 0; i < estados.length; i++) {
				var valor = numitem.slice(-2);
				 if (valor == "7" || valor == "8" || valor == "9"){
				 	if (estados[i][numitem.slice(-2)] != undefined){
				 		estados[i][numitem.slice(-2)] = novedad;
				 		mod = true;
				 	}
				 }else{
				 	if (estados[i][numitem.slice(-1)] != undefined){
				 		estados[i][numitem.slice(-1)] = novedad;
				 		mod = true;
				 	}
				 }
			}			
			
		}
		if (!mod){
			if (valor == "6" || valor == "7" || valor == "8"){
				estados.push({[numitem.slice(-2)] : novedad});	
			}else{
				estados.push({[numitem.slice(-1)] : novedad});
			}
		}
		 $(clase).attr("value","novedad");
	}
	})()
	}else{
		Swal.fire({
		type: "warning",
		title: "Primero debe seleccionar la calificación..."
		})
		return false;		
	}
}
/*==============================================
=            FUNCION BOTON REVERSAR            =
==============================================*/
function btnReversar(btn,input){
	
	var texto = $(input).find("option:selected").text();
	var clase = $(input).parent().parent();

	/* ELIMINAMOS EL EVENTO DE CLICK */
	$(btn).off('click');
	/* CAMBIAMOS TEXTO DE BOTON */

	if (texto == "CUMPLE"){

			$(btn).html("Reversar");
			$(btn).removeClass("btnovedadbpa");//removemos clase
			$(btn).addClass("reversar");//agregamos clase
			$(btn).attr("data-original-title","Reversar Selección");			

	}else{
		var colocarboton = $(input).parent();
		var clases_buton = $(input).next().attr("class");
		clases_buton = clases_buton.replace("btnovedadbpa","reversar")
		$(colocarboton).append('<button data-toggle="tooltip" title="Reversar Selección" class="'+clases_buton+'">Reversar</button>');
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip();
		});
		$(".btnovedadbpa").click(function(){
			botonNovedad($(this));
		})		
	}
	$(".reversar").click(function(){
		
		var agregar = $(this).parent();
		var dato_class =  $(agregar).children();
		var class_select = $(dato_class[0]).attr("class");
		var class_buton = $(dato_class[1]).attr("class");
		
		class_buton = class_buton.replace("reversar","btnovedadbpa");
		$(agregar).html('<select class="'+class_select+'">'+
                           '<option selected value="Seleccionar">Seleccionar</option>'+
                           '<option value="2">CUMPLE</option>'+
                           '<option value="1">CUMPLE PARCIALMENTE</option>'+
                            '<option value="0">NO CUMPLE</option>'+
                          '</select>'+
                         '<button data-toggle="tooltip" title="Registrar novedad" class="'+class_buton+'"> <span class="glyphicon glyphicon-warning-sign"></span></button>');
		$("body .tooltip").remove();//eliminamos tooltip

		 $(agregar).parent().removeClass("list-group-item-success list-group-item-info list-group-item-danger");
		 $(document).ready(function(){
		   $('[data-toggle="tooltip"]').tooltip();
		 });
		$(".btnovedadbpa").click(function(){
			botonNovedad($(this));
		})		
		/*========================================================================================
		=            APLICAMOS NUEVAMENTE LA FUNCION DE VALIDAR SELECT AL DAR REVERSA            =
		========================================================================================*/
		;
		$(".selectcheckbpa").change(function(){
			
			var value = $(this).val();
			var texto = $(this).find("option:selected").text();
			var button = $(this).next();			
			ValidarSelect(value,texto,$(this));
			var padre = $(this).parent();//obtenemos el elemento padre
			if ($('input[id="checkbpa"]').is(':checked')){
				
				var botonreversa = $(padre).find("button.reversar"); // avanzamos hasta los botones ue tienen clase reversar
				$(botonreversa).remove(); // eliminamos todos para crear uno nuevo
			}
			if (texto != "CUMPLE"){
				var padre = $(this).parent();//obtenemos el elemento padre
				var botonreversa = $(padre).find("button.reversar"); // avanzamos hasta los botones ue tienen clase reversar
				$(botonreversa).remove(); // eliminamos todos para crear uno nuevo

			}
			btnReversar(button,$(this));

		});			

		
	})
}
/*===================================================
=            FUNCION PARA VALIDAR SELECT            =
===================================================*/
function ValidarSelect(value,texto,input){
	if (texto != "") {
		var clase = $(input).parent().parent();
		if (texto == "CUMPLE"){
			$(clase).addClass("list-group-item-success");
		}else if (texto == "CUMPLE PARCIALMENTE") {
			$(clase).addClass("list-group-item-info");
		}else{
			$(clase).addClass("list-group-item-danger");
		}		

		$(input).attr("disabled","true");
		 $("body .tooltip").remove();
		//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
		var li = $("#checkListbpasmartwizard .nav-tabs li");
		var idli = "";
		var contearreglo = [];
		for (var i = 0; i < li.length; i++) {
			var clas = $(li[i]).hasClass("active"); //validar si esta activo
			if (clas){
				var aid = $(li[i]).children();
				idli = $(aid).attr("href");
			}
		}
		var numoption = $(idli+" ul li");
		var numitem = "";
		for (var i = 0; i < numoption.length; i++) {
			var classes = $(input).hasClass("btnestado"+i)
			if (classes){
				numitem = "valor"+i;
			}
		}
		/*=========================================================================
		=            VERIFICAMOS QUE LA VARIABLE ESTADOS ES UN ARREGLO            =
		=========================================================================*/
		
		if (Array.isArray(estados)){
			/* ELIMINAMOS EL ARRAY QUE TIENE EL INDICE QUE FUE INGRESADO ANTERIORMENTE */
			var mod = false;
			for (var i = 0; i < estados.length; i++) {
				if (estados[i][numitem] != undefined){
					estados[i][numitem] = value;
					mod = true;
				}
			}			
			
		}
		if (!mod){
			estados.push({[numitem] : value});	
		}
		
		$(clase).attr("value",value);
	}


}

/*=============================================
=            SELECT DE CHECK ITEMS            =
=============================================*/
$(".selectcheckbpa").change(function(){
	Selectcheck($(this));
})
/*===============================================
=            FUNCION DE SELECT CHECK            =
===============================================*/
function Selectcheck(input){
	var value = $(input).val();
	var texto = $(input).find("option:selected").text();
	var button = $(input).next();
	/*===================================================
	=            FUNCION PARA VALIDAR SELECT            =
	===================================================*/
	ValidarSelect(value,texto,$(input));
	btnReversar(button,$(input));

}

/*==================================================
=            CHECK TOTAL SI TODO CUMPLE            =
==================================================*/
$('.checkbpa').on('ifToggled', function(event){
	if ($('input[id="checkbpa"]').is(':checked')) {
		estados = [];
		//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
		var li = $("#checkListbpasmartwizard .nav-tabs li");
		var idli = "";
		for (var i = 0; i < li.length; i++) {
			var clas = $(li[i]).hasClass("active"); //validar si esta activo
			if (clas){
				var aid = $(li[i]).children();
				idli = $(aid).attr("href");
			}
		}
		var numoption = $(idli+" ul li");
		var numitem = "";
		$(numoption).removeClass("list-group-item-danger list-group-item-info");
		$(numoption).addClass("list-group-item-success");
		$(numoption).find("button.reversar").remove(); // avanzamos hasta los botones ue tienen clase reversar
		$(numoption).attr("value","listo");
		for (var i = 0; i < numoption.length; i++) {

			var obtbutton = $(numoption[i] ).children().children();
			$(obtbutton[1]).remove();
			$(obtbutton[0]).val("2");

			$(obtbutton[0]).attr("disabled",true);
			$("body .tooltip").remove();
			numitem = "valor"+i;
			estados.push({[numitem] : 2});
		}
	}else{
		var li = $("#checkListbpasmartwizard .nav-tabs li");
		var idli = "";
		for (var i = 0; i < li.length; i++) {
			var clas = $(li[i]).hasClass("active"); //validar si esta activo
			if (clas){
				var aid = $(li[i]).children();
				idli = $(aid).attr("href");
			}
		}
		var numoption = $(idli+" ul li");
		var numitem = "";
		$(numoption).removeClass("list-group-item-success");
		$(numoption).removeAttr("value","listo");
		//$('input[id="allitem"]').iCheck('uncheck');
		for (var i = 0; i < numoption.length; i++) {
			var acciones = $(numoption[i]).children();
			if ($(numoption[i]).children().hasClass("optioncheckcalidad")){
				$(acciones[1]).remove();
				$(numoption[i]).append('<div  class="btn-group pull-right optioncheckcalidad">'+
                                        '<select class="btn selectcheckbpa btnestado'+i+'">'+
                                          '<option selected value="Seleccionar">Seleccionar</option>'+
                                          '<option value="2">CUMPLE</option>'+
                                          '<option value="1">CUMPLE PARCIALMENTE</option>'+
                                          '<option value="0">NO CUMPLE</option>'+
                                        '</select>'+
                                        '<button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad'+i+'"> <span class="glyphicon glyphicon-warning-sign"></span></button>'+
                                      '</div>');
			}else if ($(numoption[i]).children().hasClass("optioncheckcalidadpeque")){
				$(acciones[1]).remove();
				$(numoption[i]).append('<div class=" btn-group pull-right optioncheckcalidadpeque">'+
                                        '<select class="btn selectcheckbpa btnestado'+i+'">'+
                                          '<option selected value="Seleccionar">Seleccionar</option>'+
                                          '<option value="2">CUMPLE</option>'+
                                          '<option value="1">CUMPLE PARCIALMENTE</option>'+
                                          '<option value="0">NO CUMPLE</option>'+
                                        '</select>'+
                                        '<button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedadbpa btnovedad'+i+'"> <span class="glyphicon glyphicon-warning-sign"></span></button>'+
                                      '</div> ');				
			}
		}
		estados = [];
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip();
		});		
		/*================================================================================================================
		=            PARA QUE LUEGO DE DAR CLICK EN DESACTIVAR SELECCION SE ACTIVE BOTON OK Y BOTON NOVEDADES            =
		================================================================================================================*/
	$(".selectcheckbpa").change(function(){
		Selectcheck($(this));
	})//funcion select opciones

	$(".btnovedadbpa").click(function(){
		botonNovedad($(this));
	})//funcion boton reporte de novedad
		
	}
});
/*===============================================================
=            BOTON DE SIGUIENTE AL REVISAR CHECK BPA            =
===============================================================*/
var directionSwart = "";
$ ("#checkListbpasmartwizard"). on ("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
	//VALIDA SI DA CLICK EN SIGUIENTE
	directionSwart = stepDirection;
	if (stepDirection == "forward"){
		//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
		var li = $("#checkListbpasmartwizard .nav-tabs li");
		var idli = "";
		var contearreglo = [];
		for (var i = 0; i < li.length; i++) {
			var clas = $(li[i]).hasClass("active"); //validar si esta activo
			if (clas){
				var aid = $(li[i]).children();
				idli = $(aid).attr("href");
			}
		}
		var numoption = $(idli+" ul li");
		for (var i = 0; i < numoption.length; i++) {
			var valuecheck = $(numoption[i]).attr("value");
			if (!valuecheck){
				Swal.fire({
				type: "warning",
				title: "Por favor complete la revisión para continuar..."
				})
				return false;
			}
		}
		 localStorage.setItem(idli,JSON.stringify(estados));
		/*=====  REINICIAMOS EL ARREGLO  ======*/
		 estados = [];
		 $('input[id="checkbpa"]').iCheck('uncheck');
	// }else{
	// 	Swal.fire({
	// 	type: "warning",
	// 	title: "No puede retroceder.."
	// 	})
	// 	return false;
	}
});

/*=====================================================
=            CARGAR IMAGENES REFERENCIALES            =
=====================================================*/
$('input[name="imgReferen[]"]').change(function(e) {
  let fileInvent = $(this);
  var fileLength = this.files.length;
  let filePath = fileInvent.val();
  var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
  if (fileLength > 16) {
    Swal.fire({
      title: 'Error!',
      text: 'Solamente se aceptan 15 Archivos de Evidencia',
      type: 'error',
      confirmButtonText: 'Aceptar'
    });
    filePath = '';
    return false;
  } else {
    //$(".ref").remove();
    $('#btnCargarEvid .form-control').text("");
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
      }
    }
    $('#btnCargarEvid .form-control').append("Ha seleccionado " + fileLength + " archivos");



  }
});
/*==========================================================
=            FUNCION PARA REGISTRO DE CHECK BPA            =
==========================================================*/
function RegistroCheckBpa(ListadoEvidencia){
	var idcliente = $(".cliente").val();
	var idauditor = $(".auditor").val();
	var nombrecliente = $(".cliente option:selected").text();
	var nombreauditor = $(".auditor option:selected").text();
	var observaciones = $(".obscheckbpa").val();
	var idlocalizacion = $(".localizacion").val();
	var fechabpa = $("#fechabpa").val();
	var registroCheck = new FormData();
    registroCheck.append("doc",localStorage.getItem("#documentos"));
    registroCheck.append("ol",localStorage.getItem("#ol"));
    registroCheck.append("aproductos",localStorage.getItem("#aproductos"));
    registroCheck.append("idcliente",idcliente);
    registroCheck.append("idauditor",idauditor);
    registroCheck.append("nombrecliente",nombrecliente);
    registroCheck.append("nombreauditor",nombreauditor);				    
    registroCheck.append("RegistBaseobservaciones",observaciones);
    registroCheck.append("idlocalizacion",idlocalizacion);
    registroCheck.append("fechabpa", fechabpa);
    registroCheck.append("listaoImgEvidencia",ListadoEvidencia);
    $.ajax({
      data: registroCheck,
      url: rutaOculta + "ajax/checkbpa.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
	  /*beforeSend: function(){
		   document.getElementById("conte_loading").style.display = "block";
	  },*/
 	  success: function(respuesta) {
 	  	if (respuesta.trim() == 1) {
	          Swal.fire({
	            type: "success",
	            title: "CheckList registrado exitosamente!!..",
	            showConfirmButton: true,
	            confirmButtonText: "Cerrar"
	            }).then(function(result){
	            if (result.value) {
	            window.location = "checkbpa";
	            }
	          })
 	  	}
      }
    });
}
/*===========================================
=            WIZARD DE CHECK BPA            =
===========================================*/
$("#checkListbpasmartwizard").smartWizard({
	theme: 'dots',
	lang: {  // Language variables
	  next: 'Siguiente',
	  previous: 'Atrás'
	},
	cycleSteps: false, // Allows to cycle the navigation of steps
	transitionEffect: 'fade', // Effect on navigation, none/slide/fade
    transitionSpeed: '400',
    toolbarSettings : { 
	    toolbarExtraButtons : [ 
$ ('<button> </button>') .text ('Finalizar')
		      .addClass('btn btn-info')
		      .on('click', function(){
		      	var botonsiguiente = $(".sw-btn-group .sw-btn-next").hasClass("disabled");
				var idcliente = $(".cliente").val();
				var idauditor = $(".auditor").val();
				var localizacion = $(".localizacion").val();
				var idlocalizacion = $(".localizacion").val();
				var fechabpa = $("#fechabpa").val();

		      	if (botonsiguiente && idcliente != "Seleccionar una opción" && idauditor != "Seleccionar una opción" && idlocalizacion != "Seleccionar una opción" && fechabpa != ""){
					//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS

					var li = $("#checkListbpasmartwizard .nav-tabs li");
					var idli = "";
					var contearreglo = [];
					for (var i = 0; i < li.length; i++) {
						var clas = $(li[i]).hasClass("active"); //validar si esta activo
						if (clas){
							var aid = $(li[i]).children();
							idli = $(aid).attr("href");
						}
					}
					var numoption = $(idli+" ul li");
					for (var i = 0; i < numoption.length; i++) {
						var valuecheck = $(numoption[i]).attr("value");
						if (!valuecheck){
							Swal.fire({
							type: "warning",
							title: "Por favor complete la revisión para continuar..."
							})
							return false;
						}	
					}
					localStorage.setItem(idli,JSON.stringify(estados));
					/*=====  REINICIAMOS EL ARREGLO  ======*/
					estados = [];
					/*=====================================================================
					=            OBTENEMOS LOS VALORES PARA ENVIAR AL SERVIDOR            =
					=====================================================================*/
					var nombrecliente = $(".cliente option:selected").text();
					var nombreauditor = $(".auditor option:selected").text();
					var observaciones = $(".obscheckbpa").val();
					var imgeviden = $('input[name="imgReferen[]"]')[0].files;
					var listaEvidencia = [];//listado de la ruta de imagenes de evidencia
					var listadoEviFisica = "";
					var finalfor = 0; 
						/*===================================================================
						=            RECORREMOS LA CANTIDAD DE ARCHIVOS CARGADOS PARA GUARDAR EN EL SERVIDOR            =
						===================================================================*/
						if (imgeviden.length > 0){
							for (var i = 0; i < imgeviden.length; i++) {
								var imgevidencia = new FormData();
						    	imgevidencia.append("registroimgevidencia",imgeviden[i]);
							    $.ajax({
							      data: imgevidencia,
							      url: rutaOculta + "ajax/checkbpa.ajax.php",
							      type: "POST",
							      contentType: false,
							      processData: false,
								  /*beforeSend: function(){
									   document.getElementById("conte_loading").style.display = "block";
								  },*/
						     	  success: function(respuesta) {
							      	listaEvidencia.push({"ImgEvidencia": respuesta.substr(3)});
							      	listadoEviFisica = JSON.stringify(listaEvidencia);
									if ((finalfor+1) >= imgeviden.length){
										RegistroCheckBpa(listadoEviFisica);
									}
									finalfor++;
							      }
							    });
							}
						}else{
							listadoEviFisica = null;
							RegistroCheckBpa(listadoEviFisica);
						}

		      	}else{
				    Swal.fire({
				      title: "Debe completar primero todos los campos para finalizar",
				      confirmButtonText: 'Aceptar'
				    });		      		


		      	}
				
		      })
			      ]   
    }
});
/*===============================================================
=            TABLA PARA EL LISTADO DE BPA REALIZADOS            =
===============================================================*/
$("#Tablacheckbpa").DataTable({
  "ajax": "ajax/TablaListCheckBpa.ajax.php",
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
/*==================================================
=            FECHA DE CHECK LIST DE BPA            =
==================================================*/
$('#fechabpa').datetimepicker({
	startView: 2,
	autoclose: true,
	// minView: 2,
	// maxView: 2,
	// format: 'yyyy-mm-dd ',
	language: 'es'

})


