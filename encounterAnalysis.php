<?php
/**
 * Created by IntelliJ IDEA.
 * User: maliq
 * Date: 30-04-16
 * Time: 8:34 PM
 */
include("header.php");
include ("moai_db_connection.php");
include ("models/encounterService.php");
?>
    <h4>Reporte de encuentros</h4>

    <form action="encounterAnalysis.php" class="form-inline" method="post">
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

    <div class="container">
        <p><?php echo $resultsCount; ?> Resultado(s)</p>
        <?php if($resultsCount>0){?>
        <div class="row">
            <div class="span3">
                <div class="row">
                    <div class="span3">
                        <img src="images/bar.png" data-placement="bottom" title="Histograma - Hora de Encuentros" data-toggle="tooltip" onclick="createChar('barHours')">
                        <img src="images/time_serie.png" data-placement="bottom" title="Serie de Tiempo -  Encuentros por Fecha" data-toggle="tooltip" onclick="createChar('lineDates')">
                    </div>
                </div>
                <div class="row">
                    <div class="span3">
                        <?php if(!$encounterType){?>
                            <img src="images/radar.png" data-placement="bottom" title="Radar - Tipo de Encuentros" data-toggle="tooltip" onclick="createChar('radarTypes')">
                        <?php }?>
                        <img src="images/radar.png" data-placement="bottom" title="Radar - Hora de Encuentros" data-toggle="tooltip" onclick="createChar('radarHours')">
                    </div>
                </div>
                <div class="row">
                    <div class="span3">
                        <img src="images/radar.png" data-placement="bottom" title="Radar - Localización de Encuentros" data-toggle="tooltip" onclick="createChar('radarLocalizations')">
                        <img src="images/bar.png" data-placement="bottom" title="Histograma - Microlocalización de encuentros" data-toggle="tooltip" onclick="createChar('barMicroLocalizations')">
                    </div>
                </div>
            </div>
            <div class="span7">
                <div id="idCanvas">
                    <canvas id="mainCanvas">
                    </canvas>
                </div>
            </div>
        </div>

        <?php }?>
    </div>

<?php

$encounterTypes = array();
$encounterTypesCount = array();

// after getting the associative array 'encounterType' -> 'encounterTypeCount'
// (returned by getEncounterTypesCount()) we split the array
// in separate key and value arrays.
// this is done to ease the use of json_encode to put data for plots
foreach (EncounterService::getEncounterTypesCount($keywordFromForm, $encounterType, $encounterSource) as $arrayKey => $arrayValue) {
    $encounterTypes[] = $arrayKey;
    $encounterTypesCount[] = $arrayValue;
}

$encounterHours = array();
$encounterHoursCount = array();

// after getting the associative array 'encounterType' -> 'encounterTypeCount'
// (returned by getEncounterTypesCount()) we split the array
// in separate key and value arrays.
// this is done to ease the use of json_encode to put data for plots
foreach (EncounterService::getEncounterHoursCount($keywordFromForm, $encounterType, $encounterSource) as $arrayKey => $arrayValue) {
    $encounterHours[] = $arrayKey;
    $encounterHoursCount[] = $arrayValue;
}

$encounterDates = array();
$encounterDatesCount = array();

// after getting the associative array 'encounterType' -> 'encounterTypeCount'
// (returned by getEncounterTypesCount()) we split the array
// in separate key and value arrays.
// this is done to ease the use of json_encode to put data for plots
foreach (EncounterService::getEncounterDatesCount($keywordFromForm, $encounterType, $encounterSource) as $arrayKey => $arrayValue) {
    $encounterDates[] = $arrayKey;
    $encounterDatesCount[] = $arrayValue;
}

$encounterLocalization = array();
$encounterLocalizationCount = array();

// after getting the associative array 'encounterType' -> 'encounterTypeCount'
// (returned by getEncounterTypesCount()) we split the array
// in separate key and value arrays.
// this is done to ease the use of json_encode to put data for plots
foreach (EncounterService::getEncounterLocalizationCount($keywordFromForm, $encounterType, $encounterSource) as $arrayKey => $arrayValue) {
    $encounterLocalization[] = $arrayKey;
    $encounterLocalizationCount[] = $arrayValue;
}

$encounterMicroLocalization = array();
$encounterMicroLocalizationCount = array();

