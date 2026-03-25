/*============================================
=            VARIABLES DE SESSION            =
============================================*/
sessionStorage.setItem("perfiluser",$("#perfiluser").val());


/*=============================================
=            WIZAR PARA CHECK LIST            =
=============================================*/
$("#checkListsmartwizard").smartWizard({
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
		      	if (botonsiguiente){
					//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS

					var li = $("#checkListsmartwizard .nav-tabs li");
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
					var horometrocheck = $(".horocheck").val();
					var observacionescheck = $(".obsercheck").val();
					var idequipo = $("#idequipo").val();
					var idasignacion = $("#selectturn").val();
					/*================================================
					=            ENVIAR DATOS AL SERVIDOR            =
					================================================*/
				    var datos = new FormData();
				    datos.append("equipo",localStorage.getItem("#equipo"));
				    datos.append("bateria",localStorage.getItem("#bateria"));
				    datos.append("carro_bateria",localStorage.getItem("#carro_bateria"));
				    datos.append("cargador",localStorage.getItem("#cargador"));    
				    datos.append("operacional",localStorage.getItem("#operacional"));
				    datos.append("horocheck",horometrocheck);
				    datos.append("observacheck",observacionescheck);
				    if (confiratrasocheck) {
				    	datos.append("motivoatraso",motivoatrasacheck);
				    }else{
				    	datos.append("motivoatraso","");
				    }
				    datos.append("idequipocheck",idequipo);
				    datos.append("idasignacioncheck",idasignacion);
				    datos.append("forma","checklist");
				    $.ajax({
				      data: datos,
				      url: rutaOculta + "ajax/equipos.ajax.php",
				      type: "POST",
				      contentType: false,
				      processData: false,
					  //beforeSend: function(){
						//   document.getElementById("conte_loading").style.display = "block";
					  //},				      
				      //dataType: "json",
				      success: function(respuesta) {
				      	var arrayrespuesta = respuesta.split(";");
				      	if (arrayrespuesta[0].trim() == "ok"){
				          Swal.fire({
				            type: "success",
				            title: "CheckList registrado exitosamente con "+arrayrespuesta[1]+" novedades",
				            showConfirmButton: true,
				            confirmButtonText: "Cerrar"
				            }).then(function(result){
				            if (result.value) {
				            window.location = "checklist";
				            }
				          })	      		
				      	}

				      }

				    });	
					
						      		
		      		
		      	}else{
				    Swal.fire({
				      title: "Debe completar primero todos los Item's para finalizar",
				      confirmButtonText: 'Aceptar'
				    });		      		


		      	}
				
		      })
			      ]   
    }


});
/*==================================================
=            DAR ESTILO AL RADIO INPUT             =
==================================================*/
$(".localizacion, .localizacionE, .paralizacion, .allitem, .allitemuso").iCheck({
	checkboxClass: 'icheckbox_flat-green',
    radioClass: 'iradio_flat-green'
})

/*======================================================
=            DAR ESTILO A SELECT CON CHOSEN            =
======================================================*/
 $(".chosen-select").chosen({width: "100%"});

/*============================================================================
=            CHECK QUE SE ACTIVARÁ AL MOMENTO QUE DAMOS LOCALIDAD            =
============================================================================*/
$('.localizacion').on('ifChecked', function(event){
  if ($(this).val() == "local"){
  	$(".msj_localizacion1").hide();
  	$("#localnormal").val("Seleccionar una opción");
  	$(".msj_localizacion").show();

  }else{
  	$(".msj_localizacion").hide();
  	$("#localEq-padre").val("Seleccionar una opción");
    		/* ACTUALIZA EL PLUGIN DE SELECT */
	$('.chosen-select').trigger('chosen:updated');
	$("#text_ubicacion").text("");
  	$(".msj_localizacion1").show();
  }
});
/*============================================================
=            SE ACTIVA EN EL FORMULARIO DE EDITAR            =
============================================================*/
$('.localizacionE').on('ifChecked', function(event){
  if ($(this).val() == "localE"){
  	$(".msj_localizacion1E").hide();
  	//$("#localnormalE").val("Seleccionar una opción");
  	$(".msj_localizacionE").show();

  }else{
  	$(".msj_localizacionE").hide();
  	//$("#localEq-padreE").val("Seleccionar una opción");
    		/* ACTUALIZA EL PLUGIN DE SELECT */
	//$('.chosen-select').trigger('chosen:updated');
	//$("#text_ubicacionE").text("");  	
  	$(".msj_localizacion1E").show();
  }
});

/*======================================
=            GUARDAR EQUIPO            =
======================================*/
$(".guardarEquipoNuevo").click(function(){
	var localizacion = "";
	var epadre = "";
	var idUser = $(".idUser").val(); // id del usuario que hace el ingreso del equipo
	var Equipo = $(".EquipooAcivo").val().toUpperCase(); //nombre del equipo
	var modelo = $(".modeloE").val().toUpperCase();//modelo del equipo
	var ciudad = $("#ciudad").val(); //ciudad de la ubicacion del equipo
	var tipoEquipo = $("#t_equipo").val(); // tipo de equipo
	var serie = $(".serieE").val().toUpperCase(); //serie del equipo
	var baterias = $(".baterias").val().toUpperCase(); //Bateria del equipo
	var codigo = $(".codigoE").val().toUpperCase(); // codigo del Equipo
	var centrocosto = $("#c_costo").val(); //centro de costo
	
	var horometroInit = $(".horoinit").val();//valor del horometro del equipo inicial	
	/*=====================================================================
	=            COMPROBAMOS QUE TODOS LOS CAMPOS ESTEN LLENOS            =
	=====================================================================*/	
	if (Equipo != "" && modelo != "" && ciudad != "Seleccionar una opción" && tipoEquipo != "Seleccionar una opción" && serie != "" && baterias != "" && codigo != "" && centrocosto != "Seleccionar una opción"){
	    if ($('input[id="local"]').is(':checked')) {
			localizacion = $("#localnormal").val();
	    	if (localizacion == "Seleccionar una opción"){
			    Swal.fire({
			      title: 'Seleccione localización del equipo',
			      type: 'info',
			      confirmButtonText: 'Aceptar'
			    });
			    return;
	    	}
	    }else if ($('input[id="Epadre"]').is(':checked')){
	    	epadre = $("#localEq-padre").val();
	    	if (epadre != "Seleccionar una opción"){
		  		localizacion = $("#text_ubicacion").attr("idlocalizacion");
	    	}else{
			    Swal.fire({
			      title: 'Seleccione el equipo padre',
			      type: 'info',
			      confirmButtonText: 'Aceptar'
			    });
			    return;
	    	}
	    }
		var datos1 = new FormData();
	    datos1.append("codigomcseleccion", codigo);
	    $.ajax({
	      data: datos1,
	      url: rutaOculta + "ajax/equipos.ajax.php",
	      type: "POST",
	      contentType: false,
	      processData: false,
	      dataType: "json",
	      success: function(respuesta) {
	      	if (respuesta["codigo"] == codigo || respuesta == 2){
				    Swal.fire({
				      title: 'Equipo ya registrado, intente otro codigo!!',
				      type: 'info',
				      confirmButtonText: 'Aceptar'
				    });
				    return;
	      	}else{
			    var datos = new FormData();
				    datos.append("idUse",idUser);
				    datos.append("equipo",Equipo);
				    datos.append("model",modelo);
				    datos.append("ciudad",ciudad);	    
				    datos.append("t_equipo",tipoEquipo);
				    datos.append("seri",serie);
					datos.append("bateriax",baterias);
				    datos.append("codig",codigo);
				    datos.append("localizacion",localizacion);
				    datos.append("epadre",epadre);
				    datos.append("horometro",horometroInit);
				    datos.append("centrocosto",centrocosto);
				    $.ajax({
				      data: datos,
				      url: rutaOculta + "ajax/equipos.ajax.php",
				      type: "POST",
				      contentType: false,
				      processData: false,
				      success: function(respuesta) {
				      	if (respuesta.trim() == "ok"){
				          Swal.fire({
				            type: "success",
				            title: "Equipo registrado correctamente!!",
				            showConfirmButton: true,
				            confirmButtonText: "Cerrar"
				            }).then(function(result){
				            if (result.value) {
				            window.location = "equipo";
				            }
				          })	      		
				      	}

				      }

				    });			      		

	      	}

	      }

	    });	




	

	}else{
	    Swal.fire({
	      title: 'LLene todos los campos para continuar el registro!!',
	      type: 'info',
	      confirmButtonText: 'Aceptar'
	    });
	}

})

/*====================================================
=            DATOS DE LA TABLA DE EQUIPOS            =
====================================================*/
$("#dataEquipos").DataTable({
  "ajax": "ajax/TablaEquipos.ajax.php",
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
/*=======================================================================================
=            DAR VALOR A LA UBICACION EN CASO DE SELECCIONAR EL EQUIPO PADRE            =
=======================================================================================*/
$("#localEq-padre").change(function(){
	var idlocalizacion = $("#localEq-padre option:selected").attr("idlocalizacion");
	var datos = new FormData();
	datos.append("idlocalizacionEp", idlocalizacion);
	$.ajax({
	    url: "ajax/equipos.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success: function(respuesta) {
	    	if (respuesta != ""){
	    		$("#text_ubicacion").text(respuesta["nom_localizacion"]);
	    		$("#text_ubicacion").attr("idlocalizacion",idlocalizacion);
	    	}else{
	    		$("#text_ubicacion").text("");
	    	}
	    	

	    }
	})	

	
})
/*============================================================
=            SE ACTIVA EN EL FORMULARIO DE EDITAR            =
============================================================*/
$("#localEq-padreE").change(function(){
	var idlocalizacion = $("#localEq-padreE option:selected").attr("idlocalizacion");
	var datos = new FormData();
	datos.append("idlocalizacionEp", idlocalizacion);
	$.ajax({
	    url: "ajax/equipos.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success: function(respuesta) {
	    	if (respuesta != ""){
	    		$("#text_ubicacionE").text(respuesta["nom_localizacion"]);
	    		$("#text_ubicacionE").attr("idlocalizacion",idlocalizacion);
	    	}else{
	    		$("#text_ubicacionE").text("");	
	    	}
	    	

	    }
	})	

	
})




