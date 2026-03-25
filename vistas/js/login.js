/*=============================================
LOGIN CONTRASEÑA
=============================================*/
$("#logo_ver").click(function(){
	var input = $("#clave");
	if (input.attr("type") == "password" && $("#logo_ver").attr("class") == "fa fa-eye-slash"){

		input.attr("type","text");
		$("#logo_ver").removeClass("fa fa-eye-slash");
		$("#logo_ver").addClass("fa fa-eye");
	}else{
		$("#logo_ver").removeClass("fa fa-eye");
		$("#logo_ver").addClass("fa fa-eye-slash");
		input.attr("type","password");
	}
})