<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="flat-ui.css" />
<title>MOAI</title>
</head>
<?php

// Realizar una consulta MySQL
$query = 'SELECT encuentro.descripcion, hora.hora FROM encuentro, hora WHERE encuentro.hora = hora.id GROUP BY descripcion ORDER BY hora.id';
$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());


// Imprimir los resultados en HTML
echo "<table border='1'>\n";

echo "\t<tr>\n";

	echo "\t\t<td><p align='center'>Descripción del encuentro</p></td>
	<td><p align='center'>Hora</p></td>";

echo "\t</tr>\n";

while ($line = mysql_fetch_array($result, MYSQL_ASSOC)) {
	echo "\t<tr>\n";
	foreach ($line as $col_value) {
		echo "\t\t<td>$col_value</td>\n";
	}
	echo "\t</tr>\n";
}
echo "</table>\n";

// Liberar resultados
mysql_free_result($result);

// Cerrar la conexión
mysql_close($link);
	
?>

<footer>
  <p align="right">Salir</p>
</footer>

<body>
</body>
</html>