/*================================================
=            BOTON PARA ABRIR LA VENTANA DE EDITAR EQUPOS            =
================================================*/
$('.table_Equipos tbody').on("click", ".btnEditarEquipo", function() {
	var idEquipo = $(this).attr("idequipo");

  if (window.matchMedia("(max-width:767px)").matches){
    //$(".dz-message").html("Haz click para Seleccionar la Imagen");
    //var num = $("#inputEditar .input-lg").length;
    //for (var i = 0; i < num; i++) {
      $("#inputEditarEquipo .input-lg").addClass ("input-sm");
      $("#inputEditarEquipo .input-lg").removeClass("input-lg");
      
      
    //}
  }

 
    //    $("#validar_bateria").change(function(){
    //  	var rohit = $('#validar_bateria').val();
    //  	alert("hola mundo" + rohit);
    //  });

	//     validar_bateria.oninput = function() {
	// 	alert('hola mundo');
	//   };

  	/*====================================================================================
  	= CONSULTA EL ID DEL EQUIPO PARA OBTENER LOS DATOS Y EDITARLOS            =
    ====================================================================================*/
	var datos = new FormData();
	datos.append("idequipo", idEquipo);
	$.ajax({
	    url: "ajax/equipos.ajax.php",
	    method: "POST",
	    data: datos,
	    cache: false,
	    contentType: false,
	    processData: false,
	    dataType: "json",
	    success: function(respuesta) {
	    	$(".EquipooAcivoE").val(respuesta[0]["nom_equipo"]);
	    	$("#ciudadE").val(respuesta[0]["idciudad"]);
	    	$(".modeloEE").val(respuesta[0]["modelo"]);
	    	$("#t_equipoE").val(respuesta[0]["idtipo_equipo"]);
	    	$(".codigoEE").val(respuesta[0]["codigo"]);
	    	$(".horoinitE").val(respuesta[0]["horo_inicial"]);
	    	$(".serieEE").val(respuesta[0]["serie"]);
			$(".bateriaa").val(respuesta[0]["codigo_bateria"]);
	    	$(".EidequipoE").val(idEquipo);
	    	$("#c_costoE").val(respuesta[0]["idcentro_costo"]);
	    	//$("#localEq-padreE").val("Seleccionar una opción");
	    	$('.chosen-select').trigger('chosen:updated');
	    	$("#text_ubicacionE").text("");
	    	$("#localnormalE").val("Seleccionar una opción");
	    	var option ='';
	    		    		//llenar el select pero no se encuentre el que se esta editando

			var datos1 = new FormData();
			datos1.append("llenar_selectE", idEquipo);
			$.ajax({
			    url: "ajax/equipos.ajax.php",
			    method: "POST",
			    data: datos1,
			    cache: false,
			    contentType: false,
			    processData: false,
			    dataType: "json",
			    success: function(respuesta1) {
			    	$("#localEq-padreE option").remove();
			    	option ='<option value="Seleccionar una opción">Seleccionar una opción</option>';
			    	$('.chosen-select').trigger('chosen:updated');
			    	for (var i = 0; i < respuesta1.length; i++) {
			    		if (respuesta1[i]["idequipomc"] != idEquipo){
			    			option += '<option idlocalizacion= "'+respuesta1[i]["idlocalizacion"]+'"  value="'+respuesta1[i]["idequipomc"]+'">'+respuesta1[i]["valor_concatenado"]+'</option>';	
			    		}
			    	}
			    	$("#localEq-padreE").append(option);

			    	if (respuesta[0]["idequi_padre"] != null){
			    		$("#localEq-padreE").val(respuesta[0]["idequi_padre"]);
			    		/* ACTUALIZA EL PLUGIN DE SELECT */
			    		$('.chosen-select').trigger('chosen:updated');   		

			    		//ajax para conocer el nombre de la ubicacion a traves del ID
						var datos2 = new FormData();
						datos2.append("idlocalizacionEp", respuesta[0]["idlocalizacion"]);
						$.ajax({
						    url: "ajax/equipos.ajax.php",
						    method: "POST",
						    data: datos2,
						    cache: false,
						    contentType: false,
						    processData: false,
						    dataType: "json",
						    success: function(respuesta2) {
						    	$("#text_ubicacionE").text(respuesta2["nom_localizacion"]);			    	
						    }
						})
			    		
			    	}else{
			    		$("#localnormalE").val(respuesta[0]["idlocalizacion"]);
			    		$("#localEq-padreE").val("Seleccionar una opción");
			    		$('.chosen-select').trigger('chosen:updated');

			    	}
			    }
			})	 

	    }
	})
})
/*============================================================
=            BOTON PARA GUARDAR EL EQUIPO EDITADO            =
============================================================*/
$(".editarEquipo").click(function(){
	var equipo = $(".EquipooAcivoE").val().toUpperCase();
	var ciudad = $("#ciudadE").val();
	var modelo = $(".modeloEE").val().toUpperCase();
	var tipo_equipo = $("#t_equipoE").val();
	var codigo = $(".codigoEE").val().toUpperCase();
	var horometro_inicial = $(".horoinitE").val();
	var serie = $(".serieEE").val().toUpperCase();
	var baterias = $(".bateriaa").val().toUpperCase();
	var idequipomc = $(".EidequipoE").val();
	var ideditador = $(".idUserE").val();
	var idcentroc = $("#c_costoE").val();
	var localizacion = "";
	var equipopadre = "";

	if (equipo != "" && modelo != "" && ciudad != "Seleccionar una opción" && tipo_equipo != "Seleccionar una opción" && codigo != "" && serie != "" && idcentroc != "Seleccionar una opción" ){
	    if ($('input[id="localE"]').is(':checked')) {
	        localizacion = $("#localnormalE").val();
	    	if (localizacion == "Seleccionar una opción"){
			    Swal.fire({
			      title: 'Seleccione localización del equipo',
			      type: 'info',
			      confirmButtonText: 'Aceptar'
			    });
			    return;
	    	}
	    }else if ($('input[id="EpadreE"]').is(':checked')){
	    	equipopadre = $("#localEq-padreE").val();
	    	if (equipopadre != "Seleccionar una opción"){
		  		localizacion = $("#text_ubicacionE").attr("idlocalizacion");
	    	}else{
			    Swal.fire({
			      title: 'Seleccione el equipo padre',
			      type: 'info',
			      confirmButtonText: 'Aceptar'
			    });
			    return;
	    	}
	    }

	    var datos = new FormData();
	    datos.append("equipo",equipo);
	    datos.append("ciudad",ciudad);
	    datos.append("modelo",modelo);
	    datos.append("tipo_equipo",tipo_equipo);
	    datos.append("codigo",codigo);
	    datos.append("horometro_inicial",horometro_inicial);
	    datos.append("serie",serie);
		datos.append("baterias",baterias);
	    datos.append("idequipomc",idequipomc);
	    datos.append("localizacion",localizacion);
	    datos.append("equipopadre",equipopadre);
	    datos.append("ideditador",ideditador);
	    datos.append("idcentro_costo",idcentroc);
	    $.ajax({
	      data: datos,
	      url: rutaOculta + "ajax/equipos.ajax.php",
	      type: "POST",
	      contentType: false,
	      processData: false,
	      success: function(respuesta) {
	      	if (respuesta.trim() == "ok"){
	          Swal.fire({
	            type: "success",
	            title: "Equipo modificado correctamente!!",
	            showConfirmButton: true,
	            confirmButtonText: "Cerrar"
	            }).then(function(result){
	            if (result.value) {
	            window.location = "equipo";
	            }
	          })	      		
	      	}

	      }

	    });			
	}else{
	    Swal.fire({
	      title: 'Debe completar toda la información!!',
	      type: 'info',
	      confirmButtonText: 'Aceptar'
	    });		
	}
})
/*================================================
=            BOTON PARA ABRIR LA VENTANA DE ASIGNAR EQUPOS            =
================================================*/
$('.table_Equipos tbody').on("click", ".btnAsignarEquipo", function() {
	/* PARA QUE LOS DATOS DEL PRIMER TURNO SEAN VISIBLES*/
	var idEquipo = $(this).attr("idequipo");
	$(".AidequipoE").val(idEquipo);
  if (window.matchMedia("(max-width:767px)").matches){
    //$(".dz-message").html("Haz click para Seleccionar la Imagen");
    //var num = $("#inputEditar .input-lg").length;
    //for (var i = 0; i < num; i++) {
      $("#inputEditarEquipo .input-lg").addClass ("input-sm");
      $("#inputEditarEquipo .input-lg").removeClass("input-lg");

  }
  	var datos = new FormData();
  	datos.append("bloqAsigRegi",idEquipo);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta) {

	var turnos = $("#wizardTurnos ul a");
	var valorturno = "";
	/*=====================================================================================
	=            VALIDAR PARA CONOCER CUAL ES EL TURNO QUE VA HACER EL INGRESO            =
	=====================================================================================*/
	for (var i = 0; i <= turnos.length; i++) {
		$(".conteregistro"+i).show();
		$(".msjasignado").hide();
	}
	$(".msjasig").remove();
      	for (var i = 0; i < respuesta.length; i++) {

      		if (respuesta[i]["estado"] == 1 ){
      			$(".conteregistro"+respuesta[i]["turno"]).hide();
      			$(".conteregistro"+respuesta[i]["turno"]).after('<div class=" msjasig col-xs-12">'+
                  '<div class="container">'+
                    '<div class="jumbotron">'+
                      '<h1>Personal Asignado</h1>'+
                      '<p>Ya se encuentra asignado responsable de este Turno</p>'+
                      '<h4><strong>Responsable: </strong>'+respuesta[i]["responsable"]+'</h4>'+
                      '<h5> <strong>Nota:</strong> Si desea cambiar el responsable, debe ingresar en la tabla y eliminar la asignación.</h5>'+
                    '</div>'+
                  '</div>'+ 
                '</div>');
      		}
      	}
      }
  	})
	
	$("#wizardTurnos .stepContainer").css("height", "312px");
	$("#wizardTurnos .actionBar").css("display", "none");
	
})
/*==================================================================================
=            APLICAR WIZARD AL INGRESAR ASIGNACIÓN POR TURNO DE EQUIPOS            =
==================================================================================*/
function init_SmartWizard() {
	
	if( typeof ($.fn.smartWizard) === 'undefined'){ return; }
	console.log('init_SmartWizard');
	$('#wizardTurnos').smartWizard({
		theme: 'circles',
		lang: {  // Language variables
		  next: 'Siguiente',
		  previous: 'Atrás'
		},
		transitionEffect: 'fade', // Effect on navigation, none/slide/fade
	    transitionSpeed: '400',
	    toolbarSettings: {
            showNextButton: false, // show/hide a Next button
            showPreviousButton: false// show/hide a Previous button
        },
		anchorSettings : { 
		  enableAllAnchors : true // Activa todos los anclajes en los que se puede hacer clic en todo momento  
		},        
		/*keyNavigation:true,
		transitionEffect: 'slide',
        toolbarSettings: {
            showNextButton: false, // show/hide a Next button
            showPreviousButton: false// show/hide a Previous button
        }*/

	});
	$('.buttonNext').addClass('btn btn-success');
	$('.buttonPrevious').addClass('btn btn-primary');
	$('.buttonFinish').addClass('btn btn-default');
	
};
init_SmartWizard();

