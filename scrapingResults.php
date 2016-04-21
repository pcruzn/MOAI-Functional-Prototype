<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="flat-ui.css" />
<title>B&uacute;squeda por palabra clave</title>
</head>

<body>
<h3>Resultados...</h3>
<p>
<?php

// Imprimir los resultados en HTML
echo "<table border='1' align='center'>\n";

echo "\t<tr>\n";

echo "\t\t<td><p align='center'>Descripción del encuentro</p></td>
<td><p align='center'>Fecha</p></td><td><p align='center'>Fuente</p></td>";

echo "\t</tr>\n";
$source = $_GET['source'];
$result = EncounterService::getTemporaryEncounters($source);

while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
	echo "\t<tr>\n";
	echo "\t\t<td>$line[0]</td>\n";
	echo "\t\t<td>" . date_format(date_create($line[1]), 'd-m-Y') . "</td>\n";
	echo "\t\t<td>$line[2]</td>\n";
	echo "\t</tr>\n";
}
echo "</table>\n";

?>
<p>
<footer>
  <p align="right"><a href="moai.php">Volver al inicio</a> <a href="index.php">Salir</a></p>
</footer>

</body>
</html>
