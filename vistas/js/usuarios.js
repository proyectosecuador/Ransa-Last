/*======================================================
=            MOSTRAR INPUT SI ES UN CLIENTE            =
======================================================*/
$('#correo').focusout(function(){
  var texto = $('#correo').val();
  var patt = new RegExp('^[^0-9][a-zA-Z0-9_-]+([.][a-zA-Z0-9_]+)*[@]ransa+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$');
 	var res = patt.test(texto);
  const element =  document.querySelector('#userClient');
  const element2 =  document.querySelector('#selectPerfil');
  const element3 =  document.querySelector('#selectCuentaRan');
  const element4 =  document.querySelector('#textCuentaRan');
  const element5 =  document.querySelector('#inputcargo');
  const element6 =  document.querySelector('#seModulo_chosen');
  const element7 =  document.querySelector('#selectArea');
  const element8 =  document.querySelector('#selecCiudad');
  
  if (res){
    $("#userClient").val('');
    $("#userClient").hide();
    $("#selectPerfil").show();
    $("#selectCuentaRan").show();
    $("#textCuentaRan").show();
    $("#inputcargo").show();
    $("#seModulo_chosen").show();
    $("#selectArea").show();
    $("#selecCiudad").show();
    element2.classList.remove('animated','fadeOutRight');
    element3.classList.remove('animated','fadeOutRight');
    element4.classList.remove('animated','fadeOutRight');
    element5.classList.remove('animated','fadeOutRight');
    //element6.classList.remove('animated','fadeOutRight');
    element7.classList.remove('animated','fadeOutRight');
    //element5.classList.remove('animated','fadeOutRight');
    element2.classList.add('animated','fadeInRight');
    element3.classList.add('animated','fadeInRight');
    element4.classList.add('animated','fadeInRight');
    element5.classList.add('animated','fadeInRight');
    //element6.classList.add('animated','fadeInRight');
    element7.classList.add('animated','fadeInRight');
    element8.classList.add('animated','fadeInRight');
    //element5.classList.add('animated','fadeInRight');
  }else if(texto == ""){
    $("#userClient").hide();
    $("#selectPerfil").hide();
    $("#selectCuentaRan").hide();
    $("#textCuentaRan").hide();
    $("#inputcargo").hide();
    $("#seModulo_chosen").hide();
    $("#selectArea").hide();
    $("#selecCiudad").hide();
  }
  else{
    $("#userClient").css("display","block");
    $("#selectPerfil").val('cliente');
    $("#selectPerfil").hide();
    $("#selectCuentaRan").hide();
    $("#textCuentaRan").hide();
    $("#inputcargo").hide();
    $("#seModulo_chosen").hide();
    $("#selectArea").hide();
    $("#selecCiudad").hide();
	element.classList.add('animated', 'fadeInLeft');
  }
});
/*=====================================================
=            SELECCION MULTIPLE DE MODULOS            =
=====================================================*/
$("#seModulo").chosen({
  disable_search_threshold: 0,
  width: "95%"
});




/*===============================================
=            CARGAR IMAGEN DE PERFIL            =
===============================================*/
/*$('input[name="imgPerfil"]').change(function(e){
    // Options will go here
    let fileInvent = $(this);
    let filePath = fileInvent.val();
    var allowedExtensions = /(.jpg|.jpeg|.png)$/i;
    if(!allowedExtensions.exec(filePath)){
		Swal.fire({
		  	title: 'Error!',
		  	text: 'Solamente se aceptan archivos con extensiones .jpg|.jpeg|.png.',
		  	type: 'error',
		  	confirmButtonText: 'Aceptar'
		});
        filePath = '';
        return false;
    }else{
    	readURL(this);
    }
    
});*/
/*=========================================================
=            FUNCION PARA VISUALIZAR LA IMAGEN            =
=========================================================*/
/*function readURL(input) {    
  if (input.files && input.files[0]) {   
    var reader = new FileReader();
    var filename = $('input[name="imgPerfil"]').val();
    filename = filename.substring(filename.lastIndexOf('\\')+1);
    reader.onload = function(e) {
      debugger;      
      $('#blah').attr('src', e.target.result);
      $('#blah').hide();
      $('#blah').fadeIn(500);      
      $('#btnCargar .form-control').text(filename);             
    }
    reader.readAsDataURL(input.files[0]);    
  } 
  $(".alert").removeClass("loading").hide();
}*/
/*===========================================
=            SELECT MULTIPLE DE CUENTAS            =
===========================================*/
$('#seCuentaRan').multiSelect({
  keepOrder: true
});
/*=============================================
VALIDAR EMAIL REPETIDO
=============================================*/
var validarEmailRepetido = false;
$("#correo").change(function(){
  var email = $("#correo").val();

  var datos = new FormData();
  datos.append("validarEmail", email);

  $.ajax({

    url:rutaOculta+"ajax/Usuarios.ajax.php",
    method: "POST",
    data: datos,
    cache: false,
    contentType: false,
    processData: false,
    success:function(respuesta){
      
      if(respuesta.trim() == "false"){

        $(".alert").remove();
        validarEmailRepetido = false;

      }else{

        $("#correo").parent().before('<div class=" col-md-12 alert alert-warning"><strong>ADVERTENCIA:</strong> El correo electrónico ya existe en la base de datos, por favor ingrese otro diferente</div>')

          validarEmailRepetido = true;
      }
    }
  });
});
/*===========================================
=            BTN GUARDAR USUARIO            =
===========================================*/
$("#btnGUsuario").click(function(){
  /*=========================================
  =            VALIDAR EL CORREO            =
  =========================================*/
  if (validarEmailRepetido){
    $("#correo").parent().before('<div class=" col-md-12 alert alert-danger"><strong>ERROR:</strong> El correo electrónico ya existe en la base de datos, por favor ingrese otro diferente</div>')
    return false;
  }
  
  let nombre = $('input[name="nombre"]').val();
  let apellido = $('input[name="apellido"]').val();
  let correo = $('input[name="correo"]').val();
  let password = $('input[name="password"]').val();
  let cargo = $('input[name="cargopersonal"]').val();
  let perfil = $('#sePerfil').val();
  let cliente = $('#seClient').val();
  let modulo = $("#seModulo").val();
  let area = $("#seArea").val();
  let ciudad = $("#seCiudad").val();
  let vali = true;
  if (nombre == "" || apellido == "" || correo == "" || password == "" || cargo == ""){
    Swal.fire({
        title: 'Error!',
        text: 'Falta ingresar información',
        type: 'error',
        confirmButtonText: 'Aceptar'
    });
    vali = false;
  }
  /* Confirmamos que todo este validado */
  var formUsuario = new FormData(document.getElementById("formusuario"));
  if (vali){
    $.ajax({
        data: formUsuario,
        url: rutaOculta+"ajax/Usuarios.ajax.php",
        type: "POST",
        contentType: false,
        processData: false,
        success: function(response){
          debugger;
          if (response.trim() == "ok") {
            Swal.fire({
              type: "success",
              title: "Usuario Registrado Exitosamente..",
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
              if (result.value) {
              window.location = "usuarios";

              }
            })            

          }
        
        }
    });
  }
});
/*=============================================
FORMATEAR LOS IPUNT
=============================================*/

