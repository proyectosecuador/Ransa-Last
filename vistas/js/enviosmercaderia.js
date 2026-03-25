
jQuery('#fechaVencimiento').datetimepicker({
	mask:true,
	timepicker:false,
	
	format:'d/m/Y',
});
jQuery('#horaMovimiento').datetimepicker({
	mask:true,
	datepicker: false,
	format:'H:m',
});
jQuery.datetimepicker.setLocale('es');