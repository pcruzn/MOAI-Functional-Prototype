<?php
/**
 * Created by IntelliJ IDEA.
 * User: maliq
 * Date: 19-05-16
 * Time: 7:15 PM
 */
include("header.php");
include ("moai_db_connection.php");
include ("models/encounterService.php");
?>
    <h4>Reporte de encuentros</h4>

    <form action="encounterReport.php?tipo=1" class="form-inline" method="post">
        <input name="txtSearchKeyword"
               type="text"
               id="textfield" placeholder="Texto para filtrar"
            <?php
            // if a search was made, remember the keyword in the text field
            if ($_POST['txtSearchKeyword'] != '') {
                $keywordFromForm = $_POST['txtSearchKeyword'];
                echo "value=$keywordFromForm";
            }
            ?>
        />
        <select id="selectEncounterFilter" name="selectEncounterFilter" class="select-inline">
            <option value="NotFiltering" selected="selected">Sin filtrado de tipo</option>
            <?php

            include ("moai_db_connection.php");


            // old query (complete)
            // $queryEncuentros = "SELECT id, tipo_encuentro FROM tipo_encuentro";
            $queryEncuentros = "SELECT id, tipo_encuentro FROM tipo_encuentro WHERE tipo_encuentro != 'Lucha Interburguesa'
								AND tipo_encuentro != 'Acciones Armadas'";
            $result = mysql_query($queryEncuentros) or die('Consulta fallida: ' . mysql_error());

            // in case a search was made and a filter was selected, remember the filter criteria
            while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
                if ($line[0] == $_POST['selectEncounterFilter']) {
                    $encounterType = $_POST['selectEncounterFilter'];
                    echo "<option value='$line[0]' selected='selected'>$line[1]</option>";
                }else
                    echo "<option value='$line[0]'>$line[1]</option>";
            }

            ?>
        </select>
        <select id="selectEncounterSourceFilter" name="selectEncounterSourceFilter" class="select-inline">
            <option value="NoSourceFilter" selected="selected">Sin filtrado de fuente</option>
            <?php

            include ("moai_db_connection.php");


            $querySources = "SELECT id, fuente FROM fuente";
            $result = mysql_query($querySources) or die('Consulta fallida: ' . mysql_error());

            // in case a search was made and a filter was selected, remember the filter criteria
            while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
                if ($line[0] == $_POST['selectEncounterSourceFilter']) {
                    $encounterSource = $_POST['selectEncounterSourceFilter'];
                    echo "<option value='$line[0]' selected='selected'>$line[1]</option>";
                }else
                    echo "<option value='$line[0]'>$line[1]</option>";
            }

            $resultsCount = EncounterService::getEncounterCount($keywordFromForm, $encounterType, $encounterSource);

            ?>
        </select>
        <input type="submit" class="btn btn-primary " name="btnSearch" id="btnSearch" value="Filtrar" />
    </form>
    <script type="application/javascript">
        $( document ).ready(function() {

            $("select[name='selectEncounterFilter']").selectpicker({style: 'btn-primary select-inline'});
            $("select[name='selectEncounterSourceFilter']").selectpicker({style: 'btn-primary select-inline'});

        });
    </script>


<?php

if ($_GET['tipo'] == 1) {

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
include ("footer.html");