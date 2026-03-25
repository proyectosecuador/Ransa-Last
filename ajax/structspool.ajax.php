<?php
require_once "../controladores/archivos.controlador.php";
require_once "../modelos/archivos.modelo.php";
require_once "../controladores/clientes.controlador.php";
require_once "../modelos/clientes.modelo.php";
session_start();

$rows = file($_FILES['archiInvent']['tmp_name']);
$codigoarchi = substr($rows[2], 88,10);
$nombre_invent = trim(substr($rows[2], 98,30));
$fecha = trim(substr($rows[1], 220,40));
$fecha_valid = str_replace("/", "-", $fecha);
$fecha_div = explode("-", $fecha_valid);

/*****ubicacion de Zona Horaria*****/
date_default_timezone_set('America/Bogota');
/******para presentar la fecha en espa単ol******/
setlocale(LC_ALL, "esp");
////////**para asignar que muestre el mes texto del a単o*//
$mes_invent = strftime("%B",strtotime($fecha_valid));
/*****para asignar que muestre el mes numero del a単o******/
$mes_num = strftime("%m",strtotime($fecha_valid));
$anio_num = strftime("%Y",strtotime($fecha_div[2].'-'.$fecha_div[1].'-'.$fecha_div[0]));
$dia_num = strftime("%d",strtotime($fecha_div[2].'-'.$fecha_div[1].'-'.$fecha_div[0]));
$fechaInventBase = date('Y-m-d', strtotime($anio_num.'-'.$mes_num.'-'.$dia_num));
$ruta = "../archivos/Inventarios txt/";
$rutaserver = "../archtemp/";
if ($_POST['codigo'] != trim($codigoarchi)) {
	echo 1;
}
else{
	$nombre_archivo = str_replace(' ','',$_FILES['archiInvent']['name']);
	$nom_temp = $_FILES['archiInvent']['tmp_name'];
	if (!file_exists($ruta.$nombre_invent."/")) {
		/* CREAMOS LA CARPETA CON EL NOMBRE DEL CLIENTE */
		mkdir($ruta.$nombre_invent."/",0777);
		
	}
	if(!file_exists($ruta.$nombre_invent."/(".$mes_num.")".$mes_invent."/")){
		/* CREAMOS LA CARPETA CON EL NOMBRE DEL MES */
		mkdir($ruta.$nombre_invent."/(".$mes_num.")".$mes_invent."/",0777);
	}
	$rutadestino = $ruta.$nombre_invent."/(".$mes_num.")".$mes_invent."/";
	$nombre_arch = $nombre_invent."_".$fecha_valid.".txt";
	$fechaactual = date("Y-m-d");
	$item = "codigoransa";
	$rpta = ControladorClientes::ctrmostrarClientes($item,trim($codigoarchi));
	$datos = array("nombre" =>$nombre_arch,
				  "cliente" => $rpta['idcliente'],
				  "usuario" => $_SESSION["id"],
				  "ruta" => $rutadestino,
					"fecha" =>$fechaInventBase,
					"estado" => 1);
	$rpta = ControladorArchivos::ctrInserArchivos($datos);
	if ($rpta == "ok") {
		move_uploaded_file($nom_temp,$rutadestino.$nombre_arch);

		echo "<form id='formdatoExcel' method='POST' action='ajax/desInvenStyle.ajax.php'> <input type='hidden' name='nombre_archi' value='".$nombre_arch."'> <input type='hidden' name='codigoarch' value='".trim($codigoarchi)."'></form>
		<div class='table-responsive'>
			<table id='datatable-buttons' style='width:100%' class='table table-striped table-bordered dt-responsive nowrap'>
			<thead>	
			<tr>
				<th>Ubicacion</th>
				<th>Subnivel</th>
				<th>Tipo.Ubicacion</th>
				<th>Familia</th>
				<th>Grupo</th>
				<th>Tp</th>
				<th>Al</th>
				<th>Codigo</th>
				<th>Descripcion</th>
				<th>Fac.con</th>
				<th>Saldo</th>
				<th>Uni</th>
				<th>Fech.ingr</th>
				<th>Fech.venci</th>
				<th>lote</th>
				<th>cajas</th>
				<th>unid</th>
				<th>Id</th>
				<th>Paleta</th>
			</tr>
			</thead><tbody>";

	switch ($_POST['codigo']) {
		/*==========================================
		=            UNILEVER VALIDACIONES            =
		==========================================*/
		case 1588:
			for ($i=7; $i < count($rows) ; $i++) { 
				$cadena1 = substr($rows[$i], 0,15);//ubicacion
				$cadena19 = substr($rows[$i], 15,4);//subnivel
				$cadena2 = substr($rows[$i], 19,16);//tipo ubicacion
				$cadena3 = substr($rows[$i], 35,21);//familia
				$cadena4 = substr($rows[$i], 56,21);//grupo
				$cadena5 = substr($rows[$i], 77,3);//tp
				$cadena6 = substr($rows[$i], 80,3);//al
				$cadena7 = substr($rows[$i], 83,26);//codigo
				$cadena8 = substr($rows[$i], 109,51);//descripcion
				$cadena9 = substr($rows[$i], 160,10);//fact.conv
				$cadena10 = substr($rows[$i], 170,12);//saldo
				$cadena11 = substr($rows[$i], 182,4);//uni
				$cadena12 = substr($rows[$i], 186,11);//fech.ingr
				$cadena13 = substr($rows[$i], 197,11);//fech.venci
				$cadena14 = substr($rows[$i], 208,11);//lote
				$cadena15 = substr($rows[$i], 219,15);//cajas
				$cadcaj = explode(" ", trim($cadena15));
				$cadena16 = substr($rows[$i], 234,12);//unid
				$caduni = explode(" ", trim($cadena16));
				$cadena17 = substr($rows[$i], 246,3);//id
				$cadena18 = substr($rows[$i], 249,6);//paleta
				if (trim($cadena5) != "" && trim($cadena5) == "AT") {
					echo "<tr><td>".$cadena1."</td>
					<td>".$cadena19."</td>
					<td>".$cadena2."</td>
					<td>".$cadena3."</td>
					<td>".$cadena4."</td>
					<td>".$cadena5."</td>
					<td>".$cadena6."</td>
					<td>".$cadena7."</td>
					<td>".utf8_encode($cadena8)."</td>
					<td>".$cadena9."</td>
					<td>".$cadena10."</td>
					<td>".$cadena11."</td>
					<td>".$cadena12."</td>
					<td>".$cadena13."</td>
					<td>".$cadena14."</td>";
					if ($cadcaj[0] != "CAJ" && $cadcaj[0] != "CJA") {
						echo "<td>".$cadcaj[0]."</td>";
					}else{
						echo "<td>".""."</td>";
					}
					if ($caduni[0] != "BOT" && $caduni[0] != "PZS" && $caduni[0] != "PAC" && $caduni[0] != "UNI" && $caduni[0] != "CAJ") {
						echo "<td>".$caduni[0]."</td>";
					}else{
						echo "<td>".""."</td>";
					}
					echo "<td>".$cadena17."</td>
					<td>".$cadena18."</td></tr>";
				}
			}

		break;
		/*==========================================
		=            QUALA VALIDACIONES            =
		==========================================*/
		case 740:
			for ($i=7; $i < count($rows) ; $i++) { 
				$cadena1 = substr($rows[$i], 0,15);//ubicacion
				$cadena19 = substr($rows[$i], 15,4);//subnivel
				$cadena2 = substr($rows[$i], 19,16);//tipo ubicacion
				$cadena3 = substr($rows[$i], 35,21);//familia
				$cadena4 = substr($rows[$i], 56,21);//grupo
				$cadena5 = substr($rows[$i], 77,3);//tp
				$cadena6 = substr($rows[$i], 80,3);//al
				$cadena7 = substr($rows[$i], 83,26);//codigo
				$cadena8 = substr($rows[$i], 109,51);//descripcion
				$cadena9 = substr($rows[$i], 160,10);//fact.conv
				$cadena10 = substr($rows[$i], 170,12);//saldo
				$cadena11 = substr($rows[$i], 182,4);//uni
				$cadena12 = substr($rows[$i], 186,11);//fech.ingr
				$cadena13 = substr($rows[$i], 197,11);//fech.venci
				$cadena14 = substr($rows[$i], 208,17);//lote
				$cadena15 = substr($rows[$i], 225,15);//cajas
				$cadcaj = explode(" ", trim($cadena15));
				$cadena16 = substr($rows[$i], 240,12);//unid
				$caduni = explode(" ", trim($cadena16));
				$cadena17 = substr($rows[$i], 252,9);//id
				$cadena18 = substr($rows[$i], 261,3);//paleta
				if (trim($cadena5) != "" && trim($cadena5) == "AT" && trim($cadena6) != "MP" && trim($cadena6) != "OB") {
					echo "<tr><td>".$cadena1."</td>
					<td>".$cadena19."</td>
					<td>".$cadena2."</td>
					<td>".$cadena3."</td>
					<td>".$cadena4."</td>
					<td>".$cadena5."</td>
					<td>".$cadena6."</td>
					<td>".$cadena7."</td>
					<td>".utf8_encode($cadena8)."</td>
					<td>".$cadena9."</td>
					<td>".$cadena10."</td>
					<td>".$cadena11."</td>
					<td>".$cadena12."</td>
					<td>".$cadena13."</td>
					<td>".$cadena14."</td>";
					if ($cadcaj[0] != "CAJ" && $cadcaj[0] != "CJA") {
						echo "<td>".$cadcaj[0]."</td>";
					}else{
						echo "<td>".""."</td>";
					}
					if ($caduni[0] != "BOT" && $caduni[0] != "PZS" && $caduni[0] != "PAC" && $caduni[0] != "UNI" && $caduni[0] != "CAJ") {
						echo "<td>".$caduni[0]."</td>";
					}else{
						echo "<td>".""."</td>";
					}
					echo "<td>".$cadena17."</td>
					<td>".$cadena18."</td></tr>";
				}
			}

		break;		
		default:
			for ($i=7; $i < count($rows) ; $i++) { 
				$cadena1 = substr($rows[$i], 0,15);//ubicacion
				$cadena19 = substr($rows[$i], 15,4);//subnivel
				$cadena2 = substr($rows[$i], 19,16);//tipo ubicacion
				$cadena3 = substr($rows[$i], 35,21);//familia
				$cadena4 = substr($rows[$i], 56,21);//grupo
				$cadena5 = substr($rows[$i], 77,3);//tp
				$cadena6 = substr($rows[$i], 80,3);//al
				$cadena7 = substr($rows[$i], 83,26);//codigo
				$cadena8 = substr($rows[$i], 109,31);//descripcion
				$cadena9 = substr($rows[$i], 140,10);//fact.conv
				$cadena10 = substr($rows[$i], 150,12);//saldo
				$cadena11 = substr($rows[$i], 162,4);//uni
				$cadena12 = substr($rows[$i], 166,11);//fech.ingr
				$cadena13 = substr($rows[$i], 177,11);//fech.venci
				$cadena14 = substr($rows[$i], 188,11);//lote
				$cadena15 = substr($rows[$i], 199,15);//cajas
				$cadcaj = explode(" ", trim($cadena15));
				$cadena16 = substr($rows[$i], 214,12);//unid
				$caduni = explode(" ", trim($cadena16));
				$cadena17 = substr($rows[$i], 225,3);//id
				$cadena18 = substr($rows[$i], 228,6);//paleta
				if (trim($cadena5) != "" && trim($cadena5) == "AT") {
					echo "<tr><td>".$cadena1."</td>
					<td>".$cadena19."</td>
					<td>".$cadena2."</td>
					<td>".$cadena3."</td>
					<td>".$cadena4."</td>
					<td>".$cadena5."</td>
					<td>".$cadena6."</td>
					<td>".utf8_encode($cadena7)."</td>
					<td>".utf8_encode($cadena8)."</td>
					<td>".$cadena9."</td>
					<td>".$cadena10."</td>
					<td>".$cadena11."</td>
					<td>".$cadena12."</td>
					<td>".$cadena13."</td>
					<td>".$cadena14."</td>";
					if ($cadcaj[0] != "CAJ" && $cadcaj[0] != "CJA" && $cadcaj[0] != "BOT" && $cadcaj[0] != "PAC" && $cadcaj[0] != "PAQ") {
						echo "<td>".$cadcaj[0]."</td>";
					}else{
						echo "<td>".""."</td>";
					}
					if ($caduni[0] != "UNI" && $caduni[0] != "PAQ" && $caduni[0] != "BOT" && $caduni[0] != "DIS" && $caduni[0] != "CAJ" && $caduni[0] != "TIR" && $caduni[0] != "PZS" && $caduni[0] != "PAC" && $caduni[0] != "ATD" && $caduni[0] != "BOL" && $caduni[0] != "BTO" && $caduni[0] != "EXH" && $caduni[0] != "PAK" && $caduni[0] != "SAC") {
						echo "<td>".$caduni[0]."</td>";
					}else{
						echo "<td>".""."</td>";
					}
					echo "<td>".$cadena17."</td>
					<td>".$cadena18."</td></tr>";
				}
			}
			break;
	}
echo"</tbody>

</table></div>";
		
	}
	
}



?>