/*========================================================================================
=            GUARDAR LA ASIGNACIÓN DE LOS EQUIPOS SEGUN EL TURNO SELECCIONADO            =
========================================================================================*/
$(".AAsignarEquipo").click(function(){
	var turnos = $("#wizardTurnos ul li");
	var valorturno = "";
	/*=====================================================================================
	=            VALIDAR PARA CONOCER CUAL ES EL TURNO QUE VA HACER EL INGRESO            =
	=====================================================================================*/
	for (var i = 0; i < turnos.length; i++) {
		if ($(turnos[i]).hasClass("active")){
			/*=================================================================
			=            INGRESAR ASIGNACION AL TURNO SELECCIONADO            =
			=================================================================*/
			if ($(turnos[i]).children().attr("href") == "#turno-1"){
				valorturno = "1";
			}else if ($(turnos[i]).children().attr("href") == "#turno-2"){
				valorturno = "2";
			}else{
				valorturno = "3";
			}	
		}
	}
	var idequipo = $(".AidequipoE").val();
	var iduser = $(".EidUser"+valorturno).val();
	var supervisor = $("#Asupervisor"+valorturno).val();
	var responsable = $(".Aresponsable"+valorturno).val();
	var llave = $(".Allave"+valorturno).val();
	var oculto = $(".conteregistro"+valorturno).attr("style");
	if (oculto == "display: none;"){
	    Swal.fire({
	      title: 'El siguiente Turno ya tiene Responsable Asignado!!',
	      type: 'info',
	      confirmButtonText: 'Aceptar'
	    });		

	}else if (responsable == "" && supervisor == "Seleccionar una opción" && llave == ""){
		Swal.fire({
	      title: 'Complete la información!!',
	      text: 'Debe llenar obligatoriamente toda la información para continuar.. ',
	      type: 'info',
	      confirmButtonText: 'Aceptar'
	    });		
	}else{
		var datos = new FormData();

		datos.append("idequipomc",idequipo);
		datos.append("idusuarioransa",supervisor);
		datos.append("llave",llave);
		datos.append("responsable",responsable);
		datos.append("turno",valorturno);
		datos.append("asignador",iduser);

	    $.ajax({
	      data: datos,
	      url: rutaOculta + "ajax/equipos.ajax.php",
	      type: "POST",
	      contentType: false,
	      processData: false,
	      success: function(respuesta) {
	      	if (respuesta.trim() == "ok") {
				Swal.fire({
		            type: "success",
		            title: "Equipo Asignado correctamente!!",
		            showConfirmButton: true,
		            confirmButtonText: "Cerrar"
		            }).then(function(result){
		            if (result.value) {
		            	
		            	window.location = "equipo";
		            }
		        })	      		
	      	}

	      }
	    });		








	}
})
/*========================================================
=            MOSTRAR LA ASIGNACION DE EQUIPOS QUE SE HA DADO (HISTORIAL)          =
========================================================*/
$(".btn_tablaAsignacion").click(function(){
	var idequipo = $(".AidequipoE").val();	
	var datos = new FormData();
	datos.append("idConsultAsignacion",idequipo);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
	      Swal.fire({
	        title: 'Visualizar Asignación',
	        width: 800,
	        padding: '3em',
	        html: respuesta,
	        showCloseButton: true
	      });
	      /*========================================================
			=            ELIMINAR EL RESPONSABLE ASIGNADO            =
			========================================================*/
			$('.TablaAsignacion tbody').on("click", ".btnEliminarAsignacion", function() {
				var idasignacion = $(this).attr("idasignacion");
				var turno = $(this).attr("turno");



				  Swal.fire({
				  type: "warning",
				  title: "¿Está seguro de borrar la Asignación?",
				  text: "¡Si no lo está puede cancelar la accíón!",
				  showCancelButton: true,
				    confirmButtonColor: '#3085d6',
				      cancelButtonColor: '#d33',
				      cancelButtonText: 'Cancelar',
				      confirmButtonText: 'Si, borrar Asignación!'
				  }).then(function(result){
				  if (result.value) {
				  	var datosEliminar = new FormData();
					datosEliminar.append("idAsigEliminar",idasignacion);
				    $.ajax({
				      data: datosEliminar,
				      url: rutaOculta + "ajax/equipos.ajax.php",
				      type: "POST",
				      contentType: false,
				      processData: false,
				      success: function(respuesta) {
				      	if (respuesta.trim() == "ok"){

				        Swal.fire({
				            type: "success",
				            title: "Responsable del Turno "+turno+" ha sido borrado correctamente",
				            showConfirmButton: true,
				            confirmButtonText: "Cerrar"
				            }).then(function(result){
				                if (result.value) {

				                window.location = "equipo";

				                }
				              })     		
				      	}
				      }
				    });	
				  }
				})					
			})     	

      }
  })

})
/*==============================================
=            BTN ELIMINAR EL EQUIPO            =
==============================================*/
$('.table_Equipos tbody').on("click", ".btnEliminarEquipo", function() {
	var idequipo = $(this).attr("idequipoE");
	var datos = new FormData();
	datos.append("idequipoE",idequipo);


	Swal.fire({
	  type: "warning",
	  title: "¿Está seguro de eliminar el Equipo?",
	  text: "¡Si no lo está puede cancelar la accíón!",
	  showCancelButton: true,
	    confirmButtonColor: '#3085d6',
	      cancelButtonColor: '#d33',
	      cancelButtonText: 'Cancelar',
	      confirmButtonText: 'Si, borrar Equipo!'
	}).then(function(result){
		if (result.value) {
		    $.ajax({
		      data: datos,
		      url: rutaOculta + "ajax/equipos.ajax.php",
		      type: "POST",
		      contentType: false,
		      processData: false,
		      success: function(respuesta) {
		      	if (respuesta.trim() == "ok") {

		      		window.location = "equipo";
		      	}

		      }
		    });
		}

	})
})
/*==========================================
=            REGISTRO DE CIUDAD            =
==========================================*/
$(".btnGCiudad").click(function(){
	var nciduad = $("#nciudad").val().toUpperCase();
	var datos = new FormData();
	datos.append("nciudad",nciduad);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
      	if (respuesta.trim() == "ok"){
        Swal.fire({
            type: "success",
            title: "Ciudad registrada con exito.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {

                window.location = "equipo";

                }
              })     		
      	}
      }
    });
})
/*==================================================
=            REGISTRO DE TIPO DE EQUIPO            =
==================================================*/
$(".btnGTEquipo").click(function(){
	var tequipo = $("#tequipon").val().toUpperCase();
	var desc_equipo = $(".descrip_equipo").val().toUpperCase();
	var datos = new FormData();
	datos.append("tequipon",tequipo);
	datos.append("descrip_equipo",desc_equipo);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
      	if (respuesta.trim() == "ok"){
        Swal.fire({
            type: "success",
            title: "Tipo de equipo registrada con exito.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {

                window.location = "equipo";

                }
              })     		
      	}
      }
    });
})
/*======================================================
=            REGISTRO DE NUEVA LOCALIZACION            =
======================================================*/
$(".btnGLocalizacion").click(function(){
	var nlocalizacion = $(".nlocalizacion").val().toUpperCase();
	var datos = new FormData();
	datos.append("NLocalizacion",nlocalizacion);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
      	if (respuesta.trim() == "ok"){
        Swal.fire({
            type: "success",
            title: "Localización registrada con exito.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {

                window.location = "equipo";

                }
              })     		
      	}
      }
    });	
})
/*=========================================================
=            REGISTRO DE NUEVO CENTRO DE COSTO            =
=========================================================*/
$(".btnGCCosto").click(function(){
	var nombre = $("#nombrecc").val().toUpperCase();
	var descripcion = $(".descripcion_cc").val().toUpperCase();
	var datos = new FormData();
	datos.append("nom_cc",nombre);
	datos.append("descripcion",descripcion);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
      	if (respuesta.trim() == "ok"){
        Swal.fire({
            type: "success",
            title: "Centro de costo registrado con exito.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
                if (result.value) {
                window.location = "equipo";
                }
              })     		
      	}
      }
    });	

})
var notfiNoEntrega = false;
/*VARIABLES PARA VER SI ES UNA NOTIFICACION*/
var equipouso = false;
var idmanejoeq = "";
var personalnoent = "";
var horoequipoanterior= "";
var colummcpersonal = "";
var codigobatia = "";
/*===========================================
=            SELECCION DE EQUIPO            =
===========================================*/
$("#selecEquipo").click(function(){
  (async () => {
    const {
      value: cod
    } = await Swal.fire({
      title: 'Ingresar el código del equipo',
      input: 'text',
      inputPlaceholder: 'Ingresa Código',
      customClass: {
      	input: 'uppercase',
      }
    })
    if (cod) {

    	var datos = {
	      'codigomcseleccion': cod.toUpperCase()
	    }  
		// alert('hola perfil');
      $.ajax({
        data: datos,
        url: rutaOculta + "ajax/equipos.ajax.php",
        type: "POST",
        dataType: "json",
        success: function(response) {
        	// debugger;
			$("#vista_bateria").val(response[0]["codigo_bateria"]);
        	if (response == 1 ){
        		Swal.fire('El código ' + cod.toUpperCase() + ' no se encuentra Registrado o es Incorrecto');
        	}else if (response == 2) {
        		Swal.fire({
				  icon: 'error',
				  title: cod.toUpperCase()+' INOPERATIVO',
				  html: '<b>NOTA:<b> No es necesario hacer check list ni reportar novedades una vez que el equipo se encuentre Inoperativo',
				})
        		//Swal.fire('El Equipo ' + cod.toUpperCase() + ' se encuentra <b>INOPERATIVO<b>');
        	}else if (response == 0) {
        		Swal.fire('El código ' + cod.toUpperCase() + ' ha sido deshabilitado');
        	}else{
        		//console.log(response);
        		var sessionciudad = $("#sessionciudad").val();
        		if (sessionciudad == response[0]["idciudad"]){
			        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
			        fecha_actual = new Date(Date.now());
                
			        var fecha = fecha_actual.getDate()+"/"+(fecha_actual.getMonth()+1)+"/"+fecha_actual.getFullYear();
			        /*=============================================
			        =            OBTENER LA URL ACTUAL            =
			        =============================================*/
			        var form = window.location.pathname;
			        var url = form.split("/");
			        var final = url[url.length-1];
			        if (final == "usomc"){
			        	/*==========================================================================
			        	=            EN CASO DE QUE LA URL PERTENECE A MANEJO DE EQUIPO            =
			        	==========================================================================*/
			        	var perfil = $("#perfiluser").val();
			        	if (perfil == "OPERATIVO"){
				        	var colummc = TablaManejoEquipo.column(1).data().toArray();
				        	var colummcidmanejo = TablaManejoEquipo.column(0).data().toArray();
				        	colummcpersonal = TablaManejoEquipo.column(2).data().toArray();
				        	var horoequipo = TablaManejoEquipo.column(6).data().toArray();
			        	}else{
				        	var colummc = TablaManejoEquipo.column(1).data().toArray();
				        	var colummcidmanejo = TablaManejoEquipo.column(0).data().toArray();
				        	colummcpersonal = TablaManejoEquipo.column(2).data().toArray();
				        	var horoequipo = TablaManejoEquipo.column(7).data().toArray();			        		
			        	}
			        	
			        	equipouso = false;
			        	for (var i = colummc.length - 1; i >= 0; i--) {
			        		if (colummc[i] == response[0]["codigo"]){
			        			equipouso = true;
			        			idmanejoeq = colummcidmanejo[i];
			        			personalnoent = colummcpersonal[i];
			        			horoequipoanterior = horoequipo[i];
			        			break;
			        		}
			        	}
						
			        	if (!equipouso){
							// console.log('hola mundo2');
							//      alert('hola mundo2');
			        		$(".fecha").remove();
			        		//$("#descripEquiSeleccionado").html(response["valor_concatenado"]);
			    			if (window.matchMedia("(max-width:767px)").matches){
							    //$("#descripEquiSeleccionado").addClass("fecha");
							    $("#descripEquiSeleccionado").html('<span>'+fecha_actual.toLocaleDateString("es-ES", options)+'</span>');
							   	$("#descripEquiSeleccionado").after('<h2 class = "fecha">'+response[0]["valor_concatenado"]+'</h2>');
							}else{
							  	$("#descripEquiSeleccionado").html(response[0]["valor_concatenado"]);
								$("#descripEquiSeleccionado").after('<h2 class= "fecha"><spa class="" style="position:absolute; right:30px;">'+fecha_actual.toLocaleDateString("es-ES", options)+'</span></h2>');  	
							}

							$("#idequipo").val(response[0]["idequipomc"]);
		                	$("#codigoEquipo").val(response[0]["codigo"]);
		                	notfiNoEntrega = false;
			        	}else{
							Swal.fire({
							  title: "El Equipo "+response[0]["codigo"]+" se encuentra en uso",
							  html: "Primero Termine el uso del Equipo para empezar uno nuevo<br> Para reportar la no entrega del Equipo haga click en Notificar",
							  icon: 'warning',
							  showCancelButton: true,
							  confirmButtonColor: '#3085d6',
							  cancelButtonColor: '#d33',
							  confirmButtonText: 'Si, Notificar!'
							}).then((result) => {
							  if (result.value) {
								
				        		$(".fecha").remove();
				        		//$("#descripEquiSeleccionado").html(response["valor_concatenado"]);
				    			if (window.matchMedia("(max-width:767px)").matches){
								    //$("#descripEquiSeleccionado").addClass("fecha");
								    $("#descripEquiSeleccionado").html('<span>'+fecha_actual.toLocaleDateString("es-ES", options)+'</span>');
								   	$("#descripEquiSeleccionado").after('<h2 class = "fecha">'+response[0]["valor_concatenado"]+'</h2>');
								}else{
								  	$("#descripEquiSeleccionado").html(response[0]["valor_concatenado"]);
									$("#descripEquiSeleccionado").after('<h2 class= "fecha"><spa class="" style="position:absolute; right:30px;">'+fecha_actual.toLocaleDateString("es-ES", options)+'</span></h2>');  	
								}

								$("#idequipo").val(response[0]["idequipomc"]);
			                	$("#codigoEquipo").val(response[0]["codigo"]);
								
			                	notfiNoEntrega = true;
							  }
							})
			        		
			        	}

			        }else{

			    	var datos2 = {
				      'buscarasignado': response[0]["idequipomc"]
				    }
				    $.ajax({
				        data: datos2,
				        url: rutaOculta + "ajax/equipos.ajax.php",
				        type: "POST",
				        dataType: "json",
				        success: function(responseasignado){
				        	/*==========================================================================
				        	=            VALIDAR QUE TODOS LOS TURNOS SE ENCUENTREN ACTIVOS            =
				        	==========================================================================*/
							
				        	var siexiste = false;
			        		for (var i = 0; i < responseasignado.length; i++) {
			        			if (responseasignado[i]["estado"] == 1){
			        				siexiste = true;
			        			}else{

			        			}
			        		}
				        	if (responseasignado.length == 0 || siexiste == false){
							  Swal.fire({
							  type: "warning",
							  title: "No se encuentra asignado usuario responsable",
							  text: "Por favor comunicar a su jefe inmediato para que asigne responsable"
							  })			      			
				        	}else{
				        		/*=================================================================================
				        		=            AÑADIR HTML PARA VER RESPONSABLE Y EL TURNO QUE PERTENECE            =
				        		=================================================================================*/
								
				        		$(".fecha").remove();
				        		//$("#descripEquiSeleccionado").html(response["valor_concatenado"]);
				    			if (window.matchMedia("(max-width:767px)").matches){
								    //$("#descripEquiSeleccionado").addClass("fecha");
								    $("#descripEquiSeleccionado").html('<span>'+fecha_actual.toLocaleDateString("es-ES", options)+'</span>');
								   	$("#descripEquiSeleccionado").after('<h2 class = "fecha">'+response[0]["valor_concatenado"]+'</h2>');
								}else{
								  	$("#descripEquiSeleccionado").html(response[0]["valor_concatenado"]);
									$("#descripEquiSeleccionado").after('<h2 class= "fecha"><span class="" style="position:absolute; right:30px;">'+fecha_actual.toLocaleDateString("es-ES", options)+'</span></h2>');  	
								}
										
			        			var htmlresponsable = '<div class="input-group">'+
				                    '<span class="input-group-addon">Responsable: </span> '+
	                      			'<input type="text" class="form-control input-lg uppercase responsableCheckList" readonly>'+
									'</div>';
				        		var htmlturno = '<div class="input-group">'+
	                  							'<span class="input-group-addon">Turno: </span>'+
	                      						'<select id="turnoCheckList" name="turnoCheckList" class="form-control input-lg">'+
	                        					'<option value="Seleccionar una opción">Seleccionar una opción</option>';
				        		for (var i = 0; i < responseasignado.length; i++) {
				        			if (responseasignado[i]["estado"] == 1){

									htmlturno += '<option value="'+responseasignado[i]["ideasignacion"]+'">TURNO '+responseasignado[i]["turno"]+'</option>';

				        			
				        			}
				        		}
				        		//console.log(responseasignado);
				        		htmlturno += '</select>'+
	                				'</div>';
		               			$(".asignado").html(htmlresponsable);
	                			$("#idequipo").val(response[0]["idequipomc"]);
	                			$("#codigoEquipo").val(response[0]["codigo"]);
				        		$(".turnocheck").html(htmlturno);
				        		$("#checkListsmartwizard").hide();
				        		$("#registro_novedad").hide();
				        		$("#PrestamoEquipoWizard").hide();
				        		$("#botonesacciones").hide();
								$(".btnCheck").hide();								      	
				        		//$("#botonesacciones").show();
				        		$("#turnoCheckList").change(function(){
				        			/*=====  OCULTAMOS TODOS LOS MENUS AL HACER CAMBIO  ======*/
				        			$("#checkListsmartwizard").hide();
				        			$("#registro_novedad").hide();
				        			$("#PrestamoEquipoWizard").hide();

				        			var idasignar = $(this).val();
				        			var idequipomc =  response[0]["idequipomc"];
									var datos = new FormData();
									datos.append("idasignarverificarcheck",idasignar);
									datos.append("idequipoverificarcheck",idequipomc);			        			
								    $.ajax({
								      data: datos,
								      url: rutaOculta + "ajax/equipos.ajax.php",
								      type: "POST",
								      contentType: false,
								      processData: false,
								      success: function(respuesta) {
								      	//$("#botonesacciones").hide();
								      	//$(".btnCheck").hide();
								      	//console.log(respuesta)
								      	if (respuesta.trim() == 1 || respuesta.trim() == 2){
								      	$("#botonesacciones").show();
								      	$(".btnCheck").hide();

								        Swal.fire({
								            type: "warning",
								            title: "El turno seleccionado ya ha registrado el CHECLIST."
								            })
								      	}else if (respuesta.trim() == 3){
								      	$("#botonesacciones").show();
								      	$(".btnCheck").hide();
								        Swal.fire({
								            type: "warning",
								            title: "El administrador ha reportado que no ha cumplido con el Check List"
								            })
								      	}else{
								      		$("#botonesacciones").show();
								      		if (response[0]["idequi_padre"] == null){
								      			$(".btnCheck").show();
								      		}else{
								      			$(".btnCheck").hide();
								      		}
							        		
								      	}
								      }
								    });

				        			for (var i = 0; i < responseasignado.length; i++) {
				        				if (responseasignado[i]["ideasignacion"] == idasignar){
				        					$(".responsableCheckList").val(responseasignado[i]["responsable"]);
				        					$("#selectturn").val(idasignar);
				        				}
				        					
				        			}
				        		})


				        		
				        	}
				        	
				        	

				        }
				    }); 			        	

			        }       			

        		}else{
					Swal.fire('El código ' + cod.toUpperCase() + ' no se encuentra registrado');        			
        		}
		        
        	}
        }

      });

    }
  })()	
})
/*=================================================
=            DAR CLICK EN OK CHECKLIST            =
=================================================*/
var estados = [];
$(".btnok").click(function(){
	var clase = $(this).parent().parent();
	$(clase).addClass("list-group-item-success");
	$(clase).children().remove();
	$("body .tooltip").remove();
	$(clase).attr("value","listo");
	//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
	var li = $("#checkListsmartwizard .nav-tabs li");
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
		var classes = $(this).hasClass("btnok"+i)
		if (classes){
			numitem = "btnok"+i;
		}
	}
	estados.push({[numitem.slice(-1)] : 0});
})
/*========================================================================
=            CUANDO DA CLICK EN REGISTRO DE NOVEDAD CHECKLIST            =
========================================================================*/
$(".btnovedad").click(function(){
(async () => {

const { value: novedad } = await Swal.fire({
  title: 'Registro de novedad ',
  input: 'select',
  inputOptions: {
	'DAÑOS EN CHASIS Y ESTRUCTURA DEL EQUIPO': 'DAÑOS EN CHASIS Y ESTRUCTURA DEL EQUIPO',
	'PRESENTA FUGAS DE ACEITE': 'PRESENTA FUGAS DE ACEITE',
	'LAS RUEDAS PRESENTA DAÑOS O DESGASTE EXCESIVO': 'LAS RUEDAS PRESENTA DAÑOS O DESGASTE EXCESIVO',
	'EXISTE FUGA DE ACEITE HIDRAULICO': 'EXISTE FUGA DE ACEITE HIDRAULICO',
	'MAL ESTADO DE MANGUERAS Y CAÑERIAS' : 'MAL ESTADO DE MANGUERAS Y CAÑERIAS',
	'EXISTE FUGAS DE ACEITE' : 'EXISTE FUGAS DE ACEITE',
	'DAÑOS EN TABLERO DE INSTRUMENTOS, SWITCH, PALANCA DE MANDOS' : 'DAÑOS EN TABLERO DE INSTRUMENTOS, SWITCH, PALANCA DE MANDOS',
	'DAÑOS EN BATERIA, CABLES Y CONECTORES' : 'DAÑOS EN BATERIA, CABLES Y CONECTORES',
	'BAJO NIVEL AGUA DE BATERIA': 'BAJO NIVEL AGUA DE BATERIA',
	'ESTADO DE CARRO PORTABATERIAS (NO TIENE LA CUBIERTA)' : 'ESTADO DE CARRO PORTABATERIAS (NO TIENE LA CUBIERTA)',
	'SEGURO DE CARRO PORTABATERIAS (MAL ESTADO)' : 'SEGURO DE CARRO PORTABATERIAS (MAL ESTADO)',
	'ESTRUCTURA DEL EQUIPO (MAL ESTADO)' : 'ESTRUCTURA DEL EQUIPO (MAL ESTADO)',
	'DAÑOS EN CABLES Y CONECTOR' : 'DAÑOS EN CABLES Y CONECTOR',
	'LUCES NO FUNCIONA' : 'LUCES NO FUNCIONA',
	'NO ENCIENDE EL EQUIPO' : 'NO ENCIENDE EL EQUIPO',
	'NO FUNCIONA LA BOCINA' : 'NO FUNCIONA LA BOCINA',
	'DIRECCIONALES EN MAL ESTADO (DERECHO,IZQUIERDO)' : 'DIRECCIONALES EN MAL ESTADO (DERECHO,IZQUIERDO)',
	'HIDRAULICAS NO OPERATIVAS' : 'HIDRAULICAS NO OPERATIVAS',
	'EMITE RUIDO EN LA MARCHA' : 'EMITE RUIDO EN LA MARCHA',
  },
  inputPlaceholder: 'Seleccionar la novedad presentada',
  customClass: {
  	input: 'disabled value=""',
  }
})
if (novedad){
	var clase = $(this).parent().parent();
	$(clase).addClass("list-group-item-danger");
	$(clase).children().remove();
	$("body .tooltip").remove();
	//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
	var li = $("#checkListsmartwizard .nav-tabs li");
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
		var classes = $(this).hasClass("btnovedad"+i)
		if (classes){
			numitem = "btnovedad"+i;
		}
	}

	estados.push({[numitem.slice(-1)] : novedad});
	$(clase).attr("value","novedad");
}
})()
})
var directionSwart = "";
$ ("#checkListsmartwizard"). on ("leaveStep", function (e, anchorObject, stepNumber, stepDirection) {
	//VALIDA SI DA CLICK EN SIGUIENTE
	directionSwart = stepDirection;
	if (stepDirection == "forward"){
		//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
		var li = $("#checkListsmartwizard .nav-tabs li");
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
		$('input[id="allitem"]').iCheck('uncheck');
	}else{
		Swal.fire({
		type: "warning",
		title: "No puede retroceder.."
		})
		return false;		
	}
});
/*=============================================================
=            BOTON INCIAL PARA HACER EL CHECK LIST O REGISTRAR NOVEDADES            =
=============================================================*/
var motivoatrasacheck = "";
var confiratrasocheck = false;
$(".btnCheck").click(function(){
	var selecturno = $("#turnoCheckList").val();
	if (selecturno != "Seleccionar una opción"){
		
		if (window.matchMedia("(max-width:767px)").matches){
			$("#botonesacciones").removeClass("pull-right");
			$("#contenido_items li").css({"padding":"7px 6px"});
			$("#contenido_items .optionchecklist").removeClass("pull-right");
			$("#contenido_items .optionchecklist").removeClass("btn-group").addClass("input-group-btn");
			$("#contenido_items .optionchecklist").attr("align","right");
		}
		/*===============================================================================================================
		=            VALIDAMOS QUE SOLO SEA PERMITIDO REALIZAR EL CHECK LIST DENTRO DE UN HORARIO ESPECIFICO            =
		===============================================================================================================*/
		var turno = $("#turnoCheckList option:selected").html();
		/*OBTENEMOS HORA Y FECHA ACTUAL*/
		var now = new Date();
		var hora = now.getHours();//obtenemos la hora actual
		/*=================================
		=            HORARIOS             =
		=================================*/
		var Turno1 = "7:00 am hasta 9:00 am";
		var Turno2 = "7:00 am hasta 9:00 am";
		var Turno3 = "7:00 am hasta 9:00 am";

		var idciudad = $("#idciudad").val();
		
		
		if (idciudad == 1) {
			if (turno == "TURNO 1" && hora <=10){
				$("#checkListsmartwizard").show();
				$("#registro_novedad").hide();
				$("#checkListsmartwizard").smartWizard("reset");
				$('input[id="allitem"]').iCheck('uncheck');
			}else if (turno == "TURNO 2") {
				$("#checkListsmartwizard").show();
				$("#registro_novedad").hide();
				$("#checkListsmartwizard").smartWizard("reset");
				$('input[id="allitem"]').iCheck('uncheck');
			}else if (turno == "TURNO 3") {
				$("#checkListsmartwizard").show();
				$("#registro_novedad").hide();
				$("#checkListsmartwizard").smartWizard("reset");
				$('input[id="allitem"]').iCheck('uncheck');			
			}else{
				Swal.fire({
					type: "warning",
					title: "Horario no permitdo",
					html: "Se recuerda que el check List debe ser realizado desde la <strong style='font-size: 15px;'>7:00 am hasta 9:00 am</strong> <br> <strong>Hora actual: </strong> <strong style='font-size: 15px;'>"+now.toLocaleTimeString()+"</strong>"+
						"<br><br><strong style='font-size: 15px;'>Nota: </strong><span style='font-size: 15px;'>El no realizar el check list de forma periodica puede incurrir en un llamado de atención.</span><br><br>Para realizar el check List atrasado debe reportar motivo",
					showCancelButton: false,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Reportar Motivo'		
					}).then((result) => {
						if (result.value) {
							(async () => {
							const { value: motivo } = await Swal.fire({
							  title: 'Registrar Motivo',
							  input: 'textarea',
							  inputPlaceholder: 'Detallar motivo',
							  customClass: {
							  	input: 'uppercase',
							  }
							})
							if (motivo){
								motivos = motivo.split("\n").join(" ");
								motivoatrasacheck = motivos.toUpperCase();
								confiratrasocheck = true;
								$("#checkListsmartwizard").show();
								$("#registro_novedad").hide();
								$("#checkListsmartwizard").smartWizard("reset");
								$('input[id="allitem"]').iCheck('uncheck');
							}
							})()						

						}
					})					
				$("#checkListsmartwizard").hide();
				$("#registro_novedad").hide();
				$("#checkListsmartwizard").smartWizard("reset");
				$('input[id="allitem"]').iCheck('uncheck');
			}			
		}else{
			$("#checkListsmartwizard").show();
			$("#registro_novedad").hide();
			$("#checkListsmartwizard").smartWizard("reset");
			$('input[id="allitem"]').iCheck('uncheck');			
		}

	}else{
		Swal.fire({
			type: "warning",
			title: "Primrero debes seleccionar el turno"
		})

							





	}


})
/*============================================================
=            BTN NOVEDAD DE CHECK LIST DE EQUIPOS            =
============================================================*/
$(".btnNovedad").click(function(){
	var selecturno = $("#turnoCheckList").val();
	if (selecturno != "Seleccionar una opción"){
		if (window.matchMedia("(max-width:767px)").matches){
			$("#cargarimgnovedadEquipo .input-group-addon").css("display","none");
			var spantexto = $("#cargarimgnovedadEquipo .input-group-btn label span");
			$(spantexto[1]).css("display","none");
		  }else{

		  }		

		var li = $("#checkListsmartwizard .nav-tabs li");
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
			if (!$(numoption[i]).children().hasClass("optionchecklist")){
				$(numoption[i]).append('<div class="btn-group pull-right optionchecklist">'+
                         			'<button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok'+i+' "> <span class="glyphicon glyphicon-ok-sign"></span></button>'+
                                    '<button data-bs-toggle="modal" data-bs-target="#modalequipo" title="Registrar novedad" class="btn btn-info btnovedad btnovedad'+i+'"> <span class="glyphicon glyphicon-warning-sign"></span></button>'+
                                    '</div>');
			}
		}
		estados = [];
		$("#registro_novedad").show();	
		$("#PrestamoEquipoWizard").hide();
		$("#checkListsmartwizard").hide();
		$("#checkListsmartwizard").smartWizard("reset");
		$('input[id="allitem"]').iCheck('uncheck');
	}else{
		Swal.fire({
		type: "warning",
		title: "Primrero debes seleccionar el turno"
		})		
	}

})
/*==================================================================================
=            CHECK PARA CONFIRMAR QUE EL EQUIPO SE ENCUENTRA PARALIZADO            =
==================================================================================*/
$('.paralizacion').on('ifToggled', function(event){
	$("#datosparalizacion").toggle();
});
/*=========================================================================
=            SELECCIONAR LA IMAGEN DEL EQUIPO DE LAS NOVEDADES            =
=========================================================================*/
var imgNovedadEquipo = null;
$('input[name="imgnovedadequipo"]').change(function(e) {	
  // Options will go here
  imgNovedadEquipo = this.files[0];
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
     $('#cargarimgnovedadEquipo .form-control').text(imgNovedadEquipo.name);
  }

});

