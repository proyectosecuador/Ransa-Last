<?php
//header('Content-Type: application/vnd.ms-excel;charset=utf-8');

header('Content-Type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename= Listado.xls");

//EXCEL DE AFILIADOS X SEMANA, HACIENDA, SECTOR, EMPLEADO
date_default_timezone_set('America/Lima');

function conexionSQL()
{

$serverName="srv-ranecucoransa.database.windows.net";
$databaseName= "ranecuco_ransa";
$username="redrovan";
$password= "Didacta_123";

// Conexión a la base de datos
$conn = sqlsrv_connect($serverName, array("Database" => $databaseName, "UID" => $username, "PWD" => $password,  "CharacterSet"=>"UTF-8"));

if ($conn === false) {
   // echo "No se pudo conectar a la base de datos: " . sqlsrv_errors();
    die();
} else {
   // echo "Conectado correctamente a la base de datos.";
}
   return $conn;
 }

?>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<table  border="1">
  <tr>
    <th>#</th>
  <th>Nombres</th>
  <th>Fecha programada</th>
  <th>Cliente</th>
  <th>Estiba</th>
  <th>Actividad</th>
  <th>Comentarios</th>
  </tr>

<?php
 //SELECT CON NUEVOS CAMPOS QUE SE DESEA
//$sql_1 = "SET sql_mode='NO_ZERO_IN_DATE,NO_ZERO_DATE,ERROR_FOR_DIVISION_BY_ZERO,NO_ENGINE_SUBSTITUTION'";
//$result_1 = mysqli_query($db_link, $sql_1);

$conn      = conexionSQL();
    $sql         = "
SELECT  top 50 u.primernombre, u.primerapellido ,
     FORMAT(fecha_programada, 'yyyy-MM-dd H:m:s') AS fecha_programada
,   c.razonsocial , pe.nombre_proveedor ,
ae.descripcion , comentarios 
FROM ranecuco_ransa.dbo.mov_recep_desp 
inner join ranecuco_ransa.dbo.usuariosransa AS u on
u.id = mov_recep_desp.idusuario
inner join  ranecuco_ransa.dbo.clientes AS c on
c.idcliente = mov_recep_desp.idcliente
inner join   ranecuco_ransa.dbo.actividad_estiba AS ae on
ae.idactividad_estiba = idactividad
inner join  ranecuco_ransa.dbo.proveedor_estibas AS pe on
pe.idproveedor_estiba = mov_recep_desp.idproveedor_estiba 
order by fecha_programada  desc 
    ";
    //$resultado   = $mysqli->query($sql);

    $resultado   = sqlsrv_query($conn, $sql);// $mysqli->query($sql);
        
$contador=0;
    while ($fila = sqlsrv_fetch_array($resultado, SQLSRV_FETCH_ASSOC)) {
      //  $data[]   = $fila;
$contador=$contador+1;
echo '<tr>
      <td>'.$contador.'</td>
       <td>'.$fila['primernombre'].' '.$fila['primerapellido'].'</td>
       <td>'.$fila['fecha_programada'].'</td>
        <td>'.$fila['razonsocial'].'</td>
        <td>'.$fila['nombre_proveedor'].'</td>
        <td>'.$fila['descripcion'].'</td>
        <td>'.$fila['comentarios'].'</td>
        </tr>';
            }
    
echo '</table>';


 ?>


    