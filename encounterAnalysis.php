<?php
/**
 * Created by IntelliJ IDEA.
 * User: maliq
 * Date: 30-04-16
 * Time: 8:34 PM
 */
include("header.php")
?>
    <h4>Análisis de encuentros</h4>
    <p>Reportes gráficos:</p>
    <p><a href="encounterHourHistogramChart.php">Histograma - Hora de Encuentros</a></p>
    <p><a href="encounterDateTimeSeriesChart.php">Serie de Tiempo -  Encuentros por Fecha</a></p>
    <p><a href="encounterTypeRadarChart.php">Radar - Tipo de Encuentros</a> (con agrupaciones)</p>
    <p><a href="encounterHourRadarChart.php">Radar - Hora de Encuentros</a></p>
    <p><a href="encounterLocalizationRadarChart.php">Radar - Localización de Encuentros</a></p>
    <p><a href="encounterMicrolocalizationHistogramChart.php">Histograma - Microlocalización de encuentros</a></p>

<?php
include ("footer.html");