$("#correo").focus(function(){
  $(".alert").remove();
})
/*=======================================
=            CAMBIO DE CLAVE DE USUARIOS            =
=======================================*/
$(".btnCambiarClave").click(function(){
  var id = $("#idUsuario").val();
  var cactual = $(".contraActual").val();
  var cnueva = $(".contraNueva").val();
  if (cactual != "" && cnueva != ""){
      var datos = new FormData();
      datos.append("claveantigua", cactual);
      datos.append("idusuario", id);
      datos.append("clavenueva", cnueva);
    $.ajax({

      url: "ajax/Usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(respuesta) {
        if (respuesta.trim() == 1){
          $(".input_ContraActual").prepend("<div class='alert alert-danger alert-dismissible'>La contraseña Actual es Incorrecta!!..</div>")
        }else{
            Swal.fire({
              type: "success",
              title: respuesta,
              showConfirmButton: true,
              confirmButtonText: "Cerrar"
              }).then(function(result){
              if (result.value) {
              window.location = "perfil";

              }
            })
        }


      }
    })    
  }else{
    Swal.fire({
        title: 'Error!',
        text: 'Falta ingresar información',
        type: 'error',
        confirmButtonText: 'Aceptar'
    });
  }
})
/*============================================================
=            FUNCION PARA VISUALIZAR LAS IMAGENES            =
============================================================*/
function readImagen(input) {
  if (input.files && input.files[0]) {
    var reader = new FileReader();
    var fileLength = input.files.length;
    var filename = input.files.name;
    reader.onload = function(e) {
      
      $(".view_Logo_User").attr("src",e.target.result);

    }
    reader.readAsDataURL(input.files[0]);
  }
}
/*=============================================
=            CAMBIO DE IMAGEN LOGO DE USUARIOS            =
=============================================*/
var imagenLogoUser = null;
$('input[name="ImgLogoUser"]').change(function(e){
    imagenLogoUser = this.files[0];
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
    readImagen(this);
  }
})
/*===============================================================
=            GUARDAR AL EDITAR LA IMAGEN DEL USUARIO            =
===============================================================*/
$(".btn_Guar_User").click(function(){
  var fileimgUser = $('input[name="ImgLogoUser"]');
  var logoantiguo = $("#ImgUserAntiguo").val();
  var id = $("#idUsuario").val();
  if (fileimgUser.val() != ""){
    var datos = new FormData();
    datos.append("imguserAntigua", logoantiguo);
    datos.append("nuevaImagen", fileimgUser[0].files[0]);
    datos.append("iduser", id);

      $.ajax({
        url: "ajax/Usuarios.ajax.php",
        method: "POST",
        data: datos,
        cache: false,
        contentType: false,
        processData: false,
        success: function(respuesta) {
          if (respuesta.trim() == 1){
            Swal.fire({
              title: 'No se ha podido Actualizar Correctamente!!.',
              text: 'Contactarse con el administrador del Sistema',
              type: 'error',
              confirmButtonText: 'Aceptar'
            });            
          }else{
              Swal.fire({
                type: "success",
                title: respuesta,
                showConfirmButton: true,
                confirmButtonText: "Cerrar"
                }).then(function(result){
                if (result.value) {
                window.location = "perfil";

                }
              })
          }
        }
      })     




  }else{
    Swal.fire({
      title: 'Seleccione primero la Imágen!!.',
      text: '',
      type: 'warning',
      confirmButtonText: 'Aceptar'
    });    
  }
})