function RegistroNovedad(){
	var det_novedad = $(".descripcion_novedad").val();
	var ubicacion = $(".ubicacionparalizacion").val();
	var obsercheck = $(".observacionesot").val();
	var horoparalizacion = $(".horometroparalizacion").val();
	var checked = $('input[id="checkparalizacion"]').is(':checked');
	if (det_novedad == ""){
		    Swal.fire({
		      title: 'Complete la información!',
		      text: 'Es necesario detallar las novedades presentadas en el equipo',
		      type: 'warning',
		      confirmButtonText: 'Aceptar'
		    });
		    return false;			

	}else if (checked ){
		if (ubicacion == "" || horoparalizacion == "") {
		    Swal.fire({
		      title: 'Paralización!',
		      text: 'Es necesario llenar los datos al aplicar paralización',
		      type: 'info',
		      confirmButtonText: 'Aceptar'
		    });
		    return false;			
		}
	}
	else{
	
		return true;
	}

}


/*==================================================
=            TABLA DE NOVEDADES EQUIPOS            =
==================================================*/
var tableNovedades =$('#Novedades').DataTable({
	initComplete: function(){
		this.api().columns().every(function(index){
			var column = this;
			/*=========================================================================
			=            LLENAR LOS SELECT DE LOS DATOS UNIQUE DE LA TABLA            =
			=========================================================================*/
				column.data().unique().sort().each( function ( d, j ) {
					$("[data-column='"+index+"']").append('<option value="'+d+'">'+d+'</option>');				
	            });
 
		});
	},
  "ajax": "ajax/TablaNovedadesEquipos.ajax.php",
  "deferRender": true,
  "retrieve": true,
  "processing": true,
  "order": [[ 7, "desc" ]],
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

  },
        dom: "Blfrtip",
        buttons: [
          {
              extend: "excel",
              className: "btn-sm",
              filename: "Reporte de Novedades",
              sheetName: "Listado Novedades"
          },
          {
            text: 'Reportar Novedades',
            className: "btn-sm",
            action: function(e,dt,node,conf){
              var btn = $("#noti").html('<label>Correos a notificar, presionar la tecla <span class="badge ">ENTER</span> si son más de uno: </label>'+
                                                  '<input type="text" id="CorreosNoti"name="" data-role="tagsinput">');
              $('#CorreosNoti').tagsinput('destroy');
              $('#CorreosNoti').tagsinput();
              $(".bootstrap-tagsinput").append('<span style="cursor:pointer;" class="pull-right badge btnEnviarNotificacionNovedades">Enviar <i class="fas fa-mail-bulk"></i></span>');           
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
              $(".btnEnviarNotificacionNovedades").click(function(){

                var correos = $("#CorreosNoti").tagsinput('items');
                var datosCorrNoti = new FormData();
                datosCorrNoti.append("noticorreosNovedades", JSON.stringify(correos));
                datosCorrNoti.append("tabla_data",JSON.stringify(dt.rows().data().toArray()));
                $.ajax({
                  data: datosCorrNoti,
                  url: rutaOculta + "ajax/equipos.ajax.php",
                  type: "POST",
                  contentType: false,
                  processData: false,
                  beforeSend: function(){
                     document.getElementById("conte_loading").style.display = "block";
                  },
                  success: function(response) {
                  	
                    if (response.trim() == 1 ){

                      Swal.fire('Se ha notificado correctamente al Proveedor');
                      document.getElementById("conte_loading").style.display = "none";
                      window.location = "novedades";
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
/*=============================================================================================
=            ABRIR EL MENU PARA SELECCIONAR LA FECHA PROPUESTA DE POSIBLE SOLUCIÓN            =
=============================================================================================*/
$('#Novedades tbody').on("click", ".btnFechaPropuesta", function() {
		var idnovequipos = $(this).attr("idnovedad");
		$("#idnovedad_fecha").val(idnovequipos);
		$('#datetimepicker8').datetimepicker({
			format: 'YYYY-MM-DD',
	    icons: {
	        time: "fa fa-clock-o",
	        date: "fa fa-calendar",
	        up: "fa fa-arrow-up",
	        down: "fa fa-arrow-down"
	    }
	})
})
/*==================================================
=            GUARDAR LA FECHA PROPUESTA            =
==================================================*/
$(".guardarFechaPropuesta").click(function(){
	var fechapropuesta = $(".date_propuesta").val();
	var idnovequipos = $("#idnovedad_fecha").val();
    var datos = new FormData();
    datos.append("fecha_propuesta", fechapropuesta);
    datos.append("idnovequipos",idnovequipos);
    
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
	  /*beforeSend: function(){
		   document.getElementById("conte_loading").style.display = "block";
	  },*/
      success: function(respuesta) {
      	if (respuesta.trim() == "ok"){

          Swal.fire({
            type: "success",
            title: "Fecha tentativa registrada con Exito!!",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
            window.location = "novedades";
            }
          })	      		
      	}

      }

    });		

	
})
/*=====  GUARDAMOS LA NOVEDAD CONCLUIDA  ======*/
function GuardarNovedadConcluida(idnovequipos,idequipo,value0,value1,pdf){
	    var datos = new FormData();
	    datos.append("idnovedadconcluido", idnovequipos);
	    datos.append("idequipoconcluido",idequipo);
	    datos.append("ot",value0);
	    datos.append("observacionot",value1);
	    datos.append("otrealizada",pdf);
	    $.ajax({
	      data: datos,
	      url: rutaOculta + "ajax/equipos.ajax.php",
	      type: "POST",
	      contentType: false,
	      processData: false,
          /*beforeSend: function(){
             document.getElementById("conte_loading").style.display = "block";
          },*/	      
	      success: function(respuesta) {
            localStorage.removeItem("otPDF");
            localStorage.clear();	      	
	      	if (respuesta){
	          Swal.fire({
	            type: "success",
	            title: "Novedad resuelta exitosamente.",
	            showConfirmButton: true,
	            confirmButtonText: "Cerrar"
	            }).then(function(result){
	            if (result.value) {
					window.location = "novedades";
	            }
	          })	      		
	      	}

	      }

	    });
}

 
/*====================================================
=            BOTON DE TABLA DE NOVEDADES             =
====================================================*/
$('#Novedades tbody').on("click", ".btnConcluidaNovedad", function() {
	var idnovequipos = $(this).attr("idnovedad");
	var idequipo = $(this).attr("idequipo");

	var htmlmensaje = '<div class="">'+
            '<div class="col-xs-12 col-md-12">'+
              '<div class="">'+
                '<label class="input-group">O.T * :</label>'+
               ' <input type="number" id="swal-input1" class="input-group form-control" required="">'+
             ' </div>'+
           ' </div>'+
            '<div class="col-xs-12 col-md-12">'+
             ' <div class="">'+
               ' <label class="input-group" >Observaciones * :</label>'+
              '  <textarea id="swal-input2" class=" input-group form-control"></textarea>'+
             ' </div>'+
           ' </div>'+
            '<div class="col-xs-12 col-md-12">'+
             ' <div class="">'+
               ' <label class="input-group" >Cargar archivo (.pdf) :</label>'+
               ' <input type="file" name="swal-input3" id="swal-input3" style="display: block;" class=" input-group form-control">'+
             ' </div>'+
           ' </div>'+           
         ' </div>';
	(async () => {

	const { value: formValues } = await Swal.fire({
	  title: 'Datos de Orden de Trabajo',
	  html:  htmlmensaje,
      confirmButtonText: 'Novedad Resuelta',
	  focusConfirm: false,
	  preConfirm: () => {
	  	  var filePath = document.getElementById('swal-input3').value;
		  var allowedExtensions = /(.pdf)$/i;
		  if (filePath != ""){
			  if (!allowedExtensions.exec(filePath)) {
			    Swal.fire({
			      title: 'Error!',
			      text: 'Solamente se aceptan archivo de extensión (.pdf)',
			      type: 'error',
			      confirmButtonText: 'Aceptar'
			    });
			    filePath = '';
			    return false;
			  } else {
			    return [
			      document.getElementById('swal-input1').value,
			      document.getElementById('swal-input2').value,
			      $('input[id="swal-input3"]')
			    ]
			  }		  	
			}else{
			    return [
			      document.getElementById('swal-input1').value,
			      document.getElementById('swal-input2').value,
			      ""
			    ]
			}


	  }
	})

	if (formValues[0] != "" && formValues[1] != "") {
/*============================================================
=  ALMACENAMOS LA IMAGEN EN EL SERVIDOR Y OBTENEMOS LA RUTA  =
============================================================*/
	    var datos = new FormData();
	    if (formValues[2] != "" ){
	    	datos.append("fileOT", formValues[2][0].files[0]);
	    }else{
			datos.append("fileOT", "");
	    }
	    datos.append("equipomc", idequipo);
	    $.ajax({
	      data: datos,
	      url: rutaOculta + "ajax/equipos.ajax.php",
	      type: "POST",
	      contentType: false,
	      processData: false,
	      success: function(respuesta) {
	      	/*===========================================
	      	=            ALMACENAMOS LA RUTA            =
	      	===========================================*/
	      	GuardarNovedadConcluida(idnovequipos,idequipo,formValues[0],formValues[1],respuesta);
	      }

	    });
	}else{
		Swal.fire({
		type: "warning",
		title: "Es necesario llenar todos los campos para continuar..."
		});		
	}

	})()    
})
/*===================================================
=            BOTON DE ELIMINAR NOVEDADES            =
===================================================*/
$('#Novedades tbody').on("click", ".btnEliminarNovedad", function() {
	var idnovequipos = $(this).attr("idnovedad");
	var datos = new FormData();
    datos.append("idnovedadeliminar", idnovequipos);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
      	if (respuesta.trim() == "ok"){
          Swal.fire({
            type: "success",
            title: "Novedad eliminada exitosamente!!.",
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            }).then(function(result){
            if (result.value) {
            window.location = "novedades";
            }
          })	      		
      	}

      }

    });	        


})
/*====================================================
=            LIMPIAR ALERTA DEL EQUIPO MC            =
====================================================*/
$(".codigoE").focus(function(){
	$(".alert").remove();
	$(".codigoE").removeAttr("style");

})
/*=================================================================
=            VALIDAR QUE NO SE INGRESE EL MISMO CODIGO            =
=================================================================*/
$(".codigoE").focusout(function(){
	var equipomc = $(".codigoE").val().toUpperCase();
	var datos = new FormData();
    datos.append("codigomcseleccion", equipomc);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta) {
      	if (respuesta["codigo"] == equipomc || respuesta == 2){
      		$(".codigoE").css("border","2px solid red");
      		$(".codigoE").parent().parent().append('<div class="alert alert-warning " role="alert"><strong>Ya registrado!</strong> El codigo del equipo ya se encuentra registrado.</div>');
      	}

      }

    });		

})

/*=================================================================
=            CHECK PARA SELECCIONAR QUE TODO ESTA BIEN            =
=================================================================*/
$('.allitem').on('ifToggled', function(event){
	if ($('input[id="allitem"]').is(':checked')) {
		estados = [];
		//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
		var li = $("#checkListsmartwizard .nav-tabs li");
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
		$(numoption).removeClass("list-group-item-danger");
		$(numoption).addClass("list-group-item-success");
		$(numoption).attr("value","listo");
		for (var i = 0; i < numoption.length; i++) {
			$(numoption[i]).children().remove();
			$("body .tooltip").remove();
			numitem = "btnok"+i;
			estados.push({[numitem.slice(-1)] : 0});
		}
	}else{
		var li = $("#checkListsmartwizard .nav-tabs li");
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
			if (!$(numoption[i]).children().hasClass("optionchecklist")){
				$(numoption[i]).append('<div class="btn-group pull-right optionchecklist">'+
                         			'<button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok'+i+' "> <span class="glyphicon glyphicon-ok-sign"></span></button>'+
                                    '<button data-toggle="tooltip" title="Registrar novedad" class="btn btn-info btnovedad btnovedad'+i+'"> <span class="glyphicon glyphicon-warning-sign"></span></button>'+
                                    '</div>');
			}
		}
		estados = [];
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip();
		});		
		/*================================================================================================================
		=            PARA QUE LUEGO DE DAR CLICK EN DESACTIVAR SELECCION SE ACTIVE BOTON OK Y BOTON NOVEDADES            =
		================================================================================================================*/
		$(".btnok").click(function(){
			var clase = $(this).parent().parent();
			$(clase).addClass("list-group-item-success");
			$(clase).children().remove();
			$("body .tooltip").remove();
			$(clase).attr("value","listo");
			//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
			var li = $("#checkListsmartwizard .nav-tabs li");
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
				var classes = $(this).hasClass("btnok"+i)
				if (classes){
					numitem = "btnok"+i;
				}
			}
			estados.push({[numitem.slice(-1)] : 0});
		})

		$(".btnovedad").click(function(){
		(async () => {

		const { value: novedad } = await Swal.fire({
		  title: 'Registro de novedad steven',
		  input: 'select',
		  inputOptions: {
			'DAÑOS EN CHASIS Y ESTRUCTURA DEL EQUIPO': 'DAÑOS EN CHASIS Y ESTRUCTURA DEL EQUIPO',
			'PRESENTA FUGAS DE ACEITE': 'PRESENTA FUGAS DE ACEITE',
			'LAS RUEDAS PRESENTA DAÑOS O DESGASTE EXCESIVO': 'LAS RUEDAS PRESENTA DAÑOS O DESGASTE EXCESIVO',
			'EXISTE FUGA DE ACEITE HIDRAULICO': 'EXISTE FUGA DE ACEITE HIDRAULICO',
			'MAL ESTADO DE MANGUERAS Y CAÑERIAS' : 'MAL ESTADO DE MANGUERAS Y CAÑERIAS',
			'EXISTE FUGAS DE ACEITE' : 'EXISTE FUGAS DE ACEITE',
			'DAÑOS EN TABLERO DE INSTRUMENTOS, SWITCH, PALANCA DE MANDOS' : 'DAÑOS EN TABLERO DE INSTRUMENTOS, SWITCH, PALANCA DE MANDOS',
			'DAÑOS EN BATERIA, CABLES Y CONECTORES' : 'DAÑOS EN BATERIA, CABLES Y CONECTORES',
			'BAJO NIVEL AGUA DE BATERIA': 'BAJO NIVEL AGUA DE BATERIA',
			'ESTADO DE CARRO PORTABATERIAS (NO TIENE LA CUBIERTA)' : 'ESTADO DE CARRO PORTABATERIAS (NO TIENE LA CUBIERTA)',
			'SEGURO DE CARRO PORTABATERIAS (MAL ESTADO)' : 'SEGURO DE CARRO PORTABATERIAS (MAL ESTADO)',
			'ESTRUCTURA DEL EQUIPO (MAL ESTADO)' : 'ESTRUCTURA DEL EQUIPO (MAL ESTADO)',
			'DAÑOS EN CABLES Y CONECTOR' : 'DAÑOS EN CABLES Y CONECTOR',
			'LUCES NO FUNCIONA' : 'LUCES NO FUNCIONA',
			'NO ENCIENDE EL EQUIPO' : 'NO ENCIENDE EL EQUIPO',
			'NO FUNCIONA LA BOCINA' : 'NO FUNCIONA LA BOCINA',
			'DIRECCIONALES EN MAL ESTADO (DERECHO,IZQUIERDO)' : 'DIRECCIONALES EN MAL ESTADO (DERECHO,IZQUIERDO)',
			'HIDRAULICAS NO OPERATIVAS' : 'HIDRAULICAS NO OPERATIVAS',
			'EMITE RUIDO EN LA MARCHA' : 'EMITE RUIDO EN LA MARCHA',
		  },
		  inputPlaceholder: 'Seleccionar la novedad presentada',
		  customClass: {
			  input: 'disabled value=""',
		  }
		})
		if (novedad){
			var clase = $(this).parent().parent();
			$(clase).addClass("list-group-item-danger");
			$(clase).children().remove();
			$("body .tooltip").remove();
			//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
			var li = $("#checkListsmartwizard .nav-tabs li");
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
				var classes = $(this).hasClass("btnovedad"+i)
				if (classes){
					numitem = "btnovedad"+i;
				}
			}

			estados.push({[numitem.slice(-1)] : novedad});
			$(clase).attr("value","novedad");
		}
		})()
		})		
		
	}
});

