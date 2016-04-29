<?php
  include("header.php")
?>
<h4>Bienvenido al software prototipo de MOAI</h4>
<p>Seleccione un tipo de reporte:</p>

<p><a href="searchByKeyword.php">Búsqueda por palabra clave y filtrado</a></p>
<p>Funcionalidad 'Scraping':</p>
<p><a href="scrapeSources.php">Iniciar Scraping</a></p>
<p><a href="selectEncounter.php">Selección de encuentros temporales</a></p>
<p><a href="temporaryEncounters.php">Revisar encuentros temporales</a></p>
<p><a href="scrapingSourceAdd.php">Agregar Fuente</a></p>
<p>Reportes gráficos:</p>
<p><a href="encounterHourHistogramChart.php">Histograma - Hora de Encuentros</a></p>
<p><a href="encounterDateTimeSeriesChart.php">Serie de Tiempo -  Encuentros por Fecha</a></p>
<p><a href="encounterTypeRadarChart.php">Radar - Tipo de Encuentros</a></p>
<p><a href="encounterHourRadarChart.php">Radar - Hora de Encuentros</a></p>
<p><a href="encounterLocalizationRadarChart.php">Radar - Localización de Encuentros</a></p>
<p><a href="encounterMicrolocalizationHistogramChart.php">Histograma - Microlocalización de encuentros</a></p>

<?php
include ("footer.html");
