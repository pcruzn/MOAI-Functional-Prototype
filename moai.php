<?php
include("header.php")
?>

    <h5>Bienvenido al software prototipo de MOAI</h5>
    <br>
    <p>Podra ejecutar MOAI en los siguientes 4 pasos:</p>


    <div class="stepwizard">
        <div class="stepwizard-row setup-panel">
            <div class="stepwizard-step">
                <a href="scrapeSources.php" type="button" class="fui-gear btn btn-primary btn-circle"></a>
                <p>Scraping</p>
            </div>
            <div class="stepwizard-step">
                <a href="selectEncounter.php" type="button" class="fui-list-bulleted btn btn-primary btn-circle"></a>
                <p>Selección</p>
            </div>
            <div class="stepwizard-step">
                <a href="temporaryEncounters.php" type="button" class="fui-link btn btn-primary btn-circle"></a>
                <p>Modelamiento</p>
            </div>
            <div class="stepwizard-step">
                <a href="#" type="button" class="fui-eye btn btn-primary btn-circle" data-toggle="dropdown"></a>
<!--                <a href="#" class="fui-eye dropdown-toggle" data-toggle="dropdown"></a>-->
                <ul class="dropdown-menu">
                    <li><a href="createGroup.php">Agrupaciones</a></li>
                    <li><a href="encounterReport.php">Reporte</a></li>
                    <li><a href="encounterAnalysis.php">Reporte Gráfico</a></li>
                </ul>
                <p>Reporte</p>
            </div>
        </div>
    </div>



<?php
include ("footer.html");