/*=======================================================================
=            BOTON PARA DESCARGAR REPORTE DE NOVEDADES EXCEL            =
=======================================================================*/
$(".DescargarNovedades").click(function(){
	var rows = tableNovedades.rows().data().toArray();
	var envio = JSON.stringify(rows);


})

/*=======================================================
=            LISTADO DE CHECK LIST DE EQUIPO            =
=======================================================*/
$("#ListCheckListE").DataTable({
  "ajax": "ajax/TablaLisCheckList.ajax.php",
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
/*=================================================================================
=            CONSULTAR EL CHECK LIST REALIZADO EN UNA FECHA ESPECIFICA            =
=================================================================================*/
$(".btnbuscarCheckList").click(function(){
  $("#ListCheckListE").DataTable({
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
      "url": rutaOculta + "ajax/TablaLisCheckList.ajax.php",
      "data": function(d) {
        return $.extend({}, d, {
          "fecha": $(".valorFechaBuscarCheck").val()
        });
      }
    }
  })	
})
/*==========================================================
=            BOTON DE CHECK PRESTAMO DE EQUIPOS            =
==========================================================*/
var estadofast = [];
$(".btnfastok").click(function(){
	var clase = $(this).parent().parent();
	$(clase).addClass("list-group-item-success");
	$(clase).children().remove();
	$("body .tooltip").remove();
	$(clase).attr("value","listo");

	var numoption = $("#checkOperacionalfast ul li");
	var numitem = "";
	for (var i = 0; i < numoption.length; i++) {
		var classes = $(this).hasClass("btnfastok"+i)
		if (classes){
			numitem = "btnfastok"+i;
		}
	}
	estadofast.push({[numitem.slice(-1)] : 0});
})
/*==============================================================================
=            PRESENTAR SUGERENCIA DE PERSONAL PARA MANEJO DE EQUIPO            =
==============================================================================*/
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
		url: rutaOculta + "ajax/Sugerencias_Personal.json.php",
		dataType: 'json',
	    cache: false,
	    contentType: false,
	    processData: false,
	    success: function (respuesta){
			$('input[name="personal"]').typeahead({
			  hint: true,
			  highlight: true,
			  minLength: 1
			},
			{
			  name: 'states',
			  source: substringMatcher(respuesta["nombres"])
			});
			/*=============================================================================================
			=            AL MOMENTO DE SELECCIONAR EL PERSONAL SE ACTIVA PARA COLOCAR LA CLAVE            =
			=============================================================================================*/
			$('input[name="personal"]').bind('typeahead:select', function(ev, suggestion) {

				Swal.fire({
				  title: 'Ingresa el codigo',
				  input: 'text',
				  inputLabel: 'ultimos 7 digitos de la cedula',
				  showCancelButton: true,
				  inputAttributes: {
				    maxlength: 7,
				  },			  
				  confirmButtonText: 'Comprobar',
				  showLoaderOnConfirm: true,
				  preConfirm: (codigo) => {
						return fetch(rutaOculta + `ajax/personal.ajax.php?nombre=`+suggestion+`&codigo=`+codigo)
				      .then(response => {
				        if (!response.ok) {
				          throw new Error(response.statusText)
				        }
				        return response.json()
				      })		      
				      .catch(error => {
				        Swal.showValidationMessage(
				          `Request failed: ${error}`
				        )
				      })
				  },
				  allowOutsideClick: () => !Swal.isLoading()
				}).then((result) => {
				  if (result) {

				    Swal.fire({
				      title: `${result.value.resultado}`,
				    })
				    if (result.value.resultado == "Códido Incorrecto..") {
				    	// $(this).val("");
				    	$(this).typeahead('val', "");
				    }
				    
				  }else{
				  	$(this).typeahead('val', "");
				  }
				})
			});
			/*=====================================================================================================
			=            AL MOMENTO QUE SE CIERRA DEBE VALIDAR QUE EL USUARIO ESCOGIDO SEA EL CORRECTO            =
			=====================================================================================================*/

			
			
			
			var input = $(".labelPersonal").next();
	    	$(input).addClass("vertical-Align");

	    }

})
/*===================================================
=            TODO CHECK DE USO DE EQUIPO            =
===================================================*/
$('.allitemuso').on('ifToggled', function(event){
	if ($('input[id="allitemuso"]').is(':checked')) {
		estados = [];
		//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
		var li = $("#usosmartwizard .nav-tabs li");
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
		$(numoption).removeClass("list-group-item-danger");
		$(numoption).addClass("list-group-item-success");
		$(numoption).attr("value","listo");
		for (var i = 0; i < numoption.length; i++) {
			$(numoption[i]).children().remove();
			$("body .tooltip").remove();
			numitem = "btnok"+i;
			estados.push({[numitem.slice(-1)] : 0});
		}
	}else{
		var li = $("#usosmartwizard .nav-tabs li");
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
			if (!$(numoption[i]).children().hasClass("optionchecklist")){
				$(numoption[i]).append('<div class="btn-group pull-right optionchecklist">'+
                         			'<button data-toggle="tooltip" title="Todo bien!!" class="btn btn-info btnok btnok'+i+' "> <span class="glyphicon glyphicon-ok-sign"></span></button>'+
                                    '<button data-toggle="tooltip" title="Registrar Observacion" class="btn btn-info btnobservacion btnobservacion'+i+'"> <span class="glyphicon glyphicon-warning-sign"></span></button>'+
                                    '</div>');
			}
		}
		estados = [];
		$(document).ready(function(){
		  $('[data-toggle="tooltip"]').tooltip();
		});		
		/*================================================================================================================
		=            PARA QUE LUEGO DE DAR CLICK EN DESACTIVAR SELECCION SE ACTIVE BOTON OK Y BOTON NOVEDADES            =
		================================================================================================================*/
		$(".btnok").click(function(){
			var clase = $(this).parent().parent();
			$(clase).addClass("list-group-item-success");
			$(clase).children().remove();
			$("body .tooltip").remove();
			$(clase).attr("value","listo");
			//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
			var li = $("#usosmartwizard .nav-tabs li");
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
				var classes = $(this).hasClass("btnok"+i)
				if (classes){
					numitem = "btnok"+i;
				}
			}
			estados.push({[numitem.slice(-1)] : 0});
		})

		$(".btnobservacion").click(function(){
		(async () => {

		const { value: novedad } = await Swal.fire({
		  title: 'Registro de Observaciones',
		  input: 'textarea',
		  inputPlaceholder: 'Detalla la observación',
		  customClass: {
		  	input: 'uppercase',
		  }
		})
		if (novedad){
			var clase = $(this).parent().parent();
			$(clase).addClass("list-group-item-danger");
			$(clase).children().remove();
			$("body .tooltip").remove();
			//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
			var li = $("#usosmartwizard .nav-tabs li");
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
				var classes = $(this).hasClass("btnobservacion"+i)
				if (classes){
					numitem = "btnobservacion"+i;
				}
			}

			estados.push({[numitem.slice(-1)] : novedad});
			$(clase).attr("value","novedad");
		}
		})()
		})		
		
	}
});
/*====================================================================
=            CLICK EN BTNOBSERVACION DE CHECK LIST DE BPA            =
====================================================================*/
$(".btnobservacion").click(function(){
(async () => {

const { value: novedad } = await Swal.fire({
  title: 'Registro de Observaciones',
  input: 'textarea',
  inputPlaceholder: 'Detalla la observación',
  customClass: {
  	input: 'uppercase',
  }
})
if (novedad){
	var clase = $(this).parent().parent();
	$(clase).addClass("list-group-item-danger");
	$(clase).children().remove();
	$("body .tooltip").remove();
	//VALIDA HA REALIZADO EL CHECK A TODOS LOS ITEMS
	var li = $("#usosmartwizard .nav-tabs li");
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
		var classes = $(this).hasClass("btnobservacion"+i)
		if (classes){
			numitem = "btnobservacion"+i;
		}
	}

	estados.push({[numitem.slice(-1)] : novedad});
	$(clase).attr("value","novedad");
}
})()
})		
/*=====================================================
=            WIZAR DE MANEJO DE EQUIPOS MC            =
=====================================================*/
$("#usosmartwizard").smartWizard({
	theme: 'dots',
	lang: {  // Language variables
	  next: 'Siguiente',
	  previous: 'Atrás'
	},
	cycleSteps: false, // Allows to cycle the navigation of steps
	transitionEffect: 'fade', // Effect on navigation, none/slide/fade
    transitionSpeed: '400',
    toolbarSettings : { 
		showNextButton : false , // mostrar / ocultar un botón Siguiente  
    	showPreviousButton : false , // mostrar / ocultar un botón Anterior      	
	    toolbarExtraButtons : [ 
       $ ('<button> </button>') .text ('Finalizar')
		      .addClass('btn btn-info')
		      .on('click', function(){
		      	 debugger;
		      	/*=============================================================================
		      	=            VALIDAMOS QUE TODOS LOS CHECK SE ENCUENTREN VALIDADOS            =
		      	=============================================================================*/
				var li = $("#usosmartwizard .nav-tabs li");
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
						title: "Por favor complete todos los check para continuar..."
						})
						return false;
					}
				}
				var idequipo =$("#idequipo").val();
				var codigo = $("#codigoEquipo").val();
				var personal = $('input[name="personal"]').val();
				
				var bateria = $(".numbateria").val();
				var cod_bateria = $(".codigo_ba").val();
				var procentcarga = $(".porcarga").val();
				var horometroinicial = $(".horoinicio").val();
				var observaciones = $(".observa").val();
		      	/*=============================================================
		      	=            OBTENEMOS DATOS PARA ENVIAR A LA BASE            =
		      	=============================================================*/
		      	if (idequipo !== "" && codigo != "" && personal != "" && bateria != "" && procentcarga != "" && horometroinicial != "" && cod_bateria != ""){
		      		var valor1 = parseInt(horoequipoanterior);
		      		var valor2 = parseInt(horometroinicial);
		      		/*==========================================================================================
		      		=            COMPARAMOS SI EL NOMBRE QUE SE ECUENTRA EN EL CAMPO ES EL CORRECTO            =
		      		==========================================================================================*/
		      		debugger;
		      		fetch(rutaOculta + `ajax/personal.ajax.php?validnombre=`+personal)
				      .then(response => {
				        if (!response.ok) {
				          throw new Error(response.statusText)
				        }
				        return response.json()
				      })
			        .then(data => {
			        	if (data.resultado == "Nombre Incorrecto.." || data.resultado == "Nombre no registrado") {
									Swal.fire({
									type: "warning",
									title: personal+" ingresado esta incorrecto, por favor seleccione nuevamente su nombre.."
									})
									$(this).removeAttr("disabled");
									return false;
			        	}
			        })				      
				      .catch(error => {
				      	console.log(error);
									Swal.fire({
									type: "warning",
									title: `Request failed: ${error}`
									})
									return false;
				      })
				 	if (notfiNoEntrega == true && valor1  >= valor2){
							Swal.fire({
							type: "warning",
							title: "El Horometro debe ser mayor o igual al registro anterior."
							})
							return false;
				 	}else if(jQuery.inArray(personal,colummcpersonal) != -1){
							Swal.fire({
							type: "warning",
							title: personal+" ya se encuentra haciendo uso de un Equipo."
							})
							return false;
				 	}else{
				 		$(this).attr("disabled",true);
				      	var datos = new FormData();
						datos.append("idequipomanejo", idequipo);
						datos.append("nombre_personal",personal);
						datos.append("opciones", JSON.stringify(estados));
						datos.append("numbateria", bateria);
						datos.append("cod_bateria", cod_bateria);
						datos.append("pocentcarga", procentcarga);
						datos.append("horometroInicial", horometroinicial);
						datos.append("Observaciones", observaciones);
					    $.ajax({
					      data: datos,
					      url: rutaOculta + "ajax/equipos.ajax.php",
					      type: "POST",
					      contentType: false,
					      processData: false,
			              beforeSend: function(){
			                $('.gif').html('<div id="conte_loading" class="conte_loading">' +
			                                '<div id="cont_gif" >' +
			                                '<img src="' + rutaOculta + 'vistas/img/Spin-1s-200px.gif">' +
			                                '</div>' +
			                                '</div>').show();
			              },					      
					      success: function(respuesta) {
					      	/*===========================================================================
					      	=            VALIDAMOS SI ES NECESARIO REPORTAR NOTIFICAR NO USO            =
					      	===========================================================================*/
					      	if (notfiNoEntrega) {
								  	/*===============================================
								  	=            NOTIFICAMOS POR CORREO             =
								  	===============================================*/
								if (respuesta.trim() == "ok"){
									var datos = new FormData();
									datos.append("idmanejoeqnoentrega",idmanejoeq);
									datos.append("personalnoentrega",personalnoent);
									datos.append("personalnuevouso",personal);
									datos.append("horometronotificado",horometroinicial);
									
								    $.ajax({
								      data: datos,
								      url: rutaOculta + "ajax/equipos.ajax.php",
								      type: "POST",
								      contentType: false,
								      processData: false,
									  beforeSend: function(){
												   document.getElementById("conte_loading").style.display = "block";
									  },							      
								      success: function(respuesta) {
								      	if (respuesta.trim() == "ok"){
							        		Swal.fire({
											  type: 'success',
											  title: 'Equipo '+codigo+' Notificado e Ingresado Correctamente!',
											  html: 'La <strong>NO</strong> entrega fue reportado al Administrador de los Equipos<br>Queda registrado en uso por: '+personal,
									          showConfirmButton: true,
										      confirmButtonText: "Cerrar"
											}).then(function(result){
								                if (result.value) {
								                	window.location = "usomc";
								                }
								            }) 
								      	}
								      }
								    });	
								}			      		
							}else{
							      	if (respuesta.trim() == "ok"){
							          Swal.fire({
							            type: "success",
							            title: "El equipo "+codigo,
							            text: " Queda registrado en uso por: "+personal,
							            showConfirmButton: true,
							            allowOutsideClick: false,
							            confirmButtonText: "Cerrar"
							            }).then(function(result){
							            if (result.value) {
							            window.location = "usomc";
							            }
							          })
							      	}
								}


					      }

					    });					 		
				 	}	      		

		      	}else{
					Swal.fire({
					type: "warning",
					title: "Debe completar toda la información para continuar.."
					})		      		

		      	}
		      })
			      ]   
    }
});		
/*====================================================================
=            GENERAR TABLA PARA LISTADO DE EQUIPOS EN USO            =
====================================================================*/
var TablaManejoEquipo = $("#dataUsoEqui").DataTable({
	"ajax": "ajax/TablaEquiposUso.ajax.php",
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
/*===========================================================================
=            DAR CLICK EN EL BOTON DE LA TABLA DE USO DE EQUIPOS            =
===========================================================================*/
$('#dataUsoEqui tbody').on("click", ".btnTerminarUso", function() {
	var nombre = $(this).attr("nombre");
	var idmanejoeq = $(this).attr("idmanejo");
	var horoinicial = $(this).attr("horoinicial");
	Swal.fire({
	  title: 'Ingresa el codigo',
	  input: 'text',
	  inputLabel: 'ultimos 7 digitos de la cedula',
	  showCancelButton: true,
	  inputAttributes: {
	    maxlength: 7,
	  },			  
	  confirmButtonText: 'Comprobar',
	  showLoaderOnConfirm: true,
	  preConfirm: (codigo) => {
			return fetch(rutaOculta + `ajax/personal.ajax.php?nombre=`+nombre+`&codigo=`+codigo)
	      .then(response => {
	        if (!response.ok) {
	          throw new Error(response.statusText)
	        }
	        return response.json()
	      })		      
	      .catch(error => {
	        Swal.showValidationMessage(
	          `Request failed: ${error}`
	        )
	      })
	  },
	  allowOutsideClick: () => !Swal.isLoading()
	}).then((result) => {
	  if (result) {

	    Swal.fire({
	      title: `${result.value.resultado}`,
	    })
	    if (result.value.resultado == "Códido Correcto..") {
	    	$(".modalTerminoUso").modal();
				$("#idmanejoeq").val(idmanejoeq);
				$("#horoinicial").val(horoinicial);
				$(".horoinicial").val(horoinicial);//llama variable del horometro mediante la clase para que me lo presente en el input.
	    }
	  }
	})


	

  /*if (window.matchMedia("(max-width:767px)").matches){
    //$(".dz-message").html("Haz click para Seleccionar la Imagen");
    //var num = $("#inputEditar .input-lg").length;
    //for (var i = 0; i < num; i++) {
      $("#inputEditarEquipo .input-lg").addClass ("input-sm");
      $("#inputEditarEquipo .input-lg").removeClass("input-lg");
      
      
    //}
  }*/
})
/*===========================================================
=            BOTON DE INGRESAR TERMINO DE EQUIPO            =
===========================================================*/
$(".TerminarUsoEquipo").click(function(){
	var idmanejo = $("#idmanejoeq").val();
	var horoinicial = $("#horoinicial").val();
	var horofinal = $(".horofinal").val();
	var numbateria = $(".numbateriafinal").val().toUpperCase();
	var cantidadcarga = $(".rayascarga").val();
	var ubicacionequipo = $(".ubicacionfinal").val().toUpperCase();
	var observaciones = $(".observacionesfinal").val().toUpperCase();
	if (idmanejo != "" && horofinal != "" && numbateria != "" && cantidadcarga != "" && ubicacionequipo != "" ){
		if (horofinal >= horoinicial){
		  	var datos = new FormData();
			datos.append("idterminomanejo",idmanejo);
			datos.append("horofinal",horofinal);
			datos.append("numbateriafinal",numbateria);
			datos.append("cantcargafinal",cantidadcarga);
			datos.append("ubicafinal",ubicacionequipo);
			datos.append("observacionfinal",observaciones);
		    $.ajax({
		      data: datos,
		      url: rutaOculta + "ajax/equipos.ajax.php",
		      type: "POST",
		      contentType: false,
		      processData: false,
              beforeSend: function(){
                $('.gif').html('<div id="conte_loading" class="conte_loading">' +
                                '<div id="cont_gif" >' +
                                '<img src="' + rutaOculta + 'vistas/img/Spin-1s-200px.gif">' +
                                '</div>' +
                                '</div>').show();
              },			      
		      success: function(respuesta) {
		      	if (respuesta.trim() == "ok"){
		          Swal.fire({
		            type: "success",
		            title: "Ha registrado correctamente el Termino de Uso",
		            showConfirmButton: true,
		            confirmButtonText: "Cerrar"
		            }).then(function(result){
		            if (result.value) {
		            window.location = "usomc";
		            }
		          })
		      	}
		      }
		    });
		}else{
			Swal.fire({
			type: "warning",
			title: "El horometro de termino debe ser mayor o igual al inicial"
			});
			$(".horofinal").val("");			
		}
	}else{
		Swal.fire({
		type: "warning",
		title: "Es necesario llenar todos los campos para continuar..."
		});

	}

})
/*=======================================================
=            TABLA DE OPERATIVIDAD DE EQUIPO            =
=======================================================*/
var TablaOperatividad = $("#TablaOperatividadEQ").DataTable({
	initComplete: function(){
		/*this.api().column(1).data().unique().sort().each(function(d,j){
			$("#filterEquipo").append('<option value="'+d+'">'+d+'</option>');
		})*/
		this.api().columns().every(function(index){
			var column = this;

			/*=========================================================================
			=            LLENAR LOS SELECT DE LOS DATOS UNIQUE DE LA TABLA            =
			=========================================================================*/
			if (index != 7 && index != 4){
					column.data().unique().sort().each( function ( d, j ) {
						$("[data-column='"+index+"']").append('<option value="'+d+'">'+d+'</option>');				
					});
				
			}

		});
	},
	deferRender: true,
	dom: 'Blfrtip',
	"ajax": "ajax/TablaOperatividadEq.ajax.php",
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
	},
    buttons: [
      {
          extend: "excel",
          className: "btn-sm",
          filename: "Reporte de Uso de Equipos",
          sheetName: "Reporte"
      }

    ],
    /*=========================================================
    =            SUMA DE TOTAL DE HORAS TRABAJADAS            =
    =========================================================*/
    "footerCallback": function ( row, data, start, end, display ) {
        var api = this.api(), data;

        // Remove the formatting to get integer data for summation
        var intVal = function ( i ) {
            return typeof i === 'string' ?
                i.replace(/[\$,Horas]/g, '')*1 :
                typeof i === 'number' ?
                    i : 0;
        };


        // Total over all pages
        total = api
            .column( 9 )
            .data()
            .reduce( function (a, b) {
            	if (b > 0  || b != "NULL"){
            		return intVal(a) + intVal(b);
            	}else{
            		return intVal(a) + 0;
            	}
                
            }, 0 );

        // Total over this page
        pageTotal = api
            .column( 9, { page: 'current'} )
            .data()
            .reduce( function (a, b) {
               	if (b > 0  || b != "NULL"){
            		return intVal(a) + intVal(b);
            	}else{
            		return intVal(a) + 0;
            	}
            }, 0 );

        // Update footer
        $( api.column( 2 ).footer() ).html(
            pageTotal +' ('+ total +' Horas)'
        );
    }
        
        
        
});
/*============================================================================
=            REALIZA BUSQUEDA EN LA TABLA DE OPERACION DE EQUIPOS            =
============================================================================*/
$(".filterColumn").on('change',function(){
	//filterColumn($(this).attr('data-column'));
	var columna = $(this).attr('data-column');
	var valor = $(this).val();
	if (columna != 7){
		if (valor == "Seleccionar una opción"){
			valor = "";
		}
		TablaOperatividad.column(columna).search(valor).draw();

	}
	if (columna == 7){
		console.log(valor);
		if(valor == "Entregado"){
			valor = "^[1-9]";
			

		}else if (valor == "No Entregado"){
			valor = "^$";
		}
		TablaOperatividad.column(columna).search(valor,true,false).draw();

	}

	
		
})
/*=============================================================================
=            BOTON PARA ACTIVAR MODAL DE REGISTRO DE USO DE EQUIPO            =
=============================================================================*/
$("[data-target='.modalRegistrarUso']").click(function(){
	if (window.matchMedia("(max-width:767px)").matches){

		$("#contenido_items li").css({"padding":"7px 6px"});
		$("#contenido_items .optionchecklist").removeClass("pull-right");
		$("#contenido_items .optionchecklist").removeClass("btn-group").addClass("input-group-btn");
		$("#contenido_items .optionchecklist").attr("align","right");
	  }
})





/*================================================================
=            BOTON PARA VER QUIEN NOTIFICA NO ENTREGA            =
================================================================*/
$('#TablaOperatividadEQ tbody').on("click", ".btnNoEntrega", function() {
	var idmanejoeq = $(this).attr("idmanejo");
  	var datos = new FormData();
	datos.append("idTablaNotinoEntrega",idmanejoeq);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(respuesta) {
      	if (typeof respuesta === "object"){
      		var htmlnoti =   '<div class= "swal2-content">'+
							    '<div class="col-xs-12 col-md-6">'+
							      '<div class="input-group">'+
							          '<span class="input-group-addon">Fecha Notificación: </span>'+
							          '<input type="text" class="form-control input-lg" value="'+respuesta["fecha"]+'" readonly disabled>'+
							        '</div>'+
							    '</div>'+
							    '<div class="col-xs-12 col-md-6">'+
							      '<div class="input-group">'+
							          '<span class="input-group-addon">Hora Notificación: </span>'+
							          '<input type="text" class="form-control input-lg " value="'+respuesta["hora"]+'" readonly disabled>'+
							        '</div>'+
							    '</div>'+
							    '<div class="col-xs-12 col-md-12">'+
							      '<div class="input-group">'+
							          '<span class="input-group-addon">Desde Usuario:</span>'+
							          '<input type="text" class="form-control input-lg" value="'+respuesta["usuarionotificador"]+'" readonly disabled>'+
							        '</div>'+
							    '</div>'+
							    '<div class="col-xs-12 col-md-12">'+
							      '<div class="input-group">'+
							          '<span class="input-group-addon">Operario:</span>'+
							          '<input type="text" class="form-control input-lg" value="'+respuesta["personal"]+'" readonly disabled>'+
							        '</div>'+
							    '</div>    '+
							  '</div>';
          Swal.fire({
            type: "warning",
            html: htmlnoti,
            width: 800,
            showConfirmButton: true,
            confirmButtonText: "Cerrar"
            });
      	}
      }
    });	
	

})
/*===========================================================================================================
=            CONDICION PARA OCULTAR LA DESCARGA Y EL REPORTAR NOVEDAD DE LOS USUARIOS OPERATIVOS            =
===========================================================================================================*/
if (sessionStorage.getItem("perfiluser") != null){
	/*=============================================
		=            OBTENER LA URL ACTUAL            =
	=============================================*/
    var form = window.location.pathname;
    var url = form.split("/");
    var final = url[url.length-1];
	if (final == "novedades" && sessionStorage.getItem("perfiluser") == "OPERATIVO"){
		$("#Novedades_wrapper div.dt-buttons").hide();
		
	}
}
/*=====================================================
=            TABLA DE ASIGNACION DE LLAVES            =
=====================================================*/
$("#LlavesEq").DataTable({
	dom: 'Blfrtip',
        buttons: [
          {
              extend: "excel",
              className: "btn-sm",
              filename: "Listado de Asignacion",
              sheetName: "Asignación"
          },
			{
              extend: "pdf",
              className: "btn-sm"
          },
        ],	
	"ajax": "ajax/TablaAsignacion.ajax.php",
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
/*===============================================================
=            FILTRO DE TABLA DE NOVEDADES DE EQUIPOS            =
===============================================================*/
$(".filterColumnNovedad").change(function(){
	var columna = $(this).attr('data-column');
	var valor = $(this).val();
	if (valor == "Seleccionar una opción"){
		valor = "";
	}
	tableNovedades.column(columna).search(valor).draw();
		
})

/*===================================================
=            CERRAR TIEMPO DE CHECK LIST            =
===================================================*/
$('#ListCheckListE tbody').on("click", ".CerrarTiempoCheck", function() {
	var idequipo = $(this).attr("idequipo");
	var ideasignacion = $(this).attr("ideasignacion");
	var button = $(this);

(async () => {

const { value: motivo } = await Swal.fire({
  type: "warning",
  title: "¿Está seguro de Cerrar proceso de Check List?",
  input: "textarea",
  inputPlaceholder: "MOTIVO DE BLOQUEO",
  text: "¡Si no lo está puede cancelar la accíón!",
  showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, Cerrar!',
  inputValidator: (value) => {
    if (!value) {
      return 'Es necesario Colocar el motivo de Boqueo!'
    }
  }      
})

if (motivo) {
	var datos = new FormData();
    datos.append("equipoCerrarCheck",idequipo);
    datos.append("ideasignacion",ideasignacion);
    datos.append("motivobloq", motivo);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {
      	// debugger;
      	// $(button).attr("idcheck",respuesta);
      	// var input  = $('button[idcheck="'+respuesta+'"]').parent();
      	window.location = "ConsultCheck";

      }
    });
}

})()
})
/*================================================
=            CALENDARIO DE CHECK LIST            =
================================================*/
// document.addEventListener('DOMContentLoaded', function() {
// 	var calendarEl = document.getElementById('calendar');
// 	var calendar = new FullCalendar.Calendar(calendarEl, {
// 		 height: 650,
// 		 events: 'https://fullcalendar.io/demo-events.json',
// 	  // initialView: 'dayGridMonth'
// 	});
	
