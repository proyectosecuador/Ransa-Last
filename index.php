<?php
session_start();
require_once "controladores/plantilla.controlador.php";

require_once "controladores/usuarios.controlador.php";

require_once "controladores/productos.controlador.php";

require_once "controladores/productosDisensa.controlador.php";

require_once "controladores/clientes.controlador.php";

require_once "controladores/urlplataforma.controlador.php";

require_once "controladores/areas.controlador.php";

require_once "controladores/gestiondocumentos.controlador.php";

require_once "controladores/proveedores.controlador.php";

require_once "controladores/equipos.controlador.php";

require_once "controladores/ciudad.controlador.php";

require_once "controladores/tip_equipo.controlador.php";

require_once "controladores/localizacion.controlador.php";

require_once "controladores/centrocosto.controlador.php";

require_once "controladores/novedadequipo.controlador.php";

require_once "controladores/modulos_portal.controlador.php";

require_once "controladores/archivos.controlador.php";

require_once "controladores/checklistbpa.controlador.php";

require_once "controladores/t_transporte.controlador.php";

require_once "controladores/actividadE.controlador.php";

require_once "controladores/tipo_carga.controlador.php";

require_once "controladores/estibas.controlador.php";

require_once "controladores/movi_R_D.controlador.php";
require_once "controladores/servicioransa.controlador.php";
require_once "controladores/usuarios-responsables.controlador.php";
require_once "controladores/pers_autoriza.controlador.php";
require_once "controladores/personal.controlador.php";
require_once "controladores/garita.controlador.php";
require_once "controladores/checklisttrans.controlador.php";



require_once "modelos/plantilla.modelo.php";

require_once "modelos/rutas.php";

require_once "modelos/usuarios.modelo.php";

require_once "modelos/productos.modelo.php";

require_once "modelos/productosDisensa.modelo.php";

require_once "modelos/clientes.modelo.php";

require_once "modelos/urlplataforma.modelo.php";

require_once "modelos/areas.modelo.php";

require_once "modelos/gestiondocumentos.modelo.php";

require_once "modelos/proveedores.modelo.php";

require_once "modelos/equipos.modelo.php";

require_once "modelos/ciudad.modelo.php";

require_once "modelos/tip_equipo.modelo.php";

require_once "modelos/localizacion.modelo.php";

require_once "modelos/centrocosto.modelo.php";

require_once "modelos/novedadequipo.modelo.php";

require_once "modelos/modulos_portal.modelo.php";

require_once "modelos/archivos.modelo.php";

require_once "modelos/checklistbpa.modelo.php";

require_once "modelos/t_transporte.modelo.php";

require_once "modelos/actividadE.modelo.php";

require_once "modelos/tipo_carga.modelo.php";

//require_once "modelos/Q-R.php";

require_once "modelos/estibas.modelo.php";
require_once "modelos/movi_R_D.modelo.php";
require_once "modelos/servicioransa.modelo.php";
require_once "modelos/usuarios-responsables.modelo.php";
require_once "modelos/pers_autoriza.modelo.php";
require_once "modelos/personal.modelo.php";
require_once "modelos/garita.modelo.php";
require_once "modelos/checklisttrans.modelo.php";
/*=======================================
=            ENVIO DE CORREO            =
=======================================*/
/*require_once "extensiones/PHPMailer/src/PHPMailer.php";

require_once "extensiones/PHPMailer/src/SMTP.php";

require_once "extensiones/PHPMailer/src/Exception.php";*/
//require_once "extensiones/dropbox/vendor/autoload.php";
$plantilla = new ControladorPlantilla();
$plantilla->plantilla();
