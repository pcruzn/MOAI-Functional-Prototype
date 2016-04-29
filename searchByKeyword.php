<?php
include('header.php');
?>
<h3>B&uacute;squeda por palabra clave </h3>

<?php

if ($_GET['tipo'] == 1) {
	
	include ("moai_db_connection.php");
	// NO MODEL SEPARATION HERE
	// case in which a plain keyword is used to search
	$keywordFromForm = $_POST['txtSearchKeyword'];
	$query = 
	"SELECT	
	encuentro.descripcion, 
	encuentro.fecha, 
	hora.hora 
	FROM encuentro, hora 
	WHERE encuentro.hora = hora.id 
	AND descripcion LIKE '%$keywordFromForm%' 
	ORDER BY fecha";

	
	$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
	
	if (mysql_num_rows ($result) < 1) {
		echo "<h6 align='center'>No hay resultados. Intente con otra palabra o elimine uno o más filtros.</h6>";
	} else if (strlen($keywordFromForm) < 3) {
		echo "<h6 align='center'>Ingrese una palabra de 3 o más caracteres.</h6>";
	} else {
		// Imprimir los resultados en HTML
		echo "<table class=\"table table-bordered\">\n";
		
		echo "\t<tr>\n";
		
			echo "\t\t<td><p align='center'>Descripción del encuentro</p></td>
			<td><p align='center'>Fecha</p></td><td><p align='center'>Hora</p></td>";
		
		echo "\t</tr>\n";
		
		while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
			echo "\t<tr>\n";
			echo "\t\t<td>$line[0] (ver detalles)</td>\n";
			echo "\t\t<td>" . date_format(date_create($line[1]), 'd-m-Y') . "</td>\n";
			echo "\t\t<td>$line[2]</td>\n";
			echo "\t</tr>\n";
		}
		echo "</table>\n";
	}
	
	mysql_free_result($result);
	
	
	if ($dbLink != NULL) 
		mysql_close($dbLink);
}

?>

<?php
include('footer.html');
?>