// 	calendar.render();

// });
$('#consultarmesCheck').datetimepicker({
	startView: 3,
	autoclose: true,
	minView: 3,
	maxView: 3,
	format: 'MM',
	language: 'es',
    linkField: 'mesconsultServe',
    linkFormat: 'm'

})
/*========================================================================
=            REPORTAR QUE EL EQUIPO SE ENCUENTRA NO OPERATIVO            =
========================================================================*/
$('#ListCheckListE tbody').on("click", ".ReportNoOperativo", function() {
	var idequipo = $(this).attr("idequipo");
	var ideasignacion = $(this).attr("ideasignacion");
	var button = $(this);

(async () => {

const { value: motivo } = await Swal.fire({
  type: "warning",
  title: "¿Está seguro de reportar no operatividad?",
  input: "textarea",
  inputPlaceholder: "MOTIVO DE LA INOPERATIVIDAD",
  text: "¡Si no lo está puede cancelar la accíón!",
  showCancelButton: true,
    confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Si, Reportar!',
  inputValidator: (value) => {
    if (!value) {
      return 'Es necesario Colocar el motivo de Inoperatividad!'
    }
  }      
})

if (motivo) {
	var datos = new FormData();
    datos.append("equipoReportNoOperativo",idequipo);
    datos.append("ideasignacion",ideasignacion);
    datos.append("motivobloq", motivo);
    $.ajax({
      data: datos,
      url: rutaOculta + "ajax/equipos.ajax.php",
      type: "POST",
      contentType: false,
      processData: false,
      success: function(respuesta) {

      	window.location = "ConsultCheck";

      }
    });
}

})()
})

