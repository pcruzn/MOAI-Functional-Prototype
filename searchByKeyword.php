<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="flat-ui.css" />
<title>B&uacute;squeda por palabra clave</title>
</head>

<body>
<h3>B&uacute;squeda por palabra clave </h3>
<p>
<form action="searchByKeyword.php?tipo=1" method="post">
  <table border="0">
    <tr>
      <td>Palabra clave a buscar:
        <h1>
        	<input name="txtSearchKeyword" 
            type="text" 
            id="textfield"
			<?php
			// if a search was made, remember the keyword in the text field
			if ($_GET['tipo'] == 1 && $_POST['txtSearchKeyword'] != '') {
				$keywordFromForm = $_POST['txtSearchKeyword'];
				echo "value=$keywordFromForm";			
			}
			?> 
            />
        </h1>
      </td>
    </tr>
    <tr>
      <td>FILTRO AVANZADO
        <p>Tipo de encuentro: <br />
          <select name="selectEncounterFilter">
            <option value="NotFiltering" selected="selected">Sin filtrado</option>
            <?php
		
			include ("moai_db_connection.php");

			
			// old query (complete)
			// $queryEncuentros = "SELECT id, tipo_encuentro FROM tipo_encuentro";
			$queryEncuentros = "SELECT id, tipo_encuentro FROM tipo_encuentro WHERE tipo_encuentro != 'Lucha Interburguesa'
								AND tipo_encuentro != 'Acciones Armadas'";
			$result = mysql_query($queryEncuentros) or die('Consulta fallida: ' . mysql_error());
			
			// in case a search was made and a filter was selected, remember the filter criteria
			while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
				if ($line[0] == $_POST['selectEncounterFilter'])
					echo "<option value='$line[0]' selected='selected'>$line[1]</option>";
				else
					echo "<option value='$line[0]'>$line[1]</option>";
			}
		
			?>
          </select>
        </p>
        <p>Fuente:<br />
          <select name="selectEncounterSourceFilter">
	      	<option value="NoSourceFilter" selected="selected">Sin filtrado</option>
            <?php
		
			include ("moai_db_connection.php");

			
			$querySources = "SELECT id, fuente FROM fuente";
			$result = mysql_query($querySources) or die('Consulta fallida: ' . mysql_error());
			
			// in case a search was made and a filter was selected, remember the filter criteria
			while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
				if ($line[0] == $_POST['selectEncounterSourceFilter'])
					echo "<option value='$line[0]' selected='selected'>$line[1]</option>";
				else
					echo "<option value='$line[0]'>$line[1]</option>";
			}
			
			?>
          </select>
        </p>
      </td>
    </tr>
    <tr>
      <td><input type="submit" name="btnSearch" id="btnSearch" value="Buscar" /></td>
    </tr>
  </table>
</form>
</p>

<?php

if ($_GET['tipo'] == 1) {
	
	include ("moai_db_connection.php");
	
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
	
	// case in which type of encounter is used to filter
	if ($_POST['selectEncounterFilter'] != "NotFiltering") {
		$filter = $_POST['selectEncounterFilter'];
		$query = 
		"SELECT 
		encuentro.descripcion, 
		encuentro.fecha, 
		hora.hora 
		FROM encuentro, hora 
		WHERE encuentro.hora = hora.id 
		AND descripcion LIKE '%$keywordFromForm%' 
		AND tipo_encuentro = $filter 
		ORDER BY fecha";
	}
	
	// case in which source is used to filter
	if ($_POST['selectEncounterSourceFilter'] != "NoSourceFilter") {
		$filter = $_POST['selectEncounterSourceFilter'];
		$query = 
		"SELECT 
		encuentro.descripcion, 
		encuentro.fecha, 
		hora.hora 
		FROM encuentro, hora 
		WHERE encuentro.hora = hora.id 
		AND encuentro.descripcion LIKE '%$keywordFromForm%' 
		AND encuentro.fuente = $filter 
		ORDER BY fecha";
	}
	
	// case in which type and source are used as filters
	if ($_POST['selectEncounterFilter'] != "NotFiltering" && $_POST['selectEncounterSourceFilter'] != "NoSourceFilter") {
		$typeOfEncounterFilter = $_POST['selectEncounterFilter'];
		$sourceOfEncounterFilter = $_POST['selectEncounterSourceFilter'];
		$query = 
		"SELECT 
		encuentro.descripcion, 
		encuentro.fecha, 
		hora.hora 
		FROM encuentro, hora 
		WHERE encuentro.hora = hora.id 
		AND encuentro.descripcion LIKE '%$keywordFromForm%' 
		AND tipo_encuentro = $typeOfEncounterFilter 
		AND encuentro.fuente = $sourceOfEncounterFilter 
		ORDER BY fecha";
	}
	
	$result = mysql_query($query) or die('Consulta fallida: ' . mysql_error());
	
	if (mysql_num_rows ($result) < 1) {
		echo "<h6 align='center'>No hay resultados. Intente con otra palabra o elimine uno o más filtros.</h6>";
	} else if (strlen($keywordFromForm) < 3) {
		echo "<h6 align='center'>Ingrese una palabra de 3 o más caracteres.</h6>";
	} else {
		// Imprimir los resultados en HTML
		echo "<table border='1' align='center'>\n";
		
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

<footer>
  <p align="right"><a href="searchByKeyword.php">Reiniciar b&uacute;squeda</a> <a href="moai.php">Volver al inicio</a> <a href="index.php">Salir</a></p>
</footer>

</body>
</html>