// after getting the associative array 'encounterType' -> 'encounterTypeCount'
// (returned by getEncounterTypesCount()) we split the array
// in separate key and value arrays.
// this is done to ease the use of json_encode to put data for plots
foreach (EncounterService::getEncounterMicroLocalizationCount($keywordFromForm, $encounterType, $encounterSource) as $arrayKey => $arrayValue) {
    $encounterMicroLocalization[] = $arrayKey;
    $encounterMicroLocalizationCount[] = $arrayValue;
}
?>

    <script>
        var encounterTypes = <?php echo json_encode($encounterTypes); ?>;
        var encounterTypesCount = <?php echo json_encode($encounterTypesCount); ?>;
        var encounterHours = <?php echo json_encode($encounterHours); ?>;
        var encounterHoursCount = <?php echo json_encode($encounterHoursCount); ?>;
        var encounterDates = <?php echo json_encode($encounterDates); ?>;
        var encounterDatesCount = <?php echo json_encode($encounterDatesCount); ?>;
        var encounterLocalization = <?php echo json_encode($encounterLocalization); ?>;
        var encounterLocalizationCount = <?php echo json_encode($encounterLocalizationCount); ?>;
        var encounterMicroLocalization = <?php echo json_encode($encounterMicroLocalization); ?>;
        var encounterMicroLocalizationCount = <?php echo json_encode($encounterMicroLocalizationCount); ?>;

        $( document ).ready(function() {
            createChar();
        });

        var resetCanvas = function () {
            $('#mainCanvas').remove(); // this is my <canvas> element
            $('#idCanvas').append('<canvas id="mainCanvas" height="300"><canvas>');
        };

        function createChar(chartNumber) {
            resetCanvas();
            var encounterTypeRadarChartData = {
                // labels data points are converted using json_encode to meet
                // Chart.js input requirements (see below)
                labels: encounterTypes,
                datasets: [
                    {
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: encounterTypesCount
                    }
                ]
            };
            var hoursBarChartData = {
                scaleFontSize: 0,
                labels : encounterHours,
                datasets : [
                    {
                        fillColor : "rgba(220,220,220,0.9)",
                        strokeColor : "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
                        data : encounterHoursCount
                    }
                ]
            }

            var datesLineChartData = {
                labels : encounterDates,
                datasets : [
                    {
                        fillColor : "rgba(151,187,205,0.2)",
                        strokeColor : "rgba(151,187,205,1)",
                        pointColor : "rgba(151,187,205,1)",
                        pointStrokeColor : "#fff",
                        pointHighlightFill : "#fff",
                        pointHighlightStroke : "rgba(151,187,205,1)",
                        data : encounterDatesCount
                    }
                ]
            };

            var localizationRadarChartData = {
                // labels data points are converted using json_encode to meet
                // Chart.js input requirements (see below)
                labels: encounterLocalization,
                datasets: [
                    {
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: encounterLocalizationCount
                    }
                ]
            };


            var microLocalizationbarChartData = {
                labels : encounterMicroLocalization,
                datasets : [
                    {
                        fillColor : "rgba(220,220,220,0.9)",
                        strokeColor : "rgba(220,220,220,0.8)",
                        highlightFill: "rgba(220,220,220,0.75)",
                        highlightStroke: "rgba(220,220,220,1)",
                        data : encounterMicroLocalizationCount
                    }
                ]
            }

            var hoursRadarChartData = {
                // labels data points are converted using json_encode to meet
                // Chart.js input requirements (see below)
                labels: encounterHours,
                datasets: [
                    {
                        fillColor: "rgba(151,187,205,0.2)",
                        strokeColor: "rgba(151,187,205,1)",
                        pointColor: "rgba(151,187,205,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(151,187,205,1)",
                        data: encounterHoursCount
                    }
                ]
            };
            switch (chartNumber) {
                case 'barHours':
                    window.
                    myBarHours = new Chart(document.getElementById("mainCanvas").getContext("2d")).Bar(hoursBarChartData, {
                        responsive: true
                    });
                    break;
                case 'lineDates':
                    window.myLine = new Chart(document.getElementById("mainCanvas").getContext("2d")).Line(datesLineChartData, {
                        responsive: true
                    });
                    break;
                case 'radarLocalizations':
                    window.myRadarLocalizations = new Chart(document.getElementById("mainCanvas").getContext("2d")).Radar(localizationRadarChartData, {
                        responsive: true
                    });
                    break;
                case 'barMicroLocalizations':
                    window.myBarMicroLocalizations = new Chart(document.getElementById("mainCanvas").getContext("2d")).Bar(microLocalizationbarChartData, {
                        responsive: true
                    });
                    break;
                case 'radarTypes':
                    window.myRadarTypes = new Chart(document.getElementById("mainCanvas").getContext("2d")).Radar(encounterTypeRadarChartData, {
                        responsive: true
                    });
                    break;
                case 'radarHours':
                    window.myRadarHours = new Chart(document.getElementById("mainCanvas").getContext("2d")).Radar(hoursRadarChartData, {
                        responsive: true
                    });
                    break;
            }
        }

    </script>
<?php
include ("footer.html");