/*=========================================================
=            CONSULTA DE CHECK LIST REALIZADOS            =
=========================================================*/
$(".btnConsultaCheckEquipo").click(function(){
	if ($("#consultarmesCheck").val() == ""){
		$("#mesconsultServe").val("")
	}
  $("#ConsultaCheckEquipo").DataTable({

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
    dom: "Blfrtip",
    buttons: [
  {
      extend: "excel",
      className: "btn-sm",
      filename: "Reporte de Check List",
      sheetName: "Data Check List"
  }
  ],
    "ajax": {
      "method": "POST",
      "url": rutaOculta + "ajax/TablaCheckRealizadosEquipos.ajax.php",
      "data": function(d) {
        return $.extend({}, d, {

          "idequipocHECK": $('#idequipoConsultCheck').val(),
          "mes": $("#mesconsultServe").val()
        });
      }
    }
  })	
})

/*========================================================
=            PLUGINS PARA MOSTRAR LA LIBRERIA            =
========================================================*/
// $('.prueba').fileTree({
//    script: 'bpa/tree.php',
//    onlyFolders: true,
//    expandSpeed: 250,
//    collapseSpeed: 250
// });
// $('.prueba').fileTree({
//    script: 'bpa/tree.php',
//    expandEasing: 'easeOutBounce'
// });
// $("#cliente").DataTable({

