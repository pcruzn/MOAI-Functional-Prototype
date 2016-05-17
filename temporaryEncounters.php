<?php
include ("moai_db_connection.php");
include ("models/encounterService.php");
include ("header.php");

if ($_GET['action'] == "45261728") {

    EncounterService::deleteAllTemporaryEncounters();

    echo "<meta http-equiv='refresh' content='0;url=temporaryEncounters.php'>";

}

?>

    <h3>Encuentros seleccionados para modelar</h3>
    <p>Este listado corresponde al total de encuentros temporalmente selecionados que provienen de sucesivas ejecuciones de los algoritmos de scraping.</p>
    <div id="info-alert" class="alert alert-info">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Modelar</h4>
        Presione el encuentro temporar que desea modelar
    </div>
    <script type="application/javascript">
        $( document ).ready(function() {
            $("#info-alert").fadeTo(3000, 500).slideUp(500, function () {
                $("#info-alert").alert('close');
            });
        });
    </script>
<?php

// Imprimir los resultados en HTML
echo "<table border='1' align='center' class='table table-bordered'>\n";

echo "\t<thead><tr>\n";

echo "\t\t
<td><p align='center'>Descripción del encuentro</p></td>
<td><p align='center'>Fecha</p></td>
<td><p align='center'>Hora</p></td>
<td><p align='center'>Fuente</p></td>
";

echo "\t</tr></thead><tbody>\n";
$result = EncounterService::getAllEligibleTemporaryEncounters();

while ($line = mysql_fetch_array($result, MYSQL_NUM)) {
	echo "\t<tr>\n";
	echo "\t\t<td><a href='encounterAdd.php?id=$line[0]'>$line[1]</a></td>\n";
	echo "\t\t<td>" . date_format(date_create($line[2]), 'd-m-Y') . "</td>\n";
	echo "\t\t<td>$line[3]</td>\n";
	echo "\t\t<td>$line[4]</td>\n";
	echo "\t</tr>\n";
}
echo "</tbody></table>\n";

?>
</p>
<span class="WarningElement"><strong class="WarningElement"><a href="temporaryEncounters.php?action=45261728" class="WarningElement">¿Borrar todo?</a></strong></span>
<?php
include ("footer.html");
