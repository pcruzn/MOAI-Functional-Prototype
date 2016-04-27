<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");

if ($_GET['action'] == "45261728") {
	
	EncounterService::deleteAllTemporaryEncounters();
	
	echo "<meta http-equiv='refresh' content='0;url=temporaryEncounters.php'>";
	
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="flat-ui.css" />
<title>B&uacute;squeda por palabra clave</title>
</head>

<body>
<h3>Encuentros temporales</h3>
<p>Este listado corresponde al total de encuentros temporalmente almacenados que provienen de sucesivas ejecuciones de los algoritmos de scraping.</p>
<p>
<?php

// Imprimir los resultados en HTML
echo "<table border='1' align='center'>\n";

echo "\t<tr>\n";

echo "\t\t
<td><p align='center'>Descripción del encuentro</p></td>
<td><p align='center'>Fecha</p></td>
<td><p align='center'>Hora</p></td>
<td><p align='center'>Fuente</p></td>
";

echo "\t</tr>\n";
$result = EncounterService::getAllEligibleTemporaryEncounters();

while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
	echo "\t<tr>\n";
	echo "\t\t<td><a href='encounterAdd.php?id=$line[0]'>$line[1]</a></td>\n";
	echo "\t\t<td>" . date_format(date_create($line[2]), 'd-m-Y') . "</td>\n";
	echo "\t\t<td>$line[3]</td>\n";
	echo "\t\t<td>$line[4]</td>\n";
	echo "\t</tr>\n";
}
echo "</table>\n";

?>
</p>
<span class="WarningElement"><strong class="WarningElement"><a href="temporaryEncounters.php?action=45261728" class="WarningElement">¿Borrar todo?</a></strong></span>
<footer>
  <p align="right"><a href="moai.php">Volver al inicio</a> <a href="index.php">Salir</a></p>
</footer>

</body>
</html>