//     paging: true,
//     searching: true,
//     destroy: true,
//     "deferRender": true,
//     "processing": true,
//     "language": {

//       "sProcessing": "Procesando...",
//       "sLengthMenu": "Mostrar _MENU_ registros",
//       "sZeroRecords": "No se encontraron resultados",
//       "sEmptyTable": "Ningún dato disponible en esta tabla",
//       "sInfo": "Registros del _START_ al _END_ de un total de _TOTAL_",
//       "sInfoEmpty": "Registros del 0 al 0 de un total de 0",
//       "sInfoFiltered": "(filtrado de un total de _MAX_ registros)",
//       "sInfoPostFix": "",
//       "sSearch": "Buscar:",
//       "sUrl": "",
//       "sInfoThousands": ",",
//       "sLoadingRecords": "Cargando...",
//       "oPaginate": {
//         "sFirst": "Primero",
//         "sLast": "Último",
//         "sNext": "Siguiente",
//         "sPrevious": "Anterior"
//       },
//       "oAria": {
//         "sSortAscending": ": Activar para ordenar la columna de manera ascendente",
//         "sSortDescending": ": Activar para ordenar la columna de manera descendente"
//       }

//     },
// 	"ajax": {
// 		"method": "POST",
// 		"url": rutaOculta + "archivos/OT/GYE/"+file,
// 		"data": function(d) {
// 		  return $.extend({}, d, {
// 			"fecha": $("#cliente").val()
// });		
// 		}
// 		}
// });
$('.ListDoc').fileTree({
   script: 'bpa/tree.php',
   expandEasing: 'easeOutBounce'
}, function(file) {
	debugger;
   // console.log(file);
   // do something with file
   var ciudad = $("#idciudad").val();
   if (ciudad == 1){
   	window.open(rutaOculta+"archivos/OT/GYE/"+file);
   }else if (ciudad == 2) {
   	$('.selected-file').attr("src",rutaOculta+"archivos/OT/UIO/"+file);	
   }
   
   // $.text( $('a[rel="'+file+'"]').text() );
});